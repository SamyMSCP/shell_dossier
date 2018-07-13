<?php

// Si le client tente d'acceder a cette page alors qu'il est deja connecté on le redirige vers le tableau de bord
if (!empty($_COOKIE['token']) && check_fraude($_COOKIE['token']) && !check_code($_COOKIE['token']))
{
	$dh = Dh::getWithParam($_COOKIE['token'], $_COOKIE['login']);
	$params = [
		"IP" => $_SERVER['REMOTE_ADDR'],
		"userAgent" => $_SERVER['HTTP_USER_AGENT'],
		"details" => "Connexion avec code sms"
	];
	if ($dh->getConfirmation() == 0)
	{
		Logger::setNew("Numero de telephone valide", $dh->id_dh, $dh->id_dh, ["details" => "validation automatique lors de la connexion avec code sms"]);
		$dh->updateOneColumn("confirmation", 1);
	}
	else if ($dh->getConfirmation() == 2)
	{
		Logger::setNew("Numero de telephone valide", $dh->id_dh, $dh->id_dh, ["details" => "validation automatique lors de la connexion avec code sms"]);
		$dh->updateOneColumn("confirmation", 3);
	}
	Logger::setNew("Connexion front", $dh->id_dh, $dh->id_dh, $params);
	header('Location: ?p=TableauDeBord');
	exit();
}

// Le client viens de rmplirer le formulaire et tente de seconnecter
if ((!empty($_POST['login']) && !empty($token = login_client($_POST['login'], $_POST['pass']))) || (!empty($_COOKIE["mail"]) && !empty($_COOKIE["pass"]) && (login_client($_COOKIE["mail"], $_COOKIE["pass"]))))
{
	// Si il doit remplir le code sms pour passer a la suite ! on le redirige vers la page pour ca !
	if (scan_fraude($token))
	{
	/*
		$dh = Dh::getWithParam(ft_crypt_information($token), ft_crypt_information($_POST["login"]));
		$params = [
			"IP" => $_SERVER['REMOTE_ADDR'],
			"userAgent" => $_SERVER['HTTP_USER_AGENT'],
			"details" => "connexion sans validation par code sms"
		];
		Logger::setNew("Connexion front", $dh->id_dh, $dh->id_dh, $params);
		*/
		header('Location: ?p=Index&security=' . ft_crypt_information($token));
		exit();
	}
	else
	// Si il a renseigné le code sms ou qu'il n'a pas besoin de le faire on le connecte
	{
		// Si se connecte
		$dh = Dh::getWithParam(ft_crypt_information($token), ft_crypt_information($_POST["login"]));
		$params = [
			"IP" => $_SERVER['REMOTE_ADDR'],
			"userAgent" => $_SERVER['HTTP_USER_AGENT'],
			"details" => "connexion sans validation par code sms"
		];
		Logger::setNew("Connexion front", $dh->id_dh, $dh->id_dh, $params);
		header('Location: index.php?p=TableauDeBord');
    }
}
elseif (empty($GLOBALS['GET']['security']) && !empty($_POST['login']))
{
	header('Location: ?p=Index&error=' . bin2hex(random_bytes(42)));
}

$this->loadModule("Connexion", "Connexion", array());

$this->loadModule("mentions", "MessageInformation", array(
	"title" => "Meilleurescpi.com - Mentions légales",
	"path" => $this->getPath() . "mentions.php",
	"tag" => "mentions",
	)
);

$this->loadModule("contact", "MessageInformation", array(
	"title" => "Meilleurescpi.com - Nous contacter",
	"path" => $this->getPath() . "contact.php",
	"tag" => "contact",
	)
);

$this->loadModule("cq", "MessageInformation", array(
	"title" => "Meilleurescpi.com - Sécurité",
	"path" => $this->getPath() . "cq.php",
	"tag" => "cq",
	)
);

if (!empty($_SESSION['okpass']))
{
	$_SESSION['okpass'] = 0;
	echo '<div class="alert alert-success"><strong>INFORMATION : </strong>Votre nouveau mot de passe a bien été pris en compte. Il est effectif dès maintenant.</div>';
}

if (!empty($GLOBALS['GET']['confirmation']))
{
	$dh = new Dh();

	if (($id = $dh->validateMail($GLOBALS['GET']['confirmation'])))
	{
		Logger::setNew("Adresse mail confirmee", $id,  $id, []);
		echo '<div class="alert alert-success"><strong>INFORMATION : </strong>Mail confirmé.</div>';
	}
	else
		$msg = "Une erreur est survenue";
}

if (!empty($GLOBALS['GET']['reset']) && !reset_to_change_pass($GLOBALS['GET']['reset'], 0))
{
	$_SESSION['okpass'] = 1;
	header('Location: index.php?ok=1');
}

if (!empty($_POST['mail_reset']) && filter_var($_POST['mail_reset'], FILTER_VALIDATE_EMAIL))
{
	//$tab = get_dh_mail();
	$dh = Dh::getByLogin($_POST['mail_reset']);
	if (empty($dh))
	{
		echo '<div class="alert alert-danger"><strong>ERREUR :</strong> Votre adresse mail nous est inconnue, merci de vérifier vos informations.</div>';
		//return (-2);
	}
	else if (check_time_reset_pass($_POST['mail_reset']))
	{
		echo '<div class="alert alert-warning"><strong>SÉCURITÉ :</strong> Cette action est impossible. Une procédure de récupération de votre mot de passe a déjà été effectuée il y a moins de deux heures. Merci de contacter nos services pour plus d\'informations.</div>';
		//return (-1);
	}
	else
	{
		echo '<div class="alert alert-success"><strong>PROCÉDURE :</strong> Merci de consulter vos E-mails afin de commencer la procédure de récupération de votre mot de passe.</div>';
		$dh[0]->loosePasswordProcedure();
	}

	//$res = reset_password($_POST['mail_reset']);
	/*
	if (!$res)
	else if ($res == -1)
	else
	*/
}
if (empty($GLOBALS['GET']['security']) && !empty($GLOBALS['GET']['logout']))
{
	if (empty(Dh::getCurrent()))
	{
		header('Location: index.php');
		exit();
	}
	Logger::setNew("Deconnexion front", Dh::getCurrent()->id_dh, Dh::getCurrent()->id_dh, []);
	if (check_token(ft_crypt_information($GLOBALS['GET']['logout'])))
	{
		del_cookie(array('login', 'token'));
		del_all_cookie();
		destroy_token($GLOBALS['GET']['logout']);
		Notif::set("deconnexion", "Toute l'équipe de Meilleurescpi.com vous remercie pour votre visite, à bientôt !");
		header('Location: index.php');
		exit();
		//$msg = "Toute l'équipe de Meilleurescpi.com vous remercie pour votre visite, à bientôt !";
	}
}
else if (empty($GLOBALS['GET']['security']) && check_token())
	header('Location: index.php?p=TableauDeBord');
// else if (!(empty($_SESSION["mail"]) && empty($_SESSION["pass"])) || empty($GLOBALS['GET']['security']) && !empty($_POST['login']) && strlen($_POST['login']) < 1024 && filter_var($_POST['login'], FILTER_VALIDATE_EMAIL) && !empty($_POST['pass']) && strlen($_POST['pass']) < 1024)
// {

