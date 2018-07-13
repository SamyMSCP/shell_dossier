<?php
require_once("core/Database.php");
require_once("core/Table.php");

class SituationPatrimoniale extends Table
{
	protected static		$_name = "SITUATION PATRIMONIALE";
	protected static		$_primary_key = "id";

	/*
	fourchette_montant_patrimoine
	repartition_patrimoine
	futur_placement
	*/
	public static function insertNew($id_situation, $date_situation, $date_fin_situation, $fourchette_montant_patrimoine, $repartition_patrimoine, $futur_placement) {
	/*
		$req = "INSERT INTO `SITUATION PATRIMONIALE` (id_situation, date_situation, date_fin_situation, fourchette_montant_patrimoine,  futur_placement)
			VALUES(?, ?, ?, ?, ?);";
		$data = array(
			$id_situation,
			$date_situation,
			$date_fin_situation,
			$fourchette_montant_patrimoine,
			$futur_placement
		);
		Situation::getFromId($id_situation)[0]->updateOneColumn("resetSituationPatrimoniale", 0);
		$id = Database::prepareInsert(static::$_db, $req, $data);
		return ($id);
		*/
	}
	public static function insertNew2($id_situation, $date_situation, $date_fin_situation, $fourchette_montant_patrimoine, $futur_placement,
		$repartition_autres,
		$repartition_scpi,
		$repartition_immobilier_locatif,
		$repartition_residence_secondaire,
		$repartition_residence_principale,
		$repartition_assurance_vie,
		$repartition_PEA,
		$repartition_PEL
	) {

		$dh = Dh::getCurrent();
		if (empty($dh))
			$dh = 0;
		else
			$dh = $dh->id_dh;

		$req = "INSERT INTO `SITUATION PATRIMONIALE` (id_situation, date_situation, date_fin_situation, 
			fourchette_montant_patrimoine,
			futur_placement,
			repartition_autres,
			repartition_scpi,
			repartition_immobilier_locatif,
			repartition_residence_secondaire,
			repartition_residence_principale,
			repartition_assurance_vie,
			repartition_PEA,
			repartition_PEL,
			creator
		)
			VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";
		$data = array(
			$id_situation,
			$date_situation,
			$date_fin_situation,
			$fourchette_montant_patrimoine,
			$futur_placement,
			$repartition_autres,
			$repartition_scpi,
			$repartition_immobilier_locatif,
			$repartition_residence_secondaire,
			$repartition_residence_principale,
			$repartition_assurance_vie,
			$repartition_PEA,
			$repartition_PEL,
			$dh
		);
		Situation::getFromId($id_situation)[0]->updateOneColumn("resetSituationPatrimoniale", 0);
		$id = Database::prepareInsert(static::$_db, $req, $data);
		return ($id);
	}
	public static function updateOne($id, $date_situation, $date_fin_situation, $fourchette_montant_patrimoine, $repartition_patrimoine, $futur_placement) {
		$req = "UPDATE `SITUATION PATRIMONIALE` SET date_situation = ?, date_fin_situation = ?, fourchette_montant_patrimoine = ?, repartition_patrimoine = ?, futur_placement = ? WHERE id = ?";
		$data = array(
			$date_situation,
			$date_fin_situation,
			$fourchette_montant_patrimoine,
			$repartition_patrimoine,
			$futur_placement,
			$id
		);
		$id = Database::prepareInsert(static::$_db, $req, $data);
		return ($id);
	}
	public static function getFromPdId($PpId) {
		return (parent::getFromKeyValue("id_situation", $PpId));
	}
	public static function getLastFromPpId($PpId) {
		$req = "SELECT * FROM `" . self::$_name . "` WHERE id_situation = ? ORDER BY date_situation DESC LIMIT 1";
		$data = array($PpId);
		$rt = Database::prepare(static::$_db, $req, $data, 'SituationPatrimoniale');
		if (count($rt))
			return ($rt[0]);
		else
			return (null);
	}
	public static function getFromDh($id_dh) {
		$req = "SELECT `SITUATION PATRIMONIALE`.* FROM `SITUATION PATRIMONIALE` INNER JOIN `situation` ON `SITUATION PATRIMONIALE`.id_situation = `situation`.id WHERE `situation`.id_dh = ?";
		$data = array(
			$id_dh
		);
		return Database::prepare(static::$_db, $req, $data, 'SituationPatrimoniale');
	}
	public function getDateSituation() {
		$rt = new DateTime();
		$rt = $rt->setTimestamp($this->date_situation);
		return ($rt);
	}
	public function getDateFinSituation() {
		$rt = new DateTime();
		$rt = $rt->setTimestamp($this->date_fin_situation);
		return ($rt);
	}
	public function getFourchetteMontantPatrimoine() {
		return ($this->fourchette_montant_patrimoine);
	}
	public function getRepartitionPatrimoine() {
		return (0);
	}
	public function getFuturPlacement() {
		return ($this->futur_placement);
	}
	public function getFuturPlacementStr() {
		if ($this->futur_placement == 1)
			return ("moins 10 %");
		else if ($this->futur_placement == 2)
			return ("entre 10 % et 30 %");
		else if ($this->futur_placement == 3)
			return ("plus de 30 %");
		return ("-");
	}
	public function getRepResidenceSecondaire() {
		return ($this->repartition_residence_secondaire);
	}
	public function getRepImmobilierLocatif() {
		return ($this->repartition_immobilier_locatif);
	}
	public function getRepScpi() {
		return ($this->repartition_scpi);
	}
	public function getRepAutres() {
		return ($this->repartition_autres);
	}
	public function getRepResidencePrincipale() {
		return ($this->repartition_residence_principale);
	}
	public function getRepAssuranceVie() {
		return ($this->repartition_assurance_vie);
	}
	public function getRepPEA() {
		return ($this->repartition_PEA);
	}
	public function getRepPEL() {
		return ($this->repartition_PEL);
	}
	public function isValide() {
		return (time() < ($this->getDateSituation()->getTimestamp() + TIME_SITUATION_VALID));
	}
	public static function getFromDhForStore($id_dh) {
	//	return (self::getFromDh($id_dh));
		$rt = [];
		foreach (self::getFromDh($id_dh) as $key => $elm)
		{
			$rt[] = $elm->getForStore();
		}
		return ($rt);
	}
	public function getForStore() {
		$rt = $this;
		$rt->creatorShortName = $this->getCreatorStr();
		return ($rt);
	}
	public function getCreatorStr() {
		if ($this->creator == 0)
			return ("-");
		return (Dh::getById($this->creator)->getShortName());
	}
}
