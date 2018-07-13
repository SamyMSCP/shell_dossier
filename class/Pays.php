<?php
require_once("core/Database.php");
require_once("core/Table.php");

class Pays extends Table
{
	protected static		$_name = "pays";
	protected static		$_primary_key = "id";

	public static function getAll() {
		$name = (isset(static::$_name)) ? '`' . static::$_name . '`' : get_called_class();
		return Database::query(static::$_db, "SELECT * FROM " . $name . " ORDER BY nom_fr_fr", get_called_class());
	}
}
