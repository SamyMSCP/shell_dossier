<?=$this->Loading?>
<?=$this->Nav2?>
<?= $this->NotNow?>
<?php
if ($dh->getPersonnePhysique()->getPhone() == "-")
	echo $this->ForceSetPhone;

echo $this->AdressePostaleComponent;
?>
<div class="containerPerso">
	<?= $this->MonCompte?>
	<div id="histo_transaction">
		<?php
		foreach ($this->id_modal as $id_modal):
		?>
			<historique-transaction nomscpi="<?= $id_modal['scpi'] ?>" typepro="<?= $id_modal['typepro'] ?>" idmodal="<?= $id_modal['name'] ?>"></historique-transaction>
		<?php
		endforeach;
		?>
		<transac-sell></transac-sell>
	</div>
	<div id="transac">
		<transaction></transaction>
	</div>
	<div class="moduleBlock">
		<?=$this->ApercuDeMonPorteFeuillev3_5?>
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
