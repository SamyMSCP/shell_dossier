<?php
$avis_p = count(Avis::$_lstPriorite);
for ($i = 0; $i < $avis_p; $i++)
{
	?>
	<h2><?=Avis::$_lstPriorite[$i]?></h2>
	<table border="1" class="tableAvis">
		<thead>
			<tr>
				<th>Date Ajout</th>
				<th>Civilite</th>
				<th>Prenom</th>
				<th>Nom</th>
				<th>Mail</th>
				<th>Avis</th>
				<th>Priorite</th>
				<th>Status</th>
				<th>Action</th>
			</tr>
		</thead>
		<tbody>
			<?php
			$avis_s = count(Avis::$_status);
			for ($j = 0; $j < $avis_s; $j++)
			{
				foreach ($this->allAvis as $key => $elm)
				{
					if ($elm->getPriorite() != $i || $elm->getStatus()!= $j)
						continue;
					?>
					<form action="?p=<?=$GLOBALS['GET']['p']?>" method="post" accept-charset="utf-8">
						<tr class="AvisColor<?=$elm->getStatus()?>">
							<td>
							<?php
								if (empty($elm->getDateAjout()))
								{
									echo '<input type="date" name="date" id="" />';
								}
								else
								{
									echo $elm->getDateAjout()->format("d/m/Y");
								}
							?>
							</td>
							<td><?=$elm->pp->getCiviliteFormat()?></td>
							<td><?=$elm->pp->getFirstName()?></td>
							<td><?=$elm->pp->getName()?></td>
							<td><?=$elm->pp->getMail()?></td>
							<td><?=$elm->getAvis()?></td>

							<td>
								<select name="prio" id="prio">
									<?php
										foreach (Avis::$_lstPriorite as $key2 => $elm2)
										{
											?>
												<option value="<?=$key2?>" <?=($elm->priorite == $key2) ? "selected" : ""?>><?=$elm2?></option>
											<?php
										}
									?>
								</select>
							</td>
							<td>
								<select name="status" id="status">
									<?php
										foreach (Avis::$_status as $key2 => $elm2)
										{
											?>
												<option value="<?=$key2?>" <?=($elm->status == $key2) ? "selected" : ""?>><?=$elm2?></option>
											<?php
										}
									?>
								</select>
							</td>
							<td>
								<input type="hidden" name="id_avis" id="id_avis" value="<?=$elm->id?>" />
								<input type="hidden" name="token" id="token" value="<?php echo $_SESSION['csrf'][0]; ?>"/>
								<input type="submit" name="action" id="" value="Enregistrer" />
							</td>
						</tr>
					</form>
					<?php
				}
			}
			?>
		</tbody>
	</table>
<?php
}
?>
