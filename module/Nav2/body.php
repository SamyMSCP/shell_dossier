<div class="navBack"></div>
<div class="navBarOut">
		<div class="navBarBlueBar">	</div>
	<div class="navBar">
		<a class="nav-logo" href="index.php?p=TableauDeBord">
			<img class="navLogo" src="<?=$this->getPath()?>img/MS-Logo-RVB.svg" alt="logo">
		</a>
		<div class="nav-block-right">
			<div class="nav-top">
				<div class="nav-msg">
					<span class="NavTxt">VERSION BETA</span> <a class="NavTxt" style="cursor: pointer;" data-dismiss="modal" data-toggle="modal" data-target=".modal_avis"><img src="<?=$this->getPath()?>img/Ampoule-Blanc.svg" alt=""/> AVEZ VOUS DES SUGGESTIONS ?</a>
				</div>
				<div class="navUser" id="getSizeName">
					<span class="dropdown-toggle NavTxt" data-toggle="dropdown"  aria-expanded="true" ><?=$this->dh->getPersonnePhysique()->getCiviliteFormat()?> <span class="firstname NavTxt"><?=ucfirst($this->dh->getPersonnePhysique()->getFirstName())?></span> <?=strtoupper($this->dh->getPersonnePhysique()->getName())?></span>
					<img class="navFlechBas" data-toggle="dropdown" aria-expanded="true" src="<?=$this->getPath()?>img/FlecheBas-Blanc.svg" alt="Fleche bas du nom du collaborateur" />
					<ul class="dropdown-menu" style="left: inherit; right: 0px;" id="setSizeHiddenMenu">
						<?php include("menu.php"); ?>
					</ul>
				</div>
			</div>
			<?php //$stroverlay = ' "onmouseover="this.className += \' btn-selected\'" onmouseout="this.classList.remove(\'btn-selected\')'; ?>
			<?php $stroverlay = ''; ?>
			<div class="nav-bottom">
				<div class="nav-btn-block">
					<button id="hamburger-toggle"class="dropdown-toggle hamburger hamburger--collapse nav-btn-compte" type="button" data-toggle="dropdown" aria-expanded="true">
						<span class="hamburger-box">
						<span class="hamburger-inner"></span>
						</span>
					</button>
					<ul class="dropdown-menu" style=" max-width: 400px; width: 100%; ">
						<?php include("menu.php"); ?>
					</ul>
					<?php
					/*
					<div class="nav-btn nav-btn-compte">
						<img style="height: 40px; width: 40px; margin-left: auto; margin-right: auto;" src="<?=$this->getPath()?>img/Gender_Homme.png" data-toggle="dropdown" aria-expanded="true">
					</div>
					*/
					?>
					<div class="nav-btn nav-btn-accueil<?php if ($GLOBALS['GET']['p'] == "TableauDeBord") echo " btn-selected"; else echo $stroverlay; ?>">
						<a class="linkBarNav" href="?p=TableauDeBord">
								<div></div>
							<span class="NavTxt">TABLEAU DE BORD</span>
						</a>
					</div>
					<div class="nav-btn nav-btn-monPortefeuille<?php if ($GLOBALS['GET']['p'] == "Portefeuille") echo " btn-selected"; else echo $stroverlay; ?>">
						<a class="linkBarNav" href="?p=Portefeuille">
							<div></div>
							<span class="NavTxt">MON PORTEFEUILLE</span>
						</a>
					</div>
					<?php
					/*
					<div class="nav-btn nav-btn-Actualite<?php if ($GLOBALS['GET']['p'] == "Actu") echo " btn-selected"; else echo $stroverlay; ?>">
						<a class="linkBarNav" href="?p=Actu">
							<div></div>
							<span class="NavTxt">ACTUALITÉS</span>
						</a>
					</div>
					*/
					if ($this->dh->phoneOk())
					{
						?>
						<div class="nav-btn nav-btn-Opportunite<?php if ($GLOBALS['GET']['p'] == "Opportunity") echo " btn-selected"; else echo $stroverlay; ?>">
							<a class="linkBarNav" href="?p=Opportunity">
								<div></div>
								<span class="NavTxt">OPPORTUNITÉS</span>
							</a>
						</div>
						<?php
					}
					else
					{
						?>
						<div class="nav-btn nav-btn-Opportunite<?php if ($GLOBALS['GET']['p'] == "Opportunity") echo " btn-selected"; else echo $stroverlay; ?>">
							<a class="linkBarNav" onclick="msgBox.show('Cette page est accessible uniquement aux clients ayant validé leur numéro de téléphone par sms.')">
								<div></div>
								<span class="NavTxt">OPPORTUNITÉS</span>
							</a>
						</div>
						<?php
					}
					?>
					<div class="nav-btn nav-btn-Bibliotheque<?php if ($GLOBALS['GET']['p'] == "Bibliotheque") echo " btn-selected"; else echo $stroverlay; ?>">
						<a class="linkBarNav" href="?p=Bibliotheque">
							<div></div>
							<span class="NavTxt">BIBLIOTHÈQUE</span>
						</a>
					</div>
                    <div class="nav-btn nav-btn-Bibliotheque<?php if ($GLOBALS['GET']['p'] == "Badges") echo " btn-selected"; else echo $stroverlay; ?>">
                        <a class="linkBarNav" href="?p=Badges">
                            <div></div>
                            <span class="NavTxt">BADGES</span>
                        </a>
                    </div>
					<?php
					if (!isProd())
					{
						/*
						<div class="nav-btn nav-btn-mesProjets<?php if ($GLOBALS['GET']['p'] == "ListeProjets") echo " btn-selected"; else echo $stroverlay; ?>">
							<a href="?p=ListeProjets"  class="linkBarNav">
								<div></div>
								<span class="NavTxt">MES PROJETS</span>
							</a>
						</div>
						*/
					}
					/*
					*/
					?>
				</div>
				<?php
				if (!isProd())
				{
					?>
					<div class="navCreate">
						<button onclick="location.href='?p=CreationProjet'" class="NavTxt">CRÉER UN PROJET</button>
					</div>
					<?php
				}
				?>
			</div>
		</div>
	</div>
</div>

<div class="modal fade modal_avis" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
	 <div class="modal-dialog">
		<div class="modal-content" style="background-color: #EBEBEB;">
			<form method="post">
			<input type="hidden" name="token" id="token" value="<?php echo $_SESSION['csrf'][0]; ?>"/>
				<div class="modal-header">
		    		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" style="text-align: center;">MeilleureSCPI.com - Un avis à nous transmettre ?<h4>
				</div>
				<div class="modal-body">
					<h5>Vous êtes un client BETA testeur du compte client MeilleureSCPI.com</h5>
					<p>Aidez-nous à améliorer votre outil d'analyse en nous transmettant votre avis. Merci.</p>
					<div style="font-weight: bold;">
						<div class="form-group">
							<textarea class="form-control" name="avis" minlength="10" required="1" placeholder="" style="resize: none; width: 100%;"></textarea>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button name="send" class="btn-mscpi btn-orange" value="2">Envoyer</button>
					<button type="button" class="btn-mscpi" data-dismiss="modal">Fermer</button>
				</div>
			</form>
		</div>
	</div>
</div>
