<div style="text-align:center;">
	<div class="BtnSuivi">
		<button type="submit" data-toggle="modal" data-target="#suivi_crm2">AJOUTER UNE TACHE</button>
	</div>
</div>
<div class="suiviCLientTable">
	<table border="1" class="tableDh">
		<thead>
			<tr>
				<th style="cursor:pointer">Date</th>
				<th style="cursor:pointer">Type d'action</th>
				<th style="cursor:pointer">Action Effectuée</th>
				<th style="cursor:pointer">Date prochaine action</th>
				<th style="cursor:pointer">Type prochaine action</th>
				<th style="cursor:pointer">Action à effectuer</th>
				<th style="cursor:pointer">Commentaire</th>
			</tr>
		</thead>
		<tbody>
		<?php
		foreach ($this->crmclient as $elm) {
			?>
			<tr <?php
			if ($elm->finish){
				echo 'class="success"';
			}
			else{
				?>onclick="location.href='?p=EditionClient&client=<?=htmlspecialchars($elm->id_dh)?>&onglet=SUIVI&idcrm=<?=htmlspecialchars($elm->id)?>'" style="cursor: pointer;"
			<?php }
			?>>
				<td><?=$elm->getCrmDate()?></td>
				<td><?php echo '<img style="width: 25px;" src="' . $this->getPath() . ft_select_img($elm->getCrmRadio()) . '">';?></td>
				<td><?=$elm->getCrmAction()?></td>
				<td><?=$elm->getCrmDatef()?></td>
				<td><?php echo '<img style="width: 25px;" src="' . $this->getPath() . ft_select_img($elm->getCrmRadiof()) . '">';?></td>
				<td><?=$elm->getCrmActionf()?></td>
				<td><?=$elm->getCrmCommentaire()?></td>
			</tr>
		<?php
		}
		?>
		</tbody>
	</table>
</div>


<?php
include('modalCrm.php');
