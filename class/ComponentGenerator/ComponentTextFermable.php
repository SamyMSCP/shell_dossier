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

class ComponentTextFermable extends ComponentGenerator {

	protected static $_dependances = [];
	protected static $_componentName = "component-text-fermable";

	private function __construct() { }

	private function __destruct() {}

	// on pourra utiliser config pour redéfinir le component d'edition à utiliser dans un cas ou dans l'autre pour certains component
	protected static function getTemplate($class, $config) {
		$componentClassName = static::getClassName($class);
		$componentName = get_called_class();

		$rt = "<div class='$componentClassName $componentName component' >";
		if (SHOW_FRAME)
			$rt .= "<div class='debugMsg' >$componentClassName</div>";
		$rt .= "<span v-html='getContent'></span>";
		$rt .= "
			<div v-show='showButton' @click='openIt()' class='buttonOpen'>
				...
			</div>
		";
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
					data: function() {
						return ({
							open: false
						});
					},
					methods: {
						openIt: function() {
							this.open = true;
						}
					},
					computed: {
						showButton: function() {
							return (!this.open && this.content.length >= this.size);
						},
						getContent: function() {
							if (!this.open)
								return (this.content.substring(0, this.size));
							else
								return (this.content);
						},
						getTrigger: function() {
							return (this.trigger)
						}
					},
					watch: {
						getTrigger: function() {
							this.open = false;
						}
					},
					props: [ 'data', 'content', 'size', 'trigger'],
					template: '#$templateId'
				}
			);
		");
	}

}
