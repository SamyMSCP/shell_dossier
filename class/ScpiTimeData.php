<?php
require_once("core/Database.php");
require_once("core/Table.php");

class ScpiTimeData extends Table
{
	protected static		$_name = "scpi_time_data";
	protected static		$_primary_key = "id";

	static					$_to_save = [
		"id",
		"id_scpi",
		"id_scpi_time_data_list",
		"created_date",
		"content"
	];

	public function getLastFromScpiIdTypeId($id_scpi, $id_type)
	{
		$req = "SELECT * FROM `scpi_time_data` WHERE id_scpi = ? AND id_scpi_time_data_list = ? ORDER BY `created_date` DESC LIMIT 1";
		return (Database::prepare(self::$_db, $req, [$id_scpi, $id_type], "ScpiTimeData"));
	}
	public function getFromScpiIdTypeId($id_scpi, $id_type)
	{
		return(parent::getFromKeysValues([
			"id_scpi" => $id_scpi,
			"id_scpi_time_data_list" => $id_type
		]));
	}
	public function __construct() {
		$this->created_date = time();
	}
	public function getIdScpi() {
		return ($this->id_scpi);
	}
	public function setScpi(Scpi $scpi) {
		$this->id_scpi = $scpi->id;
	}
	public function getScpi() {
		return (Scpi::getFromId($this->id_scpi)[0]);
	}
	public function setType($id) {
		$this->id_scpi_time_data_list = $id;
	}
	public function getType() {
		return (ScpiTimeDataList::getFromId($this->id_scpi_time_data_list)[0]);
	}
	public function getTypeName() {
		return (ScpiTimeDataList::getFromId($this->id_scpi_time_data_list)[0]->getName());
	}
	public function getCreatedDate() {
		$rt = new DateTime;
		$rt ->setTimestamp($this->created_date);
		return ($rt);
	}
	public function setCreatedDate(Datetime $data) {
		$this->created_date = $data->getTimestamp();
	}
	public function getContent() {
		return (json_decode($this->content));
	}
	public function setContent(Array $data) {
		$this->content = json_encode($data);
	}
	public function __toString() {
		$rt = "Scpi : ";
		$rt .= Scpi::getFromId($this->id_scpi);
		$rt .= "type : " . ScpiTimeDataList::getFromId($this->id_scpi_time_data_list)[0] . "\n";
		$rt .= "date creation : " . $this->getCreatedDate()->format("d/m/Y");
		return ($rt);
	}
}
