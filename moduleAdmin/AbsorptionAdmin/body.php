<table class="tableAbsorption" border="1">
	<thead>
		<tr>
			<th>Scpi Absorbee</th>
			<th>Scpi Parent</th>
			<th>Date d'absorption</th>
			<th>Parts avant absorption</th>
			<th>Parts apres absorption</th>
			<th>Activees</th>
			<th>Action</th>
		</tr>
	</thead>
	<tbody>
		<?php
		foreach ($this->absorptionList as $key => $elm)
		{
			?>
			<form action="?p=<?=$GLOBALS['GET']['p']?>" method="post" accept-charset="utf-8">
				<tr>
					<td><?=Scpi::getFromId($elm->id_scpi_absorbed)->name?></td>
					<td><?=Scpi::getFromId($elm->id_scpi_parent)->name?></td>
					<td><?=$elm->getDateAbsorption()->format('d/m/Y H:i:s')?></td>
					<td><input type="number" min="1" name="before" id="" value="<?=$elm->getBeforeNbrPart()?>" /></td>
					<td><input type="number" min="1" name="after" id="" value="<?=$elm->getAfterNbrPart()?>" /></td>
					<td><input type="checkbox" name="isActivate" id="" <?php echo  ($elm->isActivate()) ? "checked disabled" : ""; ?> /></td>
					<td>
						<input type="hidden" name="idAbsorption" id="" value="<?=$elm->id?>" />
						<input type="hidden" name="token" id="token" value="<?php echo $_SESSION['csrf'][0]; ?>"/>
						<input type="submit" name="SaveAbsorption" id="" value="Enregistrer" />
					</td>
				</tr>
			</form>
			<?php
		}
		?>
	</tbody>
</table>
