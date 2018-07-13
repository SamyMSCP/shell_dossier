<?php
require_once("core/Database.php");
require_once("core/Apiv2.php");
class Actuality extends Apiv2
{
	public $title;
	public $token;
	public $slug;
	public $date_publication;

	public static function getAll() {
		return (parent::getRequestJsonAllActus());
	}
	public static function getFromArray($array, $nbr = null) {
		if ($nbr == null)
			return (parent::getRequestJsonActusFromScpi($array));
		else
			return (parent::getRequestJsonActusFromScpi($array, $nbr));
	}
	public static function getAllFromSCPI($id_scpi) {
		return (self::getFromArray([$id_scpi], 30));
	}
	public static function getAllFromArray($array) {
		return (self::getFromArray($array, 30));
	}
	public static function get($nbr) {
		return (parent::getRequestJsonAllActus($nbr));
	}
	public function getUrl() {
		return ($this->url);
	}

	public function getDatePublication() {
		return (new DateTime($this->publicationDate['date']));
	}
}
