<header>
  <div class=" imgTop">
      <div style="position: absolute;width: 100%;text-align: center;">
          <div style="margin-top: 39px;">
        <h1>CRÉATION DE VOTRE COMPTE</h1>
          </div>
      </div>
      <img src="<?= $this->getPath() ?>img/header.jpg">
  </div>
</header>
      <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">
            <div class="navbar-header">
                <a class="pull-left" href="index.php">
                    <img src="<?= $this->getPath() ?>img/logo-meilleurescpi.png" alt="logo" style="margin-bottom: -1px;">
                </a>
            </div>
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            </div>
        </div>
    </nav>
<div class="mdlProgressBlock">
	<?=$this->ProgressBlock?>
</div>

<div class="container space-more">
	<div class="row">
		<div class="col-md-6">
			<h2 class="text-primary">
				MERCI !
			</h2>
			<p style="font-size: 1.7em; font-family: 'Raleway'";>Votre compte a bien été créé.</p>
		</div>
		<div class="col-md-6">
			<h3>C'est ici que<br>commence votre<br>épargne immobilière.</h3>
		</div>
		<form action="?p=<?php echo $GLOBALS['GET']['p']?>" method="post">
		<input type="hidden" name="token" id="token" value="<?php echo $_SESSION['csrf'][0]; ?>"/>
			<div class="row" style="margin-right:0px; margin-left:0px;">
				<div class="col-md-6">
					 <input id="button1id" class="toreturn" src="<?= $this->getPath() ?>img/moncompte.JPG" type="image" style="display: none;" name="getaccess" value="1"></input>
					<div class="forBtn" onClick="$('#button1id').trigger('click');" style="background-color: #ffffff ; border: solid 2px #01528A; max-width: 260px; height: 50px; text-align: center; color: #01528A; cursor:pointer; margin-right: auto; margin-left: auto;">
						<img style="width: 50px; padding: 0px; float: left;" src="<?= $this->getPath() ?>img/MS-CreationCompte-Visuels_Valider.png" />
						<p>CONNEXION A MON COMPTE</p>
					</div>
				</div>
				<div class="col-md-6">
					<input id="button2id" class="tosend" src="<?= $this->getPath() ?>img/conseiller.JPG" style="display: none;" type="image" name="helpme" value="2"></input>
					<div class="forBtn" id="resmarg" onClick="$('#button2id').trigger('click');" style="background-color: #ffffff ; border: solid 2px #01528A; max-width: 260px; height: 50px; text-align: center; color: #01528A; cursor:pointer; margin-right: auto; margin-left: auto">
						<img style="width: 50px; padding: 0px; float: left;" src="<?= $this->getPath() ?>img/MS-CreationCompte-Visuels_Calendrier.png" />
						<p>ETRE CONTACTE PAR<br>MON CONSEILLER</p>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>
<?php Notif::getAll(); ?>
