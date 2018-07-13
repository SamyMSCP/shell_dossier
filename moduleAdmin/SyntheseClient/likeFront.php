<?php
if (count(Dh::getById($GLOBALS['GET']['client'])->getTransaction()) !== 0)
{
	?>
	<div class="containerPerso2">
		<div class="moduleBlock">
			<?=$this->RepartitionAcceuil?>
			<?=$this->RepartitionGeographique?>
			<?=$this->RepartitionParCategorie?>
		</div>
		<div class="moduleBlock">
			<?=$this->RendementDeMesScpiAcceuil?>
			<div class="moduleVerticalAlign">
				<?=$this->TauxDOccupation?>
				<?=$this->RepartitionParType?>
			</div>
		</div>
		<div class="moduleBlock">
			<?=$this->DernieresAcquisitions?>
			<?=$this->DernieresActualites?>
		</div>
		<div class="moduleBlock">
			<?= $this->ModuleAgeScpi ?>
		</div>
		<div class="moduleBlock">
			<?=$this->ModuleDividendesTrimestriels?>
		</div>
	</div>
	<?php
}
?>
