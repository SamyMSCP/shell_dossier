<div class="listBeneficiaireElmt1"> 
	<div onclick="showViewBeneficiaire(<?=$elm->id_benf?>);" class="listBeneficiaireElmt2">
		<h3><?=$data->getCiviliteFormat()?> <?=$data->getFirstName()?> <?=strtoupper($data->getName())?></h3>
		<div>
			<img src="<?=$this->getPath()?>img/Gender-blanc_Homme.png" alt="" />
		</div>
	</div>
</div>
