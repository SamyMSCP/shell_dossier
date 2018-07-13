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

class ComponentProjetFiscaleImpot extends ComponentGenerator {

	protected static $_dependances = [
		"ComponentInputCheckboxMscpi" => ["noname" => []]
	];
	protected static $_componentName = "component-projet-fiscaleimpot";

	private function __construct() { }

	private function __destruct() {}

	protected static function getTemplate($class, $config) {
		$componentClassName = static::getClassName($class);
		$componentName = static::getComponentName($class);

		$rt = " <div class='$componentClassName $componentName component'>";
		if (SHOW_FRAME)
			$rt .= "<span class='debugMsg'>$componentClassName</span>";

		//$assujetti_impot_revenu			= SituationPhysique::getComponentConfigured('assujetti_impot_revenu');
		$impot_annee_precedente			= SituationPhysique::getComponentConfigured('impot_annee_precedente', ['style' => 'max-width:150px;']);
		$tranche_marginale_imposition	= SituationPhysique::getComponentConfigured('tranche_marginale_imposition');
		$nombre_parts_fiscales			= SituationPhysique::getComponentConfigured('nombre_parts_fiscales', ['style' => 'max-width:50px;', ':tooltips' => 'getNbrPartWording', 'tooltipswidth' => '450px']);

		$revenu_fiscale_reference		= SituationPhysique::getComponentConfigured('revenu_fiscale_reference', ['style' => 'max-width:120px;']);
		$regime_foncier					= SituationPhysique::getComponentConfigured('regime_foncier');
		$deficit_foncier				= SituationPhysique::getComponentConfigured('deficit_foncier', ['style' => 'max-width:120px;']);

		$rt .= "<component-project-mini-progress-bar-noname position='2' size='3'> </component-project-mini-progress-bar-noname>

			<div class='form_inline'>
				Je   
				<select v-model='selectedSituation.assujetti_impot_revenu.value'>
					<option :value='null'></option>
					<option :value='false'>ne suis pas</option>
					<option :value='true'>suis</option>
				</select>
				assujetti à l'impôt sur le revenu.<br />
				<br />
				<span v-if='selectedSituation.assujetti_impot_revenu.value'>
					Au titre de l’année précédente, mon impôt etait de $impot_annee_precedente
					avec un revenu fiscale de référence de $revenu_fiscale_reference. <br />
					<br />
					Ma tranche marginale d'imposition est de $tranche_marginale_imposition. <br />
					Mon nombre de parts fiscales est de $nombre_parts_fiscales. <br />
					<br />
					<select v-model='haveRevenuFonciers'>
						<option :value='null'></option>
						<option :value='true'>J’ai eu des revenus fonciers</option>
						<option :value='false'>Je n’ai pas eu de revenus fonciers</option>
					</select>.<br />
					<span v-if='haveRevenuFonciers === true'>
						 J’ai déclaré ces revenus au régime $regime_foncier.<br />
						<select v-model='haveDeficitFoncier'>
							<option :value='null'></option>
							<option :value='true'>J’ai un déficit foncier reportable</option>
							<option :value='false'>Je n’ai pas de déficit reportable</option>
						</select><span v-if='haveDeficitFoncier === true'>
							de $deficit_foncier
						</span>.
					</span>
				</span>


	 

			</div>
		";
/*
		$rt .= " <component-project-mini-progress-bar-noname position='2' size='3'> </component-project-mini-progress-bar-noname>
			<div class='form_inline'>
				Je 
				<select v-model='selectedSituation.assujetti_impot_revenu.value'>
					<option :value='null'></option>
					<option :value='false'>ne suis pas</option>
					<option :value='true'>suis</option>
				</select>
				assujetti à l'impôt sur le revenu.<br />

				<span v-if='selectedSituation.assujetti_impot_revenu.value'>
					Au titre de l’année précédente, mon impôt etait de $impot_annee_precedente.<br />
					Ma tranche marginale d'imposition est de $tranche_marginale_imposition.<br />
					Mon nombre de parts fiscales est de $nombre_parts_fiscales.
				</span>
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
					data: function() {
						return ({
							haveRevenuFonciers: null,
							haveDeficitFoncier: null
						});
					},
					computed: {
						getNbrPartWording: function() {
							return (\"Si sous êtes un couple marié ou pacsé soumis à imposition commune, vous avez droit à 2 parts de quotient familial. Vous avez droit à une majoration de parts si vous avez des enfants à charge (mineur ou majeur célibataire) : 1 demi-part pour les 2 premiers enfants à charge et 1 part entière à partir du 3e. En cas d'enfant à charge résidant alternativement au domicile de chacun des parents (en cas de séparation ou de divorce), l'avantage du quotient familial est divisé entre les 2 parents.\");
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
							if (this.selectedSituation.assujetti_impot_revenu.value === false)
								return (true);
							if (this.haveRevenuFonciers === null)
								return (false);
							else if (this.haveRevenuFonciers === true) {
								if (this.selectedSituation.regime_foncier.value !== 1 && this.selectedSituation.regime_foncier.value !== 2)
									return (false);
								else if (this.haveDeficitFoncier === null) {
									return (false);
								}
								else if (this.haveDeficitFoncier === true && this.selectedSituation.deficit_foncier.value <= 0) {
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
						selectedSituation: function() {
							this.setRegime();
						}
					},
					methods: {
						previous: function(dat) {
							this.\$store.dispatch('projet2PreviousStep', this.selectedSituation);
						},
						next: function(dat) {
							if (this.selectedSituation.assujetti_impot_revenu.value === true) {
								if (this.haveRevenuFonciers === false) {
									this.selectedSituation.regime_foncier.value = null;
									this.selectedSituation.deficit_foncier.value = null;
								}
								else if (this.haveRevenuFonciers === true) {
									if (this.selectedSituation.regime_foncier.value !== 1 && this.selectedSituation.regime_foncier.value !== 2)
										return (false);
									if (this.haveDeficitFoncier === false)
										this.selectedSituation.deficit_foncier.value = null;
									else if (this.haveDeficitFoncier === null) {
										return (false);
									}
									else if (this.haveDeficitFoncier === true) {
										if (this.selectedSituation.deficit_foncier.value <= 0)
											return (false);
									}
								}
							}
							else {
								this.selectedSituation.revenu_fiscale_reference.value = null;
								this.selectedSituation.regime_foncier.value = null;
								this.selectedSituation.deficit_foncier.value = null;
							}
							this.\$store.dispatch('projet2NextStep', this.selectedSituation);
						},
						set: function(dat) {
							if (this.selectedSituation.assujetti_impot_revenu.value === true) {
								if (this.haveRevenuFonciers === false) {
									this.selectedSituation.regime_foncier.value = null;
									this.selectedSituation.deficit_foncier.value = null;
								}
								else if (this.haveRevenuFonciers === true) {
									if (this.selectedSituation.regime_foncier.value !== 1 && this.selectedSituation.regime_foncier.value !== 2)
										return (false);
									if (this.haveDeficitFoncier === false)
										this.selectedSituation.deficit_foncier.value = null;
									else if (this.haveDeficitFoncier === null) {
										return (false);
									}
									else if (this.haveDeficitFoncier === true) {
										if (this.selectedSituation.deficit_foncier.value <= 0)
											return (false);
									}
								}
							}
							else {
								this.selectedSituation.revenu_fiscale_reference.value = null;
								this.selectedSituation.regime_foncier.value = null;
								this.selectedSituation.deficit_foncier.value = null;
							}
							this.\$store.dispatch('projet2SetBlock', this.selectedSituation);
						},
						setRegime: function() {
							if (typeof this.selectedSituation != 'undefined') {
								this.haveRevenuFonciers = this.selectedSituation.regime_foncier.value > 0;
								this.haveDeficitFoncier = this.selectedSituation.deficit_foncier.value > 0;
							}
						}
					},
					template: '#$templateId',
					created: function() {
						this.setRegime();
						this.\$parent.\$emit('isValid', this.isValid);
						this.\$on('set', this.set);
						this.\$on('next', this.next);
						this.\$on('previous', this.previous);
						this.\$parent.masquer = false;
					},
					mounted: function() {
						this.setRegime();
						this.\$parent.masquer = false;
					}
				}
			);
		");
	}

}
