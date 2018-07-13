</script>
<script type = "text/x-template" id = "transaction_list_template_action" >
<?php require_once("template/transaction_list_template.php"); ?>
</script>

<script type="text/javascript">

	Vue.component("transactionListComponentAction", {
			template: "#transaction_list_template_action",
			props: {
				type: {
					default: () => {
						return "Type"
					},
					type: String
				},
				list: {
					default: () => {
						return [];
					},
					type: Array
				},
				action: {
					default: 0,
					type: Number
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
							case "Pleine propriété":
								if (el.type_pro === self.type)
									total += (parseFloat(el.prix_part) * parseFloat(el.nbr_part));
								break;
							case "Nue propriété":
								if (el.type_pro === self.type)
									total += ((parseFloat(el.cle_repartition) / 100.0) * parseFloat(el.prix_part) * parseFloat(el.nbr_part));
								break;
							case "Usufruit":
								if (el.type_pro === self.type)
									total += ((parseFloat(el.cle_repartition) / 100.0) * parseFloat(el.prix_part) * parseFloat(el.nbr_part));
								break;
						}
					});
					return (total);
				},
				transactionFiltered: function () {
					var self = this;
					return this.list.filter((el) => {
						switch (self.type) {
							case "Pleine propriété":
								var div = (el.debut_dividendes === null) ? '-' : moment(el.debut_dividendes.date);
								if (div !== "-" && el.type_pro === "Nue propriété" && moment().isAfter(div)) {
									return true;
								}
								return (el.type_pro === 'Pleine propriété');
							case "Nue propriété":
								var div = (el.debut_dividendes === null) ? "-" : moment(el.debut_dividendes.date);
								if ((moment().isAfter(div)))
									return (false);
								else
									return (el.type_pro === 'Nue propriété');
							case "Usufruit":
								return (el.type_pro === 'Usufruit')
							default:
							return false;
						}
					});
				}

			},
			methods: {
				transactionCalcul: function (el) {
					var total = 0.0;
					switch (this.type) {
						case "Pleine propriété":
							total += (parseFloat(el.prix_part) * parseFloat(el.nbr_part));
							break;
						case "Nue propriété":
							total += ((parseFloat(el.cle_repartition) / 100.0) * parseFloat(el.prix_part) * parseFloat(el.nbr_part));
							break;
						case "Usufruit":
							total += ((parseFloat(el.cle_repartition) / 100.0) * parseFloat(el.prix_part) * parseFloat(el.nbr_part));
							break;
					}
					return (total);
				},
				openVente: function (x) {
					this.$store.state.transactions.selectedTransaction = x;
					$(".modal").modal('hide');
					setTimeout(() => {
						$("#modal_sellPart_old").modal('show');
						setTimeout(() => {
							$('body').addClass("modal-open");
						}, 370);

					}, 370);
				},
				openDel: function(x) {
					this.$store.state.transactions.selectedTransaction = x;
					$(".modal").modal('hide');
					setTimeout(() => {
						$("#del_scpi").modal('show');
						setTimeout(() => {
							$('body').addClass("modal-open");
						}, 370);

					}, 370);
				},
				openReinvest: function(x) {
					this.$store.state.transactions.selectedTransaction = x;
					$(".modal").modal('hide');
					setTimeout(() => {
						$("#modal_reinvest").modal('show');
						setTimeout(() => {
							$('body').addClass("modal-open");
						}, 370);

					}, 370);
				},
				openModification: function(x) {
					this.$store.state.transactions.selectedTransaction = x;
					$(".modal").modal('hide');
					setTimeout(() => {
						$("#modal_transactio").modal('show');
						setTimeout(() => {
							$('body').addClass("modal-open");
						}, 370);

					}, 370);
				}
			},
			filters: {
				formatMoney: function (data) {
					return parseFloat(data).toLocaleString("fr", {style: "currency", currency: "EUR"})
				},
				percent: function (data) {
					return parseFloat(data).toLocaleString("fr", {style: "percent", minimumFractionDigits: 1});
				},
				moment: function (data) {
					if (data === 0) return "-";
					return moment.unix(data).format("DD/MM/YYYY");
				}
			},
		}
	);