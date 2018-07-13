<?php

require_once("core/Database.php");
require_once("core/Table.php");
require_once("CentreInteret.php");

class DhCentreInteret extends Table
{

	protected static		$_name = "dh_centre_interet";
	protected static		$_primary_key = "id";

	public static function insertNew( $id_dh, $id_ci )
	{
		if (!empty(parent::getFromKeysValues(['id_dh' => $id_dh, 'id_ci' => $id_ci])))
			return 0;
		$req = "INSERT INTO `" . static::$_name . "` (`id_dh`, `id_ci`) VALUES (?, ?)";
		$data = [$id_dh, $id_ci];
		return Database::prepareInsert(static::$_db, $req, $data);
	}

	public static function countDhCI( $id_ci )
	{
		$req = "SELECT COUNT(" . static::$_primary_key . ") as `nb` FROM `" . static::$_name . "` WHERE `id_ci` = ";
		$data = [];
		$req.= "?";
		if (is_array($id_ci))
		{
			if (!($cnt = count($id_ci)))
				return false;
			$data[]= $id_ci[0];
			for ($i = 0; $i < $cnt; ++$i)
			{
				$data[] = $id_ci[$i];
				$req.= ",?";
			}
		}
		else
			$data[]= $id_ci;
		$req.=" GROUP BY `id_dh`";
		$res = Database::getNoClass(static::$_db, $req, $data);
		if (isset($res[0]))
			return $res[0]['nb'];
		return 0;
	}
}