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


class ComponentTable2EditTable extends ComponentGenerator {

	protected static $_dependances = [
		"ComponentTypeEdit" => ["TypeUint" => []]
	];
	protected static $_componentName = "component-table2-edit-table";

	private function __construct() { }

	private function __destruct() {}

	// on pourra utiliser config pour redéfinir le component d'edition à utiliser dans un cas ou dans l'autre pour certains component
	protected static function getTemplate($class, $config) {
		$componentClassName = static::getClassName($class);
		$componentName = get_called_class();


		$rt = "<table class='$componentClassName $componentName component'>";
		if (SHOW_FRAME)
			$rt .= "<div class='debugMsg'>$componentClassName</div>";
		foreach ($class::getDataAccess() as $col => $access)
		{
			;
			$rt .= "
				<tr>
					<th>$col</th>
					<td>{$class::getComponentConfigured($col)}</td>
				</tr>
			";
		}
		$rt .= " <tr><td style='text-align:right'> <button @click='save()'>Enregistrer</button> </td> ";
		$rt .= " <td> <button @click='set_new()'>Nouveau</button> </td></tr> ";
		$rt .= "</table>";
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
