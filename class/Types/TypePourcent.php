<?php
require_once('TypeFloat.php');
class TypePourcent extends TypeFloat {

	protected static $_errorMsg = "Veuillez entrer un pourcentage valide";

	protected static $_sqlColumn = "float";
	protected  $_config = [];
	protected static function isValid($val) {
		return (parent::isValid($val) && $val >= 0 && $val <= 100);
	}

	public static function normalize($val, $config) {
		return (parent::normalize($val, $config));
	}

	public function getShowComponent() {
		return ("ComponentTypeShow");
	}

	public function getEditComponent() {
		return ("ComponentTypePourcentEdit");
	}

}
