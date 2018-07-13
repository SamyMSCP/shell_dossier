<?php
/*
<h1>PROJET CRÉÉ</h1>
<div class="orangeBar"></div>
*/
?>
<div class="forThanks">
	<div class="blockC">
		<div class="blockThanks">
			<span id="merci">MERCI</span><br />
			<span id="pour">POUR VOTRE</span><br />
			<span id="confiance">CONFIANCE !</span><br />
			<span id="votre">Votre projet a bien été crée. L’étude de votre projet d’investissement peut commencer.</span>
		</div>
	</div>


<div id="thxBrdr">
	<span class="prochaines">Un conseiller prendra contact avec vous <br />sous 48 heures ouvrées</span>
<?php
/*
	<span class="prochaines">LES PROCHAINES ÉTAPES</span>
	<div class="blkContrendu">
		<div class="lineRed"></div>
		<div style="padding-top: 20px;">
			<img src="<?=$this->getPath()?>img/Merci-1-BleuClair.svg" alt="" class="circleRed"/>
			<span>Un conseiller prendra contact avec vous dans les meilleurs délais.</span>
		</div>
		<div>
			<img src="<?=$this->getPath()?>img/Merci-2-BleuClair.svg" alt="" class="circleRed"/>
			<span>MeilleureSCPI.com vous adressera dans les plus brefs délais une sélection comparative de SCPI et une ou des simulations finan- cières d’investissement adaptée à votre situation fiscale et patri- moniale.</span>
		</div>
		<div>
			<img src="<?=$this->getPath()?>img/Merci-3-BleuClair.svg" alt="" class="circleRed"/>
			<span>Votre Conseiller vous proposera un échanges pour vous présenter la sélection comparative et la ou les simulation(s).</span>
		</div>
		<div>
			<img src="<?=$this->getPath()?>img/Merci-4-BleuClair.svg" alt="" class="circleRed"/>
			<span>Validation du projet et souscription.</span>
		</div>
		<div>
			<img src="<?=$this->getPath()?>img/Merci-5-BleuClair.svg" alt="" class="circleRed"/>
			<span>Réception de votre ou vos certificat(s) nominatif(s) de parts en SCPI.</span>
		</div>
		<div style="padding-bottom: 20px;">
			<img src="<?=$this->getPath()?>img/Merci-6-BleuClair.svg" alt="" class="circleRed"/>
			<span>Suivi progressif de votre portefeuille de SCPI avec votre Conseiller</span>
		</div>
	</div>
*/
?>
</div>



	<div class="endBtn">
		<?php 
		$dhType = Dh::getCurrent()->getType();
		if ($dhType == null || $dhType == "client") { 
		?>
			<a href="?p=ListeProjets"class="btn_rtn">
				<div>
					RETOUR
				</div>
			</a>
		<?php } else { ?>
			<a href="?p=EditionClient&client=<?=intval($GLOBALS['GET']['client'])?>" class="btn_rtn">
				<div>
					RETOUR
				</div>
			</a>
		<?php } ?>
	</div>
</div>
