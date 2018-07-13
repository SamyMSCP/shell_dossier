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

class ComponentTypeDateEdit extends ComponentGenerator {

	private static $_counter = 1;

	protected static $_dependances = [];
	protected static $_componentName = "component-type-date-edit";

	private function __construct() { }

	private function __destruct() {}

	// on pourra utiliser config pour redéfinir le component d'edition à utiliser dans un cas ou dans l'autre pour certains component
	protected static function getTemplatePrivate($class, $config) {

		return ($rt);
	}

	protected static function getComponent($class, $config) {
		$componentClassName = static::getClassName($class);
		$componentName = static::getComponentName($class);
		$templateId = static::getTemplateId($class);// . "-" . self::$_counter;
		//self::$_counter++;


		$template = "<div class='$componentClassName component' :class='{errorInput: typeof data.error != \"undefined\"}' >";
		if (SHOW_FRAME)
			$template .= "<div class='debugMsg' >$componentClassName</div>";
		$template .= "<input :id='id' type='text' :value='getDateFormat' />";
		//$template .= "<div class='errorMsg' v-if='typeof data.error != \"undefined\"' >{{ data.error }}</div>";
		$template .= "
			<div class='errorMsg' v-if='typeof data.error != \"undefined\"' >
				<div>
					{{ data.error }}
				</div>
			</div>";
		$template .= "</div>";

		return ("
			var datepicker_counter = 0;
			Vue.component(
				'$componentName',
				{
					data: function () {
						return ({id: '$templateId'});
					},
					props: [ 'data' ],
					template: `$template`,
					computed: {
						getDateFormat:function () {
							if (this.data.value == 0)
								return ('-');
							return (moment(this.data.value, 'X').format('DD/MM/YYYY'))
						}
					},
					beforeMount: function() {
						datepicker_counter++;
						this.id = '$templateId' + datepicker_counter;
					},
					mounted: function() {
						var that = this;
						$('#' + this.id).datepicker({
							onClose: function(e) {
								var newDate = moment(e, 'DD/MM/YYYY')
								var rt = moment(that.data.value, 'X');
								if (
									newDate.date() != rt.date() ||
									newDate.month() != rt.month() ||
									newDate.year() != rt.year()
								)
								{
									rt.set({
										date: newDate.date(),
										month: newDate.month(),
										year: newDate.year(),
										hour: 0,
										minute: 0,
										second: 0,
										millisecond: 0
									});
									that.data.value = parseInt(newDate.clone().format('X'));
								}
							},
							dateFormat: 'dd/mm/yy',
							changeMonth: true,
							changeYear: true,
						})
					}
				}
			);
		");
	}

}
