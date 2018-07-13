<?=$this->Loading?>
<?=$this->Nav2?>
<?= $this->ToolTip?>
<?= $this->NotNow?>
<?php
if ($dh->getPersonnePhysique()->getPhone() == "-")
	echo $this->ForceSetPhone;

echo $this->AdressePostaleComponent;
?>

<div class="containerPerso">
	<?= $this->MonCompte?>
	<div class="moduleBlock">
	<?=$this->RendementDeMesScpiAcceuil?>
	<?=$this->RepartitionAcceuil?>
	<?=$this->DernieresActualites?>
	</div>
	<div class="moduleBlock">
		<?=$this->OpportuniteModule?>
		<?=$this->SuggestionModule?>
	</div>
	<div class="moduleBlock">
		<?=$this->Footer?>
	</div>
</div>
<?=$this->ModuleBarre?>
