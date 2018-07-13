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

class ComponentProjetChoixBeneficiaire extends ComponentGenerator {

	protected static $_dependances = [
		"ComponentInputCheckboxMscpi" => ["noname" => []],
		"ComponentTooltips" => ["noname" => []],
		"ComponentSetProjetPersonnePhysique" => ["noname" => []],
		"ComponentProjectMiniProgressBar" => ["noname" => []],
		"ComponentTypeEurosEdit" => ["TypeEuros" => []],
	];
	protected static $_componentName = "component-projet-choixbeneficiaire";

	private function __construct() { } 
	private function __destruct() {}

	// on pourra utiliser config pour redéfinir le component d'edition à utiliser dans un cas ou dans l'autre pour certains component
	protected static function getTemplate($class, $config) {
		$componentClassName = static::getClassName($class);
		$componentName = get_called_class();

		$rt = " <div class='$componentClassName $componentName component'>";
		if (SHOW_FRAME)
			$rt .= "<span class='debugMsg'>$componentClassName</span>";

		//$rt .= "{{ getToSend }}";

		//$montant = ComponentTypeEurosEdit::getHtmlTag('TypeEuros', [':data', 'storeDatas.montant']);
		$rt .= "
			<component-project-mini-progress-bar-noname position='1' size='6'> </component-project-mini-progress-bar-noname>
			<div class='form_inline'>
				Je souhaite investir pour 
				<select class='select_inline' v-model='storeDatas.selectedBox'>
					<option value='0'>moi seul</option>
					<option value='1'>mon conjoint et moi-même</option>
					<option value='2'>mon conjoint</option>
					<option value='3'>un de mes parents</option>
					<option value='4'>un de mes enfants</option>
				</select>
				un montant de 
				<component-type-euros-edit-typeeuros :tooltips='getMontantTooltip' tooltipswidth='430px' class='input_inline' style='width:160px;' :data='storeDatas.montant' v-show='true' v-if='true'> </component-type-euros-edit-typeeuros>
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
						return ({
							enableError: false
						});
					},
					methods: {
					},
					computed: {
						storeDatas: function() {
							return (this.\$store.state.mscpi.modules.StoreModuleProcessProjet.Blocks.ProjetChoixBeneficiaire);
						},
						getBeneficiairesCoupleForPersonnePhysique: function() {
							return (function(PersonnePhysique) {
								var beneficiaires = this.\$store.getters.getPersonnePhysique_beneficiaires(PersonnePhysique.id.value);
								return (beneficiaires.filter(function(elm) {
									return (elm.type_ben.value == 'couple');
								}));
							})
						},
						getPersonnePhysiqueConjoinForPersonnePhysique: function() {
							var that = this;
							return (function(PersonnePhysique) {
								var beneficiaires = that.getBeneficiairesCoupleForPersonnePhysique(PersonnePhysique);
								if (typeof beneficiaires != 'object' || beneficiaires.length == 0)
									return (null);
								var ConjoinPp = that.\$store.getters.getPersonnePhysiqueById(beneficiaires[0]['PersonnePhysique']['value'][1]);
								return (ConjoinPp);
							})
						},
						getBeneficiairesSeulForPersonnePhysique: function() {
							return (function(PersonnePhysique) {
								var beneficiaires = this.\$store.getters.getPersonnePhysique_beneficiaires(PersonnePhysique.id.value);
								return (beneficiaires.filter(function(elm) {
									return (elm.type_ben.value == 'seul');
								}));
							})
						},
						getPersonnePhysiqueConjoinForPersonnePhysique: function() {
							var that = this;
							return (function(PersonnePhysique) {
								var beneficiaires = that.getBeneficiairesCoupleForPersonnePhysique(PersonnePhysique);
								if (typeof beneficiaires != 'object' || beneficiaires.length == 0)
									return (null);
								var ConjoinPp = that.\$store.getters.getPersonnePhysiqueById(beneficiaires[0]['PersonnePhysique']['value'][1]);
								return (ConjoinPp);
							})
						},
						isValid: function() {
							if (this.storeDatas.montant.value != null && this.storeDatas.montant.value <= 0 && this.enableError)
								this.storeDatas.montant.error = 'Combien voulez vous investir ?';
							return (this.storeDatas.selectedBox >= 0 && this.storeDatas.selectedBox < 5 && this.storeDatas.montant.value > 0);
						},
						getToSend: function() {
							var DonneurDOrdre = this.\$store.getters.getSelectedDonneurDOrdre;
							if (typeof DonneurDOrdre == 'undefined' || DonneurDOrdre.id.value == 0)
								return ('Pas de donneur dordre');

							var PersonnePhysique = this.\$store.getters.getPersonnePhysique_ByDonneurDOrdre_lien_phy(DonneurDOrdre.id.value);

							if (typeof PersonnePhysique == 'undefined')
								return ('Pas de personne physique');

							PersonnePhysique = PersonnePhysique[0];
							if (this.storeDatas.selectedBox == 0)
								return(this.getBeneficiairesSeulForPersonnePhysique(PersonnePhysique));
							else if (this.storeDatas.selectedBox == 1)
								return(this.getBeneficiairesCoupleForPersonnePhysique(PersonnePhysique));
							else if (this.storeDatas.selectedBox == 2) {
								var ppConjoin = this.getPersonnePhysiqueConjoinForPersonnePhysique(PersonnePhysique)
								if (typeof ppConjoin == 'undefined' || ppConjoin == null)
									return (null);
								return(this.getBeneficiairesSeulForPersonnePhysique(ppConjoin));
							}
							return (null);
							return ('rien a afficher');
						},
						getTitle: function() {
							return ('1. VOUS SOUHAITEZ FAIRE L’INVESTISSEMENT POUR...');
						},
						getMontantTooltip: function() {
							return ('Indiquer un montant prévisionnel d\'investissement,<br />il pourra être affiné par la suite.');
						}
					},
					watch: {
						isValid: function(val) {
							this.\$parent.\$emit('isValid', val);
						},
						getTitle: function(val) {
							this.\$parent.title = val;
						}
					},
					methods: {
						previous: function(dat) {
						},
						next: function(dat) {
							this.enableError = true;
							if (this.getToSend != null && this.getToSend.length >= 1)
							{
								this.\$store.dispatch('projet2NextStep', {
									selectedBox: this.storeDatas.selectedBox,
									montant: this.storeDatas.montant,
									beneficiaire: this.getToSend[0]});
							}
							else if (this.storeDatas.selectedBox == 1 || this.storeDatas.selectedBox == 2)
							{
								if (typeof this.getToSend != 'array' || this.getToSend.length == 0 )
									this.\$store.dispatch('set_block', {
										title: 'VOTRE CONJOIN',
										component: 'component-set-projet-personne-physique-noname'
									});
								return ;
							}
							else if (
								this.storeDatas.selectedBox == 3 || this.storeDatas.selectedBox == 4
							)
							{
								if (typeof this.getToSend != 'array' || this.getToSend.length == 0 )
									this.\$store.dispatch('set_block', {
										title: 'BÉNÉFICIAIRE DE CE PROJET',
										component: 'component-set-projet-personne-physique-noname'
									});
								return ;
							}
							else
							{
								var datas = {
									selectedBox: this.storeDatas.selectedBox,
									montant: this.storeDatas.montant,
									PersonnePhysique: this.getToSend
								};
								this.\$store.dispatch('projet2NextStep', datas);
							}
						},
						set: function(dat) {
							this.enableError = true;
							var datas = {
								selectedBox: this.storeDatas.selectedBox,
								PersonnePhysique: this.getToSend
							};
							this.\$store.dispatch('projet2SetBlock', {
								datas: datas,
								name: 'ProjetChoixBeneficiaire'
							});
						},
					},
					template: '#$templateId',
					created: function() {
						this.\$on('set', this.set);
						this.\$on('next', this.next);
						this.\$on('previous', this.previous);
						this.\$parent.title = this.getTitle;
						this.\$parent.masquer = false;
						this.enableError = false;
					},
					mounted: function() {
						this.\$parent.masquer = false;
						this.enableError = false;
					}
				}
			);
		");
	}

}
