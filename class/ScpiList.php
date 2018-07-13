<?php
require_once("core/Database.php");
require_once("core/Table.php");

class ScpiList extends Table
{
	protected static		$_name = "scpi_scrap_list";
	protected static		$_primary_key = "id";
}
