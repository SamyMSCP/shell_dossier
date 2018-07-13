<?php
require_once("core/Database.php");

require_once("core/Apiv2.php");
class Acquisition extends Apiv2
{
	public $url;
	public $city;
	public $zipcode;
	public $categorie_maitre;
	public $acquisition_date;


	public static function getAll() {
		return [];
	}
	public static function get($nbr) {
		return [];
	}
	public static function getFromArray($array, $nbr) {
		$rt = parent::getRequestJsonAcquisition($array, $nbr);
		if (empty($rt))
			return (array());
		return ( $rt);
	}
	public static function getAllFromArray($array) {
		$rt = parent::getRequestJsonAcquisition($array);
		return ( $rt);
	}
	public function getUrl() {
		return ($this->url);
	}
}
