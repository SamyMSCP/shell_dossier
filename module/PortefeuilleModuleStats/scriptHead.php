</script>
<script type="text/x-template" id="stat-module-template">
	<?php require_once("template/stats_template.php"); ?>
</script>

<script type="text/javascript">
	Vue.component("statsModule", {
			template: "#stat-module-template",
			props: {
				textTitle: {
					type: String,
					default: ""
				},
				canvasId: {
					type: String,
					default: ""
				},
				typeGraph: {
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
			computed: {
				getList: function (){
					return store.state.transactions.transactionsList
				}
			},
			watch:{
				getList: function (value) {
					this.chart.destroy();
					this.create_graph();
				}
			},
			methods: {
				create_graph: function() {
					var ctx = $("#" + this.canvasId).get(0).getContext("2d");
					var pieOptions = {
						maintainAspectRatio: true,
						tooltipFillColor: "rgba(255,255,255,1)",
						tooltipFontColor: "#000",
						animation : true,
						responsive: true,
						tooltipFontSize: 12,
						tooltipTemplate:"<%if (label){%><%=label%>: <%}%><%= value %> %"
					};
					switch (this.typeGraph.type) {
						case "polar":
							this.chart = new Chart(ctx).PolarArea(this.typeGraph.data, pieOptions);
							break;
						case "donut":
							this.chart = new Chart(ctx).Doughnut(this.typeGraph.data, pieOptions);
							break;
						case "pie":
							this.chart = new Chart(ctx).Pie(this.typeGraph.data, pieOptions);
							break;
					}
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
				}, 1000);
			}
		}
	);