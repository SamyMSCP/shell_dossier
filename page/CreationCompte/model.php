<?php

$this->loadModule("Nav2Minimal", "Nav2Minimal");
if (!empty(Dh::getCurrent()))
{
	header('Location: ?p=Portefeuille');
	exit();
}

////////////////////////////////////////////
$this->state = 0;
// 0 : arrivée sur la page 
// 1 : déja passé une première fois mais il y a eu un probleme ( on prerempli le formulaire)
// 2 : le compte utilisateur a été crée. on affiche la 2ème page. et on passe avec un setTimeout a la page 3.
///////////////////////////////////////////
//$prc = 0.1;
//$this->state = 3;
$this->linkFIL =  Document::getOnlineFromNameType("FIL");
$this->linkCGU =  Document::getOnlineFromNameType("CGU");

if (count($_POST)) // Si donnees en post alors on enregistre le nouvel utilisateur.
//if (0)
{
	$prc = 0.1;
	if ($this->addNewUser())
	{
		$this->state = 3;
	}
	else
	{
		$this->state = 2;
	}
	// On check les donnees et si tout est valide on enregistre le nouvel utilisateur.
}
//if (0)
else // Si utilisateur non connecte
{
	$this->state = 1;
	$prc = 0.1;
	// On presente le formulaire d'inscription avec un token csrf
}


$this->loadModule("ProgressBlock", "ProgressBlock3", array(
	"prc" => $prc,
	"data" =>array(
		"Vos informations personnelles",
		"Vérification",
		"Validation"
	)
));

$this->loadModule("Loading", "Loading", array());
