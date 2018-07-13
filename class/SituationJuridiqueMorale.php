<?php
require_once("core/Database.php");
require_once("core/Table.php");

class SituationJuridiqueMorale extends Table
{
	protected static		$_name = "SITUATION JURIDIQUE MORALE";
	protected static		$_primary_key = "id";

	public static function insertNew($id_situation, $date_situation, $date_fin_situation, 
		$activite,
		$representant,
		$qualite_de,
		$siege_social,
		$id_gerant
	) {
		$req = "INSERT INTO `SITUATION JURIDIQUE MORALE` (id_situation, date_situation, date_fin_situation,
			activite,
			representant,
			qualite_de,
			siege_social,
			id_gerant
		)
			VALUES(?, ?, ?, ?, ?, ?, ?, ?);";
		$data = array(
			$id_situation,
			$date_situation,
			$date_fin_situation,
			$activite,
			$representant,
			$qualite_de,
			$siege_social,
			$id_gerant
		);
		Situation::getFromId($id_situation)[0]->updateOneColumn("resetSituationJuridique", 0);
		$id = Database::prepareInsert(static::$_db, $req, $data);
		return ($id);
	}
	public function getNationalite() {
		return (htmlspecialchars($this->nationalite));
	}
	public function getRcs() {
		return (htmlspecialchars($this->rcs));
	}
	public function getActivite() {
		return (htmlspecialchars($this->activite));
	}
	public function getRepresentant() {
		return (htmlspecialchars($this->representant));
	}
	public function getQualiteDe() {
		return (htmlspecialchars($this->qualite_de));
	}
	public function getSiegeSocial() {
		return (htmlspecialchars($this->siege_social));
	}
	public static function getLastFromPpId($PpId) {
		$req = "SELECT * FROM `" . self::$_name . "` WHERE id_situation = ? ORDER BY date_situation DESC LIMIT 1";
		$data = array($PpId);
		$rt = Database::prepare(static::$_db, $req, $data, 'SituationJuridiqueMorale');
		if (count($rt))
			return ($rt[0]);
		else
			return (null);
	}
	public function isValide() {
		return (time() < ($this->getDateSituation()->getTimestamp() + TIME_SITUATION_VALID));
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
}
