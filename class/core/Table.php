<?php
abstract class Table
{
	public static			$_noSecure = array();
	protected				$_is_new = 0;
	protected static		$_db = "mscpi_db";
	private static			$_needQuotes = array(
		"VARCHAR",
		"LONGTEXT"
	);

	/**
	 * Table constructor.
	 */
	public  function __construct() {
	}

	/**
	 * @return mixed
	 */
	public static function getAll() {
		$name = (isset(static::$_name)) ? '`' . static::$_name . '`' : get_called_class();
		return Database::query(static::$_db, "SELECT * FROM " . $name, get_called_class());
	}

	/**
	 * @return mixed
	 */
	public static function getAllArray() {
		$name = (isset(static::$_name)) ? '`' . static::$_name . '`' : get_called_class();
		return Database::queryArray(static::$_db, "SELECT * FROM " . $name, get_called_class());
	}
	//prepareNoClassCheckSecurity

	/**
	 * @param $id
	 * @return mixed
	 */
	public static function getFromId($id) {
		$name = (isset(static::$_name)) ? '`' . static::$_name . '`' : get_called_class();
		$req =  "SELECT * FROM " . $name . " WHERE " . static::$_primary_key ." = :id";
		return Database::prepare(static::$_db, $req, compact("id"), get_called_class());
	}

	/**
	 * @param $col
	 * @param $arr
	 * @return mixed
	 */
	public static function getFromArray($col, $arr) {
		$name = (isset(static::$_name)) ? '`' . static::$_name . '`' : get_called_class();
		$req =  "SELECT * FROM " . $name . " WHERE ";
		$i = 0;
		while ($i < count($arr)) {
			if ($i != 0)
				$req .= " OR ";
			if ($arr[$i] === "NULL"){
				$req .= $col . " IS NULL ";
				array_splice($arr, $i, 1);
			} else if ($arr[$i] === "NOT NULL"){
				$req .= $col . " IS NOT NULL ";
				array_splice($arr, $i, 1);
			}
			else
				$req .= $col . " = ? ";
			$i++;
		}
		return Database::prepare(static::$_db, $req, $arr, get_called_class());
	}

	/**
	 * @return mixed
	 */
	public static function getNotifCrmAll() {
		$name = (isset(static::$_name)) ? '`' . static::$_name . '`' : get_called_class();
		$req =  "SELECT * FROM " . $name . " JOIN CRM ON CRM.`id_dh` = `DONNEUR D'ORDRE`.id_dh WHERE finish IS NULL ORDER BY DATE_f";
		return Database::prepare(static::$_db, $req, array(), get_called_class());
	}

	/**
	 * @param $value
	 * @return mixed
	 */
	public static function getNotifCrmValue($value) {
		$name = (isset(static::$_name)) ? '`' . static::$_name . '`' : get_called_class();
		$req =  "SELECT * FROM " . $name . " JOIN CRM ON CRM.`id_dh` = `DONNEUR D'ORDRE`.id_dh WHERE `DONNEUR D'ORDRE`.`conseiller` = :id_dh AND finish IS NULL ORDER BY DATE_f";
		return Database::prepare(static::$_db, $req, array("id_dh" => $value), get_called_class());
	}

	/**
	 * @param $key
	 * @param $value
	 * @return mixed
	 */
	public static function getFromKeyValue($key, $value) {
		$name = (isset(static::$_name)) ? '`' . static::$_name . '`' : get_called_class();
		$req =  "SELECT * FROM " . $name . " WHERE ";
		$req .= $key . " = :" . $key;
		return Database::prepare(static::$_db, $req, array($key => $value), get_called_class());
	}

	/**
	 * @param $key
	 * @param $value
	 * @return mixed
	 */
	public static function getFromKeyValueIdDesc($key, $value) {
		$name = (isset(static::$_name)) ? '`' . static::$_name . '`' : get_called_class();
		$req =  "SELECT * FROM " . $name . " WHERE ";
		$req .= $key . " = :" . $key . " ORDER BY ".static::$_primary_key." DESC";
		return Database::prepare(static::$_db, $req, array($key => $value), get_called_class());
	}

	/**
	 * @param $array
	 * @return mixed
	 */
	public static function deleteFromKeysValues($array) {
		$temoin = 0;
		$name = (isset(static::$_name)) ? '`' . static::$_name . '`' : get_called_class();
		$req =  "DELETE FROM " . $name . " WHERE ";
		foreach ($array as $key => $value) {
			if ($temoin)
				$req .= "AND ";
			else
				$temoin = 1;
			$req .= "`" . $key . "` = :" . $key . " ";
		}
		return Database::prepareNoClass(static::$_db, $req, $array);
	}

	/**
	 * @param $array
	 * @return mixed
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
		return Database::prepare(static::$_db, $req, $array, get_called_class());
	}

	/**
	 * @return bool
	 */
	public static function getCols() {
		return Database::getCols(static::$_db, get_called_class());
	}

	/**
	 * @return bool
	 */
	public function update() {
		if (!isset($this->id) || $this->_is_new || $this->id === 0)
		{
			echo "Pas de mise a jours";
			return false;
		}
		$req = "UPDATE " . get_called_class() .  " SET ";
		$temoin = 0;
		foreach(static::$_to_save as $elm)
		{
			if ($temoin === 1)
				$req .= ", ";
			$req .= $elm . " = ";
			if (self::check_txt(static::$_tb[$elm]))
				$req .= '"' . $this->$elm . '" ';
			else 
				$req .= $this->$elm . " ";
			$temoin = 1;
		}
		$req .= "WHERE id = " . $this->id;
		Database::exec(static::$_db, $req);
		return true;
	}

	/**
	 * @param $var
	 * @return bool
	 */
	private static function check_txt($var){
		foreach (self::$_needQuotes as $check)
		{
			if (strpos($var, $check) === 0)
				return true;
	}
	return false;
	}

	/**
	 * @return bool
	 */
	public function insertInto()
	{
		//if (!$this->_is_new)
		if (isset($this->{static::$_primary_key}))
		{
			echo "Pas d'ajout";
			return false;
		}
		$req = "INSERT INTO " . static::$_name .  " ( ";
		$temoin = 0;
		foreach(static::$_to_save as $elm)
		{
			if ($elm == static::$_primary_key)
				continue ;
			if (!isset($this->{$elm}))
			{
				die ("Il manque le colonne " . $elm . " pour insérer une donné dans ");
			}
			if ($temoin === 1)
				$req .= ", ";
			$req .= "`" . $elm . "` ";
			$temoin = 1;
		}
		$req .= ") VALUES (";
		$temoin = 0;
		foreach(static::$_to_save as $elm)
		{
			if ($elm == static::$_primary_key)
				continue ;
			if ($temoin === 1)
				$req .= ", ";
			//if (self::check_txt(static::$_tb[$elm]))
				//$req .= '"' . $this->$elm . '" ';
			//else 
				$req .= "'" . $this->$elm . "' ";
			$temoin = 1;
		}
		$req .= ")";
		$this->id = Database::exec(static::$_db, $req);
		if (!empty($this->id))
			$this->_is_new = 0;
		else
			die ("Une erreure est survenue pendant l'inserttion");
		return $this->id;
	}

	/**
	 *
	 */
	public function create_table() {
		$temoin = 0;
		$req = "CREATE TABLE " . get_called_class() . " ( ";
		foreach (static::$_tb as $key => $value)
		{
			if ($temoin === 1)
				$req .= ", ";
			$req .= $key . " " . $value . " ";
			$temoin = 1;
		}
		if (isset(static::$_primary_key))
			$req .= ", PRIMARY KEY(" . static::$_primary_key . ") ";
		$req .= ")";
		Database::exec(static::$_db, $req);
	}

	/**
	 * @param $db
	 */
	public function setDatabase($db) {
		static::$_db = $db;
	}

	/**
	 *
	 */
	public function show() {
		var_dump($this);
	}

	/**
	 * @param $col
	 * @return bool|mixed
	 */
	public function setColumnNull($col) {
		$name = (isset(static::$_name)) ? '`' . static::$_name . '`' : get_called_class();
		$req =  "UPDATE " . $name . " SET " . $col . " = NULL  WHERE " . static::$_primary_key ." = ?";
		$data = array(
			$this->{static::$_primary_key}
		);
		if (($ret = Database::prepareNoClass(static::$_db, $req, $data)))
		{
			$this->$col = NULL;
			return $ret;
		}
		return false;
	}

	/**
	 * @param $col
	 * @param $nData
	 * @return bool|mixed
	 */
	public function updateOneColumn($col, $nData) {
		$name = (isset(static::$_name)) ? '`' . static::$_name . '`' : get_called_class();
		$req =  "UPDATE " . $name . " SET " . $col . " = ?  WHERE " . static::$_primary_key ." = ?";
		$data = array(
			$nData,
			$this->{static::$_primary_key}
		);
		// Vérifier si il y a une différence entre la valeur enregistrée et celle qu'on souhaite enregistrer.
		//		si oui on à trouvé l'erreur des Crm.....
		if (($ret = Database::prepareNoClass(static::$_db, $req, $data))) {
			$this->$col = $nData;
			return $ret;
		}
		return false;
	}

	/**
	 * @param $col
	 * @param $nData
	 * @return mixed
	 */
	public function updateOneColumnCheckSecurity($col, $nData) {
		$name = (isset(static::$_name)) ? '`' . static::$_name . '`' : get_called_class();
		$req =  "UPDATE " . $name . " SET " . $col . " = ?  WHERE " . static::$_primary_key ." = ?";
		$data = array(
			$nData,
			$this->{static::$_primary_key}
		);
		$this->$col = $nData;
		return Database::prepareNoClassCheckSecurity(static::$_db, $req, $data, get_called_class());
	}

	/**
	 * @return mixed
	 */
	public function deleteMe() {
		$name = (isset(static::$_name)) ? '`' . static::$_name . '`' : get_called_class();
		$req =  "DELETE FROM" . $name . " WHERE " . static::$_primary_key ." = ?";
		$data = array(
			$this->{static::$_primary_key}
		);
		$rt = Database::prepareNoClass(static::$_db, $req, $data, get_called_class());
		return ($rt);
	}

	/**
	 * @return mixed
	 */
	public function getId() {
		return ($this->{static::$_primary_key});
	}
}
