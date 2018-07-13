<?php
class TypeIntPositive extends Type {

	protected static $_errorMsg = "Veuillez entrer une donnée positive.";

	protected static $_sqlColumn = "int(11)";
	protected $_config = [];
	protected  static function isValid($val) {
		return (is_int($val) && $val > 0);
	}

	public static function normalize($val, $config) {
		if ($val === null)
			return (null);
		return (intval($val));
	}

	public static function beforeSet($val) {
	/*
		var_dump($val);
		debug_print_backtrace();
		error();
		*/
		if (is_string($val) && $val === "0")
			return (0);
		$tmp = intval($val);
		if ($tmp != 0)
			return ($tmp);
		return ($val);
	}
}
