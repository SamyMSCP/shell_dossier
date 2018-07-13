<?php
require_once("class/core/Ajax.php");
class UpdatePp  extends Ajax
{
	/*
		id
		civilite
		nom
		prenom
		mail
		telephone
		indicatif_telephonique
		telephone_fixe
		indicatif_telephonique_fixe
		date_naissance
		lieu_naissance
		nationalite
		etat_civil
		us_person
		politique
		complementAdresse
		numeroRue
		voie
		codePostal
		ville
		pays
		paysNaissance
		profession
	*/

	public function savePp($data)
	{
		if (!$this->checkPpData($data))
			return (false);

		foreach ($data as $key => $elm)
		{
			if (strlen($elm) == 0)
				$data[$key] = " ";
		}

		// recuperer le id du dh !
		$civilite = $data['civilite'];
		$nom = $data['nom'];
		$prenom = $data['prenom'];

		$mail = mb_strtolower($data['mail']);
		$telephone = htmlspecialchars(trim($data['telephone']));
		$indicatif_telephonique = htmlspecialchars(trim($data['indicatif_telephonique']));
		$telephone_fixe = htmlspecialchars(trim($data['telephone_fixe']));
		$indicatif_telephonique_fixe = htmlspecialchars(trim($data['indicatif_telephonique_fixe']));
		if (empty($indicatif_telephonique))
			$telephone = "-";
		if (empty($indicatif_telephonique_fixe))
			$telephone_fixe = "-";
		$date_naissance = intval($data['date_naissance']);
		$lieu_naissance = htmlspecialchars($data['lieu_naissance']);
		$pays_naissance = htmlspecialchars($data['paysNaissance']);
		$etat_civil = htmlspecialchars($data['etat_civil']);
		$nationalite = htmlspecialchars($data['nationalite']);
		$profession = htmlspecialchars($data['profession']);
		$numeroRue = intval($data['numeroRue']);
		$voie = htmlspecialchars($data['voie']);
		$type_voie = htmlspecialchars($data['type_voie']);
		$codePostal = htmlspecialchars($data['codePostal']);
		$ville = htmlspecialchars($data['ville']);
		$pays = htmlspecialchars($data['pays']);
		$us_person = intval($data['us_person']);
		$politique = intval($data['politique']);
		$complementAdresse = intval($data['complementAdresse']);

		$PpId = Pp::insertMini($_GET['client'], $civilite, $prenom, $nom);
		if (empty($PpId))
			return (false);
		$Pp = Pp::getFromId($PpId);
		if (empty($Pp))
			return (false);
		$Pp = $Pp[0];
		//$Pp->updateOneColumn("civilite", ft_crypt_information($civilite));
		//$Pp->updateOneColumn("nom", ft_crypt_information($nom));
		//$Pp->updateOneColumn("prenom", ft_crypt_information($prenom));
		$Pp->updateOneColumn("mail", ft_crypt_information($mail));
		$Pp->updateOneColumn("indicatif_telephonique", $indicatif_telephonique);
		$Pp->updateOneColumn("telephone", ft_crypt_information($telephone));
		$Pp->updateOneColumn("indicatif_telephonique_fixe", $indicatif_telephonique_fixe);
		$Pp->updateOneColumn("telephone_fixe", ft_crypt_information($telephone_fixe));
		$Pp->updateOneColumn("date_de_n", $date_naissance);
		$Pp->updateOneColumn("lieu_de_n", ft_crypt_information($lieu_naissance));
		$Pp->updateOneColumn("pays_de_naissance", $pays_naissance);
		$Pp->updateOneColumn("etat_civil", ft_crypt_information($etat_civil));
		$Pp->updateOneColumn("nationalite", ft_crypt_information($nationalite));
		$Pp->updateOneColumn("profession", ft_crypt_information($profession));
		$Pp->updateOneColumn("numeroRue", $numeroRue);
		//$Pp->updateOneColumn("voie", $voie);
		$Pp->setVoie($voie);
		$Pp->updateOneColumn("type_voie", $type_voie);
		$Pp->updateOneColumn("codePostal", $codePostal);
		$Pp->updateOneColumn("ville", $ville);
		$Pp->updateOneColumn("pays", $pays);
		$Pp->updateOneColumn("us_person", $us_person);
		$Pp->updateOneColumn("politiquement_expose", $politique);

		if ($civilite == "Madame")
		{
			$nom_jeune_fille = $data['nom_jeune_fille'];
			$Pp->updateOneColumn("nom_jeune_fille", $nom_jeune_fille);
		}
		return (true);
	}

	public function updateThisPp($data) {

		if (!$this->checkPpData($data))
			return (false);

		foreach ($data as $key => $elm)
		{
			if (!is_array($elm) && strlen($elm) == 0)
				$data[$key] = " ";
		}
		$civilite = $data['civilite'];
		$nom = $data['nom'];
		$prenom = $data['prenom'];
		$mail = mb_strtolower($data['mail']);
		$indicatif_telephonique = htmlspecialchars(trim($data['indicatif_telephonique']));
		$telephone = htmlspecialchars(trim($data['telephone']));
		$telephone_fixe = htmlspecialchars(trim($data['telephone_fixe']));
		$indicatif_telephonique_fixe = htmlspecialchars(trim($data['indicatif_telephonique_fixe']));
		if (empty($indicatif_telephonique) && empty($telephone))
			$telephone = "-";
		if (empty($indicatif_telephonique_fixe) && empty($telephone_fixe))
			$telephone_fixe = "-";
		$date_naissance = intval($data['date_naissance']);
		$lieu_naissance = htmlspecialchars($data['lieu_naissance']);
		$pays_naissance = htmlspecialchars($data['paysNaissance']);
		$etat_civil = htmlspecialchars($data['etat_civil']);
		$nationalite = htmlspecialchars($data['nationalite']);
		$profession = htmlspecialchars($data['profession']);
		$numeroRue = intval($data['numeroRue']);
		$voie = htmlspecialchars($data['voie']);
		$type_voie = htmlspecialchars($data['type_voie']);
		$codePostal = htmlspecialchars($data['codePostal']);
		$ville = htmlspecialchars($data['ville']);
		$pays = htmlspecialchars($data['pays']);
		$us_person = intval($data['us_person']);
		$politique = intval($data['politique']);
		$complementAdresse = intval($data['complementAdresse']);

		$Pp = Pp::getFromId($data['id']);
		if (empty($Pp))
			return (false);
		$Pp = $Pp[0];
		$Pp->updateOneColumn("civilite", ft_crypt_information($civilite));
		$Pp->updateOneColumn("nom", ft_crypt_information($nom));
		$Pp->updateOneColumn("prenom", ft_crypt_information($prenom));
		$Pp->updateOneColumn("mail", ft_crypt_information($mail));
		$Pp->updateOneColumn("indicatif_telephonique", $indicatif_telephonique);
		$Pp->updateOneColumn("telephone", ft_crypt_information($telephone));
		$Pp->updateOneColumn("indicatif_telephonique_fixe", $indicatif_telephonique_fixe);
		$Pp->updateOneColumn("telephone_fixe", ft_crypt_information($telephone_fixe));
		$Pp->updateOneColumn("date_de_n", $date_naissance);
		$Pp->updateOneColumn("lieu_de_n", ft_crypt_information($lieu_naissance));
		$Pp->updateOneColumn("pays_de_naissance", $pays_naissance);
		$Pp->updateOneColumn("etat_civil", ft_crypt_information($etat_civil));
		$Pp->updateOneColumn("nationalite", ft_crypt_information($nationalite));
		$Pp->updateOneColumn("profession", ft_crypt_information($profession));
		$Pp->updateOneColumn("numeroRue", $numeroRue);
		$Pp->updateOneColumn("type_voie", $type_voie);
		//$Pp->updateOneColumn("voie", $voie);
		$Pp->setVoie($voie);
		$Pp->updateOneColumn("codePostal", $codePostal);
		$Pp->updateOneColumn("ville", $ville);
		$Pp->updateOneColumn("pays", $pays);
		$Pp->updateOneColumn("us_person", $us_person);
		$Pp->updateOneColumn("politiquement_expose", $politique);


		if ($civilite == "Madame")
		{
			$nom_jeune_fille = $data['nom_jeune_fille'];
			$Pp->updateOneColumn("nom_jeune_fille", $nom_jeune_fille);
		}

		$herDh = $Pp->getDh();
		if ($herDh->lien_phy == $Pp->id_phs)
		{
			$herDh->updateOneColumn('login', ft_crypt_information($mail));
		}
		//echo json_encode($data);
		//exit();
		return (true);
	}

	public function checkPpData($data) {
		if (
			!isset($data['id']) ||
			!isset($data['civilite']) ||
			($data['civilite'] == "Madame" && !isset($data['nom_jeune_fille'])) ||
			!isset($data['nom']) ||
			!isset($data['prenom']) ||
			!isset($data['mail']) ||
			!isset($data['telephone']) ||
			!isset($data['indicatif_telephonique']) ||
			!isset($data['telephone_fixe']) ||
			!isset($data['indicatif_telephonique_fixe']) ||
			!isset($data['date_naissance']) ||
			!isset($data['lieu_naissance']) ||
			!isset($data['nationalite']) ||
			!isset($data['etat_civil']) ||
			!isset($data['us_person']) ||
			!isset($data['politique']) ||
			!isset($data['complementAdresse']) ||
			!isset($data['numeroRue']) ||
			!isset($data['voie']) ||
			!isset($data['codePostal']) ||
			!isset($data['ville']) ||
			!isset($data['pays']) ||
			!isset($data['paysNaissance']) ||
			!isset($data['profession'])
		)
		{
			error("La mise a jours de la personne physique à échouée, une donnée nécessaire est absente");
		}

		if ($data['id'] != 0)
		{
			$Pp = Pp::getFromId($data['id']);
			if (empty($Pp))
				return (false);
			$Pp = $Pp[0];
			$herDh = $Pp->getDh();
			// Si le Pp est le donneur d'ordre et que l'adresse mail est differente et qu'elle est deja utilisée par un autre alors erreur !!!
			if (
				$herDh->lien_phy == $Pp->id_phs &&
				$herDh->getLogin() != $data['mail'] &&
				!empty(Dh::getByLogin($data['mail']))
			)
				return (false);
		}

		if ($data['civilite'] != "Monsieur" && $data['civilite'] != "Madame")
			return (false);

		if (
			strlen($data['nom']) < 2 ||
			check_name($data['nom'])
		)
			return (false);

		if (
			strlen($data['prenom']) < 2 ||
			check_name($data['prenom'])
		)
			return (false);

		if (!filter_var(mb_strtolower($data['mail']), FILTER_VALIDATE_EMAIL))
			return (false);


		if (
			!empty($data['indicatif_telephonique']) &&
			!check_tel_mobile_okay($data['telephone'], $data['indicatif_telephonique'])
		)
			return (false);
		if (
			!empty($data['indicatif_telephonique_fixe']) &&
			!check_tel_mobile_okay($data['telephone_fixe'], $data['indicatif_telephonique_fixe'])
		)
			return (false);

		if (
			$data['etat_civil'] != "marie" &&
			$data['etat_civil'] != "pacse" &&
			$data['etat_civil'] != "unionlibre" &&
			$data['etat_civil'] != "celibataire" &&
			$data['etat_civil'] != "veuf" &&
			$data['etat_civil'] != "divorce" &&
			$data['etat_civil'] != ""
		)
			return (false);

		if ($data['politique'] != 0 && $data['politique'] != 1)
			return (false);
		if ($data['us_person'] != 0 && $data['us_person'] != 1)
			return (false);

		
		return (true);
	}
}
