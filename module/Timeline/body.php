<div class="module moduleDernieresActu" style="flex:2;">
	<div class="moduleTitle">
		<img src="<?=$this->getPath() . "img/Actus-Blanc.svg"?>" alt="" />
		<span>DERNIÈRES ACTUALITÉS</span>
	</div>
	<div class="moduleContent">
		
		<div class="blockListeScpi">
			<form method="GET" id="submit_scpi">
			<input type="hidden" name="p" value="<?=$GLOBALS['GET']['p']?>">
			<select id="scpialllist" class="form-control select_timeline" name="id" onchange="document.getElementById('submit_scpi').submit()">
			<option 
			<?php echo (empty($GLOBALS['GET']['id']) ? "selected=1" : "");?>
			value="0">TOUTES LES SCPI</option>
			<?php
			foreach ($this->scpi as $elm) {
				if (!empty($GLOBALS['GET']['id']) && intval($elm->id_scpi) == $GLOBALS['GET']['id'])
				{
					?>
					<option selected="1" value="<?=intval($elm->id_scpi)?>">
						<?=mb_strtoupper(substr(htmlspecialchars($elm->getName()), 5))?>
					</option>
					<?php
				}
				else
				{
					?>
					<option value="<?=intval($elm->id_scpi)?>">
						<?=mb_strtoupper(substr(htmlspecialchars($elm->getName()), 5))?>
					</option>
					<?php
				}
			}
				?>
			</select>
			</form>
		</div>
		<div class="dataTimeline">
			<?php
			include ($this->getPath() . "timeline.php")
			?>
		</div>
		<div class="blocTimeline">
			<div class="blockTimelineLeft"></div>
			<div class="ligneCentrale"></div>
			<div class="blockTimelineRight"></div>
		</div>
	</div>
</div>

<div class="module moduleDernieresActuFavoris" style="flex:1;">
	<div class="moduleTitle">
		<img src="<?=$this->getPath() . "img/Favoris_Blanc.png"?>" alt="" />
		<span>MES FAVORIS</span>
			<img src="<?= $this->getPath()?>img/i-Blanc.svg" class="_tooltip_r" onmouseover="display_tooltip('MES FAVORIS', 'Pour ajouter un favori, merci de cliquer sur l\'icône de l\'étoile en haut à droite de chaque actualité.', event)" onmouseout="disable_msg(event)">
	</div>
	<div class="moduleContent ContentFavorite">
		<h3 id="favoriteempty">Pas de favoris</h3>
	</div>
</div>

<div class="TimelineElmFavorite TimelineElmFavoriteProto">
	<img src="<?=$this->getPath()?>img/Actus-Bleu-MS.svg" alt="" />
	<div>
		<h3>Titre</h3>
		<span>Publié le 01/07/2016</span>
	</div>
	<?php
	/*
	<img onclick="removeFavorite(this);" class="imgLogo" src="<?=$this->getPath() . "img/Favoris_BleuMS-Positif.png"?>" alt="" />
	*/
	?>
	<i onclick="removeFavorite(this);" class="imgLogo fa fa-star"></i>
</div>
