<div class="listBeneficiaire">
<?php
	foreach ($this->beneficiaires as $key => $elm) 
	{
		if (count($elm->getPersonnePhysique()) == 1)
		{
			$data = $elm->getPersonnePhysique()[0];
			if ($data->getCivilite() === "Monsieur")
				include("homme.php");
			else if ($data->getCivilite() === "Madame")
				include("femme.php");
		}
		else if (count($elm->getPersonnePhysique()) > 1)
		{
			$homme = false;
			$femme = false;
			foreach ($elm->getPersonnePhysique() as $key => $elm1)
			{
				if ($elm1->getCivilite() === "Monsieur")
					$homme = true;
				else if ($elm1->getCivilite() === "Madame")
					$femme = true;
			}
			if ($homme && $femme)
			{
				include("femme-homme.php");
			}
			else if ($homme)
			{
				include("homme-homme.php");
			}
			else if ($femme)
			{
				include("femme-femme.php");
			}
			// code pour un beneficiaire avec plusieur personnes.
		}
		else if (count($elm->getPersonneMorale()) == 1)
		{
			$data = $elm->getPersonneMorale()[0];
				include("entreprise.php");
		}
	}
	?>
	<div class="listBeneficiaireElmt1"> 
		<div  onclick="showBeneficiaireNewForm();" class="listBeneficiaireElmt2_dashed">
			<h2>NOUVEAU<br />BENEFICIAIRE</h2>
			<div>
				<img src="<?=$this->getPath()?>img/Plus-bleuclair-01.png" alt="" />
			</div>
		</div>
	</div>
	<?php
/*
	*/
	?>
</div>
