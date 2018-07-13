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

class ComponentEditSituation extends ComponentGenerator {

	protected static $_dependances = [
		//"ComponentListSituations" => ["noname" => []],
		//"ComponentListProjet" => ["noname" => []],
	];
	protected static $_componentName = "component-edit-situation";

	private function __construct() { }

	private function __destruct() { }

	private static $base = [
		"date_creation" => null,
		"date_modification" => null,
		"id_situation" => null,
		"PersonnesPhysiques" => null,
		"is_valid" => null,
	];

	private static $jur = [
		"etat_civil"			=> "État civil",
		"regime_matrimonial"	=> "Régime matrimoniale",
		"a_des_enfants"			=> "A des enfants ?",
		"nbr_enfants"			=> "Nombre d'enfants",
		"enfants_a_charge"		=> "Nombre d'enfants à charge",
		"autre_personne_charge" => "Autres personnes à charge"
	];

	private static $fin = [
		"revenu_salaire" => "salaire",
		"revenu_immobilliers" => null,
		"revenu_mobilliers" => null,
		"revenu_autres" => null,
		"revenu_autres_precision" => null,
		"remboursement_mensuel" => null,
		"duree_remboursement_restante" => null,
		"loyer" => null,
		"habitation" => null,
		"credit_residence_secondaire" => null,
		"credit_residence_secondaire_duree" => null,
		"credit_immobilier_locatif" => null,
		"credit_immobilier_locatif_duree" => null,
		"credit_scpi" => null,
		"credit_scpi_duree" => null,
		"credit_a_la_consommation" => null,
		"credit_a_la_consommation_duree" => null,
		"credit_autres" => null,
		"credit_autres_duree" => null,
		"autres_charges" => null,
	];

	private static $fisc = [
		"pays_residence_fiscale" => null,
		"assujetti_impot_revenu" => null,
		"impot_annee_precedente" => null,
		"tranche_marginale_imposition" => null,
		"revenu_fiscale_reference" => null,
		"regime_foncier" => null,
		"deficit_foncier" => null,
		"nombre_parts_fiscales" => null,
		"impot_fortune" => null,
		"tranche_impot_fortune" => null,
	];

	private static $patri = [
		"estimation_patrimoine_global" => null,
		"patrimoine_residence_principale" => null,
		"patrimoine_assurance_vie" => null,
		"patrimoine_pea_compte_titre" => null,
		"patrimoine_pel_cel_codevi_livret" => null,
		"patrimoine_residence_secondaire" => null,
		"patrimoine_immobilier_locatif" => null,
		"patrimoine_scpi" => null,
		"patrimoine_epargne_retraite" => null,
		"patrimoine_autres" => null,
		"patrimoine_part_futur_placement" => null,
	];

	private static $incor = [
		"precision_coherence_1" => null,
		"precision_coherence_2" => null,
		"precision_coherence_3" => null,
		"precision_coherence_4" => null,
		"precision_coherence_5" => null,
		"precision_coherence_6" => null,
		"precision_coherence_7" => null,
		"precision_coherence_8" => null,
		"precision_coherence_9" => null,
		"precision_coherence_10" => null,
		"precision_coherence_11" => null,
		"precision_coherence_12" => null,
		"precision_coherence_13" => null,
		"precision_coherence_14" => null,
		"precision_coherence_15" => null,
		"precision_coherence_16" => null
	];

	private static $tmp = [
		"date_creation",
		"date_modification",
		"id_situation",
		"PersonnesPhysiques",
		"is_valid",

		"etat_civil",
		"regime_matrimonial",
		"a_des_enfants",
		"nbr_enfants",
		"enfants_a_charge",
		"autre_personne_charge",

		"revenu_salaire",
		"revenu_immobilliers",
		"revenu_mobilliers",
		"revenu_autres",
		"revenu_autres_precision",
		"remboursement_mensuel",
		"duree_remboursement_restante",
		"loyer",
		"credit_residence_secondaire",
		"credit_residence_secondaire_duree",
		"credit_immobilier_locatif",
		"credit_immobilier_locatif_duree",
		"credit_scpi",
		"credit_scpi_duree",
		"credit_a_la_consommation",
		"credit_a_la_consommation_duree",
		"credit_autres",
		"credit_autres_duree",
		"autres_charges",
		"habitation",

		"pays_residence_fiscale",
		"assujetti_impot_revenu",
		"impot_annee_precedente",
		"tranche_marginale_imposition",
		"revenu_fiscale_reference",
		"regime_foncier",
		"deficit_foncier",
		"nombre_parts_fiscales",
		"impot_fortune",
		"tranche_impot_fortune",

		"estimation_patrimoine_global",
		"patrimoine_residence_principale",
		"patrimoine_assurance_vie",
		"patrimoine_pea_compte_titre",
		"patrimoine_pel_cel_codevi_livret",
		"patrimoine_residence_secondaire",
		"patrimoine_immobilier_locatif",
		"patrimoine_scpi",
		"patrimoine_epargne_retraite",
		"patrimoine_autres",
		"patrimoine_part_futur_placement",


		"precision_coherence_1",
		"precision_coherence_2",
		"precision_coherence_3",
		"precision_coherence_4",
		"precision_coherence_5",
		"precision_coherence_6",
		"precision_coherence_7",
		"precision_coherence_8",
		"precision_coherence_9",
		"precision_coherence_10",
		"precision_coherence_11",
		"precision_coherence_12",
		"precision_coherence_13",
		"precision_coherence_14",
		"precision_coherence_15",
		"precision_coherence_16"
	];

	// on pourra utiliser config pour redéfinir le component d'edition à utiliser dans un cas ou dans l'autre pour certains component
	protected static function getTemplate($class, $config) {
		$componentClassName = static::getClassName($class);
		$componentName = get_called_class();

		$elms = [];
		foreach (self::$tmp as $elm) {
			$elms[$elm] = SituationPhysique::getComponentConfigured($elm);
			//$elms[$elm] = SituationPhysique::getShowComponentConfigured($elm);
		};


		$rt = " <div class='$componentClassName $componentName component' style='margin-bottom: 120px;'>";
		if (SHOW_FRAME)
			$rt .= "<span class='debugMsg'>$componentClassName</span>";


		$rt .= "
			<div class='closeMsgBox' @click='close()'>
				<img src='assets/Close-Jaune.svg'/>
			</div>
			<div class='top-modal'>
				<div class='name'>
					SITUATION : <span style=''>[{{ selectedSituationShortName }}]</span>
					<div class='trait-orange'></div>
				</div>
			</div>
			<div class='middle-modal'>
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
			<div class='onglet-modal'>
				<div class='menu'>
					<div :class='{selected: selectedOnglet === \"base\", ongletError: haveError(\"base\")}' @click='setOnglet(\"base\")'>
						GÉNÉRAL
					</div>
					<div :class='{selected: selectedOnglet === \"jur\", ongletError: haveError(\"jur\")}' @click='setOnglet(\"jur\")'>
						SITUATION JURIDIQUE
					</div>
					<div :class='{selected: selectedOnglet === \"fin\", ongletError: haveError(\"fin\")}' @click='setOnglet(\"fin\")'>
						SITUATION FINANCIERE
					</div>
					<div :class='{selected: selectedOnglet === \"fisc\", ongletError: haveError(\"fisc\")}' @click='setOnglet(\"fisc\")'>
						SITUATION FISCALE
					</div>
					<div :class='{selected: selectedOnglet === \"patri\", ongletError: haveError(\"patri\")}' @click='setOnglet(\"patri\")'>
						SITUATION PATRIMONIALE
					</div>
					<div :class='{selected: selectedOnglet === \"incor\", ongletError: haveError(\"incor\")}' @click='setOnglet(\"incor\")'>
						INCOHERENCES
					</div>
				</div>
				<div class='contenu' :class='{ongletError: haveError(selectedOnglet)}'>
					<div v-if='selectedOnglet === \"base\"' class='std'>
						<div class='ongletTitle'>
							GÉNÉRAL
							<div class='trait-orange'></div>
							<br />
						</div>
							";

						foreach (self::$base as $key => $val) {
							$name = ($val !== null) ? $val : $key;
							$rt .= "
								<div class='in'>
									<span>$name</span>
									{$elms[$key]}
								</div>
								";
						}
				$rt .="
					</div>
					<div v-if='selectedOnglet === \"jur\"' class='std'>
						<div class='ongletTitle'>
							SITUATION JURIDIQUE
							<div class='trait-orange'></div>
							<br />
						</div>
							";

							foreach (self::$jur as $key => $val) {
								$name = ($val !== null) ? $val : $key;
								$rt .= "
									<div class='in'>
										<span>$name</span>
										{$elms[$key]}
									</div>
									";
							}
				$rt .="
					</div>
					<div v-if='selectedOnglet === \"fin\"' class='std'>
						<div class='ongletTitle'>
							SITUATION FINANCIERE
							<div class='trait-orange'></div>
							<br />
						</div>
							";

							foreach (self::$fin as $key => $val) {
								$name = ($val !== null) ? $val : $key;
								$rt .= "
									<div class='in'>
										<span>$name</span>
										{$elms[$key]}
									</div>
									";
							}
				$rt .="
					</div>
					<div v-if='selectedOnglet === \"fisc\"' class='std'>
						<div class='ongletTitle'>
							SITUATION FISCALE
							<div class='trait-orange'></div>
							<br />
						</div>
							";

							foreach (self::$fisc as $key => $val) {
								$name = ($val !== null) ? $val : $key;
								$rt .= "
									<div class='in'>
										<span>$name</span>
										{$elms[$key]}
									</div>
									";
							}
				$rt .="
					</div>
					<div v-if='selectedOnglet === \"patri\"' class='std'>
						<div class='ongletTitle'>
							SITUATION PATRIMONIALE
							<div class='trait-orange'></div>
							<br />
						</div>
							";
							foreach (self::$patri as $key => $val) {
								$name = ($val !== null) ? $val : $key;
								$rt .= "
									<div class='in'>
										<span>$name</span>
										{$elms[$key]}
									</div>
									";
							}
				$rt .="
					</div>
					<div v-if='selectedOnglet === \"incor\"' class='std'>
						<div class='ongletTitle'>
							INCOHÉRENCES
							<div class='trait-orange'></div>
							<br />
						</div>
							";

							foreach (self::$incor as $key => $val) {
								$name = ($val !== null) ? $val : $key;
								$rt .= "
									<div class='in'>
										<span>$name</span>
										{$elms[$key]}
									</div>
									";
							}
				$rt .="
					</div>
				</div>
			</div>
			<div class='simpleForm'>
				<div>
					<button @click='save()' class='btn-mscpi' style='margin-top:30px;margin-bottomm:30px;'>ENREGISTRER</button>
				</div>
			</div>
		";
		
		$rt .= "</div> ";
		return ($rt);
	}
	protected static function getComponent($class, $config) {
		$componentName = static::getComponentName($class);
		$templateId = static::getTemplateId($class);

		$id_client = intval($GLOBALS['GET']['client']);
		$base	= json_encode(self::$base);
		$jur	= json_encode(self::$jur);
		$fin	= json_encode(self::$fin);
		$fisc	= json_encode(self::$fisc);
		$patri	= json_encode(self::$patri);
		$incor	= json_encode(self::$incor);
		return ("
			Vue.component(
				'$componentName',
				{
					data: function() {
						return ({
							selectedOnglet: 'base',
							champs: {
								base:	$base,
								jur:	$jur,
								fin:	$fin,
								fisc:	$fisc,
								patri:	$patri,
								incor:	$incor
							}
						});
					},
					props: [ 'data' ],
					computed: {
						ppList: function() {
							return (this.\$store.getters.getSituationPhysique_PersonnesPhysiques(this.selectedSituationPhysique.id.value));
						},
						selectedSituationPhysique: function() {
							return (this.\$store.getters.getSelectedSituationPhysique);
						},
						selectedSituationShortName: function() {
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
						haveError: function(name) {
							var data = this.champs[name];
							for (var key in data) {
								if (typeof this.selectedSituationPhysique[key].error != 'undefined')
									return (true);
							}
							return (false);
						},
						setOnglet: function(name) {
							this.selectedOnglet = name;
						},
						close: function() {
							this.\$store.commit('modal_stack_pop');
						},
						save: function() {
							var that = this;
							if (this.selectedSituationPhysique.id.value == 0)
								return ;
								//this.selectedSituation.id_dh.value = this.\$store.getters.getSelectedDonneurDOrdre.id.value;
							this.\$store.dispatch('write_selected_SituationPhysique').then(function(elm) {
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
