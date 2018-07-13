<?php
require_once('TypeEuros.php');
class TypeUEuros extends TypeEuros {

	protected static function isValid($val) {
		return (parent::isValid($val) && $val > 0);
	}
}
