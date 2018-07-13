<?php
require_once("core/Database.php");
require_once("core/Table.php");

class DelaiJouissance extends Table
{
	const MOIS = 0;
	const TRIMESTRE = 1;
	const SEMESTRE = 2;
	private					$transaction = null;
	private					$delais = null;
	private					$_dateEntreJouissance = null;
	private					$_dateSortieJouissance = null;
	protected static		$_name = "DELAI JOUISSANCE";
	protected static		$_values = null;
	protected static		$_primary_key = "id";


	public function __construct() {
		//parent::__construct();
	}
	public static function removeFromId($id) {
		$req = "DELETE FROM `DELAI JOUISSANCE` WHERE id = ?;";
		$data =  [$id];
		return (Database::prepareNoClass(static::$_db, $req, $data));
	}
	public static function insertNew($id_scpi, $value, $unite, $value_vente, $unite_vente, $date_execution)
	{
		$req = "INSERT INTO `DELAI JOUISSANCE`
			(id_scpi, value, unite, value_vente, unite_vente, date_execution) VALUES
			(?, ?, ?, ?, ?, ?);";
		$data =  [
			$id_scpi,
			$value,
			$unite,
			$value_vente,
			$unite_vente,
			$date_execution
		];
		return (Database::prepareInsert(static::$_db, $req, $data, get_called_class()));
	}

	public static function createFromTransaction($transaction) {
		if (!($transaction->getEnrDate() instanceof DateTime))
			$time = time();
		else
			$time = $transaction->getEnrDate()->getTimestamp();
			//return (null);
		$req = "SELECT * FROM `DELAI JOUISSANCE` WHERE id_scpi = ? AND date_execution < ? ORDER BY date_execution DESC LIMIT 1;";
		$data = [
			$transaction->getScpiId(),
			//$transaction->getEnrDate()->getTimestamp()
			$time
		];
		$rt = Database::prepareCheckSecurity(static::$_db, $req, $data, get_called_class());
		if (count($rt) == 0)
		{
			$rt = new DelaiJouissance();
			$rt->value = 3;
			$rt->unite = 0;
			$rt->value_vente = 1;
			$rt->unite_vente = 0;
			$rt->transaction = $transaction;
			return ($rt);
		}
		$rt = $rt [0];
		$rt->transaction = $transaction;
		return ($rt);
	}

	public function getValueEntreJouissanceStr() {
		$rt = "";
		$rt .= $this->value;
		if ($this->unite == 0)
			$rt .= " mois";
		else if ($this->unite == 1)
			$rt .= " trimestres";
		else if ($this->unite == 2)
			$rt .= " semestres";
		return ($rt);
	}
	public function getValueSortieJouissanceStr() {
		$rt = "";
		$rt .= $this->value_vente;
		if ($this->unite_vente == 0)
			$rt .= " mois";
		else if ($this->unite_vente == 1)
			$rt .= " trimestres";
		else if ($this->unite_vente == 2)
			$rt .= " semestres";
		return ($rt);
	}
	public static function	doDelai($date, $value, $unite) {
		if (!($date instanceof  DateTime))
			return(null);
		//$date = DateTime::createFromFormat('j/m/Y', $date);
		$day = $date->format("d") + 0;
		$month = $date->format("m") + 0;
		$year = $date->format("Y") + 0;
		if ($unite == self::TRIMESTRE) {
			$month -= 1;
			$month = intval($month / 3);
			$month *= 3;
			$month += 1;
			$value *= 3;
		}
		else if ($unite == self::SEMESTRE) {
			$month -= 1;
			$month = intval($month / 6);
			$month *= 6;
			$month += 1;
			$value *= 6;
		}
		$day = 1;
		$month += $value;
		while ($month > 12) {
			$month -= 12;
			$year++;
		}
		return (DateTime::createFromFormat("d/m/Y", $day . "/" . $month . "/" . $year));
	}
	public function getEntreeJouissanceStr() {
		if ($this->getEntreeJouissance() instanceof DateTime)
			return ($this->getEntreeJouissance()->format("d/m/Y"));
		return ("-");
	}
	public function getPriseActivite() {
		if ($this->transaction->getTypeTransaction() == 'V')
			return (self::doDelai($this->transaction->getEnrDate(), $this->value_vente, $this->unite_vente));
		else
		{
			return (self::doDelai($this->transaction->getEnrDate(), $this->value, $this->unite));
		}
	}
	public function getEntreeJouissance() {
		//if (!empty($this->transaction->date_entre_joui))
			//return ((new DateTime())->setTimestamp($this->transaction->date_entre_joui));
		if ($this->_dateEntreJouissance == null)
		{
			if ($this->transaction->getMarcher() != "Secondaire")
			{
				if ($this->transaction->isPleinePro() || $this->transaction->isUsufruit())
					$this->_dateEntreJouissance = self::doDelai($this->transaction->getEnrDate(), $this->value, $this->unite);
				else if ($this->transaction->isNuePro())
				{
					if ($this->transaction->getDemembrement() > 0)
					{
						$this->_dateEntreJouissance = self::doDelai($this->transaction->getEnrDate(), $this->value, $this->unite);
						//$this->_dateEntreJouissance->add(new DateInterval('P' . $this->transaction->getDemembrement() . 'Y'));
					}
					else
						$this->_dateEntreJouissance = null;
				}
				else
					$this->_dateEntreJouissance = null;
			}
			else
			{
				//if (!$this->transaction->isPleinePro())
					//$this->_dateEntreJouissance = null;
				//else
					$this->_dateEntreJouissance = self::doDelai($this->transaction->getEnrDate(), $this->value_vente, $this->unite_vente);
			}
		}
		return ($this->_dateEntreJouissance);
	}

	public function getSortieJouissanceStr() {
		if ($this->getSortieJouissance() instanceof DateTime)
		{
			$rt = clone $this->getSortieJouissance();
			$rt->sub(new DateInterval('P1D'));
			return ($rt->format("d/m/Y"));
		}
		return ("-");
	}
	public function getSortieJouissance() {
		//if (!empty($this->transaction->date_fin_joui))
			//return ((new DateTime())->setTimestamp($this->transaction->date_fin_joui));
		if ($this->_dateSortieJouissance == null)
		{
			if (
				$this->transaction->getMarcher() != "Secondaire" &&
				$this->transaction->isUsufruit() &&
				$this->transaction->getDemembrement() > 0
			)
			{
				$this->_dateSortieJouissance = self::doDelai($this->transaction->getEnrDate(), $this->value, $this->unite);
				if (!empty($this->_dateSortieJouissance))
					$this->_dateSortieJouissance->add(new DateInterval('P' . $this->transaction->getDemembrement() . 'Y'));
			}
			else
			{
				//var_dump($this->transaction->getMarcher());
				//var_dump($this->transaction->isUsufruit());
				//var_dump($this->transaction->getDemembrement());
				$this->_dateSortieJouissance = null;
			}
		}
		return ($this->_dateSortieJouissance);
	}
	public static function getAllForScpi($id_scpi) {
		return (parent::getFromKeyValue('id_scpi', $id_scpi));
	}

	public static function getAllForStore()
	{
		return parent::getAll();
	}

	public function getDatePriseEffet() {
		$rt = new DateTime();
		$rt->setTimestamp($this->date_execution);
		return ($rt);
	}

	public static function create() {
		$rt = new DelaiJouissance();
		$rt->_is_new = 1;
		return ($rt);
	}
	public static function getById($id) {
		return parent::getFromKeyValue("id_scpi", $id);
	}
	private static function getValues() {
		if (self::$_values === null) {
			self::$_values = parent::getAll();
		}
		return (self::$_values);
	}
	private static function getValueFromId($id_scpi) {
		return self::getValues()[array_search($id_scpi, array_column(self::getValues(), 'id_scpi'))];
	}
	public static function getFromDateId($id_scpi, $date) {
		return (self::getDateTimeFromDateId($id_scpi, $date)->format("d/m/Y"));
	}
	public static function getDateTimeFromDateId($id_scpi, $date) {
		if ($date == "-") {
			return (0);
		}
		$date = DateTime::createFromFormat('j/m/Y', $date);
		$day = $date->format("d") + 0;
		$month = $date->format("m") + 0;
		$year = $date->format("Y") + 0;
		$info = self::getValueFromId($id_scpi);
		return  self::getFromInfos($day, $month, $year, $info->value, $info->unite);
	}
	public static function getDateTimeOutFromDateId($id_scpi, $date) {
		if ($date === "-") {
			exit();
		}
		$date = DateTime::createFromFormat('j/m/Y', $date);
		$day = $date->format("d") + 0;
		$month = $date->format("m") + 0;
		$year = $date->format("Y") + 0;
		$info = self::getValueFromId($id_scpi);
		return  self::getFromInfos($day, $month, $year, $info->value_vente, $info->unite_vente);
	}
	public static function getFromInfos($day, $month, $year, $value, $unite) {
		if ($unite == self::TRIMESTRE) {
			$month -= 1;
			$month = intval($month / 3);
			$month *= 3;
			$month += 1;
			$value *= 3;
		}
		else if ($unite == self::SEMESTRE) {
			$month -= 1;
			$month = intval($month / 6);
			$month *= 6;
			$month += 1;
			$value *= 6;
		}
		$day = 1;
		$month += $value;
		while ($month > 12) {
			$month -= 12;
			$year++;
		}
		return (DateTime::createFromFormat("d/m/Y", $day . "/" . $month . "/" . $year));
	}
}
