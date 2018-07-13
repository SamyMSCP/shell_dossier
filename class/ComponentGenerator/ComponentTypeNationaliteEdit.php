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

class ComponentTypeNationaliteEdit extends ComponentGenerator {

	protected static $_dependances = [];
	protected static $_componentName = "component-type-nationalite-edit";

	private function __construct() { }

	private function __destruct() {}

	// on pourra utiliser config pour redéfinir le component d'edition à utiliser dans un cas ou dans l'autre pour certains component
	protected static function getTemplate($class, $config) {
		$componentClassName = static::getClassName($class);

		$rt = "<div class='$componentClassName component' :class='{errorInput: typeof data.error != \"undefined\"}' >";
		if (SHOW_FRAME)
			$rt .= "<div class='debugMsg' >$componentClassName</div>";
		$rt .="<select v-model='data.value'>";

		$lst = Pays2::getAll();
		$tmp = [];
		usort($lst, function($a, $b) {
			return (strcmp($a->getNationalite()->get(), $b->getNationalite()->get()));
		});

		$rt .= "<option value='Française'>Française</option>";
		foreach ($lst as $key => $elm) {
			if (in_array($elm->getNationalite()->get(), $lst))
				continue ;
			$rt .= "<option value='{$elm->getNationalite()->get()}'>{$elm->getNationalite()->get()}</option>";
			$lst[] = $elm->getNationalite()->get();

		}
		$rt .= "";
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
		return ("
			Vue.component(
				'$componentName',
				{
					props: [ 'data' ],
					template: '#$templateId'
				}
			);
		");
	}
}
