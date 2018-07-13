<?php
require_once("core/Database.php");
require_once("core/Apiv2.php");
class Publication extends Apiv2
{
	public $date_published;
	public $title;
	public $path;

	public static function getAll() {
		return ([]);
	/*
		$rt = parent::getRequestObjects(
				array(
					"req" => "getPublication"
					)
			);
		return ( $rt);
			*/
	}
	public static function getFromArray($array, $nbr) {
		if ($nbr == null)
			return (self::getRequestJsonPublications($array));
		else
			return (self::getRequestJsonPublications($array, $nbr));
		return ([]);
	/*
		$rt = parent::getRequestObjects(
				array(
					"req" => "getPublicationSCPIs",
					"lst" => json_encode($array, JSON_FORCE_OBJECT),
					"limit" => $nbr
					)
			);
		return ( $rt);
			*/
	}
	public static function getAllFromSCPI($id_scpi) {
		return (self::getFromArray([$id_scpi], 30));
		return ([]);
		/*
		$rt = parent::getRequestObjects(
				array(
					"req" => "getPublicationSCPIs",
					"lst" => json_encode([$id_scpi], JSON_FORCE_OBJECT)
					)
			);
		return ( $rt);
		*/
	}
	public static function getAllFromArray($array) {
		return (self::getFromArray($array, 30));
		return ([]);
		/*
		$rt = parent::getRequestObjects(
				array(
					"req" => "getPublicationSCPIs",
					"lst" => json_encode($array, JSON_FORCE_OBJECT)
					)
			);
		return ( $rt);
		*/
	}
	public static function get($nbr) {
		return ([]);
		$rt = parent::getRequestObjects(
				array(
					"req" => "getPublication",
					"limit" => $nbr
					)
			);
		return ( $rt);
	}
	public function getUrl() {
		//return (DOMAIN_NAME . $this->path);
		return ($this->path);
	}
	public function getDatePublication() {
		return (new DateTime($this->publishedAt['date']));
		//return (new Datetime($this->date_published));
	}
}
