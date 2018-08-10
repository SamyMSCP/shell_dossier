<?php
class Database
{
	/**
	 * L'objet PDO pour la connexion a cette base de donnees
	 */
	static public $_db = array();
	static private $_instance = null;

	/**
	 * Constructeur de la base de donnees
	 * @param string	$db
	 * @param string	$user
	 * @param string	$passwd
	 * @param string	$host
	 */
	private function __construct() {}
	public static function new_connexion($db = "mscpi_db", $user = USERNAME, $passwd = PASSWORD, $host = SERVERNAME) {
		try{
			if (self::$_instance === null)
			{
				self::$_instance = new Database();
			}
			if (!array_key_exists($db, self::$_db))
			{
				self::$_db[$db] = new PDO("mysql:host=" . $host .";dbname=" . $db .";charset=utf8", $user, $passwd);
				self::$_db[$db]->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			}
		}
		catch (Exception $e) {
			if (php_sapi_name() === "cli") {
//				echo $e->getMessage(); // Debug info
			}
		}
	}

	private static function check_connexion($db) {
		if (!array_key_exists($db, self::$_db))
			die("La connexion n'a pas ete etablie avec cette connexion");
	}

	/**
	 * Requete sql simple
	 * @param string	$statement
	 * @return boolean
	 */
	public static function getCols($db, $classname) {
		self::check_connexion($db);
		$req = self::$_db[$db]->query("DESC " . $classname);
		$req->setFetchMode (PDO::FETCH_COLUMN);
		$datas = $req->fetchAll();
		return ($datas);
	}
	public static function query($db, $statement, $classname) {
		self::check_connexion($db);
		$req = self::$_db[$db]->query($statement);
		$req->setFetchMode (PDO::FETCH_CLASS , $classname);
		$datas = $req->fetchAll();
		if (isset($classname::$_noSecure)) {
			foreach ($datas as $key => $elm) {
				foreach (get_object_vars($elm) as $key2 => $elm2) {
					if (!in_array($key2, $classname::$_noSecure))
						$datas[$key]->$key2 = htmlspecialchars($datas[$key]->$key2);
				}
			}
		}
		return ($datas);
	}

	/**
	 * @param $db
	 * @param $statement
	 * @param $classname
	 * @return mixed
	 */
	public static function queryArray($db, $statement, $classname) {
		self::check_connexion($db);
		$req = self::$_db[$db]->query($statement);
		$req->setFetchMode (PDO::FETCH_ASSOC);
		$datas = $req->fetchAll();
		foreach ($datas as $key => $elm) {
			foreach ($elm as $key2 => $elm2) {
				if (!in_array($key2, $classname::$_noSecure))
					$datas[$key][$key2] = htmlspecialchars($datas[$key][$key2]);
			}
		}
		return ($datas);
	}

	/**
	 * @param $db
	 * @param $statement
	 * @param $attr
	 * @return mixed
	 */
	public static function prepareNoClass($db, $statement, $attr) {
		self::check_connexion($db);
		foreach ($attr as $key => $elm) {
			$attr[$key] = htmlspecialchars($attr[$key]);
		}
		$req = self::$_db[$db]->prepare($statement);
		$req->execute($attr);
		return $req->rowCount();
	}

	/**
	 * @param $db
	 * @param $statement
	 * @param $attr
	 * @param $classname
	 * @return mixed
	 */
	public static function prepareNoClass2($db, $statement, $attr) {
		self::check_connexion($db);
		foreach ($attr as $key => $elm) {
			$attr[$key] = htmlspecialchars($attr[$key]);
		}
		$req = self::$_db[$db]->prepare($statement);
		return $req->execute($attr);
	}
	public static function prepareNoClass2NoSecurity($db, $statement, $attr) {
		self::check_connexion($db);
		$req = self::$_db[$db]->prepare($statement);
		return $req->execute($attr);
	}
	
	public static function prepareNoClassCheckSecurity($db, $statement, $attr, $classname) {
		self::check_connexion($db);
		foreach ($attr as $key => $elm) {
			if (!in_array($key, $classname::$_noSecure))
				$attr[$key] = htmlspecialchars($attr[$key]);
		}
		$req = self::$_db[$db]->prepare($statement);
		return $req->execute($attr);
	}

	/**
	 * @param $db
	 * @param $statement
	 * @param $attr
	 * @return bool
	 */
	public static function prepareInsert($db, $statement, $attr) {
		self::check_connexion($db);
		foreach ($attr as $key => $elm) {
			$attr[$key] = htmlspecialchars($attr[$key]);
		}
		$req = self::$_db[$db]->prepare($statement);
		$req->execute($attr);
		if (!$req)
			return false;
		$datas = self::$_db[$db]->lastInsertId(); ;
		return ($datas);
	}

	/**
	 * @param $db
	 * @param $statement
	 * @param $attr
	 * @param $classname
	 * @return bool
	 */
	public static function prepareInsertCheckSecurity($db, $statement, $attr, $classname) {
		self::check_connexion($db);
		foreach ($attr as $key => $elm) {
			if (!in_array($key, $classname::$_noSecure))
				$attr[$key] = htmlspecialchars($attr[$key]);
		}
		$req = self::$_db[$db]->prepare($statement);
		$req->execute($attr);
		if (!$req)
			return false;
		$datas = self::$_db[$db]->lastInsertId(); ;
		return ($datas);
	}

	/**
	 * @param $db
	 * @param $statement
	 * @param $attr
	 * @return bool
	 */
	public static function prepareInsertNoSecurity($db, $statement, $attr) {
		self::check_connexion($db);
		$req = self::$_db[$db]->prepare($statement);
		$req->execute($attr);
		if (!$req)
			return false;
		$datas = self::$_db[$db]->lastInsertId(); ;
		return ($datas);
	}

	/**
	 * @param $db
	 * @param $statement
	 * @param $attr
	 * @param $classname
	 * @return mixed
	 */
	public static function prepareCheckSecurity($db, $statement, $attr, $classname) {
		self::check_connexion($db);
		foreach ($attr as $key => $elm) {
			if (!in_array($key, $classname::$_noSecure))
				$attr[$key] = htmlspecialchars($attr[$key]);
		}
		$req = self::$_db[$db]->prepare($statement);
		$req->setFetchMode (PDO::FETCH_CLASS , $classname);
		$req->execute($attr);
		$datas = $req->fetchAll();
		return ($datas);
	}

	/**
	 * @param $db
	 * @param $statement
	 * @param $attr
	 * @return mixed
	 */
	public static function getNoClass($db, $statement, $attr) {
		self::check_connexion($db);

		foreach ($attr as $key => $elm) {
			$attr[$key] = htmlspecialchars($attr[$key]);
		}
		$req = self::$_db[$db]->prepare($statement);
		$req->execute($attr);
		$datas = $req->fetchAll();
		return ($datas);
	}

	/**
	 * @param $db
	 * @param $statement
	 * @param $attr
	 * @param $classname
	 * @return mixed
	 */
	public static function prepare($db, $statement, $attr, $classname) {
		self::check_connexion($db);
		foreach ($attr as $key => $elm) {
			$attr[$key] = htmlspecialchars($attr[$key]);
		}
		$req = self::$_db[$db]->prepare($statement);
		$req->setFetchMode (PDO::FETCH_CLASS , $classname);
		$req->execute($attr);
		$datas = $req->fetchAll();
		return ($datas);
	}

	/**
	 * @param $db
	 * @param $statement
	 * @return bool
	 */
	public static function exec($db, $statement) {
		if (self::$_db[$db]->exec($statement))
			return self::$_db[$db]->lastInsertId();
		else
			return false;
	}

	/**
	 * @param $name
	 * @return mixed|null
	 */
	public static function getDb($name) {
		if (isset(self::$_db[$name]))
			return (self::$_db[$name]);
		return (null);
	}

	/**
	 * @param string $name
	 * @return bool
	 */
	public function beginTransaction($name = "mscpi_db") {
		if (isset(self::$_db[$name]))
		{
			return (self::$_db[$name]->beginTransaction());
		}
		return (false);
	}

	/**
	 * @param string $name
	 * @return bool
	 */
	public function commit($name = "mscpi_db") {
		if (isset(self::$_db[$name]))
		{
			return (self::$_db[$name]->commit());
		}
		return (false);
	}

	/**
	 * @param string $name
	 * @return bool
	 */
	public function rollBack($name = "mscpi_db") {
		if (isset(self::$_db[$name]))
		{
			return (self::$_db[$name]->rollBack());
		}
		return (false);
	}

	/**
	 * @param $db
	 * @param $req
	 * @return mixed
	 */
	public function request($db, $req) {
		return  (self::$_db[$db]->query($req));
	}
}
