<div class="module moduleRepartition">
	<div class="moduleTitle">
		<img src="<?=$this->getPath() . "img/DiagCircu-Blanc.svg"?>" alt="" />
		<span>RÉPARTITION PAR SCPI</span>
		<?php if (!empty($this->pdf)) : ?>
			<sup class="_tooltip_r">1</sup>
		<?php else: ?>
			<span class="text-left" style="max-width: 35px; margin-right: 10px;">
				<tooltip title="Répartition de mon portefeuille" size="big" content="Il s’agit de la part que représente chacune de vos SCPI<br /> en fonction de la valeur de revente estimée.">
			</span>
		<?php endif ; ?>
	</div>
	<div class="moduleContent" style="">
		<div class="contour_RepPort">
			<canvas id="repartition_scpi"<?php if (isset($this->pdf)) : ?> width="600" height="300" style="zoom:0.5"<?php endif; ?>></canvas>
		</div>
		<div id="repartitionScpiVue" class="name_scpi col-xs-12">
			<repartition-scpi> </repartition-scpi>
		</div>
	</div>
</div>
