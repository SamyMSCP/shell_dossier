<?php
/**
 * Created by PhpStorm.
 * User: vthomas
 * Date: 20/02/2018
 * Time: 17:14
 */
?>

<div class="modal fade mdlNew" id="add_scpi" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content" style="background-color:#EBEBEB">
			<div class="modal-header" style="margin-top: 10px;">
				<button type="button" class="close right" data-dismiss="modal"><img
							src="/assets/close/Close-Jaune.svg"/></button>
				<span class="modal-title text-uppercase">AJOUTER UNE SCPI QUE JE DÉTIENS DÉJÀ</span>
			</div>
			<div class="modal-body">
				<div class="container-fluid line"></div>
				<div class="container-fluid">
					<form class="form-horizontal">
<?php /* ********************************************* [ FORMULAIRE ] ********************************************* */?>
<?php /* ************************************************ [ SCPI ] ************************************************ */?>
						<div class="form-group">
							<label class="control-label col-sm-4" for="scpi_select">Nom de la SCPI</label>
							<div class="col-sm-5">
								<scpi-select :data="$store.state.scpi.lst" v-model="scpi"></scpi-select>
							</div>
						</div>
<?php /* *********************************************** [ PARTS ] ************************************************ */?>
						<div class="form-group">
							<label class="control-label col-sm-4" for="nbr_part">Nombre de parts achet&eacute;es</label>
							<div class="col-sm-5">
								<div class="row subrow">
									<div class="col-xs-11">
										<input type="number" step="any" class="form-control" min=0 placeholder="0" id="nbr_part" v-model.number="parts">
									</div>
									<div class="col-xs-1">
										<img class="icon status" src="/assets/status/valid.png" v-if="nbr_parts_valid"/>
										<img class="icon status" src="/assets/status/warning.ico" v-else/>
									</div>
								</div>
							</div>
						</div>
<?php /* ************************************************ [ TYPE ] ************************************************ */?>
						<div class="form-group">
							<label class="control-label col-sm-4" for="type_pro">Type de propriété</label>
							<div class="col-sm-5">
								<div class="row subrow">
									<div class="col-xs-11">
										<select class="form-control" v-model="type_pro" id="type_pro">
											<option>Pleine propriété</option>
											<option>Nue propriété</option>
											<option>Usufruit</option>
										</select>
									</div>
									<div class="col-xs-1">
										<img class="icon status" src="/assets/status/valid.png" v-if="type_pro_valid"/>
										<img class="icon status" src="/assets/status/warning.ico" v-else />
									</div>
								</div>
							</div>
						</div>
<?php /* ********************************************************************************************************** */?>
<?php
/*
 * Info complementaire si usu ou nue pro
 */?>
						<div v-if="type_pro == 'Nue propriété' || type_pro == 'Usufruit'">
<?php /* ********************************************************************************************************** */?>
							<div class="form-group">
								<label class="control-label col-sm-4" for="cle">Clé de répartition {{ type_pro }}</label>
								<div class="col-sm-5">
									<div class="row subrow">
										<div class="col-xs-11">
											<div class="input-group">
												<input type="number" step="any" class="form-control" placeholder="0" id="cle_rep" v-model.number="cle_rep">
												<span class="input-group-addon">%</span>
											</div>
										</div>
										<div class="col-xs-1">
											<img class="icon status" src="/assets/status/valid.png" v-if="cle_rep_valid"/>
											<img class="icon status" src="/assets/status/warning.ico" v-else />
										</div>
									</div>
								</div>
							</div>
<?php /* ********************************************************************************************************** */?>
							<div class="form-group">
								<label class="control-label col-sm-4" for="type_dem">Type de démembrement</label>
								<div class="col-sm-5">
									<div class="row subrow">
										<div class="col-xs-11">
											<select class="form-control" v-model="type_dem" id="type_dem">
												<option>Temporaire</option>
												<option>Viager</option>
											</select>
										</div>
										<div class="col-xs-1">
											<img class="icon status" src="/assets/status/valid.png" v-if="type_dem_valid"/>
											<img class="icon status" src="/assets/status/warning.ico" v-else />
										</div>
									</div>
								</div>
							</div>
<?php /* ********************************************************************************************************** */?>
							<div class="form-group">
								<label class="control-label col-sm-4" for="dure_dem">Durée de démembrement (en années)</label>
								<div class="col-sm-5">
									<div class="row subrow">
										<div class="col-xs-11">
											<input type="number" class="form-control" placeholder="0" id="dure_dem" v-model.number="dem_time">
										</div>
										<div class="col-xs-1">
											<img class="icon status" src="/assets/status/valid.png" v-if="dure_dem_valid"/>
											<img class="icon status" src="/assets/status/warning.ico" v-else />
										</div>
									</div>
								</div>
							</div>
<?php /* ********************************************************************************************************** */?>
						</div>
<?php /* ********************************************************************************************************** */?>
<?php
 /*
  * Debut des details
  * C'est ici que les informations complementaire sont rendue
  */
?>
						<div v-if="details.enabled">
<?php /* *************************************** [ DETAILS SUPPLEMENTAIRE ] *************************************** */?>
							<div class="form-group">
								<label class="control-label col-sm-4" for="date_enr">Date d'enregistrement</label>
								<div class="col-sm-5">
									<div class="row subrow">
										<div class="col-xs-11">
											<!-- <my-date-picker v-model="details.date_enr"></my-date-picker> -->
											<input type="text" step="any" class="form-control calendar" placeholder="JJ/MM/AAAA" id="date_enr" v-model="details.date_enr">
										</div>
										<div class="col-xs-1">
											<img class="icon status" src="/assets/status/valid.png" v-if="date_enr_valid"/>
											<img class="icon status" src="/assets/status/warning.ico" v-else />
										</div>
									</div>
								</div>
							</div>
<?php /* ********************************************************************************************************** */?>
							<div class="form-group">
								<label class="control-label col-sm-4" for="prix_part">Prix de la part en Pleine propriété (frais compris)</label>
								<div class="col-sm-5">
									<div class="row subrow">
										<div class="col-xs-11">
											<div class="input-group">
												<input type="number" step="any" class="form-control" placeholder="Prix de la part en euro" id="prix_part" min=0 v-model.number="details.prix_part">
												<span class="input-group-addon">&euro;</span>
											</div>
										</div>
										<div class="col-xs-1">
											<img class="icon status" src="/assets/status/valid.png" v-if="prix_part_valid"/>
											<img class="icon status" src="/assets/status/warning.ico" v-else />
										</div>
									</div>
								</div>
							</div>
<?php /* ********************************************************************************************************** */?>
							<div class="form-group">
								<label class="control-label col-sm-4" for="marche">Sélectionner un type de marché </label>
								<div class="col-sm-5">
									<div class="row subrow">
										<div class="col-xs-11">
											<select class="form-control" v-model="details.marcher">
												<option disabled >-</option>
												<option>Primaire</option>
												<option>Secondaire</option>
												<option>Gré à Gré</option>

											</select>
										</div>
										<div class="col-xs-1">
											<img class="icon status" src="/assets/status/valid.png" v-if="type_marcher_valid"/>
											<img class="icon status" src="/assets/status/warning.ico" v-else />
										</div>
									</div>
								</div>
							</div>
<?php /* ********************************************************************************************************** */?>
							<div class="form-group">
								<label class="control-label col-sm-4" for="marche">Transaction effectuée</label>
								<div class="col-sm-5">
									<div class="row subrow">
										<div class="col-xs-11">
											<select class="form-control" v-model.number="details.trans_avec">
												<option value="0">-</option>
												<option value="1">avec une Société de gestion</option>
												<option value="2">avec un CGPI</option>
												<option value="3">avec ma Banque</option>
												<option value="4">avec mon Assureur</option>
											</select>
										</div>
										<div class="col-xs-1">
											<img class="icon status" src="/assets/status/valid.png" v-if="trans_avec_valid"/>
											<img class="icon status" src="/assets/status/warning.ico" v-else />
										</div>
									</div>
								</div>
							</div>
							<div class="form-group" v-if="trans_avec_valid">
								<label class="control-label col-sm-4" for="info_comp">Information complémentaire</label>
								<div class="col-sm-5">
									<div class="row subrow">
										<div class="col-xs-11">
											<input type="text" :disabled="(details.trans_avec === 1)" :placeholder="get_placeholder_who" class="form-control" id="info_comp" v-model="details.info_comp">
										</div>
										<div class="col-xs-1">
											<img class="icon status" src="/assets/status/valid.png" v-if="type_marcher_valid"/>
											<img class="icon status" src="/assets/status/warning.ico" v-else />
										</div>
									</div>
								</div>
							</div>
<?php /* ********************************************************************************************************** */?>
							<div class="form-group">
								<label class="control-label col-sm-4" for="montant_emprunt">Montant emprunté </label>
								<div class="col-sm-5">
									<div class="row subrow">
										<div class="col-xs-11">
											<div class="input-group">
												<input type="number" class="form-control" v-model.number="details.emprunt.montant" id="montant_emprunt"/>
												<span class="input-group-addon">&euro;</span>
											</div>
										</div>
									</div>
								</div>
							</div>
<?php /* ********************************************************************************************************** */?>
							<div class="form-group">
								<label class="control-label col-sm-4" for="duree_emprunt">Mensualitée d'emprunt</label>
								<div class="col-sm-5">
									<div class="row subrow">
										<div class="col-xs-11">
											<div class="input-group">
												<input type="number" class="form-control" v-model.number="details.emprunt.duree" id="duree_emprunt" placeholder="Nombre de mois"/>
												<span class="input-group-addon">Mois</span>
											</div>
										</div>
										<div class="col-xs-1">
											<img class="icon status" src="/assets/status/valid.png" v-if="duree_emprunt_valid"/>
											<img class="icon status" src="/assets/status/warning.ico" v-else/>
										</div>
									</div>
								</div>
							</div>
<?php /* ********************************************************************************************************** */?>
							<div class="form-group">
								<label class="control-label col-sm-4" for="date_emprunt">Date de début </label>
								<div class="col-sm-5">
									<div class="row subrow">
										<div class="col-xs-11">
											<input type="text" class="form-control" v-model="details.emprunt.date_debut" id="date_emprunt" placeholder="JJ/MM/AAAA"/>
										</div>
										<div class="col-xs-1">
											<img class="icon status" src="/assets/status/valid.png" v-if="date_emprunt_valid"/>
											<img class="icon status" src="/assets/status/warning.ico" v-else-if="details.emprunt.date_debut !== ''" />
										</div>
									</div>
								</div>
							</div>
<?php /* ********************************************************************************************************** */?>
							<div class="form-group">
								<label class="control-label col-sm-4" for="taux_emprunt">Taux emprunt </label>
								<div class="col-sm-5">
									<div class="row subrow">
										<div class="col-xs-11">
											<div class="input-group">
												<input type="number" class="form-control" v-model.number="details.emprunt.taux" id="taux_emprunt" placeholder=""/>
												<span class="input-group-addon">%</span>
											</div>
										</div>
										<div class="col-xs-1">
											<img class="icon status" src="/assets/status/valid.png" v-if="taux_emprunt_valid"/>
											<img class="icon status" src="/assets/status/warning.ico" v-else/>
										</div>
									</div>
								</div>
							</div>
<?php /* ********************************************************************************************************** */?>
						</div>
<?php /* ******************************************* [ END OF DETAILS ] ******************************************* */?>
					</form>
				</div>
			</div>
			<div class="modal-footer">
				<div class="row">
					<div class="col-sm-6">
						<div class="small button orange" @click="add_scpi">Ajouter à mon portefeuille</div>
					</div>
					<div class="col-sm-6">
						<div class="small button light blue" @click="details.enabled = !details.enabled" v-if="details.enabled">Moins de détails</div>
						<div class="small button light blue" @click="details.enabled = !details.enabled" v-else>Plus de détails</div>
					</div>
				</div>
				<div class="row small">
					<div class="col-xs-12">
						Une question ? Contactez nous au 0 805 696 022 (appel gratuit depuis un fixe).
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

