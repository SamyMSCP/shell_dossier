<?php
require_once("core/Database.php");
require_once("core/Table.php");

class TypeLogger extends Table
{
	protected static		$_name = "type_logger";
	protected static		$_primary_key = "id";
	public function __construct() {}
	public static function getIdByName($name)
	{
		$rt = self::getFromKeyValue("name", mb_strtolower($name));
		if (count($rt))
			return ($rt[0]->id);
		return (false);
	}
	public static function getNameById($id)
	{
		$rt = self::getFromId($id);
		if (count($rt))
			return ($rt[0]->name);
		return (false);
	}
	public static function getByName($name)
	{
		$rt = self::getFromKeyValue("name", mb_strtolower($name));
		if (count($rt))
			return ($rt[0]);
		return (false);
	}
	public static function getById($id)
	{
		$rt = self::getFromId($id);
		if (count($rt))
			return ($rt[0]);
		return (false);
	}
	public function getParams() {
		return (unserialize($this->need_params));
	}
	public function getName() {
		return ($this->name);
	}
}
