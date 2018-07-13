<?php
require_once("core/Database.php");
require_once("core/Table.php");

class SituationFiscaleMorale extends Table
{
	protected static		$_name = "SITUATION FISCALE MORALE";
	protected static		$_primary_key = "id";

	public static function insertNew($id_situation, $date_situation, $date_fin_situation,
		$regime_imposition,
		$frottement_regime
	) {
		$req = "INSERT INTO `SITUATION FISCALE MORALE` (id_situation, date_situation, date_fin_situation, 
			regime_imposition,
			frottement_regime
		)
			VALUES(?, ?, ?, ?, ?);";
		$data = array(
			$id_situation,
			$date_situation,
			$date_fin_situation,
			$regime_imposition,
			$frottement_regime
		);
		Situation::getFromId($id_situation)[0]->updateOneColumn("resetSituationFiscale", 0);
		$id = Database::prepareInsert(static::$_db, $req, $data);
		return ($id);
	}
	public static function updateOne($id, $date_situation, $date_fin_situation, $residence_france, $taux_marginal_imposition, $impots_annee_precedente, $nbr_parts_fiscales, $tranche_isf, $montant_impot_isf) {
		$req = "UPDATE `SITUATION FISCALE MORALE` SET date_situation = ?, date_fin_situation = ?, residence_france = ?, taux_marginal_imposition = ?, impots_annee_precedente = ?, nbr_parts_fiscales = ?, tranche_isf = ?, montant_impot_isf = ? WHERE id = ?";
		$data = array(
			$date_situation,
			$date_fin_situation,
			$residence_france,
			$taux_marginal_imposition,
			$impots_annee_precedente,
			$nbr_parts_fiscales,
			$tranche_isf,
			$montant_impot_isf,
			$id
		);
		$id = Database::prepareInsert(static::$_db, $req, $data);
		return ($id);
	}
	public static function getFromPdId($PpId) {
		return (parent::getFromKeyValue("id_situation", $PpId));
	}
	public static function getFromDh($id_dh) {
		$req = "SELECT `SITUATION FISCALE MORALE`.* FROM `SITUATION FISCALE MORALE` INNER JOIN `situation` ON `SITUATION FISCALE MORALE`.id_situation = `situation`.id WHERE `situation`.id_dh = ?";
		$data = array(
			$id_dh
		);
		return Database::prepare(static::$_db, $req, $data, 'SituationFiscaleMorale');
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
	public static function getLastFromPpId($PpId) {
		$req = "SELECT * FROM `" . self::$_name . "` WHERE id_situation = ? ORDER BY date_situation DESC LIMIT 1";
		$data = array($PpId);
		$rt = Database::prepare(static::$_db, $req, $data, 'SituationFiscaleMorale');
		if (count($rt))
			return ($rt[0]);
		else
			return (null);
	}
	public function isValide() {
		return (time() < ($this->getDateSituation()->getTimestamp() + TIME_SITUATION_VALID));
	}
	public function getRegimeImposition() {
		return ($this->regime_imposition);
	}
	public function getFrottementRegime() {
		return ($this->frottement_regime);
	}
}
