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

class ComponentTypeGerantEdit extends ComponentGenerator {

	protected static $_dependances = [];
	protected static $_componentName = "component-type-gerant--edit";

	private function __construct() { }

	private function __destruct() {}

	// on pourra utiliser config pour redéfinir le component d'edition à utiliser dans un cas ou dans l'autre pour certains component
	protected static function getTemplate($class, $config) {
		$componentClassName = static::getClassName($class);

		$rt = "<div class='$componentClassName component' :class='{errorInput: typeof data.error != \"undefined\"}' >";
		if (SHOW_FRAME)
			$rt .= "<div class='debugMsg' >$componentClassName</div>";
		$rt .="<select v-model='data.value'>
				<option v-for='pp in getLst' :value='pp.id.value'>{{pp.shortName.value}}</option>
				<option :value='-1'>insérer une nouvelle personne physique</option>
			</select>";
		$rt .= "
			<div class='errorMsg' v-if='typeof data.error != \"undefined\"' >
				<div>
					{{ data.error }}
				</div>
			</div>";
		$rt .= "</div>";
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
						getLst: function() {
							return (this.\$store.getters.getPersonnesPhysiquesForDonneurDOrdre);
						},
						dataValue: function() {
							return(this.data.value);
						}
					},
					methods: {
						newPersonnePhysique: function(elm) {
							if (this.\$store.getters.getSelectedPersonnePhysique.id.value != 0)
								this.\$store.commit('set_new_PersonnePhysique');
							this.\$store.commit('modal_stack_push', {
								tag: 'component-edit-personnes-physiques-noname'
							});
						},
					},
					watch: {
						dataValue: function(val) {
							if (val == -1)
								this.newPersonnePhysique();
						}
					},
					created: function() {
						if (this.data.value == -1)
							this.data.value = this.\$store.getters.getSelectedPersonnePhysique.id.value;
					},
					mounted: function() {
						if (this.data.value == -1)
							this.data.value = this.\$store.getters.getSelectedPersonnePhysique.id.value;
					},
					props: [ 'data', 'placeholder' ],
					template: '#$templateId'
				}
			);
		");
	}
}
