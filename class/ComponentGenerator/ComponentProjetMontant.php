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

class ComponentProjetMontant extends ComponentGenerator {

	protected static $_dependances = [
		"ComponentInputCheckboxMscpi" => ["noname" => []]
	];
	protected static $_componentName = "component-projet-montant";

	private function __construct() { }

	private function __destruct() {}

	// on pourra utiliser config pour redéfinir le component d'edition à utiliser dans un cas ou dans l'autre pour certains component
	protected static function getTemplate($class, $config) {
		$componentClassName = static::getClassName($class);
		$componentName = static::getComponentName($class);
$rt = " <div class='$componentClassName $componentName component'>"; if (SHOW_FRAME) $rt .= "<span class='debugMsg'>$componentClassName</span>";


		$montant_investissement_previsionnel	= Projet2::getComponentConfigured('montant_investissement_previsionnel');
		//$montant_investissement_previsionnel = Projet2::getEditComponent('montant_investissement_previsionnel')::getHtmlTag('TypeEuros', [':data' => "selectedProjet.montant_investissement_previsionnel"]);
		$rt .= "
			<div class='simpleForm'>
				<div>
					<span>
						Quel Montant souhaitez vous investir ?
					</span>
					$montant_investissement_previsionnel
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
					methods: {
					},
					computed: {
						selectedProjet: function() {
							return (this.\$store.getters.getSelectedProjet2);
						},
						storeDatas: function() {
							return (this.\$store.state.mscpi.modules.StoreModuleProcessProjet.Blocks.ProjetMontant);
						},
						isValid: function() {
							return (true);
						},
						getTitle: function() {
							return ('3. QUEL MONTANT SOUHAITEZ-VOUS INVESTIR ?');
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
							this.\$store.dispatch('projet2PreviousStep', this.selectedProjet);
						},
						next: function(dat) {
							this.\$store.dispatch('projet2NextStep', this.selectedProjet);
						},
						set: function(dat) {
							this.\$store.dispatch('projet2SetBlock', {
								datas: this.selectedProjet,
								name: 'ProjetMontant'
							});
						}
					},
					template: '#$templateId',
					created: function() {
						this.\$parent.masquer = false;
						this.\$parent.\$emit('isValid', true);
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
