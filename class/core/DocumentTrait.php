<?php
//require_once("class/Entity.php");

trait DocumentTrait 
{
	public static function getEntityId() {
		return (Entity::getByClassName(get_called_class())->id);
	}
	public static function getRequiredTypeDocumentEntity() {
		return (TypeDocumentEntity::getFromIdEntity(self::getEntityId()));
	}
	public static function getRequiredTypeDocument() {
		$data = self::getRequiredTypeDocumentEntity();
		$rt = array();
		foreach ($data as $key => $elm)
		{
			array_push($rt, $elm->getTypeDocument());
		}
		return ($rt);
	}
	public function getDocuments($idTypeDocument) {
		return (Document::getFromIdTypeIdEntity($idTypeDocument, self::getEntityId() , $this->{static::$_primary_key}));
	}
	public function getDocumentsArray() {
		$rt = [];
		foreach ($this->getRequiredTypeDocumentEntity() as $key => $elm)
		{
			$rt[$elm->id_type_document] = $this->getDocuments($elm->id_type_document);
		}
		return ($rt);
	}
	public function getMiniDocumentArray() {
		$rt = $this->getDocumentsArray();
		foreach($rt as $key => &$elm)
		{
			foreach ($elm as $key2 => &$elm2)
			{
				//$elm2->data = null;
				unset($elm2->data);
			}
		}
		return ($rt);
	}
	public static function getAllDocument(){
		$tab = array();
		foreach (self::getRequiredTypeDocument() as $elm){
			$tab[] = $elm->id;
		}
		if (count($tab))
			return Document::getFromArray('id_type_document', $tab);
		else
			return (array());
	}

	public static function getAllDocumentMini()
	{
		if (($docs = self::getAllDocument()))
		{
			foreach ($docs as $doc)
			{
				unset($doc->data);
			}
		}
		return $docs;
	}

	public static function getTypeDocumentNeedDhValidation() {
		return (TypeDocument::getNeedDhValidation());
	}
	public static function getTypeDocumentNeedDhValidationArray() {
		$data = self::getTypeDocumentNeedDhValidation();
		$rt = array();
		foreach ($data as $key => $elm)
		{
			array_push($rt, $elm->getTypeDocument());
		}
		return ($rt);
	}
	public function getDocumentsNeedDhValidation($idTypeDocument) {
		//return (Document::getFromKeysValues);
	}
	public function getValideDocumentSignedByTypeId($id_type)
	{
		$type = typeDocument::getFromId($id_type)[0];
		if ($type->getNeedSignature())
		{
			$rt = Document::getValideSignedFromIdTypeIdEntity(
				$id_type,
				self::getEntityId(),
				$this->{static::$_primary_key}
			);
		}
		else
		{
			$rt = Document::getValideFromIdTypeIdEntity(
				$id_type,
				self::getEntityId(),
				$this->{static::$_primary_key}
			);
		}
		return ($rt);
	}
	public function getUnvalideDocumentSignedByTypeId($id_type)
	{
		return Document::getUnvalideFromIdTypeIdEntity(
			$id_type,
			self::getEntityId(),
			$this->{static::$_primary_key}
		);
	}
	public function getNewDocumentSignedByTypeId($id_type)
	{
		return Document::getNewFromIdTypeIdEntity(
			$id_type,
			self::getEntityId(),
			$this->{static::$_primary_key}
		);
	}
}
