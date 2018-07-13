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

class ComponentSimpleBlockMscpi extends ComponentGenerator {

	protected static $_dependances = [
		"ComponentMessageBox" => ["noname" => []]
	];
	protected static $_componentName = "component-simple-block-mscpi";

	private function __construct() { }

	private function __destruct() {}

	// on pourra utiliser config pour redéfinir le component d'edition à utiliser dans un cas ou dans l'autre pour certains component

	protected static function getTemplate($class, $config) {
		$componentClassName = static::getClassName($class);
		$componentName = get_called_class();

		$rt = " <div class='$componentClassName $componentName component' :class='{active: show, masquer: masquer || !show, succeed: isSucceed}'>";
		//$rt = " <div class='$componentClassName $componentName component' :class='{active: show, masquer: false, succeed: isSucceed}'>";
		if (SHOW_FRAME)
			$rt .= "<span class='debugMsg'>$componentClassName</span>";
		$rt .= "
			<div class='block-content'>
				<slot></slot>
				<div class='buttons-projet'>
					<div class='btn-previous btn active'  @click='previous()' v-if='hidePrevious'>
						Retour
					</div>
					<div class='btn-next btn' :class='{active: activeNext}' @click='next()'>
						Continuer
					</div>
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

		return ("
			var listNames = [
				'ProjetChoixBeneficiaire',
				'ProjetChoixObjectif',
				'ProjetMontant',
				'ProjetOrigineFonds',
				'ProjetAccompagnementInvestissement',
				'JuridiqueVosInformations',
				'JuridiquePersonnePhysique1',
				'JuridiquePersonnePhysique2',
				'FinanciereRevenus',
				'FinanciereCharges',
				'FiscaleDe',
				'FiscaleImpot',
				'FiscaleIsf',
				'PatrimoineSituation',
				'PatrimoineRepartition',
				'PatrimoineFuturePlacement',
				'Fin'
			];
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
						isSucceed: function() {
							for (key in listNames) {
								if (listNames[key] == this.\$store.getters.getSelectedProjet2.statut_parcour_client.value)
									break;
								if (listNames[key] == this.blockname)
									return (true);
							}
							return (false);
						}
					},
					methods: {
						setMasquer: function(val) {
							this.masquer = val;
						},
						setActiveNext: function(val) {
							this.activeNext = val;
						},
						previous: function() {
							this.\$children[0].\$emit('previous');
						},
						next: function() {
							if (this.activeNext)
							{
								this.\$children[0].\$emit('next');
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
						return ({
							activeNext: false,
							masquer: false,
							title: '-'
						});
					},
					props: [  'show', 'config', 'blockname' ],
					template: '#$templateId',
					created: function() {
						this.\$on('isValid', this.setActiveNext);
						this.\$on('setMasquer', this.setMasquer);
					}
				}
			);
		");
	}

}
