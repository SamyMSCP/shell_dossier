<div class="content_2">
		<h2>Dividendes <?=$this->currentYear?></h2>
	<img src="<?= $this->getPath()?>img/tooltip.ico" class="_tooltip_r" onmouseover="display_tooltip('Dividendes de mes SCPI', '<?=$this->details?>',event)" onmouseout="disable_msg(event)">
		<?php
		if ($this->table['precalcul']['flagMissingInfo'])
			echo "<h3 style=\"color: #8a6d3b\">Des informations sont manquantes.</h3>";
		else
			echo '<h1 style="color: #20BF55; font-size: 50px; font-weight: bold;">' . number_format($this->dividendes, 2, ",", " ") . " €</h1>";?>
</div>
