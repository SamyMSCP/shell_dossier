<datalist id="adresseList2">
</datalist>
<datalist id="adresseListNaissance2">
</datalist>

<div class="blockSituation block3">
	<div class="titleBlockSituation">
		LES INFORMATIONS DE VOTRE CONJOINT (<?=mb_strtoupper($this->Pp2->getShortName())?>)
	</div>
	<div class="contentBlockSituation">

		<div class="contenuOut">
			<div class="contenu">

                <div class="subtitle">
                    <div>
                        L'IDENTITÉ DE <?=mb_strtoupper($this->Pp2->getShortName())?>
                    </div>
                    <div></div>
                </div>
				<!-- Select Basic -->
				<div class="form-group">
					<label class="labelForm control-label" for="civilite">Civilité</label>
					<div class="inputForm">
						<div class="arrSelect">
							<select id="civiliteConjoin" name="civiliteConjoin" class="form-control">
								<option value="Monsieur" <?=(($this->Pp2->getCivilite()) ==		"Monsieur"		) ? "selected": ""?>>Monsieur</option>
								<option value="Madame"<?=(($this->Pp2->getCivilite()) ==		"Madame"		) ? "selected": ""?>>Madame</option>
							</select>
						</div>
						<img src="<?=$this->getPath()?>img/CP-Valide.svg" alt="" style="display:block;"/>
					</div>
				</div>

				<!-- Text input-->
				<div class="form-group">
					<label class="labelForm control-label" for="nomConjoin">Nom</label>  
					<div class="inputForm">
						<input id="NomConjoin" name="nomConjoin" type="text" value="<?=$this->Pp2->getName()?>" placeholder="Nom" class="form-control input-md" required>
						<img id="NomConjoinValide" src="<?=$this->getPath()?>img/CP-Valide.svg" alt=""/>
					</div>
				</div>

				<!-- Text input-->
				<div class="form-group nomJeuneFilleConjoin">
					<label class="labelForm control-label" for="nom_jeune_filleConjoin">Nom de jeune fille</label>  
					<div class="inputForm">
						<input id="nom_jeune_filleConjoin" name="nom_jeune_filleConjoin" type="text" placeholder="Nom de jeune fille" value="<?=$this->Pp2->getNomJeuneFille()?>" class="form-control input-md">
					
						<img id="nom_jeune_filleConjoinValide" src="<?=$this->getPath()?>img/CP-Valide.svg" alt=""/>
					</div>
				</div>

				<!-- Text input-->
				<div class="form-group">
					<label class="labelForm control-label" for="prenomConjoin">Prénom</label>  
					<div class="inputForm">
						<input id="prenomConjoin" name="prenomConjoin" type="text" placeholder="Prénom"  value="<?=$this->Pp2->getFirstName()?>" class="form-control input-md" required>
						<img id="prenomConjoinValide" src="<?=$this->getPath()?>img/CP-Valide.svg" alt=""/>
					</div>
				</div>




				<!-- Text input-->
				<div class="form-group">
					<label class="labelForm control-label" for="nomConjoin">Nationalite</label>  
					<div class="inputForm">
						<div class="arrSelect">
							<select name="nationaliteConjoin" id="NationaliteConjoin" class="form-control">
								<?php

								$tmp = !empty($this->Pp2->getNationalite()) ? $this->Pp2->getNationalite() : "Française";
								foreach ($lstNat as $key => $elm)
								{
									?>
									<option value="<?=$elm['title']?>" <?php
										if ($elm['title'] == $tmp) echo "selected";?>><?=$elm['title']
										?></option>
									<?php
								}
								?>
							</select>
						</div>
						<img id="NationaliteConjoinValide" src="<?=$this->getPath()?>img/CP-Valide.svg" alt=""/>
					</div>
				</div>


				<!-- Text input-->
				<div class="form-group">
					<label class="labelForm control-label" for="date_naissanceConjoin">Date de naissance</label>  
					<div class="inputForm">
						<?php
						if (!isMobile())
						{
							?>
							<input id="date_naissanceConjoin" name="date_naissanceConjoin" type="text" placeholder="Date de naissance" class="form-control input-md" <?=(!empty($this->Pp2->getDateNaissance()) && $this->Pp2->getDateNaissance()->getTimestamp()) ? "value='" . $this->Pp2->getDateNaissance()->format("d/m/Y") . "'" : '' ?> >
							<?php
						}
						else
						{
							?>
							<input id="date_naissanceConjoin" name="date_naissanceConjoin" type="date" max="<?=date("Y-m-d")?>" class="form-control input-md" placeholder="Date de naissance" class="form-control input-md dateenr" <?=(!empty($this->Pp2->getDateNaissance()) && $this->Pp2->getDateNaissance()->getTimestamp()) ? "value='" . $this->Pp2->getDateNaissance()->format("Y-m-d") . "'" : '' ?>>
							<?php
						}
						?>
					<img id="date_naissanceConjoinValide" src="<?=$this->getPath()?>img/CP-Valide.svg" alt=""/>
					</div>
				</div>

<?php
/*
				<!-- Text input-->
				<div class="form-group">
					<label class="labelForm control-label" for="lieu_naissanceConjoin">Ville de naissance</label>  
					<div class="inputForm">
						<input id="lieu_naissanceConjoin" name="lieu_naissanceConjoin" type="text" value="<?=$this->Pp2->getLieuNaissance()?>" placeholder="Lieu de naissance" class="form-control input-md" required>
						<img id="lieu_naissanceConjoinValide" src="<?=$this->getPath()?>img/CP-Valide.svg" alt=""/>
					</div>
				</div>
*/
?>

				<div class="form-group">
					<label class="labelForm control-label">Lieu de naissance</label>
					<div class="inputForm">
						<input id="codeNaissanceConjoin"  oninput="getFromCodeCommune('codeNaissanceConjoin', 'lieu_naissanceConjoin', 'adresseListNaissance2', lastCodeData4);" list="adresseListNaissance2" name="codeNaissanceConjoin" type="text" placeholder="Code postal" value="<?=$this->Pp2->getCodeNaissance()?>" class="form-control formLeft" required>
						<input id="lieu_naissanceConjoin"  oninput="getFromCodeCommune('codeNaissanceConjoin', 'lieu_naissanceConjoin', 'adresseListNaissance2', lastCodeData4);" list="adresseListNaissance2" name="lieu_naissanceConjoin" type="text" placeholder="Ville" value="<?=$this->Pp2->getLieuNaissance()?>" class="form-control formRight" required>
						<img id="lieu_naissanceConjoinValide" src="<?=$this->getPath()?>img/CP-Valide.svg" alt=""/>
					</div>
				</div>

				<!-- Text input-->
				<div class="form-group">
					<label class="labelForm control-label" for="pays_de_naissanceConjoin">Pays de naissance</label>  
					<div class="inputForm">
						<div class="arrSelect">
							<select id="pays_de_naissanceConjoin" name="pays_de_naissanceConjoin"  value=""  class="form-control">
								<?php
								$tmp = !empty($this->Pp2->getPaysNaissance()) ? $this->Pp2->getPaysNaissance() : "France";
								foreach (Pays::getAll() as $key => $elm)
								{
									?>
									<option value="<?=$elm->nom_fr_fr?>" <?= ($elm->nom_fr_fr == $tmp ? " selected" : "") ?>><?=$elm->nom_fr_fr?></option>
									<?php
								}
							?>
							</select>
						</div>
						<img id="pays_de_naissanceConjoinValide" src="<?=$this->getPath()?>img/CP-Valide.svg" alt=""/>
					</div>
				</div>

                <div class="subtitle">
                    <div>
                        LES COORDONNÉES DE <?=mb_strtoupper($this->Pp2->getShortName())?>
                    </div>
                    <div></div>
                </div>

				<?php
				if ($this->Pp2->id_phs != $this->dh->lien_phy)
				{
					?>

					<div class="form-group">
						<label class="labelForm control-label" for="indicatifConjoin">Indicatif téléphonique</label>
						<div class="inputForm">
							<div class="arrSelect">
								<select id="countries_phone2Conjoin" name="indicatifConjoin" class="form-control bfh-countries" data-country="FR">
									<?php
									include("indic.php");
									?>
								</select>
							</div>
							<img src="<?=$this->getPath()?>img/CP-Valide.svg" alt="" style="display:block;"/>
							<img id="countries_phone2ConjoinValide" src="<?=$this->getPath()?>img/CP-Valide.svg" alt="" style="display:block;"/>
						</div>
					</div>


					<!-- Telephoneinput-->
					<div class="form-group">
						<label class="labelForm control-label" for="numConjoin">Téléphone Portable</label>
						<div class="inputForm" style="flex-direction: column;">
							<input name="numConjoin" id="numConjoin" type="tel" onclick="$('#numex').css('display', 'initial');" class="form-control bfh-phone" data-country="countries_phone2Conjoin" value="<?=$this->Pp2->getPhone()?>" required="">

							<label style="text-align: left; display: none;" id="numex" class="labelForm control-label" for="num">Ex : +33 6 45 45 45 45</label>
							<img id="numConjoinValide" src="<?=$this->getPath()?>img/CP-Valide.svg" alt=""/>
						</div>
					</div>

					<!-- Text input-->
					<div class="form-group">
						<label class="labelForm control-label" for="mailConjoin">Email</label>  
						<div class="inputForm">
							<input id="mailConjoin" name="mailConjoin" type="text" placeholder="Email" value="<?=$this->Pp2->getMail()?>" class="form-control input-md" required>
							<img id="mailConjoinValide" src="<?=$this->getPath()?>img/CP-Valide.svg" alt=""/>
						</div>
					</div>
				<?php
				}
				?>

				<!-- Multiple Checkboxes (inline) -->
				<div class="form-group">
					<label class="labelForm control-label" for="haveAddrConjoin">L'adresse du conjoint (<?=$this->Pp2->getShortName()?>) est-elle la meme ?</label>
					<div class="inputForm">
					<label class="radio-inline" for="haveAddrConjoin-0Conjoin">
						<input type="radio" name="haveAddrConjoin" id="haveAddrConjoin-0Conjoin" value="1" <?=($this->Pp2->sameAdresse($this->Pp)) ? "checked" : ""?>><span></span>
							Oui
						</label>
						<label class="radio-inline" for="haveAddrConjoin-1Conjoin">
							<input type="radio" name="haveAddrConjoin" id="haveAddrConjoin-1Conjoin" value="0"  <?=(!$this->Pp2->sameAdresse($this->Pp)) ? "checked" : ""?>><span></span>
							Non
						</label>
					</div>
				</div>

				<!-- Text input-->
			<div class="form-group forConjoinAddr">
					<label class="labelForm control-label" for="mailConjoin">Adresse</label>  
					<div class="inputForm">
						<input id="numeroRueConjoin" name="numeroRueConjoin" type="text" min="1" placeholder="n°" value="<?=$this->Pp2->getNumeroRue()?> <?=$this->Pp2->getExtention()?>" class="form-control input-md formLeft" required style="max-width:21%;">
						<select id="type_voieConjoin" class="formCenter form-control" name="type_voieConjoin">
							<?php
							foreach (Pp::$_type_voie as $key => $elm)
							{
								?>
								<option value="<?=$elm?>" <?=($this->Pp2->getTypeVoie() == $elm) ? "selected" : ""?>><?=mb_strtolower($elm)?></option>
								<?php
							}
							?>
						</select>
						<input id="voieConjoin" name="voieConjoin" type="text" placeholder="rue ..." value="<?=$this->Pp2->getVoie()?>" class="formRight form-control input-md" required>
						<img id="adresseConjoinValide" src="<?=$this->getPath()?>img/CP-Valide.svg" alt=""/>
					</div>
				</div>

				<!-- Text input-->
				<div class="form-group forConjoinAddr">
					<label class="labelForm control-label" for="complementAdresseConjoin">Complément d'adresse</label>  
					<div class="inputForm">
						<input id="complementAdresseConjoin" name="complementAdresseConjoin" type="text" placeholder="" value="<?=$this->Pp2->getComplementAdresse()?>" class="form-control input-md">
						<img src="<?=$this->getPath()?>img/CP-Valide.svg" alt="" style="display:block;"/>
					</div>
				</div>

				<!-- Text input-->
				<div class="form-group forConjoinAddr">
					<label class="labelForm control-label"></label>
					<div class="inputForm">
						<input id="codePostalConjoin" list="adresseList2" oninput="getFromCodeCommune('codePostalConjoin', 'villeConjoin', 'adresseList2', lastCodeData2);" name="codePostalConjoin" type="text" placeholder="Code postal" value="<?=$this->Pp2->getCodePostal()?>" class="form-control input-md formLeft" required>
						<input id="villeConjoin"  list="adresseList2" oninput="getFromCodeCommune('codePostalConjoin', 'villeConjoin', 'adresseList2', lastCodeData2);" name="villeConjoin" type="text" placeholder="Ville" value="<?=$this->Pp2->getVille()?>" class="formRight form-control input-md" required>
						<img id="codeConjoinValide" src="<?=$this->getPath()?>img/CP-Valide.svg" alt=""/>
					</div>
				</div>

				<!-- Text input-->
				<div class="form-group forConjoinAddr">
					<label class="labelForm control-label" for="paysConjoin">Pays</label>
					<div class="inputForm">
						<div class="arrSelect">
							<select id="paysConjoin" name="paysConjoin" value="" class="form-control">
								<?php
								$tmp = !empty($this->Pp2->getPays()) ? $this->Pp->getPays() : "France";
								foreach (Pays::getAll() as $key => $elm)
								{
									?>
									<option value="<?=$elm->nom_fr_fr?>" <?= ($elm->nom_fr_fr == $tmp ? " selected" : "") ?>><?=$elm->nom_fr_fr?></option>
									<?php
								}
								?>
							</select>
						</div>
						<img id="paysConjoinValide" src="<?=$this->getPath()?>img/CP-Valide.svg" alt=""/>
					</div>
				</div>


                <div class="subtitle">
                    <div>
                        INFORMATIONS COMPLÉMENTAIRES
                    </div>
                    <div></div>
                </div>

				<div class="form-group">
					<label class="labelForm control-label" for="status_proConjoin">Statut professionnel</label>
					<div class="inputForm">
						<div class="arrSelect">
							<select id="status_proConjoin" name="status_proConjoin" class="form-control">
								<option value="0" <?=(empty($this->Pp2->getStatusPro())) ? "selected" : ""?>>-</option>
								<?php
								foreach (StatusPro::getAll() as $key => $elm)
								{
									?>
									<option value="<?=$elm->id?>" <?=(!empty($this->Pp2->getStatusPro()) && $this->Pp2->getStatusPro()->id == $elm->id) ? "selected" : ""?>>
										<?=$elm->getName()?>
									</option>
									<?php
								}
								?>
							</select>
						</div>
						<img  id="status_proConjoinValide" src="<?=$this->getPath()?>img/CP-Valide.svg" alt="" style="display:block;"/>
					</div>
				</div>

				<div class="form-group for_cat_proConjoin">
					<label class="labelForm control-label" for="cat_proConjoin">Catégorie socio-professionnelle</label>
					<div class="inputForm">
						<div class="arrSelect">
							<select id="cat_proConjoin" name="cat_proConjoin" class="form-control">
								<option value="0" <?=(empty($this->Pp2->getCatPro())) ? "selected" : ""?>>-</option>
								<?php
								foreach (CatPro::getAll() as $key => $elm)
								{
									?>
									<option value="<?=$elm->id?>"  <?=(!empty($this->Pp2->getCatPro()) && $this->Pp2->getCatPro()->id == $elm->id) ? "selected" : ""?>>
										<?=$elm->getName()?>
									</option>
									<?php
								}
								?>
							</select>
						</div>
						<img  id="cat_proConjoinValide" src="<?=$this->getPath()?>img/CP-Valide.svg" alt="" style="display:block;"/>
					</div>
				</div>




				<!-- Text input-->
				<div class="form-group  for_professionConjoin">
					<label class="labelForm control-label" for="professionConjoin">Profession</label>
					<div class="inputForm">
						<input id="workConjoin" name="professionConjoin" type="text" placeholder="Profession" value="<?=$this->Pp2->getProfession()?>" class="form-control input-md" required>
						<img id="workConjoinValide" src="<?=$this->getPath()?>img/CP-Valide.svg" alt=""/>
					</div>
				</div>

                <div class="form-group for_contrat_travailConjoin">
                    <label class="labelForm control-label" for="contrat_travailConjoin">Type de contrat</label>
                    <div class="inputForm">
                        <div class="arrSelect">
                            <select id="contrat_travailConjoin" name="contrat_travailConjoin" class="form-control" value="<?=$this->Pp2->getContratTravail()?>">
                                <option value="-1" <?=($this->Pp2->getContratTravail() === null) ? "selected" : ""?>>Sélectionnez le type de contrat</option>
                                <option value="1" <?=($this->Pp2->getContratTravail() == 1) ? "selected" : ""?>>CDD</option>
                                <option value="2" <?=($this->Pp2->getContratTravail() == 2) ? "selected" : ""?>>CDI</option>
                                <option value="0" <?=($this->Pp2->getContratTravail() == "0") ? "selected" : ""?>>Autre</option>
                            </select>
                        </div>
                        <img  id="contrat_travailConjoinValide" src="<?=$this->getPath()?>img/CP-Valide.svg" alt="" style="display:block;"/>
                    </div>
                </div>

                <div class="form-group forTypeContratConjoin">
                    <label class="labelForm control-label" for="autre_contrat_travailConjoin">Quel type de contrat ?</label>
                    <div class="inputForm">
                        <input id="autre_contrat_travailConjoin" name="autre_contrat_travailConjoin" type="text" placeholder="Type de contrat" value="<?=$this->Pp2->getAutreContratTravail()?>" class="form-control input-md" required>
                        <img id="autre_contrat_travailConjoinValide" src="<?=$this->getPath()?>img/CP-Valide.svg" alt=""/>
                    </div>
                </div>

				<div class="form-group for_retraiteConjoin">
					<label class="labelForm control-label" for="depart_retraiteConjoin">Année prévisionnelle de départ à la retraite</label>  
					<div class="inputForm">
						<input id="depart_retraiteConjoin" name="depart_retraiteConjoin" min="<?=date("Y")?>"  max="3000" type="number" placeholder="Année prévisionnelle de départ à la retraite" value="<?=$this->Pp2->getDepartRetraite()?>" class="form-control input-md" required>
						<img id="depart_retraiteConjoinValide" src="<?=$this->getPath()?>img/CP-Valide.svg" alt=""/>
					</div>
				</div>


				<!-- Multiple Checkboxes (inline) -->
				<div class="form-group">
					<label class="labelForm control-label" for="us_personConjoin">Le bénéficiaire (<?=$this->Pp2->getShortName()?>) est-il une US Person ?
                        <img class="_tooltip_r" src="<?=$this->getPath()?>img/i_BleuClair.png" onmouseover="display_tooltip('US Person', 'La définition des US persons se trouve dans la réglementation américaine « Regulation S » (US Securities Act de 1933). Elle s’intègre dans un dispositif visant à renforcer la transparence fiscale internationale et qui a été renforcé par la législation FATCA (Foreign Account Tax Compliance Act) en 2014.', event)" onmouseout="disable_msg(event)" class="_tooltip" style="height: 22px !important;margin-left: 10px;">
					</label>
					<div class="inputForm">
						<label class="radio-inline" for="us_person-0Conjoin">
							<input type="radio" name="us_personConjoin" id="us_person-0Conjoin" value="1" <?=($this->Pp2->getUsPerson()) ? "checked" : ""?>><span></span>
							Oui
						</label>
						<label class="radio-inline" for="us_person-1Conjoin">
							<input type="radio" name="us_personConjoin" id="us_person-1Conjoin" value="0" <?=(!$this->Pp2->getUsPerson()) ? "checked" : ""?>><span></span>
							Non
						</label>
					</div>
				</div>

				<!-- Multiple Checkboxes (inline) -->
				<div class="form-group">
					<label class="labelForm control-label" for="politique">Le bénéficiaire (<?=$this->Pp2->getShortName()?>) est-il politique exposée ?
                        <img class="_tooltip_r" src="<?=$this->getPath()?>img/i_BleuClair.png" onmouseover="display_tooltip('Personne politiquement exposée', 'Une PPE est une personne de nationalité française9 ou étrangère, qui réside hors de France et - exerce ou a exercé des fonctions pour le compte d’un Etat étranger (question 4 ci- dessous); ou - dont un membre de la famille directe ou un des proches sans liens familiaux est lui-même une PPE. Source AMF', event)" onmouseout="disable_msg(event)" class="_tooltip" style="height: 22px !important;margin-left: 10px;">
					</label>
					<div class="inputForm">
						<label class="radio-inline" for="politique-0Conjoin">
							<input type="radio" name="politiqueConjoin" id="politique-0Conjoin" value="1" <?=($this->Pp2->getPolitiquementExpose()) ? "checked" : ""?>><span></span>
							Oui
						</label>
						<label class="radio-inline" for="politique-1Conjoin">
							<input type="radio" name="politiqueConjoin" id="politique-1Conjoin" value="0" <?=(!$this->Pp2->getPolitiquementExpose()) ? "checked" : ""?>><span></span>
							Non
						</label>
					</div>
				</div>

				<div class="form-group">
					<label class="labelForm control-label" for="element_particulier">Avez-vous des éléments particuliers à préciser ?</label>  
					<div class="inputForm">
						<textarea name="element_particulierConjoin" style="width:100%;" id="element_particulierConjoin" rows="8" cols="40"><?=$this->Pp2->getElementParticulier()?></textarea> </div>
				</div>
			</div>
			<input type="hidden" name="id_phsConjoin"  value="<?=$this->Pp2->id_phs?>"/>
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
