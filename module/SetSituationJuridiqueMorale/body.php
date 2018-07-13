<?php
include("listeNationalite.php")
?>
<h1>CRÉATION DE VOTRE PROJET</h1>
<div class="progressBlk">
	<?=$this->ProgressBlock?>
</div>
<form method="POST" class="form-horizontal" id="tosendinfo">
	<div class="contentSituation">
		<div class="blockSituation block1 blockSelected">
			<div class="titleBlockSituation">
				SITUATION JURIDIQUE DE LA SOCIÉTÉ
			</div>
			<div class="contentBlockSituation">
				<div class="contenuOut">
					<div class="contenu">

						<div class="form-group">
							<label class="labelForm control-label" for="dn_sociale">Dénominatoin sociale</label>
							<div class="inputForm">
								<input id="dn_sociale" name="dn_sociale" type="text" placeholder="Dénominatoin sociale"  value="<?=$this->Pm->getDenominationSociale()?>" class="form-control input-md" required>
								<img id="dn_socialeValide" src="<?=$this->getPath()?>img/CP-Valide.svg" alt=""/>
							</div>
						</div>

						<div class="form-group">
							<label class="labelForm control-label" for="f_juridique">Forme juridique</label>
							<div class="inputForm">
								<input id="f_juridique" name="f_juridique" type="text" placeholder="Forme juridique"  value="<?=$this->Pm->getFormeJuridique()?>" class="form-control input-md" required>
								<img id="f_juridiqueValide" src="<?=$this->getPath()?>img/CP-Valide.svg" alt=""/>
							</div>
						</div>

						<div class="form-group">
							<label class="labelForm control-label" for="siret">Numéro SIREN</label>
							<div class="inputForm">
								<input id="siret" name="siret" type="text" placeholder="Numéro SIREN"  value="<?=$this->Pm->getSiret()?>" class="form-control input-md" required>
								<img id="siretValide" src="<?=$this->getPath()?>img/CP-Valide.svg" alt=""/>
							</div>
						</div>

						<div class="form-group">
							<label class="labelForm control-label" for="rcs">Enregistrée au RCS de</label>
							<div class="inputForm">
								<input id="rcs" name="rcs" type="text" placeholder="Enregistrée au RCS de"  value="<?=$this->Pm->getRcs()?>" class="form-control input-md" required>
								<img id="rcsValide" src="<?=$this->getPath()?>img/CP-Valide.svg" alt=""/>
							</div>
						</div>

						<div class="form-group">
							<label class="labelForm control-label" for="activite">Activité de la société</label>
							<div class="inputForm">
								<input id="activite" name="activite" type="text" placeholder="Activité de la société"  value="<?=!empty($this->Pm->getLastSituationJuridique()) ? $this->Pm->getLastSituationJuridique()->getActivite() : '' ?>" class="form-control input-md" required>
								<img id="activiteValide" src="<?=$this->getPath()?>img/CP-Valide.svg" alt=""/>
							</div>
						</div>

						<div class="form-group">
							<label class="labelForm control-label" for="representant">Représentant légal de la personne morale</label>
							<div class="inputForm">
								<div class="arrSelect">
									<select name="representant" id="representant">
										<option value="-1" <?=($this->Pm->getGerant() == $this->dh->id_dh) ? "checked" : ""?>>Moi-meme</option>
										<?php
										foreach ($this->otherPp as $key => $elm)
										{
											?>
											<option value="<?=$elm->id_phs?>" <?=($this->Pm->getGerant()->id_phs == $elm->id_phs) ? "selected" : ""?>><?=$elm->getCiviliteFormat()?> <?=$elm->getFirstName()?> <?=$elm->getName()?></option>
											<?php
										}
										?>
										<option value="0">Autre</option>
									</select>
								</div>
							</div>
						</div>


						<div class="form-group qualite_de">
							<label class="labelForm control-label" for="qualite_de">qualité de</label>
							<div class="inputForm">
								<input id="qualite_de" name="qualite_de" type="text" placeholder="En qualité de"  value="<?=!empty($this->Pm->getLastSituationJuridique()) ? $this->Pm->getLastSituationJuridique()->getQualiteDe() : '' ?>" class="form-control input-md" required>
								<img id="qualite_deValide" src="<?=$this->getPath()?>img/CP-Valide.svg" alt="" style="display:block;"/>
							</div>
						</div>

						<div class="form-group representantInfos">
							<label class="labelForm control-label" for="representantCivilite">Civilite du représentant</label>
							<div class="inputForm">
								<div class="arrSelect">
									<select name="representantCivilite">
										<option value="Monsieur">Monsieur</option>
										<option value="Madame">Madame</option>
									</select>
								</div>
								<img src="<?=$this->getPath()?>img/CP-Valide.svg" alt="" style="display:block;"/>
							</div>
						</div>

						<div class="form-group representantInfos">
							<label class="labelForm control-label" for="representantNom">Nom du représentant</label>
							<div class="inputForm">
								<input id="representantNom" name="representantNom" type="text" placeholder="Nom du représentant"  value="" class="form-control input-md" required>
								<img id="representantNomValide" src="<?=$this->getPath()?>img/CP-Valide.svg" alt=""/>
							</div>
						</div>

						<div class="form-group representantInfos">
							<label class="labelForm control-label" for="representantPrenom">Prenom du représentant</label>
							<div class="inputForm">
								<input id="representantPrenom" name="representantPrenom" type="text" placeholder="Prenom du représentant"  value="" class="form-control input-md" required>
								<img id="representantPrenomValide" src="<?=$this->getPath()?>img/CP-Valide.svg" alt=""/>
							</div>
						</div>



						<?php
						/*
						<div class="form-group">
							<label class="labelForm control-label" for="representant">Représentant légal de la personne morale</label>
							<div class="inputForm">
								<input id="representant" name="representant" type="text" placeholder="Représentant légal de la personne morale"  value="<?=($this->Pm->getLastSituationJuridique()) ? $this->Pm->getLastSituationJuridique()->getRepresentant() : '' ?>" class="form-control input-md" required>
								<img id="representantValide" src="<?=$this->getPath()?>img/CP-Valide.svg" alt=""/>
							</div>
						</div>

						<div class="form-group"  id="gerantCheck">
							<label class="labelForm control-label" for="gerant">Etes-vous le gerant ?</label>
							<div class="inputForm">
								<label class="radio-inline" for="gerant-0">
									<input type="radio" name="gerant" id="gerant-0" value="1" ><span></span>
										Oui
								</label>
								<label class="radio-inline" for="gerant-1">
									<input type="radio" name="gerant" id="gerant-1" value="0" ><span></span>
										Non
								</label>
							</div>
						</div>

						<div class="form-group">
							<label class="labelForm control-label" for="nom">Nationalite</label>  
							<div class="inputForm">
								<div class="arrSelect">
									<select name="nationalite" id="Nationalite">
										<?php
										$tmp = !empty($this->Pm->getLastSituationJuridique() && !empty($this->Pm->getLastSituationJuridique()->getNationalite())) ? $this->Pm->getLastSituationJuridique()->getNationalite() : "Française";
										$tmp = "Française";
										foreach ($lstNat as $key => $elm)
										{
											?>
											<option value="<?=$elm['title']?>" <?php if ($elm['title'] == $tmp) echo "selected";?>><?=$elm['title']?></option>
											<?php
										}
										?>
									</select>
								</div>
								<img src="<?=$this->getPath()?>img/CP-Valide.svg" alt="" style="display:block;"/>
							</div>
						</div>
						*/
						?>

						<div class="form-group">
							<label class="labelForm control-label" for="representant">Adresse du siège social</label>
							<div class="inputForm">
								<input id="siege_social" name="siege_social" type="text" placeholder="Adresse du siège social"  value="<?=!empty($this->Pm->getLastSituationJuridique()) ? $this->Pm->getLastSituationJuridique()->getSiegeSocial() : '' ?>" class="form-control input-md" required>
								<img id="siege_socialValide" src="<?=$this->getPath()?>img/CP-Valide.svg" alt=""/>
							</div>
						</div>

						<?php

						/*
						<div class="form-group">
							<label class="labelForm control-label" for="us_person">Le bénéficiaire est-il une US Person ?</label>
							<div class="inputForm">
								<label class="radio-inline" for="us_person-0">
									<input type="radio" name="us_person" id="us_person-0" value="1" <?=($this->dh->getPersonnePhysique()->getUsPerson()) ? "checked" : ""?>><span></span>
										Oui
								</label>
								<label class="radio-inline" for="us_person-1">
									<input type="radio" name="us_person" id="us_person-1" value="0" <?=(!$this->dh->getPersonnePhysique()->getUsPerson()) ? "checked" : ""?>><span></span>
										Non
								</label>
							</div>
						</div>

						<!-- Multiple Checkboxes (inline) -->
						<div class="form-group">
							<label class="labelForm control-label" for="politique">Le bénéficiaire est-il politiquement exposée ?</label>
							<div class="inputForm">
								<label class="radio-inline" for="politique-0">
									<input type="radio" name="politique" id="politique-0" value="1" <?=($this->dh->getPersonnePhysique()->getPolitiquementExpose()) ? "checked" : ""?>><span></span>
									Oui
								</label>
								<label class="radio-inline" for="politique-1">
										<input type="radio" name="politique" id="politique-1" value="0" <?=(!$this->dh->getPersonnePhysique()->getPolitiquementExpose()) ? "checked" : ""?>><span></span>
										Non
								</label>
							</div>
						</div>
						*/
						?>
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

		<input type="hidden" name="id_pm"  value="<?=$this->Pm->id_pm?>"/>
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

