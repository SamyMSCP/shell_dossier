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
			 <ul class="nav navbar-nav">
			</ul>
		</div>
			<div class="pull-right" style="margin-top: -62px;">
				<div class="btn-group">
					<button class="btn btn-primary dropdown-toggle" style="background-color: #35617F;height: 34px;" data-toggle="dropdown" aria-expanded="true"><?php $tab = get_info_perso_phy(intval($this->dh->lien_phy));
						echo  ft_decrypt_crypt_information($tab['civilite']) === "Monsieur" ? "M. " . (strtoupper(htmlspecialchars(ft_decrypt_crypt_information($tab['nom'])))) : "Mme " . htmlspecialchars((strtoupper(ft_decrypt_crypt_information($tab['nom']))));
					?> <span class="caret"></span></button>
						<ul class="dropdown-menu" style="left: inherit; right: 0px;">
							<li style="cursor: pointer;"><a href="?p=FrontAccueil&client=<?=$GLOBALS['GET']['client']?>">Accueil</a></li>
							<li style="cursor: pointer;"><a href="?p=FrontMonPorteFeuille&client=<?=$GLOBALS['GET']['client']?>">Mon portefeuille</a></li>
						</ul>
				</div>
			</div>
	</div>
</nav>
