<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
	<div class="container">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="pull-left" href="admin_lkje5sjwjpzkhdl42mscpi.php?p=Accueil">
				<img src="img/logo-meilleurescpi.png" alt="logo">
			</a>
		</div>
		<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
			<ul class="nav navbar-nav">
				<li style="margin-left: 10px;"></li>
				<?php
				if (property_exists($this, "id") && $this->id != null) {
				?>
					<li>
						<a href=<?php echo "?p=Synthese&client=" . $this->id; ?>>Synthèse</a>
					</li>
					<li>
						<a href=<?php echo "?p=Coordonnees&client=" . $this->id; ?>>Coordonnées</a>
					</li>
					<li>
						<a href=<?php echo "?p=Documents&client=" . $this->id; ?>>Documents</a>
					</li>
					 <li>
						<a href=<?php echo "?p=Suivi&client=" . $this->id; ?>>Suivi</a>
					</li>
					<li>
						<a href=<?php echo "?p=PEC&client=" . $this->id; ?>>Projet en cours</a>
					</li>
					<li>
						<a href=<?php echo "?p=QSLM&client=" . $this->id; ?>>Questionnaire et situation</a>
					</li>
				   <li>
						<p class="navbar-btn">
							<a href=<?php print('"admin_lkje5sjwjpzkhdl42mscpi.php?logout=' . (ft_decrypt_crypt_information($_COOKIE['token'])) .'"'); ?> class="btn btn-warning">Logout !</a>
						</p>
					</li>
				<?php
				}
				else {
				?>
			  	</ul><div class="col-md-offset-7 col-md-2" style="margin-top: 14px;">
					<p class="navbar-btn">
					  <a href=<?php print('"admin_lkje5sjwjpzkhdl42mscpi.php?logout=' . (ft_decrypt_crypt_information($_COOKIE['token'])) .'"'); ?> class="btn btn-warning">Logout !</a>
					</p>
				
  				</div> <?php } ?>
		</div>
	</div>
</nav>
