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

class ComponentProfilInvestisseurQuizScpi extends ComponentGenerator {

	protected static $_dependances = [
		"ComponentInputCheckboxMscpi" => ["noname" => []]
	];
	protected static $_componentName = "component-profil-investisseur-quiz-scpi";

	private function __construct() { }

	private function __destruct() {}

	// on pourra utiliser config pour redéfinir le component d'edition à utiliser dans un cas ou dans l'autre pour certains component
	protected static function getTemplate($class, $config) {
		$componentClassName = static::getClassName($class);
		$componentName = static::getComponentName($class);

		$rt = " <div class='$componentClassName $componentName component'>";
		if (SHOW_FRAME)
			$rt .= "<span class='debugMsg'>$componentClassName</span>";

		$quiz = ProfilInvestisseur2::getComponentConfigured('quiz');

		$rt .= "
			<component-project-mini-progress-bar-noname :position='getPosition()' size='13'> </component-project-mini-progress-bar-noname>
			$quiz
		";
		$rt .= "</div> ";
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
						return ({
							position: 0
						});
					},
					computed: {
						selectedProfilInvestisseur: function() {
							return (this.\$store.getters.getSelectedProfilInvestisseur2);
						},
						getId: function() {
							return (this.selectedProfilInvestisseur.id.value);
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
						storeDatas: function() {
							return (this.\$store.state.mscpi.modules.StoreModuleProcessProjet.Blocks.ProjetJuridiquePersonnePhysique1);
						},
						isValid: function() {
							return (true);
						},
						statut_parcour_client: function() {
							return (this.selectedProjet.statut_parcour_client.value);
						},
					},
					watch: {
						getId: function(val) {
							this.mode = 0;
						},
						isValid: function(val) {
							this.\$parent.\$emit('isValid', val);
						},
						statut_parcour_client: function(val) {
							this.setPositionChildren(0);
						}
					},
					methods: {
						setPositionChildren(val) {
							this.\$children[1]._data.mode = val;
						},
						getPosition: function() {
							if (typeof this.\$children[1] != 'undefined') 
								this.position =  this.\$children[1]._data.mode + 1;
							else 
								this.position = 0;
							return this.position;
						},
						previous: function(dat) {
							if (typeof this.\$children[1] != 'undefined' && this.\$children[1].previous())
								this.\$store.dispatch('projet2PreviousStep', this.selectedProfilInvestisseur);
						},
						next: function(dat) {
							this.getPosition();
							if (this.\$children[1] == 'undefined')
								return ;
							if (this.\$children[1].next()) {
								this.setPositionChildren(0);
								this.\$store.dispatch('projet2NextStep', this.selectedProfilInvestisseur);
							}
						},
						set: function(dat) {
							this.\$store.dispatch('projet2SetBlock', this.selectedProfilInvestisseur);
						}
					},
					template: '#$templateId',
					created: function() {
						this.\$parent.\$emit('isValid', true);
						this.\$on('set', this.set);
						this.\$on('next', this.next);
						this.\$on('previous', this.previous);
						this.\$parent.title = this.getTitle;
						this.\$parent.masquer = false;
						this.getPosition();
					},
					mounted: function() {
						this.getPosition();
						this.\$parent.masquer = false;
					}
				}
			);
		");
	}

}
