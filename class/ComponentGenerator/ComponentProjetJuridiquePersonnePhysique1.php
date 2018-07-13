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

class ComponentProjetJuridiquePersonnePhysique1 extends ComponentGenerator {

	protected static $_dependances = [
		"ComponentInputCheckboxMscpi" => ["noname" => []]
	];
	protected static $_componentName = "component-projet-juridiquepersonnephysique1";

	private function __construct() { }

	private function __destruct() {}

	// on pourra utiliser config pour redéfinir le component d'edition à utiliser dans un cas ou dans l'autre pour certains component
	protected static function getTemplate($class, $config) {
		$componentClassName = static::getClassName($class);
		$componentName = get_called_class();

		$rt = " <div class='$componentClassName $componentName component'>";
		if (SHOW_FRAME)
			$rt .= "<span class='debugMsg'>$componentClassName</span>";

		$civiliteEdit						= PersonnePhysique::getComponentConfigured('civilite', [':data' => "selectedPp.civilite"]);
		$nomEdit							= PersonnePhysique::getComponentConfigured('nom', [':data' => "selectedPp.nom", "style" => "max-width: 150px;", "placeholder" => "nom"]);
		$prenomEdit							= PersonnePhysique::getComponentConfigured('prenom', [':data' => "selectedPp.prenom", "style" => "max-width: 150px;", "placeholder" => "prénom"]);
		$nationaliteEdit 					= PersonnePhysique::getComponentConfigured('nationalite', [':data' => "selectedPp.nationalite"]);
		$date_de_nEdit						= PersonnePhysique::getComponentConfigured('date_de_n', [':data' => "selectedPp.date_de_n", "style" => "max-width: 130px;"]);
		$pays_de_naissanceEdit 				= PersonnePhysique::getComponentConfigured('pays_de_naissance', [':data' => "selectedPp.pays_de_naissance"]);
		$code_naissanceEdit 				= PersonnePhysique::getComponentConfigured('code_naissance', [':data' => "selectedPp.code_naissance", "list" => "codePostalList2", "style" => "max-width: 130px;"]);
		$lieu_de_nEdit						= PersonnePhysique::getComponentConfigured('lieu_de_n', [':data' => "selectedPp.lieu_de_n", "list" => "codePostalList2"]);
		$numeroRueEdit						= PersonnePhysique::getComponentConfigured('numeroRue', [':data' => "selectedPp.numeroRue", "style" => "max-width: 70px;", "placeholder" => "n°"]);

		$extensionEdit						= PersonnePhysique::getComponentConfigured('extension', [':data' => "selectedPp.extension", "style" => "max-width: 110px;", "placeholder" => "extension"]);
		$type_voieEdit						= PersonnePhysique::getComponentConfigured('type_voie', [':data' => "selectedPp.type_voie"]);
		$voieEdit							= PersonnePhysique::getComponentConfigured('voie', [':data' => "selectedPp.voie", "placeholder" => "nom de voie"]);
		$complementAdresseEdit 				= PersonnePhysique::getComponentConfigured('complementAdresse', [':data' => "selectedPp.complementAdresse", "placeholder" => "complément adresse"]);
		$paysEdit							= PersonnePhysique::getComponentConfigured('pays', [':data' => "selectedPp.pays"]);
		$codePostalEdit 					= PersonnePhysique::getComponentConfigured('codePostal', [':data' => "selectedPp.codePostal", "list" => "codePostalList1", "style" => "max-width: 130px;"]);
		$villeEdit							= PersonnePhysique::getComponentConfigured('ville', [':data' => "selectedPp.ville", "list" => "codePostalList1"]);
		$categorie_professionelle_code_1	= PersonnePhysique::getComponentConfigured('categorie_professionelle_code_1', [
			':data' => "selectedPp.categorie_professionelle_code_1",
			':code2' => "selectedPp.categorie_professionelle_code_2",
		]);
		$categorie_professionelle_code_2	= PersonnePhysique::getComponentConfigured('categorie_professionelle_code_2', [
			':data' => "selectedPp.categorie_professionelle_code_2",
			':code1' => "selectedPp.categorie_professionelle_code_1",
		]);

		$code_naf							= PersonnePhysique::getComponentConfigured('code_naf', [':data' => "selectedPp.code_naf", "style" => "max-width: 110px;"]);
		$depart_retraite					= PersonnePhysique::getComponentConfigured('depart_retraite', [':data' => "selectedPp.depart_retraite", "style" => "max-width: 80px;", "placeholder" => "année"]);

		$mail								= PersonnePhysique::getComponentConfigured('mail');

		$rt .= "
			<component-project-mini-progress-bar-noname position='2'  :size='getSize'> </component-project-mini-progress-bar-noname>
			<datalist id='codePostalList1'>
				<option v-for='(elm, key) in codeList'>{{ elm.Nom_commune }} / {{ elm.Code_postal }}</option>
			</datalist>
			<datalist id='codePostalList2'>
				<option v-for='(elm, key) in codeList2'>{{ elm.Nom_commune }} / {{ elm.Code_postal }}</option>
			</datalist>

			<div class='simpleForm'>
				<div class='subtitle'>
					<div>Votre identité</div>
				</div>
			</div>
			<div class='form_inline' style='margin-bottom:100px'>
				Je suis $civiliteEdit $nomEdit $prenomEdit, de nationalité $nationaliteEdit,<br />
				né{{ (selectedPp.civilite.value == 'Madame') ? 'e' : ''}} le $date_de_nEdit en/aux $pays_de_naissanceEdit, à $lieu_de_nEdit, $code_naissanceEdit
			</div>
			<div class='simpleForm'>
				<div class='subtitle'>
					<div>Votre adresse</div>
				</div>
			</div>
			<div class='form_inline' style='margin-bottom:100px'>
				Je réside en/aux $paysEdit au $numeroRueEdit $extensionEdit $type_voieEdit $voieEdit $complementAdresseEdit $codePostalEdit $villeEdit.
			</div>

			<div class='simpleForm' v-if='!isDh'>
				<div class='subtitle'>
					<div>Vos coordonnées</div>
				</div>
			</div>
			<div class='form_inline' style='margin-bottom:100px'  v-if='!isDh'>
				Je peux être contacté par courriel à l'adresse $mail
			</div>

			<div class='simpleForm'>
				<div class='subtitle'>
					<div>
						Votre situation professionnelle
					</div>
				</div>
			</div>
			<div class='form_inline'>
				Je fais partie de la catégorie professionnelle $categorie_professionelle_code_1. Je suis $categorie_professionelle_code_2 et mon code NAF est $code_naf <span style='cursor:pointer;text-decoration:underline;color: #0e6dbb;font-size: 14px;' @click='openHelper()'>(Je ne connais pas mon code NAF)</span>
				<br />
				Je prévois de partir à la retraite en $depart_retraite
			</div>
		";
		$rt .= "</div> ";

		/*
		*/
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
						return ({codeList: {}, codeList2: {}});
					},
					computed: {
						isDh: function() {
							return  (this.selectedPp.id.value == this.\$store.getters.getSelectedDonneurDOrdre.lien_phy.value);
						},
						getSize: function() {
							if (this.listPersonnePhysique == null)
								return (3);
							if (this.listPersonnePhysique.length > 1)
								return (5);
							return (3);
						},
						selectedPp: function() {
							return (this.\$store.getters.getSelectedPersonnePhysique);
						},
						selectedSitation: function() {
							return (this.\$store.getters.getSelectedSituationPhysique);
						},
						selectedProjet: function() {
							return (this.\$store.getters.getSelectedProjet2);
						},
						statut_parcour_client: function() {
							return (this.selectedProjet.statut_parcour_client.value);
						},
						storeDatas: function() {
							return (this.\$store.state.mscpi.modules.StoreModuleProcessProjet.Blocks.ProjetJuridiquePersonnePhysique1);
						},
						isValid: function() {
							return (true);
						},
						listPersonnePhysique: function() {
							return (this.\$store.getters.getPersonnesPhysiqueForProjet2);
						},
						gVille: function() {
							return (this.selectedPp.ville.value);
						},
						gCode: function() {
							return (this.selectedPp.codePostal.value);
						},
						gVilleN: function() {
							return (this.selectedPp.lieu_de_n.value);
						},
						gCodeN: function() {
							return (this.selectedPp.code_naissance.value);
						},
					},
					watch: {
						gVille: function(elm) {
							if (this.selectedPp.pays.value != 'France')
								return ;
							var that = this;
							var value = String(elm).split(' / ', 2);
							if (value.length < 2)
							{
								this.\$store.dispatch('getCodeVille', {
									code: that.selectedPp.codePostal.value,
									ville: that.selectedPp.ville.value
								}).then(
									function(datas) {
										Vue.set(that, 'codeList', datas)
									},
									function() {}
								);
							} else {
								that.selectedPp.ville.value = value[0];
								that.selectedPp.codePostal.value = value[1];
							}
						},
						gCode: function(elm) {
							if (this.selectedPp.pays.value != 'France')
								return ;
							var that = this;
							var value = String(elm).split(' / ', 2);
							if (value.length < 2)
							{
								this.\$store.dispatch('getCodeVille', {
									code: that.selectedPp.codePostal.value,
									ville: that.selectedPp.ville.value
								}).then(
									function(datas) {
										Vue.set(that, 'codeList', datas)
									},
									function() {}
								);
							} else {
								that.selectedPp.ville.value = value[0];
								that.selectedPp.codePostal.value = value[1];
							}
						},
						gVilleN: function(elm) {
							if (this.selectedPp.pays_de_naissance.value != 'France')
								return ;
							var that = this;
							var value = String(elm).split(' / ', 2);
							if (value.length < 2)
							{
								this.\$store.dispatch('getCodeVille', {
									code: that.selectedPp.code_naissance.value,
									ville: that.selectedPp.lieu_de_n.value
								}).then(
									function(datas) {
										Vue.set(that, 'codeList2', datas)
									},
									function() {}
								);
							} else {
								that.selectedPp.lieu_de_n.value = value[0];
								that.selectedPp.code_naissance.value = value[1];
							}
						},
						gCodeN: function(elm) {
							if (this.selectedPp.pays_de_naissance.value != 'France')
								return ;
							var that = this;
							var value = String(elm).split(' / ', 2);
							if (value.length < 2)
							{
								this.\$store.dispatch('getCodeVille', {
									code: that.selectedPp.code_naissance.value,
									ville: that.selectedPp.lieu_de_n.value
								}).then(
									function(datas) {
										Vue.set(that, 'codeList2', datas)
									},
									function() {}
								);
							} else {
								that.selectedPp.lieu_de_n.value = value[0];
								that.selectedPp.code_naissance.value = value[1];
							}
						},
						isValid: function(val) {
							this.\$parent.\$emit('isValid', val);
						},
						statut_parcour_client: function(val) {
							if (this.listPersonnePhysique == null)
								return ;
							if (val == 'JuridiquePersonnePhysique1')
								this.\$store.commit('set_selected_PersonnePhysique', this.listPersonnePhysique[0]);
						}
					},
					methods: {
						previous: function(dat) {
							this.\$store.dispatch('projet2PreviousStep', this.selectedPp);
						},
						next: function(dat) {
							this.\$store.dispatch('projet2NextStep', this.selectedPp);
						},
						set: function(dat) {
							this.\$store.dispatch('projet2SetBlock', this.selectedPp);
						},
						openHelper: function() {
							this.\$store.commit('modal_stack_push', {
								tag: 'component-naf-helper-noname',
								config: {
									props: {
										data: this.data
									}
								}
							});
						}
					},
					mounted: function() {
						if (this.listPersonnePhysique != null)
							this.\$store.commit('set_selected_PersonnePhysique', this.listPersonnePhysique[0]);
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
