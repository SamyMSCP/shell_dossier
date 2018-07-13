<?php
require_once("TypeToOne.php");
class TypeToOneObjectifsList extends TypeToOne {

	public function __construct(&$ent, $config) {
		$config['class'] = "ObjectifsList2";
		parent::__construct($ent, $config);
	}

	public static function checkConfig($config) {
		$config['class'] = "ObjectifsList2";
		return (parent::checkConfig($config));
	}

	public static function checkDb($dbName, $tableName, $config) {
		$config['class'] = "ObjectifsList2";
		return (parent::checkDb($dbName, $tableName, $config));
	}

	public static function getVuexGetters($config, $calledClass) {
		$config['config']['class'] = "ObjectifsList2";
		return (parent::getVuexGetters($config, $calledClass));
	}

	public function getShowComponent() {
		//return ("ComponentTypeToOneObjectifsListShow");
		return ("ComponentTypeShow");
	}

	public function getEditComponent() {
		return ("ComponentTypeToOneObjectifsListEdit");
	}
}
