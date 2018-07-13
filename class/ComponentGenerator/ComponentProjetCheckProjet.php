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

class ComponentProjetCheckProjet extends ComponentGenerator {

	protected static $_dependances = [
		"ComponentInputCheckboxMscpi" => ["noname" => []]
	];
	protected static $_componentName = "component-projet-check-projet";

	private function __construct() { }

	private function __destruct() {}

	// on pourra utiliser config pour redéfinir le component d'edition à utiliser dans un cas ou dans l'autre pour certains component
	protected static function getTemplate($class, $config) {
		$componentClassName = static::getClassName($class);
		$componentName = static::getComponentName($class);

		$rt = " <div class='$componentClassName $componentName component'>";
		if (SHOW_FRAME)
			$rt .= "<span class='debugMsg'>$componentClassName</span>";

		//$rt .= "{{ getToSend }}";
		$rt .= " ";
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
						selectedProjet: function() {
							return (this.\$store.getters.getSelectedProjet2);
						},
						allProjet: function() {
							return (this.\$store.getters.getProjet2ForSelectedDh);
						},
						isValid: function() {
							return (true);
						},
						getTitle: function(val) {
							return ('BLOCK CLEAN');
						}
					},
					watch: {
						isValid: function(val) {
							this.\$parent.\$emit('isValid', val);
						},
						getTitle: function(val) {
							this.\$parent.title = val;
						},
						statut_parcour_client: function(val) {
							this.doCheck();
						}
					},
					methods: {
						doCheck: function() {
							var temoin = this.allProjet.some(function(elm) {
								return (elm.statut_parcour_client.value != 'Fin');
							});
							if (temoin) {
								var that = this;
								setTimeout(function() {
									that.\$store.dispatch('modal_message_box', {
										config: {
											props: {
												button: {
													'restart': {
														text: 'Abandonner ce projet et en commencer un nouveau',
														action: 'projet2NextStep',
														payload: ''
													},
													'continue': {
														text: 'Continuer le projet en cours',
														action: 'projet2useExist',
														payload: ''
													}
												},
												notclose: true
											}
										},
										notClose: true,
										content: 'Vous avez déja démarré la création d\'un projet d\'investissement. que voulez vous faire ?'
									});
								}, 100);
							} else {
								this.next();
							}
						},
						previous: function(dat) {
							this.\$store.dispatch('projet2PreviousStep');
						},
						next: function(dat) {
							this.\$store.dispatch('projet2NextStep');
						},
						set: function(dat) {
							this.\$store.dispatch('projet2SetBlock');
						}
					},
					template: '#$templateId',
					created: function() {
						this.\$parent.\$emit('isValid', true);
						this.\$on('set', this.set);
						this.\$on('next', this.next);
						this.\$on('previous', this.previous);
						this.\$parent.title = this.getTitle;
						this.\$parent.masquer = false;
						if (this.selectedProjet.statut_parcour_client.value == 'ProjetCheckProjet')
							this.doCheck();
					},
					mounted: function() {
						this.\$parent.masquer = false;
						//if (this.selectedProjet.statut_parcour_client.value == 'ProjetCheckProjet')
							//this.doCheck();
					}
				}
			);
		");
	}

}
