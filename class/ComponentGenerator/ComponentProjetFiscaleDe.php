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

class ComponentProjetFiscaleDe extends ComponentGenerator {

	protected static $_dependances = [
		"ComponentInputCheckboxMscpi" => ["noname" => []]
	];
	protected static $_componentName = "component-projet-fiscalede";

	private function __construct() { }

	private function __destruct() {}

	// on pourra utiliser config pour redéfinir le component d'edition à utiliser dans un cas ou dans l'autre pour certains component
	protected static function getTemplate($class, $config) {
		$componentClassName = static::getClassName($class);
		$componentName = static::getComponentName($class);

		$rt = " <div class='$componentClassName $componentName component'>";
		if (SHOW_FRAME)
			$rt .= "<span class='debugMsg'>$componentClassName</span>";

		$pays_residence_fiscale = SituationPhysique::getComponentConfigured('pays_residence_fiscale');

		$en_france = ComponentTypeBool2btnEdit::getHtmlTag("TypeBool", [':data' => "en_france"]);

		$rt .= "
			<component-project-mini-progress-bar-noname position='1' size='3'> </component-project-mini-progress-bar-noname>
			<div class='form_inline'>
				Choisissez votre résidence fiscale $pays_residence_fiscale.
			</div>
		";
		/*
		$rt .= "
			<div class='simpleForm'>
				<div>
					<span>
						Êtes-vous résident fiscal en France ?
					</span>
					$en_france
				</div>
				<div v-if='en_france.value === false'>
					<span>
						Précisez le pays
					</span>
					$pays_residence_fiscale
				</div>
			</div>
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
					data: function () {
						return ({
							en_france: { value: -1, canSet: true }
						});
					},
					computed: {
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
							if (this.en_france.value === true)
								return (true);
							if (this.selectedSituation.pays_residence_fiscale.value == null)
								return (false);
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
							this.\$store.dispatch('projet2PreviousStep', {
								situation: this.selectedSituation,
								en_france: this.en_france
							});
						},
						next: function(dat) {
							this.\$store.dispatch('projet2NextStep', {
								situation: this.selectedSituation,
								en_france: this.en_france
							});
						},
						set: function(dat) {
							this.\$store.dispatch('projet2SetBlock', {
								situation: this.selectedSituation,
								en_france: this.en_france
							});
						}
					},
					mounted: function() {
						console.log()
						if (this.selectedSituation.pays_residence_fiscale.value === 'France')
							this.en_france.value = true;
						else if (this.selectedSituation.pays_residence_fiscale.value == null)
							this.en_france.value = -1;
						else
							this.en_france.value = false;
						this.\$parent.masquer = false;
					},
					template: '#$templateId',
					created: function() {
						this.\$parent.\$emit('isValid', true);
						this.\$on('set', this.set);
						this.\$on('next', this.next);
						this.\$on('previous', this.previous);
						this.\$parent.masquer = false;
					}
				}
			);
		");
	}

}
