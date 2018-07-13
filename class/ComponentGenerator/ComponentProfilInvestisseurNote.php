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

class ComponentProfilInvestisseurNote extends ComponentGenerator {

	protected static $_dependances = [
		"ComponentInputCheckboxMscpi" => ["noname" => []]
	];
	protected static $_componentName = "component-profil-investisseur-note";

	private function __construct() { }

	private function __destruct() {}

	// on pourra utiliser config pour redéfinir le component d'edition à utiliser dans un cas ou dans l'autre pour certains component
	protected static function getTemplate($class, $config) {
		$componentClassName = static::getClassName($class);
		$componentName = get_called_class();

		$rt = " <div class='$componentClassName $componentName component'>";
		if (SHOW_FRAME)
			$rt .= "<span class='debugMsg'>$componentClassName</span>";

		$resultat_questionnaire = ProfilInvestisseur2::getComponentConfigured('resultat_questionnaire');

		$rt .= "
			<div :style='{color: getProfil.color}' v-if='typeof getProfil != \"undefined\"'>
				<span style='font-weight:bold; font-size: 42px;'>{{ getProfil.niveau}}</span> <br />
				<span>Voici votre résultat : $resultat_questionnaire / 20</span><br />
				<span>{{ getProfil.description }}</span>
			</div>
			<br />
			<div v-if='this.selectedProfilInvestisseur.resultat_questionnaire.value < 10'>
				<div>N’hésitez pas à relire le guide de la SCPI pour parfaire vos connaissances.</div>
				<div>
					<component-input-checkbox-mscpi-noname 
						:data='formulaire.btn1'
						label='Si vous estimez que vous avez une expérience suffisante dans l’investissement de parts de SCPI, merci de bien vouloir cocher cette case. Toutefois MeilleureSCPI.com vous met en garde sur le fait que ce produit pourrait ne pas être adapté à votre profil.'
						>
					</component-input-checkbox-mscpi-noname>
				</div>
				<div>Vous avez noté que :</div>
				<div>
					<component-input-checkbox-mscpi-noname
						:data='formulaire.btn2'
						label='L’investissement en parts de SCPI s’inscrit dans le cadre d’un investissement long terme.En SCPI, le capital n’est pas garanti et les performances passées ne préjugent en rien des performances futures.'
					>
					</component-input-checkbox-mscpi-noname>
				</div>
				<div id='msgAlertSending'>Veuillez cocher les cases ci dessus pour passer à la suite.</div>
			</div>
			<div>
				<button
					@click='next()'
					class='btn-mscpi'
				>
					PASSER A L'ÉTAPE SUIVANTE
				</button>
			</div>
		";
		$rt .= "</div> ";
		return ($rt);
	}

	protected static function getComponent($class, $config) {
		$componentName = static::getComponentName($class);
		$templateId = static::getTemplateId($class);

		$list = json_encode(ProfilInvestisseur2::$_typeProfil);

		return ("
			Vue.component(
				'$componentName',
				{
					data: function() {
						return ({
							formulaire: {
								btn1: {value: null},
								btn2: {value: null},

							},
							list: $list
						});
					},
					computed: {
						selectedProfilInvestisseur: function() {
							return (this.\$store.getters.getSelectedProfilInvestisseur2);
						},
						selectedPp: function() {
							return (this.\$store.getters.getSelectedPersonnePhysique);
						},
						selectedSituation: function() {
							return (this.\$store.getters.getSelectedSituationPhysique);
						},
						selectedProjet: function() {
							return (this.\$store.getters.getSelectedProjet2);
						},
						isValid: function() {
							return (true);
						},
						getProfil: function() {
							var note = this.selectedProfilInvestisseur.resultat_questionnaire.value
							return (this.list.find(function(elm) {
								return (elm.min < note && elm.max > note);
							}));
						}
					},
					methods: {
						next: function(dat) {
							this.\$store.dispatch('projet2NextStep', this.formulaire);
						},
					},
					template: '#$templateId',
					created: function() {
						this.\$on('next', this.next);
					},
				}
			);
		");
	}
}
