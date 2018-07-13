
<div class="modal fade modalPrevention" tabindex="-1" role="dialog" aria-labelledby="modalClickSeeProject" id="modalWelcomeProject">
	<div class="modal-dialog modal-sm preventionCapital">
		<div class="modal-content">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><img style="height:30px;" src="<?=$this->getPath()?>img/Close-Jaune.svg" alt="" /></button>
			<h3>Vous allez compléter votre projet d'investissement</h3>
			<p>
				Dans le cadre d'un investissement en parts de SCPI, l'AMF recommande la bonne connaissance de l'investisseur.
				<br />
				<br />
				À ce titre nous avons crée le module projet qui vous permettra de renseigner vos informations nécessaires pour une souscription en adéquation avec votre situation juridique, financière, fiscale et patrimoniale. <br />
				<br />
				<i class="fa fa-clock-o" aria-hidden="true"></i> 10 min'
			 </p>
			<div class="lstButton">
				<div  id="btnNoContinue" data-dismiss="modal" class="btnCapital">Je commence !</div>
			</div>
		</div>
	</div>
</div>

<?php
if (isset($_SESSION['click_see_project']) && $_SESSION['click_see_project'] === true)
{
	$_SESSION['click_see_project'] = false;
	?>
	<div class="modal fade modalPrevention" tabindex="-1" role="dialog" aria-labelledby="modalClickSeeProject" id="modalClickSeeProject">
		<div class="modal-dialog modal-sm preventionCapital">
			<div class="modal-content">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><img style="height:30px;" src="<?=$this->getPath()?>img/Close-Jaune.svg" alt="" /></button>
				<h3>Vous n'avez pas encore de projet</h3>
				<div class="lstButton">
					<div id="btnNoContinue" class="btnCapital" onclick="window.location = '?p=Portefeuille'">Retourner à mon portefeuille</div>
					<div  data-dismiss="modal" class="btnCapital">Je crée mon premier projet</div>
				</div>
			</div>
		</div>
	</div>
	<script type="text/javascript" charset="utf-8">
		$('#modalClickSeeProject').modal('show');
		$('#modalClickSeeProject').on('hidden.bs.modal', function() {
			$('#modalWelcomeProject').modal('show');
		});
	</script>
	<?php
}
else
{
	?>
	<script type="text/javascript" charset="utf-8">
		$('#modalWelcomeProject').modal('show');
	</script>
	<?php
}
?>




<h1>CRÉATION DE VOTRE PROJET</h1>
<div class="progressBlk">
	<?=$this->ProgressBlock?>
</div>
<form id="setProjectForm" method="post" action="?p=<?=$GLOBALS['GET']['p']?><?=(isset($GLOBALS['GET']['client']) ? "&client=" . intval($GLOBALS['GET']['client']) : "")?>">

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
					Moi seul (<?=$this->dh->getShortName()?>)
				</label>
				<img class="_tooltip_r" src="<?=$this->getPath()?>img/i_BleuClair.png" onmouseover="display_tooltip('Moi seul', 'Dans le cas d\'un investissement réalisé pour vous (Biens propres)', event)" onmouseout="disable_msg(event)" class="_tooltip" style="height: 22px !important;margin-left: 10px;">
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
									if ($elm->getIsChild())
										continue ;
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
				<img class="_tooltip_r" src="<?=$this->getPath()?>img/i_BleuClair.png" onmouseover="display_tooltip('Mon conjoint et moi-même', 'Dans le cadre d\'un investissement réalisé pour vous et votre conjoint (Biens communs)', event)" onmouseout="disable_msg(event)" class="_tooltip" style="height: 22px !important;margin-left: 10px;">
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
									if ($elm->getIsChild())
										continue ;
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
				<img class="_tooltip_r" src="<?=$this->getPath()?>img/i_BleuClair.png" onmouseover="display_tooltip('Mon conjoint', 'Dans le cadre d\'un investissement réalisé pour votre conjoint (Biens propres)', event)" onmouseout="disable_msg(event)" class="_tooltip" style="height: 22px !important;margin-left: 10px;">
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
									if ($elm->getIsChild())
										continue ;
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
				<img class="_tooltip_r" src="<?=$this->getPath()?>img/i_BleuClair.png" onmouseover="display_tooltip('Un de mes parents', 'Dans le cadre d\'un investissement réalisé pour un de vos parents (Biens propres)', event)" onmouseout="disable_msg(event)" class="_tooltip" style="height: 22px !important;margin-left: 10px;">
			</div>
			<div class="radio">
				<label for="forwhom-6">
					<input class="inputFirstBlock" type="radio" name="forwhom" id="forwhom-6" value="6"><span></span>
					Un de mes enfants
					<div class="quiEnfant">
						<div id="selectOther">
							Je souhaite investir pour :
							<select name="compteEnfant" id="compteEnfant">
								<?php
								foreach ($this->enfants as $key => $elm)
								{
									if (!$elm->getIsChild())
										continue ;
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
				<img class="_tooltip_r" src="<?=$this->getPath()?>img/i_BleuClair.png" onmouseover="display_tooltip('Un de mes enfants', 'Dans le cadre d\'un investissement réalisé pour un de vos enfants (Biens propres)', event)" onmouseout="disable_msg(event)" class="_tooltip" style="height: 22px !important;margin-left: 10px;">
			</div>
			<div class="radio">
				<label for="forwhom-4" style="color: #ccc;cursor: inherit;">
					<input class="inputFirstBlock" type="radio" name="forwhom" id="forwhom-4" value="4" disabled><span></span>
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
				<img class="_tooltip_r" src="<?=$this->getPath()?>img/i_BleuClair.png" onmouseover="display_tooltip('Une société dont je suis le gérant', 'En cours', event)" onmouseout="disable_msg(event)" class="_tooltip" style="height: 22px !important;margin-left: 10px;">
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
			<div class="quiEnfant">
				<div class="enfantNewInfo">
					<div class="forForm">
						<span>
							Civilite :
						</span>
						<div class="arrSelect">
							<select name="enfantCivilite">
								<option value="Monsieur">Monsieur</option>
								<option value="Madame">Madame</option>
							</select>
						</div>
					</div>
					<div class="forForm">
						<span>
							Nom :
						</span>
						<input type="text" name="enfantName" id="enfantName" value="" />
					</div>
					<div class="forForm">
						<span>
							Prenom :
						</span>
						<input type="text" name="enfantFirstName" id="enfantFirstName" value="" />
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
			<div class="modal fade modalPrevention" tabindex="-1" role="dialog" aria-labelledby="modalPrevention" id="modalPrevention">
				<div class="modal-dialog modal-sm preventionCapital" role="document">
					<div class="modal-content">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><img style="height:30px;" src="<?=$this->getPath()?>img/Close-Jaune.svg" alt="" /></button>
						<h3>VOUS AVEZ SÉLECTIONNÉ « GARANTIR MON CAPITAL » PARMI VOS 3 PREMIERS OBJECTIFS.</h3>
						<p>
							En SCPI, le capital n’est pas garanti et les performances passées ne préjugent en rien des performances futures.
						</p>
						<p>Pour poursuivre acceptez-vous une perte potentielle en capital ?</p>
						<div class="lstButton">
							<div id="btnNoContinue" data-dismiss="modal" class="btnCapital">Je modifie mes préférences</div>
							<div id="btnContinue" class="btnCapital" style="text-align: center;">Oui, j'accepte ce point</div>
						</div>
					</div>
				</div>
			</div>

			<span style="margin-left:37px">Faites glissez vos préférences par ordre d'importance (le plus haut étant le plus important)</span>
			<div class="btnReinitialize" onclick="dragModule.reinitialize()">
				<span>Réinitialiser la liste</span>
			</div>
			<div class="blockSelection">
				<div class="blockLeft">
					<div>
						<div position="0">
							<span class="blockDragReceiver">Glissez l'objectif 1</span>
						</div>
					</div>
					<div>
						<div position="1">
							<span class="blockDragReceiver">Glissez l'objectif 2</span>
						</div>
					</div>
					<div>
						<div position="2">
							<span class="blockDragReceiver">Glissez l'objectif 3</span>
						</div>
					</div>
				</div>
				<div class="blockCenter">
					<img style="width: 35%;" src="<?=$this->getPath()?>img/arrow.svg" alt="" />
				</div>
				<div class="blockRight">
					<?php
						foreach (Projet::$_listObjectif as $key => $elm )
						{
							?>
								<div value="<?=$key?>">
									<span draggable="true" id="blockDragable<?=$key?>" class="blockDraggable" >
											<?=$elm;?>
									</span>
								</div>
							<?php
						}
					?>
				</div>

			</div>
			<div class="Precision">
				Précisez : <input type="text" name="objectif_autre" id="autreText" value="" placeholder="Autre"/>
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
		</div>
	</div>



	<div class="_space_"></div>
	<div class="title" id="el_4">
		<p>4. SOUHAITEZ-VOUS RÉALISER VOTRE INVESTISSEMENT À CRÉDIT ?</p>
	</div>
	<div class="content_body form-horizontal mod_4">
		<div class="row" style="margin-bottom: 29px;">
			<div class="col-md-4" style="text-align: center;">
				<label class="radio-inline" for="yes">
					<input class="inputThirdBlock" type="radio" name="res" id="yes" value="1"><span></span>
					Oui (En totalite)
				</label> 
			</div>

			<div class="col-md-4" style="text-align: center;">
				<label class="radio-inline" for="yes2">
					<input class="inputThirdBlock" type="radio" name="res" id="yes2" value="2"><span></span>
					Oui (En partie)
				</label> 
			</div>
			<div class="col-md-4" style="text-align: center;">
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
		</div>
	</div>

	<div class="_space_"></div>
	<div class="title" id="el_5" style="display:none;">
		<p>4 BIS. SOUHAITEZ-VOUS ÊTRE ACCOMPAGNÉ(E) POUR LE FINANCEMENT ?</p>
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
		</div>
	</div>
	<div class="_space_"></div>
	<div class="title" id="el_6">
		<p>5. QUEL EST L’ORIGINE DES FONDS DE CE PROJET D’INVESTISSEMENT ?</p>
	</div>
	<div class="content_body form-horizontal mod_6">
		<div>
			<?php
			foreach (Projet::$_listOrigine as $key => $elm)
			{
				?>
				<div class="radio">
					<label for="origine-<?=$key?>">
						<input class="inputSixthBlock" type="checkbox" name="origine-<?=$key?>" id="origine-<?=$key?>" value="1"><span></span>
					<?=$elm?>
					</label>
				</div>
				<?php
			}
			?>
		</div>
		<div class="blockValidation6">

			<div class="btn-next btn-next-inactive">
				<div class="inactive">
					QUESTION SUIVANTE
					<img src="<?=$this->getPath()?>img/CP-Fleche-GrisFonce.svg" alt="" />
				</div>
			</div>
			<div class="btn-next btn-next-step-6" style="display:none;">
				<div class="active" >
					QUESTION SUIVANTE
					<img src="<?=$this->getPath()?>img/CP-Fleche-BleuClair.svg" alt="" />
				</div>
			</div>
		</div>
	</div>
	<input type="hidden" id="listObjectif" name="listObjectif" id="" value="" />
	<input type="hidden" name="token" id="token" value="<?php echo $_SESSION['csrf'][0]; ?>"/>
	<input type="hidden" name="action" id="" value="setNewProject" />
</form>
<button  id="sendBtn" class="tosend">VALIDER CETTE ETAPE</button>
