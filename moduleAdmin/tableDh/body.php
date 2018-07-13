<table border="1" class="tableDh">
	<thead>
		<tr>
			<th id="sortscpi" style="cursor:alias">Client</th>
			<th style="cursor:alias">Type</th>
			<th style="cursor:alias">Dernier contact</th>
			<th style="cursor:alias">Prochain contact</th>
			<th style="cursor:alias">Action à réaliser</th>
			<th style="cursor:alias">Valeur du portefeuille</th>
			<th style="cursor:alias">Dernière souscription</th>
		</tr>
	</thead>
	<tbody>
		<?php
			foreach ($this->client as $key => $elm) {
				$Pp = $elm->getPersonnePhysique();
		?>
		<tr onclick="location.href='?p=EditionClient&client=<?=htmlspecialchars($elm->id_dh)?>'">
			<td><?=$Pp->getCiviliteFormat()?> <?=$Pp->getFirstName()?> <?=$Pp->getName()?></td>
			<td><?=$elm->getClientType()?></td>
            <?php
				$crm = $elm->getCrm();
				if ($crm) {
				?>
					<td><?=$crm[0]->getCrmDate()?></td>
					<td><img style="width: 25px;" src="<?=$this->getPath() . ft_select_img($crm[0]->getCrmRadiof())?>"></td>
					<td><?=$crm[0]->getCrmDatef()?></td>
				<?php
				} else {
				?>
					<td>Inconnue</td>
					<td>Inconnue</td>
					<td>Rien</td>
				<?php
				}
				?>
			<td> <?=number_format($elm->getCacheArrayTable()["precalcul"]["ventePotentielle"], 2, ',', ' ')?> €</td>
            <td><button type="button" class="btn btn-info" href="info.php?client=<?=htmlspecialchars($elm->id_dh)?>">Info</button></td>
		</tr>
		<?php
		}
		?>
		
	</tbody>
	
</table>
<script type="text/javascript">
	$(document).ready(function() 
	{ 
		$(".tableDh").tablesorter(); 
		$("#sortscpi").click();
	})
    </script>

