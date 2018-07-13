<?php
require_once("core/Database.php");
require_once("core/Table.php");

class Document extends Table
{
	protected static		$_name = "documents";
	protected static		$_primary_key = "id";

	private					$_dateExecution = null;
	private					$_dateCreation= null;
	private					$_data = null;
	private					$_idtype = null;
	private					$_type = null;
	public static			$_noSecure = ["commentaire"];

	public static function insert($id_type, $data)
	{
		return false;
	}

	public static function getFromIdTypeId($idType) {
		return (parent::getFromKeyValue("id_type_document", $idType));
	}

	public static function getFromIdTypeIdEntity($idType, $idEntity, $linkEntity) {
		$req = "SELECT `documents`.* FROM `documents` INNER JOIN `documents_entity` ON `documents`.id = `documents_entity`.id_documents WHERE `documents_entity`.id_entity = ? AND `documents`.id_type_document = ? AND `documents_entity`.link_entity = ?";
		$data = array(
			$idEntity,
			$idType,
			$linkEntity
		);
		return Database::prepare(static::$_db, $req, $data, "Document");
	}
	public static function getValideSignedFromIdTypeIdEntity($idType, $idEntity, $linkEntity) {
		$req = "SELECT `documents`.* FROM `documents` INNER JOIN `documents_entity` ON `documents`.id = `documents_entity`.id_documents WHERE `documents_entity`.id_entity = ? AND `documents`.id_type_document = ? AND `documents_entity`.link_entity = ? AND date_execution <= " .  time() . " AND date_expiration >= " . time()  . " AND signed = 1;";
		$data = array(
			$idEntity,
			$idType,
			$linkEntity
		);
		return Database::prepare(static::$_db, $req, $data, "Document");
	}
	public static function getLastValideSignedFromIdTypeIdEntity($idType, $idEntity, $linkEntity) {
		$req = "SELECT `documents`.* FROM `documents` INNER JOIN `documents_entity` ON `documents`.id = `documents_entity`.id_documents WHERE `documents_entity`.id_entity = ? AND `documents`.id_type_document = ? AND `documents_entity`.link_entity = ? AND date_execution <= " .  time() . " AND date_expiration >= " . time()  . " AND signed = 1 ORDER BY date_execution DESC LIMIT 1;";
		$data = array(
			$idEntity,
			$idType,
			$linkEntity
		);
		return Database::prepare(static::$_db, $req, $data, "Document");
	}
	public static function getValideFromIdTypeIdEntity($idType, $idEntity, $linkEntity) {
		$req = "SELECT `documents`.* FROM `documents` INNER JOIN `documents_entity` ON `documents`.id = `documents_entity`.id_documents WHERE `documents_entity`.id_entity = ? AND `documents`.id_type_document = ? AND `documents_entity`.link_entity = ? AND date_execution <= " .  time() . " AND date_expiration >= " . time()  . ";";
		$data = array(
			$idEntity,
			$idType,
			$linkEntity
		);
		return Database::prepare(static::$_db, $req, $data, "Document");
	}
	public static function getUnvalideFromIdTypeIdEntity($idType, $idEntity, $linkEntity) {
		$req = "SELECT `documents`.* FROM `documents` INNER JOIN `documents_entity` ON `documents`.id = `documents_entity`.id_documents WHERE `documents_entity`.id_entity = ? AND `documents`.id_type_document = ? AND `documents_entity`.link_entity = ? AND ( date_execution >= " .  time() . " OR date_expiration >= " . time()  . " );";
		$data = array(
			$idEntity,
			$idType,
			$linkEntity
		);
		return Database::prepare(static::$_db, $req, $data, "Document");
	}
	public static function getNewFromIdTypeIdEntity($idType, $idEntity, $linkEntity) {
		$req = "SELECT `documents`.* FROM `documents` INNER JOIN `documents_entity` ON `documents`.id = `documents_entity`.id_documents WHERE `documents_entity`.id_entity = ? AND `documents`.id_type_document = ? AND `documents_entity`.link_entity = ? AND  date_execution IS NULL;";
		$data = array(
			$idEntity,
			$idType,
			$linkEntity
		);
		return Database::prepare(static::$_db, $req, $data, "Document");
	}
	public static function getFromIdType($idType) {
		$req = "SELECT * FROM `documents` WHERE id_type_document = ?";
		$data = array(
			$idType
		);
		return Database::prepare(static::$_db, $req, $data, "Document");
	}
	public static function getOnlineFromIdType($idType) {
		$req = "SELECT * FROM `documents` WHERE id_type_document = ? AND online = 1";
		$data = array(
			$idType
		);
		return Database::prepare(static::$_db, $req, $data, "Document");
	}
	public static function getOnlineFromNameType($name) {
		$req = "SELECT `documents`.* FROM `documents` INNER JOIN `type_document` ON `documents`.id_type_document = `type_document`.id WHERE `type_document`.name = ? AND `documents`.online = 1";
		$data = array(
			$name
		);
		return Database::prepare(static::$_db, $req, $data, "Document");
	}
	public static function getFromNameType($name) {
		$req = "SELECT `documents`.* FROM `documents` INNER JOIN `type_document` ON `documents`.id_type_document = `type_document`.id WHERE `type_document`.name = ?";
		$data = array(
			$name
		);
		return Database::prepare(static::$_db, $req, $data, "Document");
	}
	public function checkDhValidate($id_dh) {
		$rt = DocumentDhValidation::getFromDhDocument($id_dh, $this->id);
		if (count($rt))
			return (true);
		else
			return (false);
	}
	public function setValidateForDh($id_dh) {
		$params = [
			"document name" => $this->filename
		];
		$dhExecutant = Dh::getCurrent();
		if (empty($dhExecutant))
			$dhExecutant = $id_dh;
		else
			$dhExecutant = $dhExecutant->id_dh;
		Logger::setNew("Validation d'un document", $dhExecutant, $id_dh, $params);
		return (DocumentDhValidation::setValidate($id_dh, $this->id));
	}

	public static function updateNewWithOnline($id, $online) {
		if (!empty($dateExecution))
			$dateExecution = DateTime::createFromFormat("Y-m-d", $dateExecution)->getTimestamp();
		else
			$dateExecution = 0;
		$date_creation = (new DateTime(date("Y-m-d")))->getTimestamp();
		$req = "UPDATE `documents` 
			SET online = ? WHERE id = ?";
		$data = array(
			$online,
			$id
		);
		$id = Database::prepareInsert(static::$_db, $req, $data);
		return $id;
	}

	public static function insertNewWithOnline($idType, $idEntity, $linkEntity, $datas, $type, $filename, $dateExecution, $online) {
		if (!empty($dateExecution))
			$dateExecution = DateTime::createFromFormat("Y-m-d", $dateExecution)->getTimestamp();
		else
			$dateExecution = 0;
		$date_creation = (new DateTime(date("Y-m-d")))->getTimestamp();
		$req = "INSERT INTO `documents` 
			(id_type_document, date_creation, type, filename, online)
			VALUES (?, ?, ?, ?, ?)";
		$data = array(
			$idType,
			$date_creation,
			$type,
			$filename,
			$online
		);
		$id = Database::prepareInsert(static::$_db, $req, $data);

		$doc = self::getFromId($id);
		if (empty($doc))
			return (null);
		$doc = $doc[0];

		$req = "INSERT INTO `documents_entity` 
			(id_documents, id_entity, link_entity)
			VALUES (?, ?, ?)";
		$data = array(
			$id,
			$idEntity,
			$linkEntity
		);
		$link = Database::prepareInsert(static::$_db, $req, $data);
		if (empty($link)) {
			$doc->deleteMe();
			exit();
		}
		$doc->saveCryptedData($datas);
		return ($link);
		//return Database::prepareInsert(static::$_db, $req, $data);
	}
	public static function insertNewNoTime($idType, $idEntity, $linkEntity, $datas, $type, $filename, $dateExecution) {
		$date_creation = (new DateTime(date("Y-m-d")))->getTimestamp();
		// TODO upgrade fileSystem
		$req = "INSERT INTO `documents` 
			(id_type_document, date_creation, type, filename)
				VALUES (?, ?, ?, ?)";
			
		$data = array(
			$idType,
			time(),
			$type,
			$filename
		);
		$id = Database::prepareInsert(static::$_db, $req, $data);

		$doc = self::getFromId($id);
		if (empty($doc))
			return (null);
		$doc = $doc[0];

		$req = "INSERT INTO `documents_entity` 
			(id_documents, id_entity, link_entity)
			VALUES (?, ?, ?)";
		$data = array(
			$id,
			$idEntity,
			$linkEntity
		);
		$link = Database::prepareInsert(static::$_db, $req, $data);
		if (empty($link)) {
			$doc->deleteMe();
			exit();
		}
		$doc->saveCryptedData($datas);
		return ($link);
		//return Database::prepareInsert(static::$_db, $req, $data);
	}
	public static function insertNew($idType, $idEntity, $linkEntity, $datas, $type, $filename, $dateExecution) {
		if (!empty($dateExecution))
			$dateExecution = DateTime::createFromFormat("Y-m-d", $dateExecution)->getTimestamp();
		else
			$dateExecution = time();
		$date_creation = (new DateTime(date("Y-m-d")))->getTimestamp();
		$req = "INSERT INTO `documents` 
			(id_type_document, date_creation, type, filename, date_execution, date_expiration)
				VALUES (?, ?, ?, ?, ?, ?)";

		if ($idType == 4)
			$date_expiration = $dateExecution + TIME_LETTRE_MISSION_VALID;
		else
			$date_expiration = $dateExecution + TIME_SITUATION_VALID;
			
		$data = array(
			$idType,
			time(),
			$type,
			$filename,
			$dateExecution,
			$date_expiration
		);
		$id = Database::prepareInsert(static::$_db, $req, $data);

		$doc = self::getFromId($id);
		if (empty($doc))
			return (null);
		$doc = $doc[0];


		$req = "INSERT INTO `documents_entity` 
			(id_documents, id_entity, link_entity)
			VALUES (?, ?, ?)";
		$data = array(
			$id,
			$idEntity,
			$linkEntity
		);
		$link = Database::prepareInsert(static::$_db, $req, $data);
		if (empty($link)) {
			$doc->deleteMe();
			exit();
		}
		$doc->saveCryptedData($datas);
		return ($link);
	}
	public function deleteMe() {
		$data = array(
			$this->id
		);
		$req = "DELETE FROM `documents_entity` WHERE id_documents = ?";
		$rt = Database::prepareNoClass(static::$_db, $req, $data);
		if (empty($rt))
			return false;
		$req = "DELETE FROM `documents` WHERE id = ?";
		return Database::prepareNoClass(static::$_db, $req, $data);
	}
	public static function getFromDocumentEntityId($id) {
		$req = "SELECT id_documents FROM `documents_entity` WHERE id = ?";
		$tmp = Database::getNoClass(static::$_db, $req, [$id]);
		if (empty($tmp))
			return (null);
		return (parent::getFromId($tmp[0]['id_documents']));
	}
	public function getDateExecution() {
		if (empty($this->_dateExecution))
			$this->_dateExecution = "";
		if ($this->_dateExecution == null)
		{
			$this->_dateExecution = new DateTime;
			$this->_dateExecution->setTimestamp($this->date_execution); 
		}
		return ($this->_dateExecution);
	}
	public function getDateCreation() {
		if (empty($this->_dateCreation))
			$this->_dateCreation = "";
		if ($this->_dateCreation == null)
		{
			$this->_dateCreation = new DateTime;
			$this->_dateCreation->setTimestamp($this->date_creation); 
		}
		return ($this->_dateCreation);
	}
	public function getData() {
		// TODO nettoyer ici pour renvoyer le bon fichier.
		if ($this->_data == null) {
			if (file_exists(DOCUMENT_PATH . $this->getCryptedFilename()))
				$this->_data = ft_decode_file(file_get_contents(DOCUMENT_PATH . $this->getCryptedFilename()));
			else
				$this->_data = file_get_contents("../document/document_defaut.pdf");
		}
		return ($this->_data);
	}
	public function getType() {
		if ($this->_type== null)
		{
			$this->_type= $this->type;
		}
		return ($this->_type);
	}
	public function getTypeDocument() {
		if ($this->_idtype == null)
		{
			$this->_idtype = TypeDocument::getFromId($this->id_type_document);
			if (count($this->_idtype))
				$this->_idtype = $this->_idtype[0];
		}
		return ($this->_idtype);
	}
	public function getFilename() {
		return (htmlspecialchars($this->filename));
	}
	public function isOnline() {
		if ($this->online == 1)
			return (true);
		return (false);
	}
	public function getIdUniversign() {
		return ($this->id_universign);
	}
	public function setUniversignComplete() {
	// TODO Il faut récupérer ledocument et remplacer la version non signé par le nouveau.
		
		// TODO upgrade fileSystem
		$this->updateOneColumn('date_execution', time());
		$this->updateOneColumn('signed', 1);
		$this->updateOneColumn('date_expiration', time() + TIME_LETTRE_MISSION_VALID);
		$this->saveCryptedData(ft_simple_encryption_file(Signature::getDocumentById($this->getIdUniversign())));
		//$this->updateOneColumn("data", ft_simple_encryption_file(Signature::getDocumentById($this->getIdUniversign())));
	}
	public function isSigned() {
		if (empty($this->signed))
			return (false);
		return (true);
	}
	public function toogleSigned() {
		if (empty($this->signed))
			$this->updateOneColumn("signed", 1);
		else
			$this->updateOneColumn("signed", 0);
	}
	public function isValidated()
	{
		if (empty($this->validated_by))
			return false;
		return true;
	}
	public function getEntity() {
		$entity = Entity::getFromIdDocument($this->id);
		return ($entity[0]->class::getFromId($entity[0]->link_entity));
	}

	public function checkAuthorisation($dh) {
		if (count($this->getEntity()))
			return ($this->getEntity()[0]->checkAuthorisation($dh));
		return (false);
	}
	public function saveData($data) {
		return ($this->saveCryptedData(ft_simple_encryption_file($data)));
	}
	public function saveCryptedData($data) {
		return (file_put_contents(DOCUMENT_PATH . $this->getCryptedFilename(), $data));
	}
	public function getCryptedFilename() {
		return (str_replace("/", "_", ft_crypt_information($this->id)));
	}
	public function deleteDocument() {
		$req = "DELETE FROM `document_dh_validation` WHERE id_document = ?";
		Database::prepareNoClass(static::$_db, $req, [$this->id]);

		$req = "DELETE FROM `documents_entity` WHERE id_documents = ?";
		Database::prepareNoClass(static::$_db, $req, [$this->id]);


		$req = "DELETE FROM `documents_entity` WHERE id_documents = ?";
		

		$rt = unlink(DOCUMENT_PATH . $this->getCryptedFilename());

		$req = "DELETE FROM `documents` WHERE id = ?";
		return (Database::prepareNoClass(static::$_db, $req, [$this->id]));
	}
}
