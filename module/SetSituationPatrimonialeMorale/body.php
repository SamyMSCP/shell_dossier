<h1>CRÉATION DE VOTRE PROJET</h1>
<div class="progressBlk">
	<?=$this->ProgressBlock?>
</div>
<form method="POST" class="form-horizontal" id="tosendinfo">

	<div class="contentSituation">
		<div class="blockSituation block1 blockSelected">
			<div class="titleBlockSituation">
				VOUS ÉVALUEZ VOTRE PATRIMOINE NET À :
			</div>
			<div class="contentBlockSituation">
				<div class="contenuOut">
					<div class="contenu">
						<div class="form-group">
							<label class="labelForm control-label" for="fourchette_montant_patrimoine-0">
								 50 000 €
							</label>
							<div class="inputForm">
								<label class="radio-inline" for="fourchette_montant_patrimoine-0">
									<input 
									<?=(!isset($this->SituationPatrimonialeMorale) || $this->SituationPatrimonialeMorale->getFourchetteMontantPatrimoine() == 1) ? "checked" : "" ?>
									type="radio" name="fourchette_montant_patrimoine" id="fourchette_montant_patrimoine-0" value="1" required>
									<span></span>
								</label>
							</div>
						</div>



						<div class="form-group">
							<label class="labelForm control-label" for="fourchette_montant_patrimoine-0">
								entre 50 000 € et 100 000 €
							</label>
							<div class="inputForm">
								<label class="radio-inline" for="fourchette_montant_patrimoine-1">
									<input 
									<?=(isset($this->SituationPatrimonialeMorale) && $this->SituationPatrimonialeMorale->getFourchetteMontantPatrimoine() == 2) ? "checked" : "" ?>
									type="radio" name="fourchette_montant_patrimoine" id="fourchette_montant_patrimoine-1" value="2">
									<span></span>
								</label>
							</div>
						</div>



						<div class="form-group">
							<label class="labelForm control-label" for="fourchette_montant_patrimoine-0">
								entre 100 000 € et 500 000 €
							</label>
							<div class="inputForm">
								<label class="radio-inline" for="fourchette_montant_patrimoine-2">
									<input 
									<?=(isset($this->SituationPatrimonialeMorale) && $this->SituationPatrimonialeMorale->getFourchetteMontantPatrimoine() == 3) ? "checked" : "" ?>
									type="radio" name="fourchette_montant_patrimoine" id="fourchette_montant_patrimoine-2" value="3">
									<span></span>
								</label>
							</div>
						</div>



						<div class="form-group">
							<label class="labelForm control-label" for="fourchette_montant_patrimoine-0">
								entre 500 000 € et 1 300 000 €
							</label>
							<div class="inputForm">
								<label class="radio-inline" for="fourchette_montant_patrimoine-3">
									<input 
									<?=(isset($this->SituationPatrimonialeMorale) && $this->SituationPatrimonialeMorale->getFourchetteMontantPatrimoine() == 4) ? "checked" : "" ?>
									type="radio" name="fourchette_montant_patrimoine" id="fourchette_montant_patrimoine-3" value="4">
									<span></span>
								</label>
							</div>
						</div>



						<div class="form-group">
							<label class="labelForm control-label" for="fourchette_montant_patrimoine-0">
								plus de 1 300 000 €
							</label>
							<div class="inputForm">
								<label class="radio-inline" for="fourchette_montant_patrimoine-4">
									<input 
									<?=(isset($this->SituationPatrimonialeMorale) && $this->SituationPatrimonialeMorale->getFourchetteMontantPatrimoine() == 5) ? "checked" : "" ?>
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
				SITUATION PATRIMONIALE DE LA SOCIÉTÉ
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


								<tr>
									<td>Liquidité</td>
									<td>
										<input 
										 value="<?=(isset($this->SituationPatrimonialeMorale)) ? $this->SituationPatrimonialeMorale->getRepLiquidite() : "0" ?>"
										id="repartition_liquidite" name="repartition_liquidite" type="number" value="0" min="0">
									</td>
								</tr>

								<tr>
									<td>Placement de trésorerie court terme</td>
									<td>
										<input 
										 value="<?=(isset($this->SituationPatrimonialeMorale)) ? $this->SituationPatrimonialeMorale->getRepCourt() : "0" ?>"
										id="repartition_court" name="repartition_court"  type="number" value="0" min="0">
									</td>
								</tr>

								<tr>
									<td>Placement de trésorerie long terme</td>
									<td>
										<input 
										 value="<?=(isset($this->SituationPatrimonialeMorale)) ? $this->SituationPatrimonialeMorale->getRepLong() : "0" ?>"
										id="repartition_long" name="repartition_long"  type="number" value="0" min="0">
									</td>
								</tr>

								<tr>
									<td>Investissement imobilier direct</td>
									<td>
										<input 
										 value="<?=(isset($this->SituationPatrimonialeMorale)) ? $this->SituationPatrimonialeMorale->getRepImmobilier() : "0" ?>"
										id="repartition_immobilier" name="repartition_immobilier"  type="number" value="0" min="0">
									</td>
								</tr>

								<tr>
									<td>SCPI</td>
									<td>
										<input 
										 value="<?=(isset($this->SituationPatrimonialeMorale)) ? $this->SituationPatrimonialeMorale->getRepScpi() : "0" ?>"
										id="repartition_scpi" name="repartition_scpi"  type="number" value="0" min="0">
									</td>
								</tr>

								<tr>
									<td>Autres</td>
									<td>
									   <input 
										 value="<?=(isset($this->SituationPatrimonialeMorale)) ? $this->SituationPatrimonialeMorale->getRepAutres() : "0" ?>"
									   id="repartition_autres" name="repartition_autres"  type="number" value="0" min="0">
									</td>
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
								<?=(!isset($this->SituationPatrimonialeMorale) || $this->SituationPatrimonialeMorale->getFuturPlacement() == 1) ? "checked" : "" ?>
								type="radio" name="futur_placement" id="placement-0" value="1" required>
								<span></span>Faible (inférieure à 10 %)
							</label> 
							<label class="radio-inline" for="placement-1">
								<input 
								<?=(!isset($this->SituationPatrimonialeMorale) || $this->SituationPatrimonialeMorale->getFuturPlacement() == 2) ? "checked" : "" ?>
								type="radio" name="futur_placement" id="placement-1" value="2">
								<span></span>Moyenne (10 à 30 %)
							</label>
							<label class="radio-inline" for="placement-2">
								<input 
								<?=(!isset($this->SituationPatrimonialeMorale) || $this->SituationPatrimonialeMorale->getFuturPlacement() == 3) ? "checked" : "" ?>
								type="radio" name="futur_placement" id="placement-2" value="3">
								<span></span>Importante (supérieure à 30 %)
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
<div class="modal fade modalPrevention" tabindex="-1" role="dialog" aria-labelledby="modalPrevention">
	<div class="modal-dialog modal-sm preventionCapital" role="document">
		<div class="modal-content">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><img style="height:30px;" src="<?=$this->getPath()?>img/Close-Jaune.svg" alt="" /></button>
			<h3>ATTENTION, VOUS AVEZ INDIQUÉ VOULOIR FAIRE UN INVESTISSEMENT IMPORTANT QUI REPRÉSENTERA PLUS DE 30 % DE VOTRE PATRIMOINE. ÊTES-VOUS SÛR(E) DE VOULOIR POURSUIVRE ?</h3>
			<br />
			<p>Les SCPI n’offrent pas de garantie du capital investi et les performances passées ne préjugent en rien des performances à venir.</p>
			<div class="lstButton">
				<div id="btnNoContinue" data-dismiss="modal" class="btnCapital">Je modifie mes préférences</div>
				<div id="btnContinue" class="btnCapital">Oui, je souhaite poursuivre</div>
			</div>
		</div>
	</div>
</div>
