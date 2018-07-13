<?php
require_once('TypeText.php');
class TypePrecisionCoherence extends TypeText {

	protected static $_errorMsg = "Ce champ doit fait au minimum 25 caractères";

	protected static $_sqlColumn = "text";
	protected $_config = [];
	protected static function isValid($val) {
		return (strlen($val) >= 1 && parent::isValid($val));
	}

	public function getEditComponent() {
		return ('ComponentTypeTextEdit');
	}
}
