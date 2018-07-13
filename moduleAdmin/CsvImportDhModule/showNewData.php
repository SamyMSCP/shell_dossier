
<table border='1' class="tableOldData">
	<tr>
		<th>Action</th>
		<th>Civilite</th>
		<th>Prenom</th>
		<th>Nom</th>
		<th>login</th>
		<th>Mot de passe</th>
		<th>Type</th>
	</tr>
	<?php
	foreach ($this->newData as $key => $elm) {
	?>
		<tr>
			<td><?=$elm['action']?></td>
			<td><?=$elm['civilite']?></td>
			<td><?=$elm['prenom']?></td>
			<td><?=$elm['nom']?></td>
			<td><?=$elm['login']?></td>
			<td><?=$elm['mdp']?></td>
			<td><?=$elm['type']?></td>
		</tr>
		<?php
	}
	?>
</table>
<div class="centerIt">
	<a href="?p=<?=$GLOBALS['GET']['p']?>">Retour</a>
</div>


