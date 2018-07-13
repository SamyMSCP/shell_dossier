<?php
require_once("TypeEncryptedString.php");
class TypeEncryptedMail extends TypeEncryptedString {

	protected static $_errorMsg = "Veuillez insérer un courriel valide";

	protected static $_sqlColumn = "text";

	protected $_config = [];

	protected static function isValid($val) {
		if (empty($val))
			return (parent::isValid($val));
		return (parent::isValid($val) && filter_var($val, FILTER_VALIDATE_EMAIL));
	}

	public static function beforeSet($val) {
		if (is_string($val))
			return (mb_strtolower(trim($val)));
		return ($val);
	}

}
