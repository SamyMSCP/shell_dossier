<?php
require_once("core/Database.php");
require_once("core/Table.php");

class SituationFinanciereMorale extends Table
{
	public static			$_noSecure = array("datas");
	protected static		$_name = "SITUATION FINANCIERE MORALE";
	protected static		$_primary_key = "id";

	public static function insertNew($id_situation, $date_situation, $date_fin_situation, 
			$datas,
			$evolution_CA,
			$investissement_consequent_prevu
	) {
		$req = "INSERT INTO `SITUATION FINANCIERE MORALE` (id_situation, date_situation, date_fin_situation,
			datas,
			evolution_CA,
			investissement_consequent_prevu
		)
			VALUES(?, ?, ?, ?, ?, ?);";
		$data = array(
			$id_situation,
			$date_situation,
			$date_fin_situation,
			$datas,
			$evolution_CA,
			$investissement_consequent_prevu
		);
		Situation::getFromId($id_situation)[0]->updateOneColumn("resetSituationFinanciere", 0);
		$id = Database::prepareInsertNoSecurity(static::$_db, $req, $data);
		return ($id);
	}
	public function getDatas() {
		$rt = array();
			//return ($this->datas);
		$tmp = unserialize($this->datas);

		if (isset($tmp[date("Y")]))
			$rt['N'] = $tmp[date("Y")];
		else
			$rt['N'] = array('CA' => 0, 'resultat' => 0, 'taux_endettement' => 0);

		if (isset($tmp[date("Y") - 1]))
			$rt['N1'] = $tmp[date("Y") - 1];
		else
			$rt['N1'] = array('CA' => 0, 'resultat' => 0, 'taux_endettement' => 0);

		if (isset($tmp[date("Y") - 2]))
			$rt['N2'] = $tmp[date("Y") - 2];
		else
			$rt['N2'] = array('CA' => 0, 'resultat' => 0, 'taux_endettement' => 0);
		return ($rt);
	}
	public function getEvolutionCA() {
		return ($this->evolution_CA);
	}
	public function getInvestissementPrevu() {
		return ($this->investissement_consequent_prevu);
	}
	public static function getLastFromPpId($PpId) {
		$req = "SELECT * FROM `" . self::$_name . "` WHERE id_situation = ? ORDER BY date_situation DESC LIMIT 1";
		$data = array($PpId);
		$rt = Database::prepare(static::$_db, $req, $data, 'SituationFinanciereMorale');
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
