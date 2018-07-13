<div class="module moduleRepartitionGeographique">
	<div class="moduleTitle">
		<img src="<?=$this->getPath() . "img/DiagCircu-Blanc.svg"?>" alt="" />
		<span>RÉPARTITION GÉOGRAPHIQUE</span>
	<?php if (!empty($this->pdf)) : ?>
		<sup class="_tooltip_r">4</sup>
	<?php else: ?>
		<img class="_tooltip_r" src="<?=$this->getPath()?>img/i-Blanc.svg" onmouseover="display_tooltip('Répartition géographique', 'Il s’agit de la répartition géographique de votre portefeuille de SCPI global en fonction des<br> dernières informations communiquées par les sociétés de gestion (pondérée en fonction de la valeur de vente potentielle de chaque ligne de SCPI que vous détenez).', event)" onmouseout="disable_msg(event)" class="_tooltip" >
	<?php endif ; ?>
	</div>
	<div class="moduleContent" style="flex-direction: column;justify-content: space-around;padding-bottom: 5px;">
		<div class="contour_RepGeo">
			<canvas id="repartition_geographique"<?php if (isset($this->pdf)) : ?> width="600" height="300" style="zoom:0.5"<?php endif; ?>></canvas>
		</div>
		<div class="name_scpi col-xs-12">
			<ul>
				<?php
				$i = 1;
				$autre = 0.0;
				foreach ($this->data as $key => $elm) {
//					if ($this->total == 0.0) {
//						echo "<li>Aucune information disponible</li>";
//					}
					?>
					<li class="el-color-<?=$i?>">
						<span class="pill-color"><i class="fa fa-circle"></i></span>
						<span class="name"><?=htmlspecialchars($key)?></span>
						<?php
						if ($this->data[$key] === 0 || $this->total == 0) {
							?>
							<span class="purcent-info"><?=htmlspecialchars(number_format(0, 2, ',', ' '))?> %</span>
							<?php
						}
						else {
							?>
							<span class="purcent-info"><?=number_format(100 * $this->data[$key] / $this->total, 2, ",", "")?> %</span>
							<?php
						}
						?>
					</li>
					<?php
					$i++;
				}
				if ($autre > 0)
				{
					?>
					<li class="el-color-<?=$i?>">
						<span class="pill-color"><i class="fa fa-circle"></i></span>
						<span class="name">Autres R&eacute;gion</span>
						<span class="purcent-info"><?= number_format($autre, 1, ",", "")?> %</span>
					</li>
					<?php
				}
				?>
			</ul>
			<?php
			/*
			$temoin = 0;
			$color = array(
				0 => "color: rgb(57, 128, 181);",
				1 => "color: rgb(103, 157, 198);",
				2 => "color: rgb(149, 187, 215);",
				3 => "color: rgb(176, 204, 225);"
			);
			foreach ($this->table as $key => $elm) {
				if ($key === "precalcul")
					continue;
				if ($this->table['precalcul']['ventePotentielle'] == 0)
					continue ;
				echo '<h3 style="' . $color[$temoin] . ';margin-top: 0px;">';
				echo htmlspecialchars(substr($key , 5)) . " : " . htmlspecialchars(number_format(100 * ($elm['precalcul']["ventePotentielle"] / $this->table['precalcul']['ventePotentielle']), 1, ',', ' ')) . "%</h3>";
				$temoin++;
				if ($temoin === 4)
					break;
			}
			*/
			?>
		</div>
	</div>
</div>