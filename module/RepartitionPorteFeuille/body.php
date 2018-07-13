<div class="content_2">
	<img src="<?=$this->getPath()?>img/tooltip.ico" onmouseover="display_tooltip('Répartition de mon portefeuille', 'Il s’agit de la part que représente chacune de vos SCPI dans votre portefeuille.<br>La valeur de référence étant la dernière valeur connue de vente par part.', event)" onmouseout="disable_msg(event)" class="_tooltip">
	<h2>Répartition de mon portefeuille</h2>
	<div id="test">
	</div>
	<div class="">
		<div id="money" >
		</div>
		<div id="euro">
			<h1 style="color: #129A50; "><?php  echo number_format($this->table['precalcul']['ventePotentielle'], 2, ',', ' ') . " €"; ?></h1>
		</div>
	</div>
	<div class="row">
		<div id="name_scpi" class="col-md-12" style="text-align: right;">
			<?php
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
				echo '<h3 style="' . $color[$temoin] . '">';
				echo htmlspecialchars(substr($key , 5)) . " : " . htmlspecialchars(number_format(100 * ($elm['precalcul']["ventePotentielle"] / $this->table['precalcul']['ventePotentielle']), 1, ',', ' ')) . "%</h3>";
				$temoin++;
				if ($temoin === 3)
					break;
			}
			?>
		</div>
	</div>
</div>
