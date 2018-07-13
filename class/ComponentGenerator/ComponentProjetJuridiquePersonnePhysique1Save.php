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

class ComponentProjetJuridiquePersonnePhysique1Save extends ComponentGenerator {

	protected static $_dependances = [
		"ComponentInputCheckboxMscpi" => ["noname" => []]
	];
	protected static $_componentName = "component-projet-juridiquepersonnephysique1-save";

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
		$nomEdit							= PersonnePhysique::getComponentConfigured('nom', [':data' => "selectedPp.nom"]);
		$prenomEdit							= PersonnePhysique::getComponentConfigured('prenom', [':data' => "selectedPp.prenom"]);
		$nationaliteEdit 					= PersonnePhysique::getComponentConfigured('nationalite', [':data' => "selectedPp.nationalite"]);
		$date_de_nEdit						= PersonnePhysique::getComponentConfigured('date_de_n', [':data' => "selectedPp.date_de_n"]);
		$pays_de_naissanceEdit 				= PersonnePhysique::getComponentConfigured('pays_de_naissance', [':data' => "selectedPp.pays_de_naissance"]);
		$code_naissanceEdit 				= PersonnePhysique::getComponentConfigured('code_naissance', [':data' => "selectedPp.code_naissance", "list" => "codePostalList2"]);
		$lieu_de_nEdit						= PersonnePhysique::getComponentConfigured('lieu_de_n', [':data' => "selectedPp.lieu_de_n", "list" => "codePostalList2"]);
		$numeroRueEdit						= PersonnePhysique::getComponentConfigured('numeroRue', [':data' => "selectedPp.numeroRue"]);

		$extensionEdit						= PersonnePhysique::getComponentConfigured('extension', [':data' => "selectedPp.extension"]);
		$type_voieEdit						= PersonnePhysique::getComponentConfigured('type_voie', [':data' => "selectedPp.type_voie"]);
		$voieEdit							= PersonnePhysique::getComponentConfigured('voie', [':data' => "selectedPp.voie"]);
		$complementAdresseEdit 				= PersonnePhysique::getComponentConfigured('complementAdresse', [':data' => "selectedPp.complementAdresse"]);
		$paysEdit							= PersonnePhysique::getComponentConfigured('pays', [':data' => "selectedPp.pays"]);
		$codePostalEdit 					= PersonnePhysique::getComponentConfigured('codePostal', [':data' => "selectedPp.codePostal", "list" => "codePostalList1"]);
		$villeEdit							= PersonnePhysique::getComponentConfigured('ville', [':data' => "selectedPp.ville", "list" => "codePostalList1"]);
		$categorie_professionelle_code_1	= PersonnePhysique::getComponentConfigured('categorie_professionelle_code_1', [
			':data' => "selectedPp.categorie_professionelle_code_1",
			':code2' => "selectedPp.categorie_professionelle_code_2",
		]);
		$categorie_professionelle_code_2	= PersonnePhysique::getComponentConfigured('categorie_professionelle_code_2', [
			':data' => "selectedPp.categorie_professionelle_code_2",
			':code1' => "selectedPp.categorie_professionelle_code_1",
		]);

		$code_naf							= PersonnePhysique::getComponentConfigured('code_naf', [':data' => "selectedPp.code_naf"]);
		$depart_retraite					= PersonnePhysique::getComponentConfigured('ville', [':data' => "selectedPp.depart_retraite"]);
		$us_personEdit						= PersonnePhysique::getComponentConfigured('us_person', [':data' => "selectedPp.us_person"]);
		$politiquement_exposeEdit			= PersonnePhysique::getComponentConfigured('politiquement_expose', [':data' => "selectedPp.politiquement_expose"]);
		$element_particulier				= PersonnePhysique::getComponentConfigured('element_particulier', [':data' => "selectedPp.element_particulier"]);

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
					<div>VOTRE IDENTITÉ</div>
				</div>
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
					<span>Nationalité</span>
					$nationaliteEdit
				</div>
				<div>
					<span>Date de naissance</span>
					$date_de_nEdit
				</div>
				<div>
					<span>Pays de naissance</span>
					$pays_de_naissanceEdit
				</div>
				<div>
					<span>Lieu de naissance</span>
					$lieu_de_nEdit
				</div>
				<div>
					<span>Code postal de naissance</span>
					$code_naissanceEdit
				</div>
				<div class='subtitle'>
					<div>VOS COORDONNÉES</div>
				</div>
				<div>
					<span>N° de rue</span>
					$numeroRueEdit
				</div>
				<div>
					<span>Extension</span>
					$extensionEdit
				</div>
				<div>
					<span>Type de voie</span>
					$type_voieEdit
				</div>
				<div>
					<span>Voie</span>
					$voieEdit
				</div>
				<div>
					<span>Complément d'adresse</span>
					$complementAdresseEdit
				</div>
				<div>
					<span>Pays</span>
					$paysEdit
				</div>
				<div>
					<span>Code postal</span>
					$codePostalEdit
				</div>
				<div>
					<span>Ville</span>
					$villeEdit
				</div>

				<div class='subtitle'>
					<div>VOTRE SITUATION PROFESSIONELLE</div>
				</div>
				<div>
					<span>Catégorie professionelle n1</span>
					$categorie_professionelle_code_1
				</div>
				<div v-if='selectedPp.categorie_professionelle_code_1.value != null'>
					<span>Catégorie professionelle n3</span>
					$categorie_professionelle_code_2
				</div>
				<div>
					<span>Code NAF</span>
					$code_naf
				</div>
				<div v-if='selectedPp.categorie_professionelle_code_1.value != 7'>
					<span>Année prévisionnelle de départ à la retraite</span>
					$depart_retraite
				</div>
				<div class='subtitle'>
					<div>INFORMATIONS COMPLÉMENTAIRES</div>
				</div>
				<div>
					<span>
						Le bénéficiaire ({{ selectedPp.shortName.value }}) est-il une US Person ?
						<component-tooltips-noname title='US Person' content=
							\"La définition des US persons se trouve dans la réglementation<br />
								américaine « Regulation S » (US Securities Act de 1933).<br />
								Elle s’intègre dans un dispositif visant à renforcer la <br />
								transparence fiscale internationale et qui a été renforcé <br />
								par la législation FATCA (Foreign Account Tax Compliance Act)<br />
								en 2014.\"
						></component-tooltips-noname>
					</span>
					$us_personEdit
				</div>
				<div>
					<span>
						Le bénéficiaire ({{ selectedPp.shortName.value }}) est-il politiquement exposée ?
						<component-tooltips-noname title='Personne politiquement exposée' content=
						\"<p>Les personnes politiquement exposées sont des personnes <br />
							physiques qui occupent ou ont occupé des fonctions publiques <br />
							importantes, pas nécessairement politiques, liées à un pouvoir de <br />
							décision significatif. Les personnes considérées comme des <br />
							personnes connues pour être étroitement associées à un client PPE <br />
							sont également incluses (membres de la famille et entourage).<br />
							Les fonctions des PPE sont listées à l'article R.561-18-I du code <br />
							monétaire et financier, elle intègre notamment :</p>
							<ul style='text-align:left;'>
								<li>Chef d'Etat, chef de gouvernement, membre d'un <br />
									gouvernement national ou de la Commission européenne ;</li>
								<li>Membre d'une assemblée parlementaire nationale ou du <br />
									Parlement européen ;</li>
								<li>Membre d'une cour suprême, d'une cour constitutionnelle <br />
									ou d'une autre haute juridiction dont les décisions ne sont <br />
									pas, sauf circonstances exceptionnelles, susceptibles de <br />
									recours;</li>
								<li>Membre d'une cour des comptes ;</li>
								<li>Dirigeant ou membre de l'organe de direction d'une banque <br />
									centrale;</li>
								<li>Ambassadeur, chargé d'affaires, consul général et consul de <br />
									carrière ;</li>
								<li>Officier général ou officier supérieur assurant le <br />
									commandement d'une armée ;</li>
								<li>Membre d'un organe d'administration, de direction ou de <br />
									surveillance d'une entreprise publique ;</li>
								<li>Dirigeant d'une institution internationale publique créée <br />
									par un traité.</li>
							</ul>\"
						></component-tooltips-noname>
					</span>
					$politiquement_exposeEdit
				</div>
				<div >
					<span>Avez-vous des éléments particuliers à préciser ?</span>
					$element_particulier
				</div>

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
						getSize: function() {
							if (this.listPersonnePhysique == null)
								return (2);
							if (this.listPersonnePhysique.length > 1)
								return (3);
							return (2);
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
