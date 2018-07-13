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

function prepareGetters($arr) {
	$rt = "";
	foreach ($arr as $key => $elm) {
		$rt .= "$key:function(state, getters) {" . $elm . "},";
	}
	$rt .= "\n";
	return ($rt);
}

class Table2 {
	protected static		$_db = "mscpi_db";
	/*
	protected static		$_name = null;
	*/
	protected static		$_primary_key = "id";
	protected static		$_dataAccess = [];
	protected static		$_dataTypes = [];
	protected static		$_access = [];
	protected				$_typeInstances = [];
	protected static		$_name = null;


	public function __construct() {
		if (!isset($this->{static::$_primary_key}))
			$this->{static::$_primary_key} = 0;
		foreach (static::$_dataAccess as $k => $v)
		{
			if (isset($this->$k))
				continue ;
			if (isset($v['defaultValue']))
				$this->$k = $v['defaultValue'];
			else
				$this->$k = null;
		}
		$this->normalize();
	}
	public function __destruct() {}

	public static function getDbName() { return (static::$_db); }
	public static function getTableName() { return (static::$_name); }
	public static function getPrimaryKeyName() { return (static::$_primary_key); }
	public static function getDataAccess() { return (static::$_dataAccess); }
	public static function getDataTypes() { return (static::$_dataTypes); }

	/*
	*/
	public function getForDonneurDOrdre($donneurdordre) {
		return ([]);
	}

	/*
	*/
	public function getId() {
		if (!isset($this->{static::$_primary_key}))
			return (null);
		return (intval($this->{static::$_primary_key}));
	}

	/*
	*/
	public function getById($id) {
		$id = intval($id);
		$name = (isset(static::$_name)) ? '`' . static::$_name . '`' : get_called_class();
		$req =  "SELECT * FROM " . $name . " WHERE " . static::$_primary_key ." = :id";
		$rt = Database::prepare(static::$_db, $req, compact("id"), get_called_class());
		if (empty($rt))
			return (null);
		$rt = $rt[0];
		$rt->normalize();
		return ($rt);
	}

	/*
	*/
	public function getFromKeyValue($key, $value) {
		$name = (isset(static::$_name)) ? '`' . static::$_name . '`' : get_called_class();
		$req =  "SELECT * FROM " . $name . " WHERE ";
		$req .= $key . " = :" . $key;
		$rt = Database::prepare(static::$_db, $req, array($key => $value), get_called_class());
		foreach ($rt as &$elm)
			$elm->normalize();
		return ($rt);
	}

	/*
	*/
	public function getFromRequest($req, $data) {
		$rt = Database::prepare(static::$_db, $req, $data, get_called_class());
		foreach ($rt as &$elm)
			$elm->normalize();
		return ($rt);
	}

	/*
	*/
	public static function getFromKeysValues($array) {
		$temoin = 0;
		$name = (isset(static::$_name)) ? '`' . static::$_name . '`' : get_called_class();
		$req =  "SELECT * FROM " . $name . " WHERE ";
		foreach ($array as $key => $value) {
			if ($temoin)
				$req .= "AND ";
			$req .= "`" . $key . "` = :" . $key . " ";
			$temoin = 1;
		}
		$rt = Database::prepare(static::$_db, $req, $array, get_called_class());
		foreach ($rt as &$elm)
			$elm->normalize();
		return ($rt);
	}

	/*
		C'est cette methode qui permet d'insérer automatiquement les différent getters pour les types !
	*/
	function __call($method, $params) {

		if ($method == "getCurrent")
			return (true);

		if (!$this->canAccess())
			return (null);

		foreach (static::$_dataTypes as $key => $type)
		{
			// Insertion des getters automatiques
			if (isset($type['getter']) && $method === $type['getter'])
			{
				// Vérification des authorisation d'acces
				if (isset($type['getAccess']))
				{
					foreach ($type['getAccess'] as $access)
					{
						// Vérifier si l'instance existe et sinon la créer
						//if (!isset($this->{"_" . $key . "_"}))
						if (!isset($this->_typeInstances[$key]))
							$this->_typeInstances[$key] = new $type['type']($this, $type['config']);
						return ($this->_typeInstances[$key]);
					}
				}
				return (null);
			}
		}
	}



	/*
		Vérifier si la class respecte bien le format attendu
		rt pour vérifier que la class contient bien le minimum pour fonctionner
	*/
	public static function verifyClass() {
		if (
			!isset(static::$_name) ||
			!is_string(static::$_name) ||
			strlen(static::$_name) < 3 ||

			!isset(static::$_primary_key) ||
			!is_string(static::$_primary_key) ||
			strlen(static::$_primary_key) < 1 ||

			!isset(static::$_dataTypes) ||
			!is_array(static::$_dataTypes) ||

			!isset(static::$_db) ||
			!is_string(static::$_db) ||
			strlen(static::$_db) < 2
		)
			return (false);

		foreach (static::$_dataTypes as $type)
		{
			if (
					!class_exists($type['type'])
				||
					!is_subclass_of($type['type'], "TypeRelation")
				&&
				(
					(
						is_string($type['type']::getSqlColumn()) &&
						strlen($type['type']::getSqlColumn()) < 3
					) || (
						is_array($type['type']::getSqlColumn()) &&
						count($type['type']::getSqlColumn()) < 2
					) 
				)
			)
				return (false);
		}
		return (true);
	}

	/*
		Demander si la table existe bien en db
	*/
	public static function tableExist() {
		return (Database::request(static::$_db, "SHOW TABLES LIKE \"" . static::$_name . "\"")->rowCount() !== 0);
	}


	/*
		Vériffie si la table est conforme à la classe et que la table en base permet bien de fonctionner
	*/
	public static function verifyTable() {
		if (!static::verifyClass())
			return (false);

		// Vérifier si la table existe
		if (!static::tableExist())
			return (false);

		// Vérifier si la table à bien les colonnes nécéssaire et qu'elles sont dans le bon type
		foreach (static::$_dataTypes as $type)
		{

			$okay = false;
			if (!$type['type']::checkDb(static::getDbName(), static::getTableName(), $type['config']))
			{
				return (false);
			}
		}
		return (true);
	}

	/*
		Creation de la table
	*/
	public static function createTable() {
		if (!static::verifyClass() || static::tableExist())
			return (false);
		$req = "CREATE TABLE `" . static::$_name . "`  (`" . static::$_primary_key . "` BIGINT AUTO_INCREMENT PRIMARY KEY);";
		Database::request(static::$_db, $req);

		// Boucler sur tout les types et les créer
		foreach (static::$_dataTypes as $col => $type)
		{
			if (
				(
					!is_subclass_of($type['type'], "Type") &&
					!is_subclass_of($type['type'], "TypeMulti") &&
					!is_subclass_of($type['type'], "TypeRelation")
				) ||
				!$type['type']::verify()
			)
			{
				static::dropTable();
				return (false);
			}
			$type['type']::setToDb(static::getDbName(), static::getTableName(), $type['config']);
		}
		if (!static::verifyTable())
		{
			static::dropTable();
			return (false);
		}
		return (true);
	}

	/*
		description de la table
	*/
	public static function desc() {
		if (!static::tableExist())
			return (false);
		$req = "DESC `" . static::$_name . "`;";
		$data = Database::request(static::$_db, $req);
		foreach ($data as $key => $elm)
		{
			var_dump($elm);
		}
		return (true);
	}

	/*
		Pour supprimer la table en db
	*/
	public static function dropTable() {
		if (!static::tableExist())
			return (false);
		Database::request(static::$_db, "DROP TABLE `" . static::$_name . "`");
		return (true);
	}

	public function beforeCheck() {
	}

	/*
		Methode de vérification de la cohérence des données
	*/
	public function checkData() {
		//echo "on entre\n";
		$this->beforeCheck();
		foreach (static::$_dataTypes as $key => $type)
		{
				////continue ;
			if (!isset($type['config']['column']))
				continue ;
			if (is_array($type['config']['column']))
			{
				foreach ($type['config']['column'] as $elm)
				{
					if (!property_exists($this, $elm)) {
						//DevLogs::set("1" . $key, 1);
						return (false);
					}
				}
			}
			else if (is_string($type['config']['column'])) {
				if (!property_exists($this, $type['config']['column'])) {
					//DevLogs::set("2" . $key, 1);
					return (false);
				}
			}
			if (!isset($this->_typeInstances[$key]))
			{
				$this->_typeInstances[$key]  = new $type['type']($this, $type['config']);
			}
			if ($this->_typeInstances[$key]->checkData() === false) {
				//DevLogs::set("3" . $key, 1);
				return (false);
			}
		}
		//error("4");
		return (true);
	}

	public function getTypeInstance($name) {
		return ($this->_typeInstances[$name]);
	}

	protected function insert() {
		// TODO Vérifier le droit d'insertion
		if (!$this->checkData())
			return (false);
		$req = "INSERT INTO `" . static::$_name . "` (";
		$values = " (";
		$data = [];
		$first = true;
		foreach (static::$_dataTypes as $key => $type)
		{
			if (isset($type['config']['column'])) {
				if (is_array($type['config']['column'])) {
					foreach ($type['config']['column'] as $name)
					{
						if (!$first) {
							$req .= ", ";
							$values .= ", ";
						}
						$req .= "`$name`";
						$values .= "?";
						$data[] = $this->$name;
						$first = false;
					}
				}
				else if (is_string($type['config']['column'])) {
					if (!$first) {
						$req .= ", ";
						$values .= ", ";
					}
					$req .= "`" . $type['config']['column'] . "`";
					$values .= "?";
					$data[] = $this->{$type['config']['column']};
					$first = false;
				}
			}
		}
		$req .= ") VALUES $values)";
		/*
		var_dump($data); 
		var_dump($req); 
		error();
		*/
		$rt = Database::prepareInsertNoSecurity(static::$_db, $req, $data);
		if (empty($rt))
			return (false);
		$this->{static::$_primary_key} = $rt;

		// Mise à jours des Relations
		foreach ($this->_typeInstances as $key => $instance) {
			if (is_subclass_of($instance, "TypeRelation"))
				$instance->commit();
		}
		return (true);
	}

	protected function update() {
		// TODO Vérifier le droit de modification
		if (!$this->checkData())
			return (false);
		$req = "UPDATE `" . static::$_name . "` SET ";
		$data = [];
		$first = true;
		foreach (static::$_dataTypes as $key => $type)
		{
			if (isset($type['config']['column'])) {
				if (is_array($type['config']['column'])) {
					foreach ($type['config']['column'] as $name)
					{
						if (!$first)
							$req .= ", ";
						$req .= "`$name` = ?";
						$data[] = $this->$name;
						$first = false;
					}
				}
				else if (is_string($type['config']['column'])) {
					if (!$first)
						$req .= ", ";
					$req .= "`" . $type['config']['column'] . "` = ?";
					$data[] = $this->{$type['config']['column']};
					$first = false;
				}
			}
		}
		$req .= " WHERE `" . static::$_primary_key . "` = ?;";
		$data[] = $this->{static::$_primary_key};

		$rt =  Database::prepareNoClass2NoSecurity(static::$_db, $req, $data);
		if (empty($rt))
			return (false);

		// Mise à jours des Relations
		foreach ($this->_typeInstances as $key => $instance) {
			if (is_subclass_of($instance, "TypeRelation"))
				$instance->commit();
		}
		return (true);
	}

	/*
		Pour persister l'instance en db (insert ou update)
	*/
	public function commit() {
		$this->beforeSetCaller();
		$rt = null;
		if (!isset($this->{static::$_primary_key}) || $this->{static::$_primary_key} == 0)
			$rt = $this->insert();
		else
			$rt = $this->update();
		if (!$this->afterSetCaller()) {
			//if ( get_called_class() == "SituationPhysique") {
				//DevLogs::set('KO');
			//}
			return (false);
		}
		//if ( get_called_class() == "SituationPhysique") {
			//DevLogs::set('OK');
		//}
		return ($rt);
	}

	/*
		Une methode delete qui devra vérifier les dépendances si il y en as;
	*/
	public function delete() {

	}
	
	/*
		Pour demander à la classe si l'utilisateur courant peut lire une donnée.
	*/
	public function canGetValue($name) {

		if (!empty(DonneurDOrdre::getCurrent()) && DonneurDOrdre::getCurrent()->getType() == "yoda")
			return (true);
		if (
			!isset(static::$_dataAccess[$name]) ||
			!is_array(static::$_dataAccess[$name]) ||
			!isset(static::$_dataAccess[$name]["get"]) ||
			!is_array(static::$_dataAccess[$name]["get"])
		)
			return (false);

		foreach (static::$_dataAccess[$name]["get"] as $key => $elm)
		{
			if ($elm($this))
				return (true);
		}
		return (false);
	}

	/*
		Pour demander à la classe si l'utilisateur courant peut ècrire une donnée.
	*/
	public function canSetValue($name) {
		if (
			!isset(static::$_dataAccess[$name]) ||
			!is_array(static::$_dataAccess[$name]) ||
			!isset(static::$_dataAccess[$name]["set"]) ||
			!is_array(static::$_dataAccess[$name]["set"])
		)
			return (false);
		foreach (static::$_dataAccess[$name]["set"] as $key => $elm)
		{
			if ($elm($this))
				return (true);
		}
		return (false);
	}

	public function getValue($name) {
		if (!$this->canGetValue($name))
			return (false);
		if (property_exists($this, $name))
			return ($this->$name);
		return (null);
	}

	public function setRawValue($name, $value) {
		$this->$name = $value;
	}
	/*
	*/
	public function setValue($name, $value) {
		if (!$this->canSetValue($name))
		{
			if (
				isset($this->$name) &&
				$this->$name === null &&
				isset($this->_dataAccess[$name]['defaultValue']) &&
				$this->_dataAccess[$name]['defaultValue'] === $value
			)
				$this->$name = $this->_dataAccess[$name]['defaultValue'];
			return (false);
		}
		$this->$name = $value;
		return (true);
	}

	public function setValueNoControl($name, $value) {
		$this->$name = $value;
		return (true);
	}

	/*
	*/
	public static function getAll() {
		$name = (isset(static::$_name)) ? '`' . static::$_name . '` ;' : get_called_class();
		$req = "SELECT * FROM " . $name;
		$datas =  Database::query(static::$_db, $req, get_called_class());
		foreach ($datas as &$data) {
			$data->normalize();
		}
		return ($datas);
	}

	/*
		Une méthode qui est appelée apres chaque récupération en db pour préparer les données
	*/
	protected function normalize() {
		foreach (static::$_dataTypes as $key => $type)
		{
			if (!isset($this->_typeInstances[$key]))
				$this->_typeInstances[$key] = new $type['type']($this, $type['config']);
			if (isset($type['config']['column'])) {

				//if (is_subclass_of($type['type'], "TypeMulti"))
				if (is_array($type['config']['column'])) {
					foreach ($type['config']['column'] as $real => $name) {
						if (!isset($this->$name))
							$this->$name = null;
						if ($this->$name !== null)
						$this->$name = $type['type']::normalize($real, $this->$name, $type['config']);
					}
				}
				//else if (is_subclass_of($type['type'], "Type"))
				else if (is_string($type['config']['column']))
				{
					if (!isset($this->{$type['config']['column']}))
						$this->{$type['config']['column']} = null;
					if ($this->{$type['config']['column']} !== null)
						$this->{$type['config']['column']} = $type['type']::normalize($this->{$type['config']['column']}, $type['config']);
				}
			}
		}
	}

	/*
		Pour demander si l'utilisateur courant à bien les autorisation d'access à cette table
	*/
	public function canAccess() {
		if (!empty(DonneurDOrdre::getCurrent()) && DonneurDOrdre::getCurrent()->type == "yoda")
			return (true);
		foreach (static::$_access as $access) {
			if ($access($this)) {
				return (true);
			}
		}
		return (false);
	}

	/*
		Mettre à jours les données à partir du format utilisé du coté client
	*/
	public function setForGraphApi($datas, $toSet = null) {

		if (!$this->canAccess())
			return (false);

		$rt = ["id" => 
			[
				"value" => $this->getId(),
				"canSet" => false
			],
			"shortName" => 
			[
				"value" => $this->getShortName(),
				"canSet" => false
			]
		];

		/*
			on va faire ici un remove des keys qu'on ne veux pas entrer
			( en fonction de toSet) [ l'autre maniere est incompatible avec le TypeMulti ].
		*/

		$this->beforeSetCaller();
		$this->beforeCheck($datas);
		$haveError = false;
		foreach ($this->_typeInstances as $key => $instance) {
			if (is_subclass_of($instance, "TypeMulti") && !$instance->setForGraphApi($datas)) {
				$haveError = true;
			}
			else if (
				$this->canSetValue($key) &&
				($toSet === null || in_array($key, $toSet)) &&
				isset($datas[$key]) &&
				!$instance->setForGraphApi($datas)
			) {
				$haveError = true;
			}
			$rt = array_merge($rt, $instance->getForState(true));
		}
		// TODO Check data qui empeche d'insérer des datas
		if ($haveError || !$this->checkData()){ 
			return ($rt);
		}
		return (true);
	}

	/*
		Methode qui sert à demander quels sont les erreurs (pour le store)
	*/
	public function getErrors() {
		if (!$this->canAccess())
			return (false);
		$rt = ["id" => 
			[
				"value" => $this->getId(),
				"canSet" => false
			]
		];
		$haveError = false;
		foreach ($this->_typeInstances as $key => $instance) {
			$rt = array_merge($rt, $instance->getForState(true));
		}
		return ($rt);
	}


	/*
		Génération automatique des élements de vuex
	*/
	public function generateVuexState($tmp = false) {
		// TODO Mettre un controle d'acces
		if (!$this->canAccess())
			return (false);
		$rt = ["id" => 
			[
				"value" => $this->getId(),
				"canSet" => false
			],
			"shortName" => 
			[
				"value" => $this->getShortName(),
				"canSet" => false
			]
		];
		foreach ($this->_typeInstances as $key => $elm) {
			$rt = array_merge($rt, $elm->getForState($tmp));
		}
		return ($rt);
	}

	/*
		Une fonction qui fournit un nom qui sera utilisé pour afficher les données dans un select par exemple
	*/
	public function getShortName() {
		return ("---not_defined---");
	}

	/*
	*/
	public function generateVuexActions() {
		$class = get_called_class();
		$rt = [];

		$rt["write_selected_$class"] = "
			var datas = context.getters.getSelected$class;
			var that = this;
			return (new Promise(function(resolve, reject) {
				Vue.http.post('graph_api.php', {
						Receiver: '$class',
						Action: 'commit',
						Datas: datas
					},
					{emulateJSON: true}
				)
				.then (
					function (res) {
						context.commit('update_datas', res.body);
						resolve();
					},
					function (res) {
						if (typeof res.body == 'object')
							context.commit('update_datas', res.body);
						reject();
					}
				);
			}));
		";
		return ($rt);
	}

	/*
	*/
	public function generateVuexMutations() {
		$class = get_called_class();
		$rt = [];
		$rt["set_selected_$class"] = "
			state.datas.$class.selected = JSON.parse(JSON.stringify(payload));
		";
		$rt["set_new_$class"] = "
			state.datas.$class.selected = JSON.parse(JSON.stringify(state.datas.$class.new));
		";
		$rt["update_one_$class"] = "
			state.datas.$class.lst = state.datas.$class.lst.map(function(elm) {
				if (elm.id.value == payload.id.value)
				{
					return (payload);
				}
				return (elm);
			});
		";
		$rt["add_one_$class"] = "
			state.datas.$class.lst.push(payload);
			state.datas.$class.selected = JSON.parse(JSON.stringify(state.datas.$class.lst[state.datas.$class.lst.length - 1]));
		";
		return ($rt);
	}

	/*
	*/
	public static function generateVuexGetters() {
		$class = get_called_class();
		$rt = [];
		$rt["get{$class}ById"] = "
			return (function(id) {
				return (state.datas.$class.lst.find(function(elm) {
					return (elm.id.value === id);
				}));
			});
		";
		$rt["get{$class}ByArray"] = "
			return (function(arr) {
				return (state.datas.$class.lst.filter(function(elm) {
					return (arr.some(function (elm2) {
						return (elm.id.value === elm2);
					}));
				}));
			});
		";
		$rt["get{$class}Filtered"] = "
			return (function(func) {
				return (state.datas.$class.lst.filter(func));
			});
		";
		$rt["getAll{$class}"] = "
			return (state.datas.$class.lst);
		";
		$rt["getSelected{$class}"] = "
			return (
				state.datas.$class.selected
			);
		";
		foreach (static::$_dataTypes as $key => $elm) {
			if (!is_subclass_of($elm['type'], "TypeRelation"))
				continue ;
			$rt = array_merge($rt, $elm['type']::getVuexGetters($elm, get_called_class()));
		}
		return ($rt);
	}

	/*
		Pour ajouter des élements supplémentaires au Store en question.
		( récupérer generateVuexState et le retourner, possibilité de merger de nouveaux élements en plus)
	*/
	public function getVuexState($tmp = false) {
		return ($this->generateVuexState($tmp));
	}

	/*
	*/
	public function getVuexActions() {
		$arr = static::generateVuexActions();
		$rt = "";
		foreach ($arr as $key => $elm) {
			$rt .= "$key:function(context, payload) {" . $elm . "},";
		}
		return ($rt);
	}

	/*
	*/
	public function getVuexMutations() {
		$arr = static::generateVuexMutations();
		$rt = "";
		foreach ($arr as $key => $elm) {
			$rt .= "$key:function(state, payload) {" . $elm . "},";
		}
		return ($rt);
	}

	/*
	*/
	public static function getVuexGetters() {
		$arr = static::generateVuexGetters();
		$rt = "";
		foreach ($arr as $key => $elm) {
			$rt .= "$key:function(state, getters) {" . $elm . "},";
		}
		return ($rt);
	}

	/*
	*/
	public static function getStoreName() {
		return (static::$_storeName);
	}

	/*
		Pour demander à la classe quel est le Component d'edition par defaut pour afficher un type de donnée
	*/
	public static function getShowComponent($col) {

		// Recherche le type
		$type = static::findDataType($col);

		// Retourne le component d'init dans acces si il y est
		if (isset(static::$_dataAccess[$col]["showComponent"])) {
			ComponentManager::loadComponentGenerated(static::$_dataAccess[$col]["showComponent"], $type["type"]);
			return (static::$_dataAccess[$col]["showComponent"]);
		}


		$componentName = null;
		if (is_subclass_of($type["type"], "TypeMulti"))
			$componentName = $type["type"]::getShowComponent($col, $type);
		else
			$componentName = $type["type"]::getShowComponent();
		ComponentManager::loadComponentGenerated($componentName, $type["type"]);
		return ($componentName);
	}

	/*
		Pour demander à la classe quel est le Component d'edition par defaut pour editer un type de donnée
	*/
	public static function getEditComponent($col) {
		$type = static::findDataType($col);
		if (isset(static::$_dataAccess[$col]["editComponent"]))
			return (static::$_dataAccess[$col]["editComponent"]);
		if (isset($type['config']['props'])) {
			foreach ($type['config']['props'] as $key => $elm) {
				$props[$key] = json_encode($elm);
			}
		}
		if (!isset($props[':data'])) {
			$class = get_called_class();
			$props[':data'] = "\$store.getters.getSelected$class.$col";
		}
		$componentName = null;
		if (is_subclass_of($type["type"], "TypeMulti"))
			$componentName = $type["type"]::getEditComponent($col, $type);
		else
			$componentName = $type["type"]::getEditComponent();
		ComponentManager::loadComponentGenerated($componentName, $type["type"]);
		return ($componentName);
	}

	public static function findDataType($col) {
		$rt = null;
		if (isset(static::$_dataTypes[$col]))
			return (static::$_dataTypes[$col]);
		foreach (static::$_dataTypes as $key => &$elm) {
			if (isset($elm['config']['column']) && is_array($elm['config']['column'])) {
				foreach ($elm['config']['column'] as $key2 => $elm2) {
					if ($elm2 == $col) {
						return ($elm);
					}
				}
			}
		}
	}

	public static function findColumnName($name) {
		foreach (static::$_dataTypes as $key => &$elm) {
			if (isset($elm['config']['column']) && is_array($elm['config']['column'])) {
				foreach ($elm['config']['column'] as $key2 => $elm2) {
					if ($elm2 == $name) {
						return ($elm);
					}
				}
			}
		}
		return ($name);
	}

	public static function getEditComponentConfigured($col, $props = []) {

		// il faut aller chercher quelle est le Type qui vas avec cette colonne !
		//$name = static::findColumnName();
		$type = static::findDataType($col);

		// Préparation des props
		if (isset($type['config']['props'])) {
			foreach ($type['config']['props'] as $key => $elm) {
				$props[$key] = json_encode($elm);
			}
		}
		if (!isset($props[':data'])) {
			$class = get_called_class();
			$props[':data'] = "\$store.getters.getSelected$class.$col";
		}

		// Si définit dans acces, on renvoie celui la !
		if (isset(static::$_dataAccess[$col]["editComponent"])) {
			ComponentManager::loadComponentGenerated(static::$_dataAccess[$col]["editComponent"], $type["type"]);
			return (static::$_dataAccess[$col]["editComponent"]::getHtmlTag($type["type"], $props));
		}

		$componentName = null;
		if (is_subclass_of($type["type"], "TypeMulti"))
			$componentName = $type["type"]::getEditComponent($col, $type);
		else
			$componentName = $type["type"]::getEditComponent();
		ComponentManager::loadComponentGenerated($componentName, $type["type"]);
		return ($componentName::getHtmlTag($type['type'], $props));
	}
	public static function getShowComponentConfigured($col, $props = []) {
		$type = static::findDataType($col);
		if (isset($type['config']['props'])) {
			foreach ($type['config']['props'] as $key => $elm) {
				$props[$key] = json_encode($elm);
			}
		}
		if (!isset($props[':data'])) {
			$class = get_called_class();
			$props[':data'] = "\$store.getters.getSelected$class.$col";
		}

		if (isset(static::$_dataAccess[$col]["showComponent"])) {
			ComponentManager::loadComponentGenerated(static::$_dataAccess[$col]["showComponent"], $type["type"]);
			return (static::$_dataAccess[$col]["showComponent"]::getHtmlTag($type["type"], $props));
		}

		$componentName = null;
		if (is_subclass_of($type["type"], "TypeMulti"))
			$componentName = $type["type"]::getShowComponent($col, $type);
		else
			$componentName = $type["type"]::getShowComponent();
		ComponentManager::loadComponentGenerated($componentName, $type["type"]);
		return ($componentName::getHtmlTag($type['type'], $props));
	}

	public static function getComponentConfigured($col, $props = []) {
		if (isset($type['config']['props'])) {
			foreach ($type['config']['props'] as $key => $elm) {
				$props[$key] = json_encode($elm);
			}
		}
		if (!isset($props[':data'])) {
			$class = get_called_class();
			$props[':data'] = "\$store.getters.getSelected$class.$col";
		}
		$canSet = $props[':data'] . ".canSet";
		$edit = self::getEditComponentConfigured($col, $props);
		$show = self::getShowComponentConfigured($col, $props);
		$rt = "
			<template v-if='$canSet'>
				$edit
			</template>
			<template v-else>
				$show
			</template>
		";
		return ($rt);
	}

	/*
		Utile pour récupérer une copie propre directement de la Db;
	*/
	public function cloneFromDb() {
		if ($this->getId() != 0)
			return (self::getById($this->getId()));
		return (null);
	}
	/*
		Cette methode sert dans le cas ou il y a des choses à mettre à jours dans la classe meme ou sur d'autres élements
		si elle retourne autre chose que true c'est qu'il y a eu une erreur !
	*/
	public function beforeSetCaller() {
		$copie = $this->cloneFromDb();
		$this->beforeSet($copie);
	}

	public function beforeSet($prev) {
		return (true);
	}

	/*
	*/
	public function afterSetCaller() {
		$copie = $this->cloneFromDb();
		return ($this->afterSet($copie));
	}

	public function afterSet($prev) {
		return (true);
	}

	public function removeCheck() {
		foreach ($this->_typeInstances as $key => &$elm) {
			//var_dump($key);
			$elm->setConfig("notCheck", true);
		}
		//error();
	}

	public function getNewCopy() {
		$rt = $this->cloneFromDb();
		$rt->{self::$_primary_key} = 0;
		return ($rt);
	}

}
