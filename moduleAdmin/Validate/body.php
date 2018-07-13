<div class="validate">
	<?php
	if ($this->collaborateur->getType() != "prospecteur" && $this->collaborateur->getType() != "chefprojet")
	{
		?>
		<button data-toggle="modal" data-target="#modal_centreinteret" onclick="store.commit('INIT_CI')" class="btn-mscpi btn-not-check"><span>Centres d'intérêts</span></button>
		<?php
	}
	?>
	<button data-toggle="modal" data-target="#modal_envoiidentifiants"  class="btn-mscpi btn-not-check"><span>Envoi identifiants</span></button>
<!--	<button data-toggle="modal" data-target="#modal_envoiidentifiants"  class="btn-mscpi btn-not-check"><span>Envoi de mails</span></button>-->
	<?php
	if ($this->collaborateur->type != "prospecteur") {
		?>
		<?php
		if ($this->collaborateur->getType() != "prospecteur")
		{
			?>
			<div id="SetAdresseValideComponent">
				<set-adresse-valide-component></set-adresse-valide-component>
			</div>
			<?php
		}
		?>
		<div class="<?=($this->dh->mailOk()) ? "validateTrue" : "" ?>">
			Mail
			<img src="<?=$this->getPath()?>img/CP-Valide.svg" alt="" />
		</div>
		<div class="<?=($this->dh->phoneOk()) ? "validateTrue" : "" ?>">
			Téléphone
			<img src="<?=$this->getPath()?>img/CP-Valide.svg" alt="" />
		</div>
		<?php
		if ($this->collaborateur->type != "yoda" && $this->collaborateur->type != "backoffice" && $this->collaborateur->id_dh != $this->dh->conseiller)
		{
			?>
			<div class="<?=($this->dh->isf == true) ? "validateTrue" : "" ?>">
				I.F.I
				<img src="<?=$this->getPath()?>img/CP-Valide.svg" alt="" />
			</div>
			<?php
		}
		else
		{
			?>
			<div class="<?php 	if ($this->dh->isf === NULL) echo "unknow";
								else if ($this->dh->isf == true) echo "validateTrue" ?>">
				<form method="post" action="admin_lkje5sjwjpzkhdl42mscpi.php?p=EditionClient&client=<?= $GLOBALS['GET']['client'] ?>" id="form-isf">
					<input type="hidden" name="token" id="token" value="<?php echo $_SESSION['csrf'][0]; ?>"/>
					<input type="hidden" name="action_isf" value="1">
					<label for="isf">I.F.I</label>
					<input type="checkbox" name="isf" id="isf" data-toggle="toggle" data-class="fast" data-on="Oui" data-off="Non"  <?= ($this->dh->isf == true) ? 'checked' : '' ?>>
				</form>
			</div>
			<?php
		}
	}
	?>
	<div>
	</div>
	<?php
	if ($this->collaborateur->type != "prospecteur") {
		?>
		<div id="vueSetParrain">
			<set-parrain> </set-parrain>
		</div>
		<div class="validateTrue">
			Token
			<input type="text" disabled value="<?=getThisDomain()?>/?p=CreationCompte&utm=<?=$this->dh->getTokenAffiliation()?>" class="inputToken"/>
		</div>
		<?php
	}
	?>
</div>
<?php
if ($this->collaborateur->getType() != "prospecteur")
{
	?>
	<div id="vuCentreInteretApp">
		<centreinteretcomponent></centreinteretcomponent>
	</div>
	<?php
}
?>
<div class="modal fade modadel modal-mscpi" id="modal_envoiidentifiants" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><img src="<?= $this->getPath() ?>img/Close-Jaune.svg" alt="" /></button>
				<h4 class="modal-title text-center">ENVOI IDENTIFIANTS</h4>
				<div class="modal-trait"></div>
			</div>
			<div class="modal-body">
				<div class="row">
					<?php if (is_null($this->dh->password)): ?>
						<p class="text-center">Envoyer des identifiants temporaire ?</p>
					<?php else: ?>
						<p class="text-center">Réinitialiser le mot de passe et envoyer des identifiants temporaire ?</p>
					<?php endif; ?>
				</div>
			</div>
			<div class="modal-footer">
				<form method="post" action="admin_lkje5sjwjpzkhdl42mscpi.php?p=EditionClient&client=<?= $GLOBALS['GET']['client'] ?>" id="form-isf">
					<input type="hidden" name="token" id="token" value="<?php echo $_SESSION['csrf'][0]; ?>" />
					<input type="hidden" name="action" value="sendId" />
					<input type="hidden" name="id_client" value="<?= $GLOBALS['GET']['client'] ?>" />
					<button type="submit" class="btn-mscpi" id="envoiId">ENVOYER</button>
				</form>
			</div>
		</div>
	</div>
</div>
