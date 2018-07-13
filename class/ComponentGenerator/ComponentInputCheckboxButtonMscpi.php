<?php

class ComponentInputCheckboxButtonMscpi extends ComponentGenerator {

	protected static $_dependances = [];
	protected static $_componentName = "component-input-checkbox-button-mscpi";

	private function __construct() { }

	private function __destruct() {}

	// on pourra utiliser config pour redéfinir le component d'edition à utiliser dans un cas ou dans l'autre pour certains component
	protected static function getTemplate($class, $config) {
		$componentClassName = static::getClassName($class);
		$componentName = get_called_class();

		$rt = "<div class='$componentClassName component in_container' :class='{selected: value === checker, disabled: isDisabled}' @click='setValue()'>";
		if (SHOW_FRAME)
			$rt .= "<div class='debugMsg' >$componentClassName</div>";
		$rt .= " {{ label }} ";
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
						},
						isDisabled: function() {
							return (typeof this.disabled != 'undefined' && this.disabled == true);
						}
					},
					methods: {
						setValue: function() {
							if (!this.isDisabled)
								this.\$emit('input', this.checker);
						}
					},
					template: '#$templateId'
				}
			);
		");
	}
}

