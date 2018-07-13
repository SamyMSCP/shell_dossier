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

class ComponentEditProjet extends ComponentGenerator {

	protected static $_dependances = [
		"ComponentListSituations" => ["noname" => []],
		"ComponentListProjet" => ["noname" => []],
		"ComponentEditProjetSimulationComparaison" => ["noname" => []],
		"ComponentEditProjetProposition" => ["noname" => []],
	];
	protected static $_componentName = "component-edit-projet";

	private function __construct() { }

	private function __destruct() { }

	// on pourra utiliser config pour redéfinir le component d'edition à utiliser dans un cas ou dans l'autre pour certains component
	protected static function getTemplate($class, $config) {
		$componentClassName = static::getClassName($class);
		$componentName = get_called_class();

		$date_creation			= Projet2::getComponentConfigured('date_creation');
		$etat_du_projet			= Projet2::getComponentConfigured('etat_du_projet');
		$statut_parcour_client	= Projet2::getComponentConfigured('statut_parcour_client');
		//$objectifs				= Projet2::getShowComponentConfigured('objectifs');

		$id_objectifs_list_1	= Projet2::getComponentConfigured('id_objectifs_list_1');
		$id_objectifs_list_2	= Projet2::getComponentConfigured('id_objectifs_list_2');
		$id_objectifs_list_3	= Projet2::getComponentConfigured('id_objectifs_list_3');

		/*
		*/
		$rt = " <div class='$componentClassName $componentName component' style='margin-bottom: 120px;'>";
		if (SHOW_FRAME)
			$rt .= "<span class='debugMsg'>$componentClassName</span>";


		$rt .= "
			<div class='closeMsgBox' @click='close()'>
				<img src='assets/Close-Jaune.svg'/>
			</div>
			<div class='top-modal'>
				<div class='name'>
					<span>{{ selectedProjet.id.value }}:{{ selectedProjet.nom.value | upper }}</span>
						<div v-if='selectedProjet.etat_du_projet.value == -1' style='border-color:#ff9f1c'>
							<img src='assets/EnCoursCreation-Orange.svg' alt='' />
							<div style='color:#ff9f1c'>
								Projet en cours de création
							</div>
						</div>
						<div v-if='selectedProjet.etat_du_projet.value == 0' style='border-color:#1781e0'>
							<img src='assets/Proposition_BleuClair.png' alt='' />
							<div style='color:#1781e0'>
								Projet créé
							</div>
						</div>
						<div v-if='selectedProjet.etat_du_projet.value >= 1 && selectedProjet.etat_du_projet.value <= 4' style='border-color:#1781e0'>
							<img src='assets/ProjetReflexionPlan de travail 1.svg' alt='' />
							<div style='color:#1781e0'>
								Projet en cours de réflexion
							</div>
						</div>
						<div v-if='selectedProjet.etat_du_projet.value == 5 || selectedProjet.etat_du_projet.value == 6' style='border-color:#1781e0'>
							<img src='assets/EnCoursRealisation-Bleu.svg' alt='' />
							<div style='color:#1781e0'>
								Projet en cours de réalisation
							</div>
						</div>
						<div v-if='selectedProjet.etat_du_projet.value == 7' style='border-color:#20BF55'>
							<img src='assets/Termine-Vert.svg' alt='' />
							<div style='color:#20BF55'>
								Projet finalisé
							</div>
						</div>

						<div v-if='selectedProjet.etat_du_projet.value == -2' style='border-color:#969D96'>
							<img src='assets/Annule-Gris.svg' alt='' />
							<div style='color:#969D96'>
								Projet annulé
							</div>
						</div>
						
				</div>
				<div class='blockCree'>
					<b>Créé le</b> {{ selectedProjet.date_creation.value  | tsDateStr }} | <b>Mis à jour le </b> {{ selectedProjet.date_modification.value  | tsDateStr }} 
				</div>
			</div>
			<div class='middle-modal'>

				<div  class='modalBlock'>
					<div class='modalBlock_title'>
						<span>
							DÉTAILS DU PROJET
						</span>
						<div class='trait-orange'></div>
					</div>
					<div class='modalBlock_bottom'>
						<div class='modalBlock_bottom_left alignRight'>
							<div>
								Bénéficiaires
							</div>
							<div>
								Budget
							</div>
						</div>
						<div class='modalBlock_bottom_left infos' style='flex:2;'>
							<div>
								{{ beneficiaireShortName }}
							</div>
							<div>
								{{ selectedProjet.montant_investissement_previsionnel.value }} €
							</div>
						</div>
					</div>
				</div>

				<div  class='modalBlock'>
					<div class='modalBlock_title'>
						<span>
							ORIGINE DES FONDS
						</span>
						<div class='trait-orange'></div>
					</div>
					<div class='modalBlock_bottom'>
						<div class='modalBlock_bottom_left  alignRight' style='flex:2;'>
							<div v-for='(origine, key) in selectedProjet.origine.value' v-if='origine.enabled'>
								<span v-if='key == \"Autre\"'>Autre: ({{ origine.precision }})</span>
								<span v-else>{{ key }}</span>
							</div>
						</div>
						<div class='modalBlock_bottom_left infos'>
							<div v-for='(origine, key) in selectedProjet.origine.value' v-if='origine.enabled'>
								[{{ origine.value }} %]
							</div>
						</div>
					</div>
				</div>

				<div  class='modalBlock'>
					<div class='modalBlock_title'>
						<span>
							OBJECTIFS
						</span>
						<div class='trait-orange'></div>
					</div>
					<div class='modalBlock_bottom'>
						<div class='modalBlock_bottom_left  alignRight' style='flex:0;'>
							<div style='height:60px;'> 1 </div>
							<div style='height:60px;'> 2 </div>
							<div style='height:60px;'> 3 </div>
						</div>
						<div class='modalBlock_bottom_left infos'>
							<div v-for='(idObj, key) in selectedProjet.objectifs.value' style='display:flex;flex-direction:column;align-items: flex-start;height:60px;'>
								{{ listObjectifs[idObj] }} <br />
								<span v-if='key==0'>
									$id_objectifs_list_1
								</span>
								<span v-if='key==1'>
									$id_objectifs_list_2
								</span>
								<span v-if='key==2'>
									$id_objectifs_list_3
								</span>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class='onglet-modal'>
				<div class='menu'>
					<div :class='{selected: selectedOnglet === \"GENERAL\"}' @click='setOnglet(\"GENERAL\")'>
						GÉNÉRAL
					</div>
					<div :class='{selected: selectedOnglet === \"simu\"}' @click='setOnglet(\"simu\")'>
						SIMULATION & COMPARAISONS
					</div>
					<div :class='{selected: selectedOnglet === \"portefeuille\"}' @click='setOnglet(\"portefeuille\")'>
						PORTEFEUILLE DE SCPI PROPOSÉES
					</div>
					<div :class='{selected: selectedOnglet === \"profils\"}' @click='setOnglet(\"profils\")'>
						VOS PROFILS D'INVESTISSEURS
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
							<span>Date de création</span>
							$date_creation
						</div>
						<div class='in'>
							<span>Etat du projet</span>
							$etat_du_projet
						</div>
						<div class='in'>
							<span>Etape du procecus de création</span>
							$statut_parcour_client
						</div>
					</div>
					<div v-if='selectedOnglet === \"simu\"' class='std'>
						<div class='ongletTitle'>
							SIMULATION & COMPARAISONS
							<div class='trait-orange'></div>
							<br />
						</div>
						<component-edit-projet-simulation-comparaison-noname></component-edit-projet-simulation-comparaison-noname>
					</div>
					<div v-if='selectedOnglet === \"portefeuille\"' class='std'>
						<div class='ongletTitle'>
							PORTEFEUILLE DE SCPI PROPOSÉES
							<div class='trait-orange'></div>
							<br />
						</div>
						<component-edit-projet-proposition-noname></component-edit-projet-proposition-noname>
					</div>
					<div v-if='selectedOnglet === \"profils\"' class='std'>
						<div class='ongletTitle'>
							VOS PROFILS D'INVESTISSEURS
							<div class='trait-orange'></div>
							<br />
						</div>
					</div>
				</div>
			</div>
			<div class='simpleForm'>
				<div>
					<button @click='save()' class='btn-mscpi' style='margin-top:30px;margin-bottomm:30px;'>ENREGISTRER</button>
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
		$list = json_encode(TypeObjectif::$_listObjectif);
		return ("
			Vue.component(
				'$componentName',
				{
					data: function() {
						return ({
							selectedOnglet: 'GENERAL',
							listObjectifs: $list
						});
					},
					props: [ 'data' ],
					computed: {
						origineSorted: function() {
						/*
							var rt = [];
							for (var key in this.selectedProjet.origine.value) {
								if (this.selectedProjet.origine.value[key].enabled)
								rt.push({
									name: key,
									this.selectedProjet.origine.value[key]
								});
							}
							return (rt);
							*/
						},
						selectedProjet: function() {
							return (this.\$store.getters.getSelectedProjet2);
						},
						beneficiaire: function() {
							return (this.\$store.getters.getBeneficiaire2_ByProjet2_id_beneficiaire(this.selectedProjet.id.value)[0]);
						},
						ppList: function() {
							return (this.\$store.getters.getBeneficiaire2_PersonnePhysique(this.beneficiaire.id.value));
						},
						beneficiaireShortName: function() {
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
					},
					methods: {
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
