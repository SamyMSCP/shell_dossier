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

class ComponentEditBeneficiaire extends ComponentGenerator {

	protected static $_dependances = [
		"ComponentListSituations" => ["noname" => []],
		"ComponentListProjet" => ["noname" => []],
	];
	protected static $_componentName = "component-edit-beneficiaire";

	private function __construct() { }

	private function __destruct() { }

	// on pourra utiliser config pour redéfinir le component d'edition à utiliser dans un cas ou dans l'autre pour certains component
	protected static function getTemplate($class, $config) {
		$componentClassName = static::getClassName($class);
		$componentName = get_called_class();

		$type_ben			= Beneficiaire2::getShowComponentConfigured('type_ben');
		$type_relation		= Beneficiaire2::getShowComponentConfigured('type_relation');


		$situation			= ComponentListSituations::getHtmlTag('noname', [':data' => 'this.$store.getters.getPersonnePhysique_SituationPhysique(ppList[0].id.value)']);

		$f_juridique		= PersonneMorale::getShowComponentConfigured('f_juridique', [":data" => "pm.f_juridique"]);

		$rt = " <div class='$componentClassName $componentName component' style='margin-bottom: 120px;'>";
		if (SHOW_FRAME)
			$rt .= "<span class='debugMsg'>$componentClassName</span>";


		$rt .= "
			<div class='closeMsgBox' @click='close()'>
				<img src='assets/Close-Jaune.svg'/>
			</div>
			<div class='top-modal'>
				<div class='name'>
					BENEFICIAIRE : <span style=''>[{{ selectedBeneficiaireShortName }}]</span>
					<div class='trait-orange'></div>
				</div>
			</div>

			<div class='middle-modal' v-if='selectedBeneficiaire.type_ben.value !=\"Pm\"'>

				<div v-for='pp in ppList' class='modalBlock'>
					<div class='modalBlock_title'>
						<span>
							{{ pp.shortName.value }} 
							<img src='assets/crayon-inactif@2x.png' @click='setPersonnePhysique(pp)'/>
						</span>
						<div class='trait-orange'></div>
					</div>
					<div class='modalBlock_bottom'>
						<div class='modalBlock_bottom_left'>
							<div>
								<img src='assets/Flag-bleuclair-01.png'/>
								??
							</div>
							<div>
								<img src='assets/Phone-bleuclair.png'/>
								[{{ pp.indicatif_telephonique.value }}] {{ pp.telephone.value }}
							</div>
							<div>
								<img src='assets/Email-bleuclair.png'/>
								{{ pp.mail.value }}
							</div>
						</div>
						<div class='modalBlock_bottom_right'>

							<document-btn class='btn-mscpi btn-orange' v-for='typeDocument in \$store.getters.getLstDocuments.PersonnePhysique' id_entity='1' :link_entity='pp.id.value' :type_document='typeDocument.id' :key='typeDocument.id'>
								{{ typeDocument.name }}
							</document-btn>
						</div>
					</div>
				</div>
			</div>
			<div class='middle-modal' v-else>
				<div v-for='pm in pmList' class='modalBlock' style='max-width:inherit; width:100%;'>
					<div class='modalBlock_title'>
						<span>
							{{ pm.dn_sociale.value }} 
							<img src='assets/crayon-inactif@2x.png' @click='setPersonneMorale(pm)'/>
						</span>
						<div class='trait-orange'></div>
					</div>
					<div class='modalBlock_bottom'>
						<div class='modalBlock_bottom_left'>
							<div>
								N° Siret : {{ pm.siret.value}}
							</div>
							<div>
								Forme Juridique : $f_juridique
							</div>
							<div>
								Gérant :
								<span v-if='typeof \$store.getters.getPersonnePhysiqueById(pm.id_gerant.value) != \"undefined\"'>
									{{ \$store.getters.getPersonnePhysiqueById(pm.id_gerant.value).shortName.value }}
								</span>
							</div>
						</div>
						<div class='modalBlock_bottom_right'>

							<document-btn class='btn-mscpi btn-orange' v-for='typeDocument in \$store.getters.getLstDocuments.PersonneMorale' id_entity='1' :link_entity='pm.id.value' :type_document='typeDocument.id' :key='typeDocument.id'>
								{{ typeDocument.name }}
							</document-btn>
						</div>
					</div>
				</div>

			</div>
			<div class='onglet-modal'>
				<div class='menu'>
					<div :class='{selected: selectedOnglet === \"GENERAL\"}' @click='setOnglet(\"GENERAL\")'>
						GÉNÉRAL
					</div>
					<div :class='{selected: selectedOnglet === \"SITUATION\"}' @click='setOnglet(\"SITUATION\")' v-if='selectedBeneficiaire.type_ben.value != \"Pm\"'>
						SITUATIONS
					</div>
					<div :class='{selected: selectedOnglet === \"PROJETS\"}' @click='setOnglet(\"PROJETS\")'  v-if='selectedBeneficiaire.type_ben.value != \"Pm\"'>
						PROJETS
					</div>
				</div>
				<div class='contenu'>
					<div v-if='selectedOnglet === \"GENERAL\"' class='std'>
						<div class='ongletTitle'>
							GÉNÉRAL
							<div class='trait-orange'></div>
							<br />
						</div>
						<div class='in'>
							<span>Type de beneficiaire</span>
							$type_ben
						</div>
						<div class='in'>
							<span>Type de relation</span>
							$type_relation
						</div>
					</div>
					<div v-if='selectedOnglet === \"SITUATION\"'>
						<div class='ongletTitle'>
							SITUATIONS DE {{ selectedBeneficiaireShortName }}
							<div class='trait-orange'></div>
						</div>
						$situation
					</div>
					<div v-if='selectedOnglet === \"PROJETS\"'>
						<div class='ongletTitle'>
							PROJETS DE {{ selectedBeneficiaireShortName }}
							<div class='trait-orange'></div>
							<br />
						</div>
						<component-list-projet-noname :data='this.\$store.getters.getProjet2_id_beneficiaire(selectedBeneficiaire.id.value)'></component-list-projet-noname>
					</div>
				</div>
			</div>
		";
		/*
			<div class='simpleForm'>
				<div>
					<button @click='save()' class='btn-mscpi' style='margin-top:30px;margin-bottomm:30px;'>ENREGISTRER</button>
				</div>
			</div>
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
							selectedOnglet: 'GENERAL'
						});
					},
					props: [ 'data' ],
					computed: {
						pmList: function() {
							return (this.\$store.getters.getBeneficiaire2_PersonneMorale(this.selectedBeneficiaire.id.value));
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
							if (typeof dh == 'undefined')
								return ('-');
							return (dh.id.value + \":\" + dh.shortName.value);
		
						}
					},
					methods: {
						setPersonnePhysique: function(elm) {
							this.\$store.commit('set_selected_PersonnePhysique', elm);
							this.\$store.commit('modal_stack_push', {
								tag: 'component-edit-personnes-physiques-noname'
							});
						},
						setPersonneMorale: function(elm) {
							this.\$store.commit('set_selected_PersonneMorale', elm);
							this.\$store.commit('modal_stack_push', {
								tag: 'component-edit-personnes-morale-noname'
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
							this.\$store.dispatch('write_selected_Beneficiaire2').then(function(elm) {
								that.\$store.dispatch('modal_stack_pop');
							});
						},
					},
					watch: {
					},
					template: '#$templateId'
				}
			);
		");
	}
}
