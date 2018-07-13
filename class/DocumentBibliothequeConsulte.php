<?php
require_once("core/Database.php");
require_once("core/Table.php");

class DocumentBibliothequeConsulte extends Table
{
	protected static		$_name = "document_bibliotheque_consulte";
	protected static		$_primary_key = "id";

	public static function	insertConsultation($id_dh, $id_document) {
		$old = self::getIt($id_dh, $id_document);
		DocumentBibliothequeConsulte::setLog($id_dh, $id_document);
		if (count($old) <= 0)
		{
			$rt = (self::insertNew($id_dh, $id_document));
			if (empty($rt))
				return ;
			$nElm = self::getFromId($rt)[0];
			$nElm->setCrm(0);
		}
		else
		{
			$old = $old[0];
			if (!$old->checkTimestampToday()) // Si on a déja fait une entrée aujourd'hui 
			{
				// On le met a jours
				$old->updateTimestamp();

				// On insere un nouveau crm
				$old->setCrm(0);
			}
		}

	}
	public static function setLog($id_dh, $id_document) {
		$doc = DocumentBibliotheque::getFromId($id_document)[0];
		Logger::setNew('Visualisation guide', $id_dh, $id_dh, ['Document' => $doc->name]);
	}
	public function setCrm($isOkay = 0) {
		$doc = DocumentBibliotheque::getFromId($this->id_document_bibliotheque)[0];
		Crm2::insertNew(
			$this->id_dh,
			0,
			3,
			time(),
			-2700,
			"Cet utilisateur a consulté un document sur la page Bibliothèque : " . $doc->name,
			[],
			$isOkay
		);
	}
	public function checkTimestampToday() {
		$date = $this->getDate();
		return (
			intval($date->format("Y")) == date("Y") &&
			intval($date->format("m")) == date("m") &&
			intval($date->format("d")) == date("d")
		);
	}
	public static function getIt($id_dh, $id_document) {
		return (parent::getFromKeysValues([
			"id_dh"						=> $id_dh,
			"id_document_bibliotheque"	=> $id_document
		]));
	}
	public static function insertNew($id_dh, $id_document) {
		$req = "INSERT INTO `document_bibliotheque_consulte`(id_dh, id_document_bibliotheque, timestamp) VALUES (?, ?, ?);";
		$data = [
			$id_dh,
			$id_document,
			time()
		];
		return Database::prepareInsert(static::$_db, $req, $data);
	}

	public function updateTimestamp() {
		$this->updateOneColumn("timestamp", time());
	}
	public function getDate() {
		$rt = new DateTime;
		$rt->setTimestamp($this->timestamp);
		return ($rt);
	}
}
