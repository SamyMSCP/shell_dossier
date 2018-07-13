<?php
$this->Pp = $this->beneficiaire->getPersonnePhysique();

if ($this->projet->etat_du_projet == -1) // Check si l'etat du projet est -1
{
	if (0)
	{
		$this->loadModule("formThisPage", "SignatureModule", array(
			"dh" => $dh
		));
	}
	else if (
	    $this->Pp[0]->getResetSituationJuridique() ||
        empty($this->Pp[0]->getLastSituationJuridique()) ||
        !$this->Pp[0]->getLastSituationJuridique()->isValide() ||
        !$this->Pp[0]->situationSetted() ||
        (isset($this->Pp[1]) && !$this->Pp[1]->situationSetted())
    )
	{
		if (isset($this->Pp[1]))
		{
			$this->loadModule("formThisPage", "SetSituationJuridique", array(
				"dh" => $dh,
				"ben" => $this->beneficiaire,
				"Pp" => $this->Pp[0],
				"Pp2" => $this->Pp[1]
			));
		}
		else
		{
			$this->loadModule("formThisPage", "SetSituationJuridique", array(
				"dh" => $dh,
				"ben" => $this->beneficiaire,
				"Pp" => $this->Pp[0]
			));
		}
		// Affiche le module pour le renseignement de situation Juridique
	}
	else if ($this->Pp[0]->getResetSituationFinanciere() || empty($this->Pp[0]->getLastSituationFinanciere()) || !$this->Pp[0]->getLastSituationFinanciere()->isValide())
	// Check si la situation Financiere n'est pas a jours ou non  renseignee
	{
		$this->loadModule("formThisPage", "SetSituationFinanciere", array(
			"dh" => $dh,
			"ben" => $this->beneficiaire,
			"Pp" => $this->Pp[0]
		));
		// Affiche le module pour le renseignement de situation Financiere
	}
	else if ($this->Pp[0]->getResetSituationFiscale() || empty($this->Pp[0]->getLastSituationFiscale()) || !$this->Pp[0]->getLastSituationFiscale()->isValide())
	// Check si la situation Fiscale n'est pas a jours ou non  renseignee
	{
		$this->loadModule("formThisPage", "SetSituationFiscale", array(
			"dh" => $dh,
			"ben" => $this->beneficiaire,
			"Pp" => $this->Pp[0]
		));
		// Affiche le module pour le renseignement de situation Fiscale
	}
	else if ($this->Pp[0]->getResetSituationPatrimoniale() || empty($this->Pp[0]->getLastSituationPatrimoniale()) || !$this->Pp[0]->getLastSituationPatrimoniale()->isValide())
	// Check si la situation Patrimoniale n'est pas a jours ou non  renseignee
	{
		$this->loadModule("formThisPage", "SetSituationPatrimoniale", array(
			"dh" => $dh,
			"ben" => $this->beneficiaire,
			"Pp" => $this->Pp[0]
		));
		// Affiche le module pour le renseignement de situation Patrimoniale
	}
	else if (empty($this->Pp[0]->getLastProfilInvestisseur()) || !$this->Pp[0]->getLastProfilInvestisseur()->isValide())
	{
		$this->loadModule("formThisPage", "SetProfilInvestisseur", array(
			"dh" => $dh,
			"ben" => $this->beneficiaire,
			"Pp" => $this->Pp[0],
			"haveSecond" => true
		));
		// Affiche le module pour le renseignement du profil investisseur 
	}
	else if (isset($this->Pp[1]) && (empty($this->Pp[1]->getLastProfilInvestisseur()) || !$this->Pp[1]->getLastProfilInvestisseur()->isValide()))
	{
		$this->loadModule("formThisPage", "SetProfilInvestisseur", array(
			"dh" => $dh,
			"ben" => $this->beneficiaire,
			"Pp" => $this->Pp[1]
		));
		// Affiche le module pour le renseignement du profil investisseur
	}
	else
	{
		// Le client a finis la création de son Projet.

		// On insert une tache Crm au conseiller du client
		$id_crm = Crm2::insertNew(
			$dh->id_dh,
			5,
			1,
			time(),
			-2700,
			$this->collaborateur->getShortName() . " a créé un nouveau projet d'investissement pour le bénéficiaire : " . $this->beneficiaire->getShortName(),
			serialize([$this->projet->id]),
			0
		);

		if (empty($id_crm))
		{
			Notif::set("addProject", "Le changement de status du projet n'a pas pu aboutir.");
			header("Location: ?p=" . $GLOBALS['GET']['p']);
			exit();
		}

		Crm2::getFromId($id_crm)[0]->updateOneColumn("priority", 5);

		$log = Logger::setNew("Nouveau Projet", $dh->id_dh, $dh->id_dh, [
			'Id du Crm' => $id_crm,
			'Beneficiaire' => $this->beneficiaire->getShortName(),
			'Id du projet' => $this->projet->id,
			'Nom du projet' => $this->projet->getName(),
			'link' => '?p=EditionClient&client=' . $dh->id_dh
		]);

		if (empty($log))
		{
			Notif::set("addProject", "Le changement de status du projet n'a pas pu aboutir.");
			header("Location: ?p=" . $GLOBALS['GET']['p']);
			exit();
		}

		// On insert un log

		//Page de remerciement
		$this->loadModule("formThisPage", "ThanksNewProject", array(
			"dh" => $dh,
			"ben" => $this->beneficiaire,
			"Pp" => $this->Pp[0]
		));

		//	Mail remerciement !
		$dh->sendMail("Votre Projet d'investissement à bien été enregistré", "", "thanksNewProject");

		// Ce projet peux passer a l'etape 0;
		//	on change l'etat du projet a 0
		$this->projet->updateOneColumn("etat_du_projet", "0");
	}
}
else
{
	header("Location: ?p=EditionClient&client=" . $dh->id_dh);
	exit();
}
