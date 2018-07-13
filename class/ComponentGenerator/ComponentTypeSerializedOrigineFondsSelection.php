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

class ComponentTypeSerializedOrigineFondsSelection extends ComponentGenerator {

	protected static $_dependances = [
		"ComponentInputCheckboxToogleMscpiBlock" => ["noname" => []],
	];
	protected static $_componentName = "component-type-serialized-origine-fonds-selection";

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
			<div class='new_style_container'>
				<component-input-checkbox-toogle-mscpi-block-noname 
					class='big'
					v-for='(elm, key) in data.value'
					v-model='elm.enabled'
					:label='key'
					:key='key'
					v-if='(typeof showcredit != \"undefined\" && showcredit == true) || key != \"Crédit\"'
					>
				</component-input-checkbox-toogle-mscpi-block-noname>
			</div>
		";
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
					props: [ 'data', 'showcredit'],
					methods: {
						setValue: function() {
							this.\$emit('input', this.value);
						},
					},
					data: function() {
						return ({
							value: {
								'Crédit' : {
									value:0,
									enabled: false
								},
								'Épargne' : {
									value:0,
									enabled: false
								},
								'Cession d’actifs immobiliers' : {
									value:0,
									enabled: false
								},
								'Héritage (successions)' : {
									value:0,
									enabled: false
								},
								'Réemploi de fonds propres' : {
									value:0,
									enabled: false
								},
								'Donation' : {
									value:0,
									enabled: false
								},
								'Réemploi de fonds démembrés' : {
									value:0,
									enabled: false
								},
								'Cessions d’actifs mobiliers' : {
									value:0,
									enabled: false
								},
								'Autre' : {
									value:0,
									precision: ''
								}
							}
						});
					},
					watch: {
						data: function(val) {
							if (typeof this.data.value != 'object' || this.data.value == null) {
								this.data.value = this.value;
								return ;
							}
							for (key in this.value) {
								if (typeof this.data.value[key] == 'undefined')
									this.data.value[key] = this.value[key];
							}
							if (typeof this.data.value['Autre'].precision == 'undefined')
								this.data.value['Autre'].precision = ' ';
						}
					},
					template: '#$templateId'
				}
			);
		");
	}
}
