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

class ComponentProfilInvestisseurPlacementDetenus extends ComponentGenerator {

	protected static $_dependances = [
		"ComponentInputCheckboxMscpi" => ["noname" => []]
	];
	protected static $_componentName = "component-profil-investisseur-placement-detenus";

	private function __construct() { }

	private function __destruct() {}

	// on pourra utiliser config pour redéfinir le component d'edition à utiliser dans un cas ou dans l'autre pour certains component
	protected static function getTemplate($class, $config) {
		$componentClassName = static::getClassName($class);
		$componentName = static::getComponentName($class);

		$rt = " <div class='$componentClassName $componentName component'>";
		if (SHOW_FRAME)
			$rt .= "<span class='debugMsg'>$componentClassName</span>";


		$dispose_actions			= ProfilInvestisseur2::getEditComponentConfigured('dispose_actions', ['label' => 'Actions']);
		$dispose_fcpi_fip_fcpr		= ProfilInvestisseur2::getEditComponentConfigured('dispose_fcpi_fip_fcpr', ['label' => 'FCPI/FIP/FCPR']);
		$dispose_opcvm				= ProfilInvestisseur2::getEditComponentConfigured('dispose_opcvm', ['label' => 'OPCVM']);
		$dispose_assurance_vie		= ProfilInvestisseur2::getEditComponentConfigured('dispose_assurance_vie', ['label' => 'Assurance vie']);
		$dispose_obligations		= ProfilInvestisseur2::getEditComponentConfigured('dispose_obligations', ['label' => 'Obligations']);
		$dispose_scpi				= ProfilInvestisseur2::getEditComponentConfigured('dispose_scpi', ['label' => 'SCPI']);
		$dispose_opci				= ProfilInvestisseur2::getEditComponentConfigured('dispose_opci', ['label' => 'OPCI']);
		$dispose_liquidite			= ProfilInvestisseur2::getEditComponentConfigured('dispose_liquidite', ['label' => 'Liquidités']);
		$dispose_pea				= ProfilInvestisseur2::getEditComponentConfigured('dispose_pea', ['label' => 'PEA']);
		$dispose_immobilier_direct	= ProfilInvestisseur2::getEditComponentConfigured('dispose_immobilier_direct', ['label' => 'Immobilier direct']);
		$dispose_crowdfunding		= ProfilInvestisseur2::getEditComponentConfigured('dispose_crowdfunding', ['label' => 'Crowdfunding']);

		$rt .= "
			<component-project-mini-progress-bar-noname position='6' size='9'> </component-project-mini-progress-bar-noname>
			<div class='form_inline'>
				Indiquez les placements que vous détenez.
			</div>
			<div class='new_style_container'>
				$dispose_actions
				$dispose_fcpi_fip_fcpr
				$dispose_opcvm
				$dispose_assurance_vie
				$dispose_obligations
				$dispose_scpi
				$dispose_opci
				$dispose_liquidite
				$dispose_pea
				$dispose_immobilier_direct
				$dispose_crowdfunding
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
						selectedProfilInvestisseur: function() {
							return (this.\$store.getters.getSelectedProfilInvestisseur2);
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
							this.\$store.dispatch('projet2PreviousStep', this.selectedProfilInvestisseur);
						},
						next: function(dat) {
							this.\$store.dispatch('projet2NextStep', this.selectedProfilInvestisseur);
						},
						set: function(dat) {
							this.\$store.dispatch('projet2SetBlock', this.selectedProfilInvestisseur);
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
