<div <?php echo 'class="modal fade modal_' . $tab[$i]['id'] . '"'; ?> tabindex="-2" role="dialog" aria-labelledby="myLargeModalLabel">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" style="text-align: center;">Transaction n° <?php echo ($i + 1)?> - Achat</h4>
			</div>
			<div class="modal-body">
				<div class="col-lg-12">
					<div class="well">
						<div class="row">
							<div class="col-lg-6">
								<?php if (empty($val = $tab[$i]['enr_date']))
									$val = "Inconnue";
								 echo  'Date de création : ' . htmlspecialchars(ft_decrypt_crypt_information($val)) . '<br><br>';
								?>
								</div>
								<div class="col-lg-6" style="text-align: right;">
								Conseiller <br><br>
								</div>
							</div>
							<div style="background-color : #C0C0C0; text-align: center; margin-top: -23px;"><h2>Etat de la transaction</h2></div>
							<div class="row" id="indice">
								<div class="col-lg-12">
									<div class="col-custom">
										<img src="<?=$this->getPath()?>img/n1.png">
									</div>
									<div class="col-custom">
										<img src="<?=$this->getPath()?>img/n2.png">
									</div>
									<div class="col-custom">
										<img src="<?=$this->getPath()?>img/n3.png">
									</div>
									<div class="col-custom">
										<img src="<?=$this->getPath()?>img/n4.png">
									</div>
									<div class="col-custom">
										<img src="<?=$this->getPath()?>img/n5.png">
									</div>
									<div class="col-custom">
										<img src="<?=$this->getPath()?>img/n6.png">
									</div>
									<div class="col-custom">
										<img src="<?=$this->getPath()?>img/n7.png">
									</div>
									<div class="col-custom">
										<img src="<?=$this->getPath()?>img/n8.png">
									</div>
								</div>
							</div>
							<div style="background-color : #C0C0C0; text-align: center;"><h2>Détails de la transaction</h2></div>
							<br>
							<div class="row">
									<table class="table" style="width: 96%; margin-left: 2%;">
										<thead style="background-color: #01528A;">
											<tr>
												<th>Nom de la SCPI</th>
												<th>Nombre de parts</th>
												<th>Marché</th>
												<th>Type de propriété</th>
												<th>Clé de répartition</th>
												<th>Durée du démembrement</th>
												<th>Prix d'achat/ prix de vente</th>
												<th>Montant total</th>
											</tr>
										</thead>
										<tbody>
											<?php
											echo '<tr style="cursor:pointer; text-align:center;" onmouseover="this.bgColor=\'#5bc0de\';" onmouseout="this.bgColor=\'white\';">';
												if (empty($val = $tab[$i]['Name']))
													$val = "Inconnue";
												echo '<td>' . htmlspecialchars(ft_decrypt_crypt_information($val)) . '</td>';
												if (empty($val = $tab[$i]['nbr_part']))
													$val = "Inconnue";
												echo '<td>' . htmlspecialchars(($val)) . '</td>';
												if (empty($val = $tab[$i]['marcher']))
													$val = "Inconnue";
												echo '<td>' . htmlspecialchars(ft_decrypt_crypt_information($val)) . '</td>';
												echo '<td>-</td>';
												if (empty($val = $tab[$i]['Name']))
													$val = "Inconnue";
												echo '<td>' . htmlspecialchars(ft_decrypt_crypt_information($val)) . '</td>';
												if (empty($val = $tab[$i]['type_pro']))
													$val = "Inconnue";
												echo '<td>' . htmlspecialchars(ft_decrypt_crypt_information($val)) . '</td>';
												if (empty($tab[$i]['prix_part']) || empty($tab[$i]['nbr_part']))
													$val = "Inconnue";
												echo '<td>' . htmlspecialchars($tab[$i]["prix_part"] * $tab[$i]['nbr_part']) . ' €</td>';
												?>
												<td>
											</tr>
										</tbody>
										</table>
									</div>
									<div class="row">
										<div class="col-lg-5" style="margin-left: 10px;">
											<form <?php echo 'action="?p=PEC&client=' . $id . '"'; ?> method="post">
												<?php
												if (ft_decrypt_crypt_information($tab[$i]['type_pro']) === "Usufruit"){
													echo 'Date d’entrée en jouissance';?>
													<input class="datepicker" name="date_usus" class="form-control" type="text" value=<?php if (!empty($tab[$i]['date_usufruit_s'])) echo '"' . strftime("%d/%m/%Y", $tab[$i]['date_usufruit_s']) . '"'; else echo '"' . date("d/m/Y") . '"'; ?> required>
												<script>
													 $('.datepicker').datepicker({
													 dateFormat: 'dd-mm-yy',
													 minDate: '+5d',
													 changeMonth: true,
													 changeYear: true,
													 altFormat: "yy-mm-dd",
													 language:"fr",
													 closeText: 'Fermer'
													});
												</script>
										   <?php echo '<br>Date de fin de jouissance'; ?>
										   <input class="datepicker_1" name="date_usuf" class="form-control" type="text" value=<?php if (!empty($tab[$i]['date_usufruit_f'])) echo '"' . strftime("%d/%m/%Y", $tab[$i]['date_usufruit_f']) . '"' ; else echo '"' . date("d/m/Y") . '"'; ?> required>
										   <script>
													 $('.datepicker_1').datepicker({
													 dateFormat: 'dd-mm-yy',
													 minDate: '+5d',
													 changeMonth: true,
													 changeYear: true,
													 altFormat: "yy-mm-dd",
													 language:"fr",
													 closeText: 'Fermer'
													});
												</script>
												<?php } ?>
									</div>
									<div class="col-lg-5">
										<br>Date de signature du BS<br>
										Date enregistrement
									</div>
								</div>
								<br>
								<div style="background-color : #C0C0C0; text-align: center;"><h2>Documents justificatifs</h2></div>
								<br>
							<div class="row" style="text-align: center;">
								<div class="col-lg-2">
									<img <?php echo 'onclick="$(\'.modal_euro_' . $tab[$i]['id'] . '\').modal(\'show\')"'; ?> src="<?=$this->getPath()?>img/euro.ico" <?php if (empty($tab[$i]['lien_euro']))
																														echo 'style="cursor:pointer; width: 100px; opacity: 0.4;"';
																														else
																															echo 'style="cursor:pointer; width: 100px;"'; ?>>
								</div>
								<div class="col-lg-2">
									<img <?php echo 'onclick="$(\'.modal_juge_' . $tab[$i]['id'] . '\').modal(\'show\')"'; ?> src="<?=$this->getPath()?>img/juge.ico" <?php if (empty($tab[$i]['lien_juge'])) echo 'style="cursor:pointer; width: 100px; opacity: 0.4;"'; else echo 'style="cursor:pointer; width: 100px;"';?>>
								</div>
								<div class="col-lg-2">
									<img <?php echo 'onclick="$(\'.modal_creditbank_' . $tab[$i]['id'] . '\').modal(\'show\')"'; ?> src="<?=$this->getPath()?>img/credit_bank.svg" <?php if (empty($tab[$i]['lien_creditbank'])) echo 'style="cursor:pointer; width: 100px; opacity: 0.4;"'; else echo 'style="cursor:pointer; width: 100px;"';?>>
								</div>
								<div class="col-lg-2">
									<img <?php echo 'onclick="$(\'.modal_dem_' . $tab[$i]['id'] . '\').modal(\'show\')"'; ?> src="<?=$this->getPath()?>img/dem.svg" <?php if (empty($tab[$i]['lien_dem'])) echo 'style="cursor:pointer; width: 100px; opacity: 0.4;"'; else echo 'style="cursor:pointer; width: 100px;"';?>>
								</div>
								<div class="col-lg-2">
									<img <?php echo 'onclick="$(\'.modal_bank_' . $tab[$i]['id'] . '\').modal(\'show\')"'; ?> src="<?=$this->getPath()?>img/bank.svg" <?php if (empty($tab[$i]['lien_bank'])) echo 'style="cursor:pointer; width: 100px; opacity: 0.4;"'; else echo 'style="cursor:pointer; width: 100px;"'?>>
								</div>
							</div>
							<div class="row">
								<div class="col-lg-2">
									<h2 style="font-size: 27px; text-align: center;">BS ou OA</h2>
								</div>
								<div class="col-lg-2">
									<h2 style="font-size: 27px; text-align: center;">CNP</h2>
								</div>
								<div class="col-lg-2">
									<h2 style="font-size: 25px; text-align: center;">Chèque<br>Ordre virement</h2>
								</div>
								<div class="col-lg-2">
									<h2 style="font-size: 27px; text-align: center;">Convention</br>démembrement</h2>
								</div>
								<div class="col-lg-2">
									<h2 style="font-size: 27px; text-align: center;">Offre de pret</h2>
								</div>
							</div>

									<textarea name="comm" style="margin: 0px; width: 100%; height: 126px;"><?php if (empty($tab[$i]['commentaire']))
														$txt = "Inconnue";
														echo htmlspecialchars($txt);?></textarea>
								<div style="text-align: center;">
									<button type="submit" name="scom" <?php echo 'value="' . intval($tab[$i]['id']) . '"'; ?> class="btn btn-lg btn-primary">Sauvegarder le commentaire</button>
								</div>
							  </form>
						</div>
					</div>

					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
					</div>
			</div>
		</div>
	</div> 
