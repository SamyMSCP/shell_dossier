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

class ComponentModalStack extends ComponentGenerator {

	protected static $_dependances = [
		"ComponentMessageBox" => ["noname" => []]
	];
	protected static $_componentName = "component-modal-stack";

	private function __construct() { }

	private function __destruct() {}

	// on pourra utiliser config pour redéfinir le component d'edition à utiliser dans un cas ou dans l'autre pour certains component
	protected static function getTemplate($class, $config) {
		return ("");

		$rt = "<div class='' : >";
		if (SHOW_FRAME)
			$rt .= "<div class='debugMsg' >$componentClassName</div>";
			$rt .= "
				<div>
					<div>
						<div class='modal-content'>
							<div class='modal-header'>
								<h5 class='modal-title' id='exampleModalLabel'>Modal title</h5>
								<button type='button' class='close' data-dismiss='modal' aria-label='Close'>
									<span aria-hidden='true'>&times;</span>
								</button>
							</div>
							<div class='modal-body'>
								...
							</div>
							<div class='modal-footer'>
								<button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
								<button type='button' class='btn btn-primary'>Save changes</button>
							</div>
						</div>
					</div>
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
		$componentClassName = static::getClassName($class);
		$componentName = static::getComponentName($class);
		$templateId = static::getTemplateId($class);

		$frame = "";
		if (SHOW_FRAME)
			$frame .= "
				createElement('span', {
					attrs: {
						class: 'debugMsg',
						style: 'margin-top:0px; opacity:1;'
					}
				}, ['$componentClassName']),
		";

		return ("
			Vue.component(
				'$componentName',
				{
					data: function() {
						return ({data: 'coucou'});
					},
					computed: {
						getTop: function() {
							return (this.\$store.getters.getModalStackTop);
						}
					},
					methods: {
						
					},
					watch: {
						getTop: function (val) {
							if (val == null)
								$('#stack_modal').modal('hide');
							else
							{
								if (
									val != null &&
									typeof val.notClose != 'undefined' &&
									val.notClose == true
								) {
									$('#stack_modal').modal({
										backdrop: 'static',
										keyboard: false,
									});
								} else {

									$('#stack_modal').modal({
										backdrop: 'static',
										keyboard: false,
									});
									/*
									$('#stack_modal').modal({
										backdrop: true,
										keyboard: true,
									});
									*/
								}
								$('#stack_modal').modal('show');
							}
						}
					},
					render: function(createElement) {

						function prepareElement(elementConfig) {
							var tag = elementConfig.tag;
							var config = (typeof elementConfig.config != 'undefined') ? JSON.parse(JSON.stringify(elementConfig.config)) : {};
							var content = [];
							if (typeof elementConfig.componentContent != 'undefined')
								content.push(prepareElement(elementConfig.componentContent));
							if (typeof elementConfig.content != 'undefined')
								content.push(elementConfig.content);
							return (createElement(tag, config, content));
						}

						var element = ' ';
						if (this.getTop != null)
							element = prepareElement(this.getTop);


						var att = {
							class: 'modal fade',
							id:'stack_modal',
							tabindex: '-1',
							role: 'dialog',
							'aria-labelledby':'exampleModalLabel',
							'aria-hidden': 'true',
						};

						return (createElement('div', {
							class: {
								errorInput: 'typeof data.error != \"undefined\"'
							},
							attrs: {
								class: '$componentClassName component',
							}
						}, [
							createElement('div', {
								attrs: att
							}, [
								$frame
								createElement('div', {
									attrs: {
										class: 'modal-dialog',
										role: 'document',
										style: 'width:auto;margin-left: 0px;margin-right: 0px;'
									}
								}, [
									element
								]),
							])
						]));
					}
				}
			);
		");
	}

}
