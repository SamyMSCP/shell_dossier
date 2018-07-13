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

class ComponentMessageBox extends ComponentGenerator {

	protected static $_dependances = [];
	protected static $_componentName = "component-message-box";

	private function __construct() { }

	private function __destruct() {}

	// on pourra utiliser config pour redéfinir le component d'edition à utiliser dans un cas ou dans l'autre pour certains component
	protected static function getTemplate($class, $config) {
		$componentClassName = static::getClassName($class);
		$componentName = get_called_class();

		$rt = "<div class='$componentClassName $componentName component'>";
		if (SHOW_FRAME)
			$rt .= "<div class='debugMsg' >$componentClassName</div>";
		$rt .= "
			<div class='MessageBoxContent'>
				<div v-if='showClose' class='closeMsgBox' @click='close()'>
					<img src='assets/Close-Jaune.svg'/>
				</div>
				<h4 v-if='typeof title != \"undefined\"' style='margin-bottom: 30px;'>{{ title }}</h4>
				<slot></slot>
				<div v-if='typeof html != \"undefined\"' v-html='html'></div>
				<div class='buttons'>
					<div v-for='(button, key) in getButtons'>
						<button v-if='typeof button.action != \"undefined\"' @click='doAction(key)' class='btn-mscpi' :style='getStyle(key)'>{{ button.text }}</button>
						<button v-else-if='typeof button.mutation != \"undefined\"' @click='doMutation(key)' class='btn-mscpi'  :style='getStyle(key)'>{{ button.text }}</button>
					</div>
				</div>
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
						return ({});
					},
					computed: {
						getButtons: function() {
							if (
								typeof this.button != 'object'
							)
								return ({});
							return (this.button);
						},
						getStyle: function() {
							return (function(name) {
								if (typeof this.button[name].style != 'undefined')
									return (this.button[name].style);
								else
									return ({});
							})
						},
						showClose: function() {
							return (
								typeof this.notclose == 'undefined' ||
								this.notclose == false
							);
						}
					},
					props: [ 'button', 'title', 'html', 'notclose' ],
					methods: {
						doAction: function(actionName) {
							if (typeof this.button[actionName].action != 'undefined')
								this.\$store.dispatch(this.button[actionName].action, this.button[actionName].payload)
							if (this.button[actionName].action != 'modal_stack_pop')
								this.\$store.commit('modal_stack_pop');
						},
						doMutation: function(actionName) {
							if (typeof this.button[actionName].mutation != 'undefined')
								this.\$store.commit(this.button[actionName].mutation, this.button[actionName].payload)
							if (this.button[actionName].mutation != 'modal_stack_pop')
								this.\$store.commit('modal_stack_pop');
						},
						close: function() {
							this.\$store.commit('modal_stack_pop');
						}
					},
					template: '#$templateId',
				}
			);
		");
	}
}
