<div class="DonneurDOrdreGauche">
	<h2>INFORMATIONS GENERALES</h2>
	<div class="traitDonneurDOrdreG"></div>
	<?php
	if ($this->dh->day) {
		?>
		<span class="CreeLe"><b>Compte créé le </b><?=date_fr(DateTime::createFromFormat("Y-m-d", $this->dh->day)->format("d F Y"))?><br>
			<b>A partir de: </b> <?= $this->dh->getWhereFrom() ?>
		</span>
		<?php
	} else {
	?>
		<span class="CreeLe"><b>Compte créé automatiquement</b></span>
	<?php
	}
	?>
	<ul class="lstInfosDh">
		<li>
			<div style="margin-top: 5px;">
				<img src="<?=$this->getPath()?>img/GPS-Pin-bleu.png" alt="Image Gps" />
			</div>
			<div>
				<?=$this->dh->getPersonnePhysique()->getAdresse()?>
			</div>
		</li>
		<li>
			<div>
				<img src="<?=$this->getPath()?>img/Phone-bleuclair.png" alt="Image Phone" />
			</div>
			<div style="margin-top: 7px;">
				<?=$this->dh->getPersonnePhysique()->getPhone()?>
			</div>
		</li>
		<li>
			<div>
				<img src="<?=$this->getPath()?>img/Email-bleuclair.png" alt="Image Envoi courrier" />
			</div>
			<div style="margin-top: 7px;">
				<?=$this->dh->getPersonnePhysique()->getMail()?>
			</div>
			<?php
			if ($this->canChangeMail)
			{
				?>
				<div class="delocker">
					<img src="<?=$this->getPath()?>img/Lock_closed.png" alt="" />
				</div>
				<?php
			}
			?>
		</li>
		<li><?php
			if (!$this->canChangeMail) { 
				if (!empty($this->dh->getNonSollicitationParMail())) { ?>
				N'est pas sollicité par l'envoi d'email :
				<?= $this->dh->getNonSollicitationParMail() ?>
			<?php } 
			} else { ?>
			<form action="?p=EditionClient&client=<?=$GLOBALS['GET']['client']?>" method="post" accept-charset="utf-8">
				<input type="hidden" name="token" id="token" value="<?=$_SESSION['csrf'][0]?>" />
			<input type="hidden" name="action" value="non_sollicitation_par_mail"/>
				<label for="">Ne pas solliciter par email :</label><img src="<?=$this->getPath()?>img/tooltip.ico" onmouseover="display_tooltip('Saisir une raison','- Compte de parainage<br />- Demande du client<br /> ...')" onmouseout="disable_msg(event)" style="position: relative;width: 20px;top: -5px;left: 5px"><br />
				<input type="text" name="non_sollicitation_par_mail" placeholder="pourquoi ?" value="<?= $this->dh->getNonSollicitationParMail() ?>" />
				<button	type="submit">OK</button>
			</form>
			<?php
			} ?>
		</li>
		<?php
		if ($this->canChangeMail)
		{
			?>
			<div class="btnChangeMail">
				<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalChangeMail">
					CHANGER L'ADRESSE MAIL
				</button>
			</div>
			<?php
		}
		?>
	</ul>
	<div class="Btn">
		<form action="?p=EditionClient&client=<?=$GLOBALS['GET']['client']?>" method="post" accept-charset="utf-8">
			<input type="hidden" name="token" id="token" value="<?=$_SESSION['csrf'][0]?>"/>
			<input type="hidden" name="action" value="toogleVip"/>
			<button
				type="submit"
				<?php
				if (!$this->dh->isVip())
				{
					?>
					class="notComplete"
					<?php
				}
				else
				{
					?>
					<?php
				}
				?>
			>
				VIP
			</button>
		</form>
	</div>

	<div class="Btn">
		<form action="?p=EditionClient&client=<?=$GLOBALS['GET']['client']?>" method="post" accept-charset="utf-8">
			<input type="hidden" name="token" id="token" value="<?=$_SESSION['csrf'][0]?>"/>
			<input type="hidden" name="action" value="toogleKo"/>
			<button
				type="submit"
				<?php
				if (!$this->dh->isKo())
				{
					?>
					class="notComplete"
					<?php
				}
				else
				{
					?>
					<?php
				}
				?>
			>
				KO
			</button>
		</form>
	</div>
	
</div>



<?php
if ($this->canChangeMail)
{
	?>
	<div class="modal fade modalChangeMail" id="modalChangeMail" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<form action="?p=<?=$GLOBALS['GET']['p']?><?= !empty($GLOBALS['GET']['client']) ? "&client=" . $GLOBALS['GET']['client'] : ""; ?><?= !empty($GLOBALS['GET']['onglet']) ? "&onglet=" . $GLOBALS['GET']['onglet'] : ""; ?>" method="post" accept-charset="utf-8" id="changeMailDh">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel">Changement d'adresse mail / Login</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
				<div class="modal-body">
					<div class="forInput">
						<span>Retapez l'ancienne adresse mail :</span>
						<input type="email" onpaste="return false;" name="oldMail" id="oldMail" value="" />
					</div>
					<div class="avertissementMessage2">
						<span >L'anciennene adresse mail ne correspond pas.</span>
					</div>
					<div class="forInput">
						<span>Nouvelle adresse mail :</span>
						<input type="email" onpaste="return false;" name="newMail" id="newMail" value="" />
					</div>
					<div class="avertissementMessage3">
						<span>Le nouveau adresse mail est mal formate.</span>
					</div>
					<div class="forInput">
						<span>Merci de retaper la nouvelle adresse ::</span>
						<input type="email" onpaste="return false;" name="newMailConfirmation" id="newMailConfirmation" value="" />
					</div>
					<div class="avertissementMessage1">
						<span >Les nouvelles adresses mails ne sont pas identique.</span>
					</div>
				 </div>
				 <div class="modal-footer">
					<input type="hidden" name="token" id="token" value="<?=$_SESSION['csrf'][0]?>"/>
					<input type="hidden" name="action" value="changeMailDh"/>
					<button type="button" class="btn-mscpi" data-dismiss="modal">Close</button>
					<button type="button" id="btnChangeMail" class="btn-mscpi btn-orange">Valider</button>
				 </div>
				</div>
			</form>
		</div>
	</div>
	<?php
}
?>


<div class="DonneurDOrdreDroite">
	<h2>DOCUMENTS</h2>
	<div class="traitDonneurDOrdreD"></div>
<div id="vueDhDocument">
	<div class="Btn" v-for="typeDocument in $store.state.dh.lstTypeDocument" >
		<document-btn id_entity="4" :link_entity="$store.getters.getSelectedDh.id" :type_document="4">
			{{ typeDocument.name }}
		</document-btn>
	</div>
</div>
	<?php
	/*
	foreach ($this->RequiredDocumentDh as $key => $elm)
	{
		?>
		<div class="Btn">
			<button onclick="showListeDeroulante({idClient:'<?=$this->dh->id_dh?>', idEntity:'<?=Entity::getByClassName("Dh")->id?>', linkEntity:'<?=$this->dh->id_dh?>', idTypeDocument:'<?=$elm->id?>'}, dataDh['<?=$elm->id?>']  , event);" type="submit" 
			<?php
			if (count($this->dh->getDocuments($elm->id)) === 0)
				echo "class='notComplete'";
			?>
			><?=$elm->getName()?></button>
		</div>
		<?php
	}
	*/
	foreach ($this->NeedValidationDh as $key => $elm)
	{
		?>
		<div class="Btn">
			<button
			onclick="$('.doc<?=$key?>').toggle();"
			<?php
			if (count($this->dh->getDocumentNotValidateFromTypeName($elm->getName())))
				echo "class='notComplete'";
			?>
			><?=$elm->getName()?>
			</button>
			<div class="viewDocumentValidationDh doc<?=$key?>">
				<ul>
					<?php
					foreach (Document::getFromNameType($elm->getName()) as $key2 => $elm2)
					{
						?>
							<li>
								<span class="
								<?php
									if ($elm2->checkDhValidate($this->dh->id_dh))
										echo "docValidate ";
									if ($elm2->isOnline())
										echo "docActual ";
								?>
								"><?php echo $elm2->filename;?></span>
							</li>
						<?php
					}
					?>
				</ul>
			</div>
		</div>
		<?php
	}
	?>
</div>
