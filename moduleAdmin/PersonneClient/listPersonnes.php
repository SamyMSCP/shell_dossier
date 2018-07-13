<div class="personnesClientTable listePersonnes">
	<h3>Personnes physiques</h3>
	<?php
	foreach ($this->Pp as $key => $elm) {
		?>
			<div class="personneElement1"> 
				<div onclick="showPersonnePhysiqueUpdateForm(<?=$elm->id_phs?>);" class="personneElement2">
					<h3>
						<?=$elm->getCiviliteFormat()?>
						<?=$elm->getFirstName()?>
						<?=$elm->getName()?>
					</h3>
					<div>
						<img src="<?=$this->getPath()?>img/<?php
						if ($elm->getCiviliteFormat() == "M.")
							echo "Gender-blanc_Homme.png";
						else
							echo "Gender-blanc_Femme.png";
						?>" alt="" />
					</div>
				</div>
			</div>
		<?php
	}
	?>
	<div class="personneElement1"> 
		<div class="personneElement2_dashed" onclick="showPersonnePhysiqueNewForm();" >
			<h2>NOUVELLE<br />PERSONNE PHYSIQUE</h2>
			<div>
				<img src="<?=$this->getPath()?>img/Plus-bleuclair-01.png" alt="" />
			</div>
		</div>
	</div>
</div>
<div class="personnesClientTable listePersonnes">
	<h3>Personnes morales</h3>
	<?php
	foreach ($this->Pm as $key => $elm) {
		?>
			<div class="personneElement1"> 
				<div onclick="showPersonneMoraleUpdateForm(<?=$elm->id_pm?>);" class="personneElement2">
					<h3>
						<?=$elm->getDenominationSociale()?>
					</h3>
					<div>
						<img src="<?=$this->getPath()?>img/Gender-blanc_Homme.png" alt="" />
					</div>
				</div>
			</div>
		<?php
	}
	?>
	<div class="personneElement1"> 
		<div class="personneElement2_dashed" onclick="showPersonneMoraleNewForm();"  >
			<h2>NOUVELLE<br />PERSONNE MORALE</h2>
			<div>
				<img src="<?=$this->getPath()?>img/Plus-bleuclair-01.png" alt="" />
			</div>
		</div>
	</div>
</div>

