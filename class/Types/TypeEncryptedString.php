<?php
require_once("TypeString.php");
class TypeEncryptedString extends TypeString {

	protected static $_sqlColumn = "text";
	protected $_config = [];
	protected static function isValid($val) {
		return (parent::isValid($val) && strlen($val) >= 1);
	}

	protected  static function prepareGet($val) {
		if (strlen($val))
			return (ft_decrypt_crypt_information($val));
		return (null);
	}

	protected static function prepareSet($val) {
		if (strlen($val))
			return (ft_crypt_information($val));
		return (null);
	}

}
