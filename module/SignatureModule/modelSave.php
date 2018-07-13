<?php


// On récupère toutes les lettres de missions non signée et on vérifie si il y en a une en attente de validation.

// Si oui on la déclare comme validée et on rafraichi la page

// Si non on affiche le formulaire pour créer un nouvelle lettre de mission => want to sign

// Si non
// On vérifie si il y en a une qui est encore valable et on redirige sur la page universign pour la valider !






if (isset($GLOBALS['GET']['rt']) && $GLOBALS['GET']['rt'] == "ok") // Si j'ai une reponse okay du universign dans mon url
{
	echo "Le document est okay";
	exit();
	// Récupère toutes les lettres de missions pour cet utilisateur !
	$doc = $this->dh->getNewDocumentSignedByTypeId(4);

	// Vérifier si il n'y en a pas deja une en cours de validité !



	if (!isset($doc[0])) // Si j'ai deja un lien pour lui.
	{
		//Notif:set("err", "erreur");
		header("Location: ?p=" . $GLOBALS['GET']['p'] . "&projet=" . $GLOBALS['GET']['projet']);
		exit();
	}
	$signature = Signature::getInfoById($doc[0]->getIdUniversign());
	if ($signature['status'] == "completed")// Je check la validite au pres de universign ?
	{
		// Je set le document comme signe dans la bdd
		// Je confirme au client que la lettre de mission a ete validee.
		$doc[0]->setUniversignComplete();
	}
	else
	{
		// je r'envoi a la page de sprojets
	}
	header("Location: ?p=" . $GLOBALS['GET']['p'] . "&projet=" . $GLOBALS['GET']['projet']);
	exit();
}
else if (isset($GLOBALS['GET']['rt']) && $GLOBALS['GET']['rt'] == "ko") // Si j'ai une reponse KO du universign dans mon url
{
	//Notif::set("msgLM", "La signature de la lettre de mission a echouee");
	Notif::set("msgLM", "La signature de la lettre de mission a ete annulee");
	header("Location: ?p=" . $GLOBALS['GET']['p'] . "&projet=" . $GLOBALS['GET']['projet']);
	exit();
	// je Notifie une erreur.
	// je renvoi a la page de projets
}
else if (isset($GLOBALS['GET']['rt']) && $GLOBALS['GET']['rt'] == "cancel") // Si c'est annule
{
	Notif::set("msgLM", "La signature de la lettre de mission a ete annulee");
	header("Location: ?p=" . $GLOBALS['GET']['p'] . "&projet=" . $GLOBALS['GET']['projet']);
	exit();
}

if (isset($_POST['action']) && $_POST['action'] == "wantSign")
//if (1)
{
	// Le client doit etre redirige vers universign
	$doc = $this->dh->getNewDocumentSignedByTypeId(4); // 4 est l'id de la lettre de mission)

	if (isset($doc[0])) // Si j'ai deja un lien pour lui.
//	if (0)
	{
		//Verifier si le document a bien ete valide
		//$doc = $doc[0];
		$signature = Signature::getInfoById($doc[0]->getIdUniversign());
		if ($signature['status'] == "ready")// Je check la validite au pres de universign ?
		//if (!empty($doc[0]->url))
		{
			// Je renvoi le client a cette Url
			header("Location: " . $doc[0]->url);
			exit();
		}
		else //Je desactive l'entree et j'en cree une nouvelle.
		{
			if (!isset($_POST['duree']))
			{
				header("Location: ?p=" . $GLOBALS['GET']['p'] . "&projet=" . $GLOBALS['GET']['projet']);
				exit();
			}
			$duree = intval($_POST['duree']);
			$doc[0]->updateOneColumn('id_type_document', 0);
			ob_end_clean();
			$pdf = PdfGenerator::getNewLMFromDh2(Dh::getCurrent(), $duree)->getLm();
			$sig = Signature::getNewSignature($this->dh->getPersonnePhysique(), $pdf);
			if (!empty($sig['url']))
			{
				$this->dh->insertNewLM($sig['url'], $sig['id'], $pdf, $duree);
				header("Location: " . $sig['url']);
				exit();
			}
		}
	}
	else
	{
		if (!isset($_POST['duree']))
		{
			header("Location: ?p=" . $GLOBALS['GET']['p'] . "&projet=" . $GLOBALS['GET']['projet']);
			exit();
		}
		$duree = intval($_POST['duree']);
		// Je genere un document pour le clien.
		// Je l'envoi a universign et recupere l'url
		// Je genere une nouvelle entree dans la db avec l'url.
		// Je renvoi le client a l'Url
		//$pdf = PdfGenerator::getLM();
		ob_end_clean();
		$pdf = PdfGenerator::getNewLMFromDh2(Dh::getCurrent(), $duree)->getLm();
		$sig = Signature::getNewSignature($this->dh->getPersonnePhysique(), $pdf);
		$this->dh->insertNewLM($sig['url'], $sig['id'], $pdf, $duree);
		if (!empty($sig['url']))
		{
			$this->dh->insertNewLM($sig['url'], $sig['id'], $pdf, $duree);
			header("Location: " . $sig['url']);
			exit();
		}
		else
		{
			Notif::set('msgLm', 'Vous ne pouvez pas signer votre lettre de mission pour le moment, <br />Veuillez reessayer plus tard !');
			header("Location: ?p=" . $GLOBALS['GET']['p'] . "&projet=" . $GLOBALS['GET']['projet']);
			exit();
		}
		// Notif d'une erreur !
	}
}

$this->loadModule("ProgressBlock", "ProgressBlock3", array(
	"prc" => 0.01,
	"data" =>array(
		"Vos objectifs & lettre de mission",
		"Votre projet  d’investissement",
		"Votre situation juridique, financière, fiscale et patrimonial",
		"Vos connaissances",
		"Commencement de votre projet d’investissement"
	)
));
