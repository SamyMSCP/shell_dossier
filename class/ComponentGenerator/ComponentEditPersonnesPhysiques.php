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

class ComponentEditPersonnesPhysiques extends ComponentGenerator {

	protected static $_dependances = [
		"ComponentNafHelper" => ["noname" => []]
	];
	protected static $_componentName = "component-edit-personnes-physiques";

	private function __construct() { }

	private function __destruct() { }

	// on pourra utiliser config pour redéfinir le component d'edition à utiliser dans un cas ou dans l'autre pour certains component
	protected static function getTemplate($class, $config) {
		$componentClassName = static::getClassName($class);
		$componentName = get_called_class();

		$civiliteEdit						= PersonnePhysique::getComponentConfigured('civilite');
		$nomEdit							= PersonnePhysique::getComponentConfigured('nom');
		$prenomEdit							= PersonnePhysique::getComponentConfigured('prenom');
		$nationaliteEdit 					= PersonnePhysique::getComponentConfigured('nationalite');
		$date_de_nEdit						= PersonnePhysique::getComponentConfigured('date_de_n');
		$pays_de_naissanceEdit 				= PersonnePhysique::getComponentConfigured('pays_de_naissance');
		$code_naissanceEdit 				= PersonnePhysique::getComponentConfigured('code_naissance', [
			"list" => "codePostalList2"
		]);
		$lieu_de_nEdit						= PersonnePhysique::getComponentConfigured('lieu_de_n', [
			"list" => "codePostalList2
		"]);
		$numeroRueEdit						= PersonnePhysique::getComponentConfigured('numeroRue');

		$extensionEdit						= PersonnePhysique::getComponentConfigured('extension');
		$type_voieEdit						= PersonnePhysique::getComponentConfigured('type_voie');
		$voieEdit							= PersonnePhysique::getComponentConfigured('voie');
		$complementAdresseEdit 				= PersonnePhysique::getComponentConfigured('complementAdresse');
		$paysEdit							= PersonnePhysique::getComponentConfigured('pays');
		$codePostalEdit 					= PersonnePhysique::getComponentConfigured('codePostal', [
			"list" => "codePostalList1"
		]);
		$villeEdit							= PersonnePhysique::getComponentConfigured('ville', [
			"list" => "codePostalList1"
		]);
		$categorie_professionelle_code_1	= PersonnePhysique::getComponentConfigured('categorie_professionelle_code_1', [
			':code2' => "selectedPp.categorie_professionelle_code_2",
		]);
		$categorie_professionelle_code_2	= PersonnePhysique::getComponentConfigured('categorie_professionelle_code_2', [
			':code1' => "selectedPp.categorie_professionelle_code_1",
		]);
		$code_naf							= PersonnePhysique::getComponentConfigured('code_naf');
		$depart_retraite					= PersonnePhysique::getComponentConfigured('depart_retraite');

		$mail								= PersonnePhysique::getComponentConfigured('mail');
		$telephone							= PersonnePhysique::getComponentConfigured('telephone', [
			'linkid' => 42,
		]);
		$indicatif_telephonique				= PersonnePhysique::getComponentConfigured('indicatif_telephonique', [
			'linkid' => 42,
		]);
		$telephone_fixe						= PersonnePhysique::getComponentConfigured('telephone_fixe', [
			'linkid' => 43,
		]);
		$indicatif_telephonique_fixe		= PersonnePhysique::getComponentConfigured('indicatif_telephonique_fixe', [
			'linkid' => 43,
		]);

		/*
		*/
		$rt = " <div class='$componentClassName $componentName component' style='margin-bottom: 120px;'>";
		if (SHOW_FRAME)
			$rt .= "<span class='debugMsg'>$componentClassName</span>";


		$rt .= "
			<div class='closeMsgBox' @click='close()'>
				<img src='assets/Close-Jaune.svg'/>
			</div>
			<h2 style='margin-top:30px;margin-bottom:30px;'>Personne Physique</h2>
			<div class='traitOrange'> </div>
			<datalist id='codePostalList1'>
				<option v-for='(elm, key) in codeList'>{{ elm.Nom_commune }} / {{ elm.Code_postal }}</option>
			</datalist>
			<datalist id='codePostalList2'>
				<option v-for='(elm, key) in codeList2'>{{ elm.Nom_commune }} / {{ elm.Code_postal }}</option>
			</datalist>
			<div class='simpleForm'>

				<div class='subtitle'>
					<div>Identité</div>
				</div>
				<div>
					<span>Civilité</span>
					<div style='position:relative;'>
						$civiliteEdit
						<img src='assets/Gender_Homme.png' v-if='selectedPp.civilite.value == \"Monsieur\"' style='width: 23px; position: absolute; top: 16px; right: 20px;'/>
						<img src='assets/Gender_Femme.png' v-else style='width: 23px; position: absolute; top: 16px; right: 20px;'/>
					</div>
				</div>

				<div>
					<span>Nom</span>
					<div>$nomEdit</div>
				</div>
				<div>
					<span>Prénom</span>
					<div>$prenomEdit</div>
				</div>
				<div>
					<span>Nationalité</span>
					<div>$nationaliteEdit </div>
				</div>





				<div>
					<span>Date de naissance</span>
					<div>$date_de_nEdit</div>
				</div>
				<div>
					<span>Pays de naissance</span>
					<div>$pays_de_naissanceEdit </div>
				</div>
				<div>
					<span>Code postal de naissance</span>
					<div>$code_naissanceEdit </div>
				</div>
				<div>
					<span>Ville de naissance</span>
					<div>$lieu_de_nEdit</div>
				</div>

				<div class='subtitle'>
					<div>Coordonnées</div>
				</div>

				<div>
					<span>Adresse email</span>
					<div>$mail</div>
				</div>

				<div>
					<span>Indicatif téléphonique</span>
					<div>$indicatif_telephonique</div>
				</div>
				<div>
					<span>N° de téléphone</span>
					<div>$telephone</div>
				</div>
				<div>
					<span>Indicatif téléphonique fixe</span>
					<div>$indicatif_telephonique_fixe</div>
				</div>
				<div>
					<span>N° de téléphone fixe</span>
					<div>$telephone_fixe</div>
				</div>


				<div class='subtitle'>
					<div>Adresse postale</div>
				</div>
				<div>
					<span>N°</span>
					<div>$numeroRueEdit</div>
				</div>
				<div>
					<span>extension</span>
					<div>$extensionEdit</div>
				</div>
				<div>
					<span>Type de voie</span>
					<div>$type_voieEdit</div>
				</div>
				<div>
					<span>Nom de voie</span>
					<div>$voieEdit</div>
				</div>
				<div>
					<span>Complément d'adresse</span>
					<div>$complementAdresseEdit </div>
				</div>
				<div>
					<span>Pays</span>
					<div>$paysEdit</div>
				</div>
				<div>
					<span>Code postal</span>
					<div>$codePostalEdit </div>
				</div>
				<div>
					<span>Ville</span>
					<div>$villeEdit</div>
				</div>

				<div class='subtitle'>
					<div>Situation professionelle</div>
				</div>
				<div>
					<span>Catégorie professionelle n1</span>
					<div>$categorie_professionelle_code_1</div>
				</div>
				<div>
					<span>Catégorie professionelle n2</span>
					<div>$categorie_professionelle_code_2</div>
				</div>
				<div>
					<span>Code NAF</span>
					<div>
						$code_naf
						<span style='margin-left:10px;cursor:pointer;text-decoration:underline;color: #0e6dbb;font-size: 14px;' @click='openHelper()'>(Ouvir l'assistant code NAF)</span>
					</div>
				</div>
				<div>
					<span>Année prévisionelle de départ à la retraite</span>
					<div>$depart_retraite</div>
				</div>
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
		return ("
			Vue.component(
				'$componentName',
				{
					data: function() {
						return ({codeList: {}, codeList2: {}});
					},
					props: [ 'data' ],
					computed: {
						selectedPp: function() {
							return (this.\$store.getters.getSelectedPersonnePhysique);
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
					methods: {
						close: function() {
							this.\$store.commit('modal_stack_pop');
						},
						save: function() {
							var that = this;
							if (this.selectedPp.id.value == 0)
								this.selectedPp.lien_dh.value = this.\$store.getters.getSelectedDonneurDOrdre.id.value;
							this.\$store.dispatch('write_selected_PersonnePhysique').then(function(elm) {
								that.\$store.dispatch('modal_stack_pop');
							});
						},
						openHelper: function() {
							this.\$store.commit('modal_stack_push', {
								tag: 'component-naf-helper-noname',
								config: {
									props: {
										data: this.data
									},
								},
								notClose: true
							});
						}
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
					},
					template: '#$templateId'
				}
			);
		");
	}
}
