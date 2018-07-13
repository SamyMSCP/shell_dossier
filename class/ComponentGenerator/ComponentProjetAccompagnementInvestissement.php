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

class ComponentProjetAccompagnementInvestissement extends ComponentGenerator {

	protected static $_dependances = [
		"ComponentInputCheckboxMscpi" => ["noname" => []]
	];
	protected static $_componentName = "component-projet-accompagnementinvestissement";

	private function __construct() { }

	private function __destruct() {}

	// on pourra utiliser config pour redéfinir le component d'edition à utiliser dans un cas ou dans l'autre pour certains component
	protected static function getTemplate($class, $config) {
		$componentClassName = static::getClassName($class);
		$componentName = static::getComponentName($class);

		$rt = " <div class='$componentClassName $componentName component'>";
		if (SHOW_FRAME)
			$rt .= "<span class='debugMsg'>$componentClassName</span>";

		$accompagne_investissement = Projet2::getEditComponentConfigured("accompagne_investissement", [":data" => "\$store.getters.getSelectedProjet2.accompagne_investissement"]);
		$rt .= "
			<component-project-mini-progress-bar-noname position='6' size='6'> </component-project-mini-progress-bar-noname>
			<div class='form_inline'>
				Souhaitez vous être accompagné(e) pour votre financement ?
			</div>
			$accompagne_investissement
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
					computed: {
						selectedProjet: function() {
							return (this.\$store.getters.getSelectedProjet2);
						},
						statut: function() {
							return (this.\$store.getters.getSelectedProjet2.statut_parcour_client.value);
						},
						storeDatas: function() {
							return (this.\$store.state.mscpi.modules.StoreModuleProcessProjet.Blocks.ProjetAccompagnementInvestissement);
						},
						isValid: function() {
							if (
								this.selectedProjet.accompagne_investissement.value !== 0 &&
								this.selectedProjet.accompagne_investissement.value !== 1
							)
								return (false);
							return (true);
						},
					},
					watch: {
						isValid: function(val) {
							this.\$parent.\$emit('isValid', val);
						},
						statut: function(val) {
							if (val == 'ProjetAccompagnementInvestissement')
								this.\$parent.\$emit('setMasquer', false);
							else
								this.\$parent.\$emit('setMasquer', true);
						}
					},
					methods: {
						previous: function(dat) {
							this.\$store.dispatch('projet2PreviousStep', this.selectedProjet);
						},
						next: function(dat) {
							this.\$store.dispatch('projet2NextStep', this.selectedProjet);
						},
						set: function(dat) {
							this.\$store.dispatch('projet2SetBlock', {
								datas: this.selectedProjet,
								name : 'ProjetAccompagnementInvestissement'
							});
						}
					},
					template: '#$templateId',
					created: function() {
						this.\$parent.\$emit('isValid', this.isValid);
						this.\$on('set', this.set);
						this.\$on('next', this.next);
						this.\$on('previous', this.previous);
						this.\$parent.title = this.getTitle;

						if (this.statut == 'ProjetAccompagnementInvestissement')
							this.\$parent.\$emit('setMasquer', false);
						else
							this.\$parent.\$emit('setMasquer', true);
						this.\$parent.masquer = false;
					},
					mounted: function() {
						this.\$parent.masquer = false;
					}
				}
			);
		");
	}

}
