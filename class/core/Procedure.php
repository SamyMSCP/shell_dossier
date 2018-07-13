<?php
class Procedure {
	protected static $_steps = [ ];
	public function __construct() { }
	public function __destruct() { }

	
	public static function nextStep($datas) {
		self::error(403, "La methode nextStep n'est pas implémentée");
	}

	public static function getSteps() {
		return (static::$_steps);
	}
}
