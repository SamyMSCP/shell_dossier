<?php
class ComponentInputCheckboxToogleMscpiBlock extends ComponentGenerator {

	protected static $_dependances = [];
	protected static $_componentName = "component-input-checkbox-toogle-mscpi-block";

	private function __construct() { }

	private function __destruct() {}

	// on pourra utiliser config pour redéfinir le component d'edition à utiliser dans un cas ou dans l'autre pour certains component
	protected static function getTemplate($class, $config) {
		$componentClassName = static::getClassName($class);
		$componentName = get_called_class();
		return ("
			<div class='$componentClassName $componentName in_container' :class='{selected: preparedValue === true}'  @click='setValue()'>
				{{ label }}
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
