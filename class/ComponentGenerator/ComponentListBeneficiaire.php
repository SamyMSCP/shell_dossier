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

class ComponentListBeneficiaire extends ComponentGenerator {

	protected static $_dependances = [
		"ComponentEditBeneficiaire" => ["noname" => []],
		"ComponentCreateBeneficiaire" => ["noname" => []],
	];
	protected static $_componentName = "component-list-beneficiaire";

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
					@click='newBeneficiaire'
				>
					INSÉRER UN BENEFICIAIRE
				</button>
				<table class='tableLstBeneficiaire'>
					<thead>
						<tr>
							<th>Nom</th>
							<th>Type</th>
						</tr>
					</thead>
					<tbody>
						<tr v-for='ben in data' class='canClick' @click='setBeneficiaire(ben)'>
							<td>{{ selectedBeneficiaireShortName(ben) }}</td>
							<td>{{ ben.type_ben.value }}</td>
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
						selectedBeneficiaireShortName: function(ben) {
							if (ben.type_ben.value == 'Pm') {
								var pm =  this.\$store.getters.getBeneficiaire2_PersonneMorale(ben.id.value);
								if (pm === null)
									return ('--not defined--');
								return (pm[0].dn_sociale.value);
							}
							var ppList =  this.\$store.getters.getBeneficiaire2_PersonnePhysique(ben.id.value);
							var rt = '';
							var temoin = false;
							for (var key in ppList) {
								if (temoin)
									rt += ' & ';
								rt += ppList[key].shortName.value;
								temoin = true;
							}
							return (rt);
						},
						newBeneficiaire: function(elm) {
							this.\$store.commit('set_new_Beneficiaire2');
							this.\$store.getters.getSelectedBeneficiaire2.id_dh.value = this.\$store.getters.getSelectedDonneurDOrdre.id.value;
							this.\$store.commit('modal_stack_push', {
								tag: 'component-create-beneficiaire-noname'
							});
						},
						setBeneficiaire: function(elm) {
							this.\$store.commit('set_selected_Beneficiaire2', elm);
							this.\$store.commit('modal_stack_push', {
								tag: 'component-edit-beneficiaire-noname'
							});
						}
					},
					template: '#$templateId'
				}
			);
		");
	}
}
