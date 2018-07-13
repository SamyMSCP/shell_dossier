<?php
class TypeBool extends Type {

	protected static $_errorMsg = "Ce champ est obligatoire";

	protected static $_sqlColumn = "int(1)";
	protected  $_config = [];
	protected static function isValid($val) {
		//if (!(is_bool($val) || (is_int($val) && $val <= 1 && $val >= 0))) {
		//}
		return (is_bool($val) || (is_int($val) && $val <= 1 && $val >= 0));
	}

	protected static function beforeSet($val) {
		if ($val === null)
			return (null);
		if (is_int($val))
			return ($val != 0);
		if (is_string($val) && ($val == "true" || $val == "false"))
			return ($val === "true");
		return ($val);
	}

	protected static function beforeGet($val) {
		if ($val === null)
			return (null);
		if (!empty($val))
			return (true);
		return (false);
	}

	public static function normalize($val, $config) {
		if ($val === null)
			return (null);
		return ($val >= 1);
	}


	public function getShowComponent() {
		return ("ComponentTypeBoolShow");
	}

	public function getEditComponent() {
		return ("ComponentTypeBool2btnEdit");
	}

}
