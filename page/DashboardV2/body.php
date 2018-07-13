<?=$this->Loading?>
<?= $this->Nav2 ?>
<?= $this->ToolTip ?>
<?= $this->NotNow ?>
<?php
if ($this->dh->getPersonnePhysique()->getPhone() == "-")
	echo $this->ForceSetPhone;

echo $this->AdressePostaleComponent;
?>

<div class="containerPerso">
	<?= $this->MonCompte ?>
	<div class="row band">
		<div class="col-lg-4 col-md-6 col-sm-12" style="padding-bottom: 15px;">
			<?= $this->ValorisationPF ?>
		</div>
		<div class="col-lg-4 col-md-6 col-lg-push-4 col-md-push-0 col-sm-push-0 col-xs-push-0 col-sm-12" style="padding-bottom: 15px;">
			<?= $this->DividendesAccueil ?>
		</div>
		<div class=" clearfix col-lg-4 col-md-12 col-lg-pull-4 col-md-pull-0 col-sm-push-0 col-xs-push-0" style="padding-bottom: 15px;">
			<?= $this->RepartitionAcceuil ?>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-12" style="padding-bottom: 15px;">
			<?= $this->ApercuDeMonPorteFeuilleAccueil; ?>
		</div>
	</div>
	<div class="row" id="third-band">
		<div class="col-lg-4 col-md-12" style="padding-bottom: 15px;">
			<?= $this->DernieresActualites ?>
		</div>
		<div class="col-lg-4 col-md-6 col-sm-12" style="padding-bottom: 15px;">
			<?= $this->OpportuniteASaisir ?>
		</div>
		<div class="col-lg-4 col-md-6 col-sm-12" style="padding-bottom: 15px;">
			<?= $this->MonthSuggest ?>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-12 c-footer">
			<?= $this->Footer ?>
		</div>
	</div>
</div>
<?= $this->ModuleBarre ?>
