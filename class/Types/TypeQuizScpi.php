<?php
require_once("TypeSerialized.php");
class TypeQuizScpi extends TypeSerialized {

	protected static $_errorMsg = "Veuillez compléter les champs ci-dessus";

	protected static $_sqlColumn = "text";
	protected  $_config = [];
	protected static function isValid($val) {
		if (!is_array($val))
			return (false);

		$resp = [];
		$mode = 0;
		foreach (ProfilInvestisseur2::$_listQuestions as $key => $elm) {
			if (!$elm['online'])
				continue ;
			$resp[$key] = null;
			if (
				!array_key_exists($key, $val) ||
				(
					$val[$key] !== null &&
					!isset($elm['response'][$val[$key]])
				)
			) {
				return (false);
			}
		}
		if (count($val) != count($resp)) {
			return (false);
		}
		return (true);
	}

	protected static function prepareSet($val) {
		$val = json_encode($val);
		return ($val);
	}

	protected static function prepareGet($val) {
		$val = json_decode($val, true);
		return ($val);
	}

	public function getShowComponent() {
		return ("ComponentTypeShow");
	}

	public function getEditComponent() {
		return ("ComponentTypeQuizScpiEdit");
	}

	public function setForGraphApi($data) {
		$val = static::beforeSet($data[$this->_config['column']]['value']);
		$dt = $this->get();
		foreach ($dt as $key => $elm) {
			if ($elm !== null)
				$val[$key] = $elm;
		}
		$data[$this->_config['column']]['value'] = $val;
		return (parent::setForGraphApi($data));
	}
}
