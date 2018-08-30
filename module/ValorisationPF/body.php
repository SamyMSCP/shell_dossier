<div class="module">
    <div class="moduleTitle">
        <img src="<?=$this->getPath() . "img/Portefeuille_Blanc.png"?>" alt="" />
        <span>VALORISATION DE MON PORTEFEUILLE</span>
        <span class="text-left" style="max-width: 35px; margin-right: 10px;">
            <tooltip title="Mon portefeuille" size="big" content="Il s'agit de la valorisation de votre portefeuille en valeur de revente potentielle estimée.">
        </span>
    </div>
    <div class="moduleContent module-visu text-uppercase">
        <div class="container-fluid">
            <div class="legend">
					Montant investi :
			</div>
            <div class="value">{{ montantInvestis | currency }}</div>
        </div>
        <div class="container-fluid ">
            <div class="legend">Valeur de revente potentielle :</div>
			<div class="value">
            {{ montantTotal | currency }}
			</div>
			<div class="addon">
				soit
				<span><?=number_format((float)$this->table['precalcul']['plusMoinValuePourcent'], 2, ",", "") ?>%</span>
				 de plus-value
			</div>
        </div>
    </div>
</div>