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

class ComponentTypeSerializedOrigineFonds2 extends ComponentGenerator {

	protected static $_dependances = [
		"ComponentInputCheckboxToogleMscpi" => ["noname" => []],
		"ComponentInputCheckboxMscpi" => ["noname" => []],
		"ComponentTypeBool2btnEdit" => ["noname" => []],
		"ComponentTypePourcentEdit" => ["TypePourcent" => []],
		"ComponentTypeEdit" => ["TypeString" => []],
	];
	protected static $_componentName = "component-type-serialized-origine-fonds2";

	private function __construct() { }

	private function __destruct() {}

	// on pourra utiliser config pour redéfinir le component d'edition à utiliser dans un cas ou dans l'autre pour certains component
	protected static function getTemplate($class, $config) {
		$componentClassName = static::getClassName($class);
		$componentName = get_called_class();

		$rt = "<div class='$componentClassName $componentName component' :class='{errorInput: typeof data.error != \"undefined\"}' >";
		if (SHOW_FRAME)
			$rt .= "<div class='debugMsg' >$componentClassName</div>";

		$rt .= "
			<div class='form_inline'>
				Quelle est la répartition des fonds pour ce projet d’investissement ?
			</div>
			<div class='tableSituation'>
				<div class='table'>
					<div
					v-for='(elm, key) in data.value'
					v-if='elm.enabled'
					>
						<span> {{ key }} </span>
						<div>
							<component-type-pourcent-edit-typepourcent :data='elm' @change='setVal(key, \$event)'></component-type-pourcent-edit-typepourcent>
							<div class='tableSituationButtonsMoin' @click='moin(key)'>
								<div class='ligneHorizontale'></div>
							</div>
							<div class='tableSituationButtonsPlus' @click='plus(key)'>
								<div class='ligneHorizontale'></div>
								<div class='ligneVerticale'></div>
							</div>
						</div>
					</div>
					<div v-if='data.value.Autre.enabled && typeof data.value.Autre.precision != \"undefined\"'>
						<span>Merci de préciser la nature de cette autre source</span>
						<div>
							<input v-model='data.value.Autre.precision' ></input>
						</div>
					</div>
					<div >
						<span>Total</span>
						<div style='font-family: \"Open Sans\", sans-serif; font-size: 18px; width: 100%; color: #01528a;text-align:center;border-top: 1px solid #0088e5;padding: 10px;'>
							{{ getTotal }} %
						</div>
					</div>
				</div>
				<div class='graph'>
					<component-pie-chart-noname :data='dataChart'> </component-pie-chart-noname>
				</div>
			</div>
";
		$rt .= "
			<div class='errorMsg' v-if='typeof data.error != \"undefined\"' >
				<div>
					{{ data.error }}
				</div>
			</div>";
		$rt .= "</div>";

		/*

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
					props: [ 'data'],
					methods: {
						resetVerrou: function() {
							this.verou = {
								'Crédit' : false,
								'Épargne' : false,
								'Cession d’actifs immobiliers' : false,
								'Héritage (successions)' : false,
								'Réemploi de fonds propres' : false,
								'Donation' : false,
								'Réemploi de fonds démembrés' : false,
								'Cessions d’actifs mobiliers' : false,
								'Autre' : false
							};
						},
						setVal: function(key, elm) {
							this.setValue(key, elm);
						},
						setValue: function(elm, val) {
							this.verou[elm] = true;
							if (isNaN(val))
								return ;
							var totalB = 0;
							val = Math.round(val * 2) / 2;
							var count = -1;
							for (key in this.data['value']) {
								if (this.data['value'][key]['enabled'] && !this.verou[key])
									count++;
							}
							if (val < 0)
								val = 0;
							else if (val > 100)
								val = 100;
							//else if (val > (100 - count))
								//val = (100 - count);
							
							for (key in this.data['value']) {
								var tmp;
								if (
									key != elm &&
									!this.verou[key] &&
									this.data['value'][key]['enabled']
								) {
									tmp = parseFloat(this.data['value'][key]['value']);
									if (isNaN(tmp)) {
										val -= 1;
										this.data['value'][key]['value'] = 1;
										tmp = 1;
									}
									else if (tmp <= 0) {
										val -= 1;
										this.data['value'][key]['value'] = 1;
										tmp = 1;
									}
									else if (tmp < 1) {
										val -= (1 - tmp);
										this.data['value'][key]['value'] = 1;
										tmp = 1;
									}
									totalB += tmp;
								}
							}

							var totalA = 100;
							for (key in this.data['value']) {
								var tmp;
								if (key == elm)
									totalA -= val;
								if (
									key != elm &&
									this.verou[key] &&
									this.data['value'][key]['enabled']
								) {
									tmp = parseFloat(this.data['value'][key]['value']);
									if (isNaN(tmp)) {
										val -= 1;
										this.data['value'][key]['value'] = 1;
										tmp = 1;
									}
									else if (tmp <= 0) {
										val -= 1;
										this.data['value'][key]['value'] = 1;
										tmp = 1;
									}
									else if (tmp < 1) {
										val -= (1 - tmp);
										this.data['value'][key]['value'] = 1;
										tmp = 1;
									}
									totalA -= tmp;
								}
							}

							var ratio = totalB / totalA;

							if (elm != null)
							this.data['value'][elm]['value'] = val;
							for (key in this.data['value']) {
								if (
									key != elm &&
									!this.verou[key] &&
									this.data['value'][key]['enabled']
								){
									var toSet = Math.round((this.data['value'][key]['value'] / ratio) * 100) / 100;
									if (toSet < 0)
										toSet = 0;
									else if (toSet > 100)
										toSet = 100;
									this.data['value'][key]['value'] = toSet;
								}
							}
						},
						moin: function(elm) {
							this.setValue(elm, parseFloat(this.data['value'][elm]['value']) - 5);
						},
						plus: function(elm) {
							this.setValue(elm, parseFloat(this.data['value'][elm]['value']) + 5);
						},
					},
					computed: {
						getSelectedStatut: function() {
							return (this.\$store.getters.getSelectedProjet2.statut_parcour_client.value);
						},
						getNbrEnable: function() {
							var rt = 0;
							for (key in this.data['value']) {
								var tmp;
								if ( this.data['value'][key]['enabled']) {
									rt++;
								}
							}
							return (rt);
						},
						getTotal: function() {
							var rt = 0;
							var tmp = [
								'Crédit',
								'Épargne',
								'Cession d’actifs immobiliers',
								'Héritage (successions)',
								'Réemploi de fonds propres',
								'Donation',
								'Réemploi de fonds démembrés',
								'Cessions d’actifs mobiliers',
								'Autre',
							];
							for (dt in tmp) {
								if (!this.data.value[tmp[dt]]['enabled'])
									continue ;
								var val = parseFloat(this.data.value[tmp[dt]]['value']);
								if (!isNaN(val))
									rt += val;
							}
							return (rt);
						},
						dataChart: function() {
							var rt = {
								datasets: [{data: [], backgroundColor: []}], labels: []
							};

							var tmp = [
								'Crédit',
								'Épargne',
								'Cession d’actifs immobiliers',
								'Héritage (successions)',
								'Réemploi de fonds propres',
								'Donation',
								'Réemploi de fonds démembrés',
								'Cessions d’actifs mobiliers',
								'Autre',
							];
							var labels = [
								'Crédit',
								'Épargne',
								'Cession d’actifs immobiliers',
								'Héritage (successions)',
								'Réemploi de fonds propres',
								'Donation',
								'Réemploi de fonds démembrés',
								'Cessions d’actifs mobiliers',
								'Autre',
							]
							var colors = null;
							if (this.getTotal <= 100.1 && this.getTotal >= 99.9) {
								colors = [
									'#086ab3',
									'#0b87e4',
									'#2c9ff5',
									'#5db5f8'
								]
							} else {
								colors = [
									'#b33a08',
									'#e4570b',
									'#f56f2c',
									'#f8855d'
								]
							}
							var temoin = 0;
							for (key in tmp) {
								var dt = parseFloat(this.data.value[tmp[key]].value);
								var enabl = this.data.value[tmp[key]].enabled;
								if (enabl && !isNaN(dt) && dt >= 0) {
									rt.datasets[0].data.push(dt);
									rt.labels.push(labels[key]);
									rt.datasets[0].backgroundColor.push(colors[temoin % 4]);
									temoin++;
								}
							}
							return (rt);
						},
						showOrigin: function() {
							return (
								this.data.value.Crédit.enabled === false ||
								( this.data.value.Crédit.enabled === true && this.data.value.Crédit.value < 100)
							);
						}
					},
					data: function() {
						return ({
							verou: {
								'Crédit' : false,
								'Épargne' : false,
								'Cession d’actifs immobiliers' : false,
								'Héritage (successions)' : false,
								'Réemploi de fonds propres' : false,
								'Donation' : false,
								'Réemploi de fonds démembrés' : false,
								'Cessions d’actifs mobiliers' : false,
								'Autre' : false
							},
							value: {
								'Crédit' : {
									value:0,
									enabled: false
								},
								'Épargne' : {
									value:0,
									enabled: false
								},
								'Cession d’actifs immobiliers' : {
									value:0,
									enabled: false
								},
								'Héritage (successions)' : {
									value:0,
									enabled: false
								},
								'Réemploi de fonds propres' : {
									value:0,
									enabled: false
								},
								'Donation' : {
									value:0,
									enabled: false
								},
								'Réemploi de fonds démembrés' : {
									value:0,
									enabled: false
								},
								'Cessions d’actifs mobiliers' : {
									value:0,
									enabled: false
								},
								'Autre' : {
									value:0,
									precision: ''
								}
							}
						});
					},
					watch: {
						getNbrEnable: function(val) {
							if ((val < 99.9 || val > 100.1) && this.getSelectedStatut == 'ProjetOrigineFonds') {
								this.setValue(null, 0);
							}
						},
						data: function(val) {
							if (typeof this.data.value != 'object' || this.data.value == null) {
								this.data.value = this.value;
								return ;
							}
							for (key in this.value) {
								if (typeof this.data.value[key] == 'undefined')
									this.data.value[key] = this.value[key];
							}
							if (typeof this.data.value['Autre'].precision == 'undefined')
								this.data.value['Autre'].precision = ' ';
						},
						getSelectedStatut: function(elm) {
							this.resetVerrou();
						}
					},
					created: function() {
						this.resetVerrou();
					},
					mounted: function() {
						this.resetVerrou();
					},
					template: '#$templateId'
				}
			);
		");
	}
}
