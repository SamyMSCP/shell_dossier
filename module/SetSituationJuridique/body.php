<?php
include("listeNationalite.php")
?>
<?php
/*

<div class="modal fade modalPreventionUS" tabindex="-1" role="dialog" aria-labelledby="modalPreventionUS" id="modalPreventionUS">
	<div class="modal-dialog modal-sm preventionCapital" role="document">
		<div class="modal-content">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><img style="height:30px;" src="<?=$this->getPath()?>img/Close-Jaune.svg" alt="" /></button>
			<h3>AVERTISSEMENT US Person</h3>
			<p>AvertissementPortefeuilleV3 Us person</p>
			<div class="lstButton">
				<div data-dismiss="modal" class="btnCapital" style="text-align: center;">Oui</div>
			</div>
		</div>
	</div>
</div>


<div class="modal fade modalPreventionExpose" tabindex="-1" role="dialog" aria-labelledby="modalPreventionExpose" id="modalPreventionExpose">
	<div class="modal-dialog modal-sm preventionCapital" role="document">
		<div class="modal-content">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><img style="height:30px;" src="<?=$this->getPath()?>img/Close-Jaune.svg" alt="" /></button>
			<h3>AVERTISSEMENT Personne politiquement exposée</h3>
			<p>AvertissementPortefeuilleV3 personne politiquement exposée</p>
			<div class="lstButton">
				<div data-dismiss="modal" class="btnCapital" style="text-align: center;">Oui</div>
			</div>
		</div>
	</div>
</div>
*/
?>
<datalist id="adresseList">
</datalist>
<datalist id="adresseListNaissance">
</datalist>

<h1 style="color: #1781e0;">CRÉATION DE VOTRE PROJET</h1>
<div class="progressBlk">
	<?=$this->ProgressBlock?>
</div>
<form method="POST" class="form-horizontal" id="tosendinfo">
	<div class="contentSituation">
		<div class="blockSituation block1 blockSelected">
			<div class="titleBlockSituation">
				SITUATION JURIDIQUE DE <?=(isset($this->ben)) ? mb_strtoupper($this->ben->getShortName()) : mb_strtoupper($this->Pp->getShortName())?>
			</div>
			<div class="contentBlockSituation">
				<div class="contenuOut">
					<div class="contenu">
						<div class="form-group">
							<label class="labelForm control-label" for="etat_civil">Etat civil</label>
							<div class="inputForm">
								<div class="arrSelect">
									<select id="etat_civil" name="etat_civil" class="form-control" value="celibataire">
										<option value="marie" <?=(($this->Pp->getEtatCivil()) ==			"marie"			) ? "selected": ""?>>Marié(e)</option>
										<option value="pacse" <?=(($this->Pp->getEtatCivil()) ==			"pacse"			) ? "selected": ""?>>Pacsé(e)</option>
										<option value="unionlibre" <?=(($this->Pp->getEtatCivil()) ==	"unionlibre"	) ? "selected": ""?>>Union libre</option>
										<?php
										if(!count($this->Pp->getBeneficiaireCouple()))
										{
											?>
											<option value="celibataire" <?=(($this->Pp->getEtatCivil()) ==	"celibataire"	) ? "selected": ""?>>Célibataire</option>
											<option value="veuf" <?=(($this->Pp->getEtatCivil()) ==			"veuf"			) ? "selected": ""?>>Veuf(e)</option>
											<option value="divorce" <?=(($this->Pp->getEtatCivil()) ==		"divorce"		) ? "selected": ""?>>Divorce</option>
											<?php
										}
										?>
									</select>
								</div>
								<img src="<?=$this->getPath()?>img/CP-Valide.svg" alt="" style="display:block;"/>
							</div>
						</div>
						<!-- Select Basic -->
						<div class="form-group regMatri">
							<label class="labelForm control-label" for="regime_matri">Régime matrimonial</label>
							<div class="inputForm">
								<div class="arrSelect">
									<select id="regime_matri" name="regime_matri" class="form-control">
										<?php
										//<option value="0">-</option>
										foreach (SituationJuridique::$_regimeMatrimonial as $key => $elm)
										{
											?>
											<option value="<?=$key?>" <?= (isset($this->SituationJuridique) && ($this->SituationJuridique->getRegimeMat() == $key)) ? "selected" : "" ?>><?=$elm?></option>
											<?php
										}
										?>
									</select>
								</div>
								<img src="<?=$this->getPath()?>img/CP-Valide.svg" alt="" style="display:block;"/>
							</div>
						</div>
						<!-- Multiple Checkboxes (inline) -->
						<div class="form-group">
								<label class="labelForm control-label" for="enfant">Avez-vous des enfants ?</label>
								<div class="inputForm">
										<label class="radio-inline" for="enfant-0">
										<input type="radio" class="inputEnfant" name="enfant" id="enfant-0" value="1" <?=(isset($this->SituationJuridique) && $this->SituationJuridique->getHaveChild() == 1) ? "checked" : ""?>><span></span>
												Oui
										</label>
										<label class="radio-inline" for="enfant-1">
												<input type="radio" class="inputEnfant" name="enfant" id="enfant-1" value="0" <?=(isset($this->SituationJuridique) && ($this->SituationJuridique->getHaveChild() == 0)) ? "checked" : ""?>><span></span>
												Non
										</label>
								</div>
						</div>


						<!-- Text input-->
						<div class="form-group nbrChild">
								<label class="labelForm control-label" for="nbr_enfant">Combien à charge ?</label>  
								<div class="inputForm">
									<input id="nbr_enfant" min="0" name="nbr_enfant" type="number" value="<?=(isset($this->SituationJuridique)) ? $this->SituationJuridique->getNbrEnfantCharge() : "0"?>" placeholder="" class="form-control input-md" required="">
									<img id="nbr_enfantValide" class="" src="<?=$this->getPath()?>img/CP-Valide.svg" alt=""/>
								</div>
						</div>

						<!-- Multiple Checkboxes (inline) -->
						<div class="form-group">
								<label class="labelForm control-label" for="autres_charge">Avez vous d’autres personnes à charge ?</label>
								<div class="inputForm">
										<label class="radio-inline" for="autres_charge-0">
												<input type="radio" class="inputOther" name="autres_charge" id="autres_charge-0" value="1" <?=(isset($this->SituationJuridique) && !empty($this->SituationJuridique->getNbrPersonnesCharge())) ? "checked" : ""?>><span></span>
												Oui
										</label>
										<label class="radio-inline" for="autres_charge-1">
												<input type="radio" class="inputOther" name="autres_charge" id="autres_charge-1" value="0" <?=(isset($this->SituationJuridique) && ($this->SituationJuridique->getNbrPersonnesCharge() == 0)) ? "checked" : ""?>><span></span>
												Non
										</label>
								</div>
						</div>

						<!-- Text input-->
						<div class="form-group nbrAutres">
							<label class="labelForm control-label" for="nbr_autres">Combien ?</label>  
							<div class="inputForm">
								<input id="nbr_autres" min="1" name="nbr_autres" type="number" placeholder=""  value="<?=(isset($this->SituationJuridique)) ? $this->SituationJuridique->getNbrPersonnesCharge() : "1"?>" class="form-control input-md" required="">
								<?php
								/*
								<div class="arrSelect">
									<select id="nbr_autres" name="nbr_autres" class="form-control">
										<?php
										for ($i = 0; $i <= 20; $i++)
										{
											?>
												<option value="<?=$i?>" <?=(isset($this->SituationJuridique) && $this->SituationJuridique->getNbrPersonnesCharge() == $i) ? "selected" : ""?>><?=$i?></option>
											<?php
										}
										?>
									</select>
								</div>
								*/
								?>
								<img id="nbr_autresValide" class="" src="<?=$this->getPath()?>img/CP-Valide.svg" alt=""/>
							</div>
						</div>

					</div>
				</div>
				<div class="nextBlockSituation">
					<div class="btn-next btn-next-inactive">
						<div class="inactive">
							QUESTION SUIVANTE
							<img src="<?=$this->getPath()?>img/CP-Fleche-GrisFonce.svg" alt="" />
						</div>
					</div>
					<div class="btn-next btn-next-step" style="display:none;">
						<div class="active" >
							QUESTION SUIVANTE
							<img src="<?=$this->getPath()?>img/CP-Fleche-BleuClair.svg" alt="" />
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="contentSituation">
		<div class="blockSituation block2">
			<div class="titleBlockSituation">
				<?php
				if ($this->Pp->id_phs == $this->dh->lien_phy)
				{
					?>
					VOS INFORMATIONS (<?=mb_strtoupper($this->Pp->getShortName())?>)
					<?php
				}
				else
				{
					?>
					LES INFORMATIONS DE <?=mb_strtoupper($this->Pp->getShortName())?>
					<?php
				}
				?>
			</div>
			<div class="contentBlockSituation"  style="padding:0px 20px 20px 20px;">
				<div class="contenuOut">
					<div class="contenu">
						<div class="subtitle">
							<div>
								<?php
								if ($this->Pp->id_phs == $this->dh->lien_phy)
								{
									?>
									VOTRE IDENTITÉ
									<?php
								}
								else
								{
									?>
									L'IDENTITÉ DE <?=mb_strtoupper($this->Pp->getShortName())?>
									<?php
								}
								?>
							</div>
							<div></div>
						</div>

						<div class="form-group">
							<label class="labelForm control-label" for="civilite">Civilité</label>
							<div class="inputForm">
								<div class="arrSelect">
									<select id="civilite" name="civilite" class="form-control">
										<option value="Monsieur" <?=(($this->Pp->getCivilite()) ==		"Monsieur"		) ? "selected": ""?>>Monsieur</option>
										<option value="Madame"<?=(($this->Pp->getCivilite()) ==		"Madame"		) ? "selected": ""?>>Madame</option>
									</select>
								</div>
								<img  id="civiliteValide" src="<?=$this->getPath()?>img/CP-Valide.svg" alt="" style="display:block;"/>
							</div>
						</div>

						<div class="form-group">
							<label class="labelForm control-label" for="nom">Nom</label>
							<div class="inputForm">
								<input id="NomSJ" name="nom" type="text" value="<?=$this->Pp->getName()?>" placeholder="Nom" class="form-control input-md" required>
								<img id="nomValide" src="<?=$this->getPath()?>img/CP-Valide.svg" alt=""/>
							</div>
						</div>

						<div class="form-group nomJeuneFille">
							<label class="labelForm control-label" for="nom_jeune_fille">Nom de jeune fille</label>
							<div class="inputForm">
								<input id="nom_jeune_fille" name="nom_jeune_fille" type="text" placeholder="Nom de jeune fille" value="<?=$this->Pp->getNomJeuneFille()?>" class="form-control input-md">
								<img id="nom_jeune_filleValide" src="<?=$this->getPath()?>img/CP-Valide.svg" alt=""/>
							</div>
						</div>

						<div class="form-group">
							<label class="labelForm control-label" for="prenom">Prénom</label>
							<div class="inputForm">
								<input id="prenomSJ" name="prenom" type="text" placeholder="Prénom"  value="<?=$this->Pp->getFirstName()?>" class="form-control input-md" required>
								<img id="prenomValide" src="<?=$this->getPath()?>img/CP-Valide.svg" alt=""/>
							</div>
						</div>
						<div class="form-group">
							<label class="labelForm control-label" for="nom">Nationalite</label>
							<div class="inputForm">
								<div class="arrSelect">
									<select name="nationalite" id="Nationalite" class="form-control">
										<?php
										$tmp = (!empty($this->Pp->getNationalite()) && inLstNationalite($this->Pp->getNationalite(), $lstNat)) ? $this->Pp->getNationalite() : "Française";
										foreach ($lstNat as $key => $elm)
										{
											?>
											<option value="<?=$elm['title']?>" <?php if ($elm['title'] == $tmp) echo "selected";?>><?=$elm['title']?></option>
											<?php
										}
										?>
									</select>
								</div>
								<img id="nationaliteValide" src="<?=$this->getPath()?>img/CP-Valide.svg" alt="" style="display:block;"/>
							<?php
							/*
							<input id="Nationalite" name="nationalite" type="text" value="<?=$this->Pp->getNationalite()?>" placeholder="Nationalite" class="form-control input-md" required>
							*/
							?>
							</div>
						</div>


						<div class="form-group">
							<label class="labelForm control-label" for="date_naissance">Date de naissance</label>
							<div class="inputForm">
								<?php
								if (!isMobile())
								{
									?>
									<input id="date_naissance" name="date_naissance" type="text" placeholder="Date de naissance" class="form-control input-md" <?=(!empty($this->Pp->getDateNaissance()) && $this->Pp->getDateNaissance()->getTimestamp()) ? "value='" . $this->Pp->getDateNaissance()->format("d/m/Y") . "'" : '' ?> >
									<?php
								}
								else
								{
									?>
									<input id="date_naissance" name="date_naissance" type="date" max="<?=date("Y-m-d")?>" class="form-control input-md" placeholder="Date de naissance" class="form-control input-md dateenr" <?=(!empty($this->Pp->getDateNaissance()) && $this->Pp->getDateNaissance()->getTimestamp()) ? "value='" . $this->Pp->getDateNaissance()->format("Y-m-d") . "'" : '' ?>>
									<?php
								}
								?>
								<img id="date_naissanceValide" src="<?=$this->getPath()?>img/CP-Valide.svg" alt=""/>
							</div>
						</div>

<?php
/*
						<div class="form-group">
							<label class="labelForm control-label" for="lieu_naissance">Lieu de naissance</label>
							<div class="inputForm">
								<input id="lieu_naissance" name="lieu_naissance" type="text" value="<?=$this->Pp->getLieuNaissance()?>" placeholder="Lieu de naissance" class="form-control input-md" required>
								<img id="lieu_naissanceValide" src="<?=$this->getPath()?>img/CP-Valide.svg" alt=""/>
							</div>
						</div>
						*/
?>

						<div class="form-group">
							<label class="labelForm control-label">Lieu de naissance</label>
							<div class="inputForm">
								<input id="codeNaissance"  oninput="getFromCodeCommune('codeNaissance', 'lieu_naissance', 'adresseListNaissance', lastCodeData3);" list="adresseListNaissance" name="codeNaissance" type="text" placeholder="Code postal" value="<?=$this->Pp->getCodeNaissance()?>" class="form-control formLeft" required>
								<input id="lieu_naissance"  oninput="getFromCodeCommune('codeNaissance', 'lieu_naissance', 'adresseListNaissance', lastCodeData3);" list="adresseListNaissance" name="lieu_naissance" type="text" placeholder="Ville" value="<?=$this->Pp->getLieuNaissance()?>" class="form-control formRight" required>
								<img id="lieu_naissanceValide" src="<?=$this->getPath()?>img/CP-Valide.svg" alt=""/>
							</div>
						</div>

						<div class="form-group">
							<label class="labelForm control-label" for="pays_de_naissance">Pays de naissance</label>
							<div class="inputForm">
								<div class="arrSelect">
									<select id="pays_de_naissance" name="pays_de_naissance" value="<?=$this->Pp->getPaysNaissance()?>"  class="form-control">
										<?php
										$tmp = (!empty($this->Pp->getPaysNaissance()) && $this->Pp->getPaysNaissance() != " ") ? $this->Pp->getPaysNaissance() : "France";
										foreach (Pays::getAll() as $key => $elm)
										{
											?>
											<option value="<?=$elm->nom_fr_fr?>" <?= ($elm->nom_fr_fr == $tmp  ? " selected" : "") ?>><?=$elm->nom_fr_fr?></option>
											<?php
										}
									//	include("listePays.php");
										/*
										<input id="pays_de_naissance" name="pays_de_naissance" type="text" value="<?=$this->Pp->getPaysNaissance()?>" placeholder="Pays de naissance" class="form-control input-md" required>
										*/
										?>
									</select>
								</div>
								<img src="<?=$this->getPath()?>img/CP-Valide.svg" alt="" style="display:block;"/>
							</div>
						</div>


						<div class="subtitle">
							<div>
								<?php
								if ($this->Pp->id_phs == $this->dh->lien_phy)
								{
									?>
									VOS COORDONNÉES
									<?php
								}
								else
								{
									?>
									LES COORDONNÉES DE <?=mb_strtoupper($this->Pp->getShortName())?>
									<?php
								}
								?>
							</div>
							<div></div>
						</div>
						<?php
						if ($this->Pp->id_phs != $this->dh->lien_phy)
						{
							?>
							<div class="form-group">
								<label class="labelForm control-label" for="indicatif">Indicatif téléphonique</label>
								<div class="inputForm">
									<div class="arrSelect">
										<select id="countries_phone2" name="indicatif" class="form-control bfh-countries" data-country="FR" class="form-control">
											<?php
											include("indic.php");
											?>
										</select>
									</div>
									<img id="countries_phone2Valide" src="<?=$this->getPath()?>img/CP-Valide.svg" alt="" style="display:block;"/>
								</div>
							</div>

							<div class="form-group">
								<label class="labelForm control-label" for="num">Téléphone Portable</label>
								<div class="inputForm" style="flex-direction: column;">
									<input name="num" id="num" type="tel" onclick="$('#numex').css('display', 'initial');" class="form-control bfh-phone" data-country="countries_phone2" value="<?=$this->Pp->getPhone()?>" required="">

									<img id="numValide"src="<?=$this->getPath()?>img/CP-Valide.svg" alt=""/>
									<label style="text-align: left; display: none;" id="numex" class="control-label" for="num">Ex : +33 6 45 45 45 45</label>
								</div>
							</div>

							<div class="form-group">
								<label class="labelForm control-label" for="mail">Email</label>
								<div class="inputForm">
									<input id="mailSJ" name="mail" type="text" placeholder="Email" value="<?=$this->Pp->getMail()?>" class="form-control input-md" required>
									<img id="mailValide" src="<?=$this->getPath()?>img/CP-Valide.svg" alt=""/>
								</div>
							</div>
						<?php
						}
						?>

						<div class="form-group">
							<label class="labelForm control-label" for="mail">Adresse</label>
							<div class="inputForm">
								<input id="numeroRue" name="numeroRue" type="text" placeholder="n°" value="<?=$this->Pp->getNumeroRue()?> <?=$this->Pp->getExtention()?>" class="formLeft form-control input-md" required style="max-width:21%;">
								<select id="type_voie" class="formCenter form-control" name="type_voie">
									<?php
									foreach (Pp::$_type_voie as $key => $elm)
									{
										?>
										<option value="<?=$elm?>" <?=($this->Pp->getTypeVoie() == $elm) ? "selected" : ""?>><?=mb_strtolower($elm)?></option>
										<?php
									}
									?>
								</select>
								<input id="voie" name="voie" type="text" placeholder="rue ..." value="<?=$this->Pp->getVoie()?>" class="formRight form-control input-md" required>
								<img id="adresseValide" src="<?=$this->getPath()?>img/CP-Valide.svg" alt=""/>
							</div>
						</div>

						<div class="form-group">
							<label class="labelForm control-label" for="complementAdresse">Complément d'adresse</label>
							<div class="inputForm">
								<input id="complementAdresse" name="complementAdresse" type="text" placeholder="" value="<?=$this->Pp->getComplementAdresse()?>" class="form-control input-md">
								<img src="<?=$this->getPath()?>img/CP-Valide.svg" alt=""/>
							</div>
						</div>

						<div class="form-group">
							<label class="labelForm control-label">Code Postal / Ville</label>
							<div class="inputForm">
								<input id="codePostal"  oninput="getFromCodeCommune('codePostal', 'ville', 'adresseList', lastCodeData);" list="adresseList" name="codePostal" type="text" placeholder="Code postal" value="<?=$this->Pp->getCodePostal()?>" class="form-control formLeft" required>
								<input id="ville"  oninput="getFromCodeCommune('codePostal', 'ville', 'adresseList', lastCodeData);" list="adresseList" name="ville" type="text" placeholder="Ville" value="<?=$this->Pp->getVille()?>" class="form-control formRight" required>
								<img id="codeValide" src="<?=$this->getPath()?>img/CP-Valide.svg" alt=""/>
							</div>
						</div>

						<div class="form-group">
							<label class="labelForm control-label" for="pays">Pays</label>
							<div class="inputForm">
								<div class="arrSelect">
									<select id="pays" name="pays" value=""  class="form-control">
										<?php
										$tmp = (!empty($this->Pp->getPays()) && $this->Pp->getPays() != " ") ? $this->Pp->getPays() : "France";
										foreach (Pays::getAll() as $key => $elm)
										{
											?>
											<option value="<?=$elm->nom_fr_fr?>" <?= ($elm->nom_fr_fr == $tmp ? " selected" : "") ?>><?=$elm->nom_fr_fr?></option>
											<?php
										}
										/*
										<input id="pays" name="pays" type="text" placeholder="Pays" value="<?=$this->Pp->getPays()?>" class="form-control input-md" required>
										*/
										?>
									</select>
								</div>
								<img id="paysValide" src="<?=$this->getPath()?>img/CP-Valide.svg" alt="" style="display:block;"/>
							</div>
						</div>

						<div class="subtitle">
							<div>
								INFORMATIONS COMPLÉMENTAIRES
							</div>
							<div></div>
						</div>

						<div class="form-group">
							<label class="labelForm control-label" for="status_pro">Statut professionnel</label>
							<div class="inputForm">
								<div class="arrSelect">
									<select id="status_pro" name="status_pro" class="form-control">
										<option value="0" <?=(empty($this->Pp->getStatusPro())) ? "selected" : ""?>>-</option>
										<?php
										foreach (StatusPro::getAll() as $key => $elm)
										{
											?>
											<option value="<?=$elm->id?>" <?=(!empty($this->Pp->getStatusPro()) && $this->Pp->getStatusPro()->id == $elm->id) ? "selected" : ""?>>
												<?=$elm->getName()?>
											</option>
											<?php
										}
										?>
									</select>
								</div>
								<img  id="status_proValide" src="<?=$this->getPath()?>img/CP-Valide.svg" alt="" style="display:block;"/>
							</div>
						</div>

						<div class="form-group for_cat_pro">
							<label class="labelForm control-label" for="cat_pro">Catégorie socio-professionnelle</label>
							<div class="inputForm">
								<div class="arrSelect">
									<select id="cat_pro" name="cat_pro" class="form-control">
										<option value="0" <?=(empty($this->Pp->getCatPro())) ? "selected" : ""?>>-</option>
										<?php
										foreach (CatPro::getAll() as $key => $elm)
										{
											?>
											<option value="<?=$elm->id?>"  <?=(!empty($this->Pp->getCatPro()) && $this->Pp->getCatPro()->id == $elm->id) ? "selected" : ""?>>
												<?=$elm->getName()?>
											</option>
											<?php
										}
										?>
									</select>
								</div>
								<img  id="cat_proValide" src="<?=$this->getPath()?>img/CP-Valide.svg" alt="" style="display:block;"/>
							</div>
						</div>

						<div class="form-group for_profession">
							<label class="labelForm control-label" for="profession">Profession</label>
							<div class="inputForm">
								<input id="work" name="profession" type="text" placeholder="Profession" value="<?=$this->Pp->getProfession()?>" class="form-control input-md" required>
								<img id="workValide" src="<?=$this->getPath()?>img/CP-Valide.svg" alt=""/>
							</div>
						</div>

						<div class="form-group for_contrat_travail">
							<label class="labelForm control-label" for="contrat_travail">Type de contrat</label>
							<div class="inputForm">
								<div class="arrSelect">
									<select id="contrat_travail" name="contrat_travail" class="form-control" value="<?=$this->Pp->getContratTravail()?>">
										<option value="-1" <?=($this->Pp->getContratTravail() === null) ? "selected" : ""?>>Sélectionnez le type de contrat</option>
										<option value="1" <?=($this->Pp->getContratTravail() == 1) ? "selected" : ""?>>CDD</option>
										<option value="2" <?=($this->Pp->getContratTravail() == 2) ? "selected" : ""?>>CDI</option>
										<option value="0" <?=($this->Pp->getContratTravail() === "0") ? "selected" : ""?>>Autre</option>
									</select>
								</div>
								<img  id="contrat_travailValide" src="<?=$this->getPath()?>img/CP-Valide.svg" alt="" style="display:block;"/>
							</div>
						</div>

						<div class="form-group forTypeContrat">
							<label class="labelForm control-label" for="autre_contrat_travail">Quel type de contrat ?</label>
							<div class="inputForm">
								<input id="autre_contrat_travail" name="autre_contrat_travail" type="text" placeholder="Type de contrat" value="<?=$this->Pp->getAutreContratTravail()?>" class="form-control input-md" required>
								<img id="autre_contrat_travailValide" src="<?=$this->getPath()?>img/CP-Valide.svg" alt=""/>
							</div>
						</div>


						<div class="form-group for_retraite">
							<label class="labelForm control-label" for="depart_retraite">Année prévisionnelle de départ à la retraite</label>
							<div class="inputForm">
								<input id="depart_retraite" name="depart_retraite" min="<?=date("Y")?>" max="3000" type="number" placeholder="Année prévisionnelle de départ à la retraite" value="<?=$this->Pp->getDepartRetraite()?>" class="form-control input-md" required>
								<img id="depart_retraiteValide" src="<?=$this->getPath()?>img/CP-Valide.svg" alt=""/>
							</div>
						</div>

						<?php
						/*
							</div>
							<div class="contenu">
						*/
						?>

						<!-- Multiple Checkboxes (inline) -->
						<div class="form-group">
							<label class="labelForm control-label" for="us_person">Le bénéficiaire (<?=$this->Pp->getShortName()?>) est-il une US Person ?
							<img class="_tooltip_r" src="<?=$this->getPath()?>img/i_BleuClair.png" onmouseover="display_tooltip('US Person', 'La définition des US persons se trouve dans la réglementation américaine « Regulation S » (US Securities Act de 1933). Elle s’intègre dans un dispositif visant à renforcer la transparence fiscale internationale et qui a été renforcé par la législation FATCA (Foreign Account Tax Compliance Act) en 2014.', event)" onmouseout="disable_msg(event)" class="_tooltip" style="height: 22px !important;margin-left: 10px;">
							</label>
							<div class="inputForm">
								<label class="radio-inline" for="us_person-0">
									<input type="radio" name="us_person" id="us_person-0" value="1" <?=($this->Pp->getUsPerson()) ? "checked" : ""?>><span></span>
										Oui
								</label>
								<label class="radio-inline" for="us_person-1">
									<input type="radio" name="us_person" id="us_person-1" value="0" <?=(!$this->Pp->getUsPerson()) ? "checked" : ""?>><span></span>
										Non
								</label>
							</div>
						</div>

						<!-- Multiple Checkboxes (inline) -->
						<div class="form-group">
							<label class="labelForm control-label" for="politique">Le bénéficiaire (<?=$this->Pp->getShortName()?>) est-il politiquement exposée ?
							<img class="_tooltip_r" src="<?=$this->getPath()?>img/i_BleuClair.png" onmouseover="display_tooltip('Personne politiquement exposée', 'Une PPE est une personne de nationalité française ou étrangère, qui réside hors de France et - exerce ou a exercé des fonctions pour le compte d’un Etat étranger (question 4 ci- dessous); ou - dont un membre de la famille directe ou un des proches sans liens familiaux est lui-même une PPE. Source AMF', event)" onmouseout="disable_msg(event)" class="_tooltip" style="height: 22px !important;margin-left: 10px;">
							</label>
							<div class="inputForm">
								<label class="radio-inline" for="politique-0">
									<input type="radio" name="politique" id="politique-0" value="1" <?=($this->Pp->getPolitiquementExpose()) ? "checked" : ""?>><span></span>
									Oui
								</label>
								<label class="radio-inline" for="politique-1">
										<input type="radio" name="politique" id="politique-1" value="0" <?=(!$this->Pp->getPolitiquementExpose()) ? "checked" : ""?>><span></span>
										Non
								</label>
							</div>
						</div>


						<div class="form-group">
							<label class="labelForm control-label" for="element_particulier">Avez-vous des éléments particuliers à préciser ?</label>
							<div class="inputForm">
								<textarea name="element_particulier" style="width:100%;" id="element_particulier" rows="8" cols="40"><?=$this->Pp->getElementParticulier()?></textarea>
							</div>
						</div>

					</div>
				</div>
				<div class="nextBlockSituation">
					<div class="btn-next btn-next-inactive">
						<div class="inactive">
							QUESTION SUIVANTE
							<img src="<?=$this->getPath()?>img/CP-Fleche-GrisFonce.svg" alt="" />
						</div>
					</div>
					<div class="btn-next btn-next-step" style="display:none;">
						<div class="active" >
							QUESTION SUIVANTE
							<img src="<?=$this->getPath()?>img/CP-Fleche-BleuClair.svg" alt="" />
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php
		if (isset($this->Pp2))
			include("form2.php");
		?>

		<input type="hidden" name="id_phs"  value="<?=$this->Pp->id_phs?>"/>
		<input type="hidden" name="token" id="token" value="<?php echo $_SESSION['csrf'][0]; ?>"/>
		<input type="hidden" name="action" id="" value="setSituationJuridique" />
		<?php
		/*
		<input style="margin-top: 20px;" class="tosend" type="image" src="<?=$this->getPath()?>img/btn_1_hd.jpg" name="send" value="send">
		*/
		?>
	</div>
	<?php
	//<button  id="sendBtn" class="tosend"  style="margin-top: 20px;margin-bottom: 20px;" />
	?>
</form>
<p class="help-block info_block"><strong>Avertissement :</strong> Ce questionnaire a pour but de nous permettre de vous conseiller de la meilleure des façons et de nous assurer que<br>
les instruments ou services financiers sollicités par vos soins sont adaptés à vos connaissances et à votre expérience. Ces informations<br>
sont amenées à être actualisées à la suite de toute modification et au maximum tous les 3 ans.<br>
Il est nécessaire que vous répondiez de manière sincère à ces questions. Toute réponse incomplète ou erronée risque de compromettre<br>
la fiabilité et/ou la pertinence de notre analyse et donc des solutions que nous serons amenés à vous présenter.</p>

