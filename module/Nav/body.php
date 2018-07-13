<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
	<div class="container">
		<div class="navbar-header">
<!--		<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
				<span class="sr-only">Toggle navigation</span> 
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>-->
			<a class="pull-left" href="index.php"><img style="width: 183px;" src="<?=$this->getPath()?>img/logo-meilleurescpi.png" alt="logo"></a>
		</div>
		<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
			<a class="etreContacte" href="index.php?p=Accueil&help=<?=$_SESSION['anticsrf']?>"><div>ÊTRE CONTACTÉ(E) PAR MON CONSEILLER</div></a>
			 <ul class="nav navbar-nav">
			</ul>
		</div>
			<div class="pull-right" style="margin-top: -62px;">
				<div class="btn-group">
					<button class="btn btn-primary dropdown-toggle" style="background-color: #35617F;height: 34px;" data-toggle="dropdown" aria-expanded="true"><?php $tab = get_info_perso_phy(intval($this->dh->lien_phy));
						echo  ft_decrypt_crypt_information($tab['civilite']) === "Monsieur" ? "M. " . (strtoupper(htmlspecialchars(ft_decrypt_crypt_information($tab['nom'])))) : "Mme " . htmlspecialchars((strtoupper(ft_decrypt_crypt_information($tab['nom']))));
					?> <span class="caret"></span></button>
						<ul class="dropdown-menu" style="left: inherit; right: 0px;">
							<li style="cursor: pointer;"><a href="?p=TableauDeBord">Accueil</a></li>
							<li style="cursor: pointer;"><a href="?p=Portefeuille">Mon portefeuille</a></li>
							<li style="cursor: pointer;"><a data-toggle="modal" data-target=".modal_set"> Modifier mon profil</a></li>
							<li style="cursor: pointer;"><a href="?p=MonPorteFeuille&help=<?=$_SESSION['anticsrf']?>"> Être contacté par mon conseiller</a></li>
							<li class="divider"></li>
    							<li><a <?php echo 'href="?logout=' . $_COOKIE['token'] . '"'; ?>> Déconnexion</a></li>
						</ul>
				</div>
			</div>
	</div>
</nav>
