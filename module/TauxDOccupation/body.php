<div class="module moduleTof">
	<div class="moduleTitle">
		<img src="<?=$this->getPath() . "img/DiagCircu-Blanc.svg"?>" alt="" />
		<span>TOF MOYEN (<?= $this->dateDividende ?>)</span>
	<?php if (!empty($this->pdf)) : ?>
		<sup class="_tooltip_r">3</sup>
	<?php else: ?>
		<img src="<?= $this->getPath()?>img/i-Blanc.svg" class="_tooltip_r" onmouseover="display_tooltip('Taux d’occupation financier moyen de mon portefeuille', 'Il s’agit du taux d’occupation moyen de votre portefeuille de SCPI (à la fin du <?= $this->dateDividende ?>).<br>Cette moyenne est pondérée en fonction de la répartition de chaque SCPI dans votre portefeuille.', event)" onmouseout="disable_msg(event)">
	<?php endif ; ?>
	</div>
	<div class="moduleContent">
		<h1><?=number_format($this->table['precalcul']['Tof'], 2, ",", " ")?> %</h1>
	</div>
</div>
