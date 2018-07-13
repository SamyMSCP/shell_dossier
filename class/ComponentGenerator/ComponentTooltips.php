<?php

class ComponentTooltips extends ComponentGenerator {

	protected static $_dependances = [];
	protected static $_componentName = "component-tooltips";

	private function __construct() { }

	private function __destruct() {}

	// on pourra utiliser config pour redéfinir le component d'edition à utiliser dans un cas ou dans l'autre pour certains component
	protected static function getTemplate($class, $config) {
		$componentClassName = static::getClassName($class);
		$componentName = get_called_class();

		$rt = " <div class='$componentClassName $componentName component'>";
		if (SHOW_FRAME)
			$rt .= "<span class='debugMsg'>$componentClassName</span>";

		$rt .= "
			<img src='assets/i_BleuClair.png' @mouseenter='show = true' @mouseout='show = false'>
			<div class='tootipsMsg' :style='{display: show ? \"block\" : \"none\"}'>
				<h4>{{ title }}</h4>
				<p v-html='content'></p>
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
							show: false
						})
					},
					methods: {
						test: function() {
							this.show = true;
						}
					},
					props: ['title', 'content'],
					template: '#$templateId'
				}
			);
		");
	}
}

