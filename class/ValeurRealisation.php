<?php
require_once("core/Database.php");
require_once("core/Table.php");

class ValeurRealisation extends Table
{
	use DocumentTrait;
	protected static		$_name = "valeur_realisation";
	protected static		$_primary_key = "id";
	public function __construct() { }

	public static function createForScpi($id_scpi, $value)
	{
		//parent::getFromKeyValue("id_scpi", $id);
	}
	public static function getFromScpiId($id)
	{
		return (parent::getFromKeyValue("id_scpi", $id));
	}
	public static function saveNewValue($id, $value)
	{
		$req = "INSERT INTO `valeur_realisation` (id_scpi, value) VALUES
			(?, ?)";
		$data = [
			$id , $value
		];
		return Database::prepareInsert(static::$_db, $req, $data);
	}
	public static function saveValue($id, $value)
	{
		$actual = self::getFromScpiId($id);
		if (!empty($actual))
		{
			$actual = $actual[0];
			$actual->updateOneColumn("value", $value);
			return $actual->id;
		}
		else
			return self::saveNewValue($id, $value);
	}
}
