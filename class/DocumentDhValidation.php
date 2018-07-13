<?php
require_once("core/Database.php");
require_once("core/Table.php");

class DocumentDhValidation extends Table
{
	protected static		$_name = "document_dh_validation";
	protected static		$_primary_key = "id";

	public static function getFromDh($id_dh)
	{
		return (parent::getFromKeyValue("id_dh", $id_dh));
	}
	public static function getLastFromDhTypeDocument($id_dh, $id_type_document)
	{
		$req = "SELECT document_dh_validation.* FROM document_dh_validation INNER JOIN documents ON document_dh_validation.id_document = documents.id WHERE document_dh_validation.id_dh = ? AND documents.id_type_document = ? ORDER BY document_dh_validation.date_validation DESC LIMIT 1";
		$rt =  Database::prepare(static::$_db, $req, [$id_dh, $id_type_document], "DocumentDhValidation");
		if (count($rt))
			return ($rt[0]);
		return (null);
	}
	public static function getFromDhDocument($id_dh, $id_document)
	{
		return (parent::getFromKeysValues(array(
			"id_dh" => $id_dh,
			"id_document" => $id_document
			)
		));
	}
	public static function setValidate($id_dh, $id_document)
	{
		if (count(self::getFromDhDocument($id_dh, $id_document)))
			return (null);
		$req = "INSERT INTO `document_dh_validation` (id_dh, id_document, date_validation)
			VALUES(?, ?, ?)";
		$data = array(
			$id_dh,
			$id_document,
			time()
		);
		return Database::prepareInsert(static::$_db, $req, $data);
	}
	public function getDateValidation() {
		if (empty($this->_dateValidation))
			$this->_dateValidation = "";
		if ($this->_dateValidation == null)
		{
			$this->_dateValidation = new DateTime;
			$this->_dateValidation->setTimestamp($this->date_validation); 
		}
		return ($this->_dateValidation);
	}
}
