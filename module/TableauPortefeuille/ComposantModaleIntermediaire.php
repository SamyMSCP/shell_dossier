</script>
<script type="text/x-template" id="portefeuille_intermediaire">
<div class="modal fade modal_intermediaire" id="tableau-transaction-intermediaire-modal" tabindex="-1" role="dialog" aria-labelledby="modal_intermediaire" >
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-body">
				<h2 style="text-align: center;">Choisir la transaction</h2>
				<div @click='close()'>
					<div class="close"><img src="/assets/close/Close-Jaune.svg"/></div>
				</div>
				<div>
					<hr class="hr_bar">
				</div>
				<div class="conteneur" style="margin: 30px 0;">
					Veuillez choisir la transaction que vous souhaitez modifier.
				</div>
				<template v-for='(elm, key) in getSelectedTransactionIntermediaire'>
					<div v-if="key == 'buy'">
						<h3>Acquisition</h3>
					</div>
					<div v-else-if="key == 'sell'">
						<h3>Cession</h3>
					</div>
					<table v-if="key != 'precalcul'" class='tablePortefeuille'>
						<thead>
						<tr>
							<th>Nom de la SCPI</th>
							<th>Date d'aquisition</th>
							<th>Nombre de parts</th>
						</tr>
						</thead>
						<tbody>
							<tr @click='setTransaction(elm.id)' v-if="key == 'buy'" class='editable white-grey'>
								<td>{{ nom_scpi }}</td>
								<td>{{ elm.enr_date | date }}</td>
								<td>{{ elm.nbr_part}}</td>
							</tr>

						<template v-for='(elm1, key1) in elm' v-if='key == "sell"'>
							<tr @click='setTransaction(elm1.id)' class='white-grey editable'>
								<td>{{ nom_scpi }}</td>
								<td>{{ elm1.enr_date | date }}</td>
								<td>{{elm1.nbr_part_vente }}</td>
							</tr>
						</template>
						</tbody>
					</table>
				</template>
			</div>
		</div>
	</div>
</div>
</script>
<script>
	Vue.component('modal-intermediaire-scpi', {
		template: "#portefeuille_intermediaire",
		data: function() {
			return ({
			});
		},
		props: [
			"data"
		],
		methods: {
			close: function() {
				$('#tableau-transaction-intermediaire-modal').modal('hide')
			},
			setTransaction: function(idTransaction) {
				this.$store.dispatch('SET_SELECTED_TRANSACTION', idTransaction)
				$('#tableau-transaction-intermediaire-modal').modal('hide')
				$('#tableau-transaction-edit-modal').modal('show')
			},

		},
		computed: {
			getSelectedTransactionIntermediaire: function () {
				return this.$store.getters.getSelectedTransactionIntermediaire;
			},

			nom_scpi: function(){
				return (this.$store.getters.getSelectedTransaction.scpi);
			}

		}
	});
