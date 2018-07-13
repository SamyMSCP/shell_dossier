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

class ComponentTypeEurosEdit extends ComponentGenerator {

	protected static $_dependances = [];
	protected static $_componentName = "component-type-euros-edit";

	private function __construct() { }

	private function __destruct() {}

	protected static function getTemplate($class, $config) {
		$componentClassName = static::getClassName($class);
		$componentName = get_called_class();

		$rt = "<div class='$componentClassName $componentName component' :class='{errorInput: typeof data.error != \"undefined\"}' >";
		if (SHOW_FRAME)
			$rt .= "<div class='debugMsg' >$componentClassName</div>";
		$rt .= " <input type='text' :value='getData' @input='setData'  @change='sendChange'/>";
		$rt .= "
			<div class='tooltips' v-if='typeof tooltips != \"undefined\"' :style='{width: tooltipswidth}'>
				<div v-html='tooltips'> </div>
			</div>";
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

			var naiveReverse = function(string) {
				return ('' + string).split('').reverse().join('');
			}
			function unformatThousand(value) {
				value = String(value).replace(/€/g, '');
				value = String(value).replace(/,/g, '.');
				value = String(value).replace(/ */g, '');
				value = parseFloat(value);
				if (isNaN(value))
					return (null);
				return (value);
			}

			function formatThousand(valueIn) {
				var value2 = String(valueIn).replace('.', ',');
				var value = unformatThousand(valueIn);

				if (value === null)
					return (' €');

				value = parseFloat(value);
				value = Math.trunc(value * 100) / 100;

				var rt = '';
				var ent = Math.trunc(value);
				var decimal = Math.round((value - ent) * 100);

				if (isNaN(ent))
					ent = 0;
				if (isNaN(decimal))
					decimal = 0;

				ent = ('' + ent).split('').reverse();
				var nEnt = [];

				for (key in ent) {
					if (key != 0 && (key % 3) == 0)
						nEnt.push(' ');
					nEnt.push(ent[key]);
				}
				ent = nEnt.reverse().join('');
				rt = ent;

				if (('' + value2).search(', ') != -1)
					rt += ',';
				else if (('' + value2).search(',') != -1)
					rt += ',';

				if ((decimal / 10) != 0) {
					rt += ' ' + Math.trunc(decimal / 10);
					if ((decimal % 10) != 0) {
						rt += decimal % 10;
					}
				}
				return (rt + ' €');
			}

			Vue.component(
				'$componentName',
				{
					data: function() {
						return ({ innerData: null, evt: null, startPos: 0, endPos: 0 });
					},
					props: [ 'data', 'tooltips', 'tooltipswidth'],
					methods: {
						sendChange: function(elm) {
							this.\$emit('change', unformatThousand(elm.target.value));
						},
						setData: function(evt) {
							var that = this;

							if (this.evt == null)
								this.evt = evt;
							this.startPos	= (this.evt.target.value.length - this.evt.target.selectionStart);
							if (this.startPos < 2)
								this.startPos = 2;

							var val = formatThousand(that.evt.target.value);
							var tmp = ('' + val).split(',');
							if (typeof tmp[1] != 'undefined') {
								var str = '' + tmp[1];
								if (this.startPos < str.length && this.startPos != 0 && str.length > 0) {
									this.startPos--;
								}
							}
							that.data.value = unformatThousand(formatThousand(that.evt.target.value))
							that.evt.target.value = formatThousand(this.evt.target.value, 2, ' ');

							setTimeout(function() {
								that.\$emit('change', that.data.value);
							}, 500);
						}
					},
					computed: {
						getData: function() {
							var that = this;
							if (this.evt != null) {
								setTimeout(function() {
									var val = ('' + formatThousand(that.data.value)).length;
									that.evt.target.setSelectionRange(
										val - that.startPos,
										val - that.startPos
									);
								}, 10);
							}
							return formatThousand(this.data.value, 2, ' ');
						}
					},
					template: '#$templateId'
				}
			);
		");
	}

}
