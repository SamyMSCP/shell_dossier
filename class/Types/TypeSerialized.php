<?php
class TypeSerialized extends Type {

	protected static $_errorMsg = "Veuillez entrer une donnée valide";

	protected static $_sqlColumn = "text";
	protected  $_config = [];
	protected static function isValid($val) {
		/*
		try {
			serialize($val);
		} catch (Exception $e) {
			echo "ca marche pas";
			exit();
		}
		*/
		return (true);
	}

	protected static function prepareSet($val) {
		$val = json_encode($val);
		return ($val);
	}

	protected static function prepareGet($val) {
		$val = json_decode($val, true);
		return ($val);
	}

	public function getShowComponent() {
		return ("ComponentTypeShow");
	}

	public function getEditComponent() {
		return ("ComponentTypeShow");
	}
}
