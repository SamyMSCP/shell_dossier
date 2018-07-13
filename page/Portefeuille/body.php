<?=$this->Loading?>
<?=$this->Nav2?>
<?= $this->NotNow?>
<?php
if ($dh->getPersonnePhysique()->getPhone() == "-")
	echo $this->ForceSetPhone;

?>
<div class="containerPerso">
	<?= $this->MonCompte?>
	<div class="moduleBlock">
		<?=$this->ApercuDeMonPorteFeuillev3?>
	</div>
	<?php
	if (count(Dh::getCurrent()->getTransaction()) !== 0) {
	?>
		<div class="moduleBlock">
			<?=$this->RendementDeMesScpiAcceuil?>
			<?=$this->RepartitionAcceuil?>
			<?=$this->RepartitionGeographique?>
		</div>
		<div class="moduleBlock">
			<?=$this->DernieresAcquisitions?>
			<?=$this->RepartitionParCategorie?>
			<div class="moduleVerticalAlign">
				<?=$this->TauxDOccupation?>
				<?=$this->RepartitionParType?>
			</div>
		</div>
	<?php
	}
	?>
	<div class="moduleBlock">
		<?=$this->Footer?>
	</div>
</div>
<?=$this->ModuleBarre?>
<?= $this->ToolTip?>
