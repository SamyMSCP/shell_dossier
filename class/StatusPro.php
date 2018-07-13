<?php
require_once("core/Database.php");
require_once("core/Table.php");

class StatusPro extends Table
{
	protected static		$_name = "status_pro";
	protected static		$_primary_key = "id";

	public function getName()  {
		return ($this->name);
	}
}
