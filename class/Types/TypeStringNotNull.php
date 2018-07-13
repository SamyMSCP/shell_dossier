<?php
class TypeStringNotNull extends Type {

	protected static $_errorMsg = "Ce champ n'est pas facultatif.";
	
	protected static $_sqlColumn = "text";
	protected $_config = [];
	protected static function isValid($val) {
		return (is_string($val) && strlen($val) >= 1 && !empty($val));
	}
}
