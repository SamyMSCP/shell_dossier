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

class ComponentPieChart extends ComponentGenerator {

	protected static $_dependances = [];
	protected static $_componentName = "component-pie-chart";

	private function __construct() { }

	private function __destruct() {}

	// on pourra utiliser config pour redéfinir le component d'edition à utiliser dans un cas ou dans l'autre pour certains component
	protected static function getTemplatePrivate($class, $config) {

		return ($rt);
	}

	protected static function getComponent($class, $config) {
		$componentClassName = static::getClassName($class);
		$componentName = static::getComponentName($class);
		$templateId = static::getTemplateId($class);

		$template = "<div class='$componentClassName component' >";
		if (SHOW_FRAME)
			$template .= "<div class='debugMsg' >$componentClassName</div>";
		$template .= "<canvas :id='id' width='200' height='200'> </canvas>";
		$template .= "</div>";

		return ("
			var pie_chart_counter = 0;
			Vue.component(
				'$componentName',
				{
					data: function () {
						return ( {id: '$templateId', chart: null});
					},
					props: {
						'data': {
							type: Object,
							default: function() {
								return ({
									datasets: [{
										data: [0]
									}],
									labels: ['not defined'],
									backgroundColor: []
								});
							}
						},
						options: {
							type: Object,
							default: function() {
								return ({
									legend: {
										display: false
									},
									tooltips: {
										callbacks: {
											label: function(tooltip, data) {
												return (
													data.labels[tooltip.index]
												);
											}
										}
									}
								});
							}
						}
					},
					template: `$template`,
					computed: {
						dataComputed: function() {
							return (this.data);
						}
					},
					watch: {
						dataComputed: function(data) {
							if (data.datasets[0].data.length == 0)
								this.chart.data.datasets[0].data = [0];
							else
							{
								this.chart.data.datasets[0].data = data.datasets[0].data;
								this.chart.data.datasets[0].backgroundColor = data.datasets[0].backgroundColor;
								this.chart.data.labels = data.labels;
							}
							this.chart.update();
						}
					},
					beforeMount: function() {
						pie_chart_counter++;
						this.id = '$templateId' + pie_chart_counter;
					},
					mounted: function() {
						this.chart = new Chart(this.id, {
							type: 'pie',
							data: this.data,
							options: this.options
						});
					}
				}
			);
		");
	}

}
