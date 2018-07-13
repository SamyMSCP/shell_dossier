<?php
require_once("core/Database.php");
require_once("core/Table.php");

class CentreInteret extends Table
{
	protected static $_name = "centre_interet";
	protected static $_primary_key = "id";

	public static function insertNew( $nom )
	{
		$req = ' INSERT INTO `'.static::$_name.'` (`nom`) VALUES (:nom)';

		return Database::prepareInsert(static::$_db, $req, ["nom" => $nom], get_called_class());
	}

	public static function getForStats()
	{
		$except = [1,5,12,16,22];

		$sql = "SELECT COUNT(`id_dh`) as `cnt`, `centre_interet`.`nom` FROM `dh_centre_interet` INNER JOIN `centre_interet` ON `centre_interet`.`id` = `dh_centre_interet`.`id_ci` WHERE `id_ci` NOT IN (?,?,?,?,?) GROUP BY `id_ci`";

		return Database::getNoClass(static::$_db, $sql, $except);
	}
}