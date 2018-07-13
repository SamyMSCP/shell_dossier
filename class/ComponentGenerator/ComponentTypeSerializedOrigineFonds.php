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

class ComponentTypeSerializedOrigineFonds extends ComponentGenerator {

	protected static $_dependances = [
		"ComponentInputCheckboxToogleMscpi" => ["noname" => []],
		"ComponentInputCheckboxMscpi" => ["noname" => []],
		"ComponentTypeBool2btnEdit" => ["noname" => []],
		"ComponentTypePourcentEdit" => ["TypePourcent" => []],
		"ComponentTypeEdit" => ["TypeString" => []],
	];
	protected static $_componentName = "component-type-serialized-origine-fonds";

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
			<div class='simpleForm'>
				<div>
					Souhaitez-vous faire un crédit pour votre investissement ?
				</div>
				<div style='max-width: 320px; margin-left: auto; margin-right: auto;'>
					<div style='display: flex;justify-content: space-around;'>
						<div>
							<component-input-checkbox-toogle-mscpi-noname :reverse='false' v-model='data.value.Crédit.enabled' label='Oui'></component-input-checkbox-toogle-mscpi-noname>
						</div>
						<div>
							<component-input-checkbox-toogle-mscpi-noname :reverse='true' v-model='data.value.Crédit.enabled' label='Non'></component-input-checkbox-toogle-mscpi-noname>
						</div>
					</div>
				</div>
				<div v-if='data.value.Crédit.enabled === true'>
					<div>
						Quel part représenterait ce crédit ?
					</div>
					<component-type-pourcent-edit-typepourcent class='component' :data='data.value.Crédit' ></component-type-pourcent-edit-typepourcent>
						
				</div>
				<div style='height:50px;'> </div>
				<div v-if='showOrigin'>
					Quel est l'origine des fonds pour cet investissement ?
				</div>
				<div v-for='(elm, key) in data.value' v-if='key != \"Crédit\" && showOrigin'>
					<component-input-checkbox-toogle-mscpi-noname v-model='elm.enabled' :label='key'></component-input-checkbox-toogle-mscpi-noname>
					<component-type-pourcent-edit-typepourcent :data='elm' v-if='elm.enabled'></component-type-pourcent-edit-typepourcent>
					
				</div>
				<div v-if='data.value.Autre.enabled && typeof data.value.Autre.precision != \"undefined\"'>
					<div>
						Pourriez-nous préciser ce revenu 'Autre' ?
					</div>
					<div>
						<input v-model='data.value.Autre.precision' ></input>
					</div>
				</div>
";
		$rt .= "</div>
		";
		$rt .= "
			<div class='errorMsg' v-if='typeof data.error != \"undefined\"' >
				<div>
					{{ data.error }}
				</div>
			</div>";
		$rt .= "</div>";

		/*

		*/
		return ($rt);
	}

	protected static function getComponent($class, $config) {
		$componentName = static::getComponentName($class);
		$templateId = static::getTemplateId($class);

		// TODO C"EST ICI QU"IL FAUT FAIRE QUELQUECHOSE !!!!!!!!!!!!!!!
		return ("
			Vue.component(
				'$componentName',
				{
					props: [ 'data'],
					methods: {
						setValue: function() {
							this.\$emit('input', this.value);
						},
					},
					computed: {
						showOrigin: function() {
							return (
								this.data.value.Crédit.enabled === false ||
								( this.data.value.Crédit.enabled === true && this.data.value.Crédit.value < 100)
							);
						}
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
									enabled: false,
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
