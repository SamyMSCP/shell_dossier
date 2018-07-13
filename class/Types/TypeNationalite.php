<?php
require_once("TypeEncryptedString.php");
class TypeNationalite extends TypeEncryptedString {

	protected static $_errorMsg = "Veuillez entrer une donnée valide.";

	//protected static $_sqlColumn = "int(11)";
	protected static $_sqlColumn = "text";
	protected $_config = [];

	protected  static function isValid($val) {
		$pays = Pays2::getFromKeyValue('nationalite',$val);
		return (!empty($pays));
	}

	public static function beforeSet($val) {
		return ($val);
	}

	public function getEditComponent() {
		return ("ComponentTypeNationaliteEdit");
	}
}
