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


class ComponentTable2EditDiv extends ComponentGenerator {

	protected static $_dependances = [
		"ComponentTypeEdit" => ["TypeUint" => []]
	];
	protected static $_componentName = "component-table2-edit-ulli";

	private function __construct() { }

	private function __destruct() {}

	// on pourra utiliser config pour redéfinir le component d'edition à utiliser dans un cas ou dans l'autre pour certains component
	protected static function getTemplate($class, $config) {
		$componentClassName = static::getClassName($class);
		$componentName = get_called_class();

		$rt = "<div class='$componentClassName $componentName component'>";
		if (SHOW_FRAME)
			$rt .= "<div class='debugMsg'>$componentClassName</div>";
		foreach ($class::getDataTypes() as $col => $colConfig)
		{
			if (isset($colConfig['notShow']) && $colConfig['notShow'] === true)
				continue ;
			$rt .= "<div v-if='data.selected.$col.canSet' class='$col-class'><div class='mscpi-form-label'>$col</div>";

			// On va vérifier si $config souhaite redéfinir manuellement le component à utidivser.
			if (isset($config[$col]["editComponent"]))
				$rt .= $config[$col]["editComponent"]::getHtmlTag($colConfig["type"], [':data' => "data.selected.$col"]);
			else
				$rt .= $class::getEditComponent($col)::getHtmlTag($colConfig["type"], [':data' => "data.selected.$col"]);

			$rt .= "</div>";
			$rt .= "<div v-else class='$col-class'>$col : ";

			// On va vérifier si $config souhaite redéfinir manuellement le component à utiliser.
			if (isset($config[$col]["showComponent"]))
				$rt .= $config[$col]["showComponent"]::getHtmlTag($colConfig["type"], [':data' => "data.selected.$col"]);
			else
				$rt .= $class::getShowComponent($col)::getHtmlTag($colConfig["type"], [':data' => "data.selected.$col"]);
			$rt .= "</div>";
		}
		$rt .= "</div>";
		return ($rt);
	}

	protected static function getComponent($class, $config) {
		$componentName = static::getComponentName($class);
		$templateId = static::getTemplateId($class);
		return ("
			Vue.component(
				'$componentName',
				{
					methods: {
						save: function() {
							this.\$store.dispatch('write_selected_$class', this.data);
						},
						set_new: function() {
							this.\$store.commit('set_new_$class');
						}
					},
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
