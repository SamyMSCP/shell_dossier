</script>
<script type="text/x-template" id="portefeuille_cession_tpl">
	<?php require_once('template/modale_vente.php') ?>
</script>
<script type="text/javascript">
	Vue.component('modaleCession', {
		template: "#portefeuille_cession_tpl",
		data: function (){
			return {
				date: moment().format("DD/MM/YYYY"),
				nbr_part: 1,
				prix_part: 0
			};
		},
		methods: {
			sell: function() {
				var self = this;
				store.dispatch('TRANSACTIONS_SELL', self.prepareRequest).then(() => {
					$('#modal_sellPart_old').modal('hide');
					swal({
						type: "success",
						title: "Votre vente à bien été prise en compte !"
					})
				}).catch((res) => {
					let data = JSON.parse(res.bodyText);
					console.log(data);
					swal({
						type: "error",
						title: "Une erreur s'est produite !",
						text: data.err
					}).then(() => {
						$('#modal_sellPart_old').modal('show');
					});
				});
			}
		},
		computed: {
			prepareRequest: function () {
				var tmp_date = parseInt(moment(this.date, "DD/MM/YYYY").format("X"));
				var id = store.state.transactions.selectedTransaction ? store.state.transactions.selectedTransaction.id : 0;
				return {
					transaction_id: id,
					date_sell: tmp_date,
					nbr_part_sell: this.nbr_part,
					prix_part_sell: this.prix_part
				}
			}
		},
		mounted: function () {
			$( "#dateSelling").datepicker();
		}
	}
);