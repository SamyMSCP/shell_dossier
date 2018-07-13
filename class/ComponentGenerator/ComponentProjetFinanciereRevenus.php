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

class ComponentProjetFinanciereRevenus extends ComponentGenerator {

	protected static $_dependances = [
		"ComponentPieChart" => ["noname" => []],
	];
	protected static $_componentName = "component-projet-financiererevenus";

	private function __construct() { }

	private function __destruct() {}

	// on pourra utiliser config pour redéfinir le component d'edition à utiliser dans un cas ou dans l'autre pour certains component
	protected static function getTemplate($class, $config) {
		$componentClassName = static::getClassName($class);
		$componentName = get_called_class();

		$revenu_salaire				= SituationPhysique::getComponentConfigured('revenu_salaire');
		$revenu_immobilliers		= SituationPhysique::getComponentConfigured('revenu_immobilliers');
		$revenu_mobilliers			= SituationPhysique::getComponentConfigured('revenu_mobilliers');
		$revenu_autres				= SituationPhysique::getComponentConfigured('revenu_autres');
		$revenu_autres_precision	= SituationPhysique::getComponentConfigured('revenu_autres_precision');

		$rt = " <div class='$componentClassName $componentName component'>";
		if (SHOW_FRAME)
			$rt .= "<span class='debugMsg'>$componentClassName</span>";

		$rt .= "
			<component-project-mini-progress-bar-noname position='1' size='3'> </component-project-mini-progress-bar-noname>
			<div class='form_inline'>
				Quels sont vos revenus mensuels nets ({{ getPpNames }}) ?
			</div>
			<div class='tableSituation'>
				<div class='table'>


					<div>
						<span  style='flex:1;'> Revenus (Salaires, retraites, pensions...) </span>
						<div> $revenu_salaire </div>
						<span style='text-align:left;'> soit {{ selectedSituation.revenu_salaire.value * 12 }} € par an</span>
					</div>
					<div>
						<span style='flex:1;'> Revenus immobiliers </span>
						<div> $revenu_immobilliers </div>
						<span style='text-align:left;'> soit {{ selectedSituation.revenu_immobilliers.value * 12 }} € par an</span>
					</div>
					<div>
						<span style='flex:1;'> Revenus mobiliers </span>
						<div> $revenu_mobilliers </div>
						<span style='text-align:left;'> soit {{ selectedSituation.revenu_mobilliers.value * 12 }} € par an</span>
					</div>
					<div>
						<span style='flex:1;'> Autres </span>
						<div> $revenu_autres </div>
						<span style='text-align:left;'> soit {{ selectedSituation.revenu_autres.value * 12 }} € par an</span>
					</div>
					<div v-if='selectedSituation.revenu_autres.value != 0 && !isNaN(parseInt(selectedSituation.revenu_autres.value))'>
						<span style='flex:1;'> Précisez la nature </span>
						<div> $revenu_autres_precision </div>
						<span></span>
					</div>
				</div>
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
							var salaire = parseInt(this.selectedSituation.revenu_salaire.value);
							var immobilliers = parseInt(this.selectedSituation.revenu_immobilliers.value);
							var mobilliers = parseInt(this.selectedSituation.revenu_mobilliers.value);
							var autres = parseInt(this.selectedSituation.revenu_autres.value);
							if (!isNaN(salaire)) {
								rt.datasets[0].data.push(salaire);
								rt.labels.push('Revenus (Salaires, retraites, pensions...)');
								rt.datasets[0].backgroundColor.push('#086ab3');
							}
							if (!isNaN(immobilliers)) {
								rt.datasets[0].data.push(immobilliers);
								rt.labels.push('Revenus immobiliers');
								rt.datasets[0].backgroundColor.push('#0b87e4');
							}
							if (!isNaN(mobilliers)) {
								rt.datasets[0].data.push(mobilliers);
								rt.labels.push('Revenus mobiliers');
								rt.datasets[0].backgroundColor.push('#2c9ff5');
							}
							if (!isNaN(autres)) {
								rt.datasets[0].data.push(autres);
								rt.labels.push('Revenus autres');
								rt.datasets[0].backgroundColor.push('#5db5f8');
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
							var salaire = parseInt(this.selectedSituation.revenu_salaire.value);
							var immobilliers = parseInt(this.selectedSituation.revenu_immobilliers.value);
							var mobilliers = parseInt(this.selectedSituation.revenu_mobilliers.value);
							var autres = parseInt(this.selectedSituation.revenu_autres.value);
							var rt = 0;
							if (!isNaN(salaire) && salaire > 0)
								rt += salaire;
							if (!isNaN(immobilliers) && immobilliers > 0)
								rt += immobilliers;
							if (!isNaN(mobilliers) && mobilliers > 0)
								rt += mobilliers;
							if (!isNaN(autres) && autres > 0)
								rt += autres;
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
							this.\$store.dispatch('projet2PreviousStep', this.selectedSituation );
						},
						next: function(dat) {
							this.\$store.dispatch('projet2NextStep', this.selectedSituation);
						},
						set: function(dat) {
							this.\$store.dispatch('projet2SetBlock', {
								datas: this.selectedSituation,
								name: 'FinanciereRevenus'
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
