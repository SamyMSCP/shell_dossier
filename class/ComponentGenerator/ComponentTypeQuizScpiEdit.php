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

class ComponentTypeQuizScpiEdit extends ComponentGenerator {

	protected static $_dependances = [
		"ComponentInputCheckboxButtonMscpi" => ["noname" => []],
		"ComponentTextFermable" => ["noname" => []]
	];
	protected static $_componentName = "component-type-quiz-scpi-edit";

	private function __construct() { }

	private function __destruct() {}

	// on pourra utiliser config pour redéfinir le component d'edition à utiliser dans un cas ou dans l'autre pour certains component
	protected static function getTemplate($class, $config) {
		$componentClassName = static::getClassName($class);
		$componentName = get_called_class();

		$list = ProfilInvestisseur2::$_listQuestions;

		$rt = "<div class='$componentClassName $componentName component' :class='{errorInput: typeof data.error != \"undefined\"}' >";
		if (SHOW_FRAME)
			$rt .= "<div class='debugMsg' >$componentClassName</div>";

/*
		$rt .= "
			{{ data }}
			<input type='number' v-model='mode'/>
		";
		*/
		foreach ($list as $key => $elm) {
			if (!$elm['online'])
				continue ;
			$title = $elm['title'];
			$oui = ( isset($elm['response'][0]) ? "
				<component-input-checkbox-button-mscpi-noname
					label='Oui'
					checker='0'
					v-model='data.value[$key]'
					@input='setOne($key)'
					:disabled='data.value[$key] !== null'
				> </component-input-checkbox-button-mscpi-noname> " : ""); 
			$non = ( isset($elm['response'][1]) ? "
				<component-input-checkbox-button-mscpi-noname
					label='Non'
					checker='1'
					v-model='data.value[$key]'
					@input='setOne($key)'
					:disabled='data.value[$key] !== null'
				> </component-input-checkbox-button-mscpi-noname>
			" : "");
			$saisPas = ( isset($elm['response'][2]) ? "
				<component-input-checkbox-button-mscpi-noname
					label='Ne sais pas'
					checker='2'
					v-model='data.value[$key]'
					@input='setOne($key)'
					:disabled='data.value[$key] !== null'
				> </component-input-checkbox-button-mscpi-noname>
			" : "");
			$rt .= "
				<template v-if='mode == $key && typeof data.value != \"undefined\"'>
					<div class='form_inline'>
						$title
					</div>
					<div class='new_style_container'>
						$oui
						$non
						$saisPas
					</div>
					<component-text-fermable-noname class='form_inline correction' :trigger='mode' :size='200' :content='correction[$key]' v-if='data.value[$key] !== null'></component-text-fermable-noname>
				</template>
			";
		}
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

		$resp = [];
		$correction = [];
		foreach (ProfilInvestisseur2::$_listQuestions as $key => $elm) {
			if (!$elm['online'])
				continue ;
			$resp[$key] = null;
			$correction[] = $elm['correction'];
		}
		$list = json_encode($resp);
		$corr = json_encode($correction);
		$size = count($resp);

		return ("
			Vue.component(
				'$componentName',
				{
					computed: {
						selectedProfilInvestisseur: function() {
							return (this.\$store.getters.getSelectedProfilInvestisseur2);
						},
					},
					data:function() {
						return ({
							mode: 0,
							responses: $list,
							correction: $corr,
							open: [
								false,
								false,
								false,
								false,
								false,
								false,
								false,
								false,
								false,
								false,
								false,
								false,
								false
							]
						});
					},
					props: [ 'data'],
					template: '#$templateId',
					methods: {
						setOne: function(key) {
							this.\$store.dispatch('projet2SetActual', this.selectedProfilInvestisseur);
						},
						previous: function() {
							if (this.mode <= 0)
								return (true);
							else
								this.mode--;
							return (false);
						},
						next: function() {
							if (this.mode >= 12)
								return (true);
							else {
								var quiz = this.selectedProfilInvestisseur.quiz.value;
								var temp = 0;
								for (key in quiz) {
									var question = quiz[key];
									if (question != null)
										temp++;
									else
										break;
								}
								this.mode++;
								if (this.mode > temp) {
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
										content: 'Veuillez choisir votre réponse'
									});
									this.mode = temp;
								}
							}
							return (false);
						},
						setData: function(data) {
							if (typeof data == 'object' && data.value != null && data.value.length == $size) {
								for (var key in this.responses) {
									if (data.value[key] != null)
									{
										this.responses[key] = parseInt(data.value[key])
									}
									else
										this.responses[key] = null;
								}
							}
						},
					},
					watch: {
						responses: function(data) {
							this.data.value = data;
						},
					},
					mounted: function() {
						this.setData(this.data);
					},
					created: function() {
						this.setData(this.data);
					},
				}
			);
		");
	}
}
