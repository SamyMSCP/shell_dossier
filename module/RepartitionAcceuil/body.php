<?php
/*
<h2>Répartition</h2>
<div id="money" style="height: 357px"></div>
<div id="euro">
<h1 class="txtInCercle">
	<?php
//		echo number_format($this->dh->getSumActualValue(), 2, ',', ' ') . " €";
	?>
	Placer le curseur sur l'arc de cercle
	</h1>
</div>
*/
?>

<div class="module moduleRepartition">
	<div class="moduleTitle">
		<img src="<?=$this->getPath() . "img/DiagCircu-Blanc.svg"?>" alt="" />
		<span>RÉPARTITION PAR SCPI</span>
		<?php if (!empty($this->pdf)) : ?>
			<sup class="_tooltip_r">1</sup>
		<?php else: ?>
			<img class="_tooltip_r" src="<?=$this->getPath()?>img/i-Blanc.svg" onmouseover="display_tooltip('Répartition de mon portefeuille', 'Il s’agit de la part que représente chacune de vos SCPI<br /> en fonction de la valeur de revente estimée.', event)" onmouseout="disable_msg(event)" class="_tooltip">
		<?php endif ; ?>
	</div>
	<div class="moduleContent" style="">
		<div class="contour_RepPort">
			<canvas id="repartition_scpi"<?php if (isset($this->pdf)) : ?> width="600" height="300" style="zoom:0.5"<?php endif; ?>></canvas>
		</div>
		<div class="name_scpi col-xs-12">
			<ul>
				<?php
				$i = 1;
				$autre = 0.0;
				foreach ($this->table as $key => $elm) {
					if ($i > 4) //MAX -> 4
					{
						if (isset($elm['precalcul']))
							$autre += 100 * ($elm['precalcul']["ventePotentielle"] / $this->table['precalcul']['ventePotentielle']);
						continue ;
					}
					if (!isset($elm['precalcul']))
						continue;
					?>
					<li class="el-color-<?=$i?>">
						<span class="pill-color"><i class="fa fa-circle"></i></span>
						<span class="name"><?=htmlspecialchars(substr($key , 5))?></span>
						<?php
						if ($this->table['precalcul']['ventePotentielle'] != 0.0) {
							?>
							<span class="purcent-info"><?=htmlspecialchars(number_format(100 * ($elm['precalcul']["ventePotentielle"] / $this->table['precalcul']['ventePotentielle']), 1, ',', ' '))?> %</span>
							<?php
						}
						else {
							?>
							<span class="purcent-info"><?=htmlspecialchars(number_format(0, 1, ',', ' '))?> %</span>
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
						<span class="name">Autres SCPI</span>
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
