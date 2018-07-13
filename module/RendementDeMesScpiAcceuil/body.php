<div class="moduleVerticalAlign">
	<div class="module moduleMonPortefeuille">
		<div class="moduleTitle">
			<img src="<?=$this->getPath() . "img/Portefeuille_Blanc.png"?>" alt="" />
			<span>VALORISATION DE MON PORTEFEUILLE</span>
			<img src="<?= $this->getPath()?>img/i-Blanc.svg" class="_tooltip_r" onmouseover="display_tooltip('Mon portefeuille', 'Il s\'agit de la valorisation de votre portefeuille en valeur de revente potentielle estimée.', event)" onmouseout="disable_msg(event)">
		</div>
		<div class="moduleContent" style="padding: 10px;">
			<div>
				<span>Montant investi :</span>
				<?=number_format($this->table['precalcul']['MontantInvestissement'], 2, ",", " ")?> €
			</div>
			<div>
				<span>Valeur de revente potentielle :</span>
				<?=number_format($this->table['precalcul']['ventePotentielle'], 2, ",", " ")?> €
			</div>
		</div>
	</div>
	<div class="module moduleDividendes">
		<div class="moduleTitle">
			<img src="<?=$this->getPath() . "img/Billet-Blanc.svg"?>" alt="" />
			<span>MES DIVIDENDES SCPI</span>
			<img src="<?= $this->getPath()?>img/i-Blanc.svg" class="_tooltip_r" onmouseover="display_tooltip('Mes dividendes estimés', '<?=$this->details?>', event)" onmouseout="disable_msg(event)">
		</div>
		<div class="moduleContent">
			<?php
			if ($this->table['precalcul']['flagMissingInfo'])
				echo "<h3 style='color:#505050;font-size:16px;'>Pour connaitre le montant de vos dividendes, merci de compléter certaines données manquantes de vos transactions.</h3>";
			else
			{
				if ($this->lastDividendes)
				{
					?>
					<div>
						<?php
						/*
						<span><?=$this->currentYear - 1?></span>
						*/
						?>
						<span><?=$this->currentYear - 1?></span>
						<?=number_format($this->lastDividendes, 2, ",", " ")?> €
					</div>
				<?php
				}
				if ($this->dividendes)
				{
				?>
				<div>
					<span><?=$this->currentYear?></span>
					<?=number_format($this->dividendes, 2, ",", " ")?> €
				</div>
				<?php
				}
			}
			?>
		</div>
	</div>
</div>
