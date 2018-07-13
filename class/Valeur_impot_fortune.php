<?php
require_once("core/Database.php");
require_once("core/Table.php");

class Valeur_impot_fortune extends Table
{
	protected static		$_name = "valeur_impot_fortune";
	protected static		$_primary_key = "id";
	private static			$_actual = null;
	public static			$_noSecure = ['datas'];

	public static function	getActual() {
		$rt = parent::getFromKeyValue("actual", "1");
		if (empty($rt))
			return (false);
		return ($rt[0]);
	}
	public static function getForStore() {
		$rt = [];
		foreach (self::getAll() as $key => $elm)
			$rt[$elm->id] = $elm->getDatas();
		return ($rt);
	}
	public function			getDatas() {
		return (unserialize($this->datas));
		/*
		if (self::$_actual == null)
		{
			self::$_actual = unserialize($this->datas);
		}
		return (self::$_actual);
		*/
	}
	public function			getIdFromValue($value)
	{
		$rt = null;
		foreach ($this->getDatas() as $key => $elm)
		{
			$rt = $key;
			if (
				$value == 0 ||
				($value > $elm['basse'] && $value <= $elm['haute']) ||
				$elm['haute'] == -1
			)
				break ;
		}
		return ($rt);
	}
	public function			getTauxFromValue($value)
	{
		$rt = null;
		foreach ($this->getDatas() as $key => $elm)
		{
			$rt = $elm['taux'];
			if (
				$value == 0 ||
				($value > $elm['basse'] && $value <= $elm['haute']) ||
				$elm['haute'] == -1
			)
				break ;
		}
		return ($rt);
	}
	public function			getDataFromValue($value)
	{
		$rt = null;
		foreach ($this->getDatas() as $key => $elm)
		{
			$rt = $elm;
			if (
				$value == 0 ||
				($value > $elm['basse'] && $value <= $elm['haute']) ||
				$elm['haute'] == -1
			)
				break ;
		}
		return ($rt);
	}
}
