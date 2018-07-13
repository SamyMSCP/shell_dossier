</script>

<script type="text/x-template" id="chartRepartitionScpi">
	<div class="blockProjectRepartition">
		<pie-chart-component :name='name' :value="getValueForChart" style="flex:1;"></pie-chart-component>
		<div class="listRepartition">
			<div v-for="elm in getValueForChart" :style="{color: elm.color}">{{ elm.label }} : {{ elm.value | pourcent }}</div>
		</div>
	</div>
</script>

<script type="text/javascript" charset="utf-8">
	Vue.component(
		'chartRepartitionScpi',
		{
			props: {
				value: {
					default: []
				},
				name: {
					type: String,
					default: 'defaultChartRepartitionScpi',
					required: true
				}
			},
			computed: {
				getValueForChart: function() {
					var that = this;
					var prep  = {};
					var retour = [];
					var total = 0;
					var colorSet = [
						"#0085A9",
						"#014C7F",
						"#002640",
						"#006D7F",
						"#00C3E5",
						"#007F6C",
						"#007F6C",
						"#008A5E",
						"#0073B1",
						"#009491",
						"#00402B",
						"#01528A",
						"#007F3F"
					];
					this.value.map(function(elm, key) {
						var scpi = that.$store.getters.getScpi(elm.id_scpi);
						if (typeof prep[scpi.name] == 'undefined')
						{
							prep[scpi.name] = {
								label: scpi.name,
								value: 0,
								color: '#ccc'
							}
						}
						prep[scpi.name].value += that.getTransactionInvestissement(elm);
						total += that.getTransactionInvestissement(elm);
					});
					Object.keys(prep).map(function(elm) {
						retour.push(prep[elm]);
					});
					retour.sort(function (a, b) {
						return (b.value - a.value);
					});
					retour.forEach(function(val, key) {
						val.color = colorSet[key % colorSet.length];
						val.value *= 100 / total;
						String(val.value = Number(val.value.toFixed(2)));
					});
					if (retour.length < 1)
					{
						return ([{
							value : 100,
							label : 'none',
							color:'#ccc'
						}]);
					}
					return (
						retour
					);
				}
			},
			methods: {
				getTransactionInvestissement: function (transaction) {
					var rt = transaction.prix_part * transaction.nbr_part;
					if (transaction.type_pro != 'Pleine propriété')
						rt *= (transaction.cle_repartition / 100);
					return (rt);
				},
			},
			template: '#chartRepartitionScpi'
		}
	);
</script>

<script type="text/x-template" id="chartRepartitionGeo">
	<div class="blockProjectRepartition">
		<pie-chart-component :name='name' :value="getValueForChart" style="flex:1;"></pie-chart-component>
		<div class="listRepartition">
			<div v-for="elm in getValueForChart" :style="{color: elm.color}">{{ elm.label }} : {{ elm.value | pourcent }}</div>
		</div>
	</div>
</script>

<script type="text/javascript" charset="utf-8">
	Vue.component(
		'chartRepartitionGeo',
		{
			props: {
				value: {
					default: []
				},
				name: {
					type: String,
					default: 'defaultChartRepartitionGeo',
					required: true
				}
			},
			computed: {
				getValueForChart: function() {
					var that = this;
					var prep  = {};
					var retour = [];
					var total = 0;
					var colorSet = [
						"#0085A9",
						"#014C7F",
						"#002640",
						"#006D7F",
						"#00C3E5",
						"#007F6C",
						"#007F6C",
						"#008A5E",
						"#0073B1",
						"#009491",
						"#00402B",
						"#01528A",
						"#007F3F"
					];
					this.value.map(function(elm, key) {
						var scpi = that.$store.getters.getScpi(elm.id_scpi);
						if (typeof prep[scpi.category] == 'undefined')
						{
							prep[scpi.category] = {
								label: scpi.category,
								value: 0,
								color: '#ccc'
							}
						}
						prep[scpi.category].value += that.getTransactionInvestissement(elm);
						total += that.getTransactionInvestissement(elm);
					});
					Object.keys(prep).map(function(elm) {
						retour.push(prep[elm]);
					});
					retour.sort(function (a, b) {
						return (b.value - a.value);
					});
					retour.forEach(function(val, key) {
						val.color = colorSet[key % colorSet.length];
						val.value *= 100 / total;
						String(val.value = Number(val.value.toFixed(2)));
					});
					if (retour.length < 1)
					{
						return ([{
							value : 100,
							label : 'none',
							color:'#ccc'
						}]);
					}
					return (
						retour
					);
				}
			},
			methods: {
				getTransactionInvestissement: function (transaction) {
					var rt = transaction.prix_part * transaction.nbr_part;
					if (transaction.type_pro != 'Pleine propriété')
						rt *= (transaction.cle_repartition / 100);
					return (rt);
				}
			},
			template: '#chartRepartitionGeo'
		}
	);
</script>

<script type="text/x-template" id="progressBarComponent">
	<div>
		<div class="progress2" onmouseover="display_val(this, event)" onmouseout="disable_val(event)">
			<div :style="{width: value + '%'}" class="progress-bar2 progress-bar-info2"></div>
		</div>
	</div>
</script>

<script type="text/javascript" charset="utf-8">
	Vue.component(
		'progressBarComponent',
		{
			data: function() {
				return ({
				});
			},
			props: {
				value: {
					default: 0
				}
			},
			template: '#progressBarComponent'
		}
	);
</script>

<script type="text/x-template" id="repartitionType">
	<div class="blockProjectRepartition" style="flex-direction:column;">
		<span class="tofVar" style="flex:1;">
			Capital variable : {{ getVariable | pourcent }}
		</span>
		<progress-bar-component :value="getVariable" style="flex:1;"></progress-bar-component>
		<span class="tofFix" style="flex:1;">
			Capital fixe : {{ (100 - getVariable) | pourcent }}
		</span>
	</div>
</script>

<script type="text/javascript" charset="utf-8">
	Vue.component(
		'repartitionType',
		{
			computed: {
				getVariable: function() {
					var that = this;
					var retour = 0;
					var total = 0;
					this.value.map(function(elm, key) {
						var scpi = that.$store.getters.getScpi(elm.id_scpi);
						if (scpi.TypeCapital != 'fixe')
							retour += that.getTransactionInvestissement(elm); 
						total += that.getTransactionInvestissement(elm);
					});
					retour *= 100 / total;
					return (retour);
				}
			},
			props: {
				value: {
					default: 0
				}
			},
			methods: {
				getTransactionInvestissement: function (transaction) {
					var rt = transaction.prix_part * transaction.nbr_part;
					if (transaction.type_pro != 'Pleine propriété')
						rt *= (transaction.cle_repartition / 100);
					return (rt);
				}
			},
			template: '#repartitionType'
		}
	);
