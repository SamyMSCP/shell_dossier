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

class ComponentTypeToOneConseillerShow extends ComponentGenerator {

	protected static $_dependances = [];
	protected static $_componentName = "component-type-to-one-conseiller-show";

	private function __construct() { }

	private function __destruct() {}

	// on pourra utiliser config pour redéfinir le component d'edition à utiliser dans un cas ou dans l'autre pour certains component
	protected static function getTemplate($class, $config) {
		$componentClassName = static::getClassName($class);
		$rt = "<span class='$componentClassName component'>";
		if (SHOW_FRAME)
			$rt .= "<span class='debugMsg'>$componentClassName</span>";
		$rt .= "{{ getName(data.value) }}</span> ";
		return ($rt);
	}

	protected static function getComponent($class, $config) {
		$componentName = static::getComponentName($class);
		$templateId = static::getTemplateId($class);

		$dt = [];
		foreach (DonneurDOrdre::getFromKeyValue("type", "conseiller") as $elm)
			$dt[$elm->getId()] = $elm->getShortName();

		return ("
			Vue.component(
				'$componentName',
				{
					data: function() {
						return ({cons: " . json_encode($dt) . "});
					},
					props: [ 'data' ],
					computed: {
						getName: function() {
							return (function(id) {
								if (typeof this.cons[id] != 'undefined')
									return (this.cons[id]);
								return ('-');
							});
						}
					},
					template: '#$templateId'
				}
			);
		");
	}
}
