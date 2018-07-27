</script>
<script type="text/x-template" id="multi_action_template">
	<div class="modal fade modal_regroupement" id="tableau-transaction-regroupement-modal" tabindex="-1" role="dialog" aria-labelledby="modal_regroupement">
		<div class="modal-dialog modal-lg">
			<div class="modal-content-regroupement">
				<div class="modal-body">
					<div class="grand-conteneur">
						<div class="text-uppercase titre">
							<h1 class="titreComposant">gérer mon portefeuille</h1>
							<div @click='close()'>
								<div class="close"><img src="/assets/close/Close-Jaune.svg"/></div>
							</div>
						</div>
						<div>
							<hr class="hr_bar">
						</div>
						<div class="conteneur">
							<div class="bouton blue" @click='showReinvest()'>
								<div class="text-uppercase">
									<div class="logo-regroupement"><img src="/assets/money/white.svg"/></div>
									<div class=" text-content">Investir dans une SCPI ou réinvestir</div>
								</div>
							</div>
							<div class="bouton green" @click='showAdd()'>
								<div class="text-uppercase">
									<div class="logo-regroupement"><img src="/assets/plus/white.svg" style="padding-top: 19px"/></div>
									<div class="text-content">ajouter une scpi que je détiens déjà</div>
								</div>
							</div>
                            <div class="bouton orange"  @click='showVente()'>
                                <div class="text-uppercase">
                                    <div class="logo-regroupement"><img src="/assets/Portefeuille/white.svg"/></div>
                                    <div class="text-content">vendre des scpi</div>
                                </div>
                            </div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</script>
<script>
	Vue.component(
		'multi-action-modale', {
			data: function() {
				return ({
					list_select: 0
				});
			},
			computed: {

			},
			methods: {
				close: function() {
					$('#tableau-transaction-regroupement-modal').modal('hide')
				},
				showReinvest: function() {
					switchModal('#tableau-transaction-regroupement-modal', '#tableau-transaction-reinvest-modal');
				},
                showVente: function() {
                    switchModal('#tableau-transaction-regroupement-modal', '#tableau-transaction-vendre-modal');
                },
                showModifier: function() {
                    switchModal('#tableau-transaction-regroupement-modal', '#tableau-transaction-modifier-modal');
                },
				showAdd: function() {
                    this.$store.dispatch("SET_NEW_SELECTED_TRANSACTION");
					switchModal('#tableau-transaction-regroupement-modal', '#tableau-transaction-edit-modal');
				}
			},
			template: "#multi_action_template"
		}
	);
