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

class ComponentTypeObjectifEdit extends ComponentGenerator {

	protected static $_dependances = [];
	protected static $_componentName = "component-type-objectif-edit";

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
			<div class='objectif_container'>
				<div class='objectif_choix'>
					<div>
						<div>
							<span v-if='obj1 != null' @drop='setTarget' @dragover.prevent id='target_1' class='isset draggable' draggable='true' @dragstart='setSrc2'>
								{{ list[obj1] }}
							</span>
							<span v-else  @drop='setTarget' @dragover.prevent id='target_1'>
								Glissez votre 1<sup>er</sup> Objectif
							</span>
						</div>
					</div>
					<div>
						<div>
							<span  v-if='obj2 != null' @drop='setTarget' @dragover.prevent id='target_2' class='isset draggable' draggable='true' @dragstart='setSrc2'>
								{{ list[obj2] }}
							</span>
							<span v-else @drop='setTarget' @dragover.prevent id='target_2'>
								Glissez votre 2<sup>ème</sup> Objectif
							</span>
						</div>
					</div>
					<div>
						<div>
							<span v-if='obj3 != null' @drop='setTarget' @dragover.prevent id='target_3' class='isset draggable' draggable='true' @dragstart='setSrc2'>
								{{ list[obj3] }}
							</span>
							<span v-else  @drop='setTarget' @dragover.prevent id='target_3' >
								Glissez 3<sup>ème</sup> Objectif
							</span>
						</div>
					</div>
				</div>
				<div class='objectif_center'   @drop='unset' @dragover.prevent >
					<img src='assets/arrow.svg' style='width: 35%;' />
				</div>
				<div class='objectif_list'   @drop='unset' @dragover.prevent >
					<div v-for='(obj, key) in list'>
						<span draggable='true' class='draggable' :id='\"list_\" + key' @dragstart='setSrc' v-if='checkKey(key)'>
							{{ obj }}
						</span>
						<span v-else class='isunset'>
							{{ obj }}
						</span>
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
					methods: {
						setSrc2: function(ev) {
							this.src = parseInt(this['obj' + ev.srcElement.id[7]]);
						},
						setSrc: function(ev) {
							this.src = parseInt(ev.srcElement.id[5]);
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
						setTarget: function(ev) {
							if (this.src == null)
								return ;
							this.unset();
							this.target = parseInt(ev.srcElement.id[7]);
							this['obj' + this.target] = this.src;
							this.updateData();
						},
						checkKey: function(key) {
							return (
								this.obj1 != key &&
								this.obj2 != key &&
								this.obj3 != key
							);
						},
						updateData: function() {
							this.data.value = [
								this.obj1,
								this.obj2,
								this.obj3
							];
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
						getData: function() {
							return (this.data);
						}
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
