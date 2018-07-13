<div class="progr">
	<div class="progress">
		<div class="progress-bar progress-bar-info" style="width:<?php echo 100 * ($this->prc / ($this->nbrElm - 1));?>%"></div>
	</div>
	<div class="icon-progress">
		<?php
		foreach ($this->data as $key => $elm) {
			if ($key < $this->prc) {
		?>
				<div class="progImg " style="left:<?php echo (100 * ($key / ($this->nbrElm - 1))); ?>%;">
					<?php
						if ($this->prc >= 1)
						{
							echo '<img class="block block', $key, '" src="', $this->getPath(), 'img/CP-Valide.svg">';
							echo '<p class="pos_step pos_step_valid" style="">', $elm, '</p>';
						}
						else
						{
							echo '<img class="block block', $key, '" src="', $this->getPath(), 'img/CP-', ($key + 1), '-bleu.svg">';
							echo '<p class="pos_step pos_step_current" style="">', $elm, '</p>';
						}
					?>
				</div>
			<?php
			} else if ($key == $this->prc) {
			?>
				<div class="progImg " style="left:<?php echo (100 * ($key / ($this->nbrElm - 1))); ?>%;">
					<img class="block block<?=$key?>" src="<?= $this->getPath() ?>img/CP-<?php echo ($key + 1);?>-bleu.svg" >
					<p class="pos_step pos_step_current" style=""><?=$elm?></p>
				</div>
			<?php
			} else if ($key > $this->prc) {
			?>
				<div class="progImg " style="left:<?php echo (100 * ($key / ($this->nbrElm - 1))); ?>%;">
					<img class="block block<?=$key?>" src="<?= $this->getPath() ?>img/CP-<?php echo ($key + 1);?>-gris.svg" >
					<p class="pos_step pos_step_noValid" style=""><?=$elm?></p>
				</div>
			<?php
			}
		}
		?>
	</div>
</div>
