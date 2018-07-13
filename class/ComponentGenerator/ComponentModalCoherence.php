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

class ComponentModalCoherence extends ComponentGenerator {

	protected static $_dependances = [];
	protected static $_componentName = "component-modal-coherence";

	private function __construct() { }

	private function __destruct() {}

	// on pourra utiliser config pour redéfinir le component d'edition à utiliser dans un cas ou dans l'autre pour certains component
	protected static function getTemplate($class, $config) {
		$componentClassName = static::getClassName($class);
		$componentName = get_called_class();

		$rt = "<div class='$componentClassName $componentName component'>";
		if (SHOW_FRAME)
			$rt .= "<div class='debugMsg' >$componentClassName</div>";

		//$precision_coherence = SituationPhysique::getComponentConfigured('precision_coherence_1', [':data', 'getPrecisionCoherence']);
		$rt .= "
			<div class='ModalCoherenceContent' v-if='mode == 1'>
				<div class='closeMsgBox' @click='close()'>
					<img src='assets/Close-Jaune.svg'/>
				</div>
				<h4 v-if='typeof title != \"undefined\"' style='margin-bottom: 30px;'>{{ title }}</h4>
				<slot></slot>
				<div class='form_inline' v-if='typeof html != \"undefined\"' v-html='html'></div>

				<div class='buttons'>
					<div v-if='config.havePrecision'>
						<button  class='btn-mscpi-2'  @click='mode = 3'>Apporter des précisions</button>
					</div>

					<div v-if='config.haveModify'>
						<button  class='btn-mscpi-2'  @click='mode = 2' style=' background-color: #ff9f1c; color: #ffffff; '>Modifier les données</button>
					</div>

					<div v-if='config.haveClose'>
						<button  class='btn-mscpi-2'  @click='close()'>Modifier mes informations</button>
					</div>
				</div>
			</div>
			<div class='ModalCoherenceContent' v-if='mode == 2'>
				<div class='closeMsgBox' @click='mode = 1'>
					<img src='assets/Close-Jaune.svg'/>
				</div>
				<h4 v-if='typeof title != \"undefined\"' style='margin-bottom: 30px;'>{{ title }}</h4>
				<slot></slot>
				<div v-if='typeof html != \"undefined\"' v-html='html2'></div>
				<div class='buttons'>
					<div v-for='(button, key) in getButtons'>
						<button style=' background-color: #ff9f1c; color: #ffffff; 'v-if='typeof button.action != \"undefined\"' @click='doAction(key)' class='btn-mscpi-2' :style='getStyle(key)'>{{ button.text }}</button>
						<button style=' background-color: #ff9f1c; color: #ffffff; 'v-else-if='typeof button.mutation != \"undefined\"' @click='doMutation(key)' class='btn-mscpi-2'  :style='getStyle(key)'>{{ button.text }}</button>
					</div>
				</div>
			</div>
			<div class='ModalCoherenceContent' v-if='mode == 3'>
				<div class='closeMsgBox' @click='mode = 1'>
					<img src='assets/Close-Jaune.svg'/>
				</div>
				<div class='form_inline' style='margin-bottom:20px;'>Pourriez-vous nous apporter des précisions sur ce point ?</div>
				<div style='position:relative;'>
					<textarea v-model='getPrecisionCoherence.value' style='min-width: 400px;min-height: 100px;'> </textarea>
					<div class='errorMsg' v-if='typeof getPrecisionCoherence.error != \"undefined\"' >
						<div>
							{{ getPrecisionCoherence.error }}
						</div>
					</div>
				</div>
				<div class='buttons' v-if='incoherenceOk'>
					<div>
						<button  class='btn-mscpi-2'  style=' background-color: #ff9f1c; color: #ffffff; '@click='setIncoherence()'>Enregistrer</button>
					</div>
				</div>
			</div>
		";
		// Le mode 3 doit permettre de corriger une incohérence.
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
						return ({
							mode: 1
						});
					},
					computed: {
						selectedPersonnePhysique: function() {
							return (this.\$store.getters.getSelectedSituationPhysique);
						},
						getButtons: function() {
							if (
								typeof this.button != 'object'
							) return ({});
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
						getPrecisionCoherence: function() {
							if (typeof this.coherence_nbr != 'undefined')
								return (this.\$store.getters.getSelectedSituationPhysique['precision_coherence_' + this.coherence_nbr]);
							else
								return ({value: null});
						},
						incoherenceOk: function() {
							return (this.getPrecisionCoherence.value != null && this.getPrecisionCoherence.value.length >= 1);
						}
					},
					watch: {
						getPrecisionCoherence: function(elm) {
							this.mode = 1;
						}
					},
					props: [ 'button', 'title', 'html', 'config', 'html2', 'coherence_nbr' ],
					methods: {
						setIncoherence: function() {
							if (
								this.getPrecisionCoherence.value == null ||
								this.getPrecisionCoherence.value.length < 1
							) {
								this.\$store.dispatch('modal_message_box', {
									config: {
										props: {
											button: {
												'fermer': {
													text: 'fermer',
													action: 'modal_stack_pop',
													payload: ''
												}
											}
										}
									},
									content: 'Veuillez compléter le formulaire pour passer à la suite'
								});
							} else {
								this.\$store.dispatch('projet2SetIncoherence', {
									nbr_incoherence: this.coherence_nbr,
									datas: this.selectedPersonnePhysique
								});
							}
						},
						doAction: function(actionName) {
							if (typeof this.button[actionName].action != 'undefined')
							{
								this.\$store.commit('modal_stack_pop');
								this.\$store.dispatch(this.button[actionName].action, this.button[actionName].payload)
							}
							else
								this.\$store.commit('modal_stack_pop');
						},
						doMutation: function(actionName) {
							if (typeof this.button[actionName].mutation != 'undefined')
							{
								this.\$store.commit('modal_stack_pop');
								//this.\$store.commit(this.button[actionName].mutation, this.button[actionName].payload)
							}
							else
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
