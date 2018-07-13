<?php
require_once("core/Database.php");
require_once("core/Table.php");

class Entity extends Table
{
	protected static		$_name = "entity";
	protected static		$_primary_key = "id";

	private					$_nameType = null;
	private					$_duree_validite = null;

	public static function	getByClassName($className) {
		$rt = Entity::getFromKeyValue("class", $className);
		if (count($rt))
			return ($rt[0]);
		return (null);
	}
	public static function getFromIdDocument($id_document) {
		$req = "SELECT * FROM `entity` INNER JOIN `documents_entity` ON `entity`.id = `documents_entity`.id_entity WHERE id_documents = ?";
		return Database::prepare(static::$_db, $req, [$id_document], 'entity');
	}
}
