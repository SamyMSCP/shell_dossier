<?php
require_once("TypeString.php");
class TypeStatutParcourClient extends TypeString {

	protected static $_errorMsg = "Veuillez entrer une donnée valide";

	protected static function isValid($val) {
		$arr = ProcedureCreationProjet::getSteps();
		if (!in_multi_array($val, $arr))
			return (false);
		return (parent::isValid($val));
	}

	public function getShowComponent() {
		return ("ComponentTypeShow");
	}

	public function getEditComponent() {
		return ("ComponentTypeStatutParcourClientEdit");
	}
}
