<div class="modal fade" id="suivi_crm2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-body">
				<form class="form-horizontal" <?php echo 'action="admin_lkje5sjwjpzkhdl42mscpi.php?p=EditionClient&client=' . $GLOBALS['GET']["client"] .'"'; ?> method="post">
					<input type="hidden" name="token" id="token" value="<?php echo $_SESSION['csrf'][0]; ?>"/>
					<fieldset>
						<div class="phase1">
							<div class="listBeneficiaire">
								<div onclick="document.getElementById('radios-0').checked = true; crm2()" class="listBeneficiaireElmt1" style="width: 25%;">
									<div class="listBeneficiaireElmt2">
										<h3>Appel</h3>
										<div>
											<img src="<?=$this->getPath() . "img/CRM_Phone-White.png"?>">
										</div>
									</div>
								</div>
								<div onclick="document.getElementById('radios-1').checked = true; crm2()" class="listBeneficiaireElmt1" style="width: 25%;">
									<div class="listBeneficiaireElmt2">
										<h3>E-mail</h3>
										<div>
											<img src="<?=$this->getPath() . "img/CRM_Email-White.png"?>">
										</div>
									</div>
								</div>
								<div onclick="document.getElementById('radios-2').checked = true; crm2()" class="listBeneficiaireElmt1" style="width: 25%;">
									<div class="listBeneficiaireElmt2">
										<h3>Lettre</h3>
										<div>
											<img src="<?=$this->getPath() . "img/CRM_Envelop-White.png"?>">
										</div>
									</div>
								</div>
								<div onclick="document.getElementById('radios-3').checked = true; crm2()" class="listBeneficiaireElmt1" style="width: 25%;">
									<div class="listBeneficiaireElmt2">
										<h3>Rendez-vous physique</h3>
										<div>
											<img src="<?=$this->getPath() . "img/CRM_QA-White.png"?>">
										</div>
									</div>
								</div>
							</div>
							<!--
							<div class="BtnCrmAction">
								<div onclick="document.getElementById('radios-0').checked = true; crm2()">Appel Téléphonique</div>
								</div>
							<div class="BtnCrmAction">
								<div onclick="document.getElementById('radios-1').checked = true; crm2()">E-mail</div>
							</div>
							<div class="BtnCrmAction">
								<div onclick="document.getElementById('radios-2').checked = true; crm2()">Lettre Postale</div>
							</div>
							<div class="BtnCrmAction">
								<div onclick="document.getElementById('radios-3').checked = true;; crm2()">RDV / Entretien</div>
							</div>-->
									<div style="display: none">
										<label class="radio-inline" for="radios-0">
											<input type="radio" name="radios" id="radios-0" value="1" checked="checked">
										</label>
										<label class="radio-inline" for="radios-1">
											<input type="radio" name="radios" id="radios-1" value="2">
										</label>
										<label class="radio-inline" for="radios-2">
											<input type="radio" name="radios" id="radios-2" value="3">
										</label>
										<label class="radio-inline" for="radios-3">
											<input type="radio" name="radios" id="radios-3" value="4">
										</label>
									</div>
						</div>
						<div class="phase2">
							<div class="listBeneficiaire">
								<div onclick="document.getElementById('choix_bieres').value = 'GUIDES'; crm3()" class="listBeneficiaireElmt1" style="width: 25%;">
									<div class="listBeneficiaireElmt2">
										<h3>GUIDES</h3>
										<div>
											<img src="<?=$this->getPath() . "img/CRM_Guide-White.png"?>">
										</div>
									</div>
								</div>
								<div onclick="document.getElementById('choix_bieres').value = 'RELANCE'; crm3()" class="listBeneficiaireElmt1" style="width: 25%;">
									<div class="listBeneficiaireElmt2">
										<h3>RELANCE</h3>
										<div>
											<img src="<?=$this->getPath() . "img/CRM_Relance-White.png"?>">
										</div>
									</div>
								</div>
								<div onclick="document.getElementById('choix_bieres').value = 'ENVOI PROPOSITION'; crm3()" class="listBeneficiaireElmt1" style="width: 25%;">
									<div class="listBeneficiaireElmt2">
										<h3>ENVOI PROPOSITION</h3>
										<div>
											<img src="<?=$this->getPath() . "img/CRM_Proposition-White.png"?>">
										</div>
									</div>
								</div>
								<div onclick="document.getElementById('choix_bieres').value = 'SUIVI SOUSCRIPTION'; crm3()" class="listBeneficiaireElmt1" style="width: 25%;">
									<div class="listBeneficiaireElmt2">
										<h3>SUIVI SOUSCRIPTION</h3>
										<div>
											<img src="<?=$this->getPath() . "img/CRM_SuiviSous-White.png"?>">
										</div>
									</div>
								</div>
							</div>
							<div style="display: none;">
								<input id="choix_bieres" name="action" type="text">
								<input id="date1" name="date" class="form-control" type="date" <?php echo 'value="' . date('Y-m-d') . '"'; ?> required>
							</div>
						</div>
						<div class="phase3">
							<h2>Date prochaine action :</h2>
							<br/><br/><br/>
							<div class="col-md-8">
								<input id="date2" type="date" style="padding: 4px; margin-top: 42px;" name="date_r" class="form-control" <?php echo 'value="' . date('Y-m-d') . '"'; ?> required="1">
								<input id="date2" type="time" style="padding: 4px; margin-top: 42px;" name="heure" class="form-control" <?php echo 'value="' . date('H:i') . '"'; ?> required="1">
							</div>
							<div class="listBeneficiaire">
								<div onclick="crm4()" class="listBeneficiaireElmt1" style="width: 25%;">
									<div class="listBeneficiaireElmt2">
										<h3>Valider</h3>
										<div>
											<img src="<?=$this->getPath() . "img/CRM_SuiviSous-White.png"?>">
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="phase4">
							<h2>Faut-t'il preparer des éléments pour la prochaine action ?</h2>
							<div class="listBeneficiaire">
								<div onclick="crm5();" class="listBeneficiaireElmt1" style="width: 25%;">
									<div class="listBeneficiaireElmt2">
										<h3>Oui</h3>
										<div>
											<img src="<?=$this->getPath() . "img/Dossiers-blanc_open.png"?>">
										</div>
									</div>
								</div>
								<div onclick="crm6();" class="listBeneficiaireElmt1" style="width: 25%;">
									<div class="listBeneficiaireElmt2">
										<h3>Non</h3>
										<div>
											<img src="<?=$this->getPath() . "img/Dossiers-blanc_closed.png"?>">
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="phase5">
							<h2>Moyen de communication :</h2>
							<div class="listBeneficiaire">
								<div id="selected_btn_1" onclick="document.getElementById('action_r_picto').value = 1; selected_btn(this)" class="listBeneficiaireElmt1" style="width: 25%;">
									<div class="listBeneficiaireElmt2">
										<h3>Appel</h3>
										<div>
											<img src="<?=$this->getPath() . "img/CRM_Phone-White.png"?>">
										</div>
									</div>
								</div>
								<div id="selected_btn_2" onclick="document.getElementById('action_r_picto').value = 2; selected_btn(this)" class="listBeneficiaireElmt1" style="width: 25%;">
									<div class="listBeneficiaireElmt2">
										<h3>E-mail</h3>
										<div>
											<img src="<?=$this->getPath() . "img/CRM_Email-White.png"?>">
										</div>
									</div>
								</div>
								<div id="selected_btn_3" onclick="document.getElementById('action_r_picto').value = 3; selected_btn(this)" class="listBeneficiaireElmt1" style="width: 25%;">
									<div class="listBeneficiaireElmt2">
										<h3>Lettre</h3>
										<div>
											<img src="<?=$this->getPath() . "img/CRM_Envelop-White.png"?>">
										</div>
									</div>
								</div>
								<div id="selected_btn_4" onclick="document.getElementById('action_r_picto').value = 4; selected_btn(this)" class="listBeneficiaireElmt1" style="width: 25%;">
									<div class="listBeneficiaireElmt2">
										<h3>Rendez-vous physique</h3>
										<div>
											<img src="<?=$this->getPath() . "img/CRM_QA-White.png"?>">
										</div>
									</div>
								</div>
							</div>
							<h2>Que faut-il preparer ?</h2>
							<div class="listBeneficiaire">
								<div id="Etudes" onclick="btnEtudes()" class="listBeneficiaireElmt1" style="width: 25%;">
									<div class="listBeneficiaireElmt2">
										<h3>Etudes</h3>
										<div>
											<img src="<?=$this->getPath() . "img/CRM_SuiviSous-White.png"?>">
										</div>
									</div>
								</div>
								<div id="qa" onclick="btnqa()" class="listBeneficiaireElmt1" style="width: 25%;">
									<div class="listBeneficiaireElmt2">
										<h3>Q/A</h3>
										<div>
											<img src="<?=$this->getPath() . "img/CRM_QA-White.png"?>">
										</div>
									</div>
								</div>
								<div id="valide_btn" onclick="crm6()" class="listBeneficiaireElmt1" style="width: 25%;">
									<div class="listBeneficiaireElmt2">
										<h3>Valider</h3>
										<div>
											<img src="<?=$this->getPath() . "img/CRM_Email-White.png"?>">
										</div>
									</div>
								</div>
							</div>
						</div>
						<div style="display: none;">
							<input id="action_r" name="action_r" type="text">
							<input type="hidden" id="action_r_picto" name="MOC_F">
						</div>
						<div class="phase6">
						<div class="row">
							<div class="col-md-10">
							<div class="form-group">
								<label class="col-md-2 control-label" for="commentaire_r">Commentaire</label>
								<div class="col-md-10">
									<textarea class="form-control" id="textarea" name="commentaire_r"></textarea>
								</div>
							</div>
							</div>
							<div class="col-md-2">
							<div class="form-group">
								<div class="col-ms-6">
									<button id="singlebutton" name="singlebutton" value="setCrm" class="btn btn-primary">Envoi</button>
								</div>
							</div>
							</div>
						</div>
						</div>
					</fieldset>
				</div>
			</form>
		</div>
	</div>
</div>



<div class="modal fade" id="suivi_crm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-body">
				<form class="form-horizontal" <?php echo 'action="admin_lkje5sjwjpzkhdl42mscpi.php?p=EditionClient&client=' . $GLOBALS['GET']["client"] .'"'; ?> method="post">
					<input type="hidden" name="token" id="token" value="<?php echo $_SESSION['csrf'][0]; ?>"/>
					<fieldset>
						<div class="first-column">
							<div class="col-lg-12" style="position: absolute; width: 47%; left : 4px;">
								<div class="alert alert-warning" role="alert">
									<p style="font-style: bold;"><strong>DONE :</strong></p> 
								</div>
								<div class="form-group">
									<label class="col-ms-6 control-label">Action</label>
									<div class="col-md-12">
										<input id="choix_bieres" name="action" class="col-md-12" type="text" list="elements" required>
											<datalist id="elements">
												<select class="form-control">
													<option value="Demande d'information">1) Demande d'information</option>
													<option value="Envoi guide de l’investissement en SCPI">2) Envoi guide de l’investissement en SCPI</option>
													<option value="Envoi guide SCPI Fiscale">3) Envoi guide SCPI Fiscale</option>
													<option value="Envoi guide la déclaration">4) Envoi guide la déclaration</option>
													<option value="Envoi Guide du démembrement">5) Envoi Guide du démembrement</option>
													<option value="Envoi guide des acquisition">6) Envoi guide des acquisition</option>
													<option value="Envoi fiche explicative">7) Envoi fiche explicative</option>
													<option value="Envoi BT MeilleureSCPI.com">8) Envoi BT MeilleureSCPI.com</option>
													<option value="Echange sur le projet d'investissement">9) Echange sur le projet d'investissement</option>
													<option value="Document d'accompagnement (LM + QC + PI)">10) Document d'accompagnement (LM + QC + PI)</option>
													<option value="Envoi simulation">11) Envoi simulation</option>
													<option value="Envoi comparaison">12) Envoi comparaison</option>
													<option value="Envoi REC">13) Envoi REC</option>
													<option value="Envoi document de souscription">14) Envoi document de souscription</option>
													<option value="Eléments pour régularisation dossier de souscription">15) Eléments pour régularisation dossier de souscription</option>
													<option value="Envoi CNP">16) Envoi CNP</option>
													<option value="Suivi post-souscription">17) Suivi post-souscription</option>
													<option value="Suivi déclaration fiscale">18) Suivi déclaration fiscale</option>
													<option value="...">Autre ...</option>
												</select>
											</datalist>
										</div>
									</div>
									<div class="form-group">
										<label class="col-ms-6 control-label" for="date">Date</label>
										<div class="col-ms-6">
											<div class="input-group">
												<span class="input-group-addon">DATE</span>
												<input id="date1" name="date" class="form-control" type="date" <?php echo 'value="' . date('Y-m-d')/*date("d/m/Y")*/ . '"'; ?> required>
											</div>
										</div>
									</div>
									<div class="form-group">
										<label class="col-ms-6 control-label" for="radios">Moyen de communication</label>
										<div class="col-ms-6"> 
											<label class="radio-inline" for="radios-0">
												<input type="radio" name="radios" id="radios-0" value="1" checked="checked">
												<img src="img/phone.ico" style="width: 50px;" alt="Téléphone">
											</label> 
											<label class="radio-inline" for="radios-1">
												<input type="radio" name="radios" id="radios-1" value="2">
												<img src="img/mail.ico" style="width: 50px;" alt="E-mail">
											</label> 
											<label class="radio-inline" for="radios-2">
												<input type="radio" name="radios" id="radios-2" value="3">
												<img src="img/letter.ico" style="width: 50px;" alt="Voie postale">
											</label> 
											<label class="radio-inline" for="radios-3">
												<input type="radio" name="radios" id="radios-3" value="4">
												<img src="img/info.ico" style="width: 50px;" alt="Demande d'informations">
											</label>
										</div>
									</div>

									<!-- Multiple Checkboxes -->
									<div class="form-group">
										<label class="col-ms-6 control-label" for="checkboxes">Project</label>
										<div class="col-ms-6">
											<div class="checkbox">
												<p class="help-block">Pas de projet crée.</p>
											</div>
										</div>
									</div>

									<!-- Textarea -->
									<div class="form-group">
										<label class="col-ms-6 control-label" for="commentaire">Commentaire</label>
										<div class="col-ms-6">                     
											<textarea class="form-control" id="textarea" name="commentaire" required></textarea>
										</div>
										<p class="help-block errormsg" style="color: red">Anomalie date incorrect</p>
									</div>
								</div>
							</div>
							<div class="second-column col-lg-11">
								<div class="margin_for">
									<div class="alert alert-warning" role="alert">
										<p style="font-style: bold;"><strong>TO DO :</strong></p> 
									</div>
							
									<!-- Prepended text-->
									<div class="form-group">
										<label class="col-ms-6 control-label">Action</label>
									<div class="col-md-12">
										<input name="action_r" class="col-md-12" type="text" list="elements_r" required>
										<datalist id="elements_r">
											<select class="form-control">
												<option value="Demande d'information">1) Demande d'information</option>
												<option value="Envoi guide de l’investissement en SCPI">2) Envoi guide de l’investissement en SCPI</option>
												<option value="Envoi guide SCPI Fiscale">3) Envoi guide SCPI Fiscale</option>
												<option value="Envoi guide la déclaration">4) Envoi guide la déclaration</option>
												<option value="Envoi Guide du démembrement">5) Envoi Guide du démembrement</option>
												<option value="Envoi guide des acquisition">6) Envoi guide des acquisition</option>
												<option value="Envoi fiche explicative">7) Envoi fiche explicative</option>
												<option value="Envoi BT MeilleureSCPI.com">8) Envoi BT MeilleureSCPI.com</option>
												<option value="Echange sur le projet d'investissement">9) Echange sur le projet d'investissement</option>
												<option value="Document d'accompagnement (LM + QC + PI)">10) Document d'accompagnement (LM + QC + PI)</option>
												<option value="Envoi simulation">11) Envoi simulation</option>
												<option value="Envoi comparaison">12) Envoi comparaison</option>
												<option value="Envoi REC">13) Envoi REC</option>
												<option value="Envoi document de souscription">14) Envoi document de souscription</option>
												<option value="Eléments pour régularisation dossier de souscription">15) Eléments pour régularisation dossier de souscription</option>
												<option value="Envoi CNP">16) Envoi CNP</option>
												<option value="Suivi post-souscription">17) Suivi post-souscription</option>
												<option value="Suivi déclaration fiscale">18) Suivi déclaration fiscale</option>
												<option value="...">Autre ...</option>
											</select>
										</datalist>
									</div>
								</div>
								<div class="form-group">
									<label class="col-ms-6 control-label" for="date_r">Date prochaine action</label>
									<div class="col-ms-6">
										<div class="input-group">
											<span class="input-group-addon">DATE</span>
											<input id="date2" type="date" style="padding: 4px;" name="date_r" class="form-control" <?php echo 'value="' . date('Y-m-d') . '"'; ?> required="1">
										</div>
									</div>
								</div>
								<div class="form-group">
									<label class="col-ms-6 control-label" for="radios1">Moyen de communication</label>
									<div class="col-ms-6"> 
										<label class="radio-inline" for="radios-4">
											<input type="radio" name="radios1" id="radios-4" value="1" checked="checked">
											<img src="img/phone.ico" style="width: 50px;" alt="Téléphone">
										</label> 
										<label class="radio-inline" for="radios-5">
											<input type="radio" name="radios1" id="radios-5" value="2">
											<img src="img/mail.ico" style="width: 50px;" alt="E-mail">
										</label>
										<label class="radio-inline" for="radios-6">
											<input type="radio" name="radios1" id="radios-6" value="3">
											<img src="img/letter.ico" style="width: 50px;" alt="Voie postale">
										</label> 
										<label class="radio-inline" for="radios-7">
											<input type="radio" name="radios1" id="radios-7" value="4">
											<img src="img/info.ico" style="width: 50px;" alt="Demande d'informations">
										</label>
									</div>
								</div>

								<!-- Multiple Checkboxes -->
								<div class="form-group">
									<label class="col-ms-6 control-label" for="checkboxes2">Projet</label>
									<div class="col-ms-6">
										<div class="checkbox">
											<p class="help-block">Pas de projet crée.</p>
										</div>
									</div>
								</div>

								<!-- Textarea -->
								<div class="form-group">
									<label class="col-ms-6 control-label" for="commentaire_r">Commentaire</label>
									<div class="col-ms-6">                     
										<textarea class="form-control" id="textarea" name="commentaire_r" required></textarea>
									</div>
								</div>

								<!-- Button -->
								<div class="form-group">
									<label class="col-ms-6 control-label" for="singlebutton"></label>
									<div class="col-ms-6">
									<button id="singlebutton" name="singlebutton" value="setCrm" class="btn btn-primary">Envoi</button>
									</div>
								</div>
							</div>
						</div>
					</fieldset>
				</div>
			</form>
		</div>
	</div>
</div>
