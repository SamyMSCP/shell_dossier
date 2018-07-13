<div class="module moduleTof">
	<div class="moduleTitle">
		<img src="<?=$this->getPath() . "img/DiagCircu-Blanc.svg"?>" alt="" />
		<span>RÉPARTITION PAR TYPE</span>
		<img src="<?= $this->getPath()?>img/i-Blanc.svg" class="_tooltip_r" onmouseover="display_tooltip('Répartition par type de SCPI', 'Part de votre portefeuille en fonction du type de SCPI pondérée avec la valeur de revente potentielle estimée.',event)" onmouseout="disable_msg(event)">
	</div>
	<div class="moduleContent">
		<span class="tofVar">
			Capital variable : <?=number_format($this->variable, 2, ",", " ")?> %
		</span>
		<div class="progress2" onmouseover="display_val(this, event)" onmouseout="disable_val(event)">
			<div class="progress-bar2 progress-bar-info2"></div>
		</div>
		<span class="tofFix">
			Capital fixe : <?=number_format($this->fixe, 2, ",", " ")?> %
		</span>
	</div>
</div>
