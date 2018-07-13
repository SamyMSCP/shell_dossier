<?php
class TypeFloat extends Type {
	protected static $_sqlColumn = "float";
	protected  $_config = [];
	protected  static function isValid($val) {
		//var_dump(is_int($val) || is_float($val)); error('cou');
		return (is_int($val) || is_float($val));
	}

	public static function normalize($val, $config) {
		return (floatval($val));
	}

	public static function beforeSet($val) {
		if ($val === null)
			return (null);
		if (is_string($val) && $val === "0")
			return (0);
		$tmp = floatval($val);
		if ($tmp != 0)
			return ($tmp);
		return ($val);
	}

	public function getEditComponent() {
		return ('ComponentTypeFloatEdit');
	}
}
