<?php
require_once("TypeToOne.php");
class TypeToOneConseiller extends TypeToOne {

	public function __construct(&$ent, $config) {
		$config['class'] = "DonneurDOrdre";
		parent::__construct($ent, $config);
	}

	public static function isValid($data) {
		return ($data->getType()->get() == "conseiller" && parent::isValid($data));
	}

	public static function checkConfig($config) {
		$config['class'] = "DonneurDOrdre";
		return (parent::checkConfig($config));
	}

	public static function checkDb($dbName, $tableName, $config) {
		$config['class'] = "DonneurDOrdre";
		return (parent::checkDb($dbName, $tableName, $config));
	}

	public static function getVuexGetters($config, $calledClass) {
		$config['config']['class'] = "DonneurDOrdre";
		return (parent::getVuexGetters($config, $calledClass));
	}

	public function getShowComponent() {
		return ("ComponentTypeToOneConseillerShow");
	}

	public function getEditComponent() {
		return ("ComponentTypeToOneConseillerEdit");
	}
}
