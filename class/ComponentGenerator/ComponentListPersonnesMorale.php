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

class ComponentListPersonnesMorale extends ComponentGenerator {

	protected static $_dependances = [
		"ComponentEditPersonnesMorale" => ["noname" => []],
	];
	protected static $_componentName = "component-list-personnes-morale";

	private function __construct() { }

	private function __destruct() { }

	// on pourra utiliser config pour redéfinir le component d'edition à utiliser dans un cas ou dans l'autre pour certains component
	protected static function getTemplate($class, $config) {
		$componentClassName = static::getClassName($class);
		$componentName = get_called_class();

		$rt = " <div class='$componentClassName $componentName component'>";
		if (SHOW_FRAME)
			$rt .= "<span class='debugMsg'>$componentClassName</span>";

			$rt .= "
			<div class='moduleContent' style='flex-direction: column;justify-content: space-around;'>
				<button 
					class='btn-mscpi btn-orange'
					style='margin-left:auto;margin-right:auto;display:block;'
					@click='newPersonneMorale'
				>
					INSÉRER UNE PERSONNE MORALE
				</button>
				<table class='tableLstPersonnePhysique'>
					<thead>
						<tr>
							<th>Dénomination sociale</th>
						</tr>
					</thead>
					<tbody>
						<tr v-for='pm in data' class='canClick' @click='setPersonneMorale(pm)'>
							<td>
								{{ pm.dn_sociale.value }}
							</td>
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
						newPersonneMorale: function(elm) {
							if (this.\$store.getters.getSelectedPersonneMorale.id.value != 0)
								this.\$store.commit('set_new_PersonneMorale');
							this.\$store.commit('modal_stack_push', {
								tag: 'component-edit-personnes-morale-noname'
							});
						},
						setPersonneMorale: function(elm) {
							this.\$store.commit('set_selected_PersonneMorale', elm);
							this.\$store.commit('modal_stack_push', {
								tag: 'component-edit-personnes-morale-noname'
							});
						}
					},
					template: '#$templateId'
				}
			);
		");
	}
}
