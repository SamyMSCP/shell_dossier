<ul>
	<?php
	foreach ($this->dh->getBeneficiaires() as $keyBen => $elmBen)
	{
		?>
		<li class="BtnTransactionBeneficiaire BtnTransactionBeneficiaire_<?=$elmBen->id_benf?>" onclick="showTableData(<?=$elmBen->id_benf?>)">
			<img src="<?=$this->getPath()?>img/<?=$elmBen->getImgName()?>" alt="" />
			<div>
				<?=$elmBen->getShortName()?>
			</div>
		</li>
		<?php
	}
	?>
	<li  class="BtnTransactionBeneficiaire BtnTransactionBeneficiaire_0 BtnTransactionBeneficiaireSelected" onclick="showTableData(0)">TOTAL</li>
</ul>
