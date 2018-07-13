<?php
require_once('TypeFloat.php');
class TypeFloatNotNull extends TypeFloat {
	protected  static function isValid($val) {
		return (is_int($val) || is_float($val) && $val > 0);
	}

	public function getEditComponent() {
		return ('ComponentTypeDemiIntEdit');
	}
}
