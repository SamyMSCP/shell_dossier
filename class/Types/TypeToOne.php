<?php
class TypeToOne extends TypeRelation {

	private static $_primary_type = "int(11)";
	private $_valueCached = null;

	public static function verify() {
		return (true);
	}

	public function checkData() {

		if (isset($this->_config['notCheck'])  && $this->_config['notCheck'] === true )
			return (true);
		if (isset($this->_config['canEmpty'])  && $this->_config['canEmpty'] === true && empty($this->getRawValue()))
			return (true);
		// Cette methode sert à vérifier si cette instance est valable.
		// Elle vérifie si la données enregistrée est bien pointé par quelque chose.
		// Si la donnée est facultative "canEmpty === true ?" alors elle authorise que la valeure soit nulle.
		$data = $this->_config['class']::getById($this->_entity->getValue($this->_config['column']));
		return (
			(
				$data instanceof $this->_config['class'] &&
				static::isValid($data)
			)
			||
				(isset($this->_config['canEmpty'])  && $this->_config['canEmpty'] === true && empty($this->_entity->getValue($this->_config['column'])))
		);
	}

	public function setById($id) {
		$entity = $this->_config['class']::getById($id);
		if (empty($entity))
			return (false);
		return ($this->set($entity));
	}

	public function setNoControl($value) {
		// Le setter travail directement avec une instance de la classe pointée.
		// On vérifie que cette donnée est bien celle attendue.
		//var_dump(); error();
		$this->_valueCached = $this->_config['class']::getById($value);
		$this->_entity->setValue($this->_config['column'], $value);
		return (true);
	}

	public static function isValid($data) {
		return (true);
	}

	public function set($value) {

		if (!static::isValid($value))
			return (false);

		if (!($value instanceof $this->_config['class']))
			return (false);

		return ($this->setNoControl($value->getId()));
	}

	public function get() {

		// Si il n'y a pas encore eu de récupération alors on met en cache le retour.
		if ($this->_valueCached == null && !empty($this->_entity->getValue($this->_config['column'])))
		{
			$this->_valueCached = $this->_config['class']::getById($this->_entity->getValue($this->_config['column']));
			//$this->_valueCached->normalize();
		}
		if (!($this->_valueCached instanceof $this->_config['class']))
			$this->_valueCached = null;
		return ($this->_valueCached);

	}

	public static function setToDb($dbName, $tableName, $config) {

		// On ajoute la colonne qui stoque l'id ici.
		$req = "ALTER TABLE `" . $tableName . "` ADD COLUMN `" . $config['column'] . "` " . static::$_primary_type . ";";
		return (Database::request($dbName, $req));
	}

	public static function checkConfig($config) {
		// Vérification des données de configuration minimales
		if (!isset($config['column']) || !isset($config['class']))
			return (false);
		return (true);
	}

	public static function checkDb($dbName, $tableName, $config) {

		if (!static::checkConfig($config))
			return (false);

		// Vérification si la Db à tout ce qu'il faut pour continuer.
		// Vérifier que la classe en relation existe bien.
		if (!class_exists($config['class']))
			return (false);

		// Vérifier que la table de la classe en relation existe;
		if (!$config['class']::tableExist())
			return (false);

		// Vérifier que la table de la classe existe;
		if (Database::request($dbName, "SHOW TABLES LIKE \"" . $tableName . "\"")->rowCount() === 0)
			return (false);

		// Vérifier que la Table de notre classe à bien la colonne demandé et qu'elle est dans un format adéquate;
		$req = "DESC `" . $tableName . "`;";
		foreach (Database::request($dbName, $req) as $key => $elm)
		{
			if ($elm['Field'] === $config['column'] &&
				$elm['Type'] === static::$_primary_type
			)
				return (true);
		}
		return (false);
	}

	public static function getVuexGetters($config, $calledClass) {

		$class = $config['config']['class'];
		$column = $config['config']['column'];
		$name = "get" . $calledClass . "_" . $column;

		$rt = [
			$name => "
				return (
					function(id) {
						var join = getters.get{$class}ById(id);

						if (typeof join == 'undefined')
							return (null);

						return (state.datas.$calledClass.lst.filter(function (elm) {
							//return (elm.$column.value === join.id.value);
							return (elm.$column.value === join.id.value);
						}));
					}
				);
			"
		];
		return ($rt);
	}

	public function getForState($getError = false) {
		if (!$this->_entity->canGetValue($this->_config['column']))
			return ([]);
		$rt = [
			$this->_config['column'] =>  [
				"value" => $this->getRawValue(),
				"canSet" => $this->_entity->canSetValue($this->_config['column'])
			]
		];
		if (!$this->checkData() && $getError)
			$rt[$this->_config['column']]['error'] = $this->getError();
		return ($rt);
	}

	public function setForGraphApi($data) {

		if (!$this->_entity->canSetValue($this->_config['column']))
			return (false);

		if (!is_array($data))
			return (false);
		return ($this->setNoControl($data[$this->_config['column']]['value']));
	}

}
