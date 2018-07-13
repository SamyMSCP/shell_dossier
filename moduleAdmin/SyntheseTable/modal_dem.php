<div <?php echo 'class="modal fade modal_dem_' . $tab[$i]['id'] . '"'; ?> tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
   <div class="modal-dialog modal-std">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" style="text-align: center;">MeilleureSCPI.com</h4>
			</div>
			<div class="modal-body">
			 <form <?php echo 'action="projet_en_cours.php?client=' . $id . '"'; ?> method="post" enctype="multipart/form-data">
				<table class="table text-center" id="table">
				<thead style="background-color: #01528A; border: 2px solid;">
					<tr>
						<th>Numéro</th>
						<th>Date de création</th>
						<th>signé</th>
						<th>Type de document</th>
						<th>Lien</th>
					</tr>
				</thead>
			<tbody>
				<?php $doc = get_doc_by_id($tab[$i]['lien_dem']);
				$tlen = count($doc);
				for ($c=0; $c < $tlen; $c++){
					?><tr>
						<td><?php echo ($c + 1); ?></td>
						<td><?php echo date_fr(strftime("%A %d %B %Y", $doc[$c]['date_c'])); ?></td>
						<td><?php if ($doc[$c]['signe'])
									echo '<img src="<?=$this->getPath()?>img/success.ico" style="width: 26px;">';
								else
									echo '<img src="<?=$this->getPath()?>img/wait.ico" style="width: 26px;">'; ?></td>
						<td><?php echo $doc[$c]['type'] ?></td>
						<td><a <?php echo 'target="_blank" href="http://' . $_SERVER['HTTP_HOST'] . '/function/viewdoc.php?id=' . $doc[$c]['id'] . '&doc=' . $doc[$c]['id_doc'] . '&nature=' . $doc[$c]['nature_doc'] . '&date=' . $doc[$c]['date_c'] . '&token=' . $_COOKIE['token'] . '"'?>><img src="<?=$this->getPath()?>img/view.ico" style="width: 26px;"></a></td>
					</tr>
				   <?php 
				}
				?>
				</tbody>
			</table>
			<div style="background-color : #C0C0C0; text-align: center;"><h2>Envoyer un document</h2></div>
						<div class="row">
							<div class="col-lg-2">
								<img <?php echo 'onclick="$(\'.modal_dem_' . $tab[$i]['id'] . '\').modal(\'show\')"'; ?> src="<?=$this->getPath()?>img/dem.svg" style="cursor:pointer; width: 100px;">
							</div>
							<div class="col-lg-3">
								<h2>Convention démembrement<h2>
							</div>
							<div class="col-lg-3">
								<input style="margin-top: 33px;" type="file" accept=".pdf" <?php echo $val = 'name="dem_' .  $tab[$i]['id'] . '"'; ?> >
							</div>
							<div class="col-lg-offset-3">

							</div>
							<div class="col-lg-2" style="margin-left: 150px; text-align: right;">
								<input type="checkbox" style="margin-top: 32px;" <?php echo $val; ?> value="1"> Signé<br>
							</div>
						</div>
			</div>
			<div class="modal-footer">
				<button type="submit" name="submit" class="btn btn-primary">Envoi des documents</button>
				</form>
				<button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
			</div>
		</div>
	</div>
</div>
