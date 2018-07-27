<div class="module">
    <div class="moduleTitle">
        <img src="<?=$this->getPath() . "img/Portefeuille_Blanc.png"?>" alt="" />
        <span>VALORISATION DE MON PORTEFEUILLE</span>
        <img src="<?= $this->getPath()?>img/i-Blanc.svg" class="_tooltip_r" onmouseover="display_tooltip('Mon portefeuille', 'Il s\'agit de la valorisation de votre portefeuille en valeur de revente potentielle estimée.', event)" onmouseout="disable_msg(event)">
    </div>
    <div class="moduleContent module-visu text-uppercase">
        <div class="container-fluid">
            <div class="legend">
					Montant investi :
			</div>
            <div class="value">
                <?=number_format($this->table['precalcul']['MontantInvestissement'], 2, ",", " ")?> €
            </div>
        </div>
        <div class="container-fluid ">
            <div class="legend">Valeur de revente potentielle :</div>
			<div class="value">
				<?=number_format($this->table['precalcul']['ventePotentielle'], 2, ",", " ")?> €
			</div>
			<div class="addon">
				soit
				<span><?=number_format((float)$this->table['precalcul']['plusMoinValuePourcent'], 2, ",", "") ?>%</span>
				 de plus-value
			</div>
        </div>
    </div>
</div>