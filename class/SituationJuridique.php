<?php
require_once("core/Database.php");
require_once("core/Table.php");

class SituationJuridique extends Table
{
	protected static		$_name = "SITUATION JURIDIQUE";
	protected static		$_primary_key = "id";

	public static			$_regimeMatrimonial = array(
		"1" => "Communauté réduite aux acquêts (sans contrat)",
		"2" => "Participation aux acquêts",
		"3" => "Communauté universelle",
		"4" => "Séparation de biens"
	);

	public static function insertNew($id_situation, $date_situation, $date_fin_situation, $regime_mat, $nbr_enfant_charge, $nbr_pers_charge, $haveChild) {
		$dh = Dh::getCurrent();
		if (empty($dh))
			$dh = 0;
		else
			$dh = $dh->id_dh;

		$req = "INSERT INTO `SITUATION JURIDIQUE` (id_situation, date_situation, date_fin_situation, regime_mat, nbr_enfant_charge, nbr_pers_charge, haveChild, creator)
			VALUES(?, ?, ?, ?, ?, ?, ?, ?);";
		$data = array(
			$id_situation,
			$date_situation,
			$date_fin_situation,
			$regime_mat,
			$nbr_enfant_charge,
			$nbr_pers_charge,
			$haveChild,
			$dh
		);
		Situation::getFromId($id_situation)[0]->updateOneColumn("resetSituationJuridique", 0);
		$id = Database::prepareInsert(static::$_db, $req, $data);
		return ($id);
	}
	public static function updateOne($id, $date_situation, $date_fin_situation, $regime_mat, $nbr_enfant_charge, $nbr_pers_charge) {
		$req = "UPDATE `SITUATION JURIDIQUE` SET date_situation = ?, date_fin_situation = ?, regime_mat = ?, nbr_enfant_charge = ?, nbr_pers_charge = ? WHERE id = ?;";
		$data = array(
			$date_situation,
			$date_fin_situation,
			$regime_mat,
			$nbr_enfant_charge,
			$nbr_pers_charge,
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
		$rt = Database::prepare(static::$_db, $req, $data, 'SituationJuridique');
		if (count($rt))
			return ($rt[0]);
		else
			return (null);
	}
	public function isValide() {
		return (time() < ($this->getDateSituation()->getTimestamp() + TIME_SITUATION_VALID));
	}
	public static function getFromDh($id_dh) {
		$req = "SELECT `SITUATION JURIDIQUE`.* FROM `SITUATION JURIDIQUE` INNER JOIN `situation` ON `SITUATION JURIDIQUE`.id_situation = `situation`.id WHERE `situation`.id_dh = ?";
		$data = array(
			$id_dh
		);
		return Database::prepare(static::$_db, $req, $data, 'SituationJuridique');
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
	public function getRegimeMat() {
		return (htmlspecialchars($this->regime_mat));
	}
	public function getNbrEnfantCharge() {
		return ($this->nbr_enfant_charge);
	}
	public function getNbrPersonnesCharge() {
		return ($this->nbr_pers_charge);
	}
	public function getHaveChild() {
		if (isset($this->haveChild))
			return (intval($this->haveChild));
		return (0);
	}
	public static function getFromDhForStore($id_dh) {
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
	public function getAdresseStr() {
		
	}
}
