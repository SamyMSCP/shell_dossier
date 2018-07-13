<div class="blockTitle">
	<img class="logo_title" src="<?=$this->getPath()?>img/Guide-BleuClair.svg" alt="" />
	<span>NOS GUIDES</span>
</div>
<div class="barre_bleu"></div>
<div class="block_list">
<?php
	foreach ($this->listGuides as $key => $elm)
	{
		if ($elm->not_online)
			continue;
		if (!$this->dh->isValide() )
		{
			?>
			<div class="element" onclick="msgBox.show('Bonjour, afin de pouvoir consulter ces documents vous devez avoir validé votre adresse email et votre numéro de telephone.')">
				<?php
				if (empty($elm->img))
				{
					?>
					<img style="height:240.453px;" />
					<?php
				}
				else
				{
					?>
					<img src="<?=$this->getPath()?>img/<?=$elm->img?>" />
					<?php
				}
				?>
				<div class="masque reserved">
					<img src="<?=$this->getPath()?>img/Cadenas-closed-Blanc.svg" alt="" />
					<span>RÉSERVÉ AUX CLIENTS AYANT VALIDÉ LEURS COORDONNÉES</span>
				</div>
			</div>
			<?php
		}
		else if ($this->dh->getType() != "client" && $elm->restrict_acces)
		{
			?>
			<div class="element" onclick="msgBox.show('Bonjour, ce document est accessible uniquement aux clients ayant souscrit par MeilleureSCPI.com. Si jamais vous avez souscrit par MeilleureSCPI.com et que ce message s’affiche, merci de nous contacter : contact@MeilleureSCPI.com')">
				<?php
				if (empty($elm->img))
				{
					?>
					<img style="height:240.453px;" />
					<?php
				}
				else
				{
					?>
					<img src="<?=$this->getPath()?>img/<?=$elm->img?>" />
					<?php
				}
				?>
				<div class="masque reserved">
					<img src="<?=$this->getPath()?>img/Cadenas-closed-Blanc.svg" alt="" />
					<span>RÉSERVÉ AUX CLIENTS MEILLEURESCPI.COM</span>
				</div>
			</div>
			<?php
		}
		else
		{
			?>
			<div class="element" onclick="window.open('<?=$elm->lnk?>?email_auto=<?=$this->dh->getLogin()?>', '_blank');setReadDoc(<?=$elm->id?>);">
				<?php
				if (empty($elm->img))
				{
					?>
					<img style="height:240.453px;" />
					<?php
				}
				else
				{
					?>
					<img src="<?=$this->getPath()?>img/<?=$elm->img?>" />
					<?php
				}
				?>
				<div class="masque">
					<span><?=$elm->name?></span>
					<button class="btn-mscpi btn-orange">CONSULTER</button>
				</div>
			</div>
			<?php
		}
	}
?>
</div>

<div class="blockTitle">
	<img class="logo_title" src="<?=$this->getPath()?>img/Publications-BleuClair.svg" alt="" />
	<span>NOS FICHES SCPI</span>
</div>
<div class="barre_bleu"></div>
<div class="block_list">
<?php
	foreach ($this->listFiches as $key => $elm)
	{
		if ($elm->not_online)
			continue;
		if (!$this->dh->isValide() )
		{
			?>
			<div class="element" onclick="msgBox.show('Bonjour, afin de pouvoir consulter ces documents vous devez avoir validé votre adresse email et votre numéro de telephone.')">
				<?php
				if (empty($elm->img))
				{
					?>
					<img style="height:240.453px;" />
					<?php
				}
				else
				{
					?>
					<img src="<?=$this->getPath()?>img/<?=$elm->img?>" />
					<?php
				}
				?>
				<div class="masque reserved">
					<img src="<?=$this->getPath()?>img/Cadenas-closed-Blanc.svg" alt="" />
					<span>RÉSERVÉ AUX CLIENTS AYANT VALIDÉ LEURS COORDONNÉES</span>
				</div>
			</div>
			<?php
		}
		else if ($this->dh->getType() != "client" && $elm->restrict_acces)
		{
			?>
			<div class="element" onclick="msgBox.show('Bonjour, ce document est accessible uniquement aux clients ayant souscrit par MeilleureSCPI.com. Si jamais vous avez souscrit par MeilleureSCPI.com et que ce message s’affiche, merci de nous contacter : contact@MeilleureSCPI.com')">
				<?php
				if (empty($elm->img))
				{
					?>
					<img style="height:240.453px;" />
					<?php
				}
				else
				{
					?>
					<img src="<?=$this->getPath()?>img/<?=$elm->img?>" />
					<?php
				}
				?>
				<div class="masque reserved">
					<img src="<?=$this->getPath()?>img/Cadenas-closed-Blanc.svg" alt="" />
					<span>RÉSERVÉ AUX CLIENTS MEILLEURESCPI.COM</span>
				</div>
			</div>
			<?php
		}
		else
		{
			?>
			<div class="element" onclick="window.open('<?=$elm->lnk?>?email_auto=<?=$this->dh->getLogin()?>', '_blank');setReadDoc(<?=$elm->id?>);">
				<?php
				if (empty($elm->img))
				{
					?>
					<img style="height:240.453px;" />
					<?php
				}
				else
				{
					?>
					<img src="<?=$this->getPath()?>img/<?=$elm->img?>" />
					<?php
				}
				?>
				<div class="masque">
					<span><?=$elm->name?></span>
					<button class="btn-mscpi btn-orange">CONSULTER</button>
				</div>
			</div>
			<?php
		}
	}
?>
</div>

<div class="blockTitle">
	<img class="logo_title" src="<?=$this->getPath()?>img/Publications-BleuClair.svg" alt="" />
	<span>NOS FICHES SCPI FISCALES</span>
</div>
<div class="barre_bleu"></div>
<div class="block_list">
<?php
	foreach ($this->listFichesFiscales as $key => $elm)
	{
		if ($elm->not_online)
			continue;
		if (!$this->dh->isValide() )
		{
			?>
			<div class="element" onclick="msgBox.show('Bonjour, afin de pouvoir consulter ces documents vous devez avoir validé votre adresse email et votre numéro de telephone.')">
				<?php
				if (empty($elm->img))
				{
					?>
					<img style="height:240.453px;" />
					<?php
				}
				else
				{
					?>
					<img src="<?=$this->getPath()?>img/<?=$elm->img?>" />
					<?php
				}
				?>
				<div class="masque reserved">
					<img src="<?=$this->getPath()?>img/Cadenas-closed-Blanc.svg" alt="" />
					<span>RÉSERVÉ AUX CLIENTS AYANT VALIDÉ LEURS COORDONNÉES</span>
				</div>
			</div>
			<?php
		}
		else if ($this->dh->getType() != "client" && $elm->restrict_acces)
		{
			?>
			<div class="element" onclick="msgBox.show('Bonjour, ce document est accessible uniquement aux clients ayant souscrit par MeilleureSCPI.com. Si jamais vous avez souscrit par MeilleureSCPI.com et que ce message s’affiche, merci de nous contacter : contact@MeilleureSCPI.com')">
				<?php
				if (empty($elm->img))
				{
					?>
					<img style="height:240.453px;" />
					<?php
				}
				else
				{
					?>
					<img src="<?=$this->getPath()?>img/<?=$elm->img?>" />
					<?php
				}
				?>
				<div class="masque reserved">
					<img src="<?=$this->getPath()?>img/Cadenas-closed-Blanc.svg" alt="" />
					<span>RÉSERVÉ AUX CLIENTS MEILLEURESCPI.COM</span>
				</div>
			</div>
			<?php
		}
		else
		{
			?>
			<div class="element" onclick="window.open('<?=$elm->lnk?>?email_auto=<?=$this->dh->getLogin()?>', '_blank');setReadDoc(<?=$elm->id?>);">
				<?php
				if (empty($elm->img))
				{
					?>
					<img style="height:240.453px;" />
					<?php
				}
				else
				{
					?>
					<img src="<?=$this->getPath()?>img/<?=$elm->img?>" />
					<?php
				}
				?>
				<div class="masque">
					<span><?=$elm->name?></span>
					<button class="btn-mscpi btn-orange">CONSULTER</button>
				</div>
			</div>
			<?php
		}
	}
?>
</div>
