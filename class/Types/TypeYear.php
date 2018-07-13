<?php
class TypeYear extends Type {

	protected static $_errorMsg = "Veuillez entrer une année valide";

	protected static $_sqlColumn = "int(11)";
	protected $_config = [];
	protected  static function isValid($val) {
		if (strlen(strval($val)) < 4)
			return (false);
		return (is_int($val) && $val >=1900 && $val <= 2200);
	}

	public static function normalize($val, $config) {
		if ($val === null)
			return (null);
		return (intval($val));
	}

	public static function beforeSet($val) {
		if (is_string($val) && $val === "0")
			return (0);
		$tmp = intval($val);
		if ($tmp != 0)
			return ($tmp);
		return ($val);
	}

	public function getEditComponent() {
		return ("ComponentTypeUintEdit");
	}
}
