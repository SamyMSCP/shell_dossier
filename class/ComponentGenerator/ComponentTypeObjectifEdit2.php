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

class ComponentTypeObjectifEdit2 extends ComponentGenerator {

	protected static $_dependances = [];
	protected static $_componentName = "component-type-objectif-edit2";

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
			<transition-group name='list-objectif' tag='div' class='new_style_container'>
				<div v-for='obj in getOrderedList' class='in_container big' :class='{selected: !checkKey(obj.key)}' :key='obj.key' @click='setOne(obj)'>
					<div class='number'>
						{{ getNumber(obj.key) }}
					</div>
					{{ obj.value }}
				</div>
			 </transition-group>
			<div @click='reset()' class='btn btn-grey'>
				Réinitiatiliser la sélection
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

		$list = json_encode(TypeObjectif::$_listObjectif);
		return ("
			Vue.component(
				'$componentName',
				{
					data: function() {
						return ({
							obj1: null,
							obj2: null,
							obj3: null,
							src: null,
							target: null,
							list: $list
						});
					},
					computed: {
						getOrderedList: function() {
							var rt = [];
							if (this.obj1 != null)
								rt.push({key: this.obj1, value: this.list[this.obj1]});
							if (this.obj2 != null)
								rt.push({key: this.obj2, value: this.list[this.obj2]});
							if (this.obj3 != null)
								rt.push({key: this.obj3, value: this.list[this.obj3]});
							for (key in this.list) {
								var tmp = this.list[key];
								if (this.checkKey(key)) {
									rt.push({key: key, value: tmp});
								}
							}
							return (rt);
						},
						getData: function() {
							return (this.data);
						}
					},
					methods: {
						reset: function() {
							this.obj1 = null;
							this.obj2 = null;
							this.obj3 = null;
							this.updateData();
						},
						unset: function(key) {
							if (this.obj1 == this.src)
								this.obj1 = null;
							if (this.obj2 == this.src)
								this.obj2 = null;
							if (this.obj3 == this.src)
								this.obj3 = null;
							this.updateData();
						},
						checkKey: function(key) {
							return (
								this.obj1 != key &&
								this.obj2 != key &&
								this.obj3 != key
							);
						},
						getNumber: function(key) {
							if (this.obj1 == key)
								return (1);
							else  if (this.obj2 == key)
								return (2);
							else if (this.obj3 == key)
								return (3);
							return ('');
						},
						updateData: function() {
							this.data.value = [
								this.obj1,
								this.obj2,
								this.obj3
							];
						},
						unsetOne: function(elm) {
							if (this.obj1 == elm.key) {
								this.obj1 = this.obj2;
								this.obj2 = this.obj3;
								this.obj3 = null;
							} else if (this.obj2 == elm.key) {
								this.obj2 = this.obj3;
								this.obj3 = null;
							} else if (this.obj3 == elm.key) {
								this.obj3 = null;
							}
						},
						setOne: function(elm) {
							if (this.checkKey(elm.key)) {
								if (this.obj1 == null)
									this.obj1 = elm.key;
								else if (this.obj2 == null)
									this.obj2 = elm.key;
								else if (this.obj3 == null)
									this.obj3 = elm.key;
							} else {
								this.unsetOne(elm);
							}
							this.updateData();
							this.setData();
						},
						setData: function(data) {
							if (typeof data == 'object' && data.value != null && data.value.length == 3) {
								for (var i = 0; i < 3; i++) {
									var val = parseInt(data.value[i]);
									if (val > 0 && i <= 8)
									{
										this['obj' + (i + 1)] = val;
									}
									else
										this['obj' + (i + 1)] = null;
								}
							}
						},
					},
					watch: {
						getData: function(elm) {
							this.setData(elm);
						},
					},
					props: [ 'data' ],
					mounted: function() {
						this.setData(this.data);
					},
					template: '#$templateId'
				}
			);
		");
	}
}
