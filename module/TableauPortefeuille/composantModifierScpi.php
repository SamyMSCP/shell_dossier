</script>
<script type="text/x-template" id="portefeuille_modifier">
	<div class="modal fade modal_modifier" id="tableau-transaction-modifier-modal" tabindex="-1" role="dialog"
		 aria-labelledby="modal_modifier">
		<div class="modal-dialog modal-lg">
			<div class="modal-content confirm-delete" style="">
				<div class="modal-body">
					<div class="text-uppercase titre">
						<h1 class="titreComposant">ATTENTION</h1>
						<div @click='close()'>
							<div class="close"><img src="/assets/close/Close-Jaune.svg"/></div>
						</div>
					</div>
					<div class="colonne-modal" style="margin-bottom: 13px">
						<hr class="hr_bar">

						<div class="conteneur-text-alert">
							Attention, vous êtes sur le point de supprimer la SCPI <span style="font-weight: bold;"> {{selectedTransaction.scpi}}</span> de votre
							portefeuille. Cette action est irréversible.
							Êtes-vous sûr de votre choix ?
						</div>
						<div class="conteneur-button">
							<div class="" @click='delTr()'>
								<button class="button-oui">OUI</button>
							</div>
							<div class="" @click='retour()'>
								<button class="button-non">NON</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</script>
<script>
	Vue.component('modal-modifier-scpi', {
		template: "#portefeuille_modifier",
		methods: {
			close: function () {
				$('#tableau-transaction-modifier-modal').modal('hide')
			},
			delTr: function()
			{
				this.$store.dispatch("DELETE_TRANSACTION", this.selectedTransaction);
				$('#tableau-transaction-modifier-modal').modal('hide');
			},
			retour: function() {
				switchModal('#tableau-transaction-modifier-modal', '#tableau-transaction-edit-modal');
			},
		},
		computed: {
			selectedTransaction: function() {
				return (this.$store.getters.getSelectedTransaction);
			},
		}
	});
