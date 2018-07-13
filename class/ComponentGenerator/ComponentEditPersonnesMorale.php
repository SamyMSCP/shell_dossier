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

class ComponentEditPersonnesMorale extends ComponentGenerator {

	protected static $_dependances = [
		//"ComponentNafHelper" => ["noname" => []]
	];
	protected static $_componentName = "component-edit-personnes-morale";

	private function __construct() { }

	private function __destruct() { }

	// on pourra utiliser config pour redéfinir le component d'edition à utiliser dans un cas ou dans l'autre pour certains component
	protected static function getTemplate($class, $config) {
		$componentClassName = static::getClassName($class);
		$componentName = get_called_class();

		$dn_sociale							= PersonneMorale::getComponentConfigured('dn_sociale');
		$siret								= PersonneMorale::getComponentConfigured('siret');
		$f_juridique						= PersonneMorale::getComponentConfigured('f_juridique');

		$id_gerant							= PersonneMorale::getComponentConfigured('id_gerant');


		$numeroRueEdit						= PersonneMorale::getComponentConfigured('numeroRue');

		$extensionEdit						= PersonneMorale::getComponentConfigured('extension');
		$type_voieEdit						= PersonneMorale::getComponentConfigured('type_voie');
		$voieEdit							= PersonneMorale::getComponentConfigured('voie');
		$complementAdresseEdit 				= PersonneMorale::getComponentConfigured('complementAdresse');
		$paysEdit							= PersonneMorale::getComponentConfigured('pays');

		$codePostalEdit 					= PersonneMorale::getComponentConfigured('codePostal', [
			"list" => "codePostalList1"
		]);
		$villeEdit							= PersonneMorale::getComponentConfigured('ville', [
			"list" => "codePostalList1"
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
			<h2 style='margin-top:30px;margin-bottom:30px;'>Personne Morale</h2>
			<div class='traitOrange'> </div>
			<datalist id='codePostalList1'>
				<option v-for='(elm, key) in codeList'>{{ elm.Nom_commune }} / {{ elm.Code_postal }}</option>
			</datalist>
			<datalist id='codePostalList2'>
				<option v-for='(elm, key) in codeList2'>{{ elm.Nom_commune }} / {{ elm.Code_postal }}</option>
			</datalist>
			<div class='simpleForm'>

				<div>
					<span>Dénomination sociale</span>
					<div style='position:relative;'>
						$dn_sociale
					</div>
				</div>
				<div>
					<span>N° SIRET</span>
					<div style='position:relative;'>
						$siret
					</div>
				</div>
				<div>
					<span>Forme Juridique</span>
					<div style='position:relative;'>
						$f_juridique
					</div>
				</div>
				<div>
					<span>Gérant</span>
					<div style='position:relative;'>
						$id_gerant
					</div>
				</div>


				<div class='subtitle'>
					<div>Siège social</div>
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
						selectedPm: function() {
							return (this.\$store.getters.getSelectedPersonneMorale);
						},
						gVille: function() {
							return (this.selectedPm.ville.value);
						},
						gCode: function() {
							return (this.selectedPm.codePostal.value);
						},
					},
					methods: {
						close: function() {
							this.\$store.commit('modal_stack_pop');
						},
						save: function() {
							var that = this;
							if (this.selectedPm.id.value == 0)
								this.selectedPm.lien_dh.value = this.\$store.getters.getSelectedDonneurDOrdre.id.value;
							this.\$store.dispatch('write_selected_PersonneMorale').then(function(elm) {
								that.\$store.dispatch('modal_stack_pop');
							});
						},
					},
					watch: {
						gVille: function(elm) {
							if (this.selectedPm.pays.value != 'France')
								return ;
							var that = this;
							var value = String(elm).split(' / ', 2);
							if (value.length < 2)
							{
								this.\$store.dispatch('getCodeVille', {
									code: that.selectedPm.codePostal.value,
									ville: that.selectedPm.ville.value
								}).then(
									function(datas) {
										Vue.set(that, 'codeList', datas)
									},
									function() {}
								);
							} else {
								that.selectedPm.ville.value = value[0];
								that.selectedPm.codePostal.value = value[1];
							}
						},
						gCode: function(elm) {
							if (this.selectedPm.pays.value != 'France')
								return ;
							var that = this;
							var value = String(elm).split(' / ', 2);
							if (value.length < 2)
							{
								this.\$store.dispatch('getCodeVille', {
									code: that.selectedPm.codePostal.value,
									ville: that.selectedPm.ville.value
								}).then(
									function(datas) {
										Vue.set(that, 'codeList', datas)
									},
									function() {}
								);
							} else {
								that.selectedPm.ville.value = value[0];
								that.selectedPm.codePostal.value = value[1];
							}
						},
					},
					template: '#$templateId'
				}
			);
		");
	}
}
