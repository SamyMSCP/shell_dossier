<?php

require_once("core/Database.php");
require_once("core/Table.php");
require_once("CentreInteret.php");

class DhCentreInteretSCPI extends Table
{

	protected static		$_name = "dh_centre_interet_scpi";
	protected static		$_primary_key = "id";

	public static function insertNew( $id_dh, $id_scpi )
	{
		if (!empty(parent::getFromKeysValues(['id_dh' => $id_dh, 'id_scpi' => $id_scpi])))
			return 0;
		$req = "INSERT INTO `" . static::$_name . "` (`id_dh`, `id_scpi`) VALUES (?, ?)";
		$data = [$id_dh, $id_scpi];
		return Database::prepareInsert(static::$_db, $req, $data);
	}

	public static function countDhCISCPI( $id_scpi )
	{
		$req = "SELECT COUNT(" . static::$_primary_key . ") as `nb` FROM `" . static::$_name . "` WHERE `id_scpi` = ";
		$data = [];
		$req.= "?";
		if (is_array($id_scpi))
		{
			if (!($cnt = count($id_scpi)))
				return false;
			$data[]= $id_scpi[0];
			for ($i = 0; $i < $cnt; ++$i)
			{
				$data[] = $id_scpi[$i];
				$req.= ",?";
			}
		}
		else
			$data[]= $id_scpi;
		$req.=" GROUP BY `id_dh`";
		$res = Database::getNoClass(static::$_db, $req, $data);
		if (isset($res[0]))
			return $res[0]['nb'];
		return 0;
	}
}