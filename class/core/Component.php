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

class Component {

	/*
		Les dépendances à charger pour le fonctionnement de la classe.
		[
			"component" => 
				[ "className" => config[] ]
		]
	*/
	protected static $_dependances = [];

	protected static $_componentName = "";

	private function __construct() { }

	private function __destruct() {}

	public static function getComponentName($elm) {
		return (static::$_componentName . "-" . strtolower($elm));
	}

	public static function getDependances() {
		return (static::$_dependances);
	}

	public static function getHtmlTag($elm, $props = []) {
		$name = static::getComponentName($elm);
		$pr = "";
		foreach ($props as $k => $v) {
			$pr .= " $k='$v'";
		}
		return ("<$name $pr></$name>");
	}

	protected static function getTemplate($class, $config) {
		return ("");
	}

	protected static function getTemplateId($class) { 
		return (static::getComponentName($class) . "-id");
	}

	protected static function getClassName($class) {
		return (get_called_class() . "_" . $class);
	}

	public static function prepare($class) {
		if (is_subclass_of($class, "Table2")) {
			foreach ($class::getDataTypes() as $col => $colConfig)
			{
				ComponentManager::loadComponentGenerated($class::getEditComponent($col), $colConfig["type"], []);
				ComponentManager::loadComponentGenerated($class::getShowComponent($col), $colConfig["type"], []);
			}
		}
	}

	public static function scriptHead($class, $config) {
		$templateId = static::getTemplateId($class);
		$template = static::getTemplate($class, $config);
		$component = static::getComponent($class, $config);

		return ("
<script type='text/x-template' id='$templateId'> $template </script>
<script type='text/javascript' charset='utf-8'>$component</script>
");
	}

	protected static function getComponent($class, $config) {
		$componentName = static::getComponentName($class);
		$templateId = static::getTemplateId($class);
		return ("
			Vue.component(
				'$componentName',
				{
					template: '#$templateId'
				}
			);
		");
	}
}
