</script>
<script type="text/x-template" id="graphiqueportefeuillerepartition" >
	<div  style="marge" class="bloc-contient-repartition " v-if="getTotalValorisation !== 0">
		<div class="bloc-repartition">
			<div class="bloc-top-blue">
				<img class="icon-width" src="/assets/PieChart/DiagCircu_Blanc.png"/>

				<div class="bloc-text-repartition">
					RÉPARTITION PAR TYPE DE SCPI
				</div>

				<tooltip title="Répartition de mon portefeuille" size="big" content="Il s’agit de la répartition de chaque type de SCPI<br /> en fonction de la valeur de revente estimée." style='margin:10px;' align='right'>
					<img class="icon-width-i" src="/assets/info/i_Blanc-Negatif.png"/>
				</tooltip>
			</div>
			<div class="graph" style="position: relative; height: 30vh">
				<canvas  id="repart-type-scpi"></canvas>
			</div>
			<div class="margin-bot">
				<div v-for="(elm, key) in getRepartitionscpi" class="boucle-position">
					<div class="contient-bloc-boucle">
						<div v-bind:style="elm.background" class="rond-couleur">

						</div>
						<div class="text-boucle">{{ elm.nom }}</div>
						<div  class="withpourcent" v-bind:style="elm.color">
							{{ elm.value*100 | pourcentage }}
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="bloc-repartition">
			<div class="bloc-top-blue">
				<img class="icon-width" src="/assets/PieChart/DiagCircu_Blanc.png"/>

				<div class="bloc-text-repartition">
					RÉPARTITION PAR CATEGORIE
				</div>

				<tooltip title="Répartition par catégorie" size="big" content="Il s’agit de la répartition de votre portefeuille par catégorie de SCPI. <br>La répartition de votre portefeuille étant calculée par rapport à la dernière valeur connue de vente par part potentielle." style='margin:10px;' align='right'>
					<img class="icon-width-i" src="/assets/info/i_Blanc-Negatif.png"/>
				</tooltip>
			</div>
			<div  class="graph" style="position: relative; height: 30vh">
				<canvas  id="repart-categorie" style="position: relative; height:40vh; width:80vw"></canvas>
			</div>
			<div class="margin-bot">
				<div v-for="(elm, key) in repartition_categorie_front" class="boucle-position">
					<div class="contient-bloc-boucle">
						<div v-bind:style="elm.background" class="rond-couleur">

						</div>
						<div class="text-boucle">{{ elm.nom }}</div>
						<div class="withpourcent" v-bind:style="elm.color">
							{{ elm.value | pourcentage }}
						</div>
					</div>
				</div>
			</div>

		</div>
		<div class="bloc-repartition">
			<div class="bloc-top-blue">
				<img class="icon-width" src="/assets/PieChart/DiagCircu_Blanc.png"/>

				<div class="bloc-text-repartition">
					RÉPARTITION GEOGRAPHIQUE
				</div>

				<tooltip title="Répartition géographique" size="big" content="Il s’agit de la répartition géographique de votre portefeuille de SCPI global en fonction des<br> dernières informations communiquées par les sociétés de gestion (pondérée en fonction de la valeur de vente potentielle de chaque ligne de SCPI que vous détenez)." style='margin:10px;' align='right'>
					<img class="icon-width-i" src="/assets/info/i_Blanc-Negatif.png"/>
				</tooltip>
			</div>
			<div class="graph" style="position: relative; height: 30vh">
				<canvas  id="repartition-geographique" style="position: relative; height:40vh; width:80vw"></canvas>
			</div>
			<div class="margin-bot">
				<div v-for="(elm, key) in repartition_geographique_front" class="boucle-position">
					<div class="contient-bloc-boucle">
						<div class="rond-couleur" v-bind:style="elm.background">

						</div>
						<div class="text-boucle">{{ elm.nom }}</div>
						<div v-bind:style="elm.color" class="withpourcent">
							{{ elm.value | pourcentage }}
						</div>
					</div>
				</div>
			</div>
		</div>

	</div>

</script>
<script>
	Vue.component(
		'graphiqueportefeuillerepartition', {
			data: function () {
				return ({
					couleur : ["#01528a", "#3475a1", "#6797b9", "#99bad0","#89CCF6"],
					styleObject: {
					},
					chart: null
				});
			},
			methods: {
				create_graph: function () {
					var pieOptions_type_scpi = {
						responsive: true,
						maintainAspectRatio: false,
						tooltipFillColor: "rgba(255,255,255,1)",
						tooltipFontColor: "#000",
						percentageInnerCutout: 70,
						animation: true,
						tooltipFontSize: 12,
						tooltipTemplate: "<%if (label){%><%=label%>: <%}%><%= value %> %"
					};
					var repartition_categorie = {
						responsive: true,
						maintainAspectRatio: false,
						tooltipTemplate: "<%if (label){%><%=label%>: <%}%><%= value %> %"
					};
					var repartition_geographique = {
						responsive: true,
						maintainAspectRatio: false,
						tooltipTemplate: "<%if (label){%><%=label%>: <%}%><%= value %> %"
					};
					this.chart = {
						repartition_type_scpi: new Chart($('#repart-type-scpi').get(0).getContext("2d")).Doughnut(this.repartition_type_scpi, pieOptions_type_scpi),
						repartition_categorie: new Chart($('#repart-categorie').get(0).getContext("2d")).Pie(this.repartition_categorie, repartition_categorie),
						repartition_geographique: new Chart($('#repartition-geographique').get(0).getContext("2d")).Pie(this.repartition_geographique, repartition_geographique)
					};
				},

				pourcentage: function (valeur) {

					foiscent = valeur * 100;

				   var ok = Math.round(foiscent);
					return ok;
				},

				getOrdretrie: function (array) {
					return (array.sort(function (a, b) {
						return b.value - a.value;
					}))
				},



				remplaceUn: function(resultat) {
					return (resultat == 1 ? 1 : resultat);
				},
			},

			computed: {

				getTotalValorisation: function() {
					return (this.$store.state.dh.precalcul.precalcul.ventePotentielle);
				},

				getRepartitionscpi: function () {

					contient = ['pourcentageTypeVariable', 'pourcentageTypeFixe']
					var rt = [];


					for (var key in contient) {
						valeur = this.remplaceUn(this.getPrecalcul[contient[key]]);
						nom = contient[key].replace('pourcentageType', '');

						rt.push(
							{value: valeur, nom: nom,
							}
						);

					}



					var tableauTrier = this.getOrdretrie(rt);
					var tableaucouleur = [];
					for (var key in tableauTrier) {
						var couleur2 = this.couleur[key];
						var tabval = tableauTrier[key].value;
						var tabnom = tableauTrier[key].nom;
						tableaucouleur.push(
							{
								value: tabval,
								background: {
									background: couleur2,
								},
								nom: tabnom,
								color: {
									color: couleur2,
								}
							},
						)
					}

					return (tableaucouleur);
				},



				getPrecalcul: function () {

					return (this.$store.state.dh.precalcul['precalcul']);
				},
				repartition_type_scpi: function () {
					return ([
						{
							value: this.pourcentage(this.remplaceUn(this.getPrecalcul['pourcentageTypeFixe'])),
							color: "#01528a"
						}, //fixe
						{
							value: this.pourcentage(this.remplaceUn(this.getPrecalcul['pourcentageTypeVariable'])),
							color: "#3475a1"
						}, //variable
					]);
				},


				repartition_categorie: function () {
					var rt = [];
					var couleur = this.couleur;
					for (var key in this.getPrecalcul['repartitionCategorie']) {

						var elm = this.getPrecalcul['repartitionCategorie'][key];
						rt.push(
							{value: this.remplaceUn(this.pourcentage(elm))},
						);
					}
					var tableauTrier = this.getOrdretrie(rt);
					var tableaucouleur = [];
					for (var key in tableauTrier) {

						var couleur2 = couleur[key];
						var tab = tableauTrier[key].value;
						tableaucouleur.push(
							{value: tab, color: couleur2},
						)
					}

					return (tableaucouleur);
				},
				repartition_geographique: function () {
					var rt = [];
					var couleur = this.couleur;
					for (var key in this.getPrecalcul['repartitionGeographique']) {
						//console.log(key);

						var elm = this.getPrecalcul['repartitionGeographique'][key];
						//console.log(elm);

						rt.push(
							{value: this.remplaceUn(this.pourcentage(elm))},
						);
					}

					var tableauTrier = this.getOrdretrie(rt);
					var tableaucouleur = [];
					for (var key in tableauTrier) {
						var couleur2 = couleur[key];
						var tab = tableauTrier[key].value;
						tableaucouleur.push(
							{value: tab, color: couleur2},
						)
					}

					return (tableaucouleur);
				},


				repartition_geographique_front: function () {
					var rt = [];
					var couleur = this.couleur;
					for (var key in this.getPrecalcul['repartitionGeographique']) {
						//console.log(key);

						var elm = this.getPrecalcul['repartitionGeographique'][key];
						//console.log(elm);

						rt.push(
							{value:this.remplaceUn(this.pourcentage(elm)), nom: key},
						);
					}

					var tableauTrier = this.getOrdretrie(rt);
					var tableaucouleur = [];
					for (var key in tableauTrier) {
						var couleur2 = couleur[key];
						var tabval = tableauTrier[key].value;
						var tabnom = tableauTrier[key].nom;
						tableaucouleur.push(
							{
								value: tabval,
								background: {
									background: couleur2,
								},
								nom: tabnom,
								color: {
									color: couleur2,
								}
							},
						)
					}


					return (tableaucouleur);
				},

				repartition_categorie_front: function () {
					var rt = [];
					var couleur = this.couleur;
					for (var key in this.getPrecalcul['repartitionCategorie']) {
						//console.log(key);

						var elm = this.getPrecalcul['repartitionCategorie'][key];
						//console.log(elm);

						rt.push(
							{value: this.remplaceUn(this.pourcentage(elm)), nom: key},
						);
					}

					var tableauTrier = this.getOrdretrie(rt);
					var tableaucouleur = [];
					for (var key in tableauTrier) {
						var couleur2 = couleur[key];
						var tabval = tableauTrier[key].value;
						var tabnom = tableauTrier[key].nom;
						tableaucouleur.push(
							{
								value: tabval,
								background: {
									background: couleur2,
								},
								color: {
									color: couleur2,
								},
								nom: tabnom,
							},
						)
					}
					return (tableaucouleur);
				},
			},
			watch:{
				getPrecalcul: function (value) {
					this.chart.repartition_type_scpi.destroy();
					this.chart.repartition_categorie.destroy();
					this.chart.repartition_geographique.destroy();
					this.create_graph();
				}
			},
			mounted: function () {
				setTimeout(() => {
					this.create_graph();
				}, 1500);
			},
			filters: {
				foiscent: function (value) {
					if (value == 0) return '0'
					resultat = 100 * value
					return resultat
				},
				pourcentage: function (valeur, decimales) {
					if (decimales === undefined) {
						decimales = 2;
					}
					return Math.round(valeur * Math.pow(10, decimales)) / Math.pow(10, decimales) + ' %';
				},

				pourcent: function (valeur, decimales) {
					if (decimales === undefined) {
						decimales = 2;
					}
					arrondi = Math.round(valeur * Math.pow(10, decimales)) / Math.pow(10, decimales);
					foiscent = arrondi * 100;
					return foiscent;
				},
			},
			template: "#graphiqueportefeuillerepartition"
		}
	);

