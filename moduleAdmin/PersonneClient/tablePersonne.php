<div class="personnesClientTable">
	<h3>Personnes physique <img onclick="showPersonnePhysiqueNewForm();" src="<?=$this->getPath()?>img/Plus-bleuclair-01.png" alt="" /></h3>
	<table border="1" class="tablePersonnePhysique">
		<thead>
			<tr>
				<th style="cursor:pointer">Civilite</th>
				<th style="cursor:pointer">Prenom</th>
				<th style="cursor:pointer">Nom</th>
				<th style="cursor:pointer">Telephone</th>
				<th style="cursor:pointer">Mail</th>
			</tr>
		</thead>
		<tbody>
		<?php
		foreach ($this->Pp as $key => $elm) {
			?>
			<tr onclick="showPersonnePhysiqueUpdateForm(<?=$elm->id_phs?>);">
				<td><?=$elm->getCiviliteFormat()?></td>
				<td><?=$elm->getFirstName()?></td>
				<td><?=$elm->getName()?></td>
				<td><?=$elm->getPhone()?></td>
				<td><?=$elm->getMail()?></td>
			</tr>
		<?php
		}
		?>
		</tbody>
	</table>
	<br />
	<h3>Personnes morale <img onclick="showPersonneMoraleNewForm();" src="<?=$this->getPath()?>img/Plus-bleuclair-01.png" alt=""/></h3>
	<table border="1" class="tablePersonnePhysique">
		<thead>
			<tr>
				<th style="cursor:pointer">Denomination sociale</th>
				<th style="cursor:pointer">Forme Juridique</th>
				<th style="cursor:pointer">Siret</th>
			</tr>
		</thead>
		<tbody>
		<?php
		foreach ($this->Pm as $key => $elm) {
			?>
			<tr onclick="showPersonneMoraleUpdateForm(<?=$elm->id_pm?>);">
				<td><?=$elm->getDenominationSociale()?></td>
				<td><?=$elm->getFormeJuridique()?></td>
				<td><?=$elm->getSiret()?></td>
			</tr>
			<?php
		}
		?>
		</tbody>
	</table>
</div>
