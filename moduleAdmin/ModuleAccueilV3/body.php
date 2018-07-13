<datalist id="userList">
</datalist>

<div class="searchBar">
	<div id="beforeInput">Quel client vous intéresse ?</div>
	<img src="<?=$this->getPath()?>img/loupe-bleu.svg" alt="" />
	<input id="searchInput" type="text" list="userList" autocomplete="off" />
</div>

<div class="containAccueil">
	<div>
		<div class="bkProjet">
			<div class="titre">PROJETS</div>
			<div class="valeur"><?=number_format(0, 0, ",", " ")?></div>
			<img src="<?=$this->getPath()?>img/projet-blanc.svg" alt="" />
		</div>
	</div>
	<div>
		<div class="bkClients">
			<div class="titre">CLIENTS</div>
			<div class="valeur"><?=number_format($this->collaborateur->getNbrClientsHave(), 0, ",", " ")?></div>
			<img src="<?=$this->getPath()?>img/groupe-blanc.svg" alt="" />
		</div>
	</div>
	<div>
		<div class="bkProspects">
			<div class="titre">PROSPECTS</div>
			<div class="valeur"><?=number_format($this->collaborateur->getNbrProspectsHave(), 0, ",", " ")?></div>
			<img src="<?=$this->getPath()?>img/loupe-blanc.svg" alt="" />
		</div>
	</div>
	<div>
		<div class="bkTransaction">
			<div class="titre">TRANSACTIONS POTENTIELLES</div>
			<div class="valeur"><?=number_format(0, 0, ",", " ")?></div>
			<img src="<?=$this->getPath()?>img/caddie-bleu.svg" alt="" />
		</div>
	</div>
	<div>
		<div class="bkTPrio">
			<div class="titre">TÂCHES PRIORITAIRES DU JOUR</div>
			<div class="valeur"><?=number_format(count($this->tacheDuJour), 0, ",", " ")?></div>
			<img src="<?=$this->getPath()?>img/prioritaire-blanc.svg" alt="" />
		</div>
	</div>
	<div>
		<div class="bkTRet">
			<div class="titre">TÂCHES EN RETARD</div>
			<div class="valeur"><?=number_format(count($this->tachePasse), 0, ",", " ")?></div>
			<img src="<?=$this->getPath()?>img/horloge-blanc.svg" alt="" />
		</div>
	</div>
</div>
