<?php

require_once("class/core/Module.php");

class SetSituationJuridique extends Module
{
	public function insertSituationJuridiqueConjoin() {
		//verifier civilite
		if (!isset($_POST['civiliteConjoin']) ||
			(
				$_POST['civilite'] != "Monsieur" &&
				$_POST['civilite'] != "Madame"
			)
		)
		{
			return (false);
		}
		$civilite = $_POST['civiliteConjoin'];

		$nom_jeune_fille = "";
		if ($_POST['civiliteConjoin'] == "Madame" &&
			isset($_POST['nom_jeune_filleConjoin'])
		)
			$nom_jeune_fille = $_POST['nom_jeune_filleConjoin'];

		//verifier nom 
		if (!isset($_POST['nomConjoin']) || (empty($_POST['nomConjoin'])))
		{
			return (false);
		}
		$nom = $_POST['nomConjoin'];

		//verifier nationalite
		if (!isset($_POST['nationaliteConjoin']) || (empty($_POST['nationaliteConjoin'])))
		{
			return (false);
		}
		$nationalite = $_POST['nationaliteConjoin'];

		//verifier prenom 
		if (!isset($_POST['prenomConjoin']) || (empty($_POST['prenomConjoin'])))
		{
			return (false);
		}
		$prenom = $_POST['prenomConjoin'];

		if (
			!isset($_POST['status_pro']) ||
			!isset($_POST['cat_pro']) ||
			!isset($_POST['profession']) ||
			!isset($_POST['contrat_travail']) ||
			!isset($_POST['autre_contrat_travail']) ||
			!isset($_POST['depart_retraite'])
		)
		{
			// TODO mettre un message explicite 
			Notif:set("errorPp", "Une erreure est survenue durant l'insertion de la personne physique !");
			return;
		}



		$status_pro = intval($_POST['status_proConjoin']);
		$cat_pro = intval($_POST['cat_proConjoin']);
		$profession = htmlspecialchars($_POST['professionConjoin']);
		$contrat_travail = intval($_POST['contrat_travailConjoin']);
		$autre_contrat_travail = htmlspecialchars($_POST['autre_contrat_travailConjoin']);
		$depart_retraite = intval($_POST['depart_retraiteConjoin']);

		if (!(
			($status_pro == 1 && $cat_pro >= 1 && strlen($profession) >= 2 && $contrat_travail == 0 && strlen($autre_contrat_travail) >= 2 && $depart_retraite >= date("Y")) ||
			($status_pro == 1 && $cat_pro >= 1 && strlen($profession) >= 2 && ($contrat_travail == 1 || $contrat_travail == 2) && $depart_retraite >= date("Y")) ||
			($status_pro == 2 && $cat_pro >= 1 && strlen($profession) >= 2 && $depart_retraite >= date("Y")) ||
			($status_pro == 3 && $cat_pro >= 1 && strlen($profession) >= 2 && $depart_retraite >= date("Y")) ||
			($status_pro == 4)
		))
		{
			Notif::set('msgAddSituation', "La situation n'a pas pu etre ajoutee (status_pro)");
			return;
		}

		//verifier date_naissance
		if (!isset($_POST['date_naissanceConjoin']))
		{
			return (false);
		}
		$date = Datetime::createFromFormat("Y-m-d", $_POST['date_naissanceConjoin']);
		if (empty($date))
			$date = Datetime::createFromFormat("d/m/Y", $_POST['date_naissanceConjoin']);
		if (empty($date))
		{
			return (false);
		}
		//$date = $date->getTimestamp();

		//verifier lieu_naissance
		if (!isset($_POST['lieu_naissanceConjoin']) || (empty($_POST['lieu_naissanceConjoin'])))
		{
			return (false);
		}
		$lieu_naissance = $_POST['lieu_naissanceConjoin'];

		if (!isset($_POST['codeNaissanceConjoin']) || (empty($_POST['codeNaissanceConjoin'])))
			return (false);
		$code_naissance = $_POST['codeNaissanceConjoin'];



		//verifier pays_de_naissance
		if (!isset($_POST['pays_de_naissanceConjoin']) || (empty($_POST['pays_de_naissanceConjoin'])))
		{
			return (false);
		}
		$pays_de_naissance = htmlspecialchars($_POST['pays_de_naissanceConjoin']);


		//verifier element_particulier
		if (!isset($_POST['element_particulierConjoin']))
		{
			return (false);
		}
		$element_particulier = htmlspecialchars($_POST['element_particulierConjoin']);





		if ($this->dh->lien_phy != $this->Pp2->id_phs)
		{

			// verfier indicatif_telephonique
			if (!isset($_POST['indicatifConjoin']) || strlen($_POST['indicatifConjoin']) != 2)
			{
				return (false);
			}
			$indicatif = $_POST['indicatifConjoin'];
			// verfier telephone
			if (!isset($_POST['numConjoin']) || check_tel_mobile($_POST['numConjoin'], $_POST['indicatifConjoin']))
			{
				return (false);
			}
			$num = $_POST['numConjoin'];
			//verifier mail
			if (!isset($_POST['mailConjoin']) || !filter_var($_POST['mailConjoin'], FILTER_VALIDATE_EMAIL))
			{
				return (false);
			}
			$mail = $_POST['mailConjoin'];
		}
		else
		{
			$indicatif = $this->Pp2->getIndicatifPhone();
			$num = $this->Pp2->getPhone();
			$mail = $this->Pp2->getMail();
		}


		if (!isset($_POST['haveAddrConjoin']))
		{
			return (false);
		}
		if ($_POST['haveAddrConjoin'] == 0)
		{
			//verifieradresse  
			if (
				!isset($_POST['complementAdresseConjoin']) ||
				!isset($_POST['numeroRueConjoin']) || (empty($_POST['numeroRueConjoin'])) ||
				!isset($_POST['voieConjoin']) || (empty($_POST['voieConjoin'])) ||
				!isset($_POST['type_voieConjoin']) || (empty($_POST['type_voieConjoin'])) ||
				!isset($_POST['codePostalConjoin']) || (empty($_POST['codePostalConjoin'])) ||
				!isset($_POST['villeConjoin']) || (empty($_POST['villeConjoin'])) ||
				!isset($_POST['paysConjoin']) || (empty($_POST['paysConjoin']))
			)
			{
				return (false);
			}
			$complementAdresse = htmlspecialchars($_POST['complementAdresseConjoin']);
			$voie = htmlspecialchars($_POST['voieConjoin']);
			$type_voie = htmlspecialchars($_POST['type_voieConjoin']);
			$codePostal = htmlspecialchars($_POST['codePostalConjoin']);
			$ville = htmlspecialchars($_POST['villeConjoin']);
			$pays = htmlspecialchars($_POST['paysConjoin']);

			$tmp = extractAdressNumExt(htmlspecialchars($_POST['numeroRueConjoin']));
			if (count($tmp) != 3)
			{
				Notif::set('msgAddSituation', "La situation n'a pas pu etre ajoutee (numéro de rue)");
				return;
			}
			$numeroRue = $tmp[1];
			$extension = $tmp[2];
		}
		else
		{
			//verifieradresse  
			if (
				!isset($_POST['complementAdresse']) ||
				!isset($_POST['numeroRue']) || (empty($_POST['numeroRue'])) ||
				!isset($_POST['voie']) || (empty($_POST['voie'])) ||
				!isset($_POST['type_voie']) || (empty($_POST['type_voie'])) ||
				!isset($_POST['codePostal']) || (empty($_POST['codePostal'])) ||
				!isset($_POST['ville']) || (empty($_POST['ville'])) ||
				!isset($_POST['pays']) || (empty($_POST['pays']))
			)
			{
				Notif::set('msgAddSituation', "La situation n'a pas pu etre ajoutee (adresse)");
				return;
			}
			$complementAdresse = htmlspecialchars($_POST['complementAdresse']);
			$voie = htmlspecialchars($_POST['voie']);
			$type_voie = htmlspecialchars($_POST['type_voie']);
			$codePostal = htmlspecialchars($_POST['codePostal']);
			$ville = htmlspecialchars($_POST['ville']);
			$pays = htmlspecialchars($_POST['pays']);

			//$numeroRue = htmlspecialchars($_POST['numeroRue']);
			$tmp = extractAdressNumExt(htmlspecialchars($_POST['numeroRue']));
			if (count($tmp) != 3)
			{
				Notif::set('msgAddSituation', "La situation n'a pas pu etre ajoutee (numéro de rue)");
				return;
			}
			$numeroRue = $tmp[1];
			$extension = $tmp[2];
		}







		//verifier us_person
		if (!isset($_POST['us_personConjoin']) ||
			(
				$_POST['us_personConjoin'] != "0" &&
				$_POST['us_personConjoin'] != "1"
			)
		)
		{
			return (false);
		}
		$us_person = intval($_POST['us_personConjoin']);

		//verifier politique
		if (!isset($_POST['politiqueConjoin']) ||
			(
				$_POST['politiqueConjoin'] != "0" &&
				$_POST['politiqueConjoin'] != "1"
			)
		)
		{
			return (false);
		}
		$politique = intval($_POST['politiqueConjoin']);

		//verifier id_phs
		if (!isset($_POST['id_phsConjoin']) || !$this->dh->checkPpIsMine($_POST['id_phsConjoin']))
		{
			//Check si le Pp appartien bien au Dh;
			return (false);
		}
		$id_phs = intval($_POST['id_phsConjoin']);
		$rt = Pp::updateAllFromId($id_phs, $this->dh->id_dh, $civilite, $prenom, $nom, $mail, $indicatif, $num, $this->etat_civil, $nationalite, $lieu_naissance, $_POST['date_naissanceConjoin'], "-", $profession, $us_person, $politique);
		$Pp = Pp::getFromId($id_phs)[0];
		$Pp->updateOneColumn("pays_de_naissance", $pays_de_naissance);

		$Pp->updateOneColumn("nom_jeune_fille", $nom_jeune_fille);
		$Pp->updateOneColumn("complementAdresse", $complementAdresse);
		$Pp->updateOneColumn("numeroRue", $numeroRue);
		$Pp->updateOneColumn("extension", $extension);
		//$Pp->updateOneColumn("voie", $voie);
		$Pp->setVoie($voie);
		$Pp->updateOneColumn("type_voie", $type_voie);
		$Pp->updateOneColumn("codePostal", $codePostal);
		$Pp->updateOneColumn("ville", $ville);
		$Pp->updateOneColumn("pays", $pays);
		$Pp->updateOneColumn("status_pro_id", $status_pro);
		$Pp->updateOneColumn("cat_pro_id", $cat_pro);
		$Pp->updateOneColumn("depart_retraite", $depart_retraite);
		$Pp->updateOneColumn("contrat_travail", $contrat_travail);
		$Pp->updateOneColumn("autre_contrat_travail", $autre_contrat_travail);
		$Pp->updateOneColumn("element_particulier", $element_particulier);
		$Pp->updateOneColumn("code_naissance", $code_naissance);
		
        $Pp->updateOneColumn("situation_setted", true);
		if (!$rt)
			return (false);
		return (true);
	}

	public function insertSituationJuridique() {
		//verifier civilite
		if (!isset($_POST['civilite']) ||
			(
				$_POST['civilite'] != "Monsieur" &&
				$_POST['civilite'] != "Madame"
			)
		)
		{
			Notif::set('msgAddSituation', "La situation n'a pas pu etre ajoutee (civilite)");
			return;
		}
		$civilite = $_POST['civilite'];

		$nom_jeune_fille = "";
		if ($_POST['civilite'] == "Madame" &&
			isset($_POST['nom_jeune_fille'])
		)
			$nom_jeune_fille = $_POST['nom_jeune_fille'];

		//verifier nom 
		if (!isset($_POST['nom']) || (empty($_POST['nom'])))
		{
			Notif::set('msgAddSituation', "La situation n'a pas pu etre ajoutee (nom)");
			return;
		}
		$nom = $_POST['nom'];

		//verifier nationalite
		if (!isset($_POST['nationalite']) || (empty($_POST['nationalite'])))
		{
			Notif::set('msgAddSituation', "La situation n'a pas pu etre ajoutee (nationalite)");
			return;
		}
		$nationalite = $_POST['nationalite'];

		//verifier prenom 
		if (!isset($_POST['prenom']) || (empty($_POST['prenom'])))
		{
			Notif::set('msgAddSituation', "La situation n'a pas pu etre ajoutee (prenom)");
			return;
		}
		$prenom = $_POST['prenom'];

		if (
			!isset($_POST['status_pro']) ||
			!isset($_POST['cat_pro']) ||
			!isset($_POST['profession']) ||
			!isset($_POST['contrat_travail']) ||
			!isset($_POST['autre_contrat_travail']) ||
			!isset($_POST['depart_retraite'])
		)
		{
			// TODO mettre un message explicite 
			Notif:set("errorPp", "Une erreure est survenue durant l'insertion de la personne physique !");
			return;
		}
		$status_pro = intval($_POST['status_pro']);
		$cat_pro = intval($_POST['cat_pro']);
		$profession = htmlspecialchars($_POST['profession']);
		$contrat_travail = intval($_POST['contrat_travail']);
		$autre_contrat_travail = htmlspecialchars($_POST['autre_contrat_travail']);
		$depart_retraite = intval($_POST['depart_retraite']);

/*
		dbg(($status_pro == 1 && $cat_pro >= 1 && strlen($profession >= 2)  ));

		dbg(($status_pro == 2 && $cat_pro >= 1 && $depart_retraite >= date("Y")));
		dbg($status_pro == 2 && $cat_pro >= 1 && $depart_retraite >= date("Y"));
		dbg($status_pro == 3);
		exit();
		*/
		if (!(
			($status_pro == 1 && $cat_pro >= 1 && strlen($profession) >= 2 && $contrat_travail == 0 && strlen($autre_contrat_travail) >= 2 && $depart_retraite >= date("Y")) ||
			($status_pro == 1 && $cat_pro >= 1 && strlen($profession) >= 2 && ($contrat_travail == 1 || $contrat_travail == 2) && $depart_retraite >= date("Y")) ||
			($status_pro == 2 && $cat_pro >= 1 && strlen($profession) >= 2  && $depart_retraite >= date("Y")) ||
			($status_pro == 3 && $cat_pro >= 1 && strlen($profession) >= 2 && $depart_retraite >= date("Y")) ||
			($status_pro == 4)
		))
		{
			Notif::set('msgAddSituation', "La situation n'a pas pu etre ajoutee (status_pro)");
			return;
		}

		//verifier date_naissance
		if (!isset($_POST['date_naissance']))
		{
			Notif::set('msgAddSituation', "La situation n'a pas pu etre ajoutee (date_naissance 1)");
		}
		$date = Datetime::createFromFormat("Y-m-d", $_POST['date_naissance']);
		if (empty($date))
			$date = Datetime::createFromFormat("d/m/Y", $_POST['date_naissance']);
		if (empty($date))
		{
			Notif::set('msgAddSituation', "La situation n'a pas pu etre ajoutee (date_naissance 2)");
			return;
		}
		//$date = $date->getTimestamp();

		//verifier lieu_naissance
		if (!isset($_POST['lieu_naissance']) || (empty($_POST['lieu_naissance'])))
		{
			Notif::set('msgAddSituation', "La situation n'a pas pu etre ajoutee (lieu_naissance)");
			return;
		}
		$lieu_naissance = $_POST['lieu_naissance'];

		if (!isset($_POST['codeNaissance']) || (empty($_POST['codePostal'])))
			return (false);
		$code_naissance = $_POST['codeNaissance'];




		//verifier pays_de_naissance
		if (!isset($_POST['pays_de_naissance']) || (empty($_POST['pays_de_naissance'])))
		{
			Notif::set('msgAddSituation', "La situation n'a pas pu etre ajoutee (pays_de_naissance)");
			return;
		}
		$pays_de_naissance = htmlspecialchars($_POST['pays_de_naissance']);





		//verifier element_particulier
		if (!isset($_POST['element_particulier']))
		{
			return (false);
		}
		$element_particulier = htmlspecialchars($_POST['element_particulier']);



		if ($this->dh->lien_phy != $this->Pp->id_phs)
		{
			// verfier indicatif_telephonique
			if (!isset($_POST['indicatif']) || strlen($_POST['indicatif']) != 2)
			{
				Notif::set('msgAddSituation', "La situation n'a pas pu etre ajoutee (indicatif)");
				return;
			}
			$indicatif = $_POST['indicatif'];
			// verfier telephone
			if (!isset($_POST['num']) || check_tel_mobile($_POST['num'], $_POST['indicatif']))
			{
				Notif::set('msgAddSituation', "La situation n'a pas pu etre ajoutee (num)");
				return;
			}
			$num = $_POST['num'];
			//verifier mail
			if (!isset($_POST['mail']) || !filter_var($_POST['mail'], FILTER_VALIDATE_EMAIL))
			{
				Notif::set('msgAddSituation', "La situation n'a pas pu etre ajoutee (mail)");
				return;
			}
			$mail = $_POST['mail'];
		}
		else
		{
			$indicatif = $this->Pp->getIndicatifPhone();
			$num = $this->Pp->getPhone();
			$mail = $this->Pp->getMail();
		}


		//verifieradresse  
		if (
			!isset($_POST['complementAdresse']) ||
			!isset($_POST['numeroRue']) || (empty($_POST['numeroRue'])) ||
			!isset($_POST['voie']) || (empty($_POST['voie'])) ||
			!isset($_POST['type_voie']) || (empty($_POST['type_voie'])) ||
			!isset($_POST['codePostal']) || (empty($_POST['codePostal'])) ||
			!isset($_POST['ville']) || (empty($_POST['ville'])) ||
			!isset($_POST['pays']) || (empty($_POST['pays']))
		)
		{
			Notif::set('msgAddSituation', "La situation n'a pas pu etre ajoutee (adresse)");
			return;
		}
		$complementAdresse = htmlspecialchars($_POST['complementAdresse']);
		$voie = htmlspecialchars($_POST['voie']);
		$type_voie = htmlspecialchars($_POST['type_voie']);
		$codePostal = htmlspecialchars($_POST['codePostal']);
		$ville = htmlspecialchars($_POST['ville']);
		$pays = htmlspecialchars($_POST['pays']);

		//$numeroRue = htmlspecialchars($_POST['numeroRue']);
		$tmp = extractAdressNumExt(htmlspecialchars($_POST['numeroRue']));
		if (count($tmp) != 3)
		{
			Notif::set('msgAddSituation', "La situation n'a pas pu etre ajoutee (numéro de rue)");
			return;
		}
		$numeroRue = $tmp[1];
		$extension = $tmp[2];



		//verifier etat_civil
		if (
			!isset($_POST['etat_civil']) ||
			!in_array($_POST['etat_civil'], Pp::$_etat_civil_lst)
		)
		{
			Notif::set('msgAddSituation', "La situation n'a pas pu etre ajoutee (etat_civil)");
			return;
		}
		$etat_civil = $_POST['etat_civil'];

		//verifier regime_matri
		if (
			!isset($_POST['regime_matri']) ||
			!isset(SituationJuridique::$_regimeMatrimonial[$_POST['regime_matri']])
		)
		{
			Notif::set('msgAddSituation', "La situation n'a pas pu etre ajoutee (regime_matri)");
			return;
		}
		$regime_matri = $_POST['regime_matri'];

		$nbr_enfant = 0;
		//verifier enfant
		if (!isset($_POST['enfant']))
		{
			Notif::set('msgAddSituation', "La situation n'a pas pu etre ajoutee (etat_civil)");
			return;
		}
		$enfant = intval($_POST['enfant']);
		if ($enfant  == 1)
		{
			if (!isset($_POST['nbr_enfant']))
			{
				Notif::set('msgAddSituation', "La situation n'a pas pu etre ajoutee (etat_civil)");
				return;
			}
			$nbr_enfant = intval($_POST['nbr_enfant']);
			if ($nbr_enfant < 0)
			{
				Notif::set('msgAddSituation', "La situation n'a pas pu etre ajoutee (etat_civil)");
				return;
			}
		}

		//verifier autres_charge
		$nbr_autres = 0;
		if (!isset($_POST['autres_charge']))
		{
			Notif::set('msgAddSituation', "La situation n'a pas pu etre ajoutee (autres_charge)");
			return;
		}
		if ($_POST['autres_charge'] == 1)
		{
			//verifier nbr_autres
			if (!isset($_POST['nbr_autres']))
			{
				Notif::set('msgAddSituation', "La situation n'a pas pu etre ajoutee (nbr_autres)");
				return;
			}
			$nbr_autres= intval($_POST['nbr_autres']);
			if ($nbr_autres < 1)
			{
				Notif::set('msgAddSituation', "La situation n'a pas pu etre ajoutee (etat_civil)");
				return;
			}
		}


		//verifier us_person
		if (!isset($_POST['us_person']) ||
			(
				$_POST['us_person'] != "0" &&
				$_POST['us_person'] != "1"
			)
		)
		{
			Notif::set('msgAddSituation', "La situation n'a pas pu etre ajoutee (us_person)");
			return;
		}
		$us_person = intval($_POST['us_person']);

		//verifier politique
		if (!isset($_POST['politique']) ||
			(
				$_POST['politique'] != "0" &&
				$_POST['politique'] != "1"
			)
		)
		{
			Notif::set('msgAddSituation', "La situation n'a pas pu etre ajoute (politique)");
			return;
		}
		$politique = intval($_POST['politique']);

		//verifier id_phs
		if (!isset($_POST['id_phs']) || !$this->dh->checkPpIsMine($_POST['id_phs']))
		{
			//Check si le Pp appartien bien au Dh;
			Notif::set('msgAddSituation', "La situation n'a pas pu etre ajoute (id_phs)");
			return;
		}
		$id_phs = intval($_POST['id_phs']);
		$rt = Pp::updateAllFromId($id_phs, $this->dh->id_dh, $civilite, $prenom, $nom, $mail, $indicatif, $num, $etat_civil, $nationalite, $lieu_naissance, $date->format("d/m/Y"), "-", $profession, $us_person, $politique);

		if (!$rt)
		{
			Notif::set('msgAddSituation', "La situation n'a pas pu etre ajoute (update Pp)");
			return;
		}

		$Pp = Pp::getFromId($id_phs)[0];
		$Pp->updateOneColumn("pays_de_naissance", $pays_de_naissance);

		$Pp->updateOneColumn("nom_jeune_fille", $nom_jeune_fille);
		$Pp->updateOneColumn("complementAdresse", $complementAdresse);
		$Pp->updateOneColumn("numeroRue", $numeroRue);
		$Pp->updateOneColumn("extension", $extension);
		//$Pp->updateOneColumn("voie", $voie);
		$Pp->setVoie($voie);
		$Pp->updateOneColumn("type_voie", $type_voie);
		$Pp->updateOneColumn("codePostal", $codePostal);
		$Pp->updateOneColumn("ville", $ville);
		$Pp->updateOneColumn("pays", $pays);
		$Pp->updateOneColumn("status_pro_id", $status_pro);
		$Pp->updateOneColumn("cat_pro_id", $cat_pro);
		$Pp->updateOneColumn("depart_retraite", $depart_retraite);
		$Pp->updateOneColumn("depart_retraite", $depart_retraite);
		$Pp->updateOneColumn("contrat_travail", $contrat_travail);
		$Pp->updateOneColumn("autre_contrat_travail", $autre_contrat_travail);
		$Pp->updateOneColumn("element_particulier", $element_particulier);
		$Pp->updateOneColumn("code_naissance", $code_naissance);
        $Pp->updateOneColumn("situation_setted", true);

		if (isset($this->Pp2))
		{
			$this->etat_civil = $etat_civil;
			$rt = $this->insertSituationJuridiqueConjoin();
			if (!$rt)
			{
				Notif::set('msgAddSituation', "La situation n'a pas pu etre ajoute (update Pp Conjoin)");
				return;
			}
		}
		$rt = Pp::getFromId($_POST['id_phs'])[0]->insertSituationJuridique(time(), time() + TIME_SITUATION_VALID, $regime_matri, $nbr_enfant, $nbr_autres, $enfant);
		if (!$rt)
		{
			Notif::set('msgAddSituation', "La situation n'a pas pu etre ajoute (insert Situation)");
			return;
		}
		header("Location: ?p=" . $GLOBALS['GET']['p'] . "&projet=" . $GLOBALS['GET']['projet'] . (isset($GLOBALS['GET']['client']) ? "&client=" . intval($GLOBALS['GET']['client']) : ""));
		exit();
	}
}
