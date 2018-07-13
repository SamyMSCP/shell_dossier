<?php
/*      __  __        _  _  _                          */
/*     |  \/  |  ___ (_)| || |  ___  _   _  _ __  ___  */
/*     | |\/| | / _ \| || || | / _ \| | | || '__|/ _ \ */
/*     | |  | ||  __/| || || ||  __/| |_| || |  |  __/ */
/*     |_|  |_| \___||_||_||_| \___| \__,_||_|   \___| */
/*                        _                            */
/*      ___   ___  _ __  (_)    ___  ___   _ __ ___    */
/*     / __| / __|| '_ \ | |   / __|/ _ \ | '_ ` _ \   */
/*     \__ \| (__ | |_) || | _| (__| (_) || | | | | |  */
/*     |___/ \___|| .__/ |_|(_)\___|\___/ |_| |_| |_|  */
/*                |_|                                  */

class ComponentManager {
	private static		$_componentGenerator = [];
	private static		$_components = [];

	private function __construct() {}
	private function __destruct() {}

	public static function loadComponentGenerated($component, $name = "noname", $config = []) {
		if (!isset(self::$_componentGenerator[$component]))
			self::$_componentGenerator[$component] = [];

		if (!isset(self::$_componentGenerator[$component][$name]))
			self::$_componentGenerator[$component][$name] = [];

		foreach (self::$_componentGenerator[$component][$name] as $val) {
			if (json_encode($val) === json_encode($config))
				return (false);
		}
		require_once(__DIR__ . "/../ComponentGenerator/$component.php");
		self::$_componentGenerator[$component][$name][] = $config;

		foreach ($component::getDependances() as $component2 => $inComponent2) {

			foreach ($inComponent2 as $name2 => $config2) {
					self::loadComponentGenerated($component2, $name2, $config2);
			}
		}

		$component::prepare($name, $config);
		return (true);
	}

	public static function getScriptHead() {
		$rt = "";
		foreach (self::$_componentGenerator as $component => $inComponent) {
			foreach ($inComponent as $name => $inName)
				foreach ($inName as $config)
					$rt .= $component::make($name, $config);
		}
		return ($rt);
	}

	public static function getComponents() {
		return (self::$_componentGenerator);
	}
}
