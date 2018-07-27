</script>
<script type="text/x-template" id="portefeuille_vente_scpi">
<div class="modal fade modal_vente" id="tableau-transaction-vendre-modal" tabindex="-1" role="dialog" aria-labelledby="modal_vendre" >
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
                        Je souhaite vendre des parts avec mon conseiller
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


</script>

<script>
    Vue.component('modal-vente-scpi', {
        template: "#portefeuille_vente_scpi",
        methods: {
            addPart: function () {
                // this.
            },
            close: function() {
                $('#tableau-transaction-vendre-modal').modal('hide')
            },
            demandeContact: function() {
                this.$store.dispatch('CONTACT_CONSEILLER_VENTE').then(
                    function(data){
                        msgBox.show(data.response);
                    },
                    function(data) {
                        msgBox.show(data.response);
                    }
                );
                $('#tableau-transaction-vendre-modal').modal('hide')
            }
        }
    });