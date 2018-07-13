<?php
require_once('TypeFloat.php');
class TypeEuros extends TypeFloat {

	protected static $_errorMsg = "Veuillez entrer une donnée valide";

	protected static $_sqlColumn = "float";
	protected  $_config = [];
	protected static function isValid($val) {
		return (parent::isValid($val));
	}

	public static function normalize($val, $config) {
		return (parent::normalize($val, $config));
	}


	public function getEditComponent() {
		return ("ComponentTypeEurosEdit");
	}
}
