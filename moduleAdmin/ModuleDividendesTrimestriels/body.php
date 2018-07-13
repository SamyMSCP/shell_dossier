<div class="module moduleRepartition">
	<div class="moduleTitle">
		<img src="<?=$this->getPath() . "img/DiagCircu-Blanc.svg"?>" alt="" />
		<span>DIVIDENDES TRIMESTRIELS</span>
		<img src="<?= $this->getPath()?>img/telechargerblanc.png" class="downloadDividendes" onclick="window.open('?p=DividendesTrimestrielsPdf&client=<?=intval($GLOBALS['GET']['client'])?>', '_blank')">
	</div>
	<div class="moduleContent vueDividendes" style="flex-direction: column;justify-content: space-around;padding-bottom: 5px;">
		<dividendes-trimestriels></dividendes-trimestriels>
	</div>
</div>
