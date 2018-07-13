<div class="listBeneficiaireElmt1"> 
	<div onclick="showViewBeneficiaire(<?=$elm->id_benf?>);" class="listBeneficiaireElmt2">
		<ul class="listPpBen">
			<?php
			foreach ($elm->getPersonnePhysique() as $key => $elm1)
			{
				?>
				<li><?=$elm1->getCiviliteFormat()?> <?=$elm1->getFirstName()?> <?=strtoupper($elm1->getName())?></li>
				<?php
			}
			?>
		</ul>
		<div>
			<img src="<?=$this->getPath()?>img/Gender-blanc_H-H.png" alt="" />
		</div>
	</div>
</div>
