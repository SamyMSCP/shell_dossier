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

		$rt .= "
			<component-project-mini-progress-bar-noname position='1' size='5'> </component-project-mini-progress-bar-noname>
			<div>
				<component-input-checkbox-mscpi-noname v-model='storeDatas.selectedBox' :checker='0' label='Moi seul'></component-input-checkbox-mscpi-noname>
				<component-tooltips-noname title='Moi seul' content=
					\"Dans le cas d'un investissement réalisé</br>
					pour vous (Biens propres)\"
				></component-tooltips-noname>
			</div>

			<div>

				<component-input-checkbox-mscpi-noname   v-model='storeDatas.selectedBox' :checker='1' label='Mon conjoint et moi-même'></component-input-checkbox-mscpi-noname>
				<component-tooltips-noname title='Mon conjoint et moi-même' content=
					\"Dans le cadre d'un investissement réalisé</br>
					pour vous et votre conjoint (Biens communs)\"
				></component-tooltips-noname>
			</div>

			<div>
				<component-input-checkbox-mscpi-noname v-model='storeDatas.selectedBox' :checker='2' label='Mon conjoint'></component-input-checkbox-mscpi-noname>
				<component-tooltips-noname title='Mon conjoint' content=
					\"Dans le cadre d'un investissement réalisé</br>
					pour votre conjoint (Biens propres)\"
				></component-tooltips-noname>
			</div>

			<div>
				<component-input-checkbox-mscpi-noname v-model='storeDatas.selectedBox' :checker='3' label='Un de mes parents'></component-input-checkbox-mscpi-noname>
				<component-tooltips-noname title='Un de mes parents' content=
					\"Dans le cadre d'un investissement réalisé</br>
					pour un de vos parents (Biens propres)\"
				></component-tooltips-noname>
			</div>

			<div>
				<component-input-checkbox-mscpi-noname v-model='storeDatas.selectedBox' :checker='4' label='Un de mes enfants'></component-input-checkbox-mscpi-noname>
				<component-tooltips-noname title='Un de mes enfants' content=
					\"Dans le cadre d'un investissement réalisé</br>
					pour un de vos enfants (Biens propres)\"
				></component-tooltips-noname>
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
							return (this.storeDatas.selectedBox >= 0 && this.storeDatas.selectedBox < 5);
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

							if (this.getToSend != null && this.getToSend.length >= 1)
							{
								this.\$store.dispatch('projet2NextStep', {
									selectedBox: this.storeDatas.selectedBox,
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
									PersonnePhysique: this.getToSend
								};
								this.\$store.dispatch('projet2NextStep', datas);
							}
						},
						set: function(dat) {
							var datas = {
								selectedBox: this.storeDatas.selectedBox,
								PersonnePhysique: this.getToSend
							};
							this.\$store.dispatch('projet2SetBlock', {
								datas: datas,
								name: 'ProjetChoixBeneficiaire'
							});
						}
					},
					template: '#$templateId',
					created: function() {
						this.\$on('set', this.set);
						this.\$on('next', this.next);
						this.\$on('previous', this.previous);
						this.\$parent.title = this.getTitle;
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
