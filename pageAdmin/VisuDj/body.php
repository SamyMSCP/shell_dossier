<?=$this->Nav?>
<div class="containerPerso vueApp">
	<div class="row">
		<h1 >Visualiser les délais de jouissance</h1>
		<div class="trait"></div>
<modal-delai-jouissance></modal-delai-jouissance>
		<table class="table tableDj table-bordered table-striped">
			<thead>
				<th>edit</th>
				<th>Id</th>
				<th>SCPI</th>
				<th>Date d'éxécution</th>
				<th>Durée</th>
			</thead>
			<tbody>
				<?php
	$dt = new DateTime();
	foreach ($this->scpi as $s)
	{
		$dj = DelaiJouissance::getAllForScpi($s->id);

		if (empty($dj))
		{
			echo "<tbody><tr class='warning'><td><btn-edit-delai-jouissance scpi-id='",$s->id,"' scpi-name=\"",$s->getName(),"\"></btn-edit-delai-jouissance></td><td>",$s->id,"</td><td><strong>", $s->getName(),"</strong></td></td><td>&nbsp;</td><td>&nbsp;</td></tr></tbody>";
		}
		else
		{
			if (($nb = count($dj)) > 0)
			{
				$nb*=2;
				$rowspan = "rowspan='$nb'";
			}
			else
				$rowspan = '';
			echo "<tbody><tr><td $rowspan><btn-edit-delai-jouissance scpi-id='",$s->id,"' scpi-name=\"",$s->getName(),"\"></btn-edit-delai-jouissance></td><td $rowspan>", $s->id,"</td><td $rowspan><strong>", $s->getName(),"</strong></td>";
			foreach ($dj as $elm)
			{
				$dt->setTimestamp($elm->date_execution);
				
				echo "<td rowspan='2'>", $dt->format('d/m/Y'),"</td>";
				echo "<td>Achat : ", $elm->getValueEntreJouissanceStr(),"</td></tr>";
				echo "<tr><td>Vente : ", $elm->getValueSortieJouissanceStr(),"</td></tr>";
			}
			echo '</tbody>';
		}
	}
				?>
			</tbody>
		</table>
	</div>
</div>
