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

class ComponentListPersonnesPhysiques extends ComponentGenerator {

	protected static $_dependances = [
		"ComponentEditPersonnesPhysiques" => ["noname" => []],
	];
	protected static $_componentName = "component-list-personnes-physiques";

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
					@click='newPersonnePhysique'
				>
						INSÉRER UNE PERSONNE PHYSIQUE
				</button>
				<table class='tableLstPersonnePhysique'>
					<thead>
						<tr>
							<th>Civilite</th>
							<th>Nom</th>
							<th>Prénom</th>
						</tr>
					</thead>
					<tbody>
						<tr v-for='pp in data' class='canClick' @click='setPersonnePhysique(pp)'>
							<td>
								<img src='assets/Gender_Homme.png' v-if='pp.civilite.value == \"Monsieur\"' style='width: 28px; margin-right:10px'/>
								<img src='assets/Gender_Femme.png' v-else style='width: 28px; margin-right:10px'/>
								{{ pp.civilite.value }}
							</td>
							<td>{{ pp.nom.value }}</td>
							<td>{{ pp.prenom.value }}</td>
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
						newPersonnePhysique: function(elm) {
							if (this.\$store.getters.getSelectedPersonnePhysique.id.value != 0)
								this.\$store.commit('set_new_PersonnePhysique');
							this.\$store.commit('modal_stack_push', {
								tag: 'component-edit-personnes-physiques-noname'
							});
						},
						setPersonnePhysique: function(elm) {
							this.\$store.commit('set_selected_PersonnePhysique', elm);
							this.\$store.commit('modal_stack_push', {
								tag: 'component-edit-personnes-physiques-noname'
							});
						}
					},
					template: '#$templateId'
				}
			);
		");
	}
}
