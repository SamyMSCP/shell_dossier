<?php
require_once("core/Database.php");
require_once("core/Table.php");
require_once("Dh.php");

class Pm extends Table
{
//	protected static		$_db = "test";
	use DocumentTrait;
	protected static		$_name = "PERSONNE MORALE";
	protected static		$_primary_key = "id_pm";
	
	private					$_denomination_sociale = null;
	private					$_RCS = null;
	private					$_date_immatri = null;
	private					$_forme_juridique = null;
	private					$_siret = null;

	private					$_situationJuridique = null;
	private					$_situationFinanciere = null;
	private					$_situationFiscale = null;
	private					$_situationPatrimoniale = null;

	private					$_lastSituationJuridique = null;
	private					$_lastSituationFinanciere = null;
	private					$_lastSituationFiscale = null;
	private					$_lastSituationPatrimoniale = null;

	public static function create() {
		$rt = new Pp();
		$rt->_is_new = 1;
		return ($rt);
	}
	public static function insert($lien_dh, $denomination_sociale, $forme_juridique, $siret, $rcs, $date_immatri) {
		$req = "INSERT INTO `PERSONNE MORALE` 
			(lien_dh, dn_sociale, f_juridique, siret, rcs, date_immatri)
			VALUES (?, ?, ?, ?, ?, ?)";
		$data = array(
			$lien_dh,
			htmlspecialchars($denomination_sociale),
			htmlspecialchars($forme_juridique),
			htmlspecialchars($siret),
			htmlspecialchars($rcs),
			strtotime($date_immatri)
		);
		return Database::prepareInsert(static::$_db, $req, $data);
	}
	public static function insertMini($lien_dh, $denomination_sociale) {
		$req = "INSERT INTO `PERSONNE MORALE` 
			(lien_dh, dn_sociale)
			VALUES (?, ?)";
		$data = array(
			$lien_dh,
			htmlspecialchars($denomination_sociale)
		);
		return Database::prepareInsert(static::$_db, $req, $data);
	}
	public static function updateFromIdPm($id, $denomination_sociale, $forme_juridique, $siret, $rcs, $date_immatri) {
		$req = "UPDATE `PERSONNE MORALE` 
			set dn_sociale = ?,
			f_juridique = ?,
			siret = ?,
			rcs = ?,
			date_immatri = ? WHERE id_pm = " . $id;
		$data = array(
			htmlspecialchars($denomination_sociale),
			htmlspecialchars($forme_juridique),
			htmlspecialchars($siret),
			htmlspecialchars($rcs),
			strtotime($date_immatri)
		);
		return Database::prepareInsert(static::$_db, $req, $data);
	}
	public static function getAllFromDh($id_dh) {
		return parent::getFromKeyValue("lien_dh", $id_dh);
	}
	public static function getByDh($dh_id) {
		return parent::getFromKeyValue("id_phs", $dh_id)[0];
	}
	public function getId() {
		return $this->id;
	}
	public function getDh() {

	}
	public function getTransaction() {
		
	}
	public function getBeneficiaire() {
		return (Beneficiaire::getFromPersonneMorale($this->id_pm));
	}
	public function getDateimmatriculation() {
		if (empty($this->date_immatri))
			$this->_date_immatri = "";
		if ($this->_date_immatri == NULL)
			$this->_date_immatri = $this->date_immatri;
		return ($this->_date_immatri);
	}
	public function getRcs() {
		if (empty($this->rcs))
			$this->_RCS = "";
		if ($this->_RCS == NULL)
			$this->_RCS = htmlspecialchars($this->rcs);
		return ($this->_RCS);
	}
	public function getSiret() {
		if (empty($this->siret))
			$this->_siret = "";
		if ($this->_siret == NULL)
			$this->_siret = htmlspecialchars($this->siret);
		return ($this->_siret);
	}
	public function getFormeJuridique() {
		if (empty($this->f_juridique))
			$this->_forme_juridique = "";
		if ($this->_forme_juridique == NULL)
			$this->_forme_juridique = htmlspecialchars($this->f_juridique);
		return ($this->_forme_juridique);
	}
	public function getDenominationSociale() {
		if (empty($this->dn_sociale))
			$this->_denomination_sociale = "";
		if ($this->_denomination_sociale == NULL)
			$this->_denomination_sociale = htmlspecialchars($this->dn_sociale);
		return ($this->_denomination_sociale);
	}
	public static function getFromBeneficiaire($id_benf) {
		$req = "SELECT * FROM `PERSONNE MORALE` INNER JOIN `BENEFICIAIRE_PERSONNE` ON `PERSONNE MORALE`.id_pm = `BENEFICIAIRE_PERSONNE`.lien_pm WHERE `BENEFICIAIRE_PERSONNE`.lien_bf = " . $id_benf;
		return Database::prepare(static::$_db, $req, array(), get_called_class());
	}
	public function getOrCreateSituation() {
		if (empty($this->id_situation))
		{
			$ben = $this->getBeneficiaire();
			if (count($ben))
			{
				$id_situation = $ben[0]->getPersonneMorale()[0]->id_situation;
				if ($id_situation)
				{
					$this->id_situation = Situation::linkPm($id_situation, $this->id_pm);
					return ($this->id_situation);
				}
				else
				{
					$this->id_situation = Situation::insertNewPm($this->lien_dh, $this->id_pm);
					return ($this->id_situation);
				}
			}
			else
			{
				$this->id_situation = Situation::insertNewPm($this->lien_dh, $this->id_pm);
				return ($this->id_situation);
			}
		}
		return ($this->id_situation);
	}
	public function getResetSituation() {
		return Situation::getResetFromPpId($this->getOrCreateSituation());
	}
	public function getResetSituationJuridique() {
		return ($this->getResetSituation()->resetSituationJuridique);
	}
	public function getResetSituationFinanciere() {
		return ($this->getResetSituation()->resetSituationFinanciere);
	}
	public function getResetSituationFiscale() {
		return ($this->getResetSituation()->resetSituationFiscale);
	}
	public function getResetSituationPatrimoniale() {
		return ($this->getResetSituation()->resetSituationPatrimoniale);
	}
	public function resetAllSituation() {
		$situation = Situation::getFromId($this->getOrCreateSituation())[0];
		$situation->updateOneColumn("resetSituationJuridique", 1);
		$situation->updateOneColumn("resetSituationFinanciere", 1);
		$situation->updateOneColumn("resetSituationFiscale", 1);
		$situation->updateOneColumn("resetSituationPatrimoniale", 1);
	}
	public function getLastSituationJuridique() {
		if ($this->_lastSituationJuridique == null)
		{
			if (!empty($this->id_situation))
				$this->_lastSituationJuridique = SituationJuridiqueMorale::getLastFromPpId($this->getOrCreateSituation());
			else
				$this->_lastSituationJuridique = null;
		}
		return ($this->_lastSituationJuridique);
	}
	public function getLastSituationFinanciere() {
		if ($this->_lastSituationFinanciere == null)
		{
			if (!empty($this->id_situation))
				$this->_lastSituationFinanciere = SituationFinanciereMorale::getLastFromPpId($this->getOrCreateSituation());
			else
				$this->_lastSituationFinanciere = null;
		}
		return ($this->_lastSituationFinanciere);
	}
	public function getLastSituationPatrimoniale() {
		if ($this->_lastSituationPatrimoniale == null)
		{
			if (!empty($this->id_situation))
				$this->_lastSituationPatrimoniale = SituationPatrimonialeMorale::getLastFromPpId($this->getOrCreateSituation());
			else
				$this->_lastSituationPatrimoniale = null;
		}
		return ($this->_lastSituationPatrimoniale);
	}
	public function getLastSituationFiscale() {
		if ($this->_lastSituationFiscale == null)
		{
			if (!empty($this->id_situation))
				$this->_lastSituationFiscale = SituationFiscaleMorale::getLastFromPpId($this->getOrCreateSituation());
			else
				$this->_lastSituationFiscale = null;
		}
		return ($this->_lastSituationFiscale);
	}
	public function getSituationFinanciere() {
		if ($this->_situationFinanciere == null)
		{
			if (!empty($this->id_situation))
				$this->_situationFinanciere = SituationFinanciereMorale::getFromPdId($this->getOrCreateSituation());
			else
				$this->_situationFinanciere = array();
		}
		return ($this->_situationFinanciere);
	}
	public function getSituationPatrimoniale() {
		if ($this->_situationPatrimoniale == null)
		{
			if (!empty($this->id_situation))
				$this->_situationPatrimoniale = SituationPatrimonialeMorale::getFromPdId($this->getOrCreateSituation());
			else
				$this->_situationPatrimoniale = array();
		}
		return ($this->_situationPatrimoniale);
	}
	public function getSituationFiscale() {
		if ($this->_situationFiscale == null)
		{
			if (!empty($this->id_situation))
				$this->_situationFiscale = SituationFiscaleMorale::getFromPdId($this->getOrCreateSituation());
			else
				$this->_situationFiscale = array();
		}
		return ($this->_situationFiscale);
	}
	public function getSituationJuridiqueId() {
		$rt = $this->getSituationJuridique();
		return ($rt);
	}
	public function getSituationFinanciereId() {
		$rt = $this->getSituationFinanciere();
		return ($rt);
	}
	public function getSituationFiscaleId() {
		$rt = $this->getSituationFiscale();
		return ($rt);
	}
	public function getSituationPatrimonialeId() {
		$rt = $this->getSituationPatrimoniale();
		return ($rt);
	}
	public function getActivite() {
		return (htmlspecialchars($this->activite));
	}
	public function getRepresentant() {
		return (htmlspecialchars($this->representant));
	}
	public function getSiegeSocial() {
		return (htmlspecialchars($this->siege_social));
	}
	public function insertSituationJuridique($date_situation, $date_fin_situation,
		$activite,
		$representant,
		$qualite_de,
		$siege_social,
		$id_gerant
	) {
		return SituationJuridiqueMorale::insertNew(
			$this->getOrCreateSituation(),
			$date_situation,
			$date_fin_situation,
			$activite,
			$representant,
			$qualite_de,
			$siege_social,
			$id_gerant
		);
	}
	public function getGerant() {
		$rt = null;
		$last = $this->getLastSituationJuridique();
		if ($last && $last->id_gerant)
		{
			$rt = Pp::getFromKeyValue("id_phs", $last->id_gerant);
			if (count($rt))
				return ($rt[0]);
		}
		return (null);
	}
	public function getForStore() {
		$rt = [];
		$rt['id'] = $this->id_pm;
		$rt['shortName']= $this->getDenominationSociale();
		return ($rt);
	}
	public function checkAuthorisation($dh) {
		return ($dh->id_dh == $this->lien_dh);
	}
}
