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

class ComponentEditProjetProposition extends ComponentGenerator {

	protected static $_dependances = [
		"ComponentListSituations" => ["noname" => []],
		"ComponentListProjet" => ["noname" => []],
	];
	protected static $_componentName = "component-edit-projet-proposition";

	private function __construct() { }

	private function __destruct() { }

	// on pourra utiliser config pour redéfinir le component d'edition à utiliser dans un cas ou dans l'autre pour certains component
	protected static function getTemplate($class, $config) {
		$componentClassName = static::getClassName($class);
		$componentName = get_called_class();

		$rt = " <div class='$componentClassName $componentName component' style='margin-bottom: 120px;'>";
		if (SHOW_FRAME)
			$rt .= "<span class='debugMsg'>$componentClassName</span>";


		$rt .= "
			<div>
				<table class='tableSimulation'>
					<thead>
						<tr>
							<th>id</th>
							<th>Nom</th>
							<th>Type</th>
							<th>Catégorie</th>
							<th>Stratégie de la SCPI</th>
							<th>Conseils de MeilleureSCPI.com</th>
							<th>Proposition d'investissement</th>
						</tr>
					</thead>
					<tbody>
						<tr v-for='trans in lstTransaction'>
							<td>
								{{ trans.id.value }}
							</td>
							<td>
								{{ getScpi(trans).name.replace('SCPI ', '') }}
								(<span v-if='getScpi(trans).TypeCapital == \"fixe\"'>CF</span><span v-else>CV</span>)

							</td>
							<td>
								{{ getScpi(trans).typeStr }}
							</td>
							<td>
								{{ getScpi(trans).category_id }}
							</td>
							<td>
								<span v-if='typeof trans.expand == \"undefined\"' >{{ getScpi(trans).strategie.substring(0, 200) }}</span>
								<span v-else >{{ getScpi(trans).strategie }}</span>
								<span @click='expandTrans(trans)' class='expandable' v-if='getScpi(trans).strategie.length > 200 && typeof trans.expand == \"undefined\"'>...</span>
							</td>
							<td>
								{{ trans.strategie }}
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

		return ("
			Vue.component(
				'$componentName',
				{
					data: function() {
						return ({ });
					},
					props: [ 'data' ],
					methods: {
						expandTrans: function(trans) {
							Vue.set(trans, 'expand', true);
							console.log(trans);
						},
						getScpi: function(elm) {
								return (this.\$store.getters.getScpi(elm.id_scpi.value));
						},
					},
					computed: {
						lstTransaction: function() {
							return (this.\$store.getters.getAllTransaction2);
						},
						selectedProjet: function() {
							return (this.\$store.getters.getSelectedProjet2);
						},
					},
					template: '#$templateId'
				}
			);
		");
	}
}
