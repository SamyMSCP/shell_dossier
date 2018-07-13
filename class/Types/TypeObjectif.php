<?php
require_once("TypeSerialized.php");
class TypeObjectif extends TypeSerialized {

	protected static	$_errorMsg = "Veuillez compléter vos objectifs d'investissements";

	public static		$_listObjectif = array(
		"1" => "Percevoir des revenus réguliers à terme",
		"2" => "Percevoir des revenus réguliers immédiatement",
		"3" => "Transmettre un capital à mes proches",
		"4" => "Valoriser mon capital sur la durée",
		"5" => "Garantir mon capital",
		"6" => "Diversification",
		"7" => "Défiscalisation",
		"8" => "Autre"
	);

	protected static $_sqlColumn = "text";
	protected  $_config = [];
	protected static function isValid($val) {
		if (!is_array($val) || count($val) != 3)
			return (false);
		foreach ($val as $key => $elm) {
			if ($elm < 1 || $elm > 8)
			{
				return (false);
			}
		}
		return (parent::isValid($val));
	}

	protected static function prepareSet($val) {
		if (is_array($val)) {
			foreach ($val as &$elm) {
				$elm = intval($elm);
			}
		}
		return (parent::prepareSet($val));
	}

	protected static function prepareGet($val) {
		$val = parent::prepareGet($val);
		if (!is_array($val))
			return ($val);
		foreach ($val as &$elm) {
			$elm = intval($elm);
		}
		return ($val);
	}

	public function getShowComponent() {
		return ("ComponentTypeObjectifShow");
	}

	public function getEditComponent() {
		return ("ComponentTypeObjectifEdit");
	}

	public function have($code) {
		$data = $this->get();
		if (!is_array($data))
			return (false);
		foreach ($data as $key => $elm)
		{
			if ($elm == $code)
				return (true);
		}
		return (false);
	}
}
