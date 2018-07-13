<?php
require_once("core/Database.php");
require_once("core/Table.php");
require_once("TypeDocumentEntity.php");

class TypeDocument extends Table
{
	protected static		$_name = "type_document";
	protected static		$_primary_key = "id";

	private					$_nameType = null;
	private					$_link = null;
	private					$_duree_validite = null;

	public static function defaultInstall() {
		TypeDocument::insert("CNI - PASSEPORT", "", 0, 0, 0, 1, array(Pp::getEntityId()));
		TypeDocument::insert("JUSTIFICATIF DE DOMICILE", "", 0, 0, 0, 1, array(Pp::getEntityId()));
		TypeDocument::insert("RIB", "", 0, 0, 0, 1, array(Pp::getEntityId()));
		TypeDocument::insert("LETTRE DE MISSION", "", 0, 0, 0, 1, array(Dh::getEntityId()));
		TypeDocument::insert("CGU", "", 0, 0, 0, 1, array(Dh::getEntityId()));
		TypeDocument::insert("FIL", "", 0, 0, 0, 1, array(Dh::getEntityId()));
		TypeDocument::insert("COMPARAISON", "", 0, 0, 0, 1, array(Projet::getEntityId()));
		TypeDocument::insert("SIMULATION", "", 0, 0, 0, 1, array(Projet::getEntityId()));
		TypeDocument::insert("REC", "", 0, 0, 0, 1, array(Projet::getEntityId()));
		TypeDocument::insert("JUST ORIGINE FONDS", "", 0, 0, 0, 1, array(Projet::getEntityId()));
		TypeDocument::insert("LAB", "", 0, 0, 0, 1, array(Projet::getEntityId()));
	}
	public static function getUploadAdmin()
	{
		return (parent::getFromKeysValues(array("Meilleurescpi")));
	}
	public static function insert($name, $duree_validite, $need_signature, $need_read, $need_validate_dh,  $need_validate_backoffice, $need_access_frontoffice, $arr)
	{
		$req = "INSERT INTO `type_document` 
			(name, duree_validite, need_signature, need_read, need_validate_dh, need_validate_backoffice, need_access_frontoffice)
			VALUES (?, ?, ?, ?, ?, ?, ?)";
		$data = array(
			$name,
			$duree_validite,
			$need_signature,
			$need_read,
			$need_validate_dh,
			$need_validate_backoffice,
			$need_access_frontoffice
		);
		$id = Database::prepareInsert(static::$_db, $req, $data);
		return TypeDocumentEntity::linkTypeToArray($id, $arr);
	}
	public static function updateTypeDocument($id, $name, $duree_validite, $need_signature, $need_read, $need_validate_dh,  $need_validate_backoffice, $need_access_frontoffice, $arr)
	{
		$req = "UPDATE `type_document` SET
			name = ?, duree_validite = ?, need_signature = ?, need_read = ?, need_validate_dh = ?, need_validate_backoffice = ?, need_access_frontoffice = ? WHERE id = ?";
		$data = array(
			$name,
			$duree_validite,
			$need_signature,
			$need_read,
			$need_validate_dh,
			$need_validate_backoffice,
			$need_access_frontoffice,
			$id
		);
		TypeDocumentEntity::removeAllForIdType($id);
		TypeDocumentEntity::linkTypeToArray($id, $arr);
		return Database::prepareNoClass(static::$_db, $req, $data);
	}
	public static function getNeedDhValidation() {
		return (parent::getFromKeyValue('need_validate_dh', '1'));
	}
	public static function getFromName($name)
	{
		return (parent::getFromKeyValue('name', $name));
	}
	public function isLinkedToEntityId($idEntity) {
		if ($this->_link == null)
		{
			$this->_link = TypeDocumentEntity::getFromIdType($this->id);
		}
		foreach ($this->_link as $key => $elm)
		{
			if ($elm->id_entity == $idEntity)
				return (true);
		}
		return (false);
	}
	public function getName()
	{
		if ($this->_nameType === null)
		{
			$this->_nameType = htmlspecialchars($this->name);
		}
		return ($this->_nameType);
	}
	public function getDureValidite()
	{
		if ($this->_duree_validite === null)
		{
			$this->_duree_validite = htmlspecialchars($this->duree_validite);
		}
		return ($this->_duree_validite);
	}
	public function getNeedSignature()
	{
		return ($this->need_signature);
	}
	public function getNeedAccessFrontoffice()
	{
		return ($this->need_access_frontoffice);
	}
	public function getNeedRead()
	{
		return ($this->need_read);
	}
	public function getNeedValidateDh()
	{
		return ($this->need_validate_dh);
	}
	public function getNeedValidateBackoffice()
	{
		return ($this->need_validate_backoffice);
	}
}
