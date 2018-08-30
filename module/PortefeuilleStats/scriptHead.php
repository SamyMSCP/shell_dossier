</script>
<script type="text/x-template" id="stat-trans-all-template">
	<?php require_once("template/stats_template.php"); ?>
</script>

<script type="text/javascript">
	Vue.component("statTransAll", {
			template: "#stat-trans-all-template",
			props: {
				textTitle: {
					type: String,
					default: ""
				},
				data: {
					type: Object,
					default: {}
				}
			},
			data: function () {
				return {
					chart: null,
					data_chart: [
						{ value : 12, label : '12', color:'#000000'},
						{ value : 19, label : '19', color:'#333333'},
						{ value : 5, label : '5', color:'#666666'},
						{ value : 3, label : '3', color:'#999999'},
						{ value : 2, label : '2', color:'#CCCCCC'},
					],
				}
			},
			methods: {
				create_graph: function() {
					var pieOptions = {
						maintainAspectRatio: true,
						tooltipFillColor: "rgba(255,255,255,1)",
						tooltipFontColor: "#000",
						percentageInnerCutout: 70,
						animation : true,
						responsive: true,
						tooltipFontSize: 12,
						tooltipTemplate:"<%if (label){%><%=label%>: <%}%><%= value %> %"
					};
					this.chart = {
							pleine: new Chart($('#stats-plein-pro').get(0).getContext("2d")).Doughnut(this.data.pleine, pieOptions),
							nue: new Chart($('#stats-nue-pro').get(0).getContext("2d")).Doughnut(this.data.nue, pieOptions),
							usu: new Chart($('#stats-usu').get(0).getContext("2d")).Doughnut(this.data.usu, pieOptions)
						};
				}
			},
			computed: {
				getList: function (){
					return store.state.transactions.transactionsList
				},
				get_flag_pleine: function (){
					var list = store.state.transactions.transactionsList.filter(el => {
						return el.type_pro === "Pleine propriété" && el.flagMissingInfo === true
					});
					return (list.length > 0);
				},
				get_flag_nue: function (){
					var list = store.state.transactions.transactionsList.filter(el => {
						return el.type_pro === "Nue propriété" && el.flagMissingInfo === true
					});
					return (list.length > 0);
				},
				get_flag_usu: function (){
					var list = store.state.transactions.transactionsList.filter(el => {
						return el.type_pro === "Usufruit" && el.flagMissingInfo === true
					});
					return (list.length > 0);
				},
			},
            watch:{
                getList: function (value) {
                    this.chart.pleine.destroy();
                    this.chart.nue.destroy();
                    this.chart.usu.destroy();
                    this.create_graph();
                }
            },
			filters: {
				money: function (data) {
					return parseFloat(data).toLocaleString("fr", {style: "currency", currency: "EUR"})
				},
				percent: function (data) {
					if (isNaN(parseFloat(data)))
						return (0).toLocaleString("fr", {style: "percent", minimumFractionDigits: 1});
					return parseFloat(data).toLocaleString("fr", {style: "percent", minimumFractionDigits: 1});
				}
			},
			mounted: function() {
				setTimeout(() => {
					this.create_graph();
				}, 1500);
			}
		}
	);