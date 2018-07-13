<?php
	$this->Pp = $this->dh->getPersonnePhysique();


	if (empty($_SESSION["anticsrf"]))
		$_SESSION["anticsrf"] = generateRandomString();
	if (!empty($GLOBALS['GET']['help']) && $GLOBALS['GET']['help'] == $_SESSION["anticsrf"]) {
		addhelp($_COOKIE["login"]);
		if ($this->dh->getConseiller()){
			$prenom = $this->dh->getConseiller()->getPersonnePhysique()->getFirstName();
			$nom = $this->dh->getConseiller()->getPersonnePhysique()->getName();
			Logger::setNew("Demande de contact", $this->dh->id_dh, $this->dh->id_dh, [
				'objet' => 'simple demande sur la navbar',
				'link' => '?p=EditionClient&client=' . $this->dh->id_dh
			]);
			$date_execution = new DateTime("NOW");
			$date_execution->add(new DateInterval('P1D'));
			$date_execution->setTime(10, 0, 0);
			$id_crm = Crm2::insertNew(
				$this->dh->id_dh,
				5,
				0,
				time(),
				-2700,
				"Ce client souhaite être contacté.",
				[],
				0
			);
			if (empty($id_crm))
			{
				Notif::set("msgContact", "La demande de contact n'a pas pu etre enregistrée");
				header("Location: ?p=" . $GLOBALS['GET']["p"]);
				exit();
			}
			if (strstr(ft_decrypt_crypt_information($this->dh->getConseiller()->getPersonnePhysique()->civilite), "onsieur"))
				Notif::set("msgContact", "M " . ucwords(strtolower(htmlspecialchars($prenom))) . " " . htmlspecialchars(strtoupper($nom)) . " prendra contact avec vous dans les meilleurs délais.");
			else
				Notif::set("msgContact", "Mme " . ucwords(strtolower(htmlspecialchars($prenom))) . " " . htmlspecialchars(strtoupper($nom)) . " prendra contact avec vous dans les meilleurs délais.");
		}
	}
	else if (!empty($GLOBALS['GET']['asaisir']) && $GLOBALS['GET']['asaisir'] == $_SESSION["anticsrf"]) {
		addhelp($_COOKIE["login"]);
		if ($this->dh->getConseiller()){
			$prenom = $this->dh->getConseiller()->getPersonnePhysique()->getFirstName();
			$nom = $this->dh->getConseiller()->getPersonnePhysique()->getName();
			Logger::setNew("Demande de contact", $this->dh->id_dh, $this->dh->id_dh, [
				'objet' => 'demande via opportunite a saisir',
				'link' => '?p=EditionClient&client=' . $this->dh->id_dh
			]);
			$date_execution = new DateTime("NOW");
			$date_execution->add(new DateInterval('P1D'));
			$date_execution->setTime(10, 0, 0);
			$id_crm = Crm2::insertNew(
				$this->dh->id_dh,
				5,
				0,
				time(),
				-2700,
				"Ce client souhaite être contacté par rapport a l'opportunité à saisir.",
				[],
				0
			);
			if (empty($id_crm))
			{
				Notif::set("msgContact", "La demande de contact n'a pas pu etre enregistrée");
				header("Location: ?p=" . $GLOBALS['GET']["p"]);
				exit();
			}
			if (strstr(ft_decrypt_crypt_information($this->dh->getConseiller()->getPersonnePhysique()->civilite), "onsieur"))
				Notif::set("msgContact", "M " . ucwords(strtolower(htmlspecialchars($prenom))) . " " . htmlspecialchars(strtoupper($nom)) . " prendra contact avec vous dans les meilleurs délais.");
			else
				Notif::set("msgContact", "Mme " . ucwords(strtolower(htmlspecialchars($prenom))) . " " . htmlspecialchars(strtoupper($nom)) . " prendra contact avec vous dans les meilleurs délais.");
		}
	}
	else if (!empty($GLOBALS['GET']['suggest']) && $GLOBALS['GET']['suggest'] == $_SESSION["anticsrf"]) {
		addhelp($_COOKIE["login"]);
		if ($this->dh->getConseiller()){
			$prenom = $this->dh->getConseiller()->getPersonnePhysique()->getFirstName();
			$nom = $this->dh->getConseiller()->getPersonnePhysique()->getName();
			Logger::setNew("Demande de contact", $this->dh->id_dh, $this->dh->id_dh, [
				'objet' => 'demande via opportunite suggérée',
				'link' => '?p=EditionClient&client=' . $this->dh->id_dh
			]);
			$date_execution = new DateTime("NOW");
			$date_execution->add(new DateInterval('P1D'));
			$date_execution->setTime(10, 0, 0);
			$id_crm = Crm2::insertNew(
				$this->dh->id_dh,
				5,
				0,
				time(),
				-2700,
				"Ce client souhaite être contacté par rapport à l'opportunité suggérée.",
				[],
				0
			);
			if (empty($id_crm))
			{
				Notif::set("msgContact", "La demande de contact n'a pas pu etre enregistrée");
				header("Location: ?p=" . $GLOBALS['GET']["p"]);
				exit();
			}
			if (strstr(ft_decrypt_crypt_information($this->dh->getConseiller()->getPersonnePhysique()->civilite), "onsieur"))
				Notif::set("msgContact", "M " . ucwords(strtolower(htmlspecialchars($prenom))) . " " . htmlspecialchars(strtoupper($nom)) . " prendra contact avec vous dans les meilleurs délais.");
			else
				Notif::set("msgContact", "Mme " . ucwords(strtolower(htmlspecialchars($prenom))) . " " . htmlspecialchars(strtoupper($nom)) . " prendra contact avec vous dans les meilleurs délais.");
		}
	}
	else
		$_SESSION["anticsrf"] = generateRandomString();
	if (!empty($_POST['code_s']) && !empty($_SESSION['code']) && intval($_SESSION['code']) === intval($_POST['code_s'])){
		if ($_SESSION['validation']){
			//valide_sms($_SESSION['mail']);
			$this->dh->updateOneColumn('confirmation', ($this->dh->mailOk())? 3 : 1);
			Notif::set("Merci", "Votre numero de téléphone a été validé.");
			Logger::setNew("Numéro de telephone valide", $this->dh->id_dh, $this->dh->id_dh, []);
			$_SESSION['validation'] = NULL;
			header("Location: ?p=" . $GLOBALS['GET']["p"]);
			exit();
		}
		else
		{
			valide_sms($this->dh->getLogin());
			$dh = intval(get_my_dh());
			change_number($_SESSION['n_tel'], $dh);
			Notif::set("Merci", "Votre numero de téléphone a été modifié avec succès.");
			Logger::setNew("Numero de telephone change", $this->dh->id_dh, $this->dh->id_dh, []);
			$_SESSION['code'] = NULL;
			header("Location: ?p=" . $GLOBALS['GET']["p"]);
			exit();
		}
	}
	else if (!empty($_POST['code_s'])){
		Notif::set("CodeError", "Code incorrect, merci de réessayer à nouveau.");
		$_SESSION['code'] = NULL;
	}
	else if (!empty($GLOBALS['GET']['cancel']))
		Notif::set("ChangementAnnule", "Vous avez annulé la modification de vos données personnelles.");

	$this->loadModule('CentreInteretComponent', 'CentreInteretComponent', ['dh' => $this->dh, 'template' => '#centreinteretcomponent']);

$this->loadModule('CentreInteretStore','CentreInteretStore', ['dh' => $this->dh]);

$this->loadModule('ScpiFrontStore','ScpiFrontStore', ['dh' => $this->dh]);

