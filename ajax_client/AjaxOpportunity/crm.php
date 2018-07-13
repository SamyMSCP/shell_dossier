<table class="tableOpportuniteCrm">
	<tbody>
		<tr>
			<th>id</th>
			<td><?=$op->id?></td>
		</tr>
		<tr>
			<th>SCPI</th>
			<td> <?=$scpi->name?> </td>
		</tr>
		<tr>
			<th>Type propriété</th>
			<td> <?=($op->type == 1) ? "Nue propriété" : "Usufruit"?> </td>
		</tr>
		<tr>
			<th>Démembrement</th>
			<td><?=($op->time_demembrement)?> ans</td>
		</tr>
		<tr>
			<th>Prix par parts</th>
			<td><?=number_format($op->price_per_part * $key, 2, ",", " ")?> €</td>
		</tr>
		<tr>
			<th>Nombre de parts</th>
			<td><?=intval($op->nb_part)?></td>
		</tr>
		<tr>
			<th>Clé de répartition</th>
			<td> <?=$key * 100 ?> %</td>
		</tr>
		<tr>
			<th>Volume d'investissement</th>
			<td><?=number_format($op->price_per_part * $key * intval($op->nb_part), 2, ",", " ")?> €</td>
		</tr>
		<tr>
			<th>Souscription partielle ?</th>
			<td><?= ($op->partial_subscrib) ? "oui" : "non"?></td>
		</tr>
		<tr>
			<th>Auteur</th>
			<td> <a href="?p=EditionClient&client=<?=Dh::getById($op->id_author)->id_dh?>"><?= Dh::getById($op->id_author)->getShortName()?></a> </td>
		</tr>
	</tbody>
</table>
<style type="text/css" media="all">
	.tableOpportuniteCrm { width:600px !important; margin: 20px auto;}
	.tableOpportuniteCrm th { text-align:right; padding-right: 10px; width: 50%;}
	.tableOpportuniteCrm td { text-align:left; padding-left: 10px;  width: 50%;}
</style>
