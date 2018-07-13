<div class="module moduleSuggestion">
	<div class="moduleTitle">
		<img src="<?php
			if (!empty(Suggestion::getSuggestion()))
				echo $this->getPath(), "img/picto/", Suggestion::getSuggestion()->getTitlePicto();
			else
				echo $this->getPath(), "img/Suggestions_Blanc.png";
		?>" alt="" />
		<span><?php echo empty(Suggestion::getSuggestion()) ? "Pas d'information" : Suggestion::getSuggestion()->getTheTitle(); ?></span>
	</div>
	<div class="moduleContent">
	<div class="moduleSuggestionImg" style="background-image:url(<?php
				if (!empty(Suggestion::getSuggestion()))
				echo Suggestion::getSuggestion()->getImageData(); //$this->getPath(), "img/picto/", 
			else
				echo $this->getPath(), "img/Suggestions_Blanc.png";
		?>)"></div>
	<?php
		if (!empty(Suggestion::getSuggestion()))
		{
		?>
		<div class="moduleSuggestionText">
			<span class="moduleSuggestionSCPITitle"><?=Suggestion::getSuggestion()->getTitle()?></span>
			<div class="moduleSuggestionBlockInfo">
				<div class="moduleSuggestionBlockInfoTDVM">
					<span style="font-size: 40px;"><?=Suggestion::getSuggestion()->getLeft_val()?></span>
					<div style="font-size: 16px;">
						<?=Suggestion::getSuggestion()->getContent()?>
					<?php
					/*
						<img src="<?=$this->getPath()?>img/i_Jaune-Negatif.png" alt="" />
					*/
					?>
					</div>
				</div>
				<div class="moduleSuggestionBlockInfoRight">
					<div class="moduleSuggestionBlockInfoAccessibilite">
						<div class="moduleSuggestionBlockInfoAccessibilite">
							<?php if (Suggestion::getSuggestion()->getRight_val()){ ?>
							<div class="moduleSuggestionBlockInfoStatus">Ouvert</div>
							<?php } else { ?>
							<div class="moduleSuggestionBlockInfoStatus" style="border: 4px solid #a94442; color: #a94442;">Fermé</div>
							<?php } ?>
								<!--<?=Suggestion::getSuggestion()->getLeft_msg()?>-->
							<div class="moduleSuggestionBlockInfoStatusPicto">
								<?php
									if (strstr(Suggestion::getSuggestion()->getLeft_msg(), "."))
										echo "<img style=\"width: 50px;\" src=\"", $this->getPath(), "img/scpi/", Suggestion::getSuggestion()->getLeft_msg(), "\">";
									else
										echo "<img style=\"width: 50px;\" src=\"$this->getPath()img/Bureaux_Bleu-MS.png\">";
								?>
							</div>
						</div>
					</div>
				</div>
			</div>
			<button class="BtnStyle" onclick="window.open('<?=Suggestion::getSuggestion()->getUrl()?>', '_blank')">DEMANDE DE RENSEIGNEMENTS</button>
		</div>
	<?php } ?>
	</div>
</div>
