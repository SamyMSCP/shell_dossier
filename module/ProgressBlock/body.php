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
					<img class="block block<?=$key?>" src="<?= $this->getPath() ?>img/MS-Numbers-Done_Nbr<?php echo ($key + 1);?>.png" >
					<p class="pos_step" style=""><?=$elm?></p>
				</div>
			<?php
			} else if ($key == $this->prc) {
			?>
				<div class="progImg " style="left:<?php echo (100 * ($key / ($this->nbrElm - 1))); ?>%;">
					<img class="block block<?=$key?>" src="<?= $this->getPath() ?>img/MS-Numbers_Nbr<?php echo ($key + 1);?>.png" >
					<p class="pos_step" style=""><?=$elm?></p>
				</div>
			<?php
			} else if ($key > $this->prc) {
			?>
				<div class="progImg " style="left:<?php echo (100 * ($key / ($this->nbrElm - 1))); ?>%;">
					<img class="block block<?=$key?>" src="<?= $this->getPath() ?>img/MS-Numbers-Undone_Nbr<?php echo ($key + 1);?>.png" >
					<p class="pos_step" style=""><?=$elm?></p>
				</div>
			<?php
			}
		}
		?>
	</div>
</div>
