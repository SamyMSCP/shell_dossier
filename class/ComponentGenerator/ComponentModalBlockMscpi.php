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

class ComponentModalBlockMscpi extends ComponentGenerator {

	protected static $_dependances = [];
	protected static $_componentName = "component-modal-block-mscpi";

	private function __construct() { }

	private function __destruct() {}

	// on pourra utiliser config pour redéfinir le component d'edition à utiliser dans un cas ou dans l'autre pour certains component
	protected static function getTemplate($class, $config) {
		$componentClassName = static::getClassName($class);
		$componentName = get_called_class();

		$rt = " <div class='$componentClassName $componentName component active'>";
		if (SHOW_FRAME)
			$rt .= "<span class='debugMsg'>$componentClassName</span>";
		$rt .= "
			<div class='block-content'>
				<slot></slot>
				<div class='buttons-projet'>
					<div class='btn-next btn' :class='{active: activeNext}' @click='next()'>
						Continuer
					</div>
				</div>
			</div>
		</div>
		";
			/*
		$rt .= "<div class='block-title'>
					{{ title }}
					<div class='closeMsgBox' @click='close()'>
						<img src='assets/Close-Jaune.svg'/>
					</div>
				</div>
				<div class='block-content' style='display:block;'>
					<slot></slot>
					<div class='btn-next btn' :class='{active: activeNext}' @click='next()'>
						ENREGISTRER LES DONNÉES
						<img class='inactive' src='assets/CP-Fleche-GrisFonce.svg' alt='btn-next' />
						<img class='active' src='assets/CP-Fleche-BleuClair.svg' alt='btn-next' />
					</div>
				</div>
			</div>
		";
		*/
		return ($rt);
	}

	protected static function getComponent($class, $config) {
		$componentName = static::getComponentName($class);
		$templateId = static::getTemplateId($class);

		return ("
			Vue.component(
				'$componentName',
				{
					computed: {
						hidePrevious: function() {
							return (
								typeof this.config == 'undefined' ||
								typeof this.config.hidePrevious == 'undefined' ||
								this.config.hidePrevious === false
							);
						},
					},
					methods: {
						close: function() {
							this.\$store.commit('modal_stack_pop');
						},
						setActiveNext: function(val) {
							this.activeNext = val;
						},
						previous: function() {
							this.\$children[0].\$emit('previous');
						},
						next: function() {
							if (this.activeNext) {
								this.\$children[0].\$emit('set');
							}
							else
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
						}
					},
					data: function() {
						return ({activeNext: false, title: '-'});
					},
					props: [ 'show', 'config'],
					template: '#$templateId',
					created: function() {
						this.\$on('isValid', this.setActiveNext);
					}
				}
			);
		");
	}

}
