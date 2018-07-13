<?php
require_once("TypeEncryptedString.php");
class TypeEncryptedCivilite extends TypeEncryptedString {

	protected static $_errorMsg = "Veuille insérer une civilité valide ('Monsieur' ou 'Madame') ";

	protected static $_sqlColumn = "text";
	protected $_config = []; protected static function isValid($val) { if (
			!is_string($val)
			||
			(
				strcmp($val, "Monsieur") != 0 &&
				strcmp($val, "Madame") != 0 &&
				strcmp($val, "Monsieur\n") != 0 &&
				strcmp($val, "Madame\n") != 0
			)
		)
		{
			return (false);
		}

		return (parent::isValid($val));
	}

	protected static function beforeSet($val) {

		$val2 = strtolower(trim($val));
		if (
			strcmp($val2, "monsieur\n") == 0 ||
			strcmp($val2, "monsieur") == 0 ||
			strcmp($val2, "m.") == 0
		)
			return ("Monsieur");
		else if (
			strcmp($val2, "madame\n") == 0 ||
			strcmp($val2, "madame") == 0 ||
			strcmp($val2, "mme") == 0
		)
			return ("Madame");
		return ($val);
	}

	public function getShort() {
		if ($this->get() == "Monsieur")
			return ("M.");
		else if ($this->get() == "Madame")
			return ("Mme");
		return ("-");
	}

	public function getEditComponent() {
		return ("ComponentTypeCiviliteEdit");
	}

}
