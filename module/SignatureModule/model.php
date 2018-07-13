<?php
$dhType = Dh::getCurrent()->getType();
if (isset($_POST['action']) && $_POST['action'] == "wantSign")
{
	// On génere sstematiquement une nouvelle lettre de mission car il pourrait tres bien avoir changé une des informations, nom prenom, telephone mail ou durée

	// On vérifie si la durée est bien récupérée
	if (!isset($_POST['duree']))
	{
		if ($dhType == null || $dhType == "client")
			header("Location: ?p=" . $GLOBALS['GET']['p'] . "&projet=" . $GLOBALS['GET']['projet']);
		else
			header("Location: ?p=" . $GLOBALS['GET']['p'] . "&projet=" . $GLOBALS['GET']['projet'] . "&client=" . intval($GLOBALS['GET']['client']));
		exit();
	}
	$duree = intval($_POST['duree']);

	// On génère un nouveau pdf
	ob_end_clean();
	$pdf = PdfGenerator::getNewLMFromDh2($this->dh, $duree)->getLm();

	// On crée un nouveau document a signer chez universign qui nous transmet l'url pour la signature !
	if ($dhType == null || $dhType == "client")
		$sig = Signature::getNewSignature($this->dh->getPersonnePhysique(), $pdf);
	else
		$sig = Signature::getNewSignature($this->dh->getPersonnePhysique(), $pdf, true);

	if (!empty($sig['url'])) // si tout s'est bien passé on redirige le client vers universign !
	{
		$this->dh->insertNewLM($sig['url'], $sig['id'], $pdf, $duree);
		//if ($dhType == null || $dhType == "client")
		if (isFrontOffice())
			header("Location: " . $sig['url']);
		else
		{
			Notif::set("signLM", "Le client à été notifié pour signer la lettre de mission par email !");
			header("Location: ?p=EditionClient&client=" . intval($GLOBALS['GET']['client']));
		}
		exit();
	}
	else // sinon on met un message d'erreur
	{
		Notif::set('msgLm', 'Vous ne pouvez pas signer votre lettre de mission pour le moment, <br />Veuillez reessayer plus tard !');
		$Location = "Location: ?p=" . $GLOBALS['GET']['p'];
		if (isset($GLOBALS['GET']['projet']) && !empty($GLOBALS['GET']['projet']))
			$Location .= "&projet=" . $GLOBALS['GET']['projet'];
		if (isset($GLOBALS['GET']['client']) && !empty($GLOBALS['GET']['client']))
			$Location .= "&client=" . $GLOBALS['GET']['client'];
		header($Location);
		exit();
	}
}


// On boucle sur toutes les lettre de mission existantes et non validé;

$doc = $this->dh->getNewDocumentSignedByTypeId(4);
//dbg($doc);

//exit();
foreach ($doc as $key => $elm)
{

	// Si ce document n'a pas d'entrée chez universign ou que celui-ci est déja signé on sort de la boucle
	if (empty($elm->id_universign) || !empty($elm->signed))
		continue;

	$temoin = false;
	// on vérifie au pres d'universign si ce document n'est pas signé en réalité.
	$signature = Signature::getInfoById($elm->getIdUniversign());
	//dbg($signature);
	if ($signature['status'] == "completed")// Je check la validite au pres de universign ?
	{
		// Je set le document comme signe dans la bdd
		$elm->setUniversignComplete();
		$temoin = true;
	}

	if ($temoin) // On a validé un document
	{
		$location = "Location: ?p=" . $GLOBALS['GET']['p'];
		if (isset($GLOBALS['GET']['projet']) && !empty($GLOBALS['GET']['projet']))
			$Location .= "&projet=" . $GLOBALS['GET']['projet'];
		if ($dhType == null || $dhType == "client")
			$Location .= "&client=" . $GLOBALS['GET']['client'];
		header($location);
		exit();
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
