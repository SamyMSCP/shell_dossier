<?=$this->Loading?>
<?=$this->Nav2?>
<?= $this->ToolTip?>
<?= $this->NotNow?>
<?php
if ($this->dh->getPersonnePhysique()->getPhone() == "-")
	echo $this->ForceSetPhone;
?>
<?=  $this->AdressePostaleComponent?>

<div class="containerPerso">
	<?= $this->MonCompte?>
	<div id='vueApp'>
		<?= $this->TableauPortefeuille?>
        <div v-if="this.$store.getters.getAllTransactions.length > 0">

			<graphiqueportefeuillerepartition></graphiqueportefeuillerepartition>

        </div>

        <!-- Avertissement -->
        <?= $this->AvertissementPortefeuilleV3 ?>
	</div>
</div>
<?= $this->FooterPortefeuilleV3 ?>

