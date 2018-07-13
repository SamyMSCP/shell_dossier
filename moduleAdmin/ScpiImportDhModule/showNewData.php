<table border='1' class="tableOldData">
	<tr>
		<?php
			foreach(ParseCsvTransaction::getTransactionCheck() as $k => $elm2){
				echo "<th>", $elm2, "</th>";
				$entete[$k] = $elm2;
			}
		?>
	</tr>
	<?php
	$len = count($this->newData);
	$i = 0;
	while ($len > $i)
	{
		echo "<tr>";
		foreach ($entete as $k) {
	?>
			<td><?=$this->newData[$i][$k]?></td>
		<?php
		}
		$i += 1;
		echo "</tr>";
	}
	?>
</table>
<div class="centerIt">
	<a href="?p=<?=$GLOBALS['GET']['p']?>">Retour</a>
</div>
