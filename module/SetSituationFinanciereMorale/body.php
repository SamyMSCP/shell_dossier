<h1>CRÉATION DE VOTRE PROJET</h1>
<div class="progressBlk">
	<?=$this->ProgressBlock?>
</div>
<form action="?p=<?=$GLOBALS['GET']['p']?>&projet=<?=$GLOBALS['GET']['projet']?>" method="POST" class="form-horizontal" id="tosendinfo">
	<div class="contentSituation">
		<div class="blockSituation block1 blockSelected">
			<div class="titleBlockSituation">
				SITUATION FINANCIÈRE DE LA SOCIÉTÉ
			</div>
			<div class="contentBlockSituation">
				<div class="contenuOut">
					<div class="contenu">

						<table class="table empOther tableRepartition">
							<thead>
								<tr>
									<th>Année</th>
									<th>N</th>
									<th>N-1</th>
									<th>N-2</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>Chiffres d'affaires</td>
									<td>
										<input value="<?=(!empty($this->SituationFinanciereMorale)) ? $this->SituationFinanciereMorale->getDatas()["N"]["CA"] : ""?>" min="0" id="CA_N" name="CA_N" type="number" required><span>€</span>
									</td>
									<td>
										<input value="<?=(!empty($this->SituationFinanciereMorale)) ? $this->SituationFinanciereMorale->getDatas()["N1"]["CA"] : ""?>" min="0" id="CA_N1" name="CA_N1" type="number" required><span>€</span>
									</td>
									<td>
										<input value="<?=(!empty($this->SituationFinanciereMorale)) ? $this->SituationFinanciereMorale->getDatas()["N2"]["CA"] : ""?>" min="0" id="CA_N2" name="CA_N2" type="number" required><span>€</span>

									</td>
								</tr>
								<tr>
									<td>Résultats</td>
									<td>
										<input value="<?=(!empty($this->SituationFinanciereMorale)) ? $this->SituationFinanciereMorale->getDatas()["N"]["resultat"] : ""?>" min="0" id="resultat_N" name="resultat_N" type="number" required><span>€</span>
									</td>
									<td>
										<input value="<?=(!empty($this->SituationFinanciereMorale)) ? $this->SituationFinanciereMorale->getDatas()["N1"]["resultat"] : ""?>" min="0" id="resultat_N1" name="resultat_N1" type="number" required><span>€</span>
									</td>
									<td>
										<input value="<?=(!empty($this->SituationFinanciereMorale)) ? $this->SituationFinanciereMorale->getDatas()["N2"]["resultat"] : ""?>" min="0" id="resultat_N2" name="resultat_N2" type="number" required><span>€</span>
									</td>
								</tr>
								<tr>
									<td>Taux d'endettement de la société</td>
									<td>
										<input value="<?=(!empty($this->SituationFinanciereMorale)) ? $this->SituationFinanciereMorale->getDatas()["N"]["taux_endettement"] : ""?>" min="0" id="taux_endettement_N" name="taux_endettement_N" type="number" required><span>%</span>
									</td>
									<td>
										<input value="<?=(!empty($this->SituationFinanciereMorale)) ? $this->SituationFinanciereMorale->getDatas()["N1"]["taux_endettement"] : ""?>" min="0" id="taux_endettement_N1" name="taux_endettement_N1" type="number" required><span>%</span>
									</td>
									<td>
										<input value="<?=(!empty($this->SituationFinanciereMorale)) ? $this->SituationFinanciereMorale->getDatas()["N2"]["taux_endettement"] : ""?>" min="0" id="taux_endettement_N2" name="taux_endettement_N2" type="number" required><span>%</span>
									</td>
								</tr>
							</tbody>
						</table>
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
				SITUATION FINANCIÈRE DE LA SOCIÉTÉ
			</div>
			<div class="contentBlockSituation">
				<div class="contenuOut">
					<div class="contenu">

						<div class="form-group" style="margin-top: 50px;">
							<label class="labelForm control-label" for="evolution_CA">Prévoyez-vous des évolutions de votre chiffre d’affaire dans les prochaines années ? </label>
							<div class="inputForm" style="margin-top: -6px;"> 
								<label class="radio-inline" for="evolution_CA-0">
									<input   <?=(!empty($this->SituationFinanciereMorale) && $this->SituationFinanciereMorale->getEvolutionCA() > 0) ? "checked" : "" ?> onclick="checkOther();" type="radio" name="evolution_CA" id="evolution_CA-0" value="1">
									<span></span>Oui
								</label> 
								<label onclick="checkOther();" class="radio-inline" for="evolution_CA-1">
									<input  <?=(empty($this->SituationFinanciereMorale) || $this->SituationFinanciereMorale->getEvolutionCA() <= 0) ? "checked" : "" ?> type="radio" name="evolution_CA" id="evolution_CA-1" value="0">
									<span></span>Non
								</label>
							</div>
						</div>

						<div class="form-group" style="margin-top: 50px;">
							<label class="labelForm control-label" for="other_money">Prévoyez-vous des investissements conséquents sur les prochaines années ?</label>
							<div class="inputForm" style="margin-top: -6px;"> 
								<label class="radio-inline" for="investissement_consequent_prevu-0">
									<input <?=(!empty($this->SituationFinanciereMorale) && $this->SituationFinanciereMorale->getInvestissementPrevu() > 0) ? "checked" : "" ?> onclick="checkOther();" type="radio" name="investissement_consequent_prevu" id="investissement_consequent_prevu-0" value="1">
									<span></span>Oui
								</label> 
								<label onclick="checkOther();" class="radio-inline" for="investissement_consequent_prevu-1">
									<input <?=(empty($this->SituationFinanciereMorale) || $this->SituationFinanciereMorale->getInvestissementPrevu() <= 0) ? "checked" : "" ?>  type="radio" name="investissement_consequent_prevu" id="investissement_consequent_prevu-1" value="0">
									<span></span>Non
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
	<input type="hidden" name="token" id="token" value="<?php echo $_SESSION['csrf'][0]; ?>"/>
	<input type="hidden" name="action" id="" value="setSituationFinanciere" />
	<?php
	/*
	<input style="margin-top: 20px;" class="tosend" type="image" src="<?=$this->getPath()?>img/btn_1_hd.jpg" name="send" value="send">
	*/
	?>
</form>
