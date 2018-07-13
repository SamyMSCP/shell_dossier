<?php
require_once("core/Database.php");
require_once("core/Table.php");
class Mscpi extends Table
{
	use DocumentTrait;

	public function checkAuthorisation($dh) {
		return (true);
	}
}
