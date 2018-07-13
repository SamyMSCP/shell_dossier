<?php
class TypeSiret extends Type {

	protected static $_errorMsg = "Veuillez entrer un N° siret valide";

	protected static $_sqlColumn = "text";
	protected $_config = [];
	protected  static function isValid($val) {
		if ($val === null)
			return (false);
		return (preg_match("/^[0-9]{14}$/i", $val) == 1);
	}

	public static function normalize($val, $config) {
		if ($val === null)
			return (null);
		return (intval($val));
	}

	public static function beforeSet($val) {
		if ($val === null)
			return (null);
		return ($val);
	}

	public function getEditComponent() {
		return ("ComponentTypeSiretEdit");
	}
}
