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
/*                |_|                                  */

/*
	Ceci est la classe père pour les Type de données

	config si il est transmis permet de configurer le fonctionnement du type.
*/

class Type {
	protected static $_sqlColumn = "";
	protected static $_defaultValue = null;
	protected static $_errorMsg = "-";
	protected $_config = [];
	protected $_valueCached = null;
	protected $_entity = null;

	protected static $_components = [
		"show" => [
			"name" => "ComponentTypeShow",
			"config" => []
		],
		"edit" => [
			"name" => "ComponentTypeEdit",
			"config" => []
		]
	];

	protected  static function isValid($val) {
		return (true);
	}

	public function checkData() {
		if (isset($this->_config['notCheck'])  && $this->_config['notCheck'] === true )
			return (true);
		if (isset($this->_config['canEmpty'])  && $this->_config['canEmpty'] === true && empty($this->getRawValue()))
			return (true);
		return (static::isValid($this->get()));
	}

	public function checkValid(){
		return (static::isValid($this->get()));
	}

	public function __construct(&$ent, $config) {
		$this->_entity = $ent;
		$this->_config = $config;
		if (isset($this->_config["defaultValue"]))
			$this->_entity->setValue($this->_config['column'], $this->_config["defaultValue"]);
	}

	public function setConfig($name, $data) {
		$this->_config[$name] = $data;
	}

	public function getConfig($name) {
		return ($this->_config[$name]);
	}

	public function set($val) {
		$val = static::beforeSet($val);

		// Si l'utilisateur n'a pas les droits d'écriture lors on ne fait rien du tout !
		if (!$this->_entity->canSetValue($this->_config['column']))
			return (false);

		// Vérification de la validité de la donnée
		if (!static::isValid($val))
			return (false);

		return ($this->setNoControl($val));
	}

	public function setNoControl($val) {

		// Enregistrement de la donnée
		if (!$this->_entity->setValue($this->_config['column'], static::prepareSet($val)))
			return (false);

		$this->_valueCached = $val;
		return (true);
	}

	public function setControlEmpty($val) {

		// Enregistrement de la donnée
		if (!$this->_entity->setValueNoControl($this->_config['column'], static::prepareSet($val)))
			return (false);

		$this->_valueCached = $val;
		return (true);
	}

	public function get() {

		// Si l'utilisateur n'a pas les droits de lecture alors on retourne false;
		if (!$this->_entity->canGetValue($this->_config['column']))
			return (false);

		if ($this->_valueCached == null)
			$this->_valueCached = static::prepareGet($this->_entity->getValue($this->_config['column']));

		return (static::beforeGet($this->_valueCached));
	}

	/*
		Cette methode est appelée avant de set une donnée la methode valueCached Béneficie donc également de cette transformation
	*/
	protected static function beforeSet($val) {
		return ($val);
	}

	/*
		Cette methode est appelée lors d'un get et est donc également appliquée à value cached lors de la récupération
	*/
	protected static function beforeGet($val) {
		return ($val);
	}

	/*
		C'est la methode qui se place entre la valeur en db et la valeur qui sera utilisée lors d'un get.
	*/
	protected static function prepareGet($val) {
		//if (!static::isValid($val))
			//return (false);
		return ($val);
	}

	/*
		C'est la methode qui se place entre la valeur insérée et la valeur qui sera en db apres un commit
	*/
	protected static function prepareSet($val) {
		//if (!static::isValid($val))
			//return (false);
		return ($val);
	}

	public function getRawValue() {
		if (!$this->_entity->canGetValue($this->_config['column']))
			return (false);
		return ($this->_entity->getValue($this->_config['column']));
	}

	public function setRawValue($val) {
		$this->_valueCached = static::prepareGet($val);
		//$this->_entity->setValue($this->_entity->getValue($this->_config['column']),$val);
		$this->_entity->setRawValue($this->_config['column'], $val);
		//static::prepareGet($this->_entity->getValue($this->_config['column']));
	}

	public function readComponent() {
		return (null);
	}

	public function showComponent() {
		return ($this->_value);
	}

	public function editComponent($path) {
		// Ne devrait-il pas simplement retourner le nom du component ??
		//return ("<input v-model='" . $path .  "'/>");
	}

	public static function getSqlColumn() { return (static::$_sqlColumn); }

	// TODO Faire la methode de vérification
	public static function verify() { 
		if (
			!isset(static::$_sqlColumn) ||
			!is_string(static::$_sqlColumn) ||
			strlen(static::$_sqlColumn) < 3
		)
			return (false);
		return (true);
	}

	public static function setToDb($dbName, $tableName, $config) {
		$req = "ALTER TABLE `" . $tableName . "` ADD COLUMN `" . $config['column'] . "` " . static::getSqlColumn() . ";";
		Database::request($dbName, $req);
	}

	public static function checkDb($dbName, $tableName, $config) {
		$req = "DESC `" . $tableName . "`;";
		foreach (Database::request($dbName, $req) as $key => $elm)
		{
			if ($elm['Field'] === $config['column'] &&
				$elm['Type'] === static::getSqlColumn()
			)
				return (true);
		}
		return (false);
	}

	public static function normalize($val, $config) {
		return ($val);
	}

	public function getError() {
		return (static::$_errorMsg);
	}

	public function getForState($getError = false) {
		if (!$this->_entity->canGetValue($this->_config['column']))
			return ([]);
		$rt = [
			$this->_config['column'] =>  [
				"value" => $this->get(),
				"canSet" => $this->_entity->canSetValue($this->_config['column'])
			]
		];
		if (!$this->checkData() && $getError)
			$rt[$this->_config['column']]['error'] = $this->getError();
		return ($rt);
	}

	public function getShowComponent() {
		return ("ComponentTypeShow");
	}

	public function getEditComponent() {
		return ("ComponentTypeEdit");
	}

	public function setForGraphApi($data) {
		if (!$this->_entity->canSetValue($this->_config['column']))
			return (false);

		if (!is_array($data))
			return (false);
		
		$val = static::beforeSet($data[$this->_config['column']]['value']);
		$tmp = $this->setNoControl($val);
		$rt =  $this->checkData();
		return ($rt);
	}
}
