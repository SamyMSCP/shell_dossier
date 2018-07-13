<div class="progr">
	<div class="progress"  >
		<div class="progress-bar progress-bar-info progress-bar-striped  progress_tmp" style="display:none; width:<?php echo 100 * ($this->prc / ($this->nbrElm - 1));?>%"></div>
		<div class="progress-bar progress-bar-info progress_real" style="width:<?php echo 100 * ($this->prc / ($this->nbrElm - 1));?>%"></div>
	</div>
	<div class="icon-progress">
		<?php
		$src = "";
		foreach ($this->data as $key => $elm) {
			if ($this->collaborateur->getType() == "yoda" || $this->collaborateur->getType() == "backoffice")
				$src = "onmouseenter='setProgressTmp(" . $key. ");' onclick='changeTransactionStatus(" .$key . ")' onmouseout='setProgressReal()'";
			if ($key < $this->prc) {
		?>
				<div class="progImg " style="left:<?php echo (100 * ($key / ($this->nbrElm - 1))); ?>%;">
					<img <?=$src?> class="blockclickable block block<?=$key?>" src="<?= $this->getPath() ?>img/MS-Numbers-Done_Nbr<?php echo ($key + 1);?>.png" >
					<p class="pos_step" style=""><?=$elm?></p>
				</div>
			<?php
			} else if ($key == $this->prc) {
			?>
				<div class="progImg " style="left:<?php echo (100 * ($key / ($this->nbrElm - 1))); ?>%;">
					<img  <?=$src?> class="blockclickable block block<?=$key?>" src="<?= $this->getPath() ?>img/MS-Numbers_Nbr<?php echo ($key + 1);?>.png" >
					<p class="pos_step" style=""><?=$elm?></p>
				</div>
			<?php
			} else if ($key > $this->prc) {
			?>
				<div class="progImg " style="left:<?php echo (100 * ($key / ($this->nbrElm - 1))); ?>%;">
					<img <?=$src?> class="blockclickable block block<?=$key?>" src="<?= $this->getPath() ?>img/MS-Numbers-Undone_Nbr<?php echo ($key + 1);?>.png" >
					<p class="pos_step" style=""><?=$elm?></p>
				</div>
			<?php
			}
		}
		?>
	</div>
</div>
