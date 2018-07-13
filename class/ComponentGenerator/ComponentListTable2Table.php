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


class ComponentListTable2Table extends ComponentGenerator {

	protected static $_dependances = [
		"ComponentTypeShow" => ["TypeUint" => []]
	];
	protected static $_componentName = "component-list-table2-table";

	private function __construct() { }

	private function __destruct() { }

	// on pourra utiliser config pour redéfinir le component d'edition à utiliser dans un cas ou dans l'autre pour certains component
	protected static function getTemplate($class, $config) {
		$componentClassName = static::getClassName($class);
		$componentName = get_called_class();
		$selected = "";
		if (isset($config['selected']))
			$selected = " :class='{selected: elm.id.value == " . $config['selected'] . ".id.value}' ";

		$rt = "<table class='$componentClassName $componentName component' border='1'><thead><tr>";
		$rt .= "<th style='width: 60px;'>Id</th>";
		foreach ($config['column'] as $column) {
			$rt .= "<th>" . ucfirst($column) . "</th>";
		}
		$rt .= " </tr></thead><tbody><tr v-for='elm in data' @click='setSelected(elm)' $selected>";
		$rt .= "<td style='text-align:right;'>{{ elm.id.value }}</td>";
			foreach ($config['column'] as $column) {
				$colConfig = $class::getDataTypes()[$column];
				$rt .= "<td>";
				if (isset($config[$column]["showComponent"]))
					$rt .= $config[$column]["showComponent"]::getHtmlTag($colConfig["type"], [':data' => "elm.$column"]);
				else
					$rt .= $class::getShowComponent($column)::getHtmlTag($colConfig["type"], [':data' => "elm.$column"]);
				$rt .= "</td>";
			}
		$rt .= "</tr></tbody></table>";
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
					methods: {
						setEdit: function(elm) {
							console.log('setEditLancé');
							this.\$store.commit('set_selected_$class',  elm);
						},
						setSelected: function(elm) {
							this.\$store.commit('set_selected_$class',  elm);
						}
					},
					template: '#$templateId'
				}
			);
		");
	}
}
