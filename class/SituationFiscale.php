<?php
require_once("core/Database.php");
require_once("core/Table.php");

class SituationFiscale extends Table
{
	protected static		$_name = "SITUATION FISCALE";
	protected static		$_primary_key = "id";

/*
	public static function insertNew($id_situation, $date_situation, $date_fin_situation, $residence_france, $taux_marginal_imposition, $impots_annee_precedente, $nbr_parts_fiscales, $tranche_isf, $montant_impot_isf) {
		$req = "INSERT INTO `SITUATION FISCALE` (id_situation, date_situation, date_fin_situation, residence_france , taux_marginal_imposition , impots_annee_precedente, nbr_parts_fiscales , tranche_isf , montant_impot_isf)
			VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?);";
		$data = array(
			$id_situation,
			$date_situation,
			$date_fin_situation,
			$residence_france,
			$taux_marginal_imposition,
			$impots_annee_precedente,
			$nbr_parts_fiscales,
			$tranche_isf,
			$montant_impot_isf
		);
		Situation::getFromId($id_situation)[0]->updateOneColumn("resetSituationFiscale", 0);
		$id = Database::prepareInsert(static::$_db, $req, $data);
		return ($id);
	}
	*/
	public static function insertNew2($id_situation, $date_situation, $date_fin_situation, $residence_france, $nbr_parts_fiscales, $pays, $id_impot, $id_tranche_impot, $id_impot_fortune, $id_tranche_impot_fortune) {

		$dh = Dh::getCurrent();
		if (empty($dh))
			$dh = 0;
		else
			$dh = $dh->id_dh;

		$req = "INSERT INTO `SITUATION FISCALE` (
				id_situation,
				date_situation,
				date_fin_situation,
				residence_france ,
				nbr_parts_fiscales,
				pays,
				id_impot,
				id_tranche_impot,
				id_impot_fortune,
				id_tranche_impot_fortune,
				creator)
			VALUES(
				?,
				?,
				?,
				?,
				?,
				?,
				?,
				?,
				?,
				?,
				?);";
		$data = array(
			$id_situation,
			$date_situation,
			$date_fin_situation,
			$residence_france,
			$nbr_parts_fiscales,
			$pays,
			$id_impot,
			$id_tranche_impot,
			$id_impot_fortune,
			$id_tranche_impot_fortune,
			$dh
		);
		Situation::getFromId($id_situation)[0]->updateOneColumn("resetSituationFiscale", 0);
		$id = Database::prepareInsert(static::$_db, $req, $data);
		return ($id);
	}
	public static function updateOne($id, $date_situation, $date_fin_situation, $residence_france, $taux_marginal_imposition, $impots_annee_precedente, $nbr_parts_fiscales, $tranche_isf, $montant_impot_isf) {
		$req = "UPDATE `SITUATION FISCALE` SET date_situation = ?, date_fin_situation = ?, residence_france = ?, taux_marginal_imposition = ?, impots_annee_precedente = ?, nbr_parts_fiscales = ?, tranche_isf = ?, montant_impot_isf = ? WHERE id = ?";
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
		$req = "SELECT `SITUATION FISCALE`.* FROM `SITUATION FISCALE` INNER JOIN `situation` ON `SITUATION FISCALE`.id_situation = `situation`.id WHERE `situation`.id_dh = ?";
		$data = array(
			$id_dh
		);
		return Database::prepare(static::$_db, $req, $data, 'SituationFiscale');
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
	public function getIsResidentFrance() {
		return ($this->getPays() == "France");
	}
	public function getNbrPartsFiscale() {
		return ($this->nbr_parts_fiscales);
	}
	public function getPays() {
		return (htmlspecialchars($this->pays));
	}
	public static function getLastFromPpId($PpId) {
		$req = "SELECT * FROM `" . self::$_name . "` WHERE id_situation = ? ORDER BY date_situation DESC LIMIT 1";
		$data = array($PpId);
		$rt = Database::prepare(static::$_db, $req, $data, 'SituationFiscale');
		if (count($rt))
			return ($rt[0]);
		else
			return (null);
	}
	public function isValide() {
		return (time() < ($this->getDateSituation()->getTimestamp() + TIME_SITUATION_VALID));
	}
	public function haveImpot() {
		return ($this->getImpotId() != 0);
	}
	public function haveIsf() {
		return ($this->getTrancheImpotFortuneId() != 0);
	}
	public function getValeurImpot() {
		if ($this->id_impot == 0)
			return (0);
		return (Valeur_impot::getFromId($this->id_impot)[0]->getDatas()[$this->id_tranche_impot]);
	}
	public function getValeurIsf() {
		if ($this->id_impot_fortune == 0)
			return (0);
		return (Valeur_impot_fortune::getFromId($this->id_impot_fortune)[0]->getDatas()[$this->id_tranche_impot_fortune]);
	}
	public function getImpotId() {
		return ($this->id_impot);
	}
	public function getTrancheImpotId() {
		return ($this->id_tranche_impot);
	}
	public function getImpotFortuneId() {
		return ($this->id_impot_fortune);
	}
	public function getTrancheImpotFortuneId() {
		return ($this->id_tranche_impot_fortune);
	}
	public function getImpotAnneePrecedente() {
		return (floatval($this->impot_annee_precedente));
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
		if ($rt->id_impot != 0)
		{
			$rt->haveImpot = "1";
		}
		else
		{
			$rt->haveImpot = "0";
			$rt->id_impot = Valeur_impot::getActual()->id;
		}
		if  ($rt->id_impot_fortune != 0)
		{
			$rt->haveImpotFortune = "1";
		}
		else
		{
			$rt->haveImpotFortune = "0";
			$rt->id_impot_fortune = Valeur_impot_fortune::getActual()->id;
		}
		$rt->impot_annee_precedente = ($rt->impot_annee_precedente === NULL) ? "0" : $rt->impot_annee_precedente;
		$rt->creatorShortName = $this->getCreatorStr();
		return ($rt);
	}
	public function getCreatorStr() {
		if ($this->creator == 0)
			return ("-");
		return (Dh::getById($this->creator)->getShortName());
	}
}
