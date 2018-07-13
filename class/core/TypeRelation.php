<?php
/*      __  __        _  _  _                          */
/*     |  \/  |  ___ (_)| || |  ___  _   _  _ __  ___  */
/*     | |\/| | / _ \| || || | / _ \| | | || '__|/ _ \ */
/*     | |  | ||  __/| || || ||  __/| |_| || |  |  __/ */
/*     |_|  |_| \___||_||_||_| \___| \__,_||_|   \___| */
/*                        _                            */
/*      ___   ___  _ __  (_)    ___  ___   _ __ ___    */
/*     / __| / __|| '_ \ | |   / __|/ _ \ | '_ ` _ \   */
/*     \__ \| (__ | |_) || | _| (__| (_) || | | | | |  */
/*     |___/ \___|| .__/ |_|(_)\___|\___/ |_| |_| |_|  */
/*                |_|                                  */ /* Ceci est la classe principale pour les Relation entre Tables

	config permet de configurer la relation
*/

class TypeRelation {

	protected static $_errorMsg = "La valeur n'est pas convenable";

	protected  $_config = [];

	public function __construct(&$ent, $config) {
		$this->_entity = $ent;
		$this->_config = $config;
	}

	public function set($value) {}
	public function get() {}
	
	public static function verify() { 
		return (true);
	}

	public static function checkDb($dbName, $tableName, $config) {
		return (true);
	}

	public static function normalize($val, $config) {
		if (!empty($val))
			return (intval($val));
		return (null);
	}

	public function forceConfig($config) {
		$this->_config = $config;
	}

	public static function checkConfig($config) {
		return (true);
	}

	public function getRawValue() {
		if (!$this->_entity->canGetValue($this->_config['column']))
			return (false);
		return ($this->_entity->getValue($this->_config['column']));
	}

	public function setRawValue($val) {
		$this->_valueCached = static::prepareGet($val);
		$this->_entity->setValue($this->_entity->getValue($this->_config['column']),$val);
	}

	public function getError() {
		return (static::$_errorMsg);
	}

	public function getForState($getError = false) { return ([]); }

	public function getShowComponent() {
		return ("ComponentTypeShow");
	}

	public function getEditComponent() {
		return ("ComponentTypeEdit");
	}

	public static function getVuexGetters($config, $calledClass) {
		return ([]);
	}

	public function setForGraphApi($data) {
		return (true);
	}

	public function commit () { return (true); }


	public function setConfig($name, $data) {
		$this->_config[$name] = $data;
	}
}
