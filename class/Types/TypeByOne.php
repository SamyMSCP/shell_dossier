<?php
class TypeByOne extends TypeRelation {

	private static $_primary_type = "int(11)";
	private $_valueCached = null;

	public static function verify() {
		return (true);
	}

	public function checkData() {

		// Ici il n'y a rien à vérifier car nous somme pointée et il n'y a pas de changements sur la table ou les données elles même
	}

	public function set($value) {
		// Pas besoins de setter.
		return (true);
	}

	public function get() {
		if ($this->_valueCached == null)
		{
			// TODO On vas récupérer les données qu'on a stocké ici.
			$this->_valueCached = $this->_config['class']::getFromKeyValue($this->_config['link'], $this->_entity->getId());
		}
		return ($this->_valueCached);

	}

	public static function setToDb($dbName, $tableName, $config) {
		return (true);
	}

	public static function checkConfig($config) {
		// Vérification des données de configuration minimales
		if (!isset($config['link']) || !isset($config['class']))
			return (false);
		return (true);
	}

	public static function checkDb($dbName, $tableName, $config) {

		if (!static::checkConfig($config))
			return (false);

		// Vérifier que notre table existe;
		if (Database::request($dbName, "SHOW TABLES LIKE \"" . $tableName . "\"")->rowCount() === 0)
			return (false);

		// Vérifier que la classe en relation existe bien.
		if (!class_exists($config['class']))
			return (false);

		// On ne peux pas Vérifier que la table de la class en relation existe;
		// car une des deux table doit obligatoirement exister en premier

		// On ne vérifie le contenu de la table en relation uniquement si elle existe
		if ($config['class']::tableExist())
		{
			// Vérifier que la Table de la classe distante à bien la colonne demandé et qu'elle est dans un format adéquate;
			$req = "DESC `" . $config['class']::getTableName() . "`;";
			foreach (Database::request($dbName, $req) as $key => $elm)
			{
				if ($elm['Field'] === $config['link'] &&
					$elm['Type'] === static::$_primary_type
				)
					return (true);
			}
		}
		else
			return (true);
		return (false);
	}

	public static function getVuexGetters($config, $calledClass) {
		$class = $config['config']['class'];
		$link = $config['config']['link'];
		$name = "get" . $calledClass . "_By" . $class. "_" . $link;

		$rt = [
			$name => "
				return (
					function(id) {
						var join = getters.get{$class}ById(id);

						if (typeof join == 'undefined')
							return (null);

						return (state.datas.$calledClass.lst.filter(function (elm) {
							return (elm.id.value === join.$link.value);
						}));
					}
				);
			"
		];
		return ($rt);
	}


}
