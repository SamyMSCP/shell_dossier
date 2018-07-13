<?php
class TypeToManyStatic extends TypeRelation {

	private static $_primary_type = "int(11)";
	private $_valueCached = null;

	public function __construct(&$ent, $config) {
		if (!isset($config['myIdName']))
			$config['myIdName'] = $ent->getPrimaryKeyName();
		if (!isset($config['otherIdName']))
			$config['otherIdName'] = $config['class']::getPrimaryKeyName();
		parent::__construct($ent, $config);
	}

	public static function verify() {
		return (true);
	}

	public function checkData() {

		// TODO Recode cette methode
		// Cette methode sert à vérifier si cette instance est valable.
		// Elle vérifie si la données enregistrée est bien pointé par quelque chose.
		// Si la donnée est facultative "canEmpty === true ?" alors elle authorise que la valeure soit nulle.
		return (true);
		return (
				$this->_config['class']::getFromKeyValue($this->_config['otherIdName'], $this->_entity->getValue($this->_config['column'])) instanceof $this->_config['class']
			||
				(isset($this->_config['canEmpty'])  && $this->_config['canEmpty'] === true && empty($this->_entity->getValue($this->_config['column'])))
			);
	}

	public function setByCol($id) {
		// TODO Recode cette methode
		$entity = $this->_config['class']::getFromKeyValue($this->_config['otherIdName'],$id);
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

/*
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
*/

	public function commit() {

		$class = $this->_config['class'];
		$joinTable = $this->_config['joinTable'];
		$myColumn = $this->_config['myColumn'];
		$otherColumn = $this->_config['otherColumn'];
		$myIdName = $this->_config['myIdName'];
		$otherIdName = $this->_config['otherIdName'];

		if ($this->_valueCached == null)
			$this->get();

		// On sort si l'id De l'entity n'est pas définit !
		if ($this->_entity->getId() == 0)
			return (true);

		// Récupération des élements deja existants !
		$id = $this->_entity->$myIdName;
		// On sort si il n'y a pas de donnés à persister;
		if (count($this->_valueCached) == 0)
			return (true);

/*
		if (
			get_class($this->_entity) == "Beneficiaire2"
		)
		{
			//echo "ben:" . count($this->_valueCached) . "\n\n";
			echo "ben:" . $this->_entity->getTypeBeneficiaire()->get() . "count" . count($this->_valueCached) . "\n\n";
		}
		*/

		// Si on a 0 en id, on vas voir dans les autres élements si un d'entre eux n'est pas égale à zero
		if ($id == 0) {
			//echo count($this->_valueCached) . "\n";
			foreach ($this->_valueCached as $key => &$elm) {
				//echo "[" . $elm->$otherIdName. "]\n";
				if ($elm->$otherIdName != 0) {
					$id = $elm->$otherIdName;
					break ;
				}
			}
		}
		if ($id == 0)
		{
			$req = "INSERT INTO `$joinTable` VALUES ()";

			$id = Database::prepareInsert($this->_entity->getDbName(), $req, []);
		}
		if ($id == 0)
			return (false);

		// On met à jour notre colonne id_situation !
		if ($this->_entity->$myIdName != $id)
		{
			$params = [ "id" => $id, "me" => $this->_entity->getId()];
			$idName = $this->_entity->getPrimaryKeyName();
			$myTable = $this->_entity->getTableName();
			$req = "UPDATE `$myTable` SET `$myIdName` = :id WHERE $idName = :me;";
			$rt = Database::prepareNoClass($this->_entity->getDbName(), $req, $params);
		}

		foreach ($this->_valueCached as $key => $elm) {
			$otherTable = $elm->getTableName();
			$idName = $elm->getPrimaryKeyName();
			$params = [ "id" => $id, "other" => $elm->getId()];
			$req = "UPDATE `$otherTable` SET `$otherIdName` = :id WHERE $idName = :other";
			$rt = Database::prepareNoClass($this->_entity->getDbName(), $req, $params);
		}
		return (true);
	}


	private function removeOne($id_toRemove) {
		$class = $this->_config['class'];
		$joinTable = $this->_config['joinTable'];
		$myColumn = $this->_config['myColumn'];
		$otherColumn = $this->_config['otherColumn'];
		$myIdName = $this->_config['myIdName'];
		$otherIdName = $this->_config['otherIdName'];

		$params = [
			"myColumn" => $this->_entity->$myIdName,
			"otherColumn" => $id_toRemove,
		];
		$req = "DELETE FROM `$joinTable` WHERE `$myColumn` = :myColumn AND `$otherColumn` = :otherColumn";
		$rt = Database::prepareNoClass($this->_entity->getDbName(), $req, $params);
	}

	private function commitOne($value) {


		$class = $this->_config['class'];
		$joinTable = $this->_config['joinTable'];
		$myColumn = $this->_config['myColumn'];
		$otherColumn = $this->_config['otherColumn'];
		$myIdName = $this->_config['myIdName'];
		$otherIdName = $this->_config['otherIdName'];

		if (!($value instanceof $this->_config['class']))
			return (false);

		if ($this->_entity->getId() == 0)
			return (false);


		$params = [
			"myColumn" => $this->_entity->$myIdName,
			"otherColumn" => $value->$otherIdName,
		];
		$req = "INSERT INTO `$joinTable` (`$myColumn`, `$otherColumn`) VALUES (:myColumn, :otherColumn);";
		$rt = Database::prepareNoClass($this->_entity->getDbName(), $req, $params);
		return ($rt);
	}

	public function get() {


		// TODO Recoder cette methode

		$class = $this->_config['class'];
		//$classIdName = $class::getPrimaryKeyName();
		$table = $class::getTableName();

		$joinTable = $this->_config['joinTable'];
		$myColumn = $this->_config['myColumn'];
		$otherColumn = $this->_config['otherColumn'];

		$myIdName = $this->_config['myIdName'];
		$otherIdName = $this->_config['otherIdName'];


		$id = $this->_entity->$myIdName;

		if ($this->_valueCached == null)
			$this->_valueCached = [];

		if ($id == 0)
			return ($this->_valueCached);

		$req = "SELECT `$table`.* FROM `$table` INNER JOIN `$joinTable` ON `$table`.$otherIdName = `$joinTable`.$otherColumn WHERE `$joinTable`.$myColumn = :id;";
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
			!isset($config['class']) ||
			!isset($config['otherIdName']) ||
			!isset($config['myIdName'])
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


		if (isset($config['config']['myIdName']))
			$myIdName = $config['config']['myIdName'];
		if (isset($config['config']['otherIdName']))
			$otherIdName = $config['config']['otherIdName'];

		// TODO adapter les getters !
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
		if ( !$this->_entity->canGetValue($this->_config['accessName']))
			return ([]);

		$myIdName = $this->_config['myIdName'];
		$otherIdName = $this->_config['otherIdName'];

		$data = [];
		foreach ($this->get() as $key => $elm)
		{
			//$data[] = $elm->{$otherIdName};
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
		if (!is_array($data))
			return (false);

		$class = $this->_config['class'];
		$joinTable = $this->_config['joinTable'];
		$myColumn = $this->_config['myColumn'];
		$otherColumn = $this->_config['otherColumn'];

		$arr = $data[$this->_config['accessName']];

		// Pour faire des tests
		if (!isset($arr['value']) || !is_array($arr['value']))
			return (true);

		foreach ($arr['value'] as $elm) {
				$this->setByCol($elm);
		}
		return (true);
	}

}
