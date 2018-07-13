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


class ComponentTable2ShowUlli extends ComponentGenerator {

	protected static $_dependances = [
		"ComponentTypeShow" => ["TypeUint" => []]
	];
	protected static $_componentName = "component-table2-show-ulli";

	private function __construct() { }

	private function __destruct() {}

	// on pourra utiliser config pour redéfinir le component d'edition à utiliser dans un cas ou dans l'autre pour certains component
	protected static function getTemplate($class, $config) {
		$componentClassName = static::getClassName($class);

		$rt = "<ul class='$componentClassName component'>";
		if (SHOW_FRAME)
			$rt .= "<div class='debugMsg'>$componentClassName</div>";
		foreach ($class::getDataTypes() as $col => $colConfig)
		{
			if (isset($colConfig['notShow']) && $colConfig['notShow'] === true)
				continue ;
			$rt .= "<li class='$col-class' :class='{canEdit: data.$col.canSet}'>$col : ";
			//$rt .=  ComponentTypeShow::getHtmlTag("TypeUint", [':data' => "data.$col"]);

			if (isset($config[$col]["showComponent"]))
				$rt .= $config[$col]["showComponent"]::getHtmlTag($colConfig["type"], [':data' => "data.$col"]);
			else
				$rt .= $class::getShowComponent($col)::getHtmlTag($colConfig["type"], [':data' => "data.$col"]);

			$rt .= "</li>";
			// On va vérifier si $config souhaite redéfinir manuellement le component à utiliser.
		}
		$rt .= "</ul>";
		return ($rt);
	}

	protected static function getComponent($class, $config) {
		$componentName = static::getComponentName($class);
		$templateId = static::getTemplateId($class);
		return ("
			Vue.component(
				'$componentName',
				{
					data: function() {
						return({});
					},
					props: [ 'data' ],
					template: '#$templateId'
				}
			);
		");
	}
}
