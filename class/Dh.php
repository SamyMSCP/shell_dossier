<?php
require_once("core/Database.php");
require_once("core/Table.php");
require_once("core/Cache.php");
require_once("Transaction.php");
require_once("Notifications.php");
require_once("Beneficiaire.php");
require_once("LstTransaction.php");
//require_once("CentreInteret.php");
require_once("Pp.php");

function prepare($d) {
	$unwanted_array = array(	'Š'=>'S', 'š'=>'s', 'Ž'=>'Z', 'ž'=>'z', 'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A', 'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E',
								'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 'Ï'=>'I', 'Ñ'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O', 'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U',
								'Ú'=>'U', 'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss', 'à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a', 'å'=>'a', 'æ'=>'a', 'ç'=>'c',
								'è'=>'e', 'é'=>'e', 'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i', 'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o', 'ô'=>'o', 'õ'=>'o',
								'ö'=>'o', 'ø'=>'o', 'ù'=>'u', 'ú'=>'u', 'û'=>'u', 'ý'=>'y', 'þ'=>'b', 'ÿ'=>'y' );
	return (strtolower(trim(strtr($d, $unwanted_array))));
};

class Dh extends Table
{
	use Cache;
	use DocumentTrait;

	protected static		$_name = "DONNEUR D'ORDRE";
	protected static		$_primary_key = "id_dh";
	private static			$_current;
	private static			$_withparam;
	private static			$_actualValue;
	private static			$_collaborateurs = null;
	private static			$_conseillers = null;
	public static			$typeDeCompte = array(
		"analyste",
		"backoffice",
		"communication",
		"conseiller",
		"prospecteur",
		"developpeur",
		"yoda"
	);

	private					$_loggers = null;
	private					$_dateCreation = null;
	private					$_beneficiaires = null;
	private					$_projets = null;
	private					$_myTransaction;
	private					$_myClients;
	private 				$_helping;
	private					$_myLogin;
	private					$_myDistinctTransaction;
	private					$_conseiller = NULL;
	private					$_myDistinctTransactionTypePro;
	private static			$_client = NULL;
	private					$_myCrm = NULL;
	private					$_myCrmForStore = NULL;
	private					$_lstSCPI = null;
	private					$_lstTransaction = null;
	private					$_myPp = null;
	private					$_myPm = null;
	public static			$_dh = "";
	public					$_lastCrm = null;
	public					$_nextCrm = null;

	public function __construct() {
	}

	public static function insertNew(
		$mail,
		$pass
	)
	{
		$req = "INSERT INTO `DONNEUR D'ORDRE`(
			day,
			login,
			password,
			page
		) VALUES (
			?, ?, ?, ?
		)";
		$data = array(
			date("Y-m-d"),
			ft_crypt_information($mail),
			ft_crypt_pass($pass),
			"front"
		);
		return Database::prepareInsert(static::$_db, $req, $data);
	}
	public function setConseillerRandom() {
		$this->updateOneColumn("conseiller", random_conseiller());
	}

	public function getWhereFrom(){
		$req = "SELECT `fr`.`name` FROM `DONNEUR D'ORDRE` as `dh`, `create_from` as `fr` WHERE `id_dh` =:id AND `dh`.`create_from` = `fr`.`id`";
		return (Database::getNoClass(static::$_db, $req, ['id' => $this->id_dh])[0][0]);
	}

	public static function getWhereFromStats() {
		$req = "SELECT `fr`.`name`,  COUNT(*) as `total` FROM `DONNEUR D'ORDRE` as `dh`, `create_from` as `fr` WHERE `dh`.`create_from` = `fr`.`id` GROUP BY `fr`.`name`";
		return (Database::getNoClass(static::$_db, $req, []));

	}

    public static function getWhereFromStatsDay() {
        $req = "SELECT `fr`.`name`,`dh`.`day`, COUNT(*) as `total` FROM `DONNEUR D'ORDRE` as `dh`, `create_from` as `fr` WHERE `dh`.`day` > DATE_SUB(Now(), INTERVAL 7 DAY) AND `dh`.`create_from` = `fr`.`id` GROUP BY `fr`.`name`, `dh`.`day` ";
        return (Database::getNoClass(static::$_db, $req, []));

    }
	public function setConnected() {
		$token = bin2hex(random_bytes(21));
		$ip = ft_crypt_information($_SERVER["REMOTE_ADDR"]);
		$this->updateOneColumn("TOKEN", ft_crypt_information($token));
		$this->updateOneColumn("IP", $ip);
		$this->updateOneColumn("fraude", 0);
		set_cookie(array('token' => $token, 'login' => $this->getLogin()));// set__cookie crypte de base
		return ($token);
	}
	public function setConnectedNoIp() {
		$token = bin2hex(random_bytes(21));
		$this->updateOneColumn("TOKEN", ft_crypt_information($token));
		$this->updateOneColumn("fraude", 0);
		set_cookie(array('token' => $token, 'login' => $this->getLogin()));// set__cookie crypte de base
		return ($token);
	}
	public static function create() {
		$rt = new Dh();
		$rt->_is_new = 1;
		return ($rt);
	}
	public function getTransactionAbsorbed() {
		return (Transaction::getTransactionAbsorbedFromDh($this->id_dh));
	}
	public function getTransactionAbsorbedNotComplete() {
		return (Transaction::getTransactionAbsorbedNotCompleteFromDh($this->id_dh));
	}
	public function getTransactionAbsorbedComplete() {
		return (Transaction::getTransactionAbsorbedCompleteFromDh($this->id_dh));
	}
	public function getDateCreation() {
		if ($this->_dateCreation == null) {
			$this->_dateCreation = DateTime::createFromFormat("Y-m-d", $this->day)->format("d/m/Y");
		}
		return ($this->_dateCreation);
	}
	public function getBeneficiaires() {
		if ($this->_beneficiaires == null) {
			$this->_beneficiaires = Beneficiaire::getFromDh($this->id_dh);
		}
		return ($this->_beneficiaires);
	}
	public function getBeneficiairesForStore() {
		return (Beneficiaire::getFromDhForStore($this->id_dh));
	}
	public static function getProspects() {
		$req = "SELECT * FROM `DONNEUR D'ORDRE` WHERE type IS NULL";
		return Database::prepare(static::$_db, $req, [], get_called_class());
	}
	public function getNbrClientsHave() {
		$req = "SELECT count(*) FROM `DONNEUR D'ORDRE` WHERE type = 'client' AND conseiller = ?;";
		return Database::getNoClass(static::$_db, $req, [$this->id_dh])[0][0];
	}
	public function getNbrProspectsHave() {
		$req = "SELECT count(*) FROM `DONNEUR D'ORDRE` WHERE type IS NULL AND conseiller = ?;";
		return Database::getNoClass(static::$_db, $req, [$this->id_dh])[0][0];
	}
	public function getProjets() {
		if ($this->_projets == null) {
			$this->_projets = Projet::getFromDh($this->id_dh);
		}
		return ($this->_projets);
	}
	public function getProjetsForFrontStore() {
		return (Projet::getFromDhForFrontStore($this->id_dh));
	}
	public function getProjetsForStore() {
		return (Projet::getFromDhForStore($this->id_dh));
	}
	public function setCrm() {
		CRM::setCrmForDh(intval($this->id_dh));
		$req = "UPDATE `DONNEUR D'ORDRE` SET help = 0 WHERE id_dh = ?";
		Database::prepareNoClass(static::$_db, $req, array($_GET['client']));
	}
	public function getNotif() {
		if ($this->type == "yoda" || empty($this->type))
			return (parent::getNotifCrmAll());
		else
			return (parent::getNotifCrmValue($this->id_dh));
	}
	public function getCrmNotOkay() {
		if (empty($this->_myCrm))
		{
			$this->_myCrm = Crm2::getNotOkayFromDh(intval($this->id_dh));
			foreach ($this->_myCrm as $key => $elm)
			{
				$executant = Dh::getById($elm->id_executant);
				$this->_myCrm[$key]->executantShortName = !empty($executant) ? $executant->getShortName() : "system";
			}
		}
		return ($this->_myCrm);
	}
	public function getCrm() {
		if (empty($this->_myCrm))
		{
			$this->_myCrm = Crm2::getFromDh(intval($this->id_dh));
			foreach ($this->_myCrm as $key => $elm)
			{
				$executant = Dh::getById($elm->id_executant);
				$this->_myCrm[$key]->executantShortName = !empty($executant) ? $executant->getShortName() : "system";
			}
		}
		return ($this->_myCrm);
	}
	public function getCrmForConseillerForStore() {
		if (empty($this->_myCrmForStore))
		{
			// TODO : ne récupérer que les Taches qui sont d'aujourd'hui ou avant !!!
			$this->_myCrmForStore = Crm2::getForConseillerForStore($this->id_dh);
			foreach ($this->_myCrmForStore as $key => $elm)
			{
				$executant = Dh::getById($elm->id_executant);
				$this->_myCrmForStore[$key]->executantShortName = !empty($executant) ? $executant->getShortName() : "system";
			}
		}
		return ($this->_myCrmForStore);
	}
	public function getCrmForStore() {
		if (empty($this->_myCrmForStore))
		{
			$this->_myCrmForStore = Crm2::getFromDhForStore(intval($this->id_dh));
			foreach ($this->_myCrmForStore as $key => $elm)
			{
				$executant = Dh::getById($elm->id_executant);
				$this->_myCrmForStore[$key]->executantShortName = !empty($executant) ? $executant->getShortName() : "system";
			}
		}
		return ($this->_myCrmForStore);
	}
	public static function addClient($cons_id) {
		if (!empty($_POST['button1id']) && $_POST['button1id'] === "AddClient" &&
			!empty($_POST['civil']) && ($_POST['civil'] === "Madame" || $_POST['civil'] === "Monsieur")
			&& !empty($_POST['Nom']) && !empty($_POST['prenom']) && !empty($_POST['tel']) && !empty($_POST['mail'])){
			$bdd = new PDO('mysql:host='. SERVERNAME . ';dbname=mscpi_db;charset=utf8', USERNAME, PASSWORD);
			$bdd2 = new PDO('mysql:host='. SERVERNAME . ';dbname=mscpi_db;charset=utf8', USERNAME, PASSWORD);
			$table_dh = $bdd->prepare("INSERT INTO `DONNEUR D'ORDRE`(day, password, IP, login, lien_phy, conseiller, page)
													VALUES (CURDATE(), :mdp, :IP, :login, :lien_phy, :conseiller, :page)");
			$table_ps = $bdd2->prepare("INSERT INTO `PERSONNE PHYSIQUE`(lien_dh, civilite, prenom, nom, telephone, mail)
														VALUES(:lien_dh, :civile, :prenom, :nom, :num, :mail)");
			$table_dh->bindParam(':mdp', $mdp);
			$table_dh->bindParam(':IP', $ip, PDO::PARAM_STR);
			$table_dh->bindParam(':login', $login, PDO::PARAM_STR);
			$table_dh->bindParam(':lien_phy', $lien_phy);
			$table_dh->bindParam(':conseiller', $yepa);
			$table_dh->bindParam(':page', $back);
			$table_ps->bindParam(':lien_dh', $id);
			$table_ps->bindParam(':civile', $civ);
			$table_ps->bindParam(':num', $num);
			$table_ps->bindParam(':mail', $login);
			$table_ps->bindParam(':prenom', $prenom);
			$table_ps->bindParam(':nom', $nom);

			$back = "back";

			$ip = ft_crypt_information($_SERVER["REMOTE_ADDR"]);
			if (!$login = filter_var($_POST['mail'], FILTER_VALIDATE_EMAIL)){
				//del_all_cookie();
				return (false);
			}
			if (empty(ft_parse_cookie($_POST['mail'])))
				return (false);
			$res = $bdd->query("SELECT login FROM `DONNEUR D'ORDRE` WHERE login='". ft_crypt_information(mb_strtolower($_POST['mail']))."'");
			if (count($res->fetchAll()) > 0){
				//del_all_cookie();
				Notif::set("MsgKoAddDh", "Erreur : Cette adresse e-mail est déja utilisée !");
				return (false);
			}
			$login = ft_crypt_information(mb_strtolower($_POST['mail']));
			$yepa = $cons_id;
			$civ = ft_crypt_information($_POST['civil']);
			if (check_name($_POST['prenom']) || check_name($_POST['Nom']))
			{
				Notif::set("MsgKoAddDh", "Erreur avec le nom ou le prénom");
				return (false);
			}
			$nom = ft_crypt_information($_POST['Nom']);
			$prenom = ft_crypt_information($_POST['prenom']);
			if (!empty($_POST["pays"]))
			{
				if (check_tel_mobile($_POST['tel'], $_POST["pays"]))
				{
					Notif::set("MsgKoAddDh", "Erreur avec le numéro de téléphone");
					return (false);
				}
			}
			else
			{
				$_POST["pays"] = " ";
				$_POST["tel"] = " ";
			}
			$num = ft_crypt_information($_POST['tel']);
			$bdd->beginTransaction();
			$bdd2->beginTransaction();
			$state = $table_dh->execute();
			if (!$state)
			{
				$bdd->rollBack();
				Notif::set("MsgKoAddDh", "Erreur d'insertion de Donneur d'ordre");
				return (false);
			}
			$id = $bdd->lastInsertId("id_dh");
			$state = $table_ps->execute();
			if (!$state)
			{
				$bdd->rollBack();
				$bdd2->rollBack();
				Notif::set("MsgKoAddPp", "Error d'insertion de la personne physique");
				return (false);
			}
			$lien_phy = $bdd2->lastInsertId("id_phs");
			$bdd->commit();
			$bdd2->commit();
			$bitch = $bdd->prepare("UPDATE `DONNEUR D'ORDRE` SET lien_phy = ? WHERE id_dh = ?");
			$state = $bitch->execute(array($lien_phy, $id));

			Notif::set("MsgOkAddClient", "Le prospect a ete ajoute avec succes.");
			return ($id);
		}
	}
	public function getClientType() {
		if ($this->type == null)
			return ("Prospect");
		return (ucfirst($this->type));
	}
	public static function getClients() {
		if (self::$_collaborateurs === null)
			self::$_collaborateurs = parent::getFromArray(
				"type",
				array("client", "NULL")
			);
		return self::$_collaborateurs;
	}
	public static function getCollaborateurs() {
		if (self::$_collaborateurs === null)
		self::$_collaborateurs = parent::getFromArray(
				"type",
				self::$typeDeCompte
			);
		return self::$_collaborateurs;
	}
	public function getMyClientsForCompteRendu() {
		if ($this->getType() == "conseiller")
			$tmp = parent::getFromKeysValues(
				 array(
						"conseiller" => $this->id_dh
				)
			);
		else if ($this->getType() == "assistant" || $this->getType() == "prospecteur")
			$tmp = parent::getAll();
		$tmp2 = [];
		foreach ($tmp as $key => $elm)
		{
			if (empty($elm->getType()) || $elm->getType() == "client")
				$tmp2[] = $elm;
		}
		return ($tmp2);
	}
	public function getMyClients() {
		if ($this->_myClients === null) {
			if ($this->getType() == "conseiller")
			{
				$req = "SELECT * FROM `DONNEUR D'ORDRE` WHERE conseiller = ? OR vip != ? OR vip IS NULL";
				$tmp = Database::prepare(static::$_db, $req, [$this->id_dh, 1], "Dh");
				$tmp2 = [];
				foreach ($tmp as $key => $elm)
				{
					if (empty($elm->getType()) || $elm->getType() == "client")
						$tmp2[] = $elm;
				}
				$this->_myClients =  $tmp2;
			}
			else if ($this->getType() == "backoffice" || $this->getType() == "assistant" || $this->getType() == "prospecteur")
			{
				$this->_myClients = Dh::getClients();
			}
			else if ($this->getType() == "yoda")
			{
				//$this->_myClients = self::getAll();
				$req =  "SELECT * FROM `DONNEUR D'ORDRE` WHERE type != \"yoda\" or type IS NULL";
				$this->_myClients = Database::prepare(static::$_db, $req, array(), "Dh");
			}
			else
			{
				$this->_myClients = [];
			}
		}
		return $this->_myClients;
	}
	public function getMyClientsHelping() {
		if ($this->_helping === null) {
			$this->_helping = parent::getFromKeysValues(
				 array(
						"conseiller" => $this->id_dh, "help" => 1
					)
				);
		}
		return $this->_helping;
	}

	public static function getConseillerByLogin($login) {
		$ret = self::getOneByLogin($login);
		if (empty($ret) || $ret->type != "conseiller")
			return (NULL);
		return ($ret);
	}
	public static function getConseillersForStore() {
		$rt = [];
		foreach (self::getConseillers() as $key => $elm)
		{
			$rt[] = [
				"id" => $elm->id_dh,
				"shortName" => $elm->getShortName()
			];
		}
		return ($rt);
	}
	public static function getConseillersForStoreMini() {
		$rt = [];
		foreach (self::getConseillers() as $key => $elm)
		{
			$rt[$elm->id_dh] = $elm->getShortName();
		}
		return ($rt);
	}
	public static function getAssistants( $seulement_actif = 0) {

		return ($seulement_actif) ? parent::getFromKeysValues(["type" => 'assistant','remove_access' => 0]) : parent::getFromArray("type",	array('assistant'));
	}
	public static function getConseillers( $seulement_actif = 0) {

		return ($seulement_actif) ? parent::getFromKeysValues(["type" => 'conseiller','remove_access' => 0]) : parent::getFromArray("type",	array('conseiller')	);
	}
	public function getType() {
		return ($this->type);
	}
	public function getTypeStr() {
		if ($this->type == null)
			return ("Prospect");
		return (ucfirst($this->type));
	}
	public static function getById($id) {
		$rt = parent::getFromKeyValue("id_dh", $id);
		if (empty($rt))
			return (null);
		return ($rt[0]);

	}
	public static function getByLogin($login) {
		if (empty($login))
			return (array());
		$login = strtolower($login);
		return parent::getFromKeysValues(
			array(
				"login" => ft_crypt_information($login)
			)
		);
	}
	public static function getOneByLogin($login) {
		if (empty($login))
			return (array());
		$rt = parent::getFromKeysValues(
			array(
				"login" => ft_crypt_information($login)
			)
		);
		if (count($rt))
			return ($rt[0]);
		return (null);
	}
	public function getLogin() {
		if ($this->_myLogin == NULL)
			$this->_myLogin = ft_decrypt_crypt_information($this->login);
		return ($this->_myLogin);
	}
	public function getPm() {
		$rt = array();
		$first = $this->getBeneficiaire();
		foreach ($first->getPm() as $ben) {
			foreach ($ben as $elm2)
				array_push($rt, $elm2);
		}
		return ($rt);
	}
	public function getConseiller() {
		if (!in_array($this->type, self::$typeDeCompte))
			$this->_conseiller = self::getById($this->conseiller);
		else
			$this->_conseiller = self::getById(1);

			//if ($this->_conseiller == NULL && $this->conseiller > 0)
		return ($this->_conseiller);
	}
	public static function getClient() {
		if (self::$_client != NULL)
			return ($_client);
		$name = "`DONNEUR D'ORDRE`";
		$req =  "SELECT * FROM " . $name . " WHERE type = \"client\" or type IS NULL";
		self::$_client = Database::prepare(static::$_db, $req, array(), get_called_class());
		return (self::$_client);
	}
	public static function getWithParam($token, $login) {
		//if (self::$_withparam == null)
		//{
			//self::$_withparam = parent::getFromKeysValues(
			return parent::getFromKeysValues(
				array(
					"login" => $login,
					"TOKEN" => $token
				)
			)[0];
		//}
		//return (self::$_withparam);
	}
	public static function getCurrent() {
		if (self::$_current == null)
		{
			if (
				empty($_COOKIE["login"]) ||
				empty($_COOKIE["token"]) ||
				empty(ft_parse_cookie($_COOKIE["token"])) ||
				empty(ft_parse_cookie($_COOKIE["login"]))
			)
				return (0);
			self::$_current = parent::getFromKeysValues(
				array(
					"login" => $_COOKIE['login'],
					"TOKEN" => $_COOKIE['token'],
				)
			);
			if (count(self::$_current) == 0)
				return null;
			self::$_current = self::$_current[0];
		}
		return (self::$_current);
	}
	public function getDividendes($year = null) {
		$rt = 0;
		foreach ($this->getLstTransaction() as $elm) {
			if ($year === null)
				$rt += $elm->getDividende();
			else
				$rt += $elm->getDividende($year);
		}
		return ($rt);
	}
	public function getBeneficiaire() {
		$rt = Beneficiaire::getFromKeyValue("id_dh", $this->id_dh);
		if (count($rt))
			return ($rt);
		return null;
	}
	public function getTransaction() {
		if ($this->_myTransaction == null)
		{
			$this->_myTransaction = Transaction::getFromKeyValue("id_donneur_ordre", $this->id_dh);
		}
		return ($this->_myTransaction);
	}
	private static function cmp($a, $b)
	{
		return ($a->getActualValue() < $b->getActualValue());
	}
	public function getDistinctTransaction() {
		if ($this->_myDistinctTransaction == null)
		{
			$this->_myDistinctTransaction = Transaction::getDistinctTransaction($this->id_dh);
			usort($this->_myDistinctTransaction, array("Dh", "cmp"));
		}
		return ($this->_myDistinctTransaction);
	}
	public function getDistinctTransactionTypePro() {
		if ($this->_myDistinctTransactionTypePro == null)
		{
			$this->_myDistinctTransactionTypePro = Transaction::getDistinctTransactionTypePro($this->id_dh);
			usort($this->_myDistinctTransactionTypePro, array("Dh", "cmp"));
		}
		return ($this->_myDistinctTransactionTypePro);
	}
	public function getLstTransaction() {
		if ($this->_lstTransaction == null) {
			$this->_lstTransaction = array();
			if ($this->getSCPIs()) {
				foreach ($this->getSCPIs() as $elm) {
					array_push($this->_lstTransaction, new LstTransaction($this->id_dh, $elm->id));
				}
			} else {
				$this->_lstTransaction = array();
			}
		}
		return ($this->_lstTransaction);
	}
	public function afterRegenerateArrayTable ($dataTransaction) {
	/*
		require_once("module/ApercuDeMonPorteFeuillev2/controller.php");
		$ref = new ReflectionClass("ApercuDeMonPorteFeuillev2");
		$inst = $ref->newInstanceWithoutConstructor();
		$inst->dh = $this;
		$inst->data = $dataTransaction;
		$inst->regenerateCacheModal($this->id_dh);
		*/
	}
	public function generateCacheArrayTable() {
		foreach ($this->getBeneficiaires() as $key => $elm)
		{
			$elm->regenerateCacheArrayTable();
		}
		$lst = $this->getLstTransaction();
		$rt = LstTransaction::forGeneracteCache($lst);
		//$rt['precalcul']['actualDividendes'] = $this->getDividendes();
		return ($rt);
	}
	public function getSCPIs() {
		if ($this->_lstSCPI == null)
		{
			$this->_lstSCPI = Scpi::getFromArray(
				Transaction::getOnProperty("id_scpi", $this->getDistinctTransaction())
			);
		}
		return ($this->_lstSCPI);
	}
	public function getSCPIsDist() {
		return Scpi::getFromArrayDist(
			Transaction::getOnProperty("id_scpi", $this->getDistinctTransaction())
		);
	}
	public function getActuality() {
		return Actuality::getFromArray(
			Transaction::getOnProperty("id_scpi", $this->getDistinctTransaction()),
			8
		);
	}
	public function getAllActuality() {
		return Actuality::getAllFromArray(
			Transaction::getOnProperty("id_scpi", $this->getDistinctTransaction())
		);
	}
	public function getPublication() {
		return Publication::getFromArray(
			Transaction::getOnProperty("id_scpi", $this->getDistinctTransaction()),
			8
		);
	}
	public function getAcquisition() {
		return Acquisition::getFromArray(
			Transaction::getLstScpiId($this->getDistinctTransaction()),
			5
		);
	}
	public function getId() {
		return ($this->id_dh);
		//return $this->id;
	}
	public function getScpiId() {
		echo $this->id_dh;
	}
	public function getSumPurchase() {
		return Transaction::getSumPurchase($this->getDistinctTransaction());
	}
	public function getSumDistinctPurchase() {
		return Transaction::getSumPurchase($this->getDistinctTransaction());
	}
	public function getSumActualValue() {
		$rt = 0;
		foreach ($this->getDistinctTransaction() as $elem) {
			$rt += $elem->getActualValue();
		}
		return ($rt);
	}
	public function getPersonnePhysique() {
		return Pp::getByDh($this->lien_phy);
	}
	public static function getByCNP($civ, $nom, $prenom) {

		foreach (self::getAll() as $key => $dh)
		{
			$all = $dh->getAllPersonnePhysique();
			if (empty($all))
				return (NULL);
			foreach ($all as $key => $val) {
				if (prepare($val->getName()) == prepare($nom) && 
					//prepare($val->getCiviliteFormat()) == prepare($civ) &&
					prepare($val->getFirstName()) == prepare($prenom)){
					return ($val);
				}
			}
			foreach ($all as $key => $val) {
				if (prepare($val->getName()) == prepare($prenom) && 
					//prepare($val->getCiviliteFormat()) == prepare($civ) &&
					prepare($val->getFirstName()) == prepare($nom)) 
				{
					//echo "\033[33mNom prénom inversé : \n\033[0m";
					return ($val);
				}
			}
		}
		return (NULL);
	}
	public function getPersonnePhysiqueByCNP($civ, $nom, $prenom) {
		$all = $this->getAllPersonnePhysique();
		if (empty($all))
			return (NULL);
		foreach ($all as $key => $val) {
			if (strtolower($val->getName()) == strtolower($nom) && 
				strtolower($val->getCiviliteFormat()) == strtolower($civ) &&
				strtolower($val->getFirstName()) == strtolower($prenom)){
				return ($val);
			}
		}
		return (NULL);
	}
	public function getPersonneMoraleByDenomination($denomination) {
		$all = $this->getAllPersonneMorale();
		if (empty($all))
			return (NULL);
		foreach ($all as $key => $val) {
			if (strtolower($val->getDenominationSociale()) == strtolower($denomination)){
				return ($val);
			}
		}
		return (NULL);
	}
	public function getAllPersonnePhysique() {
		if ($this->_myPp == null)
			$this->_myPp = Pp::getAllFromDh($this->id_dh);
		return $this->_myPp;
	}
	public function getAllPersonneMorale() {
		if ($this->_myPm == null)
			$this->_myPm = Pm::getAllFromDh($this->id_dh);
		return $this->_myPm;
	}

	public function getSituationsJuridique() {
		return (SituationJuridique::getFromDh($this->id_dh));
	}
	public function getSituationsFiscale() {
		return (SituationFiscale::getFromDh($this->id_dh));
	}
	public function getSituationsFinanciere() {
		return (SituationFinanciere::getFromDh($this->id_dh));
	}
	public function getSituationsPatrimoniale() {
		return (SituationPatrimoniale::getFromDh($this->id_dh));
	}
	public function getFavorites() {
		return (Favoris::getFromDh($this->id_dh));
	}
	public function getFavoritesArray() {
		$rt = array();
		foreach ($this->getFavorites() as $key => $elm)
		{
			 $rt[] = $elm->id_actu;
		}
		return ($rt);
	}
	public function getDocumentNotValidateFromTypeName($name) {
		$rt = array();
		$documents = Document::getOnlineFromNameType($name);
		foreach ($documents as $key => $elm)
		{
			if (!$elm->checkDhValidate($this->id_dh))
				$rt[] = $elm;
		}
		return ($rt);
	}
	public function setDocumentValidateFromTypeName($name) {
		$documents = Document::getOnlineFromNameType($name);
		foreach ($documents as $key => $elm)
		{
			if (!$elm->checkDhValidate($this->id_dh))
				return ($elm->setValidateForDh($this->id_dh));
		}
	}
	public function getCouple() {
		return Beneficiaire::getCoupleFromPersonnePhysique($this->lien_phy);
	}
	public function haveCouple() {
		if (count($this->getCouple()))
			return (true);
		else
			return (false);
	}
	public function checkPpIsMine($id_phs) {
		$allPp = $this->getAllPersonnePhysique();
		foreach ($allPp as $key => $elm) {
			if ($elm->id_phs == $id_phs)
				return (true);
		}
		return (false);	
	}
	public function getLogs() {
		return (Logs::getFromDhByDate($this->id_dh));
	}
	public function getLoggers() {
		if ($this->_loggers == null)
		{
			$this->_loggers = Logger::getByClient($this->id_dh);
			uasort($this->_loggers, function($a, $b) {
				return ($a->date < $b->date);
			});
			//dbg($this->_loggers);
			//exit();
		}
		return ($this->_loggers);
	}
	public static function changeLogin($id, $new_login) {
		//$dh  = self::getByLogin($old_login);
		$dh = self::getById($id);
		//if (empty($dh))
			//return (false);
		//$dh = $dh[0];
		$id_Pp = $dh->lien_phy;
		$newLogin = ft_crypt_information($new_login);

		Database::beginTransaction();
		if (!$dh->getPersonnePhysique()->updateOneColumn("mail", $newLogin))
		{
			Database::rollBack();
			return (false);
		}
		if (!$dh->updateOneColumn("login", $newLogin))
		{
			Database::rollBack();
			return (false);
		}
		$newComfirm = $dh->getConfirmation() & 0xd;
		if (!$dh->updateOneColumn("confirmation", $newComfirm))
		{
			Database::rollBack();
			return (false);
		}
		if (!$dh->updateOneColumn("login", $newLogin))
		{
			Database::rollBack();
			return (false);
		}
		return (Database::commit());
	}
	public function getShortName() {
		return ($this->getPersonnePhysique()->getShortName());
	}


	public function getConfirmation() {
		return ($this->confirmation);
	}

	public function insertNewSignedDocumentByIdType($id_type, $data, $contentType)
	{
		return Document::insertNewNoTime(
			$id_type, // ID pour le document Lettre de mission
			self::getEntityId(),
			$this->id_dh,
			$data,
			$contentType,
			"lettre_de_mission_" . $this->getPersonnePhysique()->getFirstName() . "_" . $this->getPersonnePhysique()->getName() . ".pdf",
			0
		);
	}
	public function insertNewLM($url, $id_universign, $lm, $duree)
	{
		$lm_id = $this->insertNewSignedDocumentByIdType(4, ft_simple_encryption_file($lm['data']), $lm['content-type']);
		if (empty($lm_id))
			return (false);
		$lm = Document::getFromId($lm_id);
		if (empty($lm))
			return (false);
		$lm = $lm[0];
		if (!$lm->updateOneColumn("url", $url))
			return (false);
		if (!$lm->updateOneColumn("id_universign", $id_universign))
			return (false);
		if (!$lm->updateOneColumn("content_plus", serialize($duree)))
			return (false);
		return ($lm->id);
	}
	public function getDocumentSignedByIdType($id_type)
	{
		return Document::getFromIdTypeIdEntity(
			$id_type,
			self::getEntityId(),
			$this->id_dh
		);
	}
	public function getLastLm() {
		$rt = Document::getLastValideSignedFromIdTypeIdEntity(
			4,
			self::getEntityId(),
			$this->id_dh
		);
		if (count($rt))
			return ($rt[0]);
		return (null);
	}
	public function getDocumentsForStore() {
		$rt = [];
		$tmp[$this->id_dh] = $this->getMiniDocumentArray();
		$rt[Dh::getEntityId()] = $tmp;
		$Pps = $this->getAllPersonnePhysique();
		$tmp = [];
		foreach ($Pps as $key => $elm)
		{
			$tmp[$elm->id_phs] = $elm->getMiniDocumentArray();
		}
		$rt[Pp::getEntityId()] = $tmp;

		$Pms = $this->getAllPersonneMorale();
		$tmp = [];
		foreach ($Pms as $key => $elm)
		{
			$tmp[$elm->id_pm] = $elm->getMiniDocumentArray();
		}
		$rt[Pm::getEntityId()] = $tmp;

		$Trans = $this->getTransaction();
		$tmp = [];
		foreach ($Trans as $key => $elm)
		{
			$tmp[$elm->id] = $elm->getMiniDocumentArray();
		}
		$rt[Transaction::getEntityId()] = $tmp;

		$Ben = $this->getBeneficiaires();
		$tmp = [];
		foreach ($Ben as $key => $elm)
		{
			$tmp[$elm->id_benf] = $elm->getMiniDocumentArray();
		}
		$rt[Beneficiaire::getEntityId()] = $tmp;

		$Projet = $this->getProjets();
		$tmp = [];
		foreach ($Projet as $key => $elm)
		{
			$tmp[$elm->id] = $elm->getMiniDocumentArray();
		}
		$rt[Projet::getEntityId()] = $tmp;
		return ($rt);
	}
	public function lettreMissionOkay() {
		if (count($this->getValideDocumentSignedByTypeId(4)))
			return (true);
		return (false);
	}
	public function getNotifications() {
		return Notifications::getForDh($this->id_dh);
	}
	public function getNotificationsNotComplete() {
		return Notifications::getNotCompleteForDh($this->id_dh);
	}
	public function getNotificationsComplete() {
		return Notifications::getCompleteForDh($this->id_dh);
	}
	public function getCodeSms() {
		return ($this->code);
	}
	public function getCrmForToday() {
		return (Crm2::getNotCompleteForDh($this->id_dh));
	}
	public function getMyClientNotHaveCrm() {
		if ($this->getType() !== "conseiller" && $this->getType() !== "assistant" && $this->getType() !== "prospecteur")
			return ;
		$rt = [];
		foreach ($this->getMyClientsForCompteRendu() as $key => $elm)
		{
			//if ($elm->getType() != 'client')
				//continue;
			if ($elm->isKo())
				continue ;
			if (count($elm->getCrmNotOkay()) == 0)
				$rt[] = $elm;
		}
		return ($rt);
	}
	public function generateCompterenduJournalierConseiller() {
		if ($this->getType() !== "conseiller" && $this->getType() !== "assistant")
			return ;

		// Generation du contrendu pour le conseiller
		// Les Crm du jours ..........
		$rt = "";
		$crmToday = $this->getCrmForToday();
		if (count($crmToday))
		{
			$rt .= "<h2 style='color:#1781e0;font-family: sans-serif; text-align: center;'>Bonjour " . $this->getShortName() . "</h2>";
			$rt .= "<p style='color:#476682;font-family: sans-serif'>Voici vos taches CRM pour la journée</p>";
			$rt .= "
				<table border='0' style='font-family: sans-serif;border-spacing:0;width:100%'>
					<thead>
						<tr style='background-color:#1781e0; color:#fff; text-align:center;'>
							<th style='padding:20px'>Client</th>
							<th style='padding:20px'>Contact</th>
							<th style='padding:20px'>Sujet</th>
							<th style='padding:20px'>Date</th>
							<th style='padding:20px'>Commentaire</th>
						</tr>
					</thead>
					<tbody>";
			foreach ($crmToday as $key => $elm)
			{
				$rt .= "<tr style='color:#1781e0; text-align:center;'>";
				$rt .= "	<td style='padding:10px; border-bottom:1px solid #1781e0;'>" . Dh::getFromId($elm->id_client)[0]->getShortName() . "</td>";
				$rt .= "	<td style='padding:10px; border-bottom:1px solid #1781e0;'>" . $elm->getContactSelectedStr() . "</td>";
				$rt .= "	<td style='padding:10px; border-bottom:1px solid #1781e0;'>" . $elm->getSujetSelectedStr() . "</td>";
				$rt .= "	<td style='padding:10px; border-bottom:1px solid #1781e0;'>" . $elm->getDateExecutionDateTime()->format("d/m/Y H:i:s") . "</td>";
				$rt .= "	<td style='padding:10px; border-bottom:1px solid #1781e0;'>" . $elm->getCommentaire() . "</td>";
				$rt .= "</tr>";
			}
			$rt .= "
					</tbody>
				</table>";
			$rt .= "<br />";
			$rt .= "<br />";
		}
		$notHaveCrm = $this->getMyClientNotHaveCrm();
		if (count($notHaveCrm) != 0)
		{
			$rt .= "<p style='color:#476682;font-family: sans-serif'>Ces clients n'ont pas de prochaines taches crm : </p/>";
			foreach($notHaveCrm  as $key => $elm)
			{
				$rt .= "<ul style='color:#476682;font-family: sans-serif;'>";
				$rt .= "<li>" . $elm->getShortName() . "</li>";
				$rt .= "</ul>";
			}
		}
		return ($rt);
	}
	public static function sendCompterenduToAssistant() {
		$weekDay = (new DateTime('NOW'))->format('w');
		if ($weekDay == 0 || $weekDay == 6)
			return ;
		foreach(self::getAssistants() as $key => $elm)
		{
			try {
				MailSender::sendToMscpiWithTemplate($elm, "Compte rendu du jour", $elm->generateCompterenduJournalierConseiller(), 1);
			}
			catch (Exception $e) {}
		}
	}
	public static function sendCompterenduToConseiller() {
		$weekDay = (new DateTime('NOW'))->format('w');
		if ($weekDay == 0 || $weekDay == 6)
			return ;
		foreach(self::getConseillers() as $key => $elm)
		{
			try {
				MailSender::sendToMscpiWithTemplate($elm, "Compte rendu du jour", $elm->generateCompterenduJournalierConseiller(), 1);
			}
			catch (Exception $e) {}
		}
	}
	public function getLastCrmOkay() {
		if (empty($this->_lastCrm))
		{
			$lastCrm = Crm2::getLastOkayForClient($this->id_dh);
			if (count($lastCrm) > 0)
				$this->_lastCrm = $lastCrm[0];
		}
		return ($this->_lastCrm);
	}
	public function getNextCrm() {
		if (empty($this->_nextCrm))
		{
			$nextCrm = Crm2::getNextNotOkayForClient($this->id_dh);
			if (count($nextCrm) > 0)
				$this->_nextCrm = $nextCrm[0];
		}
		return ($this->_nextCrm);
		/*
		$rt = Crm2::getNextNotOkayForClient($this->id_dh);
		if (count($rt) > 0)
			return ($rt[0]);
		return ($rt);
		*/
	}
	public function sendMailRegister() {
		MailSender::sendToDhWithTemplateName($this, "Bienvenue chez MeilleureSCPI.com - INSCRIPTION", "", "mail_register");
	}
	public function sendMail($subject, $content, $templateName)
	{
		MailSender::sendToDhWithTemplateName($this, $subject, $content, $templateName);
	}
	public function sendMailConfirmation()
	{
		$token = self::setTokenConfirmation();
		$_SESSION['confirmation'] = $token;
		$_SESSION['mail'] = $this->login;
		$message = getThisDomain() . "/?p=Portefeuille&confirmation=" . $token;
		MailSender::sendToDhWithTemplateName($this, "Bienvenue sur MeilleureSCPI.com", $message, "mail_confirmation");
	}
	private function setTokenConfirmation()
	{
		$token = generateRandomString();
		$this->updateOneColumn('tmp_token', $token);
		return $token;
	}
	public function validateMail( $token )
	{
		if (($dh = $this->getFromKeyValue('tmp_token', $token)))
		{
			$dh = $dh[0];
			$dh->updateOneColumn('tmp_token', NULL);
			if ($dh->confirmation < 2)
				$dh->updateOneColumn('confirmation', $dh->confirmation + 2);
			return $dh->id_dh;
		}
		return false;
	}
	public static function isPasswordOkay($passwd)
	{
		/*
		 * TODO
		 */
		/* if (!password.match(/([a-z])/g))
		else if (!password.match(/([A-Z])/g))
		else if (!password.match(/[0-9]/g))
		else if (password.length < 8) */
		return true;
	}

	public function setTmpPassword() {
		$str = generateRandomString(8);
		$this->updateOneColumn('password',ft_crypt_pass($str));
		$this->updateOneColumn('mdp_tmp', 1);
		return $str;
	}
	public static function findByReset($token)
	{
		if (self::$_current == null)
		{
			$req = "SELECT * FROM `DONNEUR D'ORDRE` WHERE `reset` LIKE ? AND `remove_access` = ?";
			$rt = Database::prepare(static::$_db, $req, [$token."|%", 0], get_called_class());
			if (isset($rt[0]))
				self::$_current = $rt[0];
		}
		return self::$_current;
	}
	private function resetPassword() {
		$time = (time() + (2 * 60 * 60));
		$str = generateRandomString(21);
		$link = $str . "|" . $time;
		$this->updateOneColumn('reset', $link);
		return ($str);
	}
	public function blockAccount($from_dh, $why)
	{
		$this->updateOneColumn('TOKEN', NULL);
		$this->updateOneColumn('remove_access', 1);
		$this->updateOneColumn('id_blocage', $from_dh);
		$this->updateOneColumn('why', ft_crypt_information(htmlspecialchars($why)));
	}
	public function loosePasswordProcedure( $reset = null ) {
		if (is_null($reset))
			$reset = $this->resetPassword();
		$message = getThisDomain() ."/?reset=" . $reset;

		$currentDh = Dh::getCurrent();
		if (!empty($currentDh))
			$id_dh = $currentDh->id_dh;
		else
			$id_dh = 0;
		Logger::setNew("Procedure perte de mot de passe", $id_dh, $this->id_dh, ["token" => $reset]);
		MailSender::sendToDhWithTemplateName($this, "MeilleureSCPI.com - MOT DE PASSE OUBLIÉ", $message, "loose_password");
		/*

		envoi d'un email :
			"MeilleureSCPI.com vous invite à consulter votre E-mail réinitialiser votre mot de passe"
		*/
	}
	/*
	public function sendMailRegister() {
		$Pp = $this->getPersonnePhysique();
		send_mail_register(
			$this->getLogin(),
			$Pp->getName(),
			$Pp->getFirstName(),
			$Pp->getCivilite()
		);
	}*/

	public function getPersonnePhysiqueForStore() {
		$rt = [];
		foreach ($this->getAllPersonnePhysique() as $key => $elm)
		{
			$rt[] = $elm->getForStore();
		}
		return ($rt);
	}
	public function determineConseillerFromTransaction() {
		$transaction = $this->getTransaction();
		usort($transaction, function($a, $b) {
			return ($a->getEnrDate() < $b->getEnrDate());
		});
		foreach ($transaction as $key => $elm)
		{
			if (!empty($elm->getConseiller()) && $elm->getConseiller()->id_dh != 49)
			{
				return ($elm->getConseiller()->id_dh);
			}
			//echo $elm->getEnrDate()->format('d/m/Y') . "<br />";
		}
		return (false);
		//dbg($transaction);
		exit();
	}
	public function isVip() {
		return (!empty($this->vip));
	}
	public function adresseOk() {
		return (!empty($this->adresse_valide) && $this->adresse_valide == 1);
	}

	public function isKo() {
		return (!empty($this->ko));
	}
	public function mailOk() {
		return (
			$this->confirmation == 2 ||
			$this->confirmation == 3
		);
	}
	public function phoneOk() {
		return (
			$this->confirmation == 1 ||
			$this->confirmation == 3
		);
	}
	public function isValide() {
		return (
			$this->mailOk() &&
			$this->phoneOk()
		);
	}
	public function isMine($id_dh) {
		if (
			$this->getType() == "yoda" ||
			$this->getType() == "backoffice" ||
			$this->getType() == "developpeur"
		)
			return (true);
		if ($this->getType() == "conseiller")
		{
			$tmp = Dh::getById($id_dh);
			if (empty($tmp) || $tmp->getConseiller->id_dh != $this->id_dh)
				return (false);
			return (true);
		}
		return (false);
	}
	public  function getLastAction() {
		return (Logger::getLastActionForDh($this->id_dh));
	}
	public  function getLastConnexion() {
		$rt = Logger::getLastByTypeExecutant("Connexion front", $this->id_dh);
		if (empty($rt))
			return (null);
		return ($rt[0]);
	}
	public function getEnfants() {
		return (Pp::getEnfantsForDh($this->id_dh));
	}
	public function getCentreInteret()
	{
		$req = "SELECT `centre_interet`.* FROM `centre_interet` INNER JOIN `dh_centre_interet` ON `centre_interet`.`id` = `dh_centre_interet`.`id_ci`
			WHERE `dh_centre_interet`.`id_dh` = ?";
		return Database::prepare(static::$_db, $req, [$this->id_dh], 'CentreInteret');
	}
	public function getCentreInteretSCPI()
	{
		$req = "SELECT GROUP_CONCAT(`id_scpi`) as `scpis` FROM `dh_centre_interet_scpi` WHERE `id_dh` = ? GROUP BY `id_dh`";

		if (($res = Database::getNoClass(static::$_db, $req, [$this->id_dh])))
			return Scpi::getFromArray(explode(',',$res[0]['scpis']));
		return [];
	}
	public function getSCPIForFrontStore()
	{
		$req = "SELECT DISTINCT `id_scpi` FROM `TRANSACTION` WHERE `id_donneur_ordre` = ?";
		return Database::getNoClass(static::$_db, $req, [$this->id_dh]);
	}
	public function getCIForFrontStore()
	{
		$rt = [];
		foreach (CentreInteret::getAll() as $ci)
			$rt[$ci->id] = false;
		foreach ($this->getCentreInteret() as $ci)
			$rt[$ci->id] = true;
		return $rt;
	}
	public function getCISCPIForFrontStore()
	{
		$rt = [];
		foreach (SCPI::getAll() as $scpi)
			$rt[$scpi->id] = false;
		foreach ($this->getCentreInteretSCPI() as $scpi)
			$rt[$scpi->id] = true;
		return $rt;
	}
	public function getForStore()
	{
		$rt = [];
		$rt['id'] = $this->id_dh;
		$rt['ci'] = $this->getCIForFrontStore();
		$rt['ciscpi'] = $this->getCISCPIForFrontStore();
		$rt['scpi'] = $this->getSCPIForFrontStore();
		$rt['adresse_valide'] = $this->adresseOk();

		$parrain = $this->getParrain();

		$rt['parrain'] = [];
		if (!empty($parrain)) {
			$rt['parrain']['shortName'] = $parrain->getShortName();
			$rt['parrain']['id'] = $parrain->id_dh ;
		}else {
			$rt['parrain']['shortName'] = null;
			$rt['parrain']['id'] = 0;
		}

		return $rt;
	}
	public function getForFrontStore()
	{
		$rt = [];
		$rt['id'] = $this->id_dh;
		$rt['ci'] = $this->getCIForFrontStore();
		$rt['ciscpi'] = $this->getCISCPIForFrontStore();
		$rt['scpi'] = $this->getSCPIForFrontStore();
		$rt['Pp'] = $this->getPersonnePhysique()->getForFrontStore();

		$parrain = $this->getParrain();

		$rt['parrainShortName'] = (!empty($parrain)) ? $parrain->getShortName() : "-";
		$rt['parrainId'] = (!empty($parrain)) ? $parrain->id_dh : 0;
		return $rt;
	}
	public function getPrecalculForFrontStore()
	{
		$this->regenerateCacheArrayTable();
		$dt = new DateTime();
		$rt = [];
		foreach ($this->getCacheArrayTable() as $scpi => $elt)
		{
			if ($scpi != "precalcul")
			{
				foreach ($elt as $t => $transac)
				{
					foreach ($transac as $id_transac)
					{
						if (is_array($id_transac))
						{
							foreach ($id_transac as $type_tr => $tr)
							{
								if ($type_tr == 'buy')
								{
									$rt[$scpi][$t][$tr->id][$type_tr] = [
										"id" => $tr->id,
										"doByMscpi" => ($tr->status_trans == "MS.C") ? true : false,
										"doByOther" => ($tr->status_trans != "MS.C") ? true : false,
										"enr_date" => (!empty($tr->enr_date) && ($enr_date = DateTime::createFromFormat("d/m/Y",ft_decrypt_crypt_information($tr->enr_date)))) ? $enr_date->getTimestamp() : NULL,
										"nbr_part" => $tr->nbr_part,
										"cle_repartition" => ($tr->cle_repartition != NULL) ? ft_decrypt_crypt_information($tr->cle_repartition) : NULL,
										"prix_part" => $tr->prix_part,
										"status_trans" => $tr->status_trans,
										"type_pro" => ($tr->type_pro != NULL) ? ft_decrypt_crypt_information($tr->type_pro) : NULL,
										"type_transaction" => "A"
									];
									$last_buy_transaction_id = $tr->id;
								}
								if ($type_tr == 'sell')
								{
									foreach ($tr as $sell_tr)
									{
										$rt[$scpi][$t][$sell_tr->id_transaction_achat][$type_tr][$sell_tr->id] = [
											"id" => $sell_tr->id,
											"id_transaction_achat" => $sell_tr->id_transaction_achat,
											"doByMscpi" => ($sell_tr->info_trans == "MS.C") ? true : false,
											"doByOther" => ($sell_tr->info_trans != "MS.C") ? true : false,
											"enr_date" => (!empty($sell_tr->enr_date) && ($enr_date = DateTime::createFromFormat("d/m/Y", ft_decrypt_crypt_information($sell_tr->enr_date)))) ? $enr_date->getTimestamp() : NULL,
											"nbr_part" => $sell_tr->nbr_part,
											"nbr_part_vente" =>  $sell_tr->nbr_part_vente,
											"prix_part" => $sell_tr->prix_part_vente,
											"prix_part_vente" => $sell_tr->prix_part_vente,
											"status_trans" => $sell_tr->status_trans,
											"type_pro" => ($sell_tr->type_pro != NULL) ? ft_decrypt_crypt_information($sell_tr->type_pro) : NULL,
											"type_transaction" => "V",
											"plusMoinValueEuro" => $sell_tr->plusMoinValueEuro,
											"plusMoinValuePourcent" => $sell_tr->plusMoinValuePourcent,
											"MontantRevente" => $sell_tr->MontantRevente
										];
									}
								}
								if ($type_tr == 'precalcul')
								{
									if (empty($last_buy_transaction_id))
										$last_buy_transaction_id = "ERROR";
									$rt[$scpi][$t][$last_buy_transaction_id][$type_tr] = [
										"plusMoinValueEuro" => $tr['plusMoinValueEuro'],
										"plusMoinValuePourcent" => $tr['plusMoinValuePourcent'],
										"ventePotentielle" => $tr['ventePotentielle'],
										"nbr_part" => $tr['nbr_part'],
										"MontantInvestissement" => $tr['MontantInvestissement'],
										"modal_link" => $transac['precalcul']['modal_link'],
										"prix_actuel" => $tr['prix_actuel']
									];
								}
							}
						}
					}
				}
			}
		}
		return $rt;
	}
	public function getSituationJuridiqueForStore() {
		return (SituationJuridique::getFromDhForStore($this->id_dh));
	}
	public function getSituationFinanciereForStore() {
		return (SituationFinanciere::getFromDhForStore($this->id_dh));
	}
	public function getSituationFiscaleForStore() {
		return (SituationFiscale::getFromDhForStore($this->id_dh));
	}
	public function getSituationPatrimonialeForStore() {
		return (SituationPatrimoniale::getFromDhForStore($this->id_dh));
	}
	public function getTokenAffiliation() {
		if ($this->token_affiliation == null)
		{
			$token = generateToken();
			while (count(Dh::getFromKeyValue("token_affiliation", $token)) > 0)
				$token = generateToken();
			$this->updateOneColumn('token_affiliation', $token);
		}
		return ($this->token_affiliation);
	}
	public function getParrain() {
		return (Dh::getById($this->id_parrain));
	}
	public function getFilleuls() {
		return (parent::getFromKeyValue('id_parrain', $this->id_dh));
	}
	public static function getLikeColumn($like) {
		$rt = [];
		$find = explode(" ", $like);
		foreach (self::getAll() as $key => $elm)
		{
			$okay = false;
			$Pp = $elm->getPersonnePhysique();
			foreach ($find as $key2 => $elm2)
			{
				if (empty($elm2))
					break ;
				$elm2_to_lower = strtolower($elm2);
				if (
					strstr(strtolower($elm->id_dh), $elm2_to_lower) !== false
					|| strstr(strtolower($Pp->getName()), $elm2_to_lower) !== false
					|| strstr(strtolower($Pp->getFirstName()), $elm2_to_lower) !== false
					|| strstr(strtolower($Pp->getMail()), $elm2_to_lower) !== false
					|| strstr(strtolower($Pp->getPhone()), $elm2_to_lower) !== false
				)
				{
					$okay = true;
					break ;
				}
			}
			if ($okay)
			{
				$tmp = [
					"id" => $elm->id_dh,
					"shortName" => $elm->getShortName()
				];
				$rt[] = $tmp;
			}
			if (count($rt) > 20)
				break;
		}
		return ($rt);
	}
	public function getCrmPrioritaire() {
		return (Crm2::getPrioritaireByConseiller($this->id_dh));
	}
	public function getLateCrm() {
		return (Crm2::getLateForConseiller($this->id_dh));
	}
	public function getIp() {
		return (ft_decrypt_crypt_information($this->IP));
	}
	public function getNonSollicitationParMail()
	{
		if (is_null($this->non_sollicitation_par_mail))
			return "";
		return (ft_decrypt_crypt_information($this->non_sollicitation_par_mail));
	}
	public function getLastValidateDocumentByTypeId($id_type_document) {
		return (DocumentDhValidation::getLastFromDhTypeDocument($this->id_dh, $id_type_document));
	}
	public function getFilValidation()
	{
		return ($this->getLastValidateDocumentByTypeId(6));
	}
	public function checkAuthorisation($dh) {
		return ($dh->id_dh == $this->id_dh);
	}
	public function getNbrLoggerTodayByName($typeName) {
		return (Logger::getNbrTodayByNameForExecutant($typeName, $this->id_dh));
	}
	public function getLoggerTodayByName($typeName) {
		return (Logger::getTodayByNameForExecutant($typeName, $this->id_dh));
	}
	public static function getDhCreatedOnFront() {
		return (parent::getFromKeyValue("page", "front"));
	}
/*
	public function needAdressValidation() {
		if ($this->adresse_valide)
			return (false);
		if ($this->force_adresse_validation)
			return (true);
		$date = Datetime::createFromFormat("d/m/Y H:i:s", "01/01/2017 00:00:00")->getTimestamp();
		foreach ($this->getTransaction() as $key => $trans) {
			if ($trans->doByMscpi() && $trans->getEnrDate() != false && $trans->getEnrDate()->getTimestamp() < $date)
				return (true);
		}
	}
*/
	public static function getFromPhone($num) {
		$data = Dh::getAll();
		$num = preg_replace('/[ ]/', '', $num);
		foreach ($data as $dh) {
			$x = ($dh->getPersonnePhysique());
			$nb = trim($x->getPhone());
			$nb = preg_replace('/[ ]/', '', $nb);
			if ($nb == $num)
				return ([$dh]);
		}
		return (0);
	}

	public function needAdressValidation() {
		if ($this->adresse_valide)
			return (false);
		if ($this->force_adresse_validation)
			return (true);
		$date = Datetime::createFromFormat("d/m/Y H:i:s", "01/01/2017 00:00:00")->getTimestamp();
		foreach ($this->getTransaction() as $key => $trans) {
			if ($trans->doByMscpi() && $trans->getEnrDate() != false && $trans->getEnrDate()->getTimestamp() < $date)
				return (true);
		}
		return (0);
	}
	public function getAdresseValide() {
		return ($this->adresse_valide);
	}

	public function isFrontCreation() {
		return ($this->page == "front");
	}



	public function getForScpiGestionAndOpportunity()
    {
        $bdd = new PDO('mysql:host='. SERVERNAME . ';dbname=mscpi_db;charset=utf8', USERNAME, PASSWORD);
       $res = $bdd->query('SELECT DISTINCT `ScpiGestion`.`id_scpi`,`ScpiGestion`.`adequation` ,`opportunity`.`price_per_part` FROM `opportunity`,`ScpiGestion` WHERE `ScpiGestion`.`show_opportunite` = 1 AND `ScpiGestion`.`id_scpi`= `opportunity`.`id_scpi` AND `ScpiGestion`.`adequation` IS NOT NULL');

        return $res->fetchAll();

//SELECT * FROM `ScpiGestion` WHERE `ScpiGestion.show_opportunite` = 1

        //SELECT * FROM `opportunity`,`ScpiGestion` WHERE `ScpiGestion`.`show_opportunite` = 1 AND `ScpiGestion`.`id_scpi`= `opportunity`.`id_scpi`
    }

	public function haveTransactionMscpi() {
		foreach ($this->getTransaction() as $key => $trans) {
			if ($trans->doByMscpi())
				return (true);
		}
		return (false);
	}

    public static function getNbInscriptionById($id){

        $req = "SELECT COUNT(*) as total FROM `DONNEUR D'ORDRE` WHERE create_from= ?";
        $rt[] = Database::getNoClass(static::$_db, $req, [$id])[0][0];
        return ($rt);
    }

    public static function nom_jour($date) {

        $jour_semaine = array(1=>"lundi", 2=>"mardi", 3=>"mercredi", 4=>"jeudi", 5=>"vendredi", 6=>"samedi", 7=>"dimanche",8=>"lundi", 9=>"mardi", 10=>"mercredi", 11=>"jeudi", 12=>"vendredi" );

        list($annee, $mois, $jour) = explode ("-", $date);

        $timestamp = mktime(0,0,0, date($mois), date($jour), date($annee));
        $njour = date("N",$timestamp);

        return $jour_semaine[$njour];

    }

    public static function jour_actuelle(){
        $date=array();
        $j1 = date("Y-m-d", mktime(0,0,0,date("m"),date("d"),date("Y")));
        $j2 = date("Y-m-d", mktime(0,0,0,date("m"),date("d")-1,date("Y")));
        $j3 = date("Y-m-d", mktime(0,0,0,date("m"),date("d")-2,date("Y")));
        $j4 = date("Y-m-d", mktime(0,0,0,date("m"),date("d")-3,date("Y")));
        $j5 = date("Y-m-d", mktime(0,0,0,date("m"),date("d")-4,date("Y")));
        $j6 = date("Y-m-d", mktime(0,0,0,date("m"),date("d")-5,date("Y")));
        $j7 = date("Y-m-d", mktime(0,0,0,date("m"),date("d")-6,date("Y")));
        $j8 = date("Y-m-d", mktime(0,0,0,date("m"),date("d")-7,date("Y")));
        $j9 = date("Y-m-d", mktime(0,0,0,date("m"),date("d")-8,date("Y")));
        $j10 = date("Y-m-d", mktime(0,0,0,date("m"),date("d")-9,date("Y")));
        $j11 = date("Y-m-d", mktime(0,0,0,date("m"),date("d")-10,date("Y")));
        $j12 = date("Y-m-d", mktime(0,0,0,date("m"),date("d")-11,date("Y")));

        $date[]=$j1;
        $date[]=$j2;
        $date[]=$j3;
        $date[]=$j4;
        $date[]=$j5;
        $date[]=$j6;
        $date[]=$j7;
        $date[]=$j8;
        $date[]=$j9;
        $date[]=$j10;
        $date[]=$j11;
        $date[]=$j12;
        $jour=array(self::nom_jour($j1), self::nom_jour($j2),self::nom_jour($j3),self::nom_jour($j4),self::nom_jour($j5),self::nom_jour($j6),self::nom_jour($j7),self::nom_jour($j8),self::nom_jour($j9),self::nom_jour($j10),self::nom_jour($j11),self::nom_jour($j12));
        return $jour;
    }

    public static function getNbrByIdForLastDays($id) {
        $i = 0;
        $rt = [];
        $dat = date("d/m/Y");
        $datUp = date("d/m/Y");
        $dat = Datetime::createFromFormat("d/m/Y H:i:s", $dat . " 00:00:00")->getTimestamp();
        $req = "SELECT count(*) FROM `DONNEUR D'ORDRE` WHERE create_from= ? and day = date(now());";
        $rt[] = Database::getNoClass(static::$_db, $req, [$id])[0][0];
        for ($i = 1; $i < 11;$i++)
        {
            $req = "SELECT count(*) FROM `DONNEUR D'ORDRE` WHERE create_from= ? AND day = date(now() - INTERVAL $i DAY);";
            $rt[] = Database::getNoClass(static::$_db, $req, [$id])[0][0];
        }
        return ($rt);
    }

    public static function getNbrByIdForLastDaysTotal() {
        $i = 0;
        $rt = [];
        $dat = date("d/m/Y");
        $datUp = date("d/m/Y");
        $dat = Datetime::createFromFormat("d/m/Y H:i:s", $dat . " 00:00:00")->getTimestamp();
        $req = "SELECT count(*) FROM `DONNEUR D'ORDRE` WHERE day = date(now());";
        $rt[] = Database::getNoClass(static::$_db, $req, [])[0][0];
        for ($i = 1; $i < 11;$i++)
        {
            $req = "SELECT count(*) FROM `DONNEUR D'ORDRE` WHERE day = date(now() - INTERVAL $i DAY);";
            $rt[] = Database::getNoClass(static::$_db, $req, [])[0][0];
        }
        return ($rt);
    }

    public static function getNbrByElementInscription($landing) {
        $tab=Array();
        $tabFinal=Array();
        $bdd = new PDO('mysql:host='. SERVERNAME . ';dbname=mscpi_db;charset=utf8', USERNAME, PASSWORD);
        $scpi=$bdd->query("SELECT distinct(type_complement) FROM `guide_list_api_scpi` WHERE type='".$landing."' ORDER BY type_complement");
        $tabScpi=$scpi->fetchAll();
        $max = sizeof($tabScpi);
        for($i = 0; $i < $max;$i++)
        {
            $tab[]=$tabScpi[$i][0];
        }
        $max2 = sizeof($tab);
        for($i = 0; $i < $max2;$i++)
        {
            $tabTotalDay=Array();
            $yesterday = date("Y-m-d", mktime(1, 1, 1, date("m"), date("d"), date("Y")));
            $scpi2="SELECT Count(*) FROM `guide_list_api_scpi` WHERE type='".$landing."' And type_complement = '".$tab[$i]."' And day='".$yesterday."'";
            $total = Database::getNoClass(static::$_db, $scpi2, [])[0][0];
            $tabTotalDay[]=$total;
            $scpi2 = "SELECT distinct(`origin`) FROM `guide_list_api_scpi` WHERE type_complement='".$tab[$i]."'";
            $total = Database::getNoClass(static::$_db, $scpi2, [])[0][0];
            $tabTotalDay[]=$total;
            for($j=0; $j<11; $j++){
                $yesterday = date("Y-m-d", mktime(1, 1, 1, date("m"), date("d") - $j, date("Y")));
                $scpi2="SELECT Count(*) FROM `guide_list_api_scpi` WHERE type='".$landing."' And type_complement = '".$tab[$i]."' And day='".$yesterday."'";
                $total = Database::getNoClass(static::$_db, $scpi2, [])[0][0];
                $tabTotalDay[]=$total;
            }
            $tabFinal[$tab[$i]]=$tabTotalDay;
        }

        return ($tabFinal);
    }

    public static function getNbrPageContact()
    {
        $tabFinal = Array();
        $tabTotalDay = Array();
        $yesterday = date("Y-m-d", mktime(1, 1, 1, date("m"), date("d"), date("Y")));
        $scpi2 = "SELECT Count(*) FROM `guide_list_api_scpi` WHERE type='Page Contact' And day='" . $yesterday . "'";
        $total = Database::getNoClass(static::$_db, $scpi2, [])[0][0];
        $tabTotalDay[] = $total;
        $scpi2 = "SELECT distinct(`origin`) FROM `guide_list_api_scpi` WHERE type='Page Contact'";
        $total = Database::getNoClass(static::$_db, $scpi2, [])[0][0];
        $tabTotalDay[] = $total;
        for ($j = 0; $j < 11; $j++) {
            $yesterday = date("Y-m-d", mktime(1, 1, 1, date("m"), date("d") - $j, date("Y")));
            $scpi2 = "SELECT Count(*) FROM `guide_list_api_scpi` WHERE type='Page Contact' And day='" . $yesterday . "'";
            $total = Database::getNoClass(static::$_db, $scpi2, [])[0][0];
            $tabTotalDay[] = $total;
        }
        $tabFinal['contact'] = $tabTotalDay;
        return ($tabFinal);
    }

    public static function getNbrByLandingMarketing($landing) {
        $tab=Array();
        $tabFinal=Array();
        $tabScpi[0]="Epargnant Barbu";
        $tabScpi[1]="Epargnant Vieux";
        $tabScpi[2]="Epargnant Couple";
        $tabScpi[3]="Epargnant Boxeur";
        $tabScpi[4]="Epargnant Militaire";
        $tabScpi[5]="Investir En SCPI";
        $max = sizeof($tabScpi);
        for($i = 0; $i < $max; $i++)
        {
            $tab[]=$tabScpi[$i];
        }
        $max2 = sizeof($tab);

        for($i = 0; $i < $max2;$i++)
        {
            $tabTotalDay=Array();
            $yesterday = date("Y-m-d", mktime(1, 1, 1, date("m"), date("d"), date("Y")));
            $scpi2="SELECT Count(*) FROM `guide_list_api_scpi` WHERE type='".$landing."' And type_complement = '".$tab[$i]."' And day='".$yesterday."'";
            $total = Database::getNoClass(static::$_db, $scpi2, [])[0][0];
            $tabTotalDay[]=$total;
            switch($tab[$i]) {
                case "Epargnant Barbu":
                    $tabTotalDay[] = "https://www.meilleurescpi.com/investir-en-scpi/328723-contact";
                    break;
                case "Epargnant Vieux":
                    $tabTotalDay[] = "https://www.meilleurescpi.com/investir-en-scpi/323723-contact";
                    break;
                case "Epargnant Couple":
                    $tabTotalDay[] = "https://www.meilleurescpi.com/investir-en-scpi/328753-contact";
                    break;
                case "Epargnant Boxeur":
                    $tabTotalDay[] = "https://www.meilleurescpi.com/investir-en-scpi/322723-contact";
                    break;
                case "Epargnant Militaire":
                    $tabTotalDay[] = "https://www.meilleurescpi.com/investir-en-scpi/322724-contact";
                    break;
                case "Investir En SCPI":
                    $tabTotalDay[] = "https://www.meilleurescpi.com/investir-en-scpi/";
                    break;
            }
            for($j=0; $j<11; $j++){
                $yesterday = date("Y-m-d", mktime(1, 1, 1, date("m"), date("d") - $j, date("Y")));
                $scpi2="SELECT Count(*) FROM `guide_list_api_scpi` WHERE type='".$landing."' And type_complement = '".$tab[$i]."' And day='".$yesterday."'";
                $total = Database::getNoClass(static::$_db, $scpi2, [])[0][0];
                $tabTotalDay[]=$total;
            }
            $tabFinal[$tab[$i]]=$tabTotalDay;
        }
        return ($tabFinal);
    }

    public static function getNbrByLandingCreationCompte($landing) {
        $tab=Array();
        $tabFinal=Array();
        $tabScpi[0]="Facebook";
        $tabScpi[1]="Twitter";
        $tabScpi[2]="Linxo";
        $tabScpi[3]="Linkedin";
        $max = sizeof($tabScpi);
        for($i = 0; $i < $max; $i++)
        {
            $tab[]=$tabScpi[$i];
        }
        $max2 = sizeof($tab);
        for($i = 0; $i < $max2;$i++)
        {
            $tabTotalDay=Array();
            $yesterday = date("Y-m-d", mktime(1, 1, 1, date("m"), date("d"), date("Y")));
            $scpi2="SELECT Count(*) FROM `guide_list_api_scpi` WHERE type='".$landing."' And type_complement = '".$tab[$i]."' And day='".$yesterday."'";
            $total = Database::getNoClass(static::$_db, $scpi2, [])[0][0];
            $tabTotalDay[]=$total;
            switch($tab[$i]) {
                case "Facebook":
                    $tabTotalDay[] = "https://moncompte.meilleurescpi.com/index.php?p=LandingF";
                    break;
                case "Twitter":
                    $tabTotalDay[] = "https://moncompte.meilleurescpi.com/index.php?p=LandingT";
                    break;
                case "Linxo":
                    $tabTotalDay[] = "https://moncompte.meilleurescpi.com/index.php?p=LandingL";
                    break;
                case "Linkedin":
                    $tabTotalDay[] = "https://moncompte.meilleurescpi.com/index.php?p=LandingL";
                    break;
            }
            for($j=0; $j<11; $j++){
                $yesterday = date("Y-m-d", mktime(1, 1, 1, date("m"), date("d") - $j, date("Y")));
                $scpi2="SELECT Count(*) FROM `guide_list_api_scpi` WHERE type='".$landing."' And type_complement = '".$tab[$i]."' And day='".$yesterday."'";
                $total = Database::getNoClass(static::$_db, $scpi2, [])[0][0];
                $tabTotalDay[]=$total;
            }
            $tabFinal[$tab[$i]]=$tabTotalDay;
        }
        return ($tabFinal);
    }

    public static function getNbrPageGuides($landing) {
        $tab=Array();
        $tabFinal=Array();
        $tabScpi[0]="Télédéclaration";
        $max = sizeof($tabScpi);
        for($i = 0; $i < $max; $i++)
        {
            $tab[]=$tabScpi[$i];
        }
        $max2 = sizeof($tab);
        for($i = 0; $i < $max2;$i++)
        {
            $tabTotalDay=Array();
            $yesterday = date("Y-m-d", mktime(1, 1, 1, date("m"), date("d"), date("Y")));
            $scpi2="SELECT Count(*) FROM `guide_list_api_scpi` WHERE type='".$landing."' And type_complement = '".$tab[$i]."' And day='".$yesterday."'";
            $total = Database::getNoClass(static::$_db, $scpi2, [])[0][0];
            $tabTotalDay[]=$total;
            $tabTotalDay[]="https://www.meilleurescpi.com/scpi/le-guide-la-scpi/";
            for($j=0; $j<11; $j++){
                $yesterday = date("Y-m-d", mktime(1, 1, 1, date("m"), date("d") - $j, date("Y")));
                $scpi2="SELECT Count(*) FROM `guide_list_api_scpi` WHERE type='".$landing."' And type_complement = '".$tab[$i]."' And day='".$yesterday."'";
                $total = Database::getNoClass(static::$_db, $scpi2, [])[0][0];
                $tabTotalDay[]=$total;
            }
            $tabFinal[$tab[$i]]=$tabTotalDay;
        }
        return ($tabFinal);
    }

}
