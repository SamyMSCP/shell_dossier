<h1 style="color: #1781e0;">CRÉATION DE VOTRE PROJET</h1>
<div class="progressBlk">
	<?=$this->ProgressBlock?>
</div>
<form method="POST" class="form-horizontal" id="tosendinfo">

	<div class="contentSituation">
		<div class="blockSituation block1 blockSelected">
			<div class="titleBlockSituation">
				SITUATION PATRIMONIALE DE <?=mb_strtoupper($this->ben->getShortName())?>
			</div>
			<div class="contentBlockSituation">
				<div class="contenuOut">
					<div class="contenu">

						Pouvez-vous nous indiquer une estimation de la valeur de votre patrimoine global.
						<div class="form-group">
							<label class="labelForm control-label" for="fourchette_montant_patrimoine-0">
								 moins de 50 000 €
							</label>
							<div class="inputForm">
								<label class="radio-inline" for="fourchette_montant_patrimoine-0">
									<input 
									<?=(isset($this->SituationPatrimoniale) && $this->SituationPatrimoniale->getFourchetteMontantPatrimoine() == 1) ? "checked" : "" ?>
									type="radio" name="fourchette_montant_patrimoine" id="fourchette_montant_patrimoine-0" value="1" required>
									<span></span>
								</label>
							</div>
						</div>



						<div class="form-group">
							<label class="labelForm control-label" for="fourchette_montant_patrimoine-1">
								entre 50 000 € et 100 000 €
							</label>
							<div class="inputForm">
								<label class="radio-inline" for="fourchette_montant_patrimoine-1">
									<input 
									<?=(isset($this->SituationPatrimoniale) && $this->SituationPatrimoniale->getFourchetteMontantPatrimoine() == 2) ? "checked" : "" ?>
									type="radio" name="fourchette_montant_patrimoine" id="fourchette_montant_patrimoine-1" value="2">
									<span></span>
								</label>
							</div>
						</div>



						<div class="form-group">
							<label class="labelForm control-label" for="fourchette_montant_patrimoine-2">
								entre 100 000 € et 500 000 €
							</label>
							<div class="inputForm">
								<label class="radio-inline" for="fourchette_montant_patrimoine-2">
									<input 
									<?=(isset($this->SituationPatrimoniale) && $this->SituationPatrimoniale->getFourchetteMontantPatrimoine() == 3) ? "checked" : "" ?>
									type="radio" name="fourchette_montant_patrimoine" id="fourchette_montant_patrimoine-2" value="3">
									<span></span>
								</label>
							</div>
						</div>



						<div class="form-group">
							<label class="labelForm control-label" for="fourchette_montant_patrimoine-3">
								entre 500 000 € et 1 300 000 €
							</label>
							<div class="inputForm">
								<label class="radio-inline" for="fourchette_montant_patrimoine-3">
									<input 
									<?=(isset($this->SituationPatrimoniale) && $this->SituationPatrimoniale->getFourchetteMontantPatrimoine() == 4) ? "checked" : "" ?>
									type="radio" name="fourchette_montant_patrimoine" id="fourchette_montant_patrimoine-3" value="4">
									<span></span>
								</label>
							</div>
						</div>



						<div class="form-group">
							<label class="labelForm control-label" for="fourchette_montant_patrimoine-4">
								plus de 1 300 000 €
							</label>
							<div class="inputForm">
								<label class="radio-inline" for="fourchette_montant_patrimoine-4">
									<input 
									<?=(isset($this->SituationPatrimoniale) && $this->SituationPatrimoniale->getFourchetteMontantPatrimoine() == 5) ? "checked" : "" ?>
									type="radio" name="fourchette_montant_patrimoine" id="fourchette_montant_patrimoine-4" value="5">
									<span></span>
								</label>
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
				RÉPARTITION DU PATRIMOINE DE <?=mb_strtoupper($this->ben->getShortName())?>
			</div>
			<div class="contentBlockSituation">
				<div class="contenuOut">
					<div class="contenu">
						<table class="table tableRepartition">
							<thead>
								<tr>
									<th>Type de patrimoine</th>
									<th>Répartition en €</th>
								</tr>
							</thead>
							<tbody>


								<tr class="forTotal">
									<td>Résidence principale</td>
									<td>
										<input 
										 value="<?=(isset($this->SituationPatrimoniale)) ? $this->SituationPatrimoniale->getRepResidencePrincipale() : "0" ?>"
										id="repartition_residence_principale" name="repartition_residence_principale" type="number" value="0" min="0">
									</td>
								</tr>


								<tr class="forTotal">
									<td>Assurance-vie</td>
									<td>
										<input 
										 value="<?=(isset($this->SituationPatrimoniale)) ? $this->SituationPatrimoniale->getRepAssuranceVie() : "0" ?>"
										id="repartition_assurance_vie" name="repartition_assurance_vie"  type="number" value="0" min="0">
									</td>
								</tr>


								<tr class="forTotal">
									<td>PEA / Compte titre</td>
									<td>
										<input 
										 value="<?=(isset($this->SituationPatrimoniale)) ? $this->SituationPatrimoniale->getRepPEA() : "0" ?>"
										id="repartition_PEA" name="repartition_PEA"  type="number" value="0" min="0">
									</td>
								</tr>

								<tr class="forTotal">
									<td>PEL / CEL / CODEVI / Livret</td>
									<td>
										<input 
										 value="<?=(isset($this->SituationPatrimoniale)) ? $this->SituationPatrimoniale->getRepPEL() : "0" ?>"
										id="repartition_PEL" name="repartition_PEL"  type="number" value="0" min="0">
									</td>
								</tr>














								<tr class="forTotal">
									<td>Résidence secondaire</td>
									<td>
										<input 
										 value="<?=(isset($this->SituationPatrimoniale)) ? $this->SituationPatrimoniale->getRepResidenceSecondaire() : "0" ?>"
										id="repartition_residence_secondaire" name="repartition_residence_secondaire"  type="number" value="0" min="0">
									</td>
								</tr>
								<tr class="forTotal">
									<td>Immobilier locatif</td>
									<td>
										<input 
										 value="<?=(isset($this->SituationPatrimoniale)) ? $this->SituationPatrimoniale->getRepImmobilierLocatif() : "0" ?>"
										id="repartition_immobilier_locatif" name="repartition_immobilier_locatif"  type="number" value="0" min="0">
									</td>
								</tr>
								<tr class="forTotal">
									<td>SCPI</td>
									<td>
										<input 
										 value="<?=(isset($this->SituationPatrimoniale)) ? $this->SituationPatrimoniale->getRepScpi() : "0" ?>"
										id="repartition_scpi" name="repartition_scpi" type="number" min="0">
									</td>
								</tr>
								<tr class="forTotal">
									<td>Autres</td>
									<td>
									   <input 
										 value="<?=(isset($this->SituationPatrimoniale)) ? $this->SituationPatrimoniale->getRepAutres() : "0" ?>"
									   id="repartition_autres" name="repartition_autres"  type="number" value="0" min="0">
									</td>
								</tr>
								<tr class="PatrimoineTotal">
									<td>Total</td>
									<td class="totalValue">52</td>
								</tr>
							</tbody>
						</table>
					</div>
					<div class="contenu contenuRepartition" >
						<div class='forRepartinion'>
							<canvas id="repartition_patrimoine"></canvas>
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
		<div class="blockSituation block3">
			<div class="titleBlockSituation">
				QUELLE SERA LA PART DE CE FUTUR PLACEMENT DANS VOTRE PATRIMOINE ?
			</div>
			<div class="contentBlockSituation">
				<div class="contenuOut">
					<div class="contenu">
						<div class="form-group" style="margin-top: 50px;">
							<label class="radio-inline" for="placement-0">
								<input 
								<?=(isset($this->SituationPatrimoniale) && $this->SituationPatrimoniale->getFuturPlacement() == 1) ? "checked" : "" ?>
								type="radio" name="futur_placement" id="placement-0" value="1" required>
								<span style="margin-right:5px !important;"></span>Faible (inférieure à 10 %)
							</label> 
							<label class="radio-inline" for="placement-1">
								<input 
								<?=(isset($this->SituationPatrimoniale) && $this->SituationPatrimoniale->getFuturPlacement() == 2) ? "checked" : "" ?>
								type="radio" name="futur_placement" id="placement-1" value="2">
								<span style="margin-right:5px !important"></span>Moyenne (10 à 30 %)
							</label>
							<label class="radio-inline" for="placement-2">
								<input 
								<?=(isset($this->SituationPatrimoniale) && $this->SituationPatrimoniale->getFuturPlacement() == 3) ? "checked" : "" ?>
								type="radio" name="futur_placement" id="placement-2" value="3">
								<span style="margin-right:5px !important"></span>Importante (supérieure à 30 %)
							</label>
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
	<input type="hidden" name="token" id="token" value="<?php echo $_SESSION['csrf'][0]; ?>"/>
	<input type="hidden" name="action" id="" value="setSituationPatrimoniale" />
	<?php
	/*
	<input style="margin-top: 20px;" id="sendBtn" class="tosend" type="image" src="<?=$this->getPath()?>img/btn_1_hd.jpg" name="send" value="send">
	*/
	?>
</form>

<!-- Small modal -->
<div class="modal fade modalPrevention2" tabindex="-1" role="dialog" aria-labelledby="modalPrevention2">
	<div class="modal-dialog modal-sm preventionCapital" role="document">
		<div class="modal-content">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><img style="height:30px;" src="<?=$this->getPath()?>img/Close-Jaune.svg" alt="" /></button>
			<h3>Attention, vous avez indiqué vouloir faire un investissement important qui représentera plus de 10 % de votre patrimoine. Êtes-vous sûr(e) de vouloir poursuivre ?</h3>
			<p>Nous recommandons à nos clients que les SCPI ne représentent pas plus de 10 % de leur patrimoine.</p>
			<div class="lstButton">
				<div id="btnNoContinue" data-dismiss="modal" class="btnCapital">Je modifie mes préférences</div>
				<div id="btnContinue2" class="btnCapital">Oui, je souhaite poursuivre</div>
			</div>
		</div>
	</div>
</div>

<!-- Small modal -->
<div class="modal fade modalPrevention" tabindex="-1" role="dialog" aria-labelledby="modalPrevention">
	<div class="modal-dialog modal-sm preventionCapital" role="document">
		<div class="modal-content">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><img style="height:30px;" src="<?=$this->getPath()?>img/Close-Jaune.svg" alt="" /></button>
			<h3>Attention, vous avez indiqué vouloir faire un investissement important qui représentera plus de 30 % de votre patrimoine. Êtes-vous sûr(e) de vouloir poursuivre ?</h3>
			<p>Nous recommandons à nos clients que les SCPI ne représentent pas plus de 10 % de leur patrimoine.</p>
			<div class="lstButton">
				<div id="btnNoContinue" data-dismiss="modal" class="btnCapital">Je modifie mes préférences</div>
				<div id="btnContinue" class="btnCapital">Oui, je souhaite poursuivre</div>
			</div>
		</div>
	</div>
</div>
