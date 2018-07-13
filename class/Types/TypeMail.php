<?php
class TypeMail extends Type {

	protected static $_sqlColumn = "text";

	protected $_config = [];

	protected static function isValid($val) {
		return (filter_var($val, FILTER_VALIDATE_EMAIL));
	}

	public static function beforeSet($val) {
		return (mb_strtolower(trim($val)));
	}

}
