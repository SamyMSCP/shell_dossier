<div class="module moduleOpportunite">
	<div class="moduleTitle">
		<img src="<?=$this->getPath() . "img/picto/" . Opportunite::getOpportunite()->getTitlePicto()?>" alt="" />
		<?php
		if (!empty(Opportunite::getOpportunite()))
			echo '<span>', Opportunite::getOpportunite()->getTheTitle(), '</span>';
		else
			echo '<span>OPPORTUNITÉ A SAISIR !</span>';
		?>
	</div>
	<div class="moduleContent">
	<?php
		if (!empty(Opportunite::getOpportunite()))
		{
		?>
		<div class="moduleOpportuniteImg" style="background-image:url('<?=Opportunite::getOpportunite()->getImageData()?>')">
		</div>
		<div class="moduleOpportuniteText">
			<span class="moduleOpportuniteSCPITitle"><?=Opportunite::getOpportunite()->getTitle()?></span>
			<div class="moduleOpportuniteBlockInfo">
				<div class="moduleOpportuniteBlockInfoRendement">
					<span><?=Opportunite::getOpportunite()->getLeft_val()?></span>
					<?=Opportunite::getOpportunite()->getLeft_msg()?>
					<?php
					/*
					<img src="<?=$this->getPath()?>img/i_Jaune-Negatif.png" alt="" />
					*/
					?>
				</div>
				<div class="moduleOpportuniteBlockInfoAccessibilite">
					<span><?=Opportunite::getOpportunite()->getRight_val()?></span>
						<?=Opportunite::getOpportunite()->getRight_msg()?>
					<?php
					/*
					<img src="<?=$this->getPath()?>img/i_Jaune-Negatif.png" alt="" />
					*/
					?>
				</div>
			</div>
			<p><?=Opportunite::getOpportunite()->getContent()?></p>
			<button class="BtnStyle" onclick="window.open('<?=Opportunite::getOpportunite()->getUrl()?>', '_blank')">EN SAVOIR PLUS</button>
		</div>
	<?php } ?>
	</div>
</div>
