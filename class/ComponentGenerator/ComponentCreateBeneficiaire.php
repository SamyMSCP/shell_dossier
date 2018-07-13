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

class ComponentCreateBeneficiaire extends ComponentGenerator {

	protected static $_dependances = [
		"ComponentListSituations" => ["noname" => []],
		"ComponentListProjet" => ["noname" => []],
	];
	protected static $_componentName = "component-create-beneficiaire";

	private function __construct() { }

	private function __destruct() { }

	// on pourra utiliser config pour redéfinir le component d'edition à utiliser dans un cas ou dans l'autre pour certains component
	protected static function getTemplate($class, $config) {
		$componentClassName = static::getClassName($class);
		$componentName = get_called_class();

		$rt = " <div class='$componentClassName $componentName component' style='margin-bottom: 120px;'>";
		if (SHOW_FRAME)
			$rt .= "<span class='debugMsg'>$componentClassName</span>";


		$rt .= "
			<div class='closeMsgBox' @click='close()'>
				<img src='assets/Close-Jaune.svg'/>
			</div>
			<div class='top-modal'>
				<div class='name'>
					CREATION D'UN NOUVEAU BÉNÉFICIAIRE
					<div class='trait-orange'></div>
				</div>
			</div>
			<div class='middle-modal'>
				<div v-if='mode === 0'>
					<p>Quel type de bénéficiaire souhaitez-vous créer ?</p>
					<div class='btnList'>
						<button class='btn-mscpi' @click='setDh()' v-if='!haveDh'>Le donneur d'ordre</button>
						<button class='btn-mscpi' @click='setMode(2)' v-if='!haveCouple'>Le conjoint du Donneur d'ordre</button>
						<button class='btn-mscpi' @click='setMode(3)'>Un enfant du Donneur d'ordre</button>
						<button class='btn-mscpi' @click='setMode(4)'>Un parent du Donneur d'ordre</button>
						<button class='btn-mscpi' @click='setMode(5)'>Une personne morale</button>
					</div>
				</div>

				<div v-if='mode === 2'>
					<p>Qui est le conjoint du Donneur d'ordre ?</p>
					<div  class='simpleForm'>
						<select v-model='ppConjoint'>
							<option v-for='pp in getPersonnesPhysiquesNotHaveBenefciaireSeul' :value='pp.id.value'>{{ pp.shortName.value }}</option>
							<option :value='-1'>Insérer une nouvelle personne physique</option>
						</select>
					</div>
					<div class='btnList'>
						<button v-if='ppConjoint > 0'class='btn-mscpi' @click='setConjoint()'>Enregistrer</button>
					</div>
				</div>

				<div v-if='mode === 3'>
					<p>Qui est cet enfant ?</p>
					<div  class='simpleForm'>
						<select v-model='ppEnfant'>
							<option v-for='pp in getPersonnesPhysiquesNotHaveBenefciaireSeul' :value='pp.id.value'>{{ pp.shortName.value }}</option>
							<option :value='-1'>Insérer une nouvelle personne physique</option>
						</select>
					</div>
					<div class='btnList'>
						<button v-if='ppEnfant > 0'class='btn-mscpi' @click='setEnfant()'>Enregistrer</button>
					</div>
				</div>

				<div v-if='mode === 4'>
					<p>Qui est ce parent ?</p>
					<div  class='simpleForm'>
						<select v-model='ppParent'>
							<option v-for='pp in getPersonnesPhysiquesNotHaveBenefciaireSeul' :value='pp.id.value'>{{ pp.shortName.value }}</option>
							<option :value='-1'>Insérer une nouvelle personne physique</option>
						</select>
					</div>
					<div class='btnList'>
						<button v-if='ppParent > 0'class='btn-mscpi' @click='setParent()'>Enregistrer</button>
					</div>
				</div>

				<div v-if='mode === 5'>
					<p>Pour quel personne morale souhaitez-vous créer un bénéficiaire ?</p>
					<div  class='simpleForm'>
						<select v-model='pmIn'>
							<option v-for='pm in getPersonnesMoraleNotHaveBenefciaire' :value='pm.id.value'>{{ pm.dn_sociale.value }}</option>
							<option :value='-1'>Insérer une nouvelle personne morale</option>
						</select>

					</div>
					<div class='btnList'>
						<button v-if='pmIn > 0'class='btn-mscpi' @click='setPm()'>Enregistrer</button>
					</div>
				</div>
			</div>
		";
		/*
		*/
		
		$rt .= "</div> ";
		return ($rt);
	}
	protected static function getComponent($class, $config) {
		$componentName = static::getComponentName($class);
		$templateId = static::getTemplateId($class);

		$id_client = intval($GLOBALS['GET']['client']);
		return ("
			Vue.component(
				'$componentName',
				{
					data: function() {
						return ({
							mode: 0,
							ppConjoint: 0,
							ppEnfant: 0,
							ppParent: 0,
							pmIn: 0
						});
					},
					watch: {
						pmIn: function(elm) {
							this.selectedBeneficiaire.mode = this.mode;
							if (elm == -1)
								this.newPersonneMorale();
						},
						ppConjoint: function(elm) {
							this.selectedBeneficiaire.mode = this.mode;
							if (elm == -1)
								this.newPersonnePhysique();
						},
						ppEnfant: function(elm) {
							this.selectedBeneficiaire.mode = this.mode;
							if (elm == -1)
								this.newPersonnePhysique();
						},
						ppParent: function(elm) {
							this.selectedBeneficiaire.mode = this.mode;
							if (elm == -1)
								this.newPersonnePhysique();
						},
					},
					props: [ 'data' ],
					computed: {
						ppDh: function() {
							return (this.\$store.getters.getPersonnesPhysiquesDonneurDOrdre);
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
						getPersonnesPhysiquesNotHaveBenefciaireSeul: function() {
							var rt = [];
							var that = this;
							rt = this.\$store.getters.getAllPersonnePhysique.filter(function(elm) {
								return (
									that.getBeneficiairesSeulForPersonnePhysique(elm).length == 0 &&
									that.dh.lien_phy.value != 
									elm.id.value
								);
							})
							return (rt);
						},
						getPersonnesMoraleNotHaveBenefciaire: function() {
							var rt = [];
							return (this.\$store.getters.getAllPersonneMorale);
						},
						ppList: function() {
							return (this.\$store.getters.getBeneficiaire2_PersonnePhysique(this.selectedBeneficiaire.id.value));
						},
						selectedBeneficiaire: function() {
							return (this.\$store.getters.getSelectedBeneficiaire2);
						},
						selectedBeneficiaireShortName: function() {
							var rt = '';
							var temoin = false;
							for (var key in this.ppList) {
								if (temoin)
									rt += ' & ';
								rt += this.ppList[key].shortName.value;
								temoin = true;
							}
							return (rt);
						},
						dh: function() {
							var dh = this.\$store.getters.getDonneurDOrdreById(this.selectedBeneficiaire.id_dh.value);
							return (dh);
						},
						dhName: function() {
							var dh = this.\$store.getters.getDonneurDOrdreById(this.selectedBeneficiaire.id_dh.value);
							if (typeof dh == 'undefined')
								return ('-');
							return (dh.id.value + \":\" + dh.shortName.value);
						},
						selectedDh: function() {
							return (this.\$store.getters.getSelectedDonneurDOrdre);
						},
						haveDh: function () {
							var that = this;
							return (this.ppDh.filter(function(elm) {
								return (that.getBeneficiairesSeulForPersonnePhysique(elm).length > 0);
							}).length > 0);
						},
						haveCouple: function () {
							var that = this;
							return (this.ppDh.filter(function(elm) {
								return (that.getBeneficiairesCoupleForPersonnePhysique(elm).length > 0);
							}).length > 0);
						},
						getForCouple: function () {
							// Renvoie toutes les personnes physiques qui n'ont pas de beneficiaire.
							/*
								Récupération de tous les benficiaire du Dh.
								filter pour ne garder que ceux qui ne sont pas le dh et qui n'ont pas 
							*/
						},
						getForChild: function () {
							// Renvoie toutes les personnes physiques qui n'ont pas de beneficiaire.
						},
						getForParent: function () {
							// Renvoie toutes les personnes physiques qui n'ont pas de beneficiaire.
						},
						getForPm: function () {
							// Renvoie toutes les personnes morales qui n'ont pas de beneficiaire.
						},
					},
					methods: {
						setDh: function() {
							var that = this;
							if (this.selectedBeneficiaire.id.value == 0)
								this.selectedBeneficiaire.id_dh.value = this.\$store.getters.getSelectedDonneurDOrdre.id.value;
							this.selectedBeneficiaire.type_ben.value = 'seul';
							this.selectedBeneficiaire.type_relation.value = '';
							that.selectedBeneficiaire.PersonnePhysique.value.push(that.\$store.getters.getSelectedDonneurDOrdre.lien_phy.value);
							this.\$store.dispatch('write_selected_Beneficiaire2').then(function(elm) {
								that.\$store.dispatch('modal_stack_pop');
							});
						},
						setEnfant: function() {
							var that = this;
							var ppEnfant = this.ppEnfant;
							if (this.selectedBeneficiaire.id.value == 0)
								this.selectedBeneficiaire.id_dh.value = this.\$store.getters.getSelectedDonneurDOrdre.id.value;
							this.selectedBeneficiaire.type_ben.value = 'seul';
							this.selectedBeneficiaire.type_relation.value = 'enfant';
							this.selectedBeneficiaire.PersonnePhysique.value.push(ppEnfant);

							this.\$store.dispatch('write_selected_Beneficiaire2').then(function(elm) {
								that.\$store.dispatch('modal_stack_pop');
							});

						},
						setParent: function() {
							var that = this;
							var ppParent = this.ppParent;
							if (this.selectedBeneficiaire.id.value == 0)
								this.selectedBeneficiaire.id_dh.value = this.\$store.getters.getSelectedDonneurDOrdre.id.value;
							this.selectedBeneficiaire.type_ben.value = 'seul';
							this.selectedBeneficiaire.type_relation.value = 'parent';
							this.selectedBeneficiaire.PersonnePhysique.value.push(ppParent);

							this.\$store.dispatch('write_selected_Beneficiaire2').then(function(elm) {
								that.\$store.dispatch('modal_stack_pop');
							});
						},
						setConjoint: function() {
							var that = this;
							var ppConjoint = this.ppConjoint;
							if (this.selectedBeneficiaire.id.value == 0)
								this.selectedBeneficiaire.id_dh.value = this.\$store.getters.getSelectedDonneurDOrdre.id.value;
							this.selectedBeneficiaire.type_ben.value = 'seul';
							this.selectedBeneficiaire.type_relation.value = 'couple';
							this.selectedBeneficiaire.PersonnePhysique.value.push(ppConjoint);
							this.\$store.dispatch('write_selected_Beneficiaire2').then(function(elm) {
								that.\$store.commit('set_new_Beneficiaire2');
								that.\$store.getters.getSelectedBeneficiaire2.id_dh.value = that.\$store.getters.getSelectedDonneurDOrdre.id.value;
								that.selectedBeneficiaire.type_ben.value = 'couple';
								that.selectedBeneficiaire.type_relation.value = 'couple';
								that.selectedBeneficiaire.PersonnePhysique.value.push(that.\$store.getters.getSelectedDonneurDOrdre.lien_phy.value);
								that.selectedBeneficiaire.PersonnePhysique.value.push(ppConjoint);
								that.\$store.dispatch('write_selected_Beneficiaire2').then(function(elm) {
									that.\$store.dispatch('modal_stack_pop');
								});
							});

						},
						setPm: function() {
							var that = this;
							if (this.selectedBeneficiaire.id.value == 0)
								this.selectedBeneficiaire.id_dh.value = this.\$store.getters.getSelectedDonneurDOrdre.id.value;
							this.selectedBeneficiaire.type_ben.value = 'Pm';
							this.selectedBeneficiaire.type_relation.value = '';
							this.selectedBeneficiaire.PersonneMorale.value.push(this.pmIn);

							this.\$store.dispatch('write_selected_Beneficiaire2').then(function(elm) {
								that.\$store.dispatch('modal_stack_pop');
							});
						},
						setMode: function(mode) {
							if (mode == 1) {
								/*
									set new beneficiaire.
									definir le type de beneficiaire
									definir le type derelation 
									definir l'id du dh en beneficiaire !
								*/
							}
							this.mode = mode;
						},
						newPersonnePhysique: function(elm) {
							if (this.\$store.getters.getSelectedPersonnePhysique.id.value != 0)
								this.\$store.commit('set_new_PersonnePhysique');
							this.\$store.commit('modal_stack_push', {
								tag: 'component-edit-personnes-physiques-noname'
							});
						},
						newPersonneMorale: function(elm) {
							if (this.\$store.getters.getSelectedPersonneMorale.id.value != 0)
								this.\$store.commit('set_new_PersonneMorale');
							this.\$store.commit('modal_stack_push', {
								tag: 'component-edit-personnes-morale-noname'
							});
						},
						setPersonnePhysique: function(elm) {
							this.\$store.commit('set_selected_PersonnePhysique', elm);
							this.\$store.commit('modal_stack_push', {
								tag: 'component-edit-personnes-physiques-noname'
							});
						},
						setOnglet: function(name) {
							this.selectedOnglet = name;
						},
						close: function() {
							this.\$store.commit('modal_stack_pop');
						},
						save: function() {
							var that = this;
							if (this.selectedBeneficiaire.id.value == 0)
								this.selectedBeneficiaire.id_dh.value = this.\$store.getters.getSelectedDonneurDOrdre.id.value;
							return (this.\$store.dispatch('write_selected_Beneficiaire2').then(function(elm) {
								that.\$store.dispatch('modal_stack_pop');
							}));
						},
					},
					created: function() {
						if (typeof this.selectedBeneficiaire.mode != 'undefined')
							this.mode = this.selectedBeneficiaire.mode;
						if (this.mode == 2)
							this.ppConjoint = this.\$store.getters.getSelectedPersonnePhysique.id.value;
						if (this.mode == 3)
							this.ppEnfant = this.\$store.getters.getSelectedPersonnePhysique.id.value;
						if (this.mode == 4)
							this.ppParent = this.\$store.getters.getSelectedPersonnePhysique.id.value;
						if (this.mode == 5)
							this.pmIn = this.\$store.getters.getSelectedPersonneMorale.id.value;
					},
					mounted: function() {
						if (typeof this.selectedBeneficiaire.mode != 'undefined')
							this.mode = this.selectedBeneficiaire.mode;
						if (this.mode == 2)
							this.ppConjoint = this.\$store.getters.getSelectedPersonnePhysique.id.value;
						if (this.mode == 3)
							this.ppEnfant = this.\$store.getters.getSelectedPersonnePhysique.id.value;
						if (this.mode == 4)
							this.ppParent = this.\$store.getters.getSelectedPersonnePhysique.id.value;
						if (this.mode == 5)
							this.pmIn = this.\$store.getters.getSelectedPersonneMorale.id.value;
					},
					template: '#$templateId'
				}
			);
		");
	}
}
