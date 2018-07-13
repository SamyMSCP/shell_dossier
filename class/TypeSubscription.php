<?php
require_once("core/Database.php");
require_once("core/Table.php");

class TypeSubscription extends Table
{
	protected static		$_name = "type_subscription";
	protected static		$_primary_key = "id";

	public function __construct() {}

	public function getParams() {
		return (unserialize($this->params));
	}
}
