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

class ComponentProjetPatrimoineRepartition extends ComponentGenerator {

	protected static $_dependances = [
		"ComponentInputCheckboxMscpi" => ["noname" => []]
	];
	protected static $_componentName = "component-projet-patrimoinerepartition";

	private function __construct() { }

	private function __destruct() {}

	// on pourra utiliser config pour redéfinir le component d'edition à utiliser dans un cas ou dans l'autre pour certains component
	protected static function getTemplate($class, $config) {
		$componentClassName = static::getClassName($class);
		$componentName = get_called_class();

		$rt = " <div class='$componentClassName $componentName component'>";
		if (SHOW_FRAME)
			$rt .= "<span class='debugMsg'>$componentClassName</span>";

		$patrimoine_residence_principale	= SituationPhysique::getComponentConfigured('patrimoine_residence_principale');
		$patrimoine_assurance_vie			= SituationPhysique::getComponentConfigured('patrimoine_assurance_vie');
		$patrimoine_pea_compte_titre		= SituationPhysique::getComponentConfigured('patrimoine_pea_compte_titre');
		$patrimoine_pel_cel_codevi_livret	= SituationPhysique::getComponentConfigured('patrimoine_pel_cel_codevi_livret');
		$patrimoine_residence_secondaire	= SituationPhysique::getComponentConfigured('patrimoine_residence_secondaire');
		$patrimoine_immobilier_locatif		= SituationPhysique::getComponentConfigured('patrimoine_immobilier_locatif');
		$patrimoine_scpi					= SituationPhysique::getComponentConfigured('patrimoine_scpi');

		$patrimoine_epargne_retraite		= SituationPhysique::getComponentConfigured('patrimoine_epargne_retraite');

		$patrimoine_autres					= SituationPhysique::getComponentConfigured('patrimoine_autres');

		$rt .= "
			<component-project-mini-progress-bar-noname position='2' size='3'> </component-project-mini-progress-bar-noname>
			<div class='form_inline'>
				Pourriez-vous renseigner votre patrimoine ?
			</div>

			<div class='tableSituation' style='max-width:600px; margin-left:auto; margin-right:auto;'>
				<div class='table'>
					<div>
						<span style='flex:3;'>Résidence principale</span>
						<div style='flex:2'>$patrimoine_residence_principale</div>
						<div> </div>
					</div>
					<div>
						<span style='flex:3;'>Assurance-vie</span>
						<div style='flex:2'>$patrimoine_assurance_vie</div>
						<div> </div>
					</div>
					<div>
						<span style='flex:3;'>PEA / Compte titre</span>
						<div style='flex:2'>$patrimoine_pea_compte_titre</div>
						<div> </div>
					</div>
					<div>
						<span style='flex:3;'>Liquidités (Livrets, PEL, CEL, Compte à terme, LDD, compte courant)</span>
						<div style='flex:2'>$patrimoine_pel_cel_codevi_livret</div>
						<div> </div>
					</div>
					<div>
						<span style='flex:3;'>Résidence secondaire</span>
						<div style='flex:2'>$patrimoine_residence_secondaire</div>
						<div> </div>
					</div>
					<div>
						<span style='flex:3;'>Immobilier locatif</span>
						<div style='flex:2'>$patrimoine_immobilier_locatif</div>
						<div> </div>
					</div>
					<div>
						<span style='flex:3;'>Epargne retraite (PEE / PERCO...)</span>
						<div style='flex:2'>$patrimoine_epargne_retraite</div>
						<div> </div>
					</div>
					<div>
						<span style='flex:3;'>SCPI</span>
						<div style='flex:2'>$patrimoine_scpi</div>
						<div> </div>
					</div>
					<div>
						<span style='flex:3;'>Autres</span>
						<div style='flex:2'>$patrimoine_autres</div>
						<div> </div>
					</div>
					<div >
						<span style='color:#1781e0;flex:3;' >Total</span>
						<div style='flex:2;'>
							<input style='color:#1781e0; border-color:#1781e0;' type='text' :value='getTotal + \" €\"' disabled/>
						</div>
						<div> </div>
					</div>
				</div>
			</div>
		";
/*
		$rt .= "
			<div class='tableSituation'>
				<div class='table'>
					<table>
						<thead>
							<tr>
								<th>Type de patrimoine	</th>
								<th>Répartition en €</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>Résidence principale</td>
								<td>$patrimoine_residence_principale</td>
							</tr>
							<tr>
								<td>Assurance-vie</td>
								<td>$patrimoine_assurance_vie</td>
							</tr>
							<tr>
								<td>PEA / Compte titre / PEE / PERCO</td>
								<td>$patrimoine_pea_compte_titre</td>
							</tr>
							<tr>
								<td>PEL / CEL / CODEVI / Livret</td>
								<td>$patrimoine_pel_cel_codevi_livret</td>
							</tr>
							<tr>
								<td>Résidence secondaire</td>
								<td>$patrimoine_residence_secondaire</td>
							</tr>
							<tr>
								<td>Immobilier locatif</td>
								<td>$patrimoine_immobilier_locatif</td>
							</tr>
							<tr>
								<td>SCPI</td>
								<td>$patrimoine_scpi</td>
							</tr>
							<tr>
								<td>Autres</td>
								<td>$patrimoine_autres</td>
							</tr>
							<tr class='total'>
								<td>Total</td>
								<td style='text-align:right;'>{{ getTotal }} €</td>
							</tr>
						</tbody>
					</table>
				</div>
				<div class='graph'>
					<component-pie-chart-noname style='padding:65px;width:100%;height:100%;' :data='dataChart'> </component-pie-chart-noname>
				</div>
			</div>
		";
		*/
		/*
		$rt .= "
			$estimation_patrimoine_global
		";
		*/
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
					computed: {
						dataChart: function() {
							var rt = {
								datasets: [{data: [], backgroundColor: []}], labels: []
							};
							var tmp = [
								'patrimoine_residence_principale',
								'patrimoine_assurance_vie',
								'patrimoine_pea_compte_titre',
								'patrimoine_pel_cel_codevi_livret',
								'patrimoine_residence_secondaire',
								'patrimoine_immobilier_locatif',
								'patrimoine_scpi',
								'patrimoine_autres'
							];
							var labels = [
								'Résidence principale',
								'Assurance-vie',
								'PEA / Compte titre / PEE / PERCO',
								'PEL / CEL / CODEVI / Livret',
								'Résidence secondaire',
								'Immobilier locatif',
								'SCPI',
								'Autres'
							];
							var colors = [
								'#086ab3',
								'#0b87e4',
								'#2c9ff5',
								'#5db5f8'
							]
							var temoin = 0;
							for (key in tmp) {
								var dt = parseInt(this.selectedSituation[tmp[key]].value);
								if (!isNaN(dt) && dt >= 0) {
									rt.datasets[0].data.push(dt);
									rt.labels.push(labels[key]);
									rt.datasets[0].backgroundColor.push(colors[temoin % 4]);
									temoin++;
								}
							}
							return (rt);
						},
						getTotal: function() {
							var rt = 0;
							var tmp = [
								'patrimoine_residence_principale',
								'patrimoine_assurance_vie',
								'patrimoine_pea_compte_titre',
								'patrimoine_pel_cel_codevi_livret',
								'patrimoine_residence_secondaire',
								'patrimoine_immobilier_locatif',
								'patrimoine_scpi',
								'patrimoine_autres'
							];
							for (key in tmp) {
								var dt = parseInt(this.selectedSituation[tmp[key]].value);
								if (!isNaN(dt) && dt >= 0) {
									rt += dt;
								}
							}
							return (rt);
						},
						selectedPp: function() {
							return (this.\$store.getters.getSelectedPersonnePhysique);
						},
						selectedSituation: function() {
							return (this.\$store.getters.getSelectedSituationPhysique);
						},
						selectedProjet: function() {
							return (this.\$store.getters.getSelectedProjet2);
						},
						storeDatas: function() {
							return (this.\$store.state.mscpi.modules.StoreModuleProcessProjet.Blocks.ProjetJuridiquePersonnePhysique1);
						},
						isValid: function() {
							var tmp = [
								'patrimoine_residence_principale',
								'patrimoine_assurance_vie',
								'patrimoine_pea_compte_titre',
								'patrimoine_pel_cel_codevi_livret',
								'patrimoine_residence_secondaire',
								'patrimoine_immobilier_locatif',
								'patrimoine_scpi',
								'patrimoine_autres'
							];
							for (key in tmp) {
								var dt = parseInt(this.selectedSituation[tmp[key]].value);
								if (isNaN(dt) || dt < 0) {
									return (false);
								}
							}
							return (true);
						},
					},
					watch: {
						isValid: function(val) {
							this.\$parent.\$emit('isValid', val);
						},
					},
					methods: {
						previous: function(dat) {
							this.\$store.dispatch('projet2PreviousStep', this.selectedSituation);
						},
						next: function(dat) {
							this.\$store.dispatch('projet2NextStep', this.selectedSituation);
						},
						set: function(dat) {
							this.\$store.dispatch('projet2SetBlock', this.selectedSituation);
						}
					},
					template: '#$templateId',
					created: function() {
						this.\$parent.\$emit('isValid', true);
						this.\$on('set', this.set);
						this.\$on('next', this.next);
						this.\$on('previous', this.previous);
						this.\$parent.\$emit('isValid', this.isValid);
						this.\$parent.masquer = false;
					},
					mounted: function() {
						this.\$parent.masquer = false;
					}
				}
			);
		");
	}

}
