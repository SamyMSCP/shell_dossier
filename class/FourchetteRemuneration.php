<?php
require_once("core/Database.php");
require_once("core/Table.php");

class FourchetteRemuneration extends Table
{
	protected static				$_name = "fourchette_remuneration";
	protected static				$_primary_key = "id";
	public function					__construct() {
		$this->id = null;
	}
	public function					getTrancheHaute() {
		return ($this->tranche_haute);
	}
	public function					getTrancheBasse() {
		return ($this->tranche_basse);
	}
	public function					getDateExecution() {
		$rt = null;
		if (!empty($this->date_execution))
		{
			$rt = new DateTime;
			$rt->setTimestamp($this->date_execution);
		}
		return ($rt);
	}
	public function					getDateCreation() {
		$rt = null;
		if (!empty($this->date_creation))
		{
			$rt = new DateTime;
			$rt->setTimestamp($this->date_creation);
		}
		return ($rt);
	}
	public function					getScpi() {
		return (Scpi::getFromId($this->id_scpi));
	}
	public function					setTrancheHaute($data) {
		$this->tranche_haute = $data;
		return (true);
	}
	public function					setTrancheBasse($data) {
		$this->tranche_basse = $data;
		return (true);
	}
	public function					setDateExecution($data) {
		if ($data instanceof DateTime)
			$this->date_execution = $data->getTimestamp();
		else 
			$this->date_execution = intval($data);
		return (true);
	}
	public function					setScpi($scpi) {
		if (!($scpi instanceof Scpi))
			return (false);
		$this->id_scpi = $scpi->id;
		return (true);
	}
	public static function			shortInsert($tranche_haute, $tranche_basse, $scpi, $date_execution = 0) {
		$nelm = new FourchetteRemuneration;
		return (
			$nelm->setTrancheHaute($tranche_haute) &&
			$nelm->setTrancheBasse($tranche_basse) &&
			$nelm->setScpi($scpi) &&
			$nelm->setDateExecution($date_execution) &&
			$nelm->insertIt()
		);
	}
	public function					insertIt() {
		if ($this->id != null)
			return (false);
		if ( empty($this->getScpi()))
			return (false);
		$date = null;
		if ($this->date_execution != null)
			$date = $this->date_execution;
		else
			$date = 0;
		$req = "INSERT INTO `fourchette_remuneration`
			(id_scpi, date_execution, tranche_haute, tranche_basse, date_creation) VALUES
			(?, ?, ?, ?, ?)";
		$data = array(
			$this->id_scpi,
			$date,
			$this->tranche_haute,
			$this->tranche_basse,
			time()
		);
		if (Database::prepareInsert(static::$_db, $req, $data))
			return (true);
		else
			return (false);
	}
	public static function			getLastForScpi($id_scpi) {
		$req = "SELECT * FROM `fourchette_remuneration` WHERE id_scpi = ? ORDER BY date_creation DESC LIMIT 1";
		$data = [
			$id_scpi
		];
		$rt = Database::prepare(static::$_db, $req, $data, 'FourchetteRemuneration');
		if (count($rt))
			return ($rt[0]);
		return (null);
	}
	public static function			getForStore() {
		return (self::getAll());
	}
	public function					getTrancheHauteStr() {
		return (number_format(floatval($this->getTrancheHaute())) . " %");
	}
	public function					getTrancheBasseStr() {
		return (number_format(floatval($this->getTrancheBasse())) . " %");
	}
	public function					getStr() {
		if ($this->tranche_haute == $this->tranche_basse)
			return ($this->getTrancheBasseStr());
		else
			return ( $this->getTrancheBasseStr() . " - " . $this->getTrancheHauteStr());
	}
}
