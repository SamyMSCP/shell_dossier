<?php
class TypeUint extends Type {

	protected static $_errorMsg = "Veuillez entrer une donnée non négative.";

	protected static $_sqlColumn = "int(11)";
	protected $_config = [];
	protected  static function isValid($val) {
		if ($val === null)
			return (false);
		return (is_int($val) && $val >= 0);
	}

	public static function normalize($val, $config) {
		if ($val === null)
			return (null);
		return (intval($val));
	}

	public static function beforeSet($val) {
		if ($val === null)
			return (null);
		if (is_string($val) && $val === "0")
			return (0);
		$tmp = intval($val);
		if ($tmp != 0)
			return ($tmp);
		if ($val === null) {
			var_dump($tmp);
			error();
		}
		return ($val);
	}

	public function getEditComponent() {
		return ("ComponentTypeUintEdit");
	}
}
