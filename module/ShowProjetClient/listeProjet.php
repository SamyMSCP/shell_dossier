<h1>Tableau des projets</h1>
<table border="1">
	<thead>
		<tr>
			<th>Nom Projet</th>
			<th>Beneficiaire</th>
			<th>Etat Projet</th>
			<th>Objectifs</th>
		</tr>
	</thead>
	<tbody>
<?php
foreach ($this->projects as $key => $elm)
{
	?>
		<tr>
			<td><?=$elm->getName()?></td>
			<td>
				<?php
					foreach ($elm->getBeneficiairesEntity()->getPersonnePhysique() as $key2 => $elm2)
					{
						if ($key2 != 0)
							echo "<br />";
						?>
						<?=$elm2->getCiviliteFormat()?> <?=$elm2->getFirstName()?> <?=$elm2->getName()?>
						<?php
					}
				?>
			</td>
			<td><?=$elm->getEtatProjet()?></td>
		</tr>
	<?php
}
?>
	</tbody>
</table>
