<h1>Pages des logs clients</h1>
<div>
	<a href="?p=TelechargerRecapGuidePdf&doc=guide"><button class="btn-mscpi">Télécharger les consultation de guides</button></a>
	<a href="?p=TelechargerRecapGuidePdf&doc=pdf"><button class="btn-mscpi">Télécharger les consultation de pdf</button></a>
</div>
<div>
	Filtrer les logs :
	<select id="selectLog">
		<option></option>
		<?php
			foreach ($this->TypeLogger as $key=> $elm)
			{
				?>
				<option value="<?=$elm->id?>" <?php if (!empty($GLOBALS['GET']['idlog']) && $GLOBALS['GET']['idlog'] == $elm->id) echo ' checked' ?>>
					<?=$elm->name?>
				</option>
				<?php
				//dbg($elm);
			}
		?>
	</select>
	<?php
		//exit();
	?>
</div>
<table border="1" class="tableLogs">
	<thead>
		<tr>
			<th>Date</th>
			<th>Action</th>
			<th>Effectué par</th>
			<th>pour le compte de</th>
			<th>Details</th>
		</tr>
	</thead>
	<tbody>
		<?php
		foreach ($this->logger as $key => $elm)
		{
			?>
			<tr>
				<td><?=$elm->getDate()->format("d/m/Y H:i:s")?></td>
				<td><?=$elm->getType()?></td>
				<td><?=$elm->getExecutantName()?></td>
				<td><?=$elm->getClient()->getShortName()?>
				<td>
					<table border="0" class="tableDetail">
						<?php
						foreach($elm->getParams() as $key2 => $elm2)
						{
							?>
							<tr>
								<th><?=$key2?></th>
								<td><?=$elm2?></td>
							</tr>
							<?php
						}
						?>
					</table>
				</td>
			</tr>
			<?php
		}
		?>
	</tbody>
</table>
<?php
/*
<table border="1" class="tableLogs">
	<thead>
		<tr>
			<th>Donneur d'ordre</th>
			<th>Date</th>
			<th>Heure</th>
			<th>Ip</th>
			<th>Post</th>
			<th>Activite</th>
		</tr>
	</thead>
	<tbody>
		<?php
		foreach ($this->logs as $elm)
		{
			?>
			<tr>
				<td><?=$elm->getDh()->getPersonnePhysique()->getShortName()?></th>
				<td><?=$elm->getDateTime()->format("d/m/Y")?></td>
				<td><?=$elm->getDateTime()->format("H:i:s")?></td>
				<td><?=$elm->getIp()?></td>
				<td><?=$elm->getPost()?></td>
				<td><?=$elm->getActivite()?></td>
			</tr>
			<?php
		}
		?>
	</tbody>
</table>
*/
?>
