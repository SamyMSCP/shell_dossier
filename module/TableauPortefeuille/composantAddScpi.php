</script>
<script type="text/x-template" id="portefeuille_add">
	<div class="modal fade modal_add" id="tableau-transaction-add-modal" tabindex="-1" role="dialog" aria-labelledby="modal_add" style="width: 50%; margin-left: auto; margin-right: auto">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-body">
					<div class='blockCaracteristiques'>
						<div class="text-uppercase">
							<h1>Ajouter une scpi que je détiens déjà</h1>
							<div @click='close()'>
								<div class="close"><img src="/assets/close/Close-Jaune.svg"/></div>
							</div>
						</div>
						<div>
							<hr class="hr_bar">
						</div>
						<div class='contenu'>
                            <div class='blockContenu'>
                                <div class="cache">
                                    <div class="composantsPropriete">
                                        <div class="proprieteTitleAdd">
                                            Nom de la SCPI
                                        </div>
                                        <div>
                                            <scpi-select :data="$store.state.scpi.lst" v-model="selectedTransaction.scpi"></scpi-select>
                                        </div>
                                    </div>
									<div class="composantsPropriete">
										<div class="proprieteTitleAdd">
											Nombre de parts achetées
										</div>
										<div>
											<input type="number" v-model="selectedTransaction.nbr_part" />
										</div>

									</div>
									<div class="composantsPropriete">
										<div class="proprieteTitleAdd">
											Type de propriété
										</div>
										<div class="selection">
											<select class="form-control" v-model="selectedTransaction.type_pro" id="type_pro">
												<option>Pleine propriété</option>
												<option>Nue propriété</option>
												<option>Usufruit</option>
											</select>
										</div>
									</div>
								</div>
								<div class="cache" v-if="selectedTransaction.type_pro == 'Nue propriété' || selectedTransaction.type_pro == 'Usufruit'">
									<div class="composantsPropriete">
										<div class="proprieteTitleAdd">
											Clé de répartition {{ selectedTransaction.type_pro }}
										</div>
										<div>
											<input type="number" v-model.number="selectedTransaction.cle_repartition">
										</div>
										<div>
											<img class="logo" src="/assets/status/valid.png"/>
											<img class="logo" src="/assets/status/warning.ico"/>
										</div>
									</div>
									<div class="composantsPropriete">
										<div class="proprieteTitleAdd">
											Type de démembrement
										</div>
										<div class="selection">
											<select class="form-control" id="type_dem">
												<option>Temporaire</option>
												<option>Viager</option>
											</select>
										</div>
										<div>
											<img class="logo" src="/assets/status/valid.png"/>
											<img class="logo" src="/assets/status/warning.ico"/>
										</div>
									</div>
									<div class="composantsPropriete">
										<div class="proprieteTitleAdd">
											Durée de démembrement (en années)
										</div>
										<div>
											<input type="number" v-model.number="selectedTransaction.demembrement">
										</div>
										<div>
											<img class="logo" src="/assets/status/valid.png"/>
											<img class="logo" src="/assets/status/warning.ico"/>
										</div>
									</div>
								</div>
								<div class="cache">
									<div class="composantsPropriete">
										<div class="proprieteTitleAdd">
											Date d'enregistrement
										</div>
										<div>
											<input type="date" v-model="selectedTransaction.enr_date">
										</div>
										<div>
											<img class="logo" src="/assets/status/valid.png"/>
											<img class="logo" src="/assets/status/warning.ico"/>
										</div>
									</div>
									<div class="composantsPropriete">
										<div class="proprieteTitleAdd">
											Prix de la part en Pleine propriété (frais compris)
										</div>
										<div>
											<input type="number" v-model.number="selectedTransaction.prix_part">
										</div>
									</div>
									<div class="composantsPropriete">
										<div class="proprieteTitleAdd">
											Sélectionner un type de marché
										</div>
										<div class="selection">
											<select class="form-control" v-model="selectedTransaction.marche">
												<option disabled >-</option>
												<option>Primaire</option>
												<option>Secondaire</option>
												<option>Gré à Gré</option>
											</select>
										</div>
									</div>
                                    <div class="composantsPropriete">
                                        <div class="proprieteTitleAdd">
                                            Transaction effectuée
                                        </div>
                                        <div class="selection">
                                            <select class="form-control">
                                                <option value="0">-</option>
                                                <option value="1">avec une Société de gestion</option>
                                                <option value="2">avec un CGPI</option>
                                                <option value="3">avec ma Banque</option>
                                                <option value="4">avec mon Assureur</option>
                                            </select>
                                        </div>
                                    </div>
								</div>
							</div>
						</div>

                        <div style="display:flex">
                            <div class='bouton orange' @click="save()"> ENREGISTRER ET FERMER </div>
                            <div class="bouton blue-light" >Moins de détails</div>
                            <div class="bouton blue-light" >Plus de détails</div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</script>
<script>
	Vue.component('modal-add-scpi',
		{
			template: "#portefeuille_add",
			data: function () {
				return { }
			},
			methods: {
				close: function() {
					$('#tableau-transaction-add-modal').modal('hide')
				},
				save: function() {
					this.$store.dispatch("SAVE_SELECTED_TRANSACTION");
				}
			},
			computed: {
				selectedTransaction: function() {
					return (this.$store.getters.getSelectedTransaction);
				},
				getError: function() {
					return (this.$store.getters.getError);
				}
			}

		});
