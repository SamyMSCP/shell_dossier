<?php
require_once('core/Database.php');
require_once('core/Table.php');

class AutoTask extends Table
{
	protected static		$_name = "AutoTask";
	protected static		$_primary_key = "id";
	private static			$_cronInterval = 60;
	public static			$_noSecure = ["arguments"];

	public static function executeRegular() {
		foreach (self::getRegularTasks() as $key => $elm)
			$elm->executeAsRegular();
	}
	public static function executeSpots() {
		foreach (self::getSpotTasks() as $key => $elm)
			$elm->executeAsSpot();
	}
	public static function getRegularTasks() {
		$req = "SELECT * FROM `" . self::$_name . "` WHERE last_execution <= (UNIX_TIMESTAMP(CURRENT_TIMESTAMP) - inter) AND date_execution IS NULL;";
		return Database::query(
			static::$_db,
			$req,
			get_called_class()
		);
	}
	public static function getSpotTasks() {
		$req = "SELECT * FROM `" . self::$_name . "` WHERE date_execution <= " . (time() + self::$_cronInterval) . " AND date_end IS NULL and inter IS NULL";
		return Database::query(
			static::$_db,
			$req,
			get_called_class()
		);
	}
	public function executeAsRegular() {
		$this->updateOneColumn("last_execution", time());
		$this->execute();
	}
	public function executeAsSpot() {
		$this->updateOneColumn("date_end", time());
		$this->execute();
	}
	public function execute() {
		$this->classname::{$this->methodName}(
			unserialize($this->arguments)
		);
	}
	public static function insertRegularTask($id_dh, $classname, $methodName, $arguments, $inter)
	{
		$req = "INSERT INTO 
			`AutoTask` (id_dh, classname, methodName, arguments, inter, date_creation)
			VALUES (:id_dh, :classname, :methodName, :arguments, :inter, :date_creation);";
		$data = [
			"id_dh" => $id_dh,
			"classname" => $classname,
			"methodName" => $methodName,
			"arguments" => serialize($arguments),
			"inter" => $inter,
			"date_creation" => time()
		];
		return Database::prepareInsertCheckSecurity(static::$_db, $req, $data, "AutoTask");
	}
	public static function insertSpotTask($id_dh, $classname, $methodName, $arguments, $date_execution)
	{
		$req = "INSERT INTO 
			`AutoTask` (id_dh, classname, methodName, arguments, date_execution, date_creation)
			VALUES (:id_dh, :classname, :methodName, :arguments, :date_execution, :date_creation);";
		$data = [
			"id_dh" => $id_dh,
			"classname" => $classname,
			"methodName" => $methodName,
			"arguments" => serialize($arguments),
			"date_execution" => $date_execution,
			"date_creation" => time()
		];
		return Database::prepareInsertCheckSecurity(static::$_db, $req, $data, "AutoTask");
	}
}
