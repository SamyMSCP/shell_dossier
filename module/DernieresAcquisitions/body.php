<div class="module moduleDernieresAcquisitions">
	<div class="moduleTitle">
	<?php
		/*
		<img src="<?=$this->getPath() . "img/Actus_Blanc.png"?>" alt="" />
		*/
		?>
		<i class="fa fa-building" aria-hidden="true"></i>
		<span>DERNIÈRES ACQUISITIONS</span>
	</div>
	<div class="moduleContent" style="justify-content:flex-start;">
		<?php
		/*<img src="<?=$this->getPath()?>img/tooltip.ico" onmouseout="disable_msg(event)" class="_tooltip_r">*/
		?>
		<ul>
			<?php
			foreach ($this->dh->getAcquisition() as  $key => $value) {
				if ($key >= 6)
					break ;
			?>
				<li>
					<?php
					/*
					<img src="<?=$this->getPath() . "img/Publications_Bleu-MS.png"?>" alt="" />
					*/
					?>
					<div>
						<span class="DernieresAcquisitionsTitle"><a target="_blank" href="<?=str_replace("preprod.", "", $value->url)?>"><?php 
						
						foreach($value->scpi as $k => $e) {
							if ($k != 0)
								echo "<br />";
							echo $e;
						}?></a></span><br />
						<?=htmlspecialchars($value->city)?> - <?=htmlspecialchars($value->zipcode)?> - <?=htmlspecialchars($value->surfaces)?> m2
					<?php
					/*
				<tr style="cursor:pointer;" class="hover_blue_back" onclick="window.open('<?=str_replace("preprod.", "", $value->url)?>');">
					<td>
						<?=str_replace(") SCPI", ")<br />", substr(htmlspecialchars($value->scpi), 5))?></td>
					<td class="mobile_resp">
						<?=htmlspecialchars($value->surfaces)?> m2</td>
					<td>
						<?=htmlspecialchars($value->city)?></td>
					<td>
						<?=htmlspecialchars($value->zipcode)?>
					</td>
				</tr>
				*/
				?>
					</div>
				</li>
				<?php
			}
			?>

		<span style="color:#505050;font-weight:400;"><i>* (% de détention)</i></span>
	</div>
</div>
