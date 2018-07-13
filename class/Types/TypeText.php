<?php
class TypeText extends Type {

	protected static $_errorMsg = "Ce champ n'est pas valide";

	protected static $_sqlColumn = "text";
	protected $_config = [];
	protected static function isValid($val) {
		return (is_string($val));
	}

	public function getEditComponent() {
		return ('ComponentTypeTextEdit');
	}
}
