<?php

class ComponentInputCheckboxMscpi extends ComponentGenerator {

	protected static $_dependances = [];
	protected static $_componentName = "component-input-checkbox-mscpi";

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
			<div class='btn' :class='{checked: value === checker}'  @click='setValue()'></div>
			<div class='label'  @click='setValue()'>{{ label }}</div>
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
					props: [ 'value', 'label', 'checker', 'disabled' ],
					computed: {
						valuePrep: function() {
							return (parseInt(this.value));
						}
					},
					methods: {
						setValue: function() {
							if (typeof this.disabled != 'undefined' && this.disabled == true)
								alert('cette fonctionalité à été temporairement désactivée');
							else
								this.\$emit('input', this.checker);
						}
					},
					template: '#$templateId'
				}
			);
		");
	}
}

