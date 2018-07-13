<div class="blockTitle">
	<img class="logo_title" src="<?=$this->getPath()?>img/Guide-BleuClair.svg" alt="" />
	<span>NOS GUIDES</span>
</div>
<div class="barre_bleu"></div>
<div class="block_list">
	<div class="element" onclick="window.open('http://moncompte.meilleurescpi.com/?mail=<?=$this->dh->getLogin()?>', '_blank');">
		<img src="<?=$this->getPath()?>img/Guide-SCPI-2017-Vol1-Investissement-BD.jpg" />
		<div class="masque">
			<span>Volume 1 l'investissement en scpi</span>
			<button class="btn-mscpi btn-orange">CONSULTER</button>
		</div>
	</div>
	<?php
	if ($this->dh->getType() == "client")
	{
		?>
		<div class="element" onclick="window.open('http://www.42.fr', '_blank');">
			<img src="<?=$this->getPath()?>img/Guide-SCPI-2017-Vol2-DeclaFiscale-BD.jpg" />
			<div class="masque">
				<span>Wording en attente</span>
				<button class="btn-mscpi btn-orange">CONSULTER</button>
			</div>
		</div>
		<?php
	}
	else
	{
		?>
		<div class="element" onclick="window.open('https://meilleurescpicom.eekl.it/p/0d6a94a4d0?email_auto=<?=$this->dh->getLogin()?>', '_blank');">
			<img src="<?=$this->getPath()?>img/Guide-SCPI-2017-Vol2-DeclaFiscale-BD.jpg" />
			<div class="masque reserved">
				<img src="<?=$this->getPath()?>img/Cadenas-closed-Blanc.svg" alt="" />
				<span>RÉSERVÉ AUX CLIENTS MEILLEURESCPI.COM</span>
			</div>
		</div>
		<?php
	}
	?>
	<div class="element" onclick="window.open('http://moncompte.meilleurescpi.com/?mail=<?=$this->dh->getLogin()?>', '_blank');">
		<img src="<?=$this->getPath()?>img/Guide-SCPI-2017-Vol3-Demembrement-BD.jpg" />
		<div class="masque">
			<span>Wording en attente</span>
			<button class="btn-mscpi btn-orange">CONSULTER</button>
		</div>
	</div>
	<div class="element" onclick="window.open('http://moncompte.meilleurescpi.com/?mail=<?=$this->dh->getLogin()?>', '_blank');">
		<img src="<?=$this->getPath()?>img/Guide-SCPI-2017-Vol4-Fiscales-BD.jpg" />
		<div class="masque">
			<span>Wording en attente</span>
			<button class="btn-mscpi btn-orange">CONSULTER</button>
		</div>
	</div>
</div>

<div class="blockTitle">
	<img class="logo_title" src="<?=$this->getPath()?>img/Publications-BleuClair.svg" alt="" />
	<span>NOS FICHES</span>
</div>
<div class="barre_bleu"></div>
<div class="block_list">
	<?php
	for ($i = 0; $i < 10; $i ++)
	{
		?>
		<div class="element">
			<img style="height:240.453px;" />
			<div class="masque reserved">
				<img src="<?=$this->getPath()?>img/Cadenas-closed-Blanc.svg" alt="" />
				<span>RÉSERVÉ AUX CLIENTS MEILLEURESCPI.COM</span>
			</div>
		</div>
		<?php
	}
	?>
</div>

