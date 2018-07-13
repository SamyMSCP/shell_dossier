<?php
require_once("core/Database.php");
require_once("core/Table.php");

class CatPro extends Table
{
	protected static		$_name = "cat_pro";
	protected static		$_primary_key = "id";

	public function getName()  {
		return ($this->name);
	}
}
