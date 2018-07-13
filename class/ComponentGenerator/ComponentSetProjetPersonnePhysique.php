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

class ComponentSetProjetPersonnePhysique extends ComponentGenerator {

	protected static $_dependances = [
		"ComponentInputCheckboxMscpi" => ["noname" => []],
		"ComponentTypeEdit" => ["TypeEncryptedName" => []],
		"ComponentTypeCiviliteEdit" => ["TypeEncryptedCivilite" => []]
	];
	protected static $_componentName = "component-set-projet-personne-physique";

	private function __construct() { }

	private function __destruct() {}

	// on pourra utiliser config pour redéfinir le component d'edition à utiliser dans un cas ou dans l'autre pour certains component
	protected static function getTemplate($class, $config) {
		$componentClassName = static::getClassName($class);
		$componentName = static::getComponentName($class);

		$rt = " <div class='$componentClassName $componentName component'>";
		if (SHOW_FRAME)
			$rt .= "<span class='debugMsg'>$componentClassName</span>";

		$civiliteEdit = PersonnePhysique::getEditComponent('civilite')::getHtmlTag('TypeEncryptedCivilite', [':data' => "selectPp.civilite"]);
		$nomEdit = PersonnePhysique::getEditComponent('nom')::getHtmlTag('TypeEncryptedName', [':data' => "selectPp.nom"]);
		$prenomEdit = PersonnePhysique::getEditComponent('prenom')::getHtmlTag('TypeEncryptedName', [':data' => "selectPp.prenom"]);

		$rt .= "
			<div v-show='mode == 0'>
				<p v-if='storeDatas.selectedBox == 1 || storeDatas.selectedBox == 2'>Veuillez choisir qui est votre conjoint dans la liste ci-dessous</p>
				<p v-else>Veuillez choisir qui est le béneficiaire de ce projet dans la liste ci-dessous</p>
				<div v-for='elm in getList'>
					<component-input-checkbox-mscpi-noname @input='setSelected(elm)' :value='selectPp.id.value' :checker='elm.id.value' :label='elm.shortName.value'></component-input-checkbox-mscpi-noname>
				</div>
				<button v-if='storeDatas.selectedBox == 1 || storeDatas.selectedBox == 2' @click='setNewPp()' class='btn-mscpi'>Mon conjoint ne figure pas parmis la liste ci dessus</button>
				<button v-else @click='setNewPp()' class='btn-mscpi'>Le béneficiaire ne figure pas parmis la liste ci dessus</button>
			</div>

			<div v-show='mode == 1' class='simpleForm'>
				<p>Veuillez compléter les informations de votre conjoint</p>
				<div>
					<span>Civilité</span>
					$civiliteEdit
				</div>
				<div>
					<span>Nom</span>
					$nomEdit
				</div>
				<div>
					<span>Prénom</span>
					$prenomEdit
				</div>
				<div>
					<button v-if='getList.length != 0' @click='setMode(0)' class='btn-mscpi'>Revenir à la liste</button>
				</div>
			</div>
		";
		$rt .= "</div> ";
		return ($rt);
	}

	protected static function getComponent($class, $config) {
		$componentName = static::getComponentName($class);
		$templateId = static::getTemplateId($class);

		/*
			mode:
				- 0 Choix dans la liste.
		*/
		return ("
			Vue.component(
				'$componentName',
				{
					data: function() {
						return ({
							mode: 0,
						});
					},
					computed: {
						selectPp: function() {
							return (this.\$store.getters.getSelectedPersonnePhysique);
						},
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
						getList: function () {
							var dh = this.\$store.getters.getSelectedDonneurDOrdre;
							var pps = this.\$store.getters.getPersonnePhysique_lien_dh(dh.id.value);
							var pp = store.getters.getPersonnePhysique_ByDonneurDOrdre_lien_phy(dh.id.value)[0];
							if (pps == null)
								return ([]);
							pp2 = this.getPersonnePhysiqueConjoinForPersonnePhysique(pp);
							if (this.storeDatas.selectedBox == 1 || this.storeDatas.selectedBox == 2) {

								// Récupérer les PP qui ne sont pas des enfants ou des couples
								return (pps.filter(function(elm) {
									if  (elm.id.value == dh.lien_phy.value)
										return (false);
 
									var bens = store.getters.getPersonnePhysique_beneficiaires(elm.id.value);
									if (bens == null)
										return (true);
									for (ben in bens) {
										if (
											bens[ben].type_relation.value == 'parent' ||
											bens[ben].type_relation.value == 'enfant'
										)
											return(false);
									}
									return (true);
								}));

							}
							else if (this.storeDatas.selectedBox == 3 || this.storeDatas.selectedBox == 4) {
								var that = this;
								return (pps.filter(function(elm) {
									if  (elm.id.value == dh.lien_phy.value)
										return (false);
									if (pp2 != null && pp2.id.value == elm.id.value)
										return (false);
									var bens = store.getters.getPersonnePhysique_beneficiaires(elm.id.value);
									if (bens == null)
										return (true);
									for (ben in bens) {
										if (
											(that.storeDatas.selectedBox == 4 && bens[ben].type_relation.value == 'parent') ||
											(that.storeDatas.selectedBox == 3 && bens[ben].type_relation.value == 'enfant')
										)
											return(false);
									}
									return (true);
								}));
							}
						},
						isValid: function() {
							return (
								this.selectPp.nom.value != null &&
								this.selectPp.civilite.value != null && 
								this.selectPp.prenom.value != null &&
								this.selectPp.nom.value.length >= 2 &&
								this.selectPp.civilite.value.length >= 2 && 
								this.selectPp.prenom.value.length >= 2
							);
						},
						getTitle: function() {
							if (this.storeDatas.selectedBox == 1 || this.storeDatas.selectedBox == 2)
								return ('VOTRE CONJOIN');
							else
								return ('BÉNÉFICIAIRE DE CE PROJET');
						}
					},
					watch: {
						isValid: function(val) {
							this.\$parent.\$emit('isValid', val)
						},
						getTitle: function(val) {
							this.\$parent.title = val;
						}
					},
					methods: {
						previous: function(dat) {
						},
						set: function(dat) {
							this.next(dat);
						},
						next: function(dat) {
							var that = this;
							var datas = {
								selectedBox: 10 + Number(this.storeDatas.selectedBox),
								montant: this.storeDatas.montant,
								selectPp: this.selectPp,
								mode: this.mode,
								PersonnePhysique: this.\$store.getters.getSelectedPersonnePhysique
							};
							this.\$store.dispatch('projet2NextStep', datas).then(
								function() {
									that.\$store.commit('modal_stack_pop');
								});
						},
						setNewPp: function() {
							this.\$store.commit('set_new_PersonnePhysique');
							this.selectPp.lien_dh.value = this.\$store.getters.getSelectedDonneurDOrdre.id.value;
							this.mode = 1;
						},
						setMode: function(mode) {
							this.mode = mode;
						},
						setSelected: function(elm) {
							console.log(elm);
							this.\$store.commit('set_selected_PersonnePhysique', elm);
						}
					},
					mounted: function() {
						if (this.getList.length == 0)
							this.mode = 1;
						this.\$store.commit('set_new_PersonnePhysique');
						this.selectPp.lien_dh.value = this.\$store.getters.getSelectedDonneurDOrdre.id.value;
					},
					template: '#$templateId',
					created: function() {
						this.\$on('set', this.set);
						this.\$on('next', this.next);
						this.\$on('previous', this.previous);
						this.\$parent.title = this.getTitle;
					}
				}
			);
		");
	}

}
