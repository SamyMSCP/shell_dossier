</script>
<script>
var vueApp = new Vue({
	el: ".vueApp",
	store: store,
	data: {
	},
	computed: {
		getTotal: function () {
			var total = 0;
			var pleine = this.$store.state.transactions.transactionsList.filter((el) => { return (el.type_pro === 'Pleine propriété')});
			var nue = this.$store.state.transactions.transactionsList.filter((el) => { return (el.type_pro === 'Nue propriété')});
			var usu = this.$store.state.transactions.transactionsList.filter((el) => { return (el.type_pro === 'Usufruit')});

			pleine.forEach((el) => { total += el.ventePotentielle; })
			nue.forEach((el) => { total += el.valorisation; })
			usu.forEach((el) => { total += el.valorisation; })
			return (total);
		},
		getPanelData: function() {
			return ({
				tdvs: {
					title: "TDVS<br>MOYEN",
					img: 0,
					date: [
						{
							year: '2014',
							data: '.051'
						},
						{
							year: '2015',
							data: '.052'
						},
						{
							year: '2016',
							data: '.053'
						}
					]
				},
				tdvm: {
					title: "TDVM<br>MOYEN",
					img: 0,
					date: [
						{
							year: '2014',
							data: '.051'
						},
						{
							year: '2015',
							data: '.052'
						},
						{
							year: '2016',
							data: '.053'
						}
					]
				},
				tof: {
					title: "TOF MOYEN<br>(2T 2017)",
					img: 1,
					date: [
						{
							year: '2014',
							data: '.051'
						},
						{
							year: '2015',
							data: '.052'
						},
						{
							year: '2016',
							data: '.053'
						}
					]
				},
				revalorisation: {
					title: "Revalorisation n-1",
					img: 1,
					date: [
						{
							year: '2014',
							data: '.051'
						},
						{
							year: '2015',
							data: '.052'
						}
					]
				}
			});
		},
		get_set_color: () => {
			//7 95 170 
			//9 124 224
			//38 149 243
			//82 172 247
			//130 196 249
			return [
				"#075FAA",
				"#097CE0",
				"#2695F3",
				"#52ACF7",
				"#82C4F9"
				];

			return [
				"#01528a",
				"#3475a1",
				"#6797b9",
				"#99bad0"
			]
		},
		get_graph_settings_donut: function() {
			// console.log(this.$store.state.transactions.transactionsList);
			var fixe = this.$store.state.transactions.transactionsList.reduce((acc, el) => {
				var i = 0;
				switch (el.type_pro){
					case "Pleine propriété":
						i = parseFloat(el.ventePotentielle);
						break;
					case "Nue propriété":
						// i = (((parseFloat(el.cle_repartition) / 100.0) * parseFloat(el.prix_part) * parseFloat(el.nbr_part)) > 0) ? el.ventePotentielle : 0;
						i = parseFloat(el.valorisation);
						break;
					case "Usufruit":
						i = parseFloat(el.valorisation);
						break;
				}
				return (el.capital === 'fixe') ? i + acc : acc;
				}, 0.0);
			// var variable = this.$store.state.transactions.transactionsList.filter((el) => { return (el.capital === 'variable')}).length;
			var variable = this.$store.state.transactions.transactionsList.reduce((acc, el) => {
				var i = 0;
				switch (el.type_pro){
					case "Pleine propriété":
						i = parseFloat(el.ventePotentielle);
						break;
					case "Nue propriété":
						// i = (((parseFloat(el.cle_repartition) / 100.0) * parseFloat(el.prix_part) * parseFloat(el.nbr_part)) > 0) ? el.ventePotentielle : 0;
						i = parseFloat(el.valorisation);
						break;
					case "Usufruit":
						i = parseFloat(el.valorisation);
						break;
				}
				return (el.capital === 'variable') ? i + acc : acc;
				}, 0.0);
			fixe = parseFloat(fixe.toFixed(2));
			variable = parseFloat(variable.toFixed(2));
			var tot = fixe + variable;
			variable = (variable/tot * 100.0);
			variable = (isNaN(variable) ? 0.0 : variable);
			fixe = (fixe/tot * 100.0);
			fixe = (isNaN(fixe) ? 0.0 : fixe);
			variable = parseFloat(variable.toFixed(2));
			fixe = parseFloat(fixe.toFixed(2));
			return {
				type: "donut",
				data: [
					{ value : variable, label : 'Variable', color: this.get_set_color[0]},
					{ value : fixe, label : 'Fixe', color: this.get_set_color[1]},
				]
			}
		},
		get_graph_settings_pie: function() {
			var debug_text = "";
			var self = this;
			var x = store.state.transactions.transactionsList;
			var stats = {}
			var tot = 0;
			x.forEach(el => {
				var keys = [];
				if (!el.pieBiens)
					return;
				keys = (Object.keys(el.pieBiens));
				keys.forEach((p) => {

					if (el.pieBiens[p] !== null){
						tmp = parseFloat(el.pieBiens[p]);
						tmp = isNaN(tmp) ? 0 : tmp * ( el.type_pro === "Pleine propriété" ? el.ventePotentielle : el.valorisation);
						stats[p] = ((stats[p] !== undefined)) ? stats[p] + tmp : tmp;
						tot += tmp;
					}
				});
			})
			var data = [];
			var k = Object.keys(stats);
			k.forEach(el => {
				data.push({label: el, value: (parseFloat(stats[el].toFixed(2)) / tot * 100)});
			})
			data = data.sort((a, b) => {
				return (a.value < b.value);
			}).filter(el => {
				return (el.value !== 0.00);
			});
			if (data.length > 5) {
				var ret = data.slice(4);
				var new_elem = {value: 0, label: "Autre"};
				ret.forEach((con) => {
					new_elem.value += con.value;
				});
				data = data.slice(0, 4);
				data.push(new_elem);
			}
			data.forEach((el, index, array) => {
				el.value = parseFloat((el.value).toFixed(2));
				el.color = self.get_set_color[index];
			}, 0);
			return {
				type: "pie",
				data: data
			}
		},
		get_graph_settings_radar: function() {
			var x = store.state.transactions.transactionsList;
			var data = {region: .0, etranger: .0, idf: .0, paris: .0};
			x.forEach((el) => {
				if (el.pieGeo === null)
					return ;
				if (el.pieGeo['Ile-de-France'] !== null && !isNaN(parseFloat(el.pieGeo['Ile-de-France'])))
					data.idf += (parseFloat(el.pieGeo['Ile-de-France']) * ( el.type_pro === "Pleine propriété" ? el.ventePotentielle : el.valorisation));
				if (el.pieGeo['Paris'] !== null && !isNaN(parseFloat(el.pieGeo['Paris'])))
					data.paris += parseFloat(el.pieGeo['Paris']) * ( el.type_pro === "Pleine propriété" ? el.ventePotentielle : el.valorisation);
				if (el.pieGeo['Régions'] !== null && !isNaN(parseFloat(el.pieGeo['Régions'])))
					data.region += parseFloat(el.pieGeo['Régions']) * ( el.type_pro === "Pleine propriété" ? el.ventePotentielle : el.valorisation);
				if (el.pieGeo['Etranger'] !== null && !isNaN(parseFloat(el.pieGeo['Etranger'])))
					data.etranger += parseFloat(el.pieGeo['Etranger']) * ( el.type_pro === "Pleine propriété" ? el.ventePotentielle : el.valorisation);
			});
			var total = data.region + data.etranger + data.idf + data.paris;
			var self = this;
			var d = ([
				{ value: data.region, label: 'Régions'},
				{ value : data.etranger, label : 'Étranger'},
				{ value : data.idf, label : 'IDF'},
				{ value : data.paris, label : 'Paris'}
			]).sort((a, b) => {
				return (a.value < b.value);
			}).map(el => {
				el.value /= total;
				el.value *= 100;
				// el.value = parseFloat(el.value.toFixed(2));
				return (el);
			}).filter(el => {
				return (el.value !== 0.00);
			});
			d.forEach((el, index, array) => {
				el.value = parseFloat((el.value).toFixed(2));
				el.color = self.get_set_color[index];
			}, 0);
			return {
				type: "polar",
				data: d
			}
		},
		getStats: function() {
			var x = store.state.transactions.transactionsList;
			var data = {nue: 0, usu: 0, pleine: 0};
			var ret = {nue: null, usu: null, pleine: null};
			x.forEach((el) => {
				var div = (el.debut_dividendes === null) ? "-" : moment(el.debut_dividendes.date);
				if (el.type_pro === "Pleine propriété" || (div !== "-" && el.type_pro === "Nue propriété" &&  moment().isAfter(div)))
					data.pleine += el.ventePotentielle;//parseFloat(el.prix_part) * parseInt(el.nbr_part);
				if (el.type_pro === "Nue propriété" && !(div !== "-" && el.type_pro === "Nue propriété" &&  moment().isAfter(div)))
					data.nue += el.valorisation;//parseFloat(el.prix_part) * parseInt(el.nbr_part);
				if (el.type_pro === "Usufruit")
					data.usu += el.valorisation;//parseFloat(el.prix_part) * parseInt(el.nbr_part);
			});
			var total = data.nue + data.usu + data.pleine;
			var self = this;
/* ******************************************************************************************** */
			var d = ([
				{ value: data.nue / total * 100, label: 'Nue propriété'},
				{ value: (total - data.nue)  / total * 100, label: 'Autre'}
			]);
			d.forEach((el, index, array) => {
				el.value = parseFloat((el.value).toFixed(2));
				el.color = self.get_set_color[index];
			}, 0);
			d[1].color = "#d0d0d0";
			ret.nue = d;
/* ******************************************************************************************** */
			var d = ([
				{ value: data.usu / total * 100, label: 'Usufruit'},
				{ value: (total - data.usu)  / total * 100, label: 'Autre'}
			]);
			d.forEach((el, index, array) => {
				el.value = parseFloat((el.value).toFixed(2));
				el.color = self.get_set_color[index + 3];
			}, 0);
			d[1].color = "#d0d0d0";
			ret.usu = d;
/* ******************************************************************************************** */
			var d = ([
				{ value: data.pleine / total * 100, label: 'Pleine propriété'},
				{ value: (total - data.pleine)  / total * 100, label: 'Autre'}
			]);
			d.forEach((el, index, array) => {
				el.value = parseFloat((el.value).toFixed(2));
				el.color = self.get_set_color[index + 1];
			}, 0);
			d[1].color = "#d0d0d0";
			ret.pleine = d;
/* ******************************************************************************************** */
			return ret;
		}
	},
	filters: {
		formatMoney: function(data) {
			return parseFloat(data).toLocaleString("fr", {style: "currency", currency: "EUR"});
		},
		formatPercent: function (data) {
			return parseFloat(data).toLocaleString("fr", {style: "percent"});
		}
	},
	methods: {
		showMsgBoxIfi: function () {
	//msgBox.show("Vous voulez générer le document pour quel résidence fiscale ?",[
			msgBox.show("Pouvez-vous nous indiquer votre résidence fiscale au 01/01/2018 ?",[
				{
					text: "France",
					action: function()
					{
						window.open('index.php?p=ShowValeurIfi')
					}
				},
				{
					text: "Autre",
					action: function() {
						window.open('index.php?p=ShowValeurIfi&expatrie=1')
					}
				}
			]);
		}
	},
	mounted: function() {
		setTimeout(function() {
			$(".calendar").datepicker();
			$("[data-toggle='tooltip']").tooltip();
		}, 1000);
		<?php
			if ($GLOBALS['GET']['p'] === "Portefeuille"){
				if (isset($GLOBALS['GET']['mod'])) {
					?>
						console.log("WOW");
						store.commit('CHANGE_SELECTED', <?=$GLOBALS['GET']['mod']?>);
				<?php
				}
			}
		?>
	}
});