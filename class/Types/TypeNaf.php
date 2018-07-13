<?php
require_once('TypeString.php');
class TypeNaf extends TypeString {

	protected static $_errorMsg = "Veuillez insérer un code Naf valide.";

	protected  static function isValid($val) {
		
		$code1 = null;
		$code2 = null;
		$code3 = null;
		$code4 = null;
		if (empty($val) || strlen($val) < 2)
			return (false);
		if (strlen($val) >= 2) // Code 1
			$code1 = intval(($val[0] * 10) + $val[1]);
		if (strlen($val) >= 4) // Code 2
			$code2 = intval($val[3]);
		if (strlen($val) >= 5) // Code 3
			$code3 = intval($val[4]);
		if (strlen($val) >= 6) // Code 4
			$code4 = $val[5];
		$naf = CodeNaf::getFromKeysValues([
			"code_1" => $code1,
			"code_2" => $code2,
			"code_3" => $code3,
			"code_4" => $code4
		]);
		if (empty($naf))
			return (false);
		return (true);
	}
	public function getEditComponent() {
		return ("ComponentTypeNafEdit");
	}
	protected static function beforeSet($value) {
		return(strtoupper($value));
	}
}
