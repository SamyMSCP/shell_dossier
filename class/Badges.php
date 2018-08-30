<?php
require_once("core/Database.php");
require_once("core/Table.php");

class ListeBadges  extends Table
{
    protected static		$_name = "Badges";
    protected static		$_primary_key = "id";

    public static function	getGeographie() {
        return (self::getFromKeyValue("categorie", 1));
    }
    public static function	getTypeScpi() {
        return (self::getFromKeyValue("categorie", 2));
    }
    public static function	getCategorieScpi() {
        return (self::getFromKeyValue("categorie", 3));
    }
    public static function	getTypeProprietaire() {
        return (self::getFromKeyValue("categorie", 4));
    }
    public static function	getNombreScpi() {
        return (self::getFromKeyValue("categorie", 5));
    }
    public static function	getDuree() {
        return (self::getFromKeyValue("categorie", 6));
    }
    public static function	getAutre() {
        return (self::getFromKeyValue("categorie", 7));
    }

}

