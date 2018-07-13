<?php

if (!empty($this->Pp->getLastProfilInvestisseur()) && $this->Pp->getLastProfilInvestisseur()->getStatus() == 1 && !isset($GLOBALS['GET']['Pp']))
	$this->isAdd = true;
else
	$this->isAdd = false;

if(isset($_POST['action']) && $_POST['action'] == "setNewProfilInvestisseur")
{
	$this->isAdd = $this->setNewProfilInvestisseur();
}
else if(isset($_POST['action']) && $_POST['action'] == "addProfil")
{
	$this->setProfilResult();
	if (isset($GLOBALS['GET']['projet']))
		header("Location: ?p=" . $GLOBALS['GET']['p'] . "&projet=" . $GLOBALS['GET']['projet'] . (isset($GLOBALS['GET']['client']) ? "&client=" . intval($GLOBALS['GET']['client']) : ""));
	else if (isset($GLOBALS['GET']['Pp']))
		header("Location: ?p=" . $GLOBALS['GET']['p'] . "&Pp=" . $GLOBALS['GET']['Pp'] . (isset($GLOBALS['GET']['client']) ? "&client=" . intval($GLOBALS['GET']['client']) : ""));
	exit();
}

//if (!$this->isAdd)
	//Notif::set("ProfilPourQuie", "Vous allez compléter le profil investisseur de " . $this->Pp->getShortName());

$this->loadModule("ProgressBlock", "ProgressBlock3", array(
	"prc" => 3,
	"data" =>array(
		"Vos objectifs & lettre de mission",
		"Votre projet  d’investissement",
		"Votre situation juridique, financière, fiscale et patrimonial",
		"Vos connaissances",
		"Commencement de votre projet d’investissement"
	)
));

if ($this->isAdd)
{
	$this->profil = $this->Pp->getLastProfilInvestisseur()->getProfil();
	$this->profilInstance = $this->Pp->getLastProfilInvestisseur();
}
