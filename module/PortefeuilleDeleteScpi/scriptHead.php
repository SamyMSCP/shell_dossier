</script>
<script type = "text/x-template" id="modale-delete-scpi-template">
<?php require_once("template/modale_delete_scpi.php"); ?>
</script>

<script type="text/javascript">

	Vue.component("modaleSupprScpi", {
		template: "#modale-delete-scpi-template",
		data: function () {
			return {
			}
		},
		methods: {
			sendDelete: function () {
				$("#del_scpi").modal('hide');

				// $store.state.transactions.selectedTransaction.scpi
				this.$store.dispatch('TRANSACTIONS_DELETE', this.$store.state.transactions.selectedTransaction)
					.then(() => {
						swal({
							title: "Suppression de la SCPI",
							type: "success",
							timer: 1800,
							showConfirmButton: false
						}).then(() => {
							$("#modale_list_transact").modal("show");
						})
					},
						() => {
						swal({
							title: "Suppression Impossible !",
							text: "reessayez plus tard, Si l'erreur persiste, contactez votre conseiller.",
							type: "error"
						})
					})
			}
		},
		computed: {
		},
		filters: {
			money: function (data) {
				return parseFloat(data).toLocaleString("fr", {style: "currency", currency: "EUR"})
			},
			percent: function (data) {
				return parseFloat(data).toLocaleString("fr", {style: "percent", minimumFractionDigits: 1});
			}
		}}
	);