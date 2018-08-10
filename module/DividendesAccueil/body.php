<div class="module moduleDividendes">
	<div class="moduleTitle">
		<img src="<?= $this->getPath() . "img/Billet-Blanc.svg" ?>" alt=""/>
		<span>MES DIVIDENDES SCPI</span>
		<span class="text-left" style="max-width: 35px; margin-right: 10px;">
			<tooltip title="Mes dividendes estimés" size="big" content="<?= $this->details ?>">
		</span>
		<!-- <img src="<?= $this->getPath() ?>img/i-Blanc.svg" class="_tooltip_r"
			 onmouseover="display_tooltip('Mes dividendes estimés', '<?= $this->details ?>', event)"
			 onmouseout="disable_msg(event)"> -->
	</div>
	<div class="moduleContent module-visu">
		<?php
		if ($this->table['precalcul']['flagMissingInfo'] || $this->table['precalcul']['ventePotentielle'] == 0.0) {
			?>
			<div class="informative-no-data">
				<div class="row">
					<div class="col-lg-12">
						<h3>Pour connaitre le montant de vos dividendes,<br/>
							merci de compléter certaines données manquantes de vos transactions.</h3>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-12">
						<a href="/?p=Portefeuille" class="btn btn-mscpi-transac">Acc&eacute;der &agrave; mes transactions</a>
					</div>
				</div>
			</div>
			<?php
		} else {
			if ($this->lastDividendes) {
				?>
				<div class="container-fluid">
					<?php
					/*
					<span><?=$this->currentYear - 1?></span>
					*/
					?>
					<div class="legend">
						Re&ccedil;u en <?= $this->currentYear - 1 ?>
					</div>
					<div class="value">
						<?= number_format($this->lastDividendes, 2, ",", " ") ?> €
					</div>
				</div>
				<?php
			}
			if ($this->dividendes) {
				?>
				<div>
					<div class="legend">Re&ccedil;u depuis le debut de l'ann&eacute;e</div>
					<div class="value">
						<?= number_format($this->dividendes, 2, ",", " ") ?> €
					</div>
				</div>
				<?php
			}
		}
		?>
	</div>
</div>
