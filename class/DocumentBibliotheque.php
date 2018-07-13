<?php
require_once("core/Database.php");
require_once("core/Table.php");

class DocumentBibliotheque  extends Table
{
	protected static		$_name = "document_bibliotheque";
	protected static		$_primary_key = "id";

	public static function	getGuides() {
		return (self::getFromKeyValue("type_id", 1));
	}
	public static function	getFiches() {
		return (self::getFromKeyValue("type_id", 2));
	}
	public static function	getFichesFiscales() {
		return (self::getFromKeyValue("type_id", 3));
	}
}
