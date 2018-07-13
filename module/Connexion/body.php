<div class="cpos">
	<?php
	@session_start();
	if (empty($GLOBALS['GET']['security']))
	{
		?>
		<form class="form-signin mg-btm" method="post" action="index.php">
		<input type="hidden" name="token" id="token" value="<?php echo $_SESSION['csrf'][0]; ?>"/>
		<?php
	}
	else
	{
		if (empty($_COOKIE["token"]))
		{
			header("Location: .");
			exit();
		}
		?>
		<form class="form-signin mg-btm" method="post" action="?security=<?=$_COOKIE['token']?>">
		<input type="hidden" name="token" id="token" value="<?php echo $_SESSION['csrf'][0]; ?>"/>
		<?php
	}
	?>



	<img class="logoImg" src="<?= $this->getPath()?>img/logo-meilleurescpi.png" alt="logo MeilleureSCPI.com">

	<div class="main">

		<h3 style="text-align: center; color: #01528A; font-weight: bold; margin-bottom: 25px;">CONNEXION À VOTRE COMPTE</h3>

		<?php
		if (empty($GLOBALS['GET']['security']))
		{
			?>
			<div class="row formIn">
				<div class="col-xs-2" style="text-align:right;">
					<img src="img/picto-enveloppe.png" style="margin-top: 5px; margin-left: -16px; width: 30px;">
				</div>
				<div class="input-group col-xs-10">
					<input required="" type="email" class="form-control input-md" <?php if (!empty($GLOBALS['GET']['error'])) echo "class=\"error_b\"";?> name="login" placeholder="Adresse email">
				</div>
			</div>
			<?php
		}
		else if (!empty($_COOKIE['token']))
		{
			if (empty(get_info_perso_phy(get_my_dh())['telephone']))
			{
				header ("Location: .");
				exit();
			}
			if (isLocal() || Dh::getCurrent()->getPersonnePhysique()->getPhone() == "-")
			{
				// Si le numéro de téléphone n'est pas renseigné alors on propose le formulaire pour le renseigner
				Dh::getCurrent()->setConnected();
				header('Location: index.php?p=TableauDeBord');
				exit();
				//include('setPhone.php');
			}
			else
			{

				$num = ft_decrypt_crypt_information(get_info_perso_phy(get_my_dh())['telephone']);
				if ($num[0] !== '+')
					$num_tel = "+33" . substr($num, 1, 9);
				else
					$num_tel = $num;
				$code = rand(100000, 999999);
				//$sms_text = 'Bonjour, Pour acceder à votre compte, merci de saisir le code de sécurite : ' . $code;
				$sms_text = 'Bonjour, ' . $code .' est votre code pour accéder à MeilleureSCPI.com';
				set_code($_COOKIE['token'], $code);
				if (check_fraude($_COOKIE['token']))
				{
					require("../function/sms/ovh_sms.php");
				}
				?>

				<h4>Un code de sécurité a été envoyé <br>sur le numéro

				<?php
				$i=0;
				$tmp = substr(ft_decrypt_crypt_information(get_info_perso_phy(get_my_dh())['telephone']), 4);
				$tmp = intval(strlen($tmp)) - 2;
				//echo substr(ft_decrypt_crypt_information(get_info_perso_phy(get_my_dh())['telephone']), 0, 3);
				while ($i < $tmp)
				{
					echo " XX";
					$i += 2;
				}
				echo " " . substr(ft_decrypt_crypt_information(get_info_perso_phy(get_my_dh())['telephone']), 10);
				?>
				</h4>
			<?php
			}
		}
		else
		{
			header('Location: index.php');
			exit();
		}
		?>

		<div class="row formIn">

			<div class="col-xs-2" style="text-align:right;">
				<img src="img/Cadenas-closed-BleuMS.svg" style="margin-top: 0px; margin-left: -16px; width: 30px;">
			</div>

			<div class="input-group col-xs-10">
				<input
					<?php
					if (empty($GLOBALS['GET']['security']))
					{
						?>
						required=""
						type="password"
						<?php
					}
					else
					{
						?>
						type="text"
						<?php
					}
					?>
					class="form-control input-md"
					<?php
					if (!empty($GLOBALS['GET']['error']))
					{
						?>
						class="error_b"
						<?php
					}
					?>
					name="pass"
					placeholder="Mot de passe"
				>
			</div>
		</div>

		<?php
		if (!empty($GLOBALS['GET']['error']))
		{
			?>
			<div class="alert alert-danger">
				<p style="font-family: 'Roboto Condensed', sans-serif;">
					Combinaison identifiant/mot de passe incorrecte</br>Vous avez oublié vos identifiants ?
				</p>
			</div>
			<?php
		}
		?>

		<div class="row formBtn">

			<?php
			if (empty($GLOBALS['GET']['security']))
			{
				//if (!isProd())
				if (1)
				{
					// Avec la creation de compte
					?>
					<div class="col-md-6" style="text-align:center;">
					<?php
						if (empty($GLOBALS['GET']['security'])) {
							echo '<a href="index.php?p=CreationCompte" class="btn btn-primary" style="background-color: #01528A;width:100%;">CRÉATION DE COMPTE</a>';
						} elseif ((check_sms($_COOKIE['token']) + 1) > -1){
							echo '<a href="?logout=' . $_COOKIE['token'] . '" class="btn btn-warning"><span class="glyphicon glyphicon-user"></span> Déconnexion</a>';
						}
					?>
					</div>
					<div class="col-md-1" style="padding-left:0px;padding-right:0px;">
						<h2 style="margin-top: 0px;color: #01528A;text-align:center;">ou</h2>
					</div>
					<div class="col-md-5" style="text-align:center;">
					<?php
				}
				else
				{
					// Sans la creation de comptes
					?>
					<div class="col-md-12" style="text-align:center;">
					<?php
				}
				?>

					<button type="submit" class="btn btn-large btn-danger" style="width:100%;">SE CONNECTER</button>
				</div>
				<?php
			} 
			//	elseif ((check_sms($_COOKIE['token']) + 1) > -1)
				else if (1)
				{
					?>
					<div class="col-md-6 noInResponsive" style="text-align:center;">
						<button type="submit" class="btn btn-large btn-danger" style="width:100%;">SE CONNECTER</button>
					</div>
					<div class="col-md-6" style="text-align:center;">
						<a href="?logout=<?=ft_decrypt_crypt_information($_COOKIE['token'])?>" class="btn btn-warning"><span class="glyphicon glyphicon-user"></span> Déconnexion</a>
					</div>
					<div class="col-md-6 inResponsive" style="text-align:center;">
						<button type="submit" class="btn btn-large btn-danger" style="width:100%;">SE CONNECTER</button>
					</div>
					<?php
				}
/////////////////////////////////////////////////////////////////////////////////
				?>








		</div>

	<div class="rows">
		<div class="col-md-12" style="margin-bottom:20px;text-align:center;">
			<?php
			if (empty($GLOBALS['GET']['security'])){
			?>
				<a href="" data-toggle="modal" data-target="#myModal" class="red_dis">Mot de passe oublié ?</a>
			<?php
			} else {
				$num_sms = check_sms($_COOKIE['token']) + 1;
				if ($num_sms > -1) {
				?>
					<a class="red_dis" style="margin-left: -9px;"<?php echo 'href="index.php?security="' . $GLOBALS['GET']['security']; ?>>Envoyer un nouveau code</a><?php 
				}
			}
			?>
		</div>
	</div>
	<div class="infoNavigateur">
		Veuillez utiliser Google Chrome ou Mozilla Firefox pour une navigation optimisée
	</div>
          <?php
            if (!empty($GLOBALS['GET']['security']) && $num_sms < 0)
              echo '<div class="alert alert-warning"><strong>Info : </strong> Compte bloqué pendant 2 heures. Nouvel essai possible à  ' . date("H:i:s", $_SESSION['sms_time']) . '. MeilleureSCPI.com reste à votre disposition pour plus d\'informations.</div>';
           ?>
        </div>
		<div class="row">
          <div class="col-sm-4 bar-bor mentionCol">
            <a data-toggle="modal" data-target="#mentions" href="" class="red_dis mention">Mentions légales</a>
          </div>
          <div class="col-sm-4 bar-bor mentionCol">
            <a data-toggle="modal" data-target="#contact" href="" class="red_dis mention">Nous contacter</a>
          </div>
          <div class="col-sm-4 mentionCol">
            <a data-toggle="modal" data-target="#cq" href="" class="red_dis mention">Sécurité</a>
          </div>
		</div>
        <span class="clearfix"></span>  

      </form>
</div>

 <?php if (empty($GLOBALS['GET']['security'])) { ?>
 <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Meilleurescpi.com - Besoin d'aide ? | Mot de passe oublié</h4>
      </div>
      <div class="modal-body">
<form class="form-horizontal" method="post" action="index.php">
		<input type="hidden" name="token" id="token" value="<?php echo $_SESSION['csrf'][0]; ?>"/>
<fieldset>
<div class="form-group">
  <label class="col-md-4 control-label" for="textinput">E-mail : </label>  
  <div class="col-md-4">
  <input id="textinput" name="mail_reset" type="email" placeholder="mail@mail.com" class="form-control input-md" required="">
    
  </div>
</div>

</fieldset>
<p style="font-size: 10px;">L'Utilisateur du Site Internet reconnaît avoir vérifié que la configuration informatique utilisée ne contient aucun virus et qu'elle est en bon état de fonctionnement.<br>
L'Utilisateur reconnaît avoir été informé que le Site Internet est accessible 24h/24h et 7 jours/7 jours, à l'exception des cas de force majeure, difficultés informatiques, difficultés liées à la structure du réseau de télécommunication, autres difficultés techniques ou opérations de maintenance.<br>

MeilleureSCPI.com se réserve la possibilité d'interrompre, de suspendre momentanément ou de modifier sans préavis l'accès à tout ou partie du Site Internet, afin d'en assurer la maintenance, ou pour toute autre raison, sans que l'interruption n'ouvre droit à aucune obligation ni indemnisation.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn-mscpi" data-dismiss="modal">Fermer</button>
        <button type="submit" class="btn-mscpi btn-orange">Envoyer</button>
</form>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<?php } ?>

<?php if (!empty($GLOBALS['GET']['reset']) && !reset_to_change_pass($GLOBALS['GET']['reset'])) { ?>
 <div class="modal fade" id="oklmmmm" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Meilleurescpi.com - Changement de mot de passe</h4>
      </div>
      <div class="modal-body">
            <div id="loader">
                <img style="display: block; margin-left: auto; margin-right: auto;" src="img/loader.svg">
                
            </div>
            <div style="display:none;" id="infoid" class="animate-bottom">
              
<?php echo '<form class="form-horizontal" method="post" action="index.php?reset=' . $GLOBALS['GET']['reset'] . '">'; ?>
		<input type="hidden" name="token" id="token" value="<?php echo $_SESSION['csrf'][0]; ?>"/>
<fieldset>

<!-- Form Name -->


<!-- Password input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="pass">Mot de passe</label>
  <div class="col-md-4">
    <input id="cpass" name="cpass" type="password" placeholder="Mot de passe" class="form-control input-md" required="">
  </div>
    <p class="pass_erreur1"><img style="width: 30px; margin-left: -4px; margin-top: 2px;" src="img/warning.ico"> 8 caractères sont nécessaires.</p>
    <p class="pass_erreur2"><img style="width: 30px; margin-left: -4px; margin-top: 2px;" src="img/warning.ico">Une majuscule est manquante.</p>
    <p class="pass_erreur3"><img style="width: 30px; margin-left: -4px; margin-top: 2px;" src="img/warning.ico">Une minuscule est manquante.</p>
    <p class="pass_erreur4"><img style="width: 30px; margin-left: -4px; margin-top: 2px;" src="img/warning.ico">Un chiffre est manquant.</p>
    <p class="success_1"><img style="width: 30px; margin-left: 0px; margin-top: 2px;" src="img/valid.png"></p>
</div>

<!-- Password input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="pass2">Confirmer votre mot de passe</label>
  <div class="col-md-4">
    <input id="cpass2" name="cpass2" type="password" placeholder="*******" class="form-control input-md" required="">
  </div>
    <p class="help-block erreur5"><img style="width: 30px; margin-left: -4px; margin-top: 2px;" src="img/warning.ico">Mot de passe incorrect.</p>
    <p class="help-block success_2"><img style="width: 30px; margin-left: 0px; margin-top: 2px;" src="img/valid.png"> Mots de passe correct.</p>
</div>
<div>

</div>

<label class="col-md-4 control-label" for="pass2">Instructions</label>
<div class="col-md-8" style="padding-top:7px;padding-bottom:12px;">
	Le mot de passe doit comporter au moins :<br>
	1 Majuscule, 1 Miniscule, 1 Chiffre<br />
	et 8 caratères minimum.
</div>

<!-- Button -->
<div class="form-group">
  <label class="col-md-4 control-label" for="submit" style="margin-top:8px;">Valider</label>
  <div class="col-md-4">
    <button id="submit" name="submit" class="btn-mscpi">Modifier</button>
  </div>
</div>

</fieldset>
</form>



            </div>
      </div>
     <!--  <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
      </div> -->
    </div>
  </div>
</div>
<?php 
}
?>

<?php if (!empty($GLOBALS['GET']['reset']) && !reset_to_change_pass($GLOBALS['GET']['reset'])) { ?>
<div class="modal fade" id="oklmmmm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">Meilleurescpi.com - Changement de mot de passe</h4>
			</div>
			<div class="modal-body">
			<div id="loader">
				<img style="display: block; margin-left: auto; margin-right: auto;" src="img/loader.svg">
			</div>
			<div style="display:none;" id="infoid" class="animate-bottom">
				<?php echo '<form class="form-horizontal" method="post" action="index.php?reset=' . $GLOBALS['GET']['reset'] . '">'; ?>
				<fieldset>
				<!-- Form Name -->

				<!-- Password input-->
				<div class="form-group">
  <label class="col-md-4 control-label" for="pass">Mot de passe</label>
  <div class="col-md-4">
    <input id="pass" name="cpass" type="password" placeholder="Mot de passe" class="form-control input-md" required="">
  </div>
    <p class="pass_erreur1"><img style="width: 30px; margin-left: -4px; margin-top: 2px;" src="img/warning.ico"> 8 caractères sont nécessaires.</p>
    <p class="pass_erreur2"><img style="width: 30px; margin-left: -4px; margin-top: 2px;" src="img/warning.ico">Une majuscule est manquante.</p>
    <p class="pass_erreur3"><img style="width: 30px; margin-left: -4px; margin-top: 2px;" src="img/warning.ico">Une minuscule est manquante.</p>
    <p class="pass_erreur4"><img style="width: 30px; margin-left: -4px; margin-top: 2px;" src="img/warning.ico">Un chiffre est manquant.</p>
    <p class="success_1"><img style="width: 30px; margin-left: 0px; margin-top: 2px;" src="img/valid.png"></p>
</div>

<!-- Password input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="pass2">Confirmer votre mot de passe</label>
  <div class="col-md-4">
    <input id="pass2" name="cpass2" type="password" placeholder="*******" class="form-control input-md" required="">
  </div>
    <p class="help-block erreur5"><img style="width: 30px; margin-left: -4px; margin-top: 2px;" src="img/warning.ico">Mot de passe incorrect.</p>
    <p class="help-block success_2"><img style="width: 30px; margin-left: 0px; margin-top: 2px;" src="img/valid.png"> Mots de passe correct.</p>
</div>

<!-- Button -->
<div class="form-group">
  <label class="col-md-4 control-label" for="submit">Valider :</label>
  <div class="col-md-4">
    <button id="submit" name="submit" class="btn btn-primary">Modifier</button>
  </div>
</div>

</fieldset>
</form>



            </div>
      </div>
     <!--  <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
      </div> -->
    </div>
  </div>
</div>
<?php 
}
?>
