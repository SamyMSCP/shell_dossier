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

class ComponentProjetOrigineFondsSelection extends ComponentGenerator {
	protected static $_dependances = [
		"ComponentTypeSerializedOrigineFondsSelection" => ["noname" => []]
	];
	protected static $_componentName = "component-projet-originefonds-selection";

	private function __construct() { 
	}

	private function __destruct() {}

	protected static function getTemplate($class, $config) {
		$componentClassName = static::getClassName($class);
		$componentName = static::getComponentName($class);

		$rt = " <div class='$componentClassName $componentName component'>";
		if (SHOW_FRAME)
			$rt .= "<span class='debugMsg'>$componentClassName</span>";

		$comp = ComponentTypeSerializedOrigineFondsSelection::getHtmlTag('noname', [":data" => 'selectedProjet.origine']);
		$rt .= " 
			<component-project-mini-progress-bar-noname position='4' size='6'> </component-project-mini-progress-bar-noname>
			<div class='form_inline'>
				Quelle est l'origine des fonds pour cet investissement ?
			</div>
			$comp
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
						storeDatas: function() {
							return (this.\$store.state.mscpi.modules.StoreModuleProcessProjet.Blocks.ProjetAccompagnementInvestissement);
						},
						isValid: function() {
							if (typeof this.selectedProjet.origine == 'undefined')
								return (false);
							for (key in this.selectedProjet.origine.value) {
								if (this.selectedProjet.credit.value != true && key == 'Crédit')
									continue ;
								if (this.selectedProjet.origine.value[key].enabled)
									return (true);
							}
							return (false);
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
								name: 'ProjetOrigineFondsSelection'
							}).then(
								function() {
								},
								function() {
								}
							);

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
