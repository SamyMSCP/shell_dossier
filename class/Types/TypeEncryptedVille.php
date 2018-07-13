<?php
require_once("TypeEncryptedString.php");
class TypeEncryptedVille extends TypeEncryptedString {

	protected static $_sqlColumn = "text";
	protected $_config = [];
	protected static function isValid($val) {
		return (parent::isValid($val) && strlen($val) >= 1);
	}

	public function getEditComponent() {
		return ("ComponentTypeVilleEdit");
	}
}
