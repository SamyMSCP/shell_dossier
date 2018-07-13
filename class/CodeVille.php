<?php
require_once("core/Database.php");
require_once("core/Table.php");

/*
	id
	Code_commune_INSEE
	Nom_commune
	Code_postal
	Libelle_acheminement
	Ligne_5
	latitude
	longitude
*/
class CodeVille  extends Table
{
	protected static		$_name = "code_ville";
	protected static		$_primary_key = "id";
	static					$_to_save = [
		"id",
		"Code_commune_INSEE",
		"Nom_commune",
		"Code_postal",
		"Libelle_acheminement",
		"Ligne_5",
		"latitude",
		"longitude",
	];

	private function setId($_id) {
		$this->id = $_id;
	}

	public function getId() {
		return($this->id);
	}

	public function getCodeCommuneINSEE() {
		return($this->Code_commune_INSEE);
	}

	public function setCodeCommuneINSEE($_Code_commune_INSEE) {
		$this->Code_commune_INSEE = $_Code_commune_INSEE;
	}

	public function getNomCommune() {
		return($this->Nom_commune);
	}

	public function setNomCommune($_Nom_commune) {
		$this->Nom_commune = $_Nom_commune;
	}

	public function getCodePostal() {
		return($this->Code_postal);
	}

	public function setCodePostal($_Code_postal) {
		$this->Code_postal = $_Code_postal;
	}

	public function getLibelleAcheminement() {
		return($this->Libelle_acheminement);
	}

	public function setLibelleAcheminement($_Libelle_acheminement) {
		$this->Libelle_acheminement = $_Libelle_acheminement;
	}

	public function getLigne5() {
		return($this->Ligne_5);
	}

	public function setLigne5($_Ligne_5) {
		$this->Ligne_5 = $_Ligne_5;
	}
		
	public function getLatitude() {
		return($this->latitude);
	}

	public function setLatitude($_latitude) {
		$this->latitude = $_latitude;
	}

	public function getLongitude() {
		return($this->longitude);
	}

	public function setLongitude($_longitude) {
		$this->longitude = $_longitude;
	}
	public static function getFromCodeCommune($code, $commune)
	{
		$code = trim($code);
		$commune = trim($commune);
		if (strlen($code) < 3 && strlen($commune) < 3)
			return ([]);
		if (strlen($commune) < 3)
			return (self::getFromCode($code));
		if (strlen($code) < 3)
			return (self::getFromCommune($commune));
		//$req = "SELECT * FROM `code_ville` WHERE Nom_commune LIKE ? OR Code_postal  LIKE ? LIMIT 10";
		$rt = self::getFromCode($code);
		foreach (self::getFromCommune($commune) as $key => $elm)
		{
			$tmp = false;
			foreach ($rt as $key2 => $elm2)
			{
				if ($elm2->id == $elm->id)
					$tmp = true;
			}
			if (!$tmp)
			$rt[] = $elm;
		}
		return ($rt);
		//return (Database::prepare(static::$_db, $req, [$commune . "%", $code . "%"], get_called_class()));
	}
	public static function getFromCode($code)
	{
		if (strlen($code) < 3)
			return ([]);
		$code = trim($code);
		$req = "SELECT * FROM `code_ville` WHERE Code_postal  LIKE ? LIMIT 25";
		return (Database::prepare(static::$_db, $req, [$code . "%"], get_called_class()));
		//else
			//return (parent::getFromKeyValue("Code_postal", $code));
	}
	public static function getFromCommune($commune)
	{
		$commune = trim($commune);
		if (strlen($commune) < 3)
			return ([]);
		$req = "SELECT * FROM `code_ville` WHERE Nom_commune LIKE ? LIMIT 25";
			return (Database::prepare(static::$_db, $req, [$commune . "%"], get_called_class()));
	}
}
