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

class ComponentListSituations extends ComponentGenerator {

	protected static $_dependances = [
		"ComponentEditSituation" => ["noname" => []],
	];
	protected static $_componentName = "component-list-situations";

	private function __construct() { }

	private function __destruct() { }

	// on pourra utiliser config pour redéfinir le component d'edition à utiliser dans un cas ou dans l'autre pour certains component
	protected static function getTemplate($class, $config) {
		$componentClassName = static::getClassName($class);
		$componentName = get_called_class();

		$date_creation = SituationPhysique::getComponentConfigured('date_creation', [":data" => 'situation.date_creation']);

		$rt = " <div class='$componentClassName $componentName component'>";
		if (SHOW_FRAME)
			$rt .= "<span class='debugMsg'>$componentClassName</span>";
		$rt .= "
			<div class='moduleContent' style='flex-direction: column;justify-content: space-around;'>
				<table class='tableLstBeneficiaire'>
					<thead>
						<tr>
							<th>Date de Création</th>
						</tr>
					</thead>
					<tbody>
						<tr v-for='situation in data' class='canClick' @click='setSituation(situation)'>
							<td>$date_creation</td>
						</tr>
					</tbody>
				</table>
			</div>
		";
		
		$rt .= "</div> ";
		return ($rt);
	}
	protected static function getComponent($class, $config) {
		$componentName = static::getComponentName($class);
		$templateId = static::getTemplateId($class);

		$id_client = intval($GLOBALS['GET']['client']);
		return ("
			Vue.component(
				'$componentName',
				{
					props: [ 'data' ],
					methods: {
						setSituation: function(elm) {
							this.\$store.commit('set_selected_SituationPhysique', elm);
							this.\$store.commit('modal_stack_push', {
								tag: 'component-edit-situation-noname'
							});
						}
					},
					template: '#$templateId'
				}
			);
		");
	}
}
