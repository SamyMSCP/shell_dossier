<?php
require_once("core/Database.php");
require_once("core/Table.php");

class ScpiTimeDataList  extends Table
{
	protected static		$_name = "scpi_time_data_list";
	protected static		$_primary_key = "id";

	public function getName() {
		return ($this->name);
	}
	public function __toString() {
		return ($this->name);
	}
}

foreach (ScpiTimeDataList::getAll() as $key => $elm) {
	define(mb_strtoupper($elm->getName()), $elm->id);
}
