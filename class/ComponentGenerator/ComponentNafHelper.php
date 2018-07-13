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

class ComponentNafHelper extends ComponentGenerator {

	protected static $_dependances = [];
	protected static $_componentName = "component-naf-helper";

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
			<div class='NafHelperContent'>
				<div class='closeMsgBox' @click='close()'>
					<img src='assets/Close-Jaune.svg'/>
				</div>
				<h4>Assistant code naf</h4>
				<p>Pour connaitre votre code Naf, veuillez compléter les champs ci-dessous</p>
				<div class='simpleForm'>
					<div>
						<span>Section</span>
						<div style='padding:6px 12px;' @change='resetSection()' class='component'>
							<select v-model='section'>
								<option v-for='elm in getSections' :value='elm.section.value'>{{ elm.libelle.value }}</option>
							</select>
						</div>
					</div>
					<div v-if='this.getCode1.length > 1'  @change='resetCode1()'>
						<span>Premier niveau</span>
						<div  style='padding:6px 12px;' class='component'>
							<select v-model='code1'>
								<option v-for='elm in getCode1' :value='elm.code_1.value'>{{ elm.libelle.value }}</option>
							</select>
						</div>
					</div>
					<div v-if='this.getCode2.length > 1' @change='resetCode2()'>
						<span>Second niveau</span>
						<div  style='padding:6px 12px;' class='component'>
							<select v-model='code2'>
								<option v-for='elm in getCode2' :value='elm.code_2.value'>{{ elm.libelle.value }}</option>
							</select>
						</div>
					</div>
					<div v-if='this.getCode3.length > 1' @change='resetCode3()'>
						<span>troisieme niveau</span>
						<div  style='padding:6px 12px;' class='component'>
							<select v-model='code3'>
								<option v-for='elm in getCode3' :value='elm.code_3.value'>{{ elm.libelle.value }}</option>
							</select>
						</div>
					</div>
					<div v-if='this.getCode4.length > 1'>
						<span>Quatrieme niveau</span>
						<div  style='padding:6px 12px;' class='component'>
							<select v-model='code4'>
								<option v-for='elm in getCode4' :value='elm.code_4.value'>{{ elm.libelle.value }}</option>
							</select>
						</div>
					</div>
					<div v-if='code4 != null'>
						votre code Naf est : {{ getCodeFormat }}
					</div>
					<div v-if='code4 != null'>
						<button class='btn-mscpi' @click='validate()'>VALIDER</button>
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

		$datas = json_encode(CodeNaf::getAll());
		return ("
			Vue.component(
				'$componentName',
				{
					data: function() {
						return ({
							list: $datas,
							section: null,
							code1: null,
							code2: null,
							code3: null,
							code4: null,
						});
					},
					computed: {
						getSections: function() {
							var that = this;
							return (this.\$store.getters.getAllCodeNaf.filter(function(elm) {
								return (
									elm.code_1.value == null &&
									elm.code_2.value == null &&
									elm.code_3.value == null &&
									elm.code_4.value == null
								);
							}).sort(function(a, b) {
								return (String(a.libelle.value).localeCompare(String(b.libelle.value)));
							}));
						},
						getCode1: function() {
							var that = this;
							return (this.\$store.getters.getAllCodeNaf.filter(function(elm) {
								return (
									elm.code_1.value != null &&
									elm.code_2.value == null &&
									elm.code_3.value == null &&
									elm.code_4.value == null &&
									elm.section.value == that.section
								);
							}).sort(function(a, b) {
								return (String(a.libelle.value).localeCompare(String(b.libelle.value)));
							}));
						},
						getCode2: function() {
							var that = this;
							return (this.\$store.getters.getAllCodeNaf.filter(function(elm) {
								return (
									elm.code_1.value != null &&
									elm.code_2.value != null &&
									elm.code_3.value == null &&
									elm.code_4.value == null &&
									elm.section.value == that.section &&
									elm.code_1.value == that.code1
								);
							}).sort(function(a, b) {
								return (String(a.libelle.value).localeCompare(String(b.libelle.value)));
							}));
						},
						getCode3: function() {
							var that = this;
							return (this.\$store.getters.getAllCodeNaf.filter(function(elm) {
								return (
									elm.code_1.value != null &&
									elm.code_2.value != null &&
									elm.code_3.value != null &&
									elm.code_4.value == null &&
									elm.section.value == that.section &&
									elm.code_1.value == that.code1 &&
									elm.code_2.value == that.code2
								);
							}).sort(function(a, b) {
								return (String(a.libelle.value).localeCompare(String(b.libelle.value)));
							}));
						},
						getCode4: function() {
							var that = this;
							return (this.\$store.getters.getAllCodeNaf.filter(function(elm) {
								return (
									elm.code_1.value != null &&
									elm.code_2.value != null &&
									elm.code_3.value != null &&
									elm.code_4.value != null &&
									elm.section.value == that.section &&
									elm.code_1.value == that.code1 &&
									elm.code_2.value == that.code2 &&
									elm.code_3.value == that.code3
								);
							}).sort(function(a, b) {
								return (String(a.libelle.value).localeCompare(String(b.libelle.value)));
							}));
						},
						getCodeFormat: function() {
							var rt = '';
							if (this.code1 < 10)
								rt += '0';
							rt += this.code1 + '.' + this.code2 + this.code3 + this.code4;
							return (rt);
						},
					},
					methods: {
						validate: function() {
							this.\$store.getters.getSelectedPersonnePhysique.code_naf.value = this.getCodeFormat;
							//this.data.value = this.getCodeFormat;
							this.\$store.commit('modal_stack_pop');
						},
						resetSection: function() {
							this.\$nextTick(function () {
								if (this.getCode1.length == 1)
									this.code1 = this.getCode1[0].code_1.value;
								else
									this.code1 = null;
								this.resetCode1();
							});
						},
						resetCode1: function() {
							this.\$nextTick(function () {
								if (this.getCode2.length == 1)
									this.code2 = this.getCode2[0].code_2.value
								else
									this.code2 = null;
								this.resetCode2();
							});
						},
						resetCode2: function() {
							this.\$nextTick(function () {
								if (this.getCode3.length == 1)
									this.code3 = this.getCode3[0].code_3.value
								else
									this.code3 = null;
								this.resetCode3();
							});
						},
						resetCode3: function() {
							if (this.getCode4.length == 1)
								this.code4 = this.getCode4[0].code_4.value
							else
								this.code4 = null;
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
