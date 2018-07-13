<?php
class ComponentInputCheckboxToogleMscpi extends ComponentGenerator {

	protected static $_dependances = [];
	protected static $_componentName = "component-input-checkbox-toogle-mscpi";

	private function __construct() { }

	private function __destruct() {}

	// on pourra utiliser config pour redéfinir le component d'edition à utiliser dans un cas ou dans l'autre pour certains component
	protected static function getTemplate($class, $config) {
		$componentClassName = static::getClassName($class);
		$componentName = get_called_class();
		return ("
			<div class='$componentClassName $componentName'>
				<div class='btn' :class='{checked: preparedValue === true}'  @click='setValue()'></div>
				<div class='label' @click='setValue()'>{{ label }}</div>
			</div>
		");
	}

	protected static function getComponent($class, $config) {
		$componentName = static::getComponentName($class);
		$templateId = static::getTemplateId($class);

		return ("
			Vue.component(
				'$componentName',
				{
					props: [ 'value', 'label', 'reverse'],
					computed: {
						preparedValue: function() {
							if (this.value !== true && this.value !== false)
								return (-1);
							if (typeof this.reverse == 'undefined' || this.reverse == false)
								return (this.value === true);
							else
								return (this.value === false);
						}
					},
					methods: {
						setValue: function() {
							if (typeof this.reverse == 'undefined')
								this.\$emit('input', !this.value);
							else if (this.reverse == false)
								this.\$emit('input', true);
							else if (this.reverse == true)
								this.\$emit('input', false);
						}
					},
					template: '#$templateId'
				}
			);
		");
	}
}
