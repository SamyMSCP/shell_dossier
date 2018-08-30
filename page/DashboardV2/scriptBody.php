</script>
<script>
var Viii = new Vue({ el: "#transac", store: store})

new Vue({
	el: ".vueApp",
	store,
	data: {
		test: "TEST"
	},
	beforeCreate() {
		this.$options.filters.plus_value = this.$options.filters.plus_value.bind(this)
		this.$options.filters.montant_revente = this.$options.filters.montant_revente.bind(this)
	},
	computed: {
		montantTotal: function () {
			var tot = 0.0;
			this.$store.state.transactions.transactionsList.forEach(el => {
				tot += this.$options.filters.montant_revente(el);
			});
			return tot;
		},
		montantInvestis: function () {
			var tot = 0.0;
			this.$store.state.transactions.transactionsList.forEach(el => {
				if (!isNaN(this.$options.filters.montant_investissement(el)))
					tot += this.$options.filters.montant_investissement(el);
			});
			return tot;
		},
		list_data: function () {
			var data =[];
			var total = 0.0;
			var color =[
					"#086ab3",
					"#0b87e4",
					"#2c9ff5",
					"#5db5f8",
					"#8dcbfa",
					"#bee2fc",
					"#eff8fe"
					];
			store.state.transactions.transactionsList.forEach(trans => {
				total += ((trans.type_pro === "Pleine propriété") ? trans.ventePotentielle : trans.valorisation);
			})
			store.state.transactions.transactionsList.forEach(trans => {
				if (parseFloat((((trans.type_pro === "Pleine propriété") ? trans.ventePotentielle : trans.valorisation) / total * 100).toFixed(2)) !== 0) {
					data.push({
						value: parseFloat((((trans.type_pro === "Pleine propriété") ? trans.ventePotentielle : trans.valorisation) / total * 100).toFixed(2)),
						label: trans.scpi
					})
				}
			});
			data.sort((a,b) => { return b.value - a.value; });
			data.forEach((trans, i) => {
				trans.color = color[i]
			});

			if (data.length > 5) {
				var autre = data.slice(5);
				var res = 0;
				autre.forEach(el => {
					res += el.value;
				});
				data = data.splice(0, 5);
				data.push({
					value: res,
					label: "Autre",
					color: color[5]
				})
			}
			return data;
		}

	},
	filters: {
		propriete_short: function (data) {
			switch (data) {
				case "Pleine propriété":
					return "PP";
				case "Nue propriété":
					return "NP";
				case "Usufruit":
					return "US";
				default:
					return "-";
			}
		},
		capital_short: function (data) {
			switch (data) {
				case "variable":
					return "V";
				case "fixe":
					return "F";
				default:
					return "-";
			}
		},
		currency: function (data) {
			x = parseFloat(data);
			return isNaN(x) ? "-" : x.toLocaleString("fr", {style: "currency", currency: "EUR"})
		},
		percent: function (data) {
			var x = (parseFloat(data) / 100.0);
			return isNaN(x) ? "-" : x.toLocaleString("fr", {style: "percent", minimumFractionDigits: 2});
		},
		montant_investissement: function(trans) {
			var montant = 0.0;
			switch (trans.type_pro) {
				case "Pleine propriété":
					montant = (parseFloat(trans.prix_part) * parseFloat(trans.nbr_part));
					break;
				case "Nue propriété":
				case "Usufruit":
					montant = ((parseFloat(trans.cle_repartition) / 100.0) * parseFloat(trans.prix_part) * parseFloat(trans.nbr_part));
					break;
				default:
					montant = 0.0;
			}
			if (montant === 0.0)
				montant = NaN;
			return (montant);
		},
		montant_revente: function (trans) {
			switch (trans.type_pro) {
				case "Nue propriété":
					//return trans.ventePotentiellePleinePro;
				case "Pleine propriété":
					return trans.ventePotentielle;
				case "Usufruit":
					return trans.valorisation;
			}
			if (((trans.type_pro === "Pleine propriété") ? trans.ventePotentielle : trans.valorisation) !== 0.0)
				return ((trans.type_pro === "Pleine propriété") ? trans.ventePotentielle : trans.valorisation);
			return NaN;
		},
		plus_value: function(trans) {
			// console.log(this);
			var montant = this.$options.filters.montant_investissement(trans);
			// var revente = this.$options.filters.montant_revente(trans);
			var revente = trans.ventePotentielle;
			var val = (revente - montant) / montant * 100;
			if (val.toString() === "-Infinity" || val.toString() === "Infinity" || revente === 0.0)
				return "-";
			return val;
		}

	}
})
