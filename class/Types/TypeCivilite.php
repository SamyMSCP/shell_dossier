<?php
class TypeCivilite extends Type {
	protected static $_sqlColumn = "text";
	protected $_config = [];
	protected static function isValid($val) {
		if (
			!is_string($val) ||
			(
				strcmp($val, "Monsieur\n") != 0 &&
				strcmp($val, "Madame\n") != 0
			)
		)
			return (false);
		return (true);
	}

	public function getShort() {
		if ($this->get() == "Monsieur")
			return ("M.");
		else if ($this->get() == "Madame")
			return ("Mme");
		return ("-");
	}

	protected static function beforeSet($val) {

		$val = strtolower(trim($val));
		if (
			strcmp($val, "monsieur") == 0 ||
			strcmp($val, "m.") == 0
		)
			return ("Monsieur\n");
		else if (
			strcmp($val, "madame") == 0 ||
			strcmp($val, "mme") == 0
		)
			return ("Madame\n");
		return (null);
	}


	public function getEditComponent() {
		return ("ComponentTypeCiviliteEdit");
	}

}
