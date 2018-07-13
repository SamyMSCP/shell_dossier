<?=$this->Loading?>
<?=$this->Nav2?>
<?= $this->ToolTip?>
<?= $this->NotNow?>
<?php
if ($dh->getPersonnePhysique()->getPhone() == "-")
	echo $this->ForceSetPhone;
?>
<?=  $this->AdressePostaleComponent?>
<div class="containerPerso">
	<?= $this->MonCompte?>
	<div class="moduleBlock">
		<?=$this->Timeline?>
	</div>
	<div class="moduleBlock">
		<?=$this->Footer?>
	</div>
</div>
<?=$this->ModuleBarre?>
