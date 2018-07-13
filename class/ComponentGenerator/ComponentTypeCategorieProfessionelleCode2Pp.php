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

class ComponentTypeCategorieProfessionelleCode2Pp extends ComponentGenerator {

	protected static $_dependances = [];
	protected static $_componentName = "component-type-categorie-professionelle-code-2-pp";

	private function __construct() { }

	private function __destruct() {}

	// on pourra utiliser config pour redéfinir le component d'edition à utiliser dans un cas ou dans l'autre pour certains component
	protected static function getTemplate($class, $config) {
		$componentClassName = static::getClassName($class);


		$rt = "<div class='$componentClassName component' :class='{errorInput: typeof data.error != \"undefined\"}' >";
		if (SHOW_FRAME)
			$rt .= "<div class='debugMsg' >$componentClassName</div>";
		$rt .="<select v-model='data.value'>";
			$rt .= "<option v-for='(elm, key) in toShow' :value='elm.code_2'>{{ elm.libelle_2 }}</option>";
		$rt .= "</select>";
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

		$list = json_encode(CategorieProfessionelle::getFromRequest("SELECT code_1, code_2, libelle_2 FROM `categorie_professionelle`", []));

		return ("
			Vue.component(
				'$componentName',
				{
					computed: {
						selectedPp: function() {
							return (this.\$store.getters.getSelectedPersonnePhysique);
						},
						toShow: function() {
							var that = this;
							var code = (typeof that.code1 != 'undefined') ? that.code1.value : that.selectedPp.categorie_professionelle_code_1.value;
							return (this.list.filter(function(elm) {
								return (elm.code_1 == code);
							}));
						}
					},
					data: function() {
						return ({list: $list});
					},
					props: [ 'data', 'code1'],
					template: '#$templateId'
				}
			);
		");
	}
}
