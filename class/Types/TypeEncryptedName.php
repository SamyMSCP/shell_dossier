<?php
require_once("TypeEncryptedString.php");
class TypeEncryptedName extends TypeEncryptedString {

	protected static $_errorMsg = "2 caracteres minimum";

	protected static $_sqlColumn = "text";

	protected $_config = [];

	protected static function isValid($val) {
		return (parent::isValid($val) && strlen($val) < 255 && strlen($val) >= 2);
	}

	public static function beforeSet($val) {
		if (is_string($val))
			return (mb_strtolower(trim($val)));
		return ($val);
	}

	public static function beforeGet($val) {
		if (is_string($val))
			return (ucfirst(trim($val)));
		return ($val);
	}

}
