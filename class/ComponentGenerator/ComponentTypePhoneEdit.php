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

class ComponentTypePhoneEdit extends ComponentGenerator {

	protected static $_dependances = [];
	protected static $_componentName = "component-type-phone-edit";

	private function __construct() { }

	private function __destruct() {}

	// on pourra utiliser config pour redéfinir le component d'edition à utiliser dans un cas ou dans l'autre pour certains component
	protected static function getTemplate($class, $config) {
		$componentClassName = static::getClassName($class);
		$componentName = get_called_class();

		$rt = "<div class='$componentClassName $componentName component' :class='{errorInput: typeof data.error != \"undefined\"}' >";
		if (SHOW_FRAME)
			$rt .= "<div class='debugMsg' >$componentClassName</div>";
		//$rt .= "{{ data }}";
		//$rt .= "<input type='text' v-model='data.value' :placeholder='placeholder'/>";
		$rt .= "
			<input
				:id='\"phone_nbr_\" + linkid'
				name='num'
				type='text'
				class='form-control bfh-phone'
				:data-country='\"countries_phone_\" + linkid'
				v-model='data.value'
				>
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
					props: [ 'data', 'placeholder', 'linkid' ],
					template: '#$templateId',
					methods: {
						mountMe: function() {
							$('#phone_nbr_' + this.linkid).each(function () {
								var phone;
								phone = $(this);
								console.log(this);
								phone.bfhphone(phone.data());
							});
						}
					},
					created: function() {
						this.mountMe();
					},
					mounted: function() {
						this.mountMe();
					}
				}
			);
		");
	}

}
