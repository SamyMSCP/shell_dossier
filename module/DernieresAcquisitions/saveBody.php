<div class="module moduleDernieresActu">
	<div class="moduleTitle">
		<img src="<?=$this->getPath() . "img/Actus_Blanc.png"?>" alt="" />
		<span>DERNIERES ACQUISITIONS</span>
	</div>
	<div class="moduleContent">

<?php
	/*<img src="<?=$this->getPath()?>img/tooltip.ico" onmouseout="disable_msg(event)" class="_tooltip_r">*/
	?>

		<ul>
	<div class="table-responsive" style="text-align:center;">
		<div style="margin-left:10px;  margin-right:10px;">
			<div>
				<table class="table">
					<thead style="background-color: #01528A;">
						<tr>
							<th>SCPI *</th>
							<th class="mobile_resp">Surface</th>
							<th>Ville</th>
							<th>Code postal</th>
						</tr>
					</thead>
					<tbody>
					<?php
					//var_dump($this->dh->getAcquisition());
					//exit();
					foreach ($this->dh->getAcquisition() as  $value) {
//						if (empty($value->scpi) || empty($value->surfaces) || empty($value->city) || empty($value->zipcode))
//							continue ;	
					?>
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
						<?php
					}
					?>
					</tbody>
				</table>
				<span><i>* (% de détention)</i></span>
			</div>
		</div>
	</div>
	</div>
</div>
