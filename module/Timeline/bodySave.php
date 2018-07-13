<div class="module moduleDernieresActu" style="flex:2;">
	<div class="moduleTitle">
		<img src="<?=$this->getPath() . "img/Actus_Blanc.png"?>" alt="" />
		<span>DERNIÈRES ACTUALITES</span>
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
						<?=mb_strtoupper(substr(htmlspecialchars(ft_decrypt_crypt_information($elm->Name)), 5))?>
					</option>
					<?php
				}
				else
				{
					?>
					<option value="<?=intval($elm->id_scpi)?>">
						<?=mb_strtoupper(substr(htmlspecialchars(ft_decrypt_crypt_information($elm->Name)), 5))?>
					</option>
					<?php
				}
			}
				?>
			</select>
			</form>
			<script>
function sortSelect(selElem, id_page) {
    var tmpAry = new Array();
    for (var i=0;i<selElem.options.length;i++) {
        tmpAry[i] = new Array();
        tmpAry[i][0] = selElem.options[i].text;
        tmpAry[i][1] = selElem.options[i].value;
    }
    tmpAry.sort();
    while (selElem.options.length > 0) {
        selElem.options[0] = null;
    }
    let index = 0;
    for (var i=0;i<tmpAry.length;i++) {
        if (tmpAry[i][0] == "TOUTES LES SCPI"){
            var op = new Option(tmpAry[i][0], tmpAry[i][1]);
            selElem.options[index++] = op;
            break;
        }
    }
    for (var i=0;i<tmpAry.length;i++) {
        if (tmpAry[i][0] != "TOUTES LES SCPI"){
            var op = new Option(tmpAry[i][0], tmpAry[i][1]);
            selElem.options[index] = op;
			if (selElem.options[index].value == id_page)
				selElem.options[index].selected = true;
			index++;
        }
    }
    return;
}
sortSelect(document.getElementById('scpialllist'), <?php echo (empty($GLOBALS['GET']['id']) ? 0 : $GLOBALS['GET']['id']); ?>);
			</script>
		<?php
		/*	<a href="?p=Actu">
					if (empty($GLOBALS['GET']['id']))
					{
						?>
						<h3 class="souligne">TOUTES LES SCPI</h3>
						<?php
					}
					else
					{ 
						?>
						<h3 >TOUTES LES SCPI</h3>
						<?php
					}
					?>
			</a>
			<?php
			foreach ($this->scpi as $elm) {
				?>
				<a href="?p=Actu&id=<?=intval($elm->id_scpi)?>">
				<?php
				if (!empty($GLOBALS['GET']['id']) && intval($elm->id_scpi) == $GLOBALS['GET']['id'])
				{
					?>
					<h3 class="souligne"><?=mb_strtoupper(substr(htmlspecialchars(ft_decrypt_crypt_information($elm->Name)), 5))?></h3>
					<?php
				}
				else
				{
					?>
					<h3><?=mb_strtoupper(substr(htmlspecialchars(ft_decrypt_crypt_information($elm->Name)), 5))?></h3>
					<?php
				}
				?>
				</a>
			<?php
			}
			*/?>
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
			<img src="<?= $this->getPath()?>img/i_Blanc-Negatif.png" class="_tooltip_r" onmouseover="display_tooltip('MES FAVORIS', 'Pour ajouter un favori, merci de cliquer sur l\'icone de l\'étoile en haut à droite de chaque actualité.', event)" onmouseout="disable_msg(event)">
	</div>
	<div class="moduleContent ContentFavorite">
		<h3 id="favoriteempty">Pas de favoris</h3>
	</div>
</div>

<div class="TimelineElmFavorite TimelineElmFavoriteProto">
	<img src="<?=$this->getPath()?>img/Actus_Bleu-MS.png" alt="" />
	<div>
		<h3>Titre</h3>
		<span>Publie le 01/07/2016</span>
	</div>
	<img onclick="removeFavorite(this);" class="imgLogo" src="<?=$this->getPath() . "img/Favoris_BleuMS-Positif.png"?>" alt="" />
</div>
