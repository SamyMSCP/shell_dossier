<div class="progressBlk">
	<?=$this->ProgressBlock?>
</div>
<form id="setProjectForm" method="post" action="?p=<?=$GLOBALS['GET']['p']?>">

<?php
/////////////////////////////////////////////////
///////////////////////////////// Premier block
/////////////////////////////////////////////////
?>

	<div class="title title_selected" id="el_1" >
		<p>1. VOUS SOUHAITEZ FAIRE L’INVESTISSEMENT POUR...</p>
	</div>
	<div class="content_body form-horizontal mod_1" style="overflow:hidden;">
		<div>
			<div class="radio">
				<label for="forwhom-1">
					<input class="inputFirstBlock" type="radio" name="forwhom" id="forwhom-1" value="1" ><span></span>
					Moi seul
				</label>
			</div>
			<div class="radio">
				<label for="forwhom-2">
					<input class="inputFirstBlock" type="radio" name="forwhom" id="forwhom-2" value="2"><span></span>
					Mon conjoint et moi-même
					<div class="quiConjoin">
						<div id="selectConjoin">
							Mon conjoint est :
							<select name="compteConjoin" id="compteConjoin">
								<?php
								foreach ($this->otherPp as $key => $elm)
								{
									?>
									<option value="<?=$elm->id_phs?>"><?=$elm->getCiviliteFormat()?> <?=$elm->getFirstName()?> <?=$elm->getName()?></option>
									<?php
								}
								?>
								<option value="0">Autre</option>
							</select>
						</div>
					</div>
				</label>
			</div>
			<div class="radio">
				<label for="forwhom-5">
					<input class="inputFirstBlock" type="radio" name="forwhom" id="forwhom-5" value="5"><span></span>
					Mon conjoint
					<div class="quiConjoinSeul">
						<div id="selectConjoinSeul">
							Mon conjoint est :
							<select name="compteConjoinSeul" id="compteConjoinSeul">
								<?php
								foreach ($this->otherPp as $key => $elm)
								{
									?>
									<option value="<?=$elm->id_phs?>"><?=$elm->getCiviliteFormat()?> <?=$elm->getFirstName()?> <?=$elm->getName()?></option>
									<?php
								}
								?>
								<option value="0">Autre</option>
							</select>
						</div>
					</div>
				</label>
			</div>
			<div class="radio">
				<label for="forwhom-3">
					<input class="inputFirstBlock" type="radio" name="forwhom" id="forwhom-3" value="3"><span></span>
					Un de mes parents
					<div class="quiParent">
						<div id="selectOther">
							Je souhaite investir pour : 
							<select name="compteParent" id="compteParent">
								<?php
								foreach ($this->otherPp as $key => $elm)
								{
									?>
									<option value="<?=$elm->id_phs?>"><?=$elm->getCiviliteFormat()?> <?=$elm->getFirstName()?> <?=$elm->getName()?></option>
									<?php
								}
								?>
								<option value="0">Autre</option>
							</select>
						</div>
					</div>
				</label>
			</div>
			<div class="radio">
				<label for="forwhom-4">
					<input class="inputFirstBlock" type="radio" name="forwhom" id="forwhom-4" value="4"><span></span>
					Une société dont je suis le gérant
					<div class="quiEntreprise">
						<div id="selectEntreprise">
							Je deja investit pour ma societe : 
							<select name="compteEntreprise" id="compteEntreprise">
								<?php
								foreach ($this->Pm as $key => $elm)
								{
									?>
									<option value="<?=$elm->id_pm?>"><?=$elm->getDenominationSociale()?></option>
									<?php
								}
								?>
								<option value="0">Autre</option>
							</select>
						</div>
					</div>
				</label>
			</div>
		</div>
		<div class="blockValidation1">
		<?php
		/*
			<div class="alone">
				<div class="btn-next btn-next-step-1">
					<div class="inactive">
						QUESTION SUIVANTE
						<img src="<?=$this->getPath()?>img/CP-Fleche-GrisFonce.svg" alt="" />
					</div>
					<div class="active">
						QUESTION SUIVANTE
						<img src="<?=$this->getPath()?>img/CP-Fleche-BleuClair.svg" alt="" />
					</div>
				</div>
			</div>
			*/
			?>
			<div class="quiConjoin">
				<div class="conjoinNewInfo">
					<div class="forForm">
						<span>
							Civilite : 
						</span>
						<div class="arrSelect">
							<select name="conjoinCivilite" id="">
								<option value="Monsieur">Monsieur</option>
								<option value="Madame">Madame</option>
							</select>
						</div>
					</div>
					<div class="forForm">
						<span>
							Nom : 
						</span>
						<input  type="text" name="conjoinName" id="conjoinName" value="" />
					</div>
					<div class="forForm">
						<span>
							Prenom : 
						</span>
						<input  type="text" name="conjoinFirstName" id="conjoinFirstName" value="" />
					</div>
				</div>
			</div>
			<div class="quiConjoinSeul">
				<div class="conjoinSeulNewInfo">
					<div class="forForm">
						<span>
							Civilite : 
						</span>
						<div class="arrSelect">
							<select name="conjoinSeulCivilite" id="">
								<option value="Monsieur">Monsieur</option>
								<option value="Madame">Madame</option>
							</select>
						</div>
					</div>
					<div class="forForm">
						<span>
							Nom : 
						</span>
						<input  type="text" name="conjoinSeulName" id="conjoinSeulName" value="" />
					</div>
					<div class="forForm">
						<span>
							Prenom : 
						</span>
						<input  type="text" name="conjoinSeulFirstName" id="conjoinSeulFirstName" value="" />
					</div>
				</div>
			</div>
			<div class="quiParent">
				<div class="parentNewInfo">
					<div class="forForm">
						<span>
							Civilite :
						</span>
						<div class="arrSelect">
							<select name="parentCivilite">
								<option value="Monsieur">Monsieur</option>
								<option value="Madame">Madame</option>
							</select>
						</div>
					</div>
					<div class="forForm">
						<span>
							Nom : 
						</span>
						<input type="text" name="parentName" id="parentName" value="" />
					</div>
					<div class="forForm">
						<span>
							Prenom : 
						</span>
						<input type="text" name="parentFirstName" id="parentFirstName" value="" />
					</div>
				</div>
			</div>
			<div class="quiEntreprise">
				<div class="entrepriseNewInfo">
					<div class="forForm">
						<span>
							Denomination Sociale :
						</span>
						<input type="text" name="entrepriseName" id="entrepriseName" value="" />
					</div>
				</div>
			</div>
		</div>
		<div class="btn-next btn-next-inactive">
			<div class="inactive">
				QUESTION SUIVANTE
				<img src="<?=$this->getPath()?>img/CP-Fleche-GrisFonce.svg" alt="" />
			</div>
		</div>
		<div class="btn-next btn-next-step-1" style="display:none;">
			<div class="active" >
				QUESTION SUIVANTE
				<img src="<?=$this->getPath()?>img/CP-Fleche-BleuClair.svg" alt="" />
			</div>
		</div>
	</div>

<?php
/////////////////////////////////////////////////
///////////////////////////////// Second block
/////////////////////////////////////////////////
?>

	<div class="_space_"></div>
	<div class="title" id="el_2" >
		<p>2. QUELS SONT VOS OBJECTIFS POUR CE PLACEMENT ?</p>
	</div>
	<div class="content_body mod_2">

		<div>
			<!-- Small modal -->
			<div class="modal fade modalPrevention" tabindex="-1" role="dialog" aria-labelledby="modalPrevention">
				<div class="modal-dialog modal-sm preventionCapital" role="document">
					<div class="modal-content">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><img style="height:21px;" src="<?=$this->getPath()?>img/BTN-Close-01.png" alt="" /></button>
						<h3>VOUS AVEZ SÉLECTIONNÉ « GARANTIR MON CAPITAL » PARMI VOS 3 PREMIERS OBJECTIFS.</h3>
						<p>Les SCPI n’offrent pas de garantie du capital investi et les performances passées ne préjugent en rien des performances à venir.</p>
						<div class="lstButton">
							<div id="btnNoContinue" data-dismiss="modal" class="btnCapital">Je modifie mes préférences</div>
							<div id="btnContinue" class="btnCapital">Oui, je souhaite poursuivre</div>
						</div>
					</div>
				</div>
			</div>

			<span style="margin-left:40px">Faites glissez vos préférences par ordre d'importance (Le plus haut étant le plus important)</span>
			<div class="blockSelection">
				<div>
					<ul>
						<li>
							<span>OBJECTIF N°1</span>
							<div class="blockSelectReceiver">
								Faites glisser dans la case
							</div>
						</li>
					</ul>
				</div>
				<div>
					<ul  onmousemove="$('.btn-next-step-2').css('display', 'flex');$('.btn-next-inactive').css('display', 'none');">
						<?php
							foreach (Projet::$_listObjectif as $key => $elm )
							{
								?>
									<li value="<?=$key?>"><span><?=$elm?></span></li>
								<?php
							}
						?>
					</ul>
				</div>
			</div>
		</div>
		<div class="blockValidation2">

			<div class="btn-next btn-next-inactive">
				<div class="inactive">
					QUESTION SUIVANTE
					<img src="<?=$this->getPath()?>img/CP-Fleche-GrisFonce.svg" alt="" />
				</div>
			</div>
			<div class="btn-next btn-next-step-2" style="display:none;">
				<div class="active" >
					QUESTION SUIVANTE
					<img src="<?=$this->getPath()?>img/CP-Fleche-BleuClair.svg" alt="" />
				</div>
			</div>
			<?php
			/*
			<div id="step2Validation">
				<div class="btn-next btn-next-step-2" style="display:inline-block;">
					<div >QUESTION SUIVANTE</div>
				</div>
			</div>
			*/
			?>
		</div>
	</div>

	<div class="_space_"></div>

	<div class="title" id="el_3">
		<p>3. QUEL MONTANT SOUHAITEZ-VOUS INVESTIR ?</p>
	</div>

	<div class="content_body form-horizontal mod_3">
		<div>
			<div class="radio">
				<label for="invest-1">
					<input class="inputSecondBlock" type="radio" name="invest" id="invest-1" value="1"><span></span>
					Moins de 25 000 €
				</label>
			</div>
			<div class="radio">
				<label for="invest-2">
					<input class="inputSecondBlock" type="radio" name="invest" id="invest-2" value="2"><span></span>
					Entre 25 000 € et 50 000 €
				</label>
			</div>
			<div class="radio">
				<label for="invest-3">
					<input class="inputSecondBlock" type="radio" name="invest" id="invest-3" value="3"><span></span>
						
					Entre 50 000 € et 100 000 €
				</label>
			</div>
			<div class="radio">
				<label for="invest-4">
					<input class="inputSecondBlock" type="radio" name="invest" id="invest-4" value="4"><span></span>
					Entre 100 000 € et 500 000 €
				</label>
			</div>
			<div class="radio">
				<label for="invest-5">
					<input class="inputSecondBlock" type="radio" name="invest" id="invest-5" value="5"><span></span>
					Superieur à 500 000 €
				</label>
			</div>
		</div>

		<div class="blockValidation3">

			<div class="btn-next btn-next-inactive">
				<div class="inactive">
					QUESTION SUIVANTE
					<img src="<?=$this->getPath()?>img/CP-Fleche-GrisFonce.svg" alt="" />
				</div>
			</div>
			<div class="btn-next btn-next-step-3" style="display:none;">
				<div class="active" >
					QUESTION SUIVANTE
					<img src="<?=$this->getPath()?>img/CP-Fleche-BleuClair.svg" alt="" />
				</div>
			</div>
			<?php
			/*
			<div id="step3Validation">
				<div class="btn-next btn-next-step-3" style="display:block;">
					<div >QUESTION SUIVANTE</div>
				</div>
			</div>
			*/
			?>
		</div>
	</div>



	<div class="_space_"></div>
	<div class="title" id="el_4">
		<p>4. SOUHAITEZ-VOUS RÉALISER VOTRE INVESTISSEMENT À CRÉDIT ?</p>
	</div>
	<div class="content_body form-horizontal mod_4">
		<div class="row" style="margin-bottom: 29px;">
			<div class="col-md-6" style="text-align: center;">
				<label class="radio-inline" for="yes">
					<input class="inputThirdBlock" type="radio" name="res" id="yes" value="1"><span></span>
					Oui
				</label> 
			</div>
			<div class="col-md-6" style="text-align: center;">
				<label class="radio-inline" for="no">
					<input class="inputThirdBlock" type="radio" name="res" id="no" value="0"><span></span>
					Non
				</label>
			</div>
		</div>

		<div class="blockValidation4">

			<div class="btn-next btn-next-inactive">
				<div class="inactive">
					QUESTION SUIVANTE
					<img src="<?=$this->getPath()?>img/CP-Fleche-GrisFonce.svg" alt="" />
				</div>
			</div>
			<div class="btn-next btn-next-step-4" style="display:none;">
				<div class="active" >
					QUESTION SUIVANTE
					<img src="<?=$this->getPath()?>img/CP-Fleche-BleuClair.svg" alt="" />
				</div>
			</div>
			<?php
			/*
			<div id="step4Validation">
				<div class="btn-next btn-next-step-4" style="display:block;">
					<div >QUESTION SUIVANTE</div>
				</div>
			</div>
			*/
			?>
		</div>
	</div>

	<div class="_space_"></div>
	<div class="title" id="el_5" style="display:none;">
		<p>5. SOUHAITEZ-VOUS ÊTRE ACCOMPAGNÉ POUR LE FINANCEMENT ?</p>
	</div>
	<div class="content_body form-horizontal mod_5">
		<div class="row" style="margin-bottom: 29px;">
			<div class="col-md-6" style="text-align: center;">
				<label class="radio-inline" for="yes_2">
					<input class="inputFourthBlock" type="radio" name="res_2" id="yes_2" value="1"><span></span>
					Oui
				</label> 
			</div>
			<div class="col-md-6" style="text-align: center;">
				<label class="radio-inline" for="no_2">
					<input class="inputFourthBlock" type="radio" name="res_2" id="no_2" value="0"><span></span>
					Non
				</label>
			</div>
		</div>
		<div class="blockValidation5">

			<div class="btn-next btn-next-inactive">
				<div class="inactive">
					QUESTION SUIVANTE
					<img src="<?=$this->getPath()?>img/CP-Fleche-GrisFonce.svg" alt="" />
				</div>
			</div>
			<div class="btn-next btn-next-step-5" style="display:none;">
				<div class="active" >
					QUESTION SUIVANTE
					<img src="<?=$this->getPath()?>img/CP-Fleche-BleuClair.svg" alt="" />
				</div>
			</div>
			<?php
			/*
			<div id="step5Validation">
				<div class="btn-next btn-next-step-5" style="display:block;">
					<div >QUESTION SUIVANTE</div>
				</div>
			</div>
			*/
			?>
		</div>
	</div>


	<?php
	///////////////////////////////// Nouvelle situation
	//if ($this->haveSituation)
	if (1)
	{
	?>
		<!-- Small modal -->
		<div class="modal fade modalhaveSituation" tabindex="-1" role="dialog" aria-labelledby="modalPrevention">
			<div class="modal-dialog modal-sm preventionCapital" role="document">
				<div class="modal-content">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><img style="height:21px;" src="<?=$this->getPath()?>img/BTN-Close-01.png" alt="" /></button>
					<h3>VOTRE SITUATION</h3>
					<p>votre situation a-t-elle changée ?</p>
					<div class="lstButton">
						<div id="haveNoChange" data-dismiss="modal" class="btnCapital">Non</div>
						<div id="haveChange" class="btnCapital">Oui</div>
					</div>
				</div>
			</div>
		</div>
	<?php
	}
	?>
	<input type="hidden" id="listObjectif" name="listObjectif" id="" value="" />
	<input type="hidden" name="token" id="token" value="<?php echo $_SESSION['csrf'][0]; ?>"/>
	<input type="hidden" name="action" id="" value="setNewProject" />
</form>
<button  id="sendBtn" class="tosend">VALIDER CETTE ETAPE</button>


