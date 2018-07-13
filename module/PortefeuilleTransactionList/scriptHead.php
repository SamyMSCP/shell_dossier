</script>
<script type = "text/x-template" id="transaction_list_template" >
	<?php require_once("template/transaction_list_template.php"); ?>
</script>

<script type="text/javascript">

	Vue.component("transactionListComponent", {
			template: "#transaction_list_template",
			props: {
				listElement: {
					default: () => {
						return [];
					},
					type: Array
				}
			},
			data: function () {
				return {}
			},
			computed: {
				transactionTotal: function () {
					var self = this;
					var total = 0.0;
					this.list.forEach((el) => {
						switch (self.type) {
							//Ajouter les transaction nue->pleine
							case "Pleine propriété":
								if (el.type_pro === self.type)
									total += el.ventePotentielle;//(parseFloat(el.prix_part) * parseFloat(el.nbr_part));
								break;
							case "Nue propriété":
								if (el.type_pro === self.type)
									total += el.ventePotentielle;//((parseFloat(el.cle_repartition) / 100.0) * parseFloat(el.prix_part) * parseFloat(el.nbr_part));
								break;
							case "Usufruit":
								if (el.type_pro === self.type)
									total += el.ventePotentielle;//((parseFloat(el.cle_repartition) / 100.0) * parseFloat(el.prix_part) * parseFloat(el.nbr_part));
								break;
						}
					})
					return (total);
				},
				transactionFormating: function () {
					var self = this;
					var ret = this.list.map((el) => {
						switch (self.type) {
							case "Pleine propriété":
								return [
									el.scpi,
								];
							case "Nue propriété":
								return [
									el.scpi,
								];
							case "Usufruit":
								return [
									el.scpi,
								];
							default:
								return []
						}
					});

					return (ret);
				}
			},
			filters: {
				formatMoney: function (data) {
					return parseFloat(data).toLocaleString("fr", {style: "currency", currency: "EUR"})
				},
				percent: function (data) {
					return parseFloat(data).toLocaleString("fr", {style: "percent", minimumFractionDigits: 1});
				}
			},
		}
	);