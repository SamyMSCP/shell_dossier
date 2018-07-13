<div class="well">
	Nombre de souscription : <p style="text-align: right;"><?php echo $this->i ?></p>
	Montant total investit : <p style="text-align: right;"><?php echo number_format($this->m, 2, ',', ' '); ?> €</p>
	Date dernière souscription : <p style="text-align: right;"><?php if ($this->date) echo date_fr(strftime("%d %B %Y", $this->date)); else echo "-";?></p>
	Montant moyen / souscription : <p style="text-align: right;"><?php if ($this->part && $this->nbr) echo number_format($this->m/$this->i, 2, ',', ' ') . " €"; else echo "-";?></p>
	Dernier contact : <?php $this->c -= 1; echo htmlspecialchars($this->c >= 0 ? $this->tabcrm[$this->c]['date_r'] : "Inconnue");?> <br>
	Prochain contact : <?php echo htmlspecialchars($this->c >= 0 ? $this->tabcrm[$this->c]['DATE_f'] : "Inconnue");?> <br>
	Dernière connexion : <?php echo (strftime("%d %b %Y", get_log(intval($GLOBALS['GET']['client']))));?>
</div>
