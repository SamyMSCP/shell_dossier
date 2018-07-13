<?php
require_once("class/core/Page.php");
class CreationCompte extends Page
{
	public $title = "Création compte MeilleureSCPI.com";

	public function addNewUser() {

		// Verifier si l'adresse mail est renseignée
		if (!isset($_POST['mail']) || empty($_POST['mail']))
		{
			Notif::set('msgCreateAccount', 'Une erreure est survenue lors de la creation de compte');
			return (0);
		}
		$mail = strtolower(htmlspecialchars(trim($_POST['mail'])));
		
		// Verifier si l'adresse mail a un format valide.
		if (!filter_var($mail, FILTER_VALIDATE_EMAIL))
		{
			$_POST['mail'] = " ";
			Notif::set('msgCreateAccount', "L'adresse mail renseignée n'a pas un format valide ");
			return (0);
		}

		$domainCheck = MailSender::checkBann($_POST['mail']);
		if ($domainCheck != false)
		{
			$_POST['mail'] = " ";
			Notif::set('msgCreateAccount', "Le domaine $domainCheck n'est pas autorisé pour la création de compte");
			return (0);
		}

		// Verifier si l'adresse mail renseignée n'est pas deja utilisee.
		if (!empty(Dh::getByLogin($mail)))
		{
			$_POST['mail'] = " ";
			Notif::set('msgCreateAccount', 'Cette adresse email est déjà utilisée par un autre utilisateur');
			return (0);
		}

		// Verification du nom
		if (
			!isset($_POST['nom']) ||
			strlen($_POST['nom']) < 2 ||
			strlen($_POST['nom']) > 42 ||
			check_name($_POST['nom'])
		)
		{
			Notif::set('msgCreateAccount', "Le nom renseigné n'est pas valide");
			return (0);
		}
		$nom = htmlspecialchars(trim($_POST['nom']));

		// Verification du prenom
		if (
			!isset($_POST['prenom']) ||
			strlen($_POST['prenom']) < 2 ||
			strlen($_POST['prenom']) > 42 ||
			check_name($_POST['prenom'])
		)
		{
			Notif::set('msgCreateAccount', "Le prénom renseigné n'est pas valide");
			return (0);
		}
		$prenom = htmlspecialchars(trim($_POST['prenom']));

		//Verifier numero detelephone portable
		if (
			!isset($_POST['num']) ||
			!isset($_POST['pays']) ||
			!check_tel_mobile_okay($_POST['num'], $_POST['pays'])
		)
		{
			Notif::set('msgCreateAccount', "Le numéro de téléphone renseigné n'est pas valide");
			return (0);
		}
		$num = htmlspecialchars(trim($_POST['num']));
		$pays = htmlspecialchars(trim($_POST['pays']));

		//Check du mot de passe
		if (
			!isset($_POST['pass']) ||
			!check_mdp_ok($_POST['pass'])
		)
		{
			Notif::set('msgCreateAccount', "Le format du mot de passe n'est pas accepté");
			return (0);
		}
		$pass = $_POST['pass'];

		// Verificatin de la civilité
		if (
			!isset($_POST['civilite']) ||
			(
				$_POST['civilite'] != "Madame" &&
				$_POST['civilite'] != "Monsieur"
			)
		)
		{
			Notif::set('msgCreateAccount', "La civilité n'est pas correcte");
			return (0);
		}
		$civilite = $_POST['civilite'];
		
		// Verifier le captcha.
		if (empty(check_captcha()) && isProd())
		{
			Notif::set('msgCreateAccount', "Le captcha n'a pas été validé");
			return (0);
		}

		if (!SmsSender::check($num))
		{
			$_POST['mail'] = " ";
			Notif::set('msgCreateAccount', "Le numéro de téléphone renseigné n'est pas valide");
			return (0);
		}

		if (!MailSender::verify($_POST['mail']))
		{
			$_POST['mail'] = " ";
			Notif::set('msgCreateAccount', "L'adresse mail renseignée n'est pas valide");
			return (0);
		}

		// Ajouter Dh
		$dh = Dh::insertNew(
			$mail,
			$pass
		);
		if (!$dh)
		{
			Notif::set('msgCreateAccount', "Impossible d'inserer le donneur d'ordre");
			return (0);
		}
		$dh = Dh::getById($dh);
		// Insert Pp
		$Pp = Pp::insertMini($dh->id_dh, $civilite, $prenom, $nom);
		if (!$Pp)
		{
			Notif::set('msgCreateAccount', "Impossible d'inserer la personne physique");
			return (0);
		}

		$Pp = Pp::getFromId($Pp)[0];


		$dh->updateOneColumn("lien_phy", $Pp->id_phs);
		//$Pp->updateOneColumn("mail", ft_crypt_information($mail));
		$Pp->setMail($mail);
		$Pp->updateOneColumn("telephone", ft_crypt_information($num));
		$Pp->updateOneColumn("indicatif_telephonique", $pays);

		$dh->setConseillerRandom();
		$dh->setDocumentValidateFromTypeName("FIL");
		$dh->setDocumentValidateFromTypeName("CGU");
		$dh->setConnectedNoIp();


		$Pp = Pp::getFromId($Pp->id_phs)[0];
		$params = [
			"id" => $Pp->id_phs,
			"Infos " => $Pp->getShortName(),
			"Phone" => $Pp->getPhone()
		];
		Logger::setNew("Ajout d'une personne physique", $dh->id_dh, $dh->id_dh, $params);
		$dh = Dh::getById($dh->id_dh);
		if (isset($_SESSION['utm'])) // Si on a récupéré un utm
		{
			$parrain = Dh::getFromKeyValue("token_affiliation", $_SESSION['utm']);
			if (!empty($parrain))
				$dh->updateOneColumn("id_parrain", $parrain[0]->id_dh);
		}

		$dh->sendMailRegister();

		$date_execution = new DateTime("NOW");
		$date_execution->add(new DateInterval('P1D'));
		$date_execution->setTime(10, 0, 0);
		$id_crm = Crm2::insertNew(
			$dh->id_dh,
			4,
			0,
			$date_execution->getTimestamp(),
			-2700,
			"Crm ajouté automatiquement lors de la création de compte.",
			[],
			0
		);
		//$dh = Dh::getById($dh->id_dh);
		$params = [
			"id" => $dh->id_dh,
			"login" => $dh->getLogin(),
			"biais" => "Création standard sur le front",
			"id_crm" => $id_crm,
			'link' => '?p=EditionClient&client=' . $dh->id_dh . '&onglet=SUIVI&id_crm=' . $id_crm,
			"IP" => $_SERVER['REMOTE_ADDR']
		];
		if (isset($_SESSION['origine'])) // Si on a récupéré l'origine
			$params['origine'] = $_SESSION['origine'];
		Logger::setNew("Creation de compte", $dh->id_dh, $dh->id_dh, $params);
		return (1);
	}
}
