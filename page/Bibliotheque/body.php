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
	<?= $this->ModuleBibliotheque?>
</div>
<?=$this->ModuleBarre?>
<div id="appBibliotheque">
	<msg-box></msg-box>
</div>
