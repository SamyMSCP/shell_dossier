<?php
require_once("class/core/AjaxClient.php");
class AjaxCreateAccount extends AjaxClient
{

	public $message = "";

	public function createAccount($data){

		// Verifier si l'adresse mail est renseignée




		if (!isset($data['mail']) || empty($data['mail']))
		{
			$this->message = 'Une erreur est survenue lors de la création de compte';
			return (0);
		}
		$mail = strtolower(htmlspecialchars(trim($data['mail'])));

		// Verifier si l'adresse mail a un format valide.
		if (!filter_var($mail, FILTER_VALIDATE_EMAIL))
		{
			$data['mail'] = " ";
			$this->message = "L'adresse mail renseignée n'a pas un format valide ";
			return (0);
		}

		$domainCheck = MailSender::checkBann($data['mail']);
		if ($domainCheck != false)
		{
			$data['mail'] = " ";
			$this->message = "Le domaine $domainCheck n'est pas autorisé pour la création de compte";
			return (0);
		}

		// Verifier si l'adresse mail renseignée n'est pas deja utilisee.
		if (!empty(Dh::getByLogin($mail)))
		{
			$data['mail'] = " ";
			$this->message = 'Cette adresse email est déjà utilisée par un autre utilisateur';
			return (0);
		}

		// Verification du nom
		if (
			!isset($data['nom']) ||
			strlen($data['nom']) < 2 ||
			strlen($data['nom']) > 42 ||
			check_name($data['nom'])
		)
		{
			$this->message = "Le nom renseigné n'est pas valide";
			return (0);
		}
		$nom = htmlspecialchars(trim($data['nom']));

		// Verification du prenom
		if (
			!isset($data['prenom']) ||
			strlen($data['prenom']) < 2 ||
			strlen($data['prenom']) > 42 ||
			check_name($data['prenom'])
		)
		{
			$this->message = "Le prénom renseigné n'est pas valide";
			return (0);
		}
		$prenom = htmlspecialchars(trim($data['prenom']));

		//Verifier numero detelephone portable
		if (
			!isset($data['num']) ||
			!isset($data['pays']) ||
			!check_tel_mobile_okay($data['num'], $data['pays'])
		)
		{
			$this->message = "Le numéro de téléphone renseigné n'est pas valide";
			return (0);
		}
		$num = htmlspecialchars(trim($data['num']));
		$pays = htmlspecialchars(trim($data['pays']));

		//Check du mot de passe
		if (
			!isset($data['pass']) ||
			!check_mdp_ok($data['pass'])
		)
		{
			$this->message = "Le format du mot de passe n'est pas accepté";
			return (0);
		}
		$pass = $data['pass'];

		// Verificatin de la civilité
		if (
			!isset($data['civilite']) ||
			(
				$data['civilite'] != "Madame" &&
				$data['civilite'] != "Monsieur"
			)
		)
		{
			$this->message = "La civilité n'est pas correcte";
			return (0);
		}
		$civilite = $data['civilite'];

		// Verifier le captcha.
		$_POST["g-recaptcha-response"] = $data['captcha'];
		if (empty(check_captcha()) && isProd())
		{
			$this->message = "Le captcha n'a pas été validé";
			return (0);
		}
		if (!SmsSender::check($num))
		{
			$data['mail'] = " ";
			$this->message = "Le numéro de téléphone renseigné n'est pas valide";
			return (0);
		}

		if (!MailSender::verify($data['mail']))
		{
			$data['mail'] = " ";
			$this->message = "L'adresse mail renseignée n'est pas valide";
			return (0);
		}

		// Ajouter Dh
		$dh = Dh::insertNew(
			$mail,
			$pass
		);
		if (!$dh)
		{
			$this->message = "Impossible de créer le compte merci de nous contacter au 01 82 28 90 28";
			return (0);
		}

/* ****************************************************************************************************************** */

		$dh = Dh::getById($dh);
		// Insert Pp
		$Pp = Pp::insertMini($dh->id_dh, $civilite, $prenom, $nom);
		if (!$Pp)
		{
			$this->message = "Impossible de créer le compte merci de nous contacter au 01 82 28 90 28";
			return (0);
		}

		$Pp = Pp::getFromId($Pp)[0];


		$dh->updateOneColumn("create_from", intval($data["from"]));
		$dh->updateOneColumn("lien_phy", $Pp->id_phs);
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
			"Andréa : Crm ajouté automatiquement lors de la création de compte.",
			[],
			0
		);
		//$dh = Dh::getById($dh->id_dh);
		$params = [
			"id" => $dh->id_dh,
			"login" => $dh->getLogin(),
			"biais" => "Création Landing Page",
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
