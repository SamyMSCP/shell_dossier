<?php
require_once("core/Database.php");
require_once("core/Table.php");

class Favoris extends Table
{
	protected static		$_name = "favoris";
	protected static		$_primary_key = "id";

	public static function insertActu($id_dh, $id_actu) {
		$req = "INSERT INTO `favoris` (id_dh, id_actu) VALUES (?, ?)";
		$data = array(
			$id_dh,
			$id_actu
		);
		return database::prepareInsert(static::$_db, $req, $data);
	}
	public static function removeActu($id_dh, $id_actu)
	{
		$req = "DELETE FROM `favoris` WHERE id_dh = ? AND id_actu = ?";
		$data = array(
			$id_dh,
			$id_actu
		);
		return database::prepareNoClass(static::$_db, $req, $data);
	}
	public static function checkActu($id_dh, $id_actu)
	{
		$req = "SELECT * FROM `favoris` WHERE id_dh = ? AND  id_actu= ?";
		$data = array(
			$id_dh,
			$id_actu
		);
		if (count(database::prepare(static::$_db, $req, $data, 'Favoris')))
			return (true);
		else
			return (false);
	}

	public static function insertPublication($id_dh, $id_publication) {
		$req = "INSERT INTO `favoris` (id_dh, id_publication) VALUES (?, ?)";
		$data = array(
			$id_dh,
			$id_publication
		);
		return Database::prepareInsert(static::$_db, $req, $data);
	}

	public static function removePublication($id_dh, $id_actu)
	{
		$req = "DELETE FROM `favoris` WHERE id_dh = ? AND id_publication = ?";
		$data = array(
			$id_dh,
			$id_publication
		);
		return database::prepareNoClass(static::$_db, $req, $data);
	}

	public static function checkPublication($id_dh, $id_publication)
	{
		$req = "SELECT * FROM `favoris` WHERE id_dh = ? AND  id_publication= ?";
		$data = array(
			$id_dh,
			$id_publication
		);
		if (count(database::prepare(static::$_db, $req, $data, 'Favoris')))
			return (true);
		else
			return (false);
	}
	public static function getFromDh($id_dh) {
		return (parent::getFromKeyValue('id_dh', $id_dh));
	}
}
