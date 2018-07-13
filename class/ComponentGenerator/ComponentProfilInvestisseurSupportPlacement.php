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

class ComponentProfilInvestisseurSupportPlacement extends ComponentGenerator {

	protected static $_dependances = [
		"ComponentInputCheckboxMscpi" => ["noname" => []]
	];
	protected static $_componentName = "component-profil-investisseur-support-placement";

	private function __construct() { }

	private function __destruct() {}

	// on pourra utiliser config pour redéfinir le component d'edition à utiliser dans un cas ou dans l'autre pour certains component
	protected static function getTemplate($class, $config) {
		$componentClassName = static::getClassName($class);
		$componentName = static::getComponentName($class);

		$rt = " <div class='$componentClassName $componentName component'>";
		if (SHOW_FRAME)
			$rt .= "<span class='debugMsg'>$componentClassName</span>";

		$connaissance_placement_actions			= ProfilInvestisseur2::getEditComponentConfigured('connaissance_placement_actions', ['label' => 'Actions']);
		$connaissance_placement_scpi			= ProfilInvestisseur2::getEditComponentConfigured('connaissance_placement_scpi', ['label' => 'SCPI']);
		$connaissance_placement_assurance_vie	= ProfilInvestisseur2::getEditComponentConfigured('connaissance_placement_assurance_vie', ['label' => 'Assurance vie']);
		$connaissance_placement_opci			= ProfilInvestisseur2::getEditComponentConfigured('connaissance_placement_opci', ['label' => 'OPCI']);
		$connaissance_placement_obligations		= ProfilInvestisseur2::getEditComponentConfigured('connaissance_placement_obligations', ['label' => 'Obligations']);
		$connaissance_placement_fcpi_fip_fcpr	= ProfilInvestisseur2::getEditComponentConfigured('connaissance_placement_fcpi_fip_fcpr', ['label' => 'FCPI / FIP / FCPR']);
		$connaissance_placement_opcvm			= ProfilInvestisseur2::getEditComponentConfigured('connaissance_placement_opcvm', ['label' => 'OPCVM']);
		$connaissance_placement_crowdfunding	= ProfilInvestisseur2::getEditComponentConfigured('connaissance_placement_crowdfunding', ['label' => 'Crowdfunding']);

		$rt .= "
			<component-project-mini-progress-bar-noname position='5' size='9'> </component-project-mini-progress-bar-noname>
			<div class='form_inline'>
				Indiquez les supports de placement pour lesquels vous estimez avoir une connaissance et/ou une expérience suffisante.
			</div>
			<div class='new_style_container'>
				$connaissance_placement_actions
				$connaissance_placement_assurance_vie
				$connaissance_placement_obligations
				$connaissance_placement_opcvm
				$connaissance_placement_scpi
				$connaissance_placement_opci
				$connaissance_placement_fcpi_fip_fcpr
				$connaissance_placement_crowdfunding
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
