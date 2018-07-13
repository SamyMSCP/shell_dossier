<h1>Module de gestion de Scpi</h1>

<modal-delai-jouissance></modal-delai-jouissance>
<table border="1" class="tableScpi">
	<thead>
		<tr>
			<th>Scpi Id</th>
			<th>Scpi Name</th>
			<th>Scpi Type</th>
			<th>Absorbed ?</th>
			<th>Prix vendeur</th>
			<th>T1</th>
			<th>T2</th>
			<th>T3</th>
			<th>T4</th>
			<th>Delai de jouissance</th>
			<th>Tof</th>
			<?php
			foreach (Scpi::$geo as $elm)
			{
				?>
				<th><?=$elm?></th>
				<?php
			}
			?>
			<th>Catégorie</th>
			<th>Capital</th>
			<th>Valeur de réalisation</th>
			<th>Valeur de reconstitution</th>
			<th>Valeur ISF</th>
			<th>Valeur IFI 01/01/2018</th>
			<th>Valeur IFI expatrié 01/01/2018</th>
			<th>AutoShow ?</th>
			<th>Show ?</th>
		</tr>
	</thead>
	<tbody>
		<?php
			foreach ($this->lstScpi as $key => $elm)
			{
				//dbg($elm);
				//exit();
				?>
				<tr<?=$elm->isShow() ? " class='isShow'" : ""?>>
					<td><?=$elm->id?></td>
					<td><?=$elm->name?></td>
					<td><?=$elm->getTypeStr()?></td>
					<td><?=$elm->isAbsorbedStr()?></td>
					<td><?=$elm->getPrixVendeur()?></td>
					<td><?=$elm->getAcompteThisYearByT(1)?></td>
					<td><?=$elm->getAcompteThisYearByT(2)?></td>
					<td><?=$elm->getAcompteThisYearByT(3)?></td>
					<td><?=$elm->getAcompteThisYearByT(4)?></td>
					<td><btn-edit-delai-jouissance scpi-id="<?=$elm->id?>" scpi-name="<?=$elm->name?>"></btn-edit-delai-jouissance></td>
					<td><?=$elm->getTof()?></td>
					<?php
						foreach (Scpi::$geo as $elm2)
						{
							?>
							<td>
								<?php
								if (isset($elm->$elm2))
								{
									?>
									<?=$elm->$elm2?>
									<?php
								}
								?>
							</td>
							<?php
						}
					?>
					<td><?=$elm->getCategoryStr()?></td>
					<td><?=$elm->getTypeCapital()?></td>
					<td><?=$elm->getValeurRealisation()?></td>
					<td><?=$elm->getValeurReconstitution()?></td>
					<td><?=$elm->getValeurIsf()?></td>
					<td><?=$elm->getValeurIfi2018()?></td>
					<td><?=$elm->getValeurIfiExpatrie2018()?></td>
					<td <?=($elm->autoShow() ? "style='background-color:#aac5d8;'" : "")?>><?=($elm->autoShow() ? "oui" : "non")?></td>
					<td>
						<form action="" method="post" accept-charset="utf-8" id="showListForm<?=$key?>">
							<select onchange="changeShowListSendForm(<?=$key?>);" name="showListForm" id="showList">
								<?php
								foreach(ScpiGestion::$_showListStr as $key1 => $elm1)
								{
									?>
									<option value="<?=$key1?>"<?= ($elm->checkShowList() == $key1 ) ? " selected" : ""?>><?=$elm1?></option>
									<?php
								}
								?>
							</select>
							<input type="hidden" name="token" id="token" value="<?php echo $_SESSION['csrf'][0]; ?>"/>
							<input type="hidden" name="changeShowList" id="" value="<?=$key?>" />
						</form>
					</td>
				</tr>
				<?php
			}
		?>
	</tbody>
</table>
