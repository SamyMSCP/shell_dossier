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

class ComponentProjetFinanciereCharges extends ComponentGenerator {

	protected static $_dependances = [
		"ComponentInputCheckboxMscpi" => ["noname" => []]
	];
	protected static $_componentName = "component-projet-financierecharges";

	private function __construct() { }

	private function __destruct() {}

	// on pourra utiliser config pour redéfinir le component d'edition à utiliser dans un cas ou dans l'autre pour certains component
	/*
remboursement_mensuel
duree_remboursement_restante

credit_residence_secondaire
credit_residence_secondaire_duree

credit_immobilier_locatif
credit_immobilier_locatif_duree

credit_scpi
credit_scpi_duree

credit_a_la_consommation
credit_a_la_consommation_duree

credit_autres
credit_autres_duree

autres_charges
	*/
	protected static function getTemplate($class, $config) {
		$componentClassName = static::getClassName($class);
		$componentName = get_called_class();

		$remboursement_mensuel				= SituationPhysique::getComponentConfigured('remboursement_mensuel');
		$duree_remboursement_restante		= SituationPhysique::getComponentConfigured('duree_remboursement_restante');
		$loyer								= SituationPhysique::getComponentConfigured('loyer');
		$credit_residence_secondaire		= SituationPhysique::getComponentConfigured('credit_residence_secondaire');
		$credit_residence_secondaire_duree	= SituationPhysique::getComponentConfigured('credit_residence_secondaire_duree');
		$credit_immobilier_locatif			= SituationPhysique::getComponentConfigured('credit_immobilier_locatif');
		$credit_immobilier_locatif_duree	= SituationPhysique::getComponentConfigured('credit_immobilier_locatif_duree');
		$credit_scpi						= SituationPhysique::getComponentConfigured('credit_scpi');
		$credit_scpi_duree					= SituationPhysique::getComponentConfigured('credit_scpi_duree');
		$credit_a_la_consommation			= SituationPhysique::getComponentConfigured('credit_a_la_consommation');
		$credit_a_la_consommation_duree		= SituationPhysique::getComponentConfigured('credit_a_la_consommation_duree');
		$credit_autres						= SituationPhysique::getComponentConfigured('credit_autres');
		$credit_autres_duree				= SituationPhysique::getComponentConfigured('credit_autres_duree');
		$autres_charges						= SituationPhysique::getComponentConfigured('autres_charges');


		//$habitation							= SituationPhysique::getComponentConfigured('habitation');

		$rt = " <div class='$componentClassName $componentName component'>";
		if (SHOW_FRAME)
			$rt .= "<span class='debugMsg'>$componentClassName</span>";

		$rt .= "
			<component-project-mini-progress-bar-noname position='3' size='3'> </component-project-mini-progress-bar-noname>
			<div class='form_inline'>
				Quels sont vos charges mensuelles ({{ getPpNames }}) ?
			</div>
			<div class='tableSituation'>
				<div class='table'>

					<div v-if='selectedSituation.habitation.value == 1'>
						<span style='flex:2'>Crédit résidence principale</span>
						<div>$remboursement_mensuel</div>
						<span style='flex:3'> soit {{ selectedSituation.remboursement_mensuel.value * 12 }} € par an</span>
						<div>$duree_remboursement_restante</div>
						<span></span>
					</div>
					<div v-if='selectedSituation.habitation.value == 2'>
						<span style='flex:2'>Loyer résidence principale</span>
						<div>$loyer</div>
						<span style='flex:3'> soit {{ selectedSituation.loyer.value * 12 }} € par an</span>
						<div></div>
						<span></span>
					</div>
					<div>
						<span style='flex:2'>Crédit résidence secondaire</span>
						<div>$credit_residence_secondaire</div>
						<span style='flex:3'> soit {{ selectedSituation.credit_residence_secondaire.value * 12 }} € par an pour une durée de </span>
						<div>$credit_residence_secondaire_duree</div>
						<span>mois</span>
					</div>
					<div>
						<span style='flex:2'>Crédit immobilier locatif</span>
						<div>$credit_immobilier_locatif</div>
						<span style='flex:3'> soit {{ selectedSituation.credit_immobilier_locatif.value * 12 }} € par an pour une durée de </span>
						<div>$credit_immobilier_locatif_duree</div>
						<span>mois</span>
					</div>
					<div>
						<span style='flex:2'>Crédit SCPI</span>
						<div>$credit_scpi</div>
						<span style='flex:3'> soit {{ selectedSituation.credit_scpi.value * 12 }} € par an pour une durée de </span>
						<div>$credit_scpi_duree</div>
						<span>mois</span>
					</div>
					<div>
						<span style='flex:2'>Crédit à la consommation</span>
						<div>$credit_a_la_consommation</div>
						<span style='flex:3'> soit {{ selectedSituation.credit_a_la_consommation.value * 12 }} € par an pour une durée de </span>
						<div>$credit_a_la_consommation_duree</div>
						<span>mois</span>
					</div>
					<div>
						<span style='flex:2'>Autres credits</span>
						<div>$credit_autres</div>
						<span style='flex:3'> soit {{ selectedSituation.credit_autres.value * 12 }} € par an pour une durée de </span>
						<div>$credit_autres_duree</div>
						<span>mois</span>
					</div>
					<div>
						<span style='flex:2'>Autres charges</span>
						<div>$autres_charges</div>
						<span style='flex:3'> soit {{ selectedSituation.autres_charges.value * 12 }} € par an</span>
						<div></div>
						<span></span>
					</div>
					<div class='total'>
						<span style='color:#1781e0; flex:2'>Total</span>
						<div style='text-align:right;'>
							<input style='color:#1781e0; border-color:#1781e0;' type='text' :value='getTotal + \"  € \"' disabled/>
						</div>
						<span style='color:#1781e0; flex:3'> soit {{ getTotal * 12 }} € par an</span>
						<div></div>
						<span></span>
					</div>
				</div>
			</div>
		";
			/*
		$rt .= "
			<div>
				$habitation
			</div>
			<div class='tableSituation'>
				<div class='table'>
					<table>
						<thead>
							<tr>
								<th>Vos revenus</th>
								<th colspan='2'>Montant de vos charges mensuelles</th>
								<th>Durée restante en mois</th>
							</tr>

							<tr>
								<th></th>
								<th>par mois</th>
								<th>soit par an</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
							<tr v-if='selectedSituation.habitation.value == 1'>
								<td>Crédit résidence principale</td>
								<td>$remboursement_mensuel</td>
								<td>{{ selectedSituation.remboursement_mensuel.value * 12 }} €</td>
								<td>$duree_remboursement_restante</td>
							</tr>
							<tr v-if='selectedSituation.habitation.value == 2'>
								<td>Loyer résidence principale</td>
								<td>$loyer</td>
								<td>{{ selectedSituation.loyer.value * 12 }} €</td>
								<td></td>
							</tr>
							<tr>
								<td>Crédit résidence secondaire</td>
								<td>$credit_residence_secondaire</td>
								<td>{{ selectedSituation.credit_residence_secondaire.value * 12 }} €</td>
								<td>$credit_residence_secondaire_duree</td>
							</tr>
							<tr>
								<td>Crédit immobilier locatif</td>
								<td>$credit_immobilier_locatif</td>
								<td>{{ selectedSituation.credit_immobilier_locatif.value * 12 }} €</td>
								<td>$credit_immobilier_locatif_duree</td>
							</tr>
							<tr>
								<td>Crédit SCPI	</td>
								<td>$credit_scpi</td>
								<td>{{ selectedSituation.credit_scpi.value * 12 }} €</td>
								<td>$credit_scpi_duree</td>
							</tr>
							<tr>
								<td>Crédit à la consommation</td>
								<td>$credit_a_la_consommation</td>
								<td>{{ selectedSituation.credit_a_la_consommation.value * 12 }} €</td>
								<td>$credit_a_la_consommation_duree</td>
							</tr>
							<tr>
								<td>Autres credits</td>
								<td>$credit_autres</td>
								<td>{{ selectedSituation.credit_autres.value * 12 }} €</td>
								<td>$credit_autres_duree</td>
							</tr>
							<tr>
								<td>Autres charges</td>
								<td>$autres_charges</td>
								<td>{{ selectedSituation.autres_charges.value * 12 }} €</td>
								<td></td>
							</tr>
							<tr style='height:15px;'>
								<td colspan='4'></td>
							</tr>
							<tr class='total'>
								<td>Total</td>
								<td style='text-align:right;'>{{ getTotal }} €</td>
								<td>{{ getTotal * 12 }} €</td>
								<td></td>
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
					methods: {
					},
					computed: {
						getPpNames: function() {
							var rt = '';
							var pps = this.\$store.getters.getPersonnesPhysiqueForProjet2
							var temoin = false;
							for (var key in pps) {
								if (temoin)
									rt += ' & ';
								rt += pps[key].shortName.value;
								temoin = true;
							}
							return (rt);
						},
						dataChart: function() {
							var rt = {
								datasets: [{data: [], backgroundColor: []}], labels: []
							};
							var tmp = [
								'loyer',
								'remboursement_mensuel',
								'credit_residence_secondaire',
								'credit_immobilier_locatif',
								'credit_scpi',
								'credit_a_la_consommation',
								'credit_autres',
								'autres_charges'
							];
							var labels = [
								'Loyer résidence principale',
								'Crédit résidence principale',
								'Crédit résidence secondaire',
								'Crédit immobilier locatif',
								'Crédit SCPI',
								'Crédit à la consommation',
								'Autres credits',
								'Autres charges'
							]
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
							var salaire = parseInt(this.selectedSituation.revenu_salaire.value);
							var immobilliers = parseInt(this.selectedSituation.revenu_immobilliers.value);
							var mobilliers = parseInt(this.selectedSituation.revenu_mobilliers.value);
							var autres = parseInt(this.selectedSituation.revenu_autres.value);
							var autres_precision = this.selectedSituation.revenu_autres_precision.value;
							var rt = 0;
							if (isNaN(salaire) || isNaN(immobilliers) || isNaN(mobilliers) || isNaN(autres))
								return (false);
							if (autres > 0 && autres_precision.length < 2)
								return (false);
							return (true);
						},
						getTotal: function() {
							var rt = 0;

							var remboursement_mensuel = parseInt(this.selectedSituation.remboursement_mensuel.value);

							if (!isNaN(remboursement_mensuel) && remboursement_mensuel > 0)
								rt += remboursement_mensuel;

							var loyer = parseInt(this.selectedSituation.loyer.value);

							if (!isNaN(loyer) && loyer > 0)
								rt += loyer;

							var credit_residence_secondaire = parseInt(this.selectedSituation.credit_residence_secondaire.value);
							if (!isNaN(credit_residence_secondaire) && credit_residence_secondaire > 0)
								rt += credit_residence_secondaire;

							var credit_immobilier_locatif = parseInt(this.selectedSituation.credit_immobilier_locatif.value);
							if (!isNaN(credit_immobilier_locatif) && credit_immobilier_locatif > 0)
								rt += credit_immobilier_locatif;
								
							var credit_scpi = parseInt(this.selectedSituation.credit_scpi.value);
							if (!isNaN(credit_scpi) && credit_scpi > 0)
								rt += credit_scpi;

							var credit_a_la_consommation = parseInt(this.selectedSituation.credit_a_la_consommation.value);
							if (!isNaN(credit_a_la_consommation) && credit_a_la_consommation > 0)
								rt += credit_a_la_consommation;

							var credit_autres = parseInt(this.selectedSituation.credit_autres.value);
							if (!isNaN(credit_autres) && credit_autres > 0)
								rt += credit_autres;

							var autres_charges = parseInt(this.selectedSituation.autres_charges.value);
							if (!isNaN(autres_charges) && autres_charges > 0)
								rt += autres_charges;
							return (rt);
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
							this.\$store.dispatch('projet2SetBlock', {
								datas: this.selectedSituation,
								name: 'FinanciereCharges'
							});
						}
					},
					template: '#$templateId',
					created: function() {
						this.\$parent.\$emit('isValid', true);
						this.\$on('set', this.set);
						this.\$on('next', this.next);
						this.\$on('previous', this.previous);
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
