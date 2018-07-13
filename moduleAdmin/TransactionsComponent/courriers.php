<?php
/**
 * Created by PhpStorm.
 * User: vthomas
 * Date: 29/01/2018
 * Time: 11:09
 */
?>
<div class="col-xs-2">
	<button class="btn-block btn-select-courrier text-uppercase" @click="showCourriers($store.state.transactions.selectedTransaction.id_scpi)">Courriers</button>
	<div id="modal-courrier" class="modal fade" role="dialog">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">

					<button type="button" class="close pull-right" aria-label="Close" onclick="$('#modal-courrier').modal('hide');">
						<img src="<?= $this->getPath() ?>img/Close-Jaune.svg" alt=""/>
					</button>

					<div class="text-center">
					<span class="modal-title">
						Selection courriers
					</span>



				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-xs-12">
							<select class="form-control" placeholder="Selection de courrier"
									@change.stop="courrier_selected = $event.target.value">
								<option disabled selected>Choisissez</option>
								<option v-for="el in courriers" :value="el.id">{{el.name}}</option>
							</select>
						</div>
					</div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-6">
                                <div class="btn btn-block" @click="civilite = 'Monsieur'" :class="(civilite == 'Monsieur') ? 'btn-primary' : 'btn-default'">Monsieur</div>
                            </div>
                            <div class="col-md-6">
                                <div class="btn btn-block" @click="civilite = 'Madame'" :class="(civilite == 'Madame') ? 'btn-primary' : 'btn-default'">Madame</div>
                            </div>
                        </div>
                    </div>
                    <div class="row col-md-12">
                    <div class="col-md-3">
                        <h4>Prenom</h4>
                    </div>
                            <div class="col-md-8">
                                <input class="form-control" placeholder="Prenom" v-model="prenom"/>
                            </div>
                    </div>
                    <div class="row col-md-12">
                        <div class="col-md-3">
                            <h4>Nom de famille</h4>
                        </div>
                        <div class="col-md-8">
                            <input class="form-control" placeholder="Nom" v-model="nomFamille"/>
                        </div>
                    </div>

                    <div class="row col-md-12">
                        <div class="col-md-3">
                            <h4>Ville</h4>
                        </div>
                        <div class="col-md-8">
                            <input class="form-control" placeholder="Ville" v-model="addresse.ville"/>
                        </div>
                    </div>
                    <div class="row col-md-12">
                        <div class="col-md-3">
                            <h4>Numéro de la rue</h4>
                        </div>
                        <div class="col-md-8">
                            <input class="form-control" placeholder="Numeroe de la rue" v-model="addresse.numeroRue"/>
                        </div>
                    </div>

                    <div class="row col-md-12">
                        <div class="col-md-3">
                            <h4>Nom de la rue</h4>
                        </div>
                        <div class="col-md-8">
                            <input class="form-control" placeholder="Le nom de la voie" v-model="addresse.nomDeLaVoie"/>
                        </div>
                    </div>

                    <div class="row col-md-12">
                        <div class="col-md-3">
                            <h4>Code postale</h4>
                        </div>
                        <div class="col-md-8">
                            <input class="form-control" placeholder="Code postale" v-model="addresse.zip"/>
                        </div>
                    </div>
					<div class="row">
						<div class="col-xs-4 col-xs-offset-4">
							<a class="btn btn-success btn-block" :class="(courrier_selected === 0) ? 'disabled' : ''"
							   target="_blank"
							   v-bind:href="get_url">Acceder
								au document</a>
						</div>
					</div>
				</div>
			</div>
			</div>
		</div>
	</div>
</div>
