<?php
require_once("core/Database.php");
require_once("core/Table.php");

class ObjectifsList extends Table
{
	protected static		$_name = "objectifs_list";
	protected static		$_primary_key = "id";
	public static			$_noSecure = ["content"];

	public function getName() {
		return ($this->name);
	}

	public function getContent() {
		return ($this->content);
	}
}
