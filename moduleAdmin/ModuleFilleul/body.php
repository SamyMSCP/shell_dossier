<table border="0" class="tableFilleul">
	<thead>
		<th>id</th>
		<th>Contact</th>
	</thead>
	<tbody>
		<?php
		foreach ($this->filleul as $key => $elm)
		{
			?>
			<tr>
				<td>
					<a href="?p=EditionClient&client=<?=$elm->id_dh?>" target="_blank">
						<?=$elm->id_dh?>
					</a>
				</td>
				<td>
					<a href="?p=EditionClient&client=<?=$elm->id_dh?>" target="_blank">
						<?=$elm->getShortName()?>
					</a>
				</td>
			</tr>
			<?php
		}
		?>
	</tbody>
</table>
