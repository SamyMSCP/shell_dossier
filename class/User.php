<?php
require_once("core/class/Database.php");
require_once("core/class/Table.php");
class User extends Table
{
//	protected static		$_db = "test";
	protected static		$_primary_key = "id";
	protected static		$_tb = array(
		"id"	=> "int NOT NULL AUTO_INCREMENT",
		"name"	=> "VARCHAR (255)",
		"age"	=> "int"
	);
	protected static		$_to_save = array(
		"name",
		"age"
	);
	public static function create($name, $age) {
		$rt = new User();
		$rt->_is_new = 1;
		$rt->name = $name;
		$rt->age= $age;
		return ($rt);
	}
	public function getId() {
		return $this->id;
	}
}
