<?php
require_once("core/Database.php");
require_once("core/Table.php");
require_once("core/Cache.php");
require_once("Transaction.php");
require_once("Dh.php");

class Beneficiaire extends Table
{
	use Cache;
	use DocumentTrait;
	private					$_myTransaction = null;
	protected static		$_name = "BENEFICIAIRE";
	protected static		$_primary_key = "id_benf";

	private					$_projects = null;
	private					$_lstSCPI = null;
	private					$_myDistinctTransaction;
	private					$_lstTransaction = null;

	public static function insertIsPm($id_dh, $id_Pm) {
		$req = "INSERT INTO `BENEFICIAIRE` 
			(id_dh, type_ben)
			VALUES (?, ?)";
		$data = array(
			$id_dh,
			"Pm"
		);
		$id_beneficiaire = Database::prepareInsert(static::$_db, $req, $data);
		if(empty($id_beneficiaire))
			return (null);
		if ($id_Pm)
		{
			$req = "INSERT INTO `BENEFICIAIRE_PERSONNE` 
				(lien_bf, lien_pm)
				VALUES (?, ?)";
			$data = array(
				$id_beneficiaire,
				intval($id_Pm)
			);
			$id_beneficiaire_personne = Database::prepareInsert(static::$_db, $req, $data);
		}
		if(empty($id_beneficiaire_personne))
			return (false);
		else
			return ($id_beneficiaire);
	}
	public static function insertIsPp($id_dh, $type_beneficiaire, $lst_Pp = null) {
		$req = "INSERT INTO `BENEFICIAIRE` 
			(id_dh, type_ben)
			VALUES (?, ?)";
		$data = array(
			$id_dh,
			$type_beneficiaire
		);
		$id_beneficiaire = Database::prepareInsert(static::$_db, $req, $data);
		if(empty($id_beneficiaire))
			return (null);
		if ($lst_Pp)
		{
			foreach($lst_Pp as $elm)
			{
				$req = "INSERT INTO `BENEFICIAIRE_PERSONNE` 
					(lien_bf, lien_pp)
					VALUES (?, ?)";
				$data = array(
					$id_beneficiaire,
					intval($elm)
				);
				$id_beneficiaire_personne = Database::prepareInsert(static::$_db, $req, $data);
			}
		}
		if(empty($id_beneficiaire_personne))
			return (false);
		else
			return ($id_beneficiaire);
	}
	public static function insertFromRelation( $id_dh, $rel_beneficiaire, $lst_personne = [])
	{
		$type_beneficiaire = null;
		if ($rel_beneficiaire == "null" || $rel_beneficiaire == "seul" || $rel_beneficiaire == "conjoint" || $rel_beneficiaire == "enfant" || $rel_beneficiaire == "parent")
			$type_beneficiaire = 'seul';
		else if ($rel_beneficiaire == "couple" || $rel_beneficiaire == "parents")
			$type_beneficiaire = 'couple';
		else if ($rel_beneficiaire == "employeur" || $rel_beneficiaire == "employe")
			$type_beneficiaire = 'Pm';
		$req = "INSERT INTO `BENEFICIAIRE` (`id_dh`, `type_ben`, `type_relation`) VALUES (?, ?, ?)";
		$id_beneficiaire = Database::prepareInsert(static::$_db, $req, [$id_dh, $type_beneficiaire, $rel_beneficiaire]);
		if (empty($id_beneficiaire))
			return null;
		if (!empty($lst_personne))
		{
			if ($type_beneficiaire == 'Pm')
			{
				//IDs des PM à lier au bénéficiaire
				foreach ($lst_personne as $pm)
				{
					$req = "INSERT INTO `BENEFICIAIRE_PERSONNE` (`lien_bf`,`lien_pm`) VALUES (?, ?)";
					$rt = Database::prepareInsert(static::$_db, $req, [$id_beneficiaire, $pm]);
				}
			}
			else
			{
				// IDs des PP à lier au bénéficiaire
				foreach ($lst_personne as $pp)
				{
					$req = "INSERT INTO `BENEFICIAIRE_PERSONNE` (`lien_bf`,`lien_pp`) VALUES (?, ?)";
					$rt = Database::prepareInsert(static::$_db, $req, [$id_beneficiaire, $pp]);
				}
			}
			return $id_beneficiaire;
		}
		return false;
	}
	public static function getById($id) {
		$rt = parent::getFromKeyValue("id_benf", $id);
		if (count($rt))
			return $rt[0];
		return (null);
	}
	public function getSituationsId() {
		$rt = array();
		/*
		foreach ($this->getPersonnePhysique() as $key => $elm)
		{
			if (!in_array($elm->getOrCreateSituation(), $rt))
				$rt[] = $elm->getOrCreateSituation();
		}
		*/
		return ($rt);
	}
	public function getSituationsJuridiqueId() {
		$rt = array();
		foreach ($this->getPersonnePhysique() as $key => $elm)
		{
			foreach ($elm->getSituationJuridiqueId() as $key2 => $elm2)
			{
				if (!in_array($elm2->id, $rt))
				{
					$rt[] = $elm2->id;
				}
			}
		}
		return ($rt);
	}
	public function getSituationsFiscaleId() {
		$rt = array();
		foreach ($this->getPersonnePhysique() as $key => $elm)
		{
			foreach ($elm->getSituationFiscaleId() as $key2 => $elm2)
			{
				if (!in_array($elm2->id, $rt))
				{
					$rt[] = $elm2->id;
				}
			}
		}
		return ($rt);
	}
	public function getSituationsFinanciereId() {
		$rt = array();
		foreach ($this->getPersonnePhysique() as $key => $elm)
		{
			foreach ($elm->getSituationFinanciereId() as $key2 => $elm2)
			{
				if (!in_array($elm2->id, $rt))
				{
					$rt[] = $elm2->id;
				}
			}
		}
		return ($rt);
	}
	public function getSituationsPatrimonialeId() {
		$rt = array();
		foreach ($this->getPersonnePhysique() as $key => $elm)
		{
			foreach ($elm->getSituationPatrimonialeId() as $key2 => $elm2)
			{
				if (!in_array($elm2->id, $rt))
				{
					$rt[] = $elm2->id;
				}
			}
		}
		return ($rt);
	}
	public static function getFromPersonnePhysique($idPp) {
		$req = "SELECT `BENEFICIAIRE`.* FROM `BENEFICIAIRE` INNER JOIN `BENEFICIAIRE_PERSONNE` ON `BENEFICIAIRE`.id_benf = `BENEFICIAIRE_PERSONNE`.lien_bf WHERE `BENEFICIAIRE_PERSONNE`.lien_pp = ?";
		$data = array(
			$idPp
		);
		return Database::prepare(static::$_db, $req, $data, 'Beneficiaire');
	}
	public static function getCoupleFromPersonnePhysique($idPp) {
		$req = "SELECT `BENEFICIAIRE`.* FROM `BENEFICIAIRE` INNER JOIN `BENEFICIAIRE_PERSONNE` ON `BENEFICIAIRE`.id_benf = `BENEFICIAIRE_PERSONNE`.lien_bf WHERE `BENEFICIAIRE_PERSONNE`.lien_pp = ? AND `BENEFICIAIRE`.type_ben = 'couple'";
		$data = array(
			$idPp
		);
		return Database::prepare(static::$_db, $req, $data, 'Beneficiaire');
	}
	public static function getSeulFromPersonnePhysique($idPp) {
		$req = "SELECT `BENEFICIAIRE`.* FROM `BENEFICIAIRE` INNER JOIN `BENEFICIAIRE_PERSONNE` ON `BENEFICIAIRE`.id_benf = `BENEFICIAIRE_PERSONNE`.lien_bf WHERE `BENEFICIAIRE_PERSONNE`.lien_pp = ? AND `BENEFICIAIRE`.type_ben = 'seul'";
		$data = array(
			$idPp
		);
		return Database::prepare(static::$_db, $req, $data, 'Beneficiaire');
	}
	public static function getFromPersonneMorale($idPm) {
		$req = "SELECT `BENEFICIAIRE`.* FROM `BENEFICIAIRE` INNER JOIN `BENEFICIAIRE_PERSONNE` ON `BENEFICIAIRE`.id_benf = `BENEFICIAIRE_PERSONNE`.lien_bf WHERE `BENEFICIAIRE_PERSONNE`.lien_pm = ?";
		$data = array(
			$idPm
		);
		return Database::prepare(static::$_db, $req, $data, 'Beneficiaire');
	}
	public function getDh() {
		$rt = Dh::getById($this->id_dh);
		if ($rt)
			return ($rt);
		return (null);
	}
	public function getTransaction() {
		if ($this->_myTransaction == null)
		{
			$this->_myTransaction = Transaction::getFromKeyValue("id_donneur_ordre", $this->id_benf);
		}
		return ($this->_myTransaction);
	}
	public static function getFromDh($id_dh) {
		return parent::getFromKeyValue("id_dh", $id_dh);
	}
	public function getPersonnes() {
		if ($this->type_ben == "Pm")
			return ($this->getPersonneMorale());
		return ($this->getPersonnePhysique());

	}
	public function getTypeRelation() {
		return $this->type_relation;
	}
	public function getPersonnePhysique() {
		return (Pp::getFromBeneficiaire($this->id_benf));
	}
	public function getPersonneMorale() {
		return (Pm::getFromBeneficiaire($this->id_benf));
	}
	public function getProjects() {
		if ($this->_projects == null)
		{
			$this->_projects = Projet::getFromBeneficiaire($this->id_benf);
		}
		return ($this->_projects);
	}
	public function getProjectsId() {
		$rt = array();
		foreach ($this->getProjects() as $key =>$elm)
		{
			$rt[] = $elm->id;
		}
		return ($rt);
	}
	public function getShortName() {
		if ($this->type_ben == "seul")
		{
			if (!isset($this->getPersonnePhysique()[0]))
				return ("-");
			$pp = $this->getPersonnePhysique()[0];
			return ($pp->getCiviliteFormat() . " " . $pp->getFirstName() . " " . $pp->getName());
		}
		else if ($this->type_ben == "couple")
		{
			if (
				!isset($this->getPersonnePhysique()[0]) || 
				!isset($this->getPersonnePhysique()[1])
			)
				return ("-");
			$pp = $this->getPersonnePhysique()[0];
			$pp2 = $this->getPersonnePhysique()[1];
			$rt = $pp->getCiviliteFormat() . " " . $pp->getFirstName() . " " . $pp->getName() . " & " . $pp2->getCiviliteFormat() . " " . $pp2->getFirstName() . " " . $pp2->getName();;
			return ($rt);
		}
		else if ($this->type_ben == "Pm")
		{
			if (!isset($this->getPersonneMorale()[0]))
				return ("-");
			$pm = $this->getPersonneMorale()[0];
			return ($pm->getDenominationSociale());
		}
	}
	public function getDistinctTransaction() {
		if ($this->_myDistinctTransaction == null)
		{
			$this->_myDistinctTransaction = Transaction::getDistinctTransactionBeneficiaire($this->id_benf);
			usort($this->_myDistinctTransaction, array("Dh", "cmp"));
		}
		return ($this->_myDistinctTransaction);
	}
	public function getSCPIs() {
		if ($this->_lstSCPI == null)
		{
			$this->_lstSCPI = Scpi::getFromArray(
				Transaction::getOnProperty("id_scpi", $this->getDistinctTransaction())
			);
		}
		// On renvoi un tableau contenant la liste des scpi que detiens le beneficiaire
		return ($this->_lstSCPI);
	}
	public function getLstTransaction() {
		if ($this->_lstTransaction == null) {
			$this->_lstTransaction = array();
			if ($this->getSCPIs()) {
				foreach ($this->getSCPIs() as $elm) {
					array_push($this->_lstTransaction, new LstTransaction($this->id_benf, $elm->id, null, true));
				}
			} else {
				$this->_lstTransaction = array();
			}
		}
		return ($this->_lstTransaction);
	}
	public function generateCacheArrayTable() {
		$lst = $this->getLstTransaction();
		$rt = LstTransaction::forGeneracteCache($lst);
	//	$rt['precalcul']['actualDividendes'] = $this->getDividendes();
		return ($rt);
	}
	public function getImgName() {
		if (count($this->getPersonnePhysique()) == 1)
		{
			$data = $this->getPersonnePhysique()[0];
			if ($data->getCivilite() === "Monsieur"){
				return ("Gender-blanc_Homme.png");
			}
			else if ($data->getCivilite() === "Madame")
			{
				return  ("Gender-blanc_Femme.png");
			}
		}
		else if (count($this->getPersonnePhysique()) > 1)
		{
			$homme = false;
			$femme = false;
			foreach ($this->getPersonnePhysique() as $key => $elmBen1)
			{
				if ($elmBen1->getCivilite() === "Monsieur")
					$homme = true;
				else if ($elmBen1->getCivilite() === "Madame")
					$femme = true;
			}
			if ($homme && $femme)
			{
				return ("Gender-blanc_F-H.png");
			}
			else if ($homme)
			{
				return ("Gender-blanc_H-H.png");
			}
			else if ($femme)
			{
				return ("Gender-blanc_F-F.png");
			}
		}
		else if (count($this->getPersonneMorale()))
		{
			return ("Societe_blanc.png");
		}
		return ("");
	}
	public function getTypeBeneficiaire() {
		return ($this->type_ben);
	}
	public function getTypeBeneficiaireForTable() {
		if ($this->type_ben == "seul" || $this->type_ben == "couple")
			return ("PP");
		else if ($this->type_ben == "Pm")
			return ("PM");
	}
	public function getTypePpStr() {
		if (count($this->getPersonnePhysique()) == 1)
		{
			$data = $this->getPersonnePhysique()[0];
			if ($data->getCivilite() === "Monsieur")
				return ("homme");
			else if ($data->getCivilite() === "Madame")
				return ("femme");
		}
		else if (count($this->getPersonnePhysique()) > 1)
		{
			$homme = false;
			$femme = false;
			foreach ($this->getPersonnePhysique() as $key => $elm1)
			{
				if ($elm1->getCivilite() === "Monsieur")
					$homme = true;
				else if ($elm1->getCivilite() === "Madame")
					$femme = true;
			}
			if ($homme && $femme)
				return ("femme-homme");
			else if ($homme)
				return ("homme-homme");
			else if ($femme)
				return ("femme-femme");
		}
		else if (count($this->getPersonneMorale()) == 1)
		{
			$data = $this->getPersonneMorale()[0];
				return ("entreprise");
		}
	}
	public function getForFrontStore() {
		$rt = [];
		$rt['id_benf'] = $this->id_benf;
		$rt['id_dh'] = $this->id_dh;
		$rt['type_ben'] = $this->type_ben;
		$rt['shortName'] = $this->getShortName();
		$rt['typePpStr'] = $this->getTypePpStr();
		//$rt['id_situation'] = $this->getPersonnes()[0]->getOrCreateSituation();
		$rt['personnes'] = [];
		foreach ($this->getPersonnes() as $key => $elm)
		{
			if (isset($elm->id_phs))
				$rt['personnes'][] = $elm->id_phs;//$elm->getForStore();
		}
		return ($rt);
	}
	public function getForStore() {
		$rt = [];
		$rt['id_benf'] = $this->id_benf;
		$rt['id_dh'] = $this->id_dh;
		$rt['type_ben'] = $this->type_ben;
		$rt['shortName'] = $this->getShortName();
		$rt['typePpStr'] = $this->getTypePpStr();
		//$rt['id_situation'] = $this->getPersonnes()[0]->getOrCreateSituation();
		$rt['imgName'] = $this->getImgName();

		$rt['personnes'] = [];
		foreach ($this->getPersonnes() as $key => $elm)
		{
			if (isset($elm->id_phs))
				$rt['personnes'][] = $elm->id_phs;//$elm->getForStore();
		}
		return ($rt);
	}
	public static function getFromDhForStore($id_dh) {
		$rt = [];
		foreach (self::getFromDh($id_dh) as $key => $elm)
		{
			$rt[] = $elm->getForStore();
		}
		return ($rt);
	}
	public function checkAuthorisation($dh) {
		return ($dh->id_dh == $this->id_dh);
	}
}
