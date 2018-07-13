<?php
require_once('TypeFloat.php');
class TypeDemiInt extends TypeFloat {

	protected static $_errorMsg = "Ce champ doit être un multiple de 0,5";

	protected  static function isValid($val) {
		return (is_int($val) || is_float($val) && $val > 0 && (intval($val * 10) % 5 == 0));
	}

	public function getEditComponent() {
		return ('ComponentTypeDemiIntEdit');
	}
}
