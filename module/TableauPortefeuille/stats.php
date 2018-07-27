</script>
<script type="text/x-template" id="tableau_portefeuille_stats_component">
	<div style='display: flex;flex-direction: column;align-items: center;'>
		<div class='tableauPortefeuilleTitre'>
			<div>
				RÉPARTITION PAR TYPE DE PROPRIÉTÉ
			</div>
		</div>
		<div class="tableau_portefeuille_stats">
			<div class="graph_resp">
				<canvas id="stats-pleine-pro"></canvas>
				<div>
					<div style='color:#1781e0;'>{{ this.getCache['precalcul']['pourcentagePleine'] | pourcent}}</div>
					<div>PLEINE PROPRIÉTÉ</div>
				</div>
			</div>
			<div class="graph_resp">
				<canvas id="stats-nue-pro"></canvas>
				<div>
					<div style='color:#01528a;'>{{ this.getCache['precalcul']['pourcentageNue'] | pourcent}}</div>
					<div>NUE PROPRIÉTÉ</div>
				</div>
			</div>
			<div class="graph_resp">
				<canvas id="stats-usu"></canvas>
				<div>
					<div style='color:#8bb0c9;'>{{ this.getCache['precalcul']['pourcentageUsu'] | pourcent}}</div>
					<div>USUFRUIT</div>
				</div>
			</div>
		</div>
	</div>
</script>
<script>

	Vue.component(
		'tableau-portefeuille-stats', {

            data: function() {
                return {
                    chart: null
                }
            },
			methods: {
				create_graph: function() {
					var pieOptions = {
						maintainAspectRatio: false,
						tooltipFillColor: "rgba(255,255,255,1)",
						tooltipFontColor: "#000",
						percentageInnerCutout: 70,
						animation : true,
						responsive: true,
						tooltipFontSize: 12,
						tooltipTemplate:"<%if (label){%><%=label%>: <%}%><%= value %> %"
					};
					this.chart = {
						pleine: new Chart($('#stats-pleine-pro').get(0).getContext("2d")).Doughnut(this.pleine, pieOptions),
						nue: new Chart($('#stats-nue-pro').get(0).getContext("2d")).Doughnut(this.nue, pieOptions),
						usu: new Chart($('#stats-usu').get(0).getContext("2d")).Doughnut(this.usu, pieOptions)
					};
				},
                pourcentage: function (valeur, decimales) {
                    if (decimales === undefined) {
                        decimales = 2;
                    }
                    arrondi = Math.round(valeur * Math.pow(10, decimales)) / Math.pow(10, decimales);
                    return arrondi;
                },
			},
			computed: {
				pleine: function() {
					return([
						{ value: this.pourcentage(this.getCache['precalcul']['pourcentagePleine']), color: "#1781e0"},
						{ value:  this.pourcentage(100 - this.getCache['precalcul']['pourcentagePleine']), color: "#dddddd"},
					]);
				},
				nue: function() {
					return([
						{ value:  this.pourcentage(this.getCache['precalcul']['pourcentageNue']), color: "#01528a"},
						{ value:  this.pourcentage(100 - this.getCache['precalcul']['pourcentageNue']), color: "#dddddd"},
					]);
				},
				usu: function() {
					return([
						{ value:  this.pourcentage(this.getCache['precalcul']['pourcentageUsu']), color: "#8bb0c9"},
						{ value:  this.pourcentage(100 - this.getCache['precalcul']['pourcentageUsu']), color: "#dddddd"},
					]);
				},
				getCache: function(){
					return(this.$store.state.dh.precalcul);
				},
                getList: function (){
                    return store.state.transactions.transactionsList
                }
            },
            watch:{
                getCache: function () {

                    this.chart.pleine.destroy();
                    this.chart.nue.destroy();
                    this.chart.usu.destroy();
                    this.create_graph();
                }
            },
			mounted: function() {
				setTimeout(() => {
					this.create_graph();
				}, 1500);
			},
			template: "#tableau_portefeuille_stats_component"
		}
	);

