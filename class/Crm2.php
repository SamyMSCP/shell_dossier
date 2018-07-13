<?php
require_once("core/Database.php");
require_once("core/Table.php");
require_once("AutoTask.php");
class Crm2 extends Table {
	protected static	$_name = "crm2";
	protected static	$_primary_key = "id";
	public static		$_noSecure = ["commentaire", "lstIdProject"];

	public static		$_contacts = [
		[
			"id" => 0,
			"name" => "Téléphone",
			"img" => "Phone_BleuClair.png",
			"img2" => "Phone_Blanc.png"
		],
		[
			"id" => 1,
			"name" => "E-mail",
			"img" => "Email_BleuClair.png",
			"img2" => "Email_Blanc.png"
		],
		[
			"id" => 2,
			"name" => "Lettre",
			"img" => "Enveloppe_BleuClair.png",
			"img2" => "Enveloppe_Blanc.png"
		],
		[
			"id" => 3,
			"name" => "En personne",
			"img" => "Gender_Homme.png",
			"img2" => "Gender-blanc_Homme.png"
		],
	];

	public static		$_sujets  = [
		[
			"id" => 0,
			"name" => "Guide",
			"img" => ""
		],
		[
			"id" => 1,
			"name" => "Relance",
			"img" => ""
		],
		[
			"id" => 2,
			"name" => "Proposition",
			"img" => ""
		],
		[
			"id" => 3,
			"name" => "Souscription",
			"img" => ""
		],
		[
			"id" => 4,
			"name" => "Création de compte",
			"img" => ""
		],
		[
			"id" => 5,
			"name" => "Suivi",
			"img" => ""
		],
		[
			"id" => 6,
			"name" => "Avis client",
			"img" => ""
		],
		[
			"id" => 7,
			"name" => "Actualités",
			"img" => ""
		],
		[
			"id" => 8,
			"name" => "Opportunité",
			"img" => ""
		],
		[
			"id" => 9,
			"name" => "Fin de demembrement",
			"img" => ""
		],

        [
            "id" => 10,
            "name" => "Demande site",
            "img" => ""
        ]
	];

	public static function insertNew(
		$id_client,
		$sujetSelected,
		$contactSelected,
		$date_execution,
		$duree,
		$commentaire,
		$lstIdProject,
		$isOkay
	) {
		$req = "INSERT INTO `crm2` (
			id_client,
			sujetSelected,
			contactSelected,
			date_execution,
			duree,
			commentaire,
			lstIdProject,
			date_creation,
			date_modification,
			id_autotask,
			isOkay,
			id_user,
			id_executant
		) VALUES (
			:id_client,
			:sujetSelected,
			:contactSelected,
			:date_execution,
			:duree,
			:commentaire,
			:lstIdProject,
			:date_creation,
			:date_modification,
			:id_autotask,
			:isOkay,
			:id_user,
			:id_executant
		)";
		if (is_array($lstIdProject))
		    $lstIdProject = serialize($lstIdProject);
		$id_autotask = 0;

		// Utilisateur pour la notif et l'executant
		$id_user = Dh::getById($id_client)->getConseiller()->id_dh;

		$currentDh = Dh::getCurrent();

		if (!empty($currentDh))
		// Crm Ajouté par u utilisateur connecté
		{
			// Id pour l'inscription au log
			$id_log  = $currentDh->id_dh;
		}
		else
		// Crm Ajouté automatiquement
		{
			// Id pour l'inscription au log
			$id_log  = 0;
		}

		if ($isOkay != 1)
		{
			//$dh = Dh::getCurrent();
			$client = Dh::getById($id_client);
			$titre = $client->getShortName();
			$comment = self::$_contacts[$contactSelected]['name'] . " " . self::$_sujets[$sujetSelected]['name'] . "<br />" . $commentaire;
			/*
			$id_autotask = AutoTask::insertSpotTask($id_user, "Notifications", "sendToDhWithTemplateForTask", [
					'dh' => $id_user,
					'title' => $titre,
					'content' => $comment,
					'templateId' => 1,
					'link' => '?p=EditionClient&client=' . $id_client . "&onglet=SUIVI"
				],
				$date_execution - TIME_BEFORE_NOTIFICATIONS);
			*/
		}
		$data = [
			"id_client" => $id_client,
			"sujetSelected" => $sujetSelected,
			"contactSelected" => $contactSelected,
			"date_execution" => $date_execution,
			"duree" => $duree,
			"commentaire" => $commentaire,
			"lstIdProject" => $lstIdProject,
			"date_creation" => time(),
			"date_modification" => time(),
			"id_autotask" => $id_autotask,
			"isOkay" => $isOkay,
			"id_user" => $id_user,
			"id_executant" => $id_log
				];

		$nCrm = Database::prepareInsertCheckSecurity(static::$_db, $req, $data, get_called_class());

		if ($isOkay != 1)
		{
			/*
			   AutoTask::getFromId($id_autotask)[0]->updateOneColumnCheckSecurity("arguments", serialize([
			   'dh' => $id_user,
			   'title' => $titre,
			   'content' => $comment,
			   'templateId' => 1,
			   'id_crm' => $nCrm,
			   'link' => '?p=EditionClient&client=' . $id_client . '&onglet=SUIVI&id_crm=' . $nCrm]));
			 */
			$params = [
				"id_autotask" => $id_autotask,
				"id_crm" => $nCrm,
				"status" => "a faire",
				"contact" => self::$_contacts[$contactSelected]['name'],
				"sujet" => self::$_sujets[$sujetSelected]['name'],
				"date execution" => ((new DateTime())->setTimestamp($date_execution))->format("d/m/Y H:i:s"),
				"commentaire" => $comment
			];
			Logger::setNew("Ajout d'une tache Crm", $id_log, $id_client, $params);
		}
		else
		{
			$params = [
				"status" => "fait",
				"contact" => self::$_contacts[$contactSelected]['name'],
				"sujet" => self::$_sujets[$sujetSelected]['name'],
				"date execution" => ((new DateTime())->setTimestamp($date_execution))->format("d/m/Y H:i:s"),
				"commentaire" => $commentaire
			];
			Notifications::setSeeForCrm($nCrm);
			Logger::setNew("Ajout d'une tache Crm", $id_user, $id_client, $params);
		}
		return ($nCrm);
	}
	public static function getNotOkayFromDh($id_client) {
		return (parent::getFromKeysValues([
			"id_client" => $id_client,
			"isOkay" => 0
		]));
	}
	public static function getFromDh($id_client) {
		return (parent::getFromKeyValue("id_client", $id_client));
	}
	public static function getFromDhForStore($id_client) {
		$rt = parent::getFromKeyValue("id_client", $id_client);
		foreach ($rt as $key => $elm)
		{
			$rt[$key]->projectsId = unserialize($rt[$key]->getLstProject());
		}
		return ($rt);
	}
	public static function getForConseillerForStore($id_conseiller) {

		$dh = Dh::getById($id_conseiller);
		$time = time() + (60 *60 * 24);
		$time2 = time() + (60 *60 * 24 * 7);
		$req = "SELECT crm2.*, `DONNEUR D'ORDRE`.conseiller FROM `crm2` LEFT JOIN `DONNEUR D'ORDRE` ON crm2.id_client = `DONNEUR D'ORDRE`.`id_dh` WHERE  (isOkay = 0 OR isOkay IS NULL) AND `DONNEUR D'ORDRE`.`conseiller` = " . $id_conseiller . " AND date_execution <= " . $time . " ORDER BY date_execution; ";
		if ($id_conseiller == 1 || $dh->getType() == "assistant")
			$req = "SELECT crm2.*, `DONNEUR D'ORDRE`.conseiller FROM `crm2` LEFT JOIN `DONNEUR D'ORDRE` ON crm2.id_client = `DONNEUR D'ORDRE`.`id_dh` WHERE  (isOkay = 0 OR isOkay IS NULL) AND date_execution <= " . $time;
		if ($dh->getType() == "prospecteur")
			$req = "SELECT crm2.*, `DONNEUR D'ORDRE`.conseiller FROM `crm2` LEFT JOIN `DONNEUR D'ORDRE` ON crm2.id_client = `DONNEUR D'ORDRE`.`id_dh` WHERE  (isOkay = 0 OR isOkay IS NULL) AND (`DONNEUR D'ORDRE`.ko IS NULL OR `DONNEUR D'ORDRE`.ko = 0) AND date_execution <= " . $time2;
		$tab = Database::query(static::$_db, $req, get_called_class());
		$rt = [];
		foreach ($tab as $key => $elm)
		{
			//$rt[$key]->projectsId = unserialize($rt[$key]->getLstProject());
			//$rt[$key]->clientShortName = Dh::getById($rt[$key]->id_client)->getShortName();
			$rt[$key] = $tab[$key]->getForStore();
		}
		return ($rt);
	}
	public function getForStore() {
		$rt = $this;
		$rt->projectsId = mb_unserialize($rt->getLstProject());
		$rt->clientShortName = Dh::getById($rt->id_client)->getShortName();
		if(isset($rt->conseiller) && $rt->conseiller > 1)
			$rt->conseillerShortName  = Dh::getById($rt->conseiller)->getShortName();
		$executant = Dh::getById($rt->id_executant);
		$rt->executantShortName = !empty($executant) ? $executant->getShortName() : "system";
		return ($rt);
	}
	public static function getProjects() {

	}
	public function getClient() {
		if (!empty($this->id_client))
			return (Dh::getById($this->id_client));
	}
	public function getIdClient() {
		return ($this->id_client);
	}
	public function getSujetSelected() {
		return ($this->sujetSelected);
	}
	public function getContactSelected() {
		return ($this->contactSelected);
	}
	public function getDateExecution() {
		return ($this->date_execution);
	}
	public function getDateEnd() {
		return ($this->date_end);
	}
	public function getSujetSelectedStr() {
		return (self::$_sujets[$this->sujetSelected]['name']);
	}
	public function getContactSelectedStr() {
		return (self::$_contacts[$this->contactSelected]['name']);
	}
	public function getDateExecutionDateTime() {
		$rt = new Datetime;
		$rt->setTimestamp($this->date_execution);
		return ($rt);
	}
	public function getCommentaire() {
		return ($this->commentaire);
	}
	public function getLstProject() {
		return ($this->lstIdProject);
	}
	public function getAutoTask() {
		$rt = AutoTask::getFromId($this->id_autotask);
		if (count($rt) > 0)
			return ($rt[0]);
		return (null);
	}
	public static function getNotCompleteForDh($id_dh) {
		$dh = Dh::getById($id_dh);
		$curTime = new Datetime();
		$curTime->setTimestamp(time());
		$curTime->setTime(0, 0, 0);
		$curTime = $curTime->getTimestamp();
		$curTime += 24 * 60 * 60;
		$req = "SELECT crm2.*, `DONNEUR D'ORDRE`.conseiller FROM `crm2` LEFT JOIN `DONNEUR D'ORDRE` ON crm2.id_client = `DONNEUR D'ORDRE`.`id_dh` WHERE date_execution < " . $curTime . " AND isOkay = 0 AND `DONNEUR D'ORDRE`.`conseiller` = " . $id_dh . " ORDER BY date_execution;";
		if ($id_dh == 1 || $dh->getType() == "assistant" || $dh->getType() == "prospecteur")
			$req = "SELECT crm2.*, `DONNEUR D'ORDRE`.conseiller FROM `crm2` LEFT JOIN `DONNEUR D'ORDRE` ON crm2.id_client = `DONNEUR D'ORDRE`.`id_dh` WHERE date_execution < " . $curTime . " AND isOkay = 0 ORDER BY date_execution;";
		return Database::query(static::$_db, $req, get_called_class());
	}

	public function getPrioritaireByConseiller($idConseiller) {
		$tsDebut = Datetime::createFromFormat("d/m/Y H:i:s" ,date("d/m/Y") . " 00:00:00")->getTimestamp();
		$tsFin = Datetime::createFromFormat("d/m/Y H:i:s" ,date("d/m/Y") . " 23:59:59")->getTimestamp();
		$req = "SELECT crm2.*, `DONNEUR D'ORDRE`.conseiller FROM `crm2` LEFT JOIN `DONNEUR D'ORDRE` ON crm2.id_client = `DONNEUR D'ORDRE`.`id_dh` WHERE date_execution > " . $tsDebut . " AND date_execution < " . $tsFin . " AND priority > 3 AND isOkay = 0 AND `DONNEUR D'ORDRE`.`conseiller` = " . $idConseiller . " ORDER BY date_execution;";
		return Database::query(static::$_db, $req, get_called_class());
	}
	public function getLateForConseiller($idConseiller) {
		$tsFin  = Datetime::createFromFormat("d/m/Y H:i:s" ,date("d/m/Y") . " 00:00:00")->getTimestamp();
		$req = "SELECT crm2.*, `DONNEUR D'ORDRE`.conseiller FROM `crm2` LEFT JOIN `DONNEUR D'ORDRE` ON crm2.id_client = `DONNEUR D'ORDRE`.`id_dh` WHERE date_execution < " . $tsFin . " AND priority > 3 AND isOkay = 0 AND `DONNEUR D'ORDRE`.`conseiller` = " . $idConseiller . " ORDER BY date_execution;";
		return Database::query(static::$_db, $req, get_called_class());
	}
	public static function getLastOkayForClient($id_client) {
		$req = "SELECT * FROM `crm2` WHERE id_client = ? AND isOkay = 1 ORDER BY date_end DESC LIMIT 1;";
		$data = [
			$id_client
		];
		return (Database::prepareCheckSecurity(static::$_db, $req, $data, get_called_class()));
	}
	public function getNextNotOkayForClient($id_client) {
			$req = "SELECT * FROM `crm2` WHERE id_client = ? AND isOkay != 1 ORDER BY date_execution LIMIT 1;";
		$data = [
			$id_client
		];
		return (Database::prepareCheckSecurity(static::$_db, $req, $data, get_called_class()));
	}
	public static function setToDhForLogs($datas)
	{
		extract($datas);
		return (self::insertNew(
			$dh,
			$sujet,
			$contact,
			$date_execution,
			$duree,
			$commentaire,
			$projects,
			$isOkay
		));
	}
	public function setOkay() {
		Notifications::setSeeForCrm($this->id);
		$this->updateOneColumn('isOkay', 1);
	}
}
