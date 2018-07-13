<?php
$this->state = 0;

$this->linkFIL =  Document::getOnlineFromNameType("FIL");
$this->linkCGU =  Document::getOnlineFromNameType("CGU");

//var_dump($_POST);
//var_dump($GLOBALS['POST']);
if (count($_POST)) // Si donnees en post alors on enregistre le nouvel utilisateur.
//if (0)
{
	$prc = 0.1;
//	if ($this->addNewUser())
//	{
//		$this->state = 3;
//	}
//	else
//	{
		$this->state = 2;
//	}
	// On check les donnees et si tout est valide on enregistre le nouvel utilisateur.
}
else // Si utilisateur non connecte
{
	$this->state = 1;
	$prc = 0.1;
	// On presente le formulaire d'inscription avec un token csrf
}