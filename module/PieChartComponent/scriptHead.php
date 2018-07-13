</script>
<script type="text/x-template" id="pieChartComponent">
	<div>
		<div class="contour_RepCat">
			<canvas :id="name"></canvas>
		</div>
	</div>
</script>

<script type="text/javascript" charset="utf-8">
	Vue.component(
		'pieChartComponent',
		{
			data: function() {
				return ({
					piechart: null,
					ctx: null
				});
			},
			props: {
				value: {
					default: []
				},
				name: {
					type: String,
					default: 'defaultPie',
					required: true
				}
			},
			methods: {
				draw: function() {
					var pieOptions = {
						responsive: true,
						maintainAspectRatio: false,
						tooltipFillColor: "rgba(255,255,255,1)",
						tooltipFontColor: "#000",
						animation : false,
						tooltipFontSize: 12,
						tooltipTemplate:"<%if (label){%><%=label%>: <%}%><%= value %> %",
					};
					if (this.piechart)
						this.piechart.destroy();
					if (!this.ctx)
						this.ctx = $('#' + this.name).get(0).getContext("2d");
						var ctx = $('#' + this.name).get(0).getContext("2d");
					this.piechart = new Chart(ctx).Pie(this.value, pieOptions);
				}
			},
			mounted: function() {
				this.draw();
			},
			watch: {
				value: function() {
					var that = this;
					setTimeout(function() {
						that.draw();
					}, 200);
				}
			},
			template: '#pieChartComponent'
		}
	);
</script>

