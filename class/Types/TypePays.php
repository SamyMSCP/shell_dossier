<?php
require_once("TypeString.php");
class TypePays extends TypeString {

	protected static $_errorMsg = "Veuillez entrer une donnée valide.";

	protected static $_sqlColumn = "text";
	protected $_config = [];

	protected  static function isValid($val) {
		$pays = Pays2::getFromKeyValue('nom_fr_fr',$val);
		return (!empty($pays));
	}

	public static function beforeSet($val) {
		return ($val);
	}

	public function getEditComponent() {
		return ("ComponentTypePaysEdit");
	}
}
