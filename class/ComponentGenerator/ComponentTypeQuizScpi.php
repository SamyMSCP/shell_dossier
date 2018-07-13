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

class ComponentTypeQuizScpiEdit extends ComponentGenerator {

	protected static $_dependances = [
		"ComponentInputCheckboxMscpi" => ["noname" => []]
	];
	protected static $_componentName = "component-type-enum-checkbox-edit";

	private function __construct() { }

	private function __destruct() {}

	// on pourra utiliser config pour redéfinir le component d'edition à utiliser dans un cas ou dans l'autre pour certains component
	protected static function getTemplate($class, $config) {
		$componentClassName = static::getClassName($class);
		$componentName = get_called_class();

		$rt = "<div class='$componentClassName $componentName component' :class='{errorInput: typeof data.error != \"undefined\"}' >";
		if (SHOW_FRAME)
			$rt .= "<div class='debugMsg' >$componentClassName</div>";

		$rt .= "
			<div class='simpleForm simpleForm2'>
				<div v-for='(elm, key, index) in list'>
					<span>
						{{ key }} 
						<component-tooltips-noname 
							v-if='typeof tooltips != \"undefined\" && typeof tooltips[index] != \"undefined\"'
							:title='tooltips[index].title' 
							:content='tooltips[index].content'
							>
						</component-tooltips-noname>
					</span>
					<component-input-checkbox-mscpi-noname v-model='data.value' :checker='elm' label=''></component-input-checkbox-mscpi-noname>
				</div>
			</div>
		";
		$rt .= "<div class='errorMsg' v-if='typeof data.error != \"undefined\"' >{{ data.error }}</div>";
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
					props: [ 'data' , 'list', 'tooltips'],
					template: '#$templateId'
				}
			);
		");
	}
}
