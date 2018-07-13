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

class ComponentProjectMiniProgressBar extends ComponentGenerator {

	protected static $_dependances = [];
	protected static $_componentName = "component-project-mini-progress-bar";

	private function __construct() { }

	private function __destruct() {}

	// on pourra utiliser config pour redéfinir le component d'edition à utiliser dans un cas ou dans l'autre pour certains component
	protected static function getTemplate($class, $config) {
		$componentClassName = static::getClassName($class); $componentName = get_called_class(); 
		$rt = " <div class='$componentClassName $componentName component'>";
		if (SHOW_FRAME)
			$rt .= "<span class='debugMsg'>$componentClassName</span>";
		$rt .= "
			<div class='mini-bar'>
				<span>
					QUESTION: {{ position }}/{{ size }}
				</span>
				<div>
					<div  class='bar1' :style='{width:getBarWidth1 + \"%\"}'></div>
					<div  class='bar2' :style='{width:getBarWidth2 + \"%\"}'></div>
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
			Vue.component(
				'$componentName',
				{
					computed: {
						getProjet: function() {
							return (this.\$store.getters.getSelectedProjet2.statut_parcour_client);
						},
						getBarWidth1() {
							return (100 *  this.position / this.size);
						},
						getBarWidth2() {
							return (100 * (this.position - 1) / this.size);
						}
					},
					props: [ 'data', 'position', 'size'],
					template: '#$templateId',
				}
			);
		");
	}

}
