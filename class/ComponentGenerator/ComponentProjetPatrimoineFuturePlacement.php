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

class ComponentProjetPatrimoineFuturePlacement extends ComponentGenerator {

	protected static $_dependances = [
		"ComponentInputCheckboxMscpi" => ["noname" => []]
	];
	protected static $_componentName = "component-projet-patrimoinefutureplacement";

	private function __construct() { }

	private function __destruct() {}

	// on pourra utiliser config pour redéfinir le component d'edition à utiliser dans un cas ou dans l'autre pour certains component
	protected static function getTemplate($class, $config) {
		$componentClassName = static::getClassName($class);
		$componentName = get_called_class();

		$rt = " <div class='$componentClassName $componentName component'>";
		if (SHOW_FRAME)
			$rt .= "<span class='debugMsg'>$componentClassName</span>";
			
		$patrimoine_part_futur_placement	= SituationPhysique::getComponentConfigured("patrimoine_part_futur_placement");

		$rt .= "
			<component-project-mini-progress-bar-noname position='3' size='3'> </component-project-mini-progress-bar-noname>
			<div class='form_inline'>
				La part de ce futur placement dans mon patrimoine sera $patrimoine_part_futur_placement.
			</div>
		";

/*
		$rt .= "
			$patrimoine_part_futur_placement
		";
		*/
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
					computed: {
						selectedPp: function() {
							return (this.\$store.getters.getSelectedPersonnePhysique);
						},
						selectedSituation: function() {
							return (this.\$store.getters.getSelectedSituationPhysique);
						},
						selectedProjet: function() {
							return (this.\$store.getters.getSelectedProjet2);
						},
						storeDatas: function() {
							return (this.\$store.state.mscpi.modules.StoreModuleProcessProjet.Blocks.ProjetJuridiquePersonnePhysique1);
						},
						isValid: function() {
							return (this.selectedSituation.patrimoine_part_futur_placement.value != null);
						},
						getTitle: function() {
							return ('QUELLE SERA LA PART DE CE FUTUR PLACEMENT DANS VOTRE PATRIMOINE ?');
						}
					},
					watch: {
						isValid: function(val) {
							this.\$parent.\$emit('isValid', val);
						},
						getTitle: function(val) {
							this.\$parent.title = val;
						}
					},
					methods: {
						previous: function(dat) {
							this.\$store.dispatch('projet2PreviousStep', this.selectedSituation);
						},
						next: function(dat) {
							if (this.selectedSituation.patrimoine_part_futur_placement.value == 1)
								this.\$store.dispatch('projet2NextStep', this.selectedSituation);
							else if (this.selectedSituation.patrimoine_part_futur_placement.value == 2) {
								this.\$store.dispatch('modal_stack_push', {
									tag: 'component-message-box-noname',
									config: {
										props: {
											button: {
												modifie: {
													mutation: 'modal_stack_pop',
													text: 'Je modifie mes préférences',
													style: { 'background-color': '#ff9f1c' }
												},
												continue: {
													action: 'projet2NextStepPop',
													payload: this.selectedSituation,
													text: 'Oui, je souhaite poursuivre',
												}
											},
											title: 'Attention, vous avez indiqué vouloir faire un investissement important qui représentera plus de 10 % de votre patrimoine. Êtes-vous sûr(e) de vouloir poursuivre ?'
										}
									},
									content: 'Nous recommandons à nos clients que les SCPI ne représentent pas plus de 10 % de leur patrimoine.'
								})
							}
							else if (this.selectedSituation.patrimoine_part_futur_placement.value == 3) {
								this.\$store.dispatch('modal_stack_push', {
									tag: 'component-message-box-noname',
									config: {
										props: {
											button: {
												modifie: {
													mutation: 'modal_stack_pop',
													text: 'Je modifie mes préférences',
													style: { 'background-color': '#ff9f1c' }
												},
												continue: {
													action: 'projet2NextStepPop',
													payload: this.selectedSituation,
													text: 'Oui, je souhaite poursuivre',
												}
											},
											title: 'Attention, vous avez indiqué vouloir faire un investissement important qui représentera plus de 30 % de votre patrimoine. Êtes-vous sûr(e) de vouloir poursuivre ?',
										}
									},
									content: 'Nous recommandons à nos clients que les SCPI ne représentent pas plus de 10 % de leur patrimoine.'
								})
							}
						},
						set: function(dat) {
							this.\$store.dispatch('modal_stack_push', {
								tag: 'component-message-box-noname',
								content: 'coucou'
							})
							//this.\$store.dispatch('projet2SetBlock', this.selectedSituation);
						}
					},
					template: '#$templateId',
					created: function() {
						this.\$parent.\$emit('isValid', this.isValid);
						this.\$on('set', this.set);
						this.\$on('next', this.next);
						this.\$on('previous', this.previous);
						this.\$parent.title = this.getTitle;
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
