<div class="progressBlk">
	<?=$this->ProgressBlock?>
</div>
<form method="POST" class="form-horizontal" id="tosendinfo">
	<div class="contentSituation">
		<div class="blockSituation block1 blockSelected">
			<div class="titleBlockSituation">
				SITUATION FISCALE DE LA SOCIÉTÉ
			</div>
			<div class="contentBlockSituation">
				<div class="contenuOut">
					<div class="contenu">

						<div class="form-group">
							<label class="labelForm control-label" for="regime_imposition">Régime d’imposition :</label>
							<div class="inputForm"> 
								<label class="radio-inline" for="regime_imposition-0">
									<input  <?=(empty($this->SituationFiscaleMorale) || $this->SituationFiscaleMorale->getRegimeImposition() == 0) ? "checked" : "" ?> onchange="checkResid()" type="radio" name="regime_imposition" id="regime_imposition-0" value="0"><span></span>IR
								</label> 
								<label class="radio-inline" for="regime_imposition-1">
									<input  <?=(!empty($this->SituationFiscaleMorale) && $this->SituationFiscaleMorale->getRegimeImposition() == 1) ? "checked" : "" ?> onchange="checkResid()" type="radio" name="regime_imposition" id="regime_imposition-1" value="1"><span></span>IS
								</label>
								<label class="radio-inline" for="regime_imposition-2">
									<input  <?=(!empty($this->SituationFiscaleMorale) && $this->SituationFiscaleMorale->getRegimeImposition() == 2) ? "checked" : "" ?> onchange="checkResid()" type="radio" name="regime_imposition" id="regime_imposition-2" value="2"><span></span>BIC
								</label> 
								<label class="radio-inline" for="regime_imposition-3">
									<input  <?=(!empty($this->SituationFiscaleMorale) && $this->SituationFiscaleMorale->getRegimeImposition() == 3) ? "checked" : "" ?> onchange="checkResid()" type="radio" name="regime_imposition" id="regime_imposition-3" value="3"><span></span>BNC
								</label>
							  </div>
						</div>

						<div class="form-group">
							<label class="labelForm control-label" for="frottement_regime">Votre frottement en fonction du régime (%)</label>  
							<div class="inputForm">
								<input  value="<?=(!empty($this->SituationFiscaleMorale)) ? $this->SituationFiscaleMorale->getFrottementRegime() : ""?>"  id="frottement_regime" min="0"  max="100" name="frottement_regime" type="number" placeholder="" class="form-control input-md">
								<img id="frottement_regimeValide" src="<?=$this->getPath()?>img/CP-Valide.svg" alt="" style="display:block;"/>
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
	<input type="hidden" name="token" id="token" value="<?php echo $_SESSION['csrf'][0]; ?>"/>
	<input type="hidden" name="action" id="" value="setSituationFiscale" />
	<?php
	/*
	<input style="margin-top: 20px;" class="tosend" type="image" src="<?=$this->getPath()?>img/btn_1_hd.jpg" name="send" value="send">
	*/
	?>
</form>
