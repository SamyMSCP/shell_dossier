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

class ComponentTypeCategorieProfessionelleCode1 extends ComponentGenerator {

	protected static $_dependances = [];
	protected static $_componentName = "component-type-categorie-professionelle-code-1";

	private function __construct() { }

	private function __destruct() {}

	// on pourra utiliser config pour redéfinir le component d'edition à utiliser dans un cas ou dans l'autre pour certains component
	protected static function getTemplate($class, $config) {
		$componentClassName = static::getClassName($class);


		$rt = "<div class='$componentClassName component' :class='{errorInput: typeof data.error != \"undefined\"}' >";
		if (SHOW_FRAME)
			$rt .= "<div class='debugMsg' >$componentClassName</div>";
		$rt .="<select v-model='data.value' @change='resetCode2'>";
			$rt .= "<option :value='null'></option>";
			$rt .= "<option v-for='(elm, key) in list' :value='elm.code_1'>{{ elm.libelle_1 }}</option>";
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

		$list = json_encode(CategorieProfessionelle::getFromRequest("SELECT DISTINCT code_1, libelle_1 FROM `categorie_professionelle`", []));

		return ("
			Vue.component(
				'$componentName',
				{
					methods: {
						resetCode2: function() {
							this.code2.value = null;
						}
					},
					data: function() {
						return ({list: $list});
					},
					props: [ 'data', 'code2'],
					template: '#$templateId'
				}
			);
		");
	}
}
