<?php
require_once("TypeInt.php");
class TypeToScpi extends TypeInt {


	public static function isValid($data) {
		return (parent::isValid($data));
	}

	public function getShowComponent() {
		return ("ComponentTypeToScpiShow");
	}

	public function getEditComponent() {
		return ("ComponentTypeToScpiEdit");
	}
}
