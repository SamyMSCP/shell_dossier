<?php
require_once("core/Database.php");
require_once("core/Table.php");

class SituationPatrimonialeMorale extends Table
{
	protected static		$_name = "SITUATION PATRIMONIALE MORALE";
	protected static		$_primary_key = "id";

	/*
	fourchette_montant_patrimoine
	repartition_liquidite
	repartition_court
	repartition_long
	repartition_immobilier
	repartition_scpi
	repartition_autres
	futur_placement
	*/
	public static function insertNew($id_situation, $date_situation, $date_fin_situation, 
		$fourchette_montant_patrimoine,
		$futur_placement,
		$repartition_liquidite,
		$repartition_court,
		$repartition_long,
		$repartition_immobilier,
		$repartition_scpi,
		$repartition_autres
	) {
		$req = "INSERT INTO `SITUATION PATRIMONIALE MORALE` (id_situation, date_situation, date_fin_situation, 
			fourchette_montant_patrimoine,
			futur_placement,
			repartition_liquidite,
			repartition_court,
			repartition_long,
			repartition_immobilier,
			repartition_scpi,
			repartition_autres
		)
			VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";
		$data = array(
			$id_situation,
			$date_situation,
			$date_fin_situation,
			$fourchette_montant_patrimoine,
			$futur_placement,
			$repartition_liquidite,
			$repartition_court,
			$repartition_long,
			$repartition_immobilier,
			$repartition_scpi,
			$repartition_autres
		);
		Situation::getFromId($id_situation)[0]->updateOneColumn("resetSituationPatrimoniale", 0);
		$id = Database::prepareInsert(static::$_db, $req, $data);
		return ($id);
	}
	public static function updateOne($id, $date_situation, $date_fin_situation, $fourchette_montant_patrimoine, $repartition_patrimoine, $futur_placement) {
		$req = "UPDATE `SITUATION PATRIMONIALE MORALE` SET date_situation = ?, date_fin_situation = ?, fourchette_montant_patrimoine = ?, repartition_patrimoine = ?, futur_placement = ? WHERE id = ?";
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
		$rt = Database::prepare(static::$_db, $req, $data, 'SituationPatrimonialeMorale');
		if (count($rt))
			return ($rt[0]);
		else
			return (null);
	}
	public static function getFromDh($id_dh) {
		$req = "SELECT `SITUATION PATRIMONIALE MORALE`.* FROM `SITUATION PATRIMONIALE MORALE` INNER JOIN `situation` ON `SITUATION PATRIMONIALE MORALE`.id_situation = `situation`.id WHERE `situation`.id_dh = ?";
		$data = array(
			$id_dh
		);
		return Database::prepare(static::$_db, $req, $data, 'SituationPatrimonialeMorale');
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
	public function isValide() {
		return (time() < ($this->getDateSituation()->getTimestamp() + TIME_SITUATION_VALID));
	}
	public function getFuturPlacement() {
		return ($this->futur_placement);
	}
	public function getRepLiquidite() {
		return ($this->repartition_liquidite);
	}
	public function getRepCourt() {
		return ($this->repartition_court);
	}
	public function getRepLong() {
		return ($this->repartition_long);
	}
	public function getRepImmobilier() {
		return ($this->repartition_immobilier);
	}
	public function getRepScpi() {
		return ($this->repartition_scpi);
	}
	public function getRepAutres() {
		return ($this->repartition_autres);
	}
}
