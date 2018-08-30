	<?php
	if (!empty($_POST['pass']) && !empty($_POST['pass2']) && !empty($_POST['oldpass']) && $_POST['pass2'] === $_POST['pass'] && !check_mdp($_POST['pass'])){
		if (!change_pass($this->dh->id_dh, ft_crypt_pass($_POST['pass']), 1, ft_crypt_pass($_POST['oldpass'])))
		{
			echo '<div class="alert alert-success"><strong>Effectué !</strong> La modification de votre mot de passe a été prise en compte.</div>';
			Logger::setNew("Mot de passe change", $this->dh->id_dh, $this->dh->id_dh, []);
		}
		else
			echo '<div class="alert alert-warning"><strong>Oups ...</strong> Il semble que les informations renseignées soient incorrectes, merci de réessayer.</div>';
	}

if (!empty($_POST['ask_isf']) && !empty($_POST['isf']))
{
	$isf = ($_POST['isf'] == "yes") ? 1 : 0;
	if ($this->dh->isf !== $isf)
	{
		$this->dh->updateOneColumn("isf", $isf);
		Logger::setNew("Changement assujettissement IFI", Dh::getCurrent()->id_dh, $this->dh->id_dh, ["valeur" => ($isf)? "oui" : "non"]);
	}
}
	//if (empty($_SESSION["notiftime"]))
	//	$_SESSION["notiftime"] = 1;
	//elseif (!empty($GLOBALS['GET']['notiftime']))
	//	$_SESSION["notiftime"] = $GLOBALS['GET']['notiftime'];
if (!in_array($GLOBALS['GET']['p'],["CreationProjet","ListeProjets","InfoProjet","ResetProfil", "Opportunity"]))
{
	if (!empty($GLOBALS['GET']['confirmation']))
	{
		if ($GLOBALS['GET']['confirmation'] == 1 && !$this->dh->mailOk())
		{
			echo '<div class="alert alert-success"><strong>Effectué !</strong> Un e-mail de confirmation vous a été envoyé.</div>';
			$this->dh->sendMailConfirmation();
		}
		else if ($this->dh->validateMail($GLOBALS['GET']['confirmation']))
		{
			// Insérer un log pour dir que l'adresse email à été confirmée
			Logger::setNew("Adresse mail confirmee", $this->dh->id_dh, $this->dh->id_dh, []);
			echo '<div class="alert alert-success"><strong>INFORMATION : </strong>Mail confirmé.</div>';
		}
	}
	elseif (!$this->dh->isValide())
	{
		if (!$this->dh->mailOk())
		{
		echo '<div class="alert alert-warning fade in">
			<a href="" class="close" data-dismiss="alert" aria-label="close" onclick="ft_notif_stop(1)">&times;</a>
			<strong>Votre adresse E-mail n\'est pas encore validée. </strong>
			Recevoir un E-mail pour valider votre compte <a href="?p=' . $GLOBALS['GET']["p"] . '&confirmation=1">Cliquez ici</a></div>';
		}
	}
	if (!$this->dh->phoneOk())
	{
		echo '<div class="alert alert-warning fade in">
		<a href="" class="close" data-dismiss="alert" aria-label="close" onclick="ft_notif_stop(1)">&times;</a>
		<strong>Votre numéro de téléphone portable n\'est pas encore validé. </strong>
		Recevoir un SMS pour valider votre compte. <a href="?p=' . $GLOBALS['GET']["p"] . '&confirmation=2">Cliquez ici</a></div>';
	}
}
	if ($this->table['precalcul']['flagMissingInfo'] == true && $GLOBALS['GET']['p'] != "CreationProjet" && $GLOBALS['GET']['p'] != "ListeProjets" && $GLOBALS['GET']['p'] != "InfoProjet" && $GLOBALS['GET']['p'] != "ResetProfil" && $GLOBALS['GET']['p'] != "Opportunity" )
	{
		?>
		<div id="" class="alert alert-warning fade in lstTransactionNotComplete">
			<a href="" class="close" data-dismiss="alert" aria-label="close" onclick="ft_notif_stop(1)">&times;</a>
			<?php
			ob_start();
			?>
			<ul>
			<?php
				$compteur = 0;
				foreach($this->table as $key => $value) {
					if ($key == 'precalcul')
						continue ;
					if ($value['precalcul']['flagMissingInfo']) {
						foreach($value as  $key2 => $value2 ) {
							if ($key2 == 'precalcul')
								continue ;
							if ($value2['precalcul']['flagMissingInfo']) {
								$compteur++;
							if ($key2 === "Pleine") {
								$typePro = " - Pleine propriété";
							}
							else if ($key2 === "Usu") {
								$typePro = " - Usufruit";
							} else {
								$typePro = " - Nue propriété";
							}
								if ($GLOBALS['GET']['p'] == 'Portefeuille') {
								?>
								<?php $id_trans = key($value2); ?>
								<!-- <li v-if="this.$store"v-for="el in this.$store.transactionsList">
									<span class="btn btn-link" @click="$store.commit('CHANGE_SELECTED', el.id)">{{el.scpi}} - {{el.type_pro}}</span>
								</li> -->
								<li><span class="btn btn-link" onclick='showModalTransaction(<?=$id_trans?>)'><?= $key ?><?= $typePro ?></span></li>
							<?php
								} else {
								?>
								<?php $id_trans = key($value2); ?>
								<!-- <li><span class="btn btn-link"><?=$key?></span></li> -->
								<li><a href="?p=Portefeuille&mod=<?=$id_trans?>" class="link_set_date"><?=$key?> <?=$typePro?></a></li>
								<?php 
								}
							}
						}
					}
				}
			?>
			</ul>
			<?php
			$tmpp = ob_get_contents();
			ob_end_clean();
			?>

			<strong>Certaines informations n'ont pas été renseignées pour <?php if ($compteur <= 1) echo "la transaction suivante"; else echo "les transactions suivantes" ?> : </strong>
			<?=$tmpp?>
		</div>
		<?php
	}
	if (!empty($GLOBALS['GET']['confirmation']) && $GLOBALS['GET']['confirmation'] == 2
		&& !$this->dh->phoneOk()
		//|| !empty($_POST['tel_c']) && ft_decrypt_crypt_information($infoper['telephone']) !== $_POST['tel_c'])
	){
		if (empty($_SESSION['code']) || ($_SESSION['last_send'] + 5 * 60 < time()))
		{
			$code = mt_rand(1000, 9999);
			$_SESSION['code'] = $code;
			$_SESSION['last_send'] = time();
			$_SESSION['validation'] = true; //non je ne souhaite pas changer de numero de telephone (voir model.php)";
			$_SESSION['mail'] = $this->dh->getLogin();

			/*if (empty($_POST['tel_c'])){
				$_SESSION['n_tel'] = ft_decrypt_crypt_information($infoper['telephone']);
				$_SESSION['validation'] = "42";
				$_SESSION['mail'] = $tab_id_dh['login'];
			}
			else
				$_SESSION['n_tel'] = $_POST['tel_c'];*/
				// Ne pas dépasser 80 caractères dans le sms msinon il coutera 2 sms.

/*
			send_sms($_SESSION['n_tel'], "Bonjour, votre code de confirmation est : ", $tmp);
			log_activity($tab_id_dh['id_dh'], "Changement de numero", ft_decrypt_crypt_information($infoper["telephone"]));
*/			if (SmsSender::sendToDhWithTemplateName($this->dh, "", $code, "setPhone"))
				$this->dh->updateOneColumn('code', $code);
			else
				$err = "Impossible d'envoyer le code";
		}
		?>
<div class="modal fade modal-mscpi" id="modal_push_tel"  tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title text-center">Information</h4>
				<div class="modal-trait"></div>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="desc text-center">Merci de rentrer le code de sécurité reçu :</div>
					<form class="form-horizontal" method="post">
						<input type="hidden" name="token" id="token" value="<?php echo $_SESSION['csrf'][0]; ?>"/>
						<fieldset>
							<div class="form-group">
								<label class="col-md-5 control-label" for="passwordinput">Code de sécurité :</label>
								<div class="col-md-5">
									<input id="passwordinput" name="code_s" type="text" placeholder="****" class="form-control input-md" required>
								</div>
							</div>
						</fieldset>
      					<div class="modal-footer">
							<button class="btn-mscpi" formaction="?p=<?=$GLOBALS['GET']['p']?>&cancel=num" formmethod="get" formnovalidate type="submit">FERMER</button>
    						<button id="send_info" name="send_info" class="btn-mscpi btn-orange">VALIDER</button>
      					</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
	<?php
	}
	else if ($this->dh->type === "client" && $this->dh->isf === null)
{
?>		<div class="modal fade modal_push_tel" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
			<div class="modal-dialog">
				<div class="modal-content">
  					<div class="modal-header">
 					    <h4 style="text-align: center;">MeilleureSCPI.com - Demande d'information</h4>
  					</div>
					<div class="traitOrange"></div>
					<form class="form-horizontal" method="post">
     					<div class="modal-body" style="
							font-family: ‘Open Sans’, sans-serif;
							font-weight: 400;
							font-size: 14px;
							color: #505050;
							text-align:center;
						">
							<input type="hidden" name="token" id="token" value="<?php echo $_SESSION['csrf'][0]; ?>"/>
							<input type="hidden" name="ask_isf" id="ask_isf" value="1"/>
							<fieldset>
								<div class="form-group text-center">
									<span class="col-md-5 col-md-offset-2">Êtes-vous assujettis à l'IFI ?</span>
									<label class="radio-inline col-md-1">
											<input type="radio" style="display: inline-block" name="isf" value="yes">Oui</label>
									<label class="radio-inline col-md-1">
											<input type="radio" style="display: inline-block" name="isf" value="no" checked>Non</label>
								</div>
							</fieldset>
						</div>
      					<div class="modal-footer">
    						<button id="send_info" name="send_info" class="btn-mscpi btn-orange">VALIDER</button>
      					</div>
					</form>
				</div>
			</div>
		</div>
<?php
}
	$tab_id_dh = get_my_dh(1);
if (!empty($_POST['mdp_1']) && !check_mdp($_POST['mdp_1']) && $tab_id_dh['mdp_tmp'] && !empty($_POST['mdp_2']) && $_POST['mdp_1'] == $_POST['mdp_2']){
	mdp_tmp($_POST['mdp_1']);
	//$GLOBALS['haveNotif'] = true;
	Logger::setNew("Mot de passe provisoire change", $this->dh->id_dh, $this->dh->id_dh, []);
	notification("Mot de passe provisoire changé");
}
elseif (!empty($_POST['mdp_1']) && !empty($_POST['mdp_2']) && $_POST["mdp_1"] != $_POST["mdp_2"])
	notification("Les mots de passe ne correspondent pas entre eux.");
else if(
	$tab_id_dh['mdp_tmp'] &&
	(
		!isset($GLOBALS['haveNotif']) ||
		$GLOBALS['haveNotif'] != true
	)
){
	$GLOBALS['haveNotif'] = true;
?>
		<div class="modal fade modal_push_tel" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" id="modalSetMdp">
			<div class="modal-dialog modal-lg" style="max-width: 740px;">
				<div class="modal-content" style="background-color:#EBEBEB;">
					<div class="modal-header">
						<h4 class="modal-title" style="text-align: center;">Changement de votre mot de passe provisoire</h4>
					</div>
					<div class="traitOrange"></div>
					<form class="form-horizontal" method="post">
						<div class="modal-body">
							<p style="text-align: center;">Votre mot de passe doit être composé de 8 à 42 caractères,<br />dont au moins une majuscule, une minuscule et un chiffre.</p>
								<input type="hidden" name="token" id="token" value="<?= $_SESSION['csrf'][0]; ?>"/>
								<div class="form-set-mdp">
									<div class="form-group">
										<label class="labelForm control-label" for="passwordinput">Nouveau mot de passe</label>
										<div class="inputForm">
											<input id="passwordinput" name="mdp_1" type="password" placeholder="****" class="form-control" required
												onchange="this.setCustomValidity(this.validity.patternMismatch ? 'Mot de passe non conforme' : ''); if(this.checkValidity()) form.mdp_2.pattern = this.value; console.log(form.mdp_2.pattern);" pattern="^(?=.*\d)(?=.*[a-z])(?=.{8,42})(?=.*[A-Z])(?!.*\s).*$" title="8 à 42 caractères, dont une majuscule, une minuscule et un chiffre.">
										</div>
									</div>
									<div class="form-group">
										<label class="labelForm control-label" for="passwordinput">Confirmation mot de passe</label>
										<div class="inputForm">
											<input id="pass2" class="form-control" name="mdp_2" type="password" placeholder="****"  required
												onchange="this.setCustomValidity(this.validity.patternMismatch ? 'Les mots de passe ne correspondent pas.' : '');" pattern="^(?=.*\d)(?=.*[a-z])(?=.{8,42})(?=.*[A-Z])(?!.*\s).*$" title="8 à 42 caractères, dont une majuscule, une minuscule et un chiffre.">
										</div>
									</div>
								</div>
							</div>
							<div class="modal-footer">
								<div class="align-btn-center">
									<button id="send_info" name="mdp_info" class="btn-change-pass btn-mscpi">Valider</button>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
<?php
}
/*
?>

		<div >
			<div class="name">
				<h2 style="text-align: left;"><?php
				 $tab = $infoper;
				 echo ft_decrypt_crypt_information($tab['civilite']) === "Monsieur" ? "M. " . ucwords(strtolower(htmlspecialchars(ft_decrypt_crypt_information($tab['prenom']))), "-") . " " . htmlspecialchars(strtoupper(ft_decrypt_crypt_information($tab['nom']))) : "Mme " . htmlspecialchars(ucwords(strtolower(ft_decrypt_crypt_information($tab['prenom'])), "-") . " "  . htmlspecialchars(strtoupper(ft_decrypt_crypt_information($tab['nom']))));
				?> <!-- <img data-toggle="modal" data-target=".modal_set" src="../img/picto-profil-nonactif.png" class="params" style="cursor:pointer;"> 
				<a <?php echo 'href="index.php?logout=' . $_COOKIE['token'] . '"'; ?>><img src="../img/door.ico" style="width: 55px; margin-left: 20px;"></a>-->
				</h2>
			</div>
			<?php if (get_log($dh))
					echo "<p style=\"font-size : 17px;\">Ma dernière connexion date du " . date_fr(strftime("%d %B %Y", get_log($dh))) . "</p>";
				else
					echo "<p style=\"font-size : 17px;\">Bienvenue chez MeilleureSCPI.com</p>";
				?>
				<img src="<?= $this->getPath() ?>img/btn-projet.JPG" style="display:none; width: 300px;">
				<?php //echo '<a href="index.php?p=Accueil&help=' . $_SESSION['anticsrf'] . '"><img src="' . $this->getPath() . 'img/btn-cons.JPG" style="width: 300px; margin-top: 10px;"></a>'; ?>
		</div>

<?php
*/
	if (!empty($_POST['why']) && !empty($_POST['pass'])){
		if ($this->dh->password == ft_crypt_pass($_POST['pass']) && strlen($_POST['why']) >= 50){
			$this->dh->blockAccount($this->dh->id_dh, $_POST['why']);
			Logger::setNew('Desactivation compte', $this->dh->id_dh, $this->dh->id_dh, ['raison' => $_POST['why']]);
			header('Location: ?token=MeilleureSCPI.com');
			exit();
		}
	}
?>
<div class="modal fade modal_delcompte" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
	 <div class="modal-dialog">
		<div class="modal-content" style="background-color: #EBEBEB;">
     	<form method="post">
		<input type="hidden" name="token" id="token" value="<?php echo $_SESSION['csrf'][0]; ?>"/>
      		<div class="modal-header">
        		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
     			<h4 class="modal-title" style="text-align: center;">MeilleureSCPI.com - Suppression de votre compte<h4>
      		</div>
     		<div class="modal-body">
     			<h5>Pour confirmer la supression définitive de votre compte merci de renseigner votre mot de passe ci-dessous.</h5>
     			<div style="font-weight: bold;">
     				<h5></h5>
     				<p>Si jamais vous confirmez la suppression vous perdrez les données attachées à votre compte, l'analyse de vos parts de SCPI, l'accès à des données mises à jour régulièrement.</p>
     				<div class="form-group">
						<input style="width: 42%;" minlength="8" required="1" name="pass" type="password" placeholder="Mot de passe" class="form-control input-md"></input>
					</div>
     				<div class="form-group">
						<textarea class="form-control" name="why" minlength="50" required="1" placeholder="Pourquoi partir si vite ?" style="resize: none; width: 100%;"></textarea>
					</div>
					<p>N'hésitez pas à nous indiquer pour quelle(s) raison(s) vous souhaitez supprimer votre compte.</p>
     			</div>
     		</div>
      		<div class="modal-footer">
				<button name="byebyebye" class="btn-mscpi btn-orange" value="2">Nous dire aurevoir</button>
        		<button type="button" class="btn-mscpi" data-dismiss="modal">Fermer</button>
      		</div>
     	</form>
    	</div>
	</div>
</div>
<div class="modal fade modal_set" tabindex="-2" role="dialog" aria-labelledby="myLargeModalLabel">
	 <div class="modal-dialog modal-lg" style=" margin-top: 8vh;">
		<div class="modal-content">
      		<div class="modal-header">
        		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
     		   <h4 class="modal-title" style="text-align: center;">MeilleureSCPI.com - Mon compte<h4>
      		</div>
     		<div class="modal-body">
     			<div class="well">
     				<div class="row">
     					<div class="col-lg-8">
     						<form class="form-horizontal col_1" method="post">
		<input type="hidden" name="token" id="token" value="<?php echo $_SESSION['csrf'][0]; ?>"/>
								<fieldset>
									<legend>Mon Profil</legend>
										<div class="form-group">
											<label class="col-xs-5 control-label label-info_modal" style="font-family: 'Montserrat', sans-serif;">Civilité : </label>  
  											<div class="col-xs-4">
  												<label class="control-label" style="font-family: 'Montserrat', sans-serif;"><?php echo ft_decrypt_crypt_information($this->Pp->civilite);?></label>
 											</div>
										</div>
										<div class="form-group">
											<label class="col-xs-5 control-label label-info_modal" style="font-family: 'Montserrat', sans-serif;">Nom de famille : </label>  
  											<div class="col-xs-4">
  												<label class="control-label" style="font-family: 'Montserrat', sans-serif;"><?php echo ft_decrypt_crypt_information($this->Pp->nom);?></label>  
 											</div>
										</div>
										<div class="form-group">
											<label class="col-xs-5 control-label label-info_modal" style="font-family: 'Montserrat', sans-serif;">Prénom : </label>  
  											<div class="col-xs-4">
  												<label class="control-label" style="font-family: 'Montserrat', sans-serif;"><?php echo ft_decrypt_crypt_information($this->Pp->prenom);?></label>  
 											</div>
										</div>

<div id="indicanum" class="form-group">
  <label class="col-xs-5 control-label label-info_modal" for="indicatif" style="font-family: 'Montserrat', sans-serif;">Indicatif téléphonique :</label>
  <div class="col-xs-6">
	<select id="countries_phone1" class="form-control bfh-countries" data-country="FR">
		<?php
		include("listPays.php");
		?>
	</select>
  </div>
</div>




										<div class="form-group">
											<label class="col-md-5 control-label label-info_modal" style="font-family: 'Montserrat', sans-serif;">Téléphone : </label>  
  											<div class="col-md-4">
  												<input name="tel_c" id="tel" readonly="1" type="tel" class="form-control bfh-phone" data-country="countries_phone1"<?php echo ' value="'. ft_decrypt_crypt_information($this->Pp->telephone) . '">';?></input>
  												<span class="help-block">Ex : +33600000000</span>
 											</div>
										</div>
										<div class="form-group">
											<label class="col-md-5 control-label label-info_modal" style="font-family: 'Montserrat', sans-serif;">E-mail : </label>  
  											<div class="col-md-4">
  												<label class="control-label" style="font-family: 'Montserrat', sans-serif;"><?php echo ft_decrypt_crypt_information($this->Pp->mail); ?></label>  
 											</div>
										</div>

									<legend><h4>Changement de mot de passe</h4></legend>
										<div class="form-group">
											<label class="col-md-5 control-label label-info_modal" style="font-family: 'Montserrat', sans-serif;">Ancien mot de passe : </label>  
  											<div class="col-md-4">
  												<input name="oldpass" type="password" id="oldpass" readonly="1" placeholder="**********" class="form-control input-md">  
 											</div>
										</div>
										<div class="form-group">
											<label class="col-md-5 control-label label-info_modal" style="font-family: 'Montserrat', sans-serif;">Nouveau mot de passe : </label>  
  											<div class="col-md-4">
												<input id="pass" name="pass" readonly="1" type="password" placeholder="**********" class="form-control input-md">
 											</div>
 												<p class="pass_erreur1"><img style="width: 37px;" src="<?=$this->getPath()?>img/warning.ico">8 caractères sont nécessaires.</p>
												<p class="pass_erreur2"><img style="width: 37px;" src="<?=$this->getPath()?>img/warning.ico">Une majuscule est manquante.</p>
												<p class="pass_erreur3"><img style="width: 37px;" src="<?=$this->getPath()?>img/warning.ico">Une minuscule est manquante.</p>
												<p class="pass_erreur4"><img style="width: 37px;" src="<?=$this->getPath()?>img/warning.ico">Un chiffre est manquant.</p>
												<p class="success_1"><img style="width: 30px; margin-top: 2px;" src="<?=$this->getPath()?>img/valid.png"></p>
										</div>
										<div class="form-group">
											<label class="col-md-5 control-label label-info_modal" style="font-family: 'Montserrat', sans-serif;">Confirmez votre nouveau mot de passe : </label>  
  											<div class="col-md-4">
												<input id="pass2" name="pass2" readonly="1" type="password" placeholder="**********" class="form-control input-md">
 											</div>
 											<p class="help-block erreur5"><img style="width: 37px;" src="<?=$this->getPath()?>img/warning.ico"> Mot de passe incorrect.</p>
											<p class="help-block success_2"><img style="width: 30px;" src="<?=$this->getPath()?>img/valid.png"> Mot de passe correct.</p>
										</div>
<?php if ($this->dh->type !== null): ?>
										<legend><h4>Informations supplémentaires</h4></legend>

										<div class="form-group">
  											<input type="hidden" name="ask_isf" value="1">
											<label class="col-md-5 control-label label-info_modal" style="font-family: 'Montserrat', sans-serif;">Êtes-vous assujettis à l'IFI :</label>
											<div class="col-md-4 col-md-offset-1" style="padding-top: 8px;">
												<label class="radio-inline col-xs-2" style="margin-left: 18px;">
													<input type="radio" style="display: inline-block" name="isf" id="isf_yes" value="yes" <?php if ($this->dh->isf == "1") echo ' checked' ?> disabled>
													oui
												</label>
												<label class="radio-inline col-xs-2">
													<input type="radio" style="display: inline-block" name="isf" id="isf_no" value="no" <?php if ($this->dh->isf == "0") echo ' checked' ?> disabled >
													non
												</label>
											</div>
										</div>
<?php endif; ?>
								</fieldset>

     					</div>
     					<div class="col-lg-4 form-horizontal votreConsultant">
<?php
	
	$prenom = "Missing information";
	$nom = $prenom;
	$telephone = $prenom;
	$login = $prenom;
	if (!empty($this->dh->getConseiller())) {
		$prenom = $this->dh->getConseiller()->getPersonnePhysique()->getFirstName();
		$nom = $this->dh->getConseiller()->getPersonnePhysique()->getName();
		$telephone = $this->dh->getConseiller()->getPersonnePhysique()->getPhoneFixe();
		$login = $this->dh->getConseiller()->getLogin();
	}
?>
     						<legend style="white-space:nowrap;">
								<div style="width:80%; display:inline-block; text-align:right;">
									Votre consultant <!-- conseiller/conseillère plutôt, non ? -->
								</div>
							</legend>
							<?php
							/*
							<img style="width:100%; max-width: 300px;border-radius: 110px;" src="<?=$this->getPath()?>conseiller/<?php
								if ($this->dh->type == "yoda")
									echo "yoda.png";
								else
									echo $login .".jpeg";?>">
									*/
									?>
							<div class="form-group">
  								<div class="col-md-offset-4 col-md-6" style="text-align:left;">
									<label class="control-label" style="font-family: 'Montserrat', sans-serif;"><?=ucwords(strtolower(htmlspecialchars($prenom))) . " " . htmlspecialchars(strtoupper($nom))?></label>
 								</div>
							</div>
							<div class="form-group">
								<label class="col-md-5 control-label label-info_modal" style="font-family: 'Montserrat', sans-serif;">Ligne directe : </label>  
  								<div class="col-md-7" style="text-align:left;">
									<label class="control-label" style="font-family: 'Montserrat', sans-serif;"><?php 
										if ($telephone != "Missing information")
											echo get_display_num($telephone, $this->dh->getConseiller()->getPersonnePhysique()->getIndicatifPhoneFixe());
									?></label>
 								</div>
							</div>
							<div class="form-group">
								<label class="col-md-3 control-label label-info_modal" style="font-family: 'Montserrat', sans-serif;">E-mail : </label>  
  								<div class="col-md-9" style="text-align:left;">
									<label class="control-label" style="font-family: 'Montserrat', sans-serif;"><?=$login?></label>
 								</div>
							</div>
     					</div>
     				</div>
     			<div class="row">
     				<div class="col-md-4" style="text-align: right;">
						<div class="form-group">
							<div class="col-md-12" style="cursor: pointer; text-align: left;">
								<?php
									if (empty($this->dh->type) || $this->dh->type === "client")
									{
								?>
								<div style="display:inline-block; text-align:left;">
									<a data-dismiss="modal" data-toggle="modal" data-target=".modal_delcompte">
										Supprimer mon compte : <img style="width: 25px;" src="<?=$this->getPath()?>img/Remove.svg">
									</a>
								</div>
								<?php
									}
								?>
							</div>
						</div>
     				</div>
					<div class="col-md-offset-7 col-md-1" style="text-align: right;">
     					<img id="cadenas" onclick="lock_img()" style="width: 60px; cursor:pointer;" src="<?=$this->getPath()?>img/Cadenas-closed-BleuClair.svg">
     				</div>
     			</div>
     			</div>
     		</div>
      		<div class="modal-footer">
			<button id="button2id" style="display: none;" name="submit" class="btn-mscpi btn-orange">Modifier vos informations</button>
			</form>
        		<button type="button" class="btn-mscpi" data-dismiss="modal">Fermer</button>
      		</div>
    	</div>
	</div>
</div>
<?= $this->CentreInteretComponent ?>
