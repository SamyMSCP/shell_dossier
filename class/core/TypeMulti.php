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
	Ceci est la classe père pour les Type de données multi colonnes
	La classe TypeMulti permet de travailler sur plusieures colonnes.

	config si il est transmis permet de configurer le fonctionnement du type.
*/

/*
	Exemple de configuration pour les adresse : 
	"column" => [
		"numeroRue" => "numeroRue",
		"extension" => "extension",
		"type_voie" => "type_voie",
		"voie" => "voie",
		"complementAdresse" => "complementAdresse",
		"codePostal" => "codePostal",
		"ville" => "ville",
		"pays" => "pays"
	]
	La clée est le utilisées par le Type.
	la donnée est le nom de la colonne dans la TABLE

	Puis pour l'utilisation, il faudra utiliser le nom demandée par le Type et non pas le nom de la colonne.
*/
class TypeMulti  {
	protected static $_sqlColumn = [
		"testInt" => "int(11)",
		"testString" => "text",
		"testString2" => "text",
	];
	protected static $_defaultValue = null;
	protected $_config = [];
	protected $_valueCached = [];
	protected $_errorMsg = "-";
	protected $_entity = null;

	// Les données arrivent dans un format qui serait avant le prepareGet 
	// ou apres le prepareSet() dans le cas ou on aurais des données cryptées par exemple
	protected  static function isValid($values, $getError = null) {
		return (true);
	}

	public function checkData($getError = null) {
		if (isset($this->_config['notCheck'])  && $this->_config['notCheck'] === true )
			return (true);
		if (isset($this->_config['canEmpty'])  && $this->_config['canEmpty'] === true) {
			foreach ($this->get() as $key => $elm) {
				if (!empty($elm))
					return (static::isValid($this->get(), $getError));
			}
			return (true);
		}
		return (static::isValid($this->get(), $getError));
	}

	public function __construct(&$ent, $config) {
		$this->_entity = $ent;
		$this->_config = $config;
	}

	public function nameExist($name) {
		foreach (static::getSqlColumn() as $col => $type)
		{
			if ($col === $name)
				return (true);
		}
		return (false);
	}

	public function getOne($name) {
		// Vérifier si le name existe
		$col = $this->_config['column'][$name];
		if (!$this->nameExist($name))
			return (false);

		// Vérifier les droits de lecture de la table
		if (!$this->_entity->canGetValue($col))
			return (false);

		// Mettre à jour la données en cache si nécessaire.
		if (!isset($this->_valueCached[$name]))
		{
			$value = $this->_entity->getValue($col);
			$this->_valueCached[$name] = static::prepareGet($name, $value);
		}
		// retourner la donnée
		return ($this->_valueCached[$name]);
	}

	public function setOne($name, $value) {
		
		// Vérifier si le name existe
		if (!$this->nameExist($name))
			return (false);

		// Vérifier les droits d'écriture sur la table
		if (!$this->_entity->canSetValue($this->_config['column'][$name]))
			return (false);

		// Mettre à jour la données
		$this->_entity->setValue($this->_config['column'][$name], static::prepareSet($name, $value));
		$this->_valueCached[$name] = $value;

		return (true);
	}

	public  function get() {
		$rt = [];
		foreach (static::$_sqlColumn as $name => $value)
		{
			if (!property_exists($this->_entity, $this->_config['column'][$name]))
				$this->_entity->{$this->_config['column'][$name]} = null;
			$rt[$name] = static::prepareGet($name, $this->_entity->{$this->_config['column'][$name]});
			// Peut-être besoins d'un prepareSet ici ??
		}
		//var_dump($rt); exit();
		return ($rt);
	}

	public function set($values) {
		if (!is_array($values))
			return (false);
		
		// On reconstruit les anciennes données
		$old = $this->get();

		//var_dump($values); exit();
		// On merge les anciennes données avec les nouvelles
		foreach ($old as $key => $value) {
			if (isset($values[$key]) && $this->_entity->canSetValue($this->_config['column'][$key]))
				$old[$key] = static::beforeSet($key, $values[$key]);
		}

		// Vérification que les données sont bien conformes
		if (!static::isValid($old))
			return (false);

		// On remplace les anciennes données dans l'entitée
		foreach ($old as $key => $value) {
			if (isset($values[$key]) && $this->_entity->canSetValue($this->_config['column'][$key]))
				if (!$this->setOne($key, $value))
					return (false);
		}
		return (true);
	}

	protected static function prepareSet($name, $value) {
		return ($value);
	}

	protected static function prepareGet($name, $value) {
		return ($value);
	}

	protected static function beforeSet($name, $value) {
		return ($value);
	}

	public static function getSqlColumn() { return (static::$_sqlColumn); }

	// TODO Faire la methode de vérification
	public static function verify() {
		foreach (static::$_sqlColumn as $name => $type) {
			if (
				!isset($type) ||
				!is_string($type) ||
				strlen($type) < 3
			)
				return (false);
		}
		return (true);
	}

	public static function setToDb($dbName, $tableName, $config) {
		foreach (static::getSqlColumn() as $name => $type) {
			if (!isset($config['column'][$name]))
				return (false);
		}
		foreach (static::getSqlColumn() as $name => $type) {
			$req = "ALTER TABLE `" . $tableName . "` ADD COLUMN `" . $config['column'][$name] . "` " . $type . ";";
			Database::request($dbName, $req);
		}
		return (true);
	}

	public static function removeColumns($dbName, $tableName, $config) {
		foreach (static::getSqlColumn() as $name => $type) {
			$req = "ALTER TABLE `" . $tableName . "` DROP COLUMN `" . $config['column'][$name] . ";";
			Database::request($dbName, $req);
		}
		return (true);
	}

	public static function checkDb($dbName, $tableName, $config) {

		// Vérification pour chaque colonne assignée qu'elles existent bien en base.
		$req = "DESC `" . $tableName . "`;";
		$cols = [];
		foreach ($config['column'] as $name => $col)
			$cols[$name] = false;
		foreach (Database::request($dbName, $req) as $key => $elm) {
			foreach ($cols as $key2 => $elm2) {
				if ($elm['Field'] === $config['column'][$key2] &&
					$elm['Type'] === static::getSqlColumn()[$key2]
				)
					$cols[$key2] = true;
			}
		}
		foreach ($cols as $val) {
			if (!$val)
				return (false);
		}
		return (true);
	}

	public function getRawValue($name) {
		if (!$this->_entity->canGetValue($this->_config['column'][$name]))
			return (false);
		return ($this->_entity->getValue($this->_config['column'][$name]));
	}

	public function setRawValue($val) {
		$this->_valueCached[$name] = static::prepareGet($name, $val);
		static::prepareGet($this->_entity->getValue($this->_config['column'][$name]));
	}

	public static function normalize($name, $val, $config) {
		return ($val);
	}

	public function setForGraphApi($data) {
		if (!is_array($data))
			return (false);

		foreach ($data as $key => $elm) {
			$name = static::fromTableToName($key, $this->_config);
			if (!isset($this->_config['column'][$name]))
				continue ;
			if (!$this->_entity->canSetValue($key))
				continue ;
			$val = static::beforeSet($name, $data[$key]['value']);
			$this->setOne($name, $val);
		}
		return ($this->checkData());
	}

	public function setConfig($name, $data) {
		$this->_config[$name] = $data;
	}

	public function getShowComponent($col, $config) {
		return ("ComponentTypeShow");
	}

	public function getEditComponent($col, $config) {
		return ("ComponentTypeEdit");
	}

	public function getForState($getError = false) {

		$rt = [];
		if ($getError)
			$errors = $this->checkData(true);
		foreach ($this->_config['column'] as $key => $elm) {
			if (!$this->_entity->canGetValue($elm))
				continue ;
			$rt[$elm] =  [
				"value" => $this->getOne($key),
				"canSet" => true
			];
			if ($getError && isset($errors[$key]))
				$rt[$elm]['error'] = $errors[$key];
		}
		return ($rt);
	}

	public function getError($col) {
		return ("Le format n'est pas valide !");
	}

	public static function fromTableToName($in, $config) {
		foreach ($config['column'] as $key => $elm) {
			if ($elm == $in)
				return ($key);
		}
	}

	public static function fromNameToTable($in, $config) {
		return ($config['column'][$in]);
	}

}
