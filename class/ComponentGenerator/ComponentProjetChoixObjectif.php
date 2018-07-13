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

class ComponentProjetChoixObjectif extends ComponentGenerator {

	protected static $_dependances = [
		"ComponentTypeObjectifEdit" => ["noname" => []],
		"ComponentProjectMiniProgressBar" => ["noname" => []],
	];
	protected static $_componentName = "component-projet-choixobjectif";
private function __construct() { } 
	private function __destruct() {}

	// on pourra utiliser config pour redéfinir le component d'edition à utiliser dans un cas ou dans l'autre pour certains component
	protected static function getTemplate($class, $config) {
		$componentClassName = static::getClassName($class);
		$componentName = get_called_class();

		$rt = " <div class='$componentClassName $componentName component'>";
		if (SHOW_FRAME)
			$rt .= "<span class='debugMsg'>$componentClassName</span>";

		$objectifs		= Projet2::getComponentConfigured('objectifs');
		$objectif_autre	= Projet2::getComponentConfigured('objectif_autre');
		$rt .= "
			<component-project-mini-progress-bar-noname position='2' size='6'> </component-project-mini-progress-bar-noname>
			<div class='form_inline'>
				Quels sont les principaux objectifs de cet investissement ? (maximum 3)
			</div>
			$objectifs
			<div class='simpleForm' v-if='haveObjectifAutre'>
				<div>
					<span>Quel est cet objectif autre ?</span>
					$objectif_autre
				</div>
			</div>
		";
		$rt .= "</div> ";
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
						return ({ });
					},
					computed: {
						haveObjectifAutre: function() {
							var data = this.selectedProjet.objectifs;
							if (typeof data.value != 'object' || data.value == null || data.value.length != 3)
								return (false);
							for (var i = 0; i < 3; i++) {
								var val = parseInt(data.value[i]);
								if (val == 8)
									return (true);
							}
							return (false);
						},
						haveGarantieCapital: function() {
							var data = this.selectedProjet.objectifs;
							if (typeof data.value != 'object' || data.value == null || data.value.length != 3)
								return (false);
							for (var i = 0; i < 3; i++) {
								var val = parseInt(data.value[i]);
								if (val == 5)
									return (true);
							}
							return (false);
						},
						selectedProjet: function() {
							return (this.\$store.getters.getSelectedProjet2);
						},
						storeDatas: function() {
							return (this.\$store.state.mscpi.modules.StoreModuleProcessProjet.Blocks.ProjetChoixObjectif);
						},
						isValid: function() {
							var data = this.selectedProjet.objectifs;
							if (typeof data.value != 'object' || data.value == null || data.value.length != 3)
								return (false);
							var haveAutre = false
							for (var i = 0; i < 3; i++) {
								var val = data.value[i];
								if (val == 8)
									haveAutre = true;
								if (val < 1 || i > 8)
									return (false);
							}
							if (
								haveAutre &&
								(
									this.selectedProjet.objectif_autre.value == null ||
									this.selectedProjet.objectif_autre.value.length < 2
								)
							)
								return (false);
							return (true);
						},
					},
					watch: {
						isValid: function(val) {
							this.\$parent.\$emit('isValid', val);
						},
					},
					methods: {
						previous: function(dat) {
							this.\$store.dispatch('projet2PreviousStep', this.selectedProjet);
						},
						next: function(dat) {
							if (this.haveGarantieCapital) {
								this.\$store.dispatch('modal_message_box', {
									config: {
										props: {
											button: {
												'modify': {
													text: 'Je modifie mes préférences',
													action: 'modal_stack_pop',
													payload: '',
													style: 'background-color: #ff9f1c;'
												},
												'oui': {
													text: 'Oui, j\'accepte ce point',
													action: 'projet2NextStep',
													payload: this.selectedProjet
												}
											},
											title: 'VOUS AVEZ SÉLECTIONNÉ « GARANTIR MON CAPITAL » PARMI VOS 3 PREMIERS OBJECTIFS.',
											html: ' En SCPI, le capital n’est pas garanti et les performances passées ne préjugent en rien des performances futures.<br />Pour poursuivre acceptez-vous une perte potentielle en capital ?'
										}
									},
								});
							}
							else
								this.\$store.dispatch('projet2NextStep', this.selectedProjet);
						},
						set: function(datas) {
							if (this.haveGarantieCapital) {
								this.\$store.dispatch('modal_message_box', {
									config: {
										props: {
											button: {
												'modify': {
													text: 'Je modifie mes préférences',
													action: 'modal_stack_pop',
													payload: '',
													style: 'background-color: #ff9f1c;'
												},
												'oui': {
													text: 'Oui, j\'accepte ce point',
													action: 'projet2SetBlock',
													payload: {
														datas: this.selectedProjet,
														name: 'ProjetChoixObjectif'
													}
												}
											},
											title: 'VOUS AVEZ SÉLECTIONNÉ « GARANTIR MON CAPITAL » PARMI VOS 3 PREMIERS OBJECTIFS.',
											html: ' En SCPI, le capital n’est pas garanti et les performances passées ne préjugent en rien des performances futures.<br />Pour poursuivre acceptez-vous une perte potentielle en capital ?'
										}
									},
								});
							}
							else
								this.\$store.dispatch('projet2SetBlock', {
									datas: this.selectedProjet,
									name: 'ProjetChoixObjectif'
								});
						}
					},
					template: '#$templateId',
					created: function() {
						this.\$parent.\$emit('isValid', this.isValid);
						this.\$on('set', this.set);
						this.\$on('next', this.next);
						this.\$on('previous', this.previous);
						this.\$parent.masquer = false;
					},
					mounted: function() {
						this.\$parent.masquer = false;
					}
				}
			);
		");
	}
}
