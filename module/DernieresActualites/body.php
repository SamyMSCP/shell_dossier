<?php
/*
<table class="table">
	<thead style="background-color: #01528A;">
	 <tr>
		 <th style="font-size: 20px; font-weight: normal; text-align: center;">Actualités de vos SCPI</th>
	 </tr>
	</thead>
	<tbody id="tbl_DerA">
<?php
	foreach ($this->dh->getActuality() as $value) {
		echo '<tr><td>';
		?>
		<?php echo '<h4>' . htmlspecialchars($value->title) . '</h4>';?>
		<?php echo htmlspecialchars(date("d/m/Y", strtotime($value->date_publication)));?><BR>
		<?php
		if (preg_match("/<\s*p[^>]*>([^<]*)<\s*\/\s*p\s*>/", $value->content, $val))
		if (!empty($val[0]) && (strlen(substr(substr($val[0], 0, -4), 0, 250)) > 200))
			echo substr(substr($val[0], 0, -4), 0, 250) . '...</p>';
		echo '<a target="_blank" href="https://www.meilleurescpi.com/actualites/' .  $value->token . "-" . $value->slug . '/">En savoir plus';?></a></td></tr><?php
	}
?>
	</tbody>
</table>
*/
?>
<div class="module moduleDernieresActu">
	<div class="moduleTitle">
		<img src="<?=$this->getPath() . "img/Actus-Blanc.svg"?>" alt="" />
		<span>DERNIÈRES ACTUALITÉS</span>
	</div>
	<div class="moduleContent mdlContentDernierActu">
		<ul class="list-unstyled">
		<?php
		foreach ($this->datas as $key => $value) {
			if ((onEdge() || onFirefox()) && $key > 5)
				break ;
			?>
			<li class="row">
				<?php
				if ($value['type'] === "pub")
				{
					?>
					<img class="col-lg-1 col-md-1 col-sm-1 col-xs-1" src="<?=$this->getPath() . "img/Publications_Bleu-MS.png"?>" alt="" />
					<?php
				}
				else
				{
					?>
					<img class="col-lg-1 col-md-1 col-sm-1 col-xs-1" src="<?=$this->getPath() . "img/Actus-Bleu-MS.svg"?>" alt="" />
					<?php
				}
				?>
				<div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">
					<span class="DernieresActuTitle"><?=htmlspecialchars($value['title'])?></span><br />
				<?php
			//	if (preg_match("/<\s*p[^>]*>([^<]*)<\s*\/\s*p\s*>/", $value->content, $val))
				/*
					<a target="_blank" href="<?=$value['link']?>">Lire la publication</a><span class="date-publi"> publiée le <?=htmlspecialchars(date("d/m/Y", strtotime($value['date'])))?></span><br />
					if (!empty($val[0]) && (strlen(substr(substr($val[0], 0, -4), 0, 250)) > 200))
						echo substr(substr($val[0], 0, -4), 0, 250) . '...</p>';
						*/
					?>
					<a target="_blank" href="<?=$value['link']?>">Lire la publication</a> publiée le <?= $value['date']->format("d/m/Y")?><br />
				</div>
				</li>
				<?php
			}
			?>
		</ul>
	</div>
</div>
