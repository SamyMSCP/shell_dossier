<div class="progressBlk">
	<?=$this->ProgressBlock?>
</div>
<form method="POST" class="form-horizontal" id="tosendinfo">
	<div class="contentSituation">
		<div class="blockSituation block1 blockSelected">
			<div class="titleBlockSituation">
				SITUATION FISCALE DE <?=mb_strtoupper($this->ben->getShortName())?>
			</div>
			<div class="contentBlockSituation">
				<div class="contenuOut">
					<div class="contenu">

						<div class="form-group">
							<label class="labelForm control-label" for="residence_principale">Êtes-vous résident fiscal en France ?</label>
							<div class="inputForm"> 
								<label class="radio-inline" for="residence_principale-0">
									<input onchange="checkResid()"  <?=(isset($this->SituationFiscale) && $this->SituationFiscale->getIsResidentFrance()) ? "checked" : "" ?> type="radio" name="residence_france" id="residence_principale-0" value="1"><span></span>Oui
								</label> 
								<label class="radio-inline" for="residence_principale-1">
									<input onchange="checkResid()"  <?=(isset($this->SituationFiscale) && !$this->SituationFiscale->getIsResidentFrance()) ? "checked" : "" ?> type="radio" name="residence_france" id="residence_principale-1" value="0"><span></span>Non
								</label>
							  </div>
						</div>

						<?php
						/*
						<div class="form-group residDetails">
							<label class="labelForm control-label" for="country">Précisez le pays</label>
							<div class="inputForm">
								<input value="<?=(isset($this->SituationFiscale)) ? $this->SituationFiscale->getPays() : "" ?>" id="country" name="pays" type="text" placeholder="" class="form-control input-md"> 
							</div>
						</div>
						*/
						?>

						<div class="form-group residDetails">
							<label class="labelForm control-label" for="country">Précisez le pays</label>
							<div class="arrSelect inputForm">
								<select id="pays" name="pays">
									<?php
									$tmp = (isset($this->SituationFiscale)) ? $this->SituationFiscale->getPays() : "France";
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
								<img src="<?=$this->getPath()?>img/CP-Valide.svg" alt="" style="display:block;"/>
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
				VOTRE SITUATION FISCALE : Impôts sur le revenu
			</div>
			<div class="contentBlockSituation">
				<div class="contenuOut">
					<div class="contenu">

						<div class="form-group">
							<label class="labelForm control-label" for="other_money">Êtes-vous assujetti à l’impôt sur le revenu ?</label>
							<div class="inputForm" style="margin-top: -6px;"> 
								<label class="radio-inline" for="other_money-0">
									<input   <?=(isset($this->SituationFiscale) && $this->SituationFiscale->haveImpot() == true) ? "checked" : "" ?> onchange="checkIR()" type="radio" name="other_money" id="other_money-0" value="1"><span></span>Oui
								</label> 
								<label class="radio-inline" for="other_money-1">
									<input <?=(isset($this->SituationFiscale) && $this->SituationFiscale->haveImpot() == false) ? "checked" : "" ?> onchange="checkIR()" type="radio" name="other_money" id="other_money-1" value="0"><span></span>Non
								</label>
							</div>
						</div>

						<div class="form-group irDetail">
							<label class="labelForm control-label" for="country">Quelle est votre tranche marginale d’imposition (%)</label>
							<div class="arrSelect inputForm">
								<input type="hidden" name="id_impot" id="" value="<?=Valeur_impot::getActual()->id?>" />
								<select id="taux_marginal_imposition" name="id_tranche_impot">
									<?php
									//$tmp = (isset($this->SituationFiscale)) ? $this->SituationFiscale->getPays() : "France";
									foreach (Valeur_impot::getActual()->getDatas() as $key => $elm)
									{
										?>
										<option value="<?=$key?>" 
											<?=((isset($this->SituationFiscale) && $this->SituationFiscale->getImpotId() == Valeur_impot::getActual()->id && $this->SituationFiscale->getTrancheImpotId() == $key) ) ? " selected" : "" ?>
										>
											<?=$elm['taux']?> % : <?= ($elm['haute'] != -1 && $elm['basse'] != 0) ? "entre " : "" ?><?= ($elm['haute'] == -1) ? "supérieur à " : "" ?><?=($elm['basse'] != 0) ? number_format($elm['basse'], 0, ",", " ") ." € " : " n'excédant pas "?><?= ($elm['haute'] != -1 && $elm['basse'] != 0) ? "et " : "" ?><?=($elm['haute'] != -1) ? number_format($elm['haute'], 0, ",", " ") . " €" : "";?>
										</option>
										<?php
									}
									?>
								</select>
								<img src="<?=$this->getPath()?>img/CP-Valide.svg" alt="" style="display:block;"/>
							</div>
						</div>
						<?php
						/*

						<div class="form-group irDetail">
							<label class="labelForm control-label" for="tranche_marginal">Votre tranche marginale d’imposition (%)</label>  
							<div class="inputForm">
								<input  value="<?=(isset($this->SituationFiscale)) ? $this->SituationFiscale->getTauxMarginalImposition() : "" ?>" id="tranche_marginal" name="taux_marginal_imposition" type="text" placeholder="" class="form-control input-md">
							</div>
						</div>


						<div class="form-group irDetail">
							<label class="labelForm control-label" for="">Votre impôt au titre de l’année précédente</label>
							<div class="inputForm">
								<input  value="<?=(isset($this->SituationFiscale)) ? $this->SituationFiscale->getImpotsAnneePrecedente() : "" ?>" id="" name="impots_annee_precedente" class="form-control" placeholder="" type="text">
							</div>
						</div>
						*/
						?>

						<div class="form-group irDetail">
							<label class="labelForm control-label" for="nbr_fiscale">Nombre de parts fiscales</label>  
							<div class="inputForm">
								<input step="0.5" min="1" value="<?=(isset($this->SituationFiscale)) ? $this->SituationFiscale->getNbrPartsFiscale() : "" ?>" id="nbr_fiscale" name="nbr_parts_fiscales" type="number" placeholder="" class="form-control input-md">
								<img id="nbr_fiscaleValide" src="<?=$this->getPath()?>img/CP-Valide.svg" alt=""/>
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
		<div class="blockSituation block3">
			<div class="titleBlockSituation">
				VOTRE SITUATION FISCALE : Impôts sur la fortune (ISF)
			</div>
			<div class="contentBlockSituation">
				<div class="contenuOut">
					<div class="contenu">

						<div class="form-group">
							<label class="labelForm control-label" for="other_money">Êtes-vous assujetti à l’impôt sur la fortune ?</label>
							<div class="inputForm" style="margin-top: -6px;"> 
								<label class="radio-inline" for="fortune-0">
									<input <?=(isset($this->SituationFiscale) && $this->SituationFiscale->haveIsf() == true) ? "checked" : "" ?> onchange="checkISF()" type="radio" name="fortune" id="fortune-0" value="1"><span></span>Oui
								</label> 
								<label class="radio-inline" for="fortune-1">
									<input <?=(isset($this->SituationFiscale) && $this->SituationFiscale->haveIsf() == false) ? "checked" : "" ?> onchange="checkISF()" type="radio" name="fortune" id="fortune-1" value="0"><span></span>Non
								</label>
							</div>
						</div>

						<div class="form-group isfDetail">
							<label class="labelForm control-label" for="country">Quelle est votre tranche d’imposition au titre de l’ISF</label>
							<div class="arrSelect inputForm">
								<input type="hidden" name="id_impot_fortune" id="" value="<?=Valeur_impot_fortune::getActual()->id?>" />
								<select id="tranche_isf" name="id_tranche_impot_fortune">
									<?php
									//$tmp = (isset($this->SituationFiscale)) ? $this->SituationFiscale->getPays() : "France";
									foreach (Valeur_impot_fortune::getActual()->getDatas() as $key => $elm)
									{
										?>
										<option value="<?=$key?>" 
											<?=((isset($this->SituationFiscale) && $this->SituationFiscale->getImpotFortuneId() == Valeur_impot_fortune::getActual()->id && $this->SituationFiscale->getTrancheImpotFortuneId() == $key) ) ? " selected" : "" ?>
										>
											<?=$elm['taux']?> % : <?= ($elm['haute'] != -1 && $elm['basse'] != 0) ? "entre " : "" ?><?= ($elm['haute'] == -1) ? "supérieur à " : "" ?><?=($elm['basse'] != 0) ? number_format($elm['basse'], 0, ",", " ") ." € " : " n'excédant pas "?><?= ($elm['haute'] != -1 && $elm['basse'] != 0) ? "et " : "" ?><?=($elm['haute'] != -1) ? number_format($elm['haute'], 0, ",", " ") . " €" : "";?>
										</option>
										<?php
									}
									?>
								</select>
								<img src="<?=$this->getPath()?>img/CP-Valide.svg" alt="" style="display:block;"/>
							</div>
						</div>
<?php
/*
						<div class="form-group isfDetail">
							<label class="labelForm control-label" for="isf">Votre tranche d’imposition au titre de l’ISF</label>
							<div class="inputForm">
								<input  value="<?=(isset($this->SituationFiscale)) ? $this->SituationFiscale->getTrancheIsf() : "" ?>" id="isf" name="tranche_isf" class="form-control" placeholder="" type="text" required="">
							</div>
						</div>

						<div class="form-group isfDetail">
							<label class="labelForm control-label" for="isf_value">Votre impôt au titre de l’ISF</label>
							<div class="inputForm">
								<input  value="<?=(isset($this->SituationFiscale)) ? $this->SituationFiscale->getMontantIsf() : "" ?>" id="isf_value" name="montant_impot_isf" class="form-control" placeholder="" type="text">
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
	</div>
	<input type="hidden" name="token" id="token" value="<?php echo $_SESSION['csrf'][0]; ?>"/>
	<input type="hidden" name="action" id="" value="setSituationFiscale" />
	<?php
	/*
	<input style="margin-top: 20px;" class="tosend" type="image" src="<?=$this->getPath()?>img/btn_1_hd.jpg" name="send" value="send">
	*/
	?>
</form>
