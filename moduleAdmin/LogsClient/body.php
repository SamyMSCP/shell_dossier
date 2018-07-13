<h1>Module Logs clients</h1>
<table border="1" class="tableLogs">
	<thead>
		<tr>
			<th>Date</th>
			<th>Action</th>
			<th>Effectué par</th>
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
				<td>
					<table border="0" class="tableDetail">
						<?php
						if (empty($elm->getParams()))
						{
							?><tr><td><i>Pas de description</i></td></tr><?php
						}
						else
						{
							foreach($elm->getParams() as $key2 => $elm2)
							{
								?>
								<tr>
									<th><?=$key2?></th>
									<td><?=$elm2?></td>
								</tr>
								<?php
							}
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

<h1>Old logs</h1>
<table border="1" class="tableLogs">
	<thead>
		<tr>
			<th>Date</th>
			<th>Heure</th>
			<th>Ip</th>
			<th>Post</th>
			<th>Activite</th>
		</tr>
	</thead>
	<tbody>
		<?php
		foreach ($this->logs as $key => $elm)
		{
			?>
			<tr>
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
