<?php
require_once("core/Database.php");
require_once("core/Table.php");

class Situation extends Table
{
	protected static		$_name = "situation";
	protected static		$_primary_key = "id";

	public static function insertNewPp($id_dh, $arrayPp) {
		$req = "INSERT INTO `situation` (id_dh) VALUES(?)";
		$data = array(
			$id_dh
		);
		$id = Database::prepareInsert(static::$_db, $req, $data);
		self::linkPpArray($id, $arrayPp);
		return ($id);
	}
	public static function insertNewPm($id_dh, $id_pm) {
		$req = "INSERT INTO `situation` (id_dh) VALUES(?)";
		$data = array(
			$id_dh
		);
		$id = Database::prepareInsert(static::$_db, $req, $data);
		self::linkPm($id, $id_pm);
		return ($id);
	}
	public static function linkPm($id, $id_pm) {
		$req = "UPDATE `PERSONNE MORALE` SET id_situation = ? WHERE id_pm = ?;";
		$data = array($id, $id_pm);
		Database::prepareInsert(static::$_db, $req, $data);
		return ($id);
	}
	public static function linkPpArray($id, $arrayPp) {
		$req = "UPDATE `PERSONNE PHYSIQUE` SET id_situation = ? WHERE ";
		$data = array($id);
		$first = true;
		foreach ($arrayPp as $key => $elm)
		{
			if (!$first)
				$req .= " OR ";
			$req .= " id_phs = ? ";
			$data[] = $elm;
			$first = false;
		}
		$req .= ";";
		Database::prepareInsert(static::$_db, $req, $data);
		return ($id);
	}
	public static function getResetFromPpId($PpId) {
		$req = "SELECT * FROM `" . self::$_name . "` WHERE id = ? LIMIT 1";
		$data = array($PpId);
		$rt = Database::prepare(static::$_db, $req, $data, 'Situation');
		if (count($rt))
			return ($rt[0]);
		else
			return (null);
	}
}
