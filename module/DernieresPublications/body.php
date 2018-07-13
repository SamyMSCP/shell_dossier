<table class="table">
	<thead style="background-color: #01528A;">
	 <tr>
		 <th style="font-size: 20px; font-weight: normal; text-align: center;">Publications de vos SCPI</th>
	 </tr>
	</thead>
	<tbody id="tbl_DerP">
<?php
	foreach ($this->dh->getPublication() as $value) {
		echo '<tr><td>';
		echo "<h4>" . htmlspecialchars($value->title) . "</h4>";
		echo htmlspecialchars(date("d/m/Y", strtotime($value->date_published))) . "<br>";
		?>
		<div style="text-align: center;">
		<?php
		echo '<a target="_blank" href="https://www.meilleurescpi.com' .  $value->path . '"><img src="'  .  $this->getPath() .   'img/pdf.png" style="width: 60px;">Afficher la publication</a></div></td></tr>';
	}
?>
	</tbody>
</table>
