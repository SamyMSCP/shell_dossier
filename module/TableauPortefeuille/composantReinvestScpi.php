</script>


<script type="text/x-template" id="portefeuille_reinvest_tpl">
	<div class="modal fade modal_reinvest " id="tableau-transaction-reinvest-modal" tabindex="-1" role="dialog" aria-labelledby="modal_reinvest" >
		<div class="modal-dialog modal-lg">
			<div class="modal-content-regroupement modale-confirm">
				<div class="modal-body">
                    <div class="text-uppercase titre">
                        <h1 class="titreComposant">Information</h1>
                        <div @click='close()'>
                            <div class="close"><img src="/assets/close/Close-Jaune.svg"/></div>
                        </div>
                    </div>
                    <div>
                        <hr class="hr_bar">
                    </div>
					<div class="conteneur" style="margin: 30px 0;">
						<div class="bouton orange text-uppercase" @click="demandeContact">
							Je souhaite contacter un conseiller
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

</script>
<script>
    Vue.component('modal-reinvest-scpi', {
        template: "#portefeuille_reinvest_tpl",
        methods: {
            addPart: function () {
                // this.
            },
            close: function() {
                $('#tableau-transaction-reinvest-modal').modal('hide')
            },
            demandeContact: function() {
                this.$store.dispatch('CONTACT_CONSEILLER_REINVEST').then(
                   function(data){
                       msgBox.show(data.response);
                   },
                    function(data) {
                        msgBox.show(data.response);

                    }
                );
                $('#tableau-transaction-reinvest-modal').modal('hide')
            }
        }
    });
