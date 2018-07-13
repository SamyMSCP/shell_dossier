<?php
class TypeToMany extends TypeRelation {

	private static $_primary_type = "int(11)";
	private $_valueCached = null;

	public static function verify() {
		return (true);
	}

	public function checkData($getError = null) {

		DevLogs::set('check DATA');
		if (isset($this->_config['notCheck'])  && $this->_config['notCheck'] === true )
			return (true);
		/*
		if (isset($this->_config['canEmpty'])  && $this->_config['canEmpty'] === true) {
			foreach ($this->get() as $key => $elm) {
				if (!empty($elm))
					return (static::isValid($this->get(), $getError));
			}
			return (true);
		}
		*/
		// TODO Recode cette methode
		// Cette methode sert à vérifier si cette instance est valable.
		// Elle vérifie si la données enregistrée est bien pointé par quelque chose.
		// Si la donnée est facultative "canEmpty === true ?" alors elle authorise que la valeure soit nulle.
		return (
				$this->_config['class']::getById($this->_entity->getValue($this->_config['column'])) instanceof $this->_config['class']
			||
				(isset($this->_config['canEmpty'])  && $this->_config['canEmpty'] === true && empty($this->_entity->getValue($this->_config['column'])))
			);
	}

	public function setById($id) {
		// TODO Recode cette methode
		$entity = $this->_config['class']::getById($id);
		if (empty($entity))
			return (false);
		return ($this->set($entity));
	}

	public function set($value) {


		if (!($value instanceof $this->_config['class']))
			return (false);

		if ($this->_valueCached == null)
			$this->get();

		$this->_valueCached[] = $value;
		return (true);
	}

	public function unset($value) {

		if (!($value instanceof $this->_config['class']))
			return (false);

		if ($this->_valueCached == null)
			$this->get();

		$ndt = [];

		foreach ($this->_valueCached as $key => $elm) {
			if ($elm->getId() != $value->getId())
				$ndt[] = $elm;
		}
		$this->_valueCached = $ndt;
		return (true);
	}

	public function commit() {

		if ($this->_valueCached == null)
			$this->get();

		if ($this->_entity->getId() == 0)
			return (false);

		// On récupère la liste des bneficiaires existants.
		$class = $this->_config['class'];
		$joinTable = $this->_config['joinTable'];
		$myColumn = $this->_config['myColumn'];
		$otherColumn = $this->_config['otherColumn'];

		$req = "SELECT * FROM `$joinTable` WHERE `$myColumn` = :myColumn";
		$params = [
			"myColumn" => $this->_entity->getId()
		];
		$rt = Database::getNoClass($this->_entity->getDbName(), $req, $params);

		// Repérer ceux qu'il faut supprimer et ajouter

		foreach ($rt as $key => $elm) {
			$temoin = false;
			foreach ($this->_valueCached as $key2 => $elm2) {
				if ($elm2->getId() == $elm[$otherColumn])
					$temoin = true; // On l'a trouvé
			}
			if (!$temoin)
				$this->removeOne($elm[$otherColumn]);
		}

		foreach ($this->_valueCached as $key2 => $elm2) {
			$temoin = false;
			foreach ($rt as $key => $elm) {
				if ($elm2->getId() == $elm[$otherColumn])
					$temoin = true; // On l'a trouvé
			}
			if (!$temoin)
			{
				$this->commitOne($elm2);
			}
		}
		if (
			get_class($this->_entity) == "Beneficiaire2" &&
			$this->_entity->getTypeBeneficiaire()->get() == "couple" &&
			count($this->_valueCached)
		) {
			//error();
		}
		return (true);
	}


	private function removeOne($id_toRemove) {
		$class = $this->_config['class'];
		$joinTable = $this->_config['joinTable'];
		$myColumn = $this->_config['myColumn'];
		$otherColumn = $this->_config['otherColumn'];

		$params = [
			"myColumn" => $this->_entity->getId(),
			"otherColumn" => $id_toRemove,
		];
		$req = "DELETE FROM `$joinTable` WHERE `$myColumn` = :myColumn AND `$otherColumn` = :otherColumn";
		$rt = Database::prepareNoClass($this->_entity->getDbName(), $req, $params);
	}

	private function commitOne($value) {

		if (!($value instanceof $this->_config['class']))
			return (false);

		if ($this->_entity->getId() == 0)
			return (false);

		$class = $this->_config['class'];
		$joinTable = $this->_config['joinTable'];
		$myColumn = $this->_config['myColumn'];
		$otherColumn = $this->_config['otherColumn'];

		$params = [
			"myColumn" => $this->_entity->getId(),
			"otherColumn" => $value->getId(),
		];
		$req = "INSERT INTO `$joinTable` (`$myColumn`, `$otherColumn`) VALUES (:myColumn, :otherColumn);";
		$rt = Database::prepareNoClass($this->_entity->getDbName(), $req, $params);
		return ($rt);
	}

	public function get() {


		// TODO Recoder cette methode

		$myIdName = $this->_entity->getPrimaryKeyName();

		$class = $this->_config['class'];
		$classIdName = $class::getPrimaryKeyName();
		$table = $class::getTableName();

		$joinTable = $this->_config['joinTable'];
		$myColumn = $this->_config['myColumn'];
		$otherColumn = $this->_config['otherColumn'];


		$id = $this->_entity->getId();

		if ($this->_valueCached == null)
			$this->_valueCached = [];

		if ($id == 0)
			return ($this->_valueCached);

		$req = "SELECT `$table`.* FROM `$table` INNER JOIN `$joinTable` ON `$table`.$classIdName = `$joinTable`.$otherColumn WHERE `$joinTable`.$myColumn = :id;";
		//var_dump($req); 
		//var_dump($id); 
		//exit();
		$data = ['id' => $id];
		if ($this->_valueCached == null)
			$this->_valueCached = $class::getFromRequest($req, $data);
		return ($this->_valueCached);

	}

	public static function setToDb($dbName, $tableName, $config) {

		// TODO Recode cette methode 
		// Si besoin, insérer la table de jointure, et les colonnes nécessaires.
		// On ajoute la colonne qui stoque l'id ici.
		//$req = "ALTER TABLE `" . $tableName . "` ADD COLUMN `" . $config['column'] . "` " . static::$_primary_type . ";";
		//return (Database::request($dbName, $req));
	}

	public static function checkConfig($config) {
		// Vérification des données de configuration minimales
		if (
			!isset($config['accessName']) ||
			!isset($config['joinTable']) ||
			!isset($config['myColumn']) ||
			!isset($config['otherColumn']) ||
			!isset($config['class'])
		)
			return (false);
		return (true);
	}

	public static function checkDb($dbName, $tableName, $config) {

		// TODO Recoder cette methode
		return (true);

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
		$column = $config['config']['accessName'];
		$name = "get" . $calledClass . "_" . $column;

		$rt = [
			$name => "
				return (
					function(arr) {
						var join = getters.get{$calledClass}ById(arr);

						if (typeof join == 'undefined')
							return (null);

						return (state.datas.$class.lst.filter(function (elm) {
							return (join.$column.value.some(function(elm2) {
								return (elm.id.value === elm2);
							}));
						}));
					}
				);
			"
		];
		return ($rt);
	}

	public function getForState($getError = false) {
		if (
			!$this->_entity->canGetValue($this->_config['accessName'])
		)
			return ([]);

		$data = [];
		foreach ($this->get() as $key => $elm)
		{
			$data[] = $elm->getId();
		}

		// TODO Il faut compléter ca !
		$rt = [
			$this->_config['accessName'] =>  [
				"value" => $data,
				"canSet" => $this->_entity->canSetValue($this->_config['accessName'])
			]
		];
		return ($rt);
	}

	public function setForGraphApi($data) {
		//DevLogs::set($data, 1);
		if (!is_array($data))
			return (false);

		$class = $this->_config['class'];
		$joinTable = $this->_config['joinTable'];
		$myColumn = $this->_config['myColumn'];
		$otherColumn = $this->_config['otherColumn'];

		$arr = $data[$this->_config['accessName']];

		// Pour faire des tests
		if (!isset($arr['value'])) {
			if (
				(isset($this->_config['canEmpty']) && $this->_config['canEmpty'])
				||
				(isset($this->_config['notCheck']) && $this->_config['notCheck'])
			)
				return (true);
			return (false);
		}

		if (!is_array($arr['value'])) {
			$arr['value'] = json_decode($arr['value']);
			if (!is_array($arr['value']))
				return (false);
		}

		foreach ($arr['value'] as $elm) {
				$this->setById($elm);
		}
		return (true);
	}

}
