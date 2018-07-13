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

class ComponentProjetOrigineFonds extends ComponentGenerator {
protected static $_dependances = [
		"ComponentInputCheckboxMscpi" => ["noname" => []]
	];
	protected static $_componentName = "component-projet-originefonds";

	private function __construct() { }

	private function __destruct() {}

	// on pourra utiliser config pour redéfinir le component d'edition à utiliser dans un cas ou dans l'autre pour certains component
	protected static function getTemplate($class, $config) {
		$componentClassName = static::getClassName($class);
		$componentName = static::getComponentName($class);

		$rt = " <div class='$componentClassName $componentName component'>";
		if (SHOW_FRAME)
			$rt .= "<span class='debugMsg'>$componentClassName</span>";

		$origine = Projet2::getEditComponentConfigured("origine", [":data" => "\$store.getters.getSelectedProjet2.origine"]);
		$rt .= "
			<component-project-mini-progress-bar-noname position='5' size='6'> </component-project-mini-progress-bar-noname>
			$origine";
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
						storeDatas: function() {
							return (this.\$store.state.mscpi.modules.StoreModuleProcessProjet.Blocks.ProjetAccompagnementInvestissement);
						},
						isValid: function() {
							if (typeof this.selectedProjet.origine == 'undefined')
								return (false);
							if (this.selectedProjet.origine.value.Autre.value != 0 && 
								(
									this.selectedProjet.origine.value.Autre.precision == null ||
									this.selectedProjet.origine.value.Autre.precision.length <= 2
								)
							)
								return (false);
							for (key in this.selectedProjet.origine.value) {
								if (!this.selectedProjet.origine.value[key]['enabled'])
									continue ;
								if (this.selectedProjet.origine.value[key].enabled && this.selectedProjet.origine.value[key].value <= 0)
									return (false);
							}
							return (this.getTotal > 99.9 && this.getTotal < 100.1);
						},
						getTotal: function() {
							var rt = 0;
							var tmp = [
								'Crédit',
								'Épargne',
								'Cession d’actifs immobiliers',
								'Héritage (successions)',
								'Réemploi de fonds propres',
								'Donation',
								'Réemploi de fonds démembrés',
								'Cessions d’actifs mobiliers',
								'Autre',
							];
							for (dt in tmp) {
								if (!this.selectedProjet.origine.value[tmp[dt]]['enabled'])
									continue ;
								var val = parseFloat(this.selectedProjet.origine.value[tmp[dt]]['value']);
								if (!isNaN(val))
									rt += val;
							}
							return (rt);
						},
					},
					watch: {
						isValid: function(val) {
							this.\$parent.\$emit('isValid', val);
						},
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
								name: 'ProjetOrigineFonds'
							})
						}
					},
					template: '#$templateId',
					created: function() {
						this.\$parent.\$emit('isValid', this.isValid);
						this.\$on('set', this.set);
						this.\$on('next', this.next);
						this.\$on('previous', this.previous);
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
