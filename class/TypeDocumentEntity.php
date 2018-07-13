<?php
require_once("core/Database.php");
require_once("core/Table.php");

class TypeDocumentEntity extends Table
{
	protected static		$_name = "type_document_entity";
	protected static		$_primary_key = "id";

	private					$_nameType = null;
	private					$_duree_validite = null;

	public static function	getFromIdType($idType) {
		return (parent::getFromKeyValue("id_type_document", $idType));
	}
	public static function	getFromIdEntity($idEntity) {
		return (parent::getFromKeyValue("id_entity", $idEntity));
	}
	public static function	removeAllForIdType($idType) {
		$req = "DELETE FROM `type_document_entity` WHERE id_type_document = ?";
		$data = array(
			$idType
		);
		return (Database::prepareNoClass(static::$_db, $req, $data));
	}
	public static function	linkTypeToArray($idType, $array) {
		foreach ($array as $key => $elm)
		{
			$req = "INSERT INTO `type_document_entity` (id_type_document, id_entity) VALUES (?, ?)";
			$data = array(
				$idType,
				$elm
			);
			Database::prepareNoClass(static::$_db, $req, $data);
		}
	}
	public function getTypeDocument() {
		$rt = TypeDocument::getFromId($this->id_type_document);
		if (count($rt));
			return ($rt[0]);
		return (null);
	}
}
