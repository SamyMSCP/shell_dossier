<?php
require_once("TypeSerialized.php"); 
class TypeSerializedOrigineFonds extends TypeSerialized {

	public static $_defaultDatas = [
		'Crédit' =>							['value' => 0, 'enabled' => false],
		'Épargne' =>						['value' => 0, 'enabled' => false],
		'Cession d’actifs immobiliers' =>	['value' => 0, 'enabled' => false],
		'Héritage (successions)' =>			['value' => 0, 'enabled' => false],
		'Réemploi de fonds propres' =>		['value' => 0, 'enabled' => false],
		'Donation' =>						['value' => 0, 'enabled' => false],
		'Réemploi de fonds démembrés' =>	['value' => 0, 'enabled' => false],
		'Cessions d’actifs mobiliers' =>	['value' => 0, 'enabled' => false],
		'Autre' =>							['value' => 0, 'enabled' => false, 'precision' => " "]
	];

	protected static $_errorMsg = "Les informations enregistrées ne sont pas cohérentes";

	public function setOnlyCredit() {
		$dt = self::$_defaultDatas;
		$dt['Crédit']['value'] = 100;
		$dt['Crédit']['enabled'] = true;
		$this->set($dt);
	}

	protected static function isValid($val) {
		if (!is_array($val)) {
			return (false);
		}
		$temoin = 0;
		foreach (static::$_defaultDatas as $key => $elm) {
			//DevLogs::set('Controle de :' . $key, 1);
			if (
				!isset($val[$key]) ||
				!isset($val[$key]['value']) ||
				!isset($val[$key]['enabled'])
			) {
				//DevLogs::set('manque de donnée:' . $key, 1);
				return (false);
			}
			if (!$val[$key]['enabled']) {
				continue ;
			}
			$value = $val[$key]['value'];
			if ($value < 0 || $value > 100) {
				return (false);
			}
			if (
				!(is_float($value) || is_int($value)) ||
				( $key == 'Autre' && !isset($val[$key]['precision']))
			) {
				//DevLogs::set('Bug Autre:' . $key, 1);
				return (false);
			}
			//if ($value <= 0)
				//return (false);
			$temoin += $value;
		}
		if ($temoin > 100.1 || $temoin < 99.9) {
			//DevLogs::set('Temoin:' . $temoin, 1);
			return (false);
		}
		//DevLogs::set(['isValid' => $val['Crédit']], 1);
		return (true);
	}

	public function getShowComponent() {
		return ("ComponentTypeShow");
	}

	public function getEditComponent() {
		return ("ComponentTypeSerializedOrigineFonds2");
	}

	protected static function beforeGet($val) {
		if (!is_array($val)) {
			return (static::$_defaultDatas);
		}
		foreach (static::$_defaultDatas as $key => $elm) {
			if (
				!isset($val[$key]) ||
				!isset($val[$key]['value']) || 
				!isset($val[$key]['enabled'])
			) {
				return (static::$_defaultDatas);
			}
			if ($key == "Autre" && !isset($val[$key]['precision'])) {
				return (static::$_defaultDatas);
			}
		}
		//DevLogs::set(['beforeGet 3' => $val['Crédit']], 1);
		//if ($val['Crédit']['value'] > 0)
			//$val['Crédit']['enabled'] = true;
		//else if ($val['Crédit']['value'] <= 0)
			//$val['Crédit']['enabled'] = false;
		return ($val);
	}

	protected static function beforeSet($val) {
		if (!is_array($val))
			return ($val);
		$rt = [];
		//if ($val['Crédit']['enabled'] !== true)
			//$val['Crédit']['value'] = 0;
		foreach (static::$_defaultDatas as $key => $elm) {
			if (
				!isset($val[$key]) ||
				!isset($val[$key]['value']) ||
				!isset($val[$key]['enabled'])
			) {
				continue ;
			}
			if (!$val[$key]['enabled']) {
				$val[$key]['value'] = 0;
			}
			$rt[$key] = [
				"value" => floatval($val[$key]['value']),
				"enabled" => boolval($val[$key]['enabled'])
			];
			if ($key == "Autre" && isset($val[$key]['precision']))
				$rt[$key]['precision'] = htmlspecialchars($val[$key]['precision']);
		}
		//$rt['Crédit']['enabled'] = $val['Crédit']['enabled'];
		//DevLogs::set(['beforeSet' => $val['Crédit']], 1);
		return ($rt);
	}
}
