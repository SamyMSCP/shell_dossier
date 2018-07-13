<style>
	.tableDividendes td{ 
		text-align:right;
	}
</style>
<h1>DIVIDENDES TRIMESTRIELS</h1>
<table class="s6 tableDividendes">
	<thead>
		<tr>
			<th style="width:34%;">SCPI</th>
			<th>1T <?=date("Y") - 1?></th>
			<th>2T <?=date("Y") - 1?></th>
			<th>3T <?=date("Y") - 1?></th>
			<th>4T <?=date("Y") - 1?></th>
		</tr>
	</thead>
	<tbody>
		<?php
		foreach ($data as $key => $elm)
		{
			if ($key == "precalcul")
				continue;
			?>
			<tr>
				<td style="width:34%;"><?=$elm['precalcul']['name']?></td>
				<td><?= (!empty($elm['precalcul']['lastDividendesTrimestre']['T1'])) ? number_format($elm['precalcul']['lastDividendesTrimestre']['T1'], 2, ",", " ") . " €" : "NR"?></td>
				<td><?= (!empty($elm['precalcul']['lastDividendesTrimestre']['T2'])) ? number_format($elm['precalcul']['lastDividendesTrimestre']['T2'], 2, ",", " ") . " €" : "NR"?></td>
				<td><?= (!empty($elm['precalcul']['lastDividendesTrimestre']['T3'])) ? number_format($elm['precalcul']['lastDividendesTrimestre']['T3'], 2, ",", " ") . " €" : "NR"?></td>
				<td><?= (!empty($elm['precalcul']['lastDividendesTrimestre']['T4'])) ? number_format($elm['precalcul']['lastDividendesTrimestre']['T4'], 2, ",", " ") . " €" : "NR"?></td>
			</tr>
			<?php
		}
		?>
		<tr style="color:#1781e0;background:#e9e9e9;">
			<td style="width:34%;">TOTAL</td>
			<td><?=(!empty($data['precalcul']['lastDividendesTrimestre']['T1'])) ? number_format($data['precalcul']['lastDividendesTrimestre']['T1'], 2, ",", " ") . " €" : "NR"?></td>
			<td><?=(!empty($data['precalcul']['lastDividendesTrimestre']['T2'])) ? number_format($data['precalcul']['lastDividendesTrimestre']['T2'], 2, ",", " ") . " €" : "NR"?></td>
			<td><?=(!empty($data['precalcul']['lastDividendesTrimestre']['T3'])) ? number_format($data['precalcul']['lastDividendesTrimestre']['T3'], 2, ",", " ") . " €" : "NR"?></td>
			<td><?=(!empty($data['precalcul']['lastDividendesTrimestre']['T4'])) ? number_format($data['precalcul']['lastDividendesTrimestre']['T4'], 2, ",", " ") . " €" : "NR"?></td>
		</tr>
	</tbody>
</table>
<p>
	Ce document ne remplace pas ceux transmis par la ou les société(s) de gestion. Il a pour but une lecture plus simple de ses dividendes. Les informations sont données à titre indicatives et ne sont pas contractuelles.<br />
	<br />
	À noter que les dividendes perçus peuvent être légèrement différents de ceux indiqués dans ce tableau. Par ailleurs, certaines sociétés de gestion indiquent un dividende brut de fiscalité (L'impôt étranger prélevé à la source est neutralisée lors de l’imposition en France).
</p>
<p>NR : Non renseigné</p>
