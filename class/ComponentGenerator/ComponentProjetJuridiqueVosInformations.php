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

class ComponentProjetJuridiqueVosInformations extends ComponentGenerator {

	protected static $_dependances = [
		"ComponentInputCheckboxMscpi" => ["noname" => []]
	];
	protected static $_componentName = "component-projet-juridiquevosinformations";

	private function __construct() { }

	private function __destruct() {}

	protected static function getTemplate($class, $config) {
		$componentClassName = static::getClassName($class);
		$componentName = static::getComponentName($class);

		$rt = " <div class='$componentClassName $componentName component'>";
		if (SHOW_FRAME)
			$rt .= "<span class='debugMsg'>$componentClassName</span>";

		$etat_civil = SituationPhysique::getEditComponentConfigured('etat_civil', ['class' => 'select_inline']);
		$regime_matrimonial = SituationPhysique::getEditComponentConfigured('regime_matrimonial');

		$a_des_enfants = SituationPhysique::getEditComponentConfigured('a_des_enfants', ['style' => 'max-width: 60px;']);
		$enfants_a_charge = SituationPhysique::getEditComponentConfigured('enfants_a_charge', ['style' => 'max-width: 60px;']);
		$nbr_enfants = SituationPhysique::getEditComponentConfigured('nbr_enfants', ['style' => 'max-width: 60px;']);

		//$autre_personne = ComponentTypeBool2btnEdit::getHtmlTag("TypeBool", [':data' => "autre_personne"]);

		$autre_personne_charge = SituationPhysique::getEditComponentConfigured('autre_personne_charge', ['style' => 'max-width: 60px;']);

		$rt .= "
			<component-project-mini-progress-bar-noname position='1'  :size='getSize'> </component-project-mini-progress-bar-noname>
			<div class='form_inline'>
				Je suis $etat_civil<span
					v-if='selectedSituation.etat_civil.value == 1 || selectedSituation.etat_civil.value == 2'>sous $regime_matrimonial</span>.
				<br />
				et j’ai $nbr_enfants enfant{{ (selectedPp.nbr_enfants.value > 1) ? 's' : '' }}<span v-if='selectedPp.nbr_enfants.value >= 1'> dont $enfants_a_charge à ma charge</span>.<br />
				J’ai $autre_personne_charge autre{{ (selectedPp.autre_personne_charge.value > 1) ? 's' : '' }} personne{{ (selectedPp.autre_personne_charge.value > 1) ? 's' : '' }} à charge.
			</div>
		";
		/*

		$etat_civil = SituationPhysique::getEditComponentConfigured('etat_civil');
		$regime_matrimonial = SituationPhysique::getEditComponentConfigured('regime_matrimonial');
		$a_des_enfants = SituationPhysique::getEditComponentConfigured('a_des_enfants');
		$enfants_a_charge = SituationPhysique::getEditComponentConfigured('enfants_a_charge');
		$nbr_enfants = SituationPhysique::getEditComponentConfigured('nbr_enfants');

		$autre_personne = ComponentTypeBool2btnEdit::getHtmlTag("TypeBool", [':data' => "autre_personne"]);

		$autre_personne_charge = SituationPhysique::getEditComponentConfigured('autre_personne_charge');

		$rt .= "
			<div class='simpleForm'>
				<div>
					<span>
						Etat civil
					</span>
					$etat_civil
				</div>
				<div v-if='selectedSituation.etat_civil.value == 1 || selectedSituation.etat_civil.value == 2'>
					<span>
						Régime matrimonial
					</span>
					$regime_matrimonial
				</div>
				<div>
					<span>
						Avez-vous des enfants ?
					</span>
					$a_des_enfants
				</div>
				<div v-if='selectedSituation.a_des_enfants.value'>
					<span>
						Combien d'enfants avez vous ?
					</span>
					$nbr_enfants
				</div>
				<div v-if='selectedSituation.a_des_enfants.value'>
					<span>
						Combien à charge ?
					</span>
					$enfants_a_charge
				</div>
				<div>
					<span>
						Avez-vous d'autres personnes à charge ?
					</span>
					$autre_personne
				</div>
				<div v-if='autre_personne.value === true'>
					<span>
						Combien d'autre personnes sont à votre charge ?
					</span>
					$autre_personne_charge
				</div>
			</div>
		";
		*/
		//$rt .= "{{ selectedPp }}";
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
							autre_personne: { value: -1, canSet: true }
						});
					},
					computed: {
						listPersonnePhysique: function() {
							return (this.\$store.getters.getPersonnesPhysiqueForProjet2);
						},
						getSize: function() {
							if (this.listPersonnePhysique == null)
								return (2);
							if (this.listPersonnePhysique.length > 1)
								return (3);
							return (2);
						},
						selectedSituation: function() {
							return (this.\$store.getters.getSelectedSituationPhysique);
						},
						selectedProjet: function() {
							return (this.\$store.getters.getSelectedProjet2);
						},
						storeDatas: function() {
							return (this.\$store.state.mscpi.modules.StoreModuleProcessProjet.Blocks.ProjetAccompagnementInvestissement);
						},
						selectedPp: function() {
							return (this.\$store.getters.getSelectedSituationPhysique);
						},
						isValid: function() {
							if (
								this.selectedSituation.a_des_enfants.value == true &&
								(
									this.selectedSituation.enfants_a_charge.value < 0 ||
									this.selectedSituation.nbr_enfants.value < 1
								)
							)
								return (false);

							if (this.selectedSituation.enfants_a_charge.value > this.selectedSituation.nbr_enfants.value) {
								this.selectedSituation.enfants_a_charge.error = 'veuillez insérer une valeur inférieure à ' + this.selectedSituation.nbr_enfants;
								return (false);
							} else {
								this.selectedSituation.enfants_a_charge.error = undefined;
							}
							if (this.selectedSituation.etat_civil.value == null)
								return (false);
							if (this.selectedSituation.etat_civil.value != 3 && this.selectedSituation.regime_matrimonial.value == null)
								return (false);
							return (true);
						},
						forShowNbrEnfants: function() {
							return (this.selectedPp.nbr_enfants.value);
						},
					},
					watch: {
						forShowNbrEnfants: function(elm) {
							this.selectedPp.a_des_enfants.value = elm >= 1;
						},
						isValid: function(val) {
							this.\$parent.\$emit('isValid', val);
						},
						selectedSituation: function() {
							this.resetData();
						},
					},
					methods: {
						previous: function(dat) {
							this.\$store.dispatch('projet2PreviousStep', this.autre_personne);
						},
						next: function(dat) {
							this.\$store.dispatch('projet2NextStep', this.autre_personne);
						},
						set: function(dat) {
							this.\$store.dispatch('projet2SetBlock', this.autre_personne);
						},
						resetData: function() {
							if (this.selectedSituation.autre_personne_charge.value === null)
								this.autre_personne.value = -1;
							else if (this.selectedSituation.autre_personne_charge.value === 0)
								this.autre_personne.value = false;
							else
								this.autre_personne.value = true;
						}
					},
					template: '#$templateId',
					created: function() {
						this.\$parent.\$emit('isValid', this.isValid);
						this.\$on('set', this.set);
						this.\$on('next', this.next);
						this.\$on('previous', this.previous);

					},
					mounted: function() {
						this.resetData();
						this.\$parent.\$emit('isValid', this.isValid);
						this.selectedPp.a_des_enfants.value = this.selectedPp.nbr_enfants.value >= 1;
					}
				}
			);
		");
	}

}
