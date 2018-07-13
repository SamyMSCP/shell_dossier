<?php
//	$this->loadModule('LandingHeader','LandingHeader', []);
$this->loadModule("LandingHeader", "LandingHeader", []);
$this->loadModule("LandingFeatures", "LandingFeatures", [
	"b0" => "outil gratuit",
	"b1" => "plateforme sécurisée",
	"b2" => "Informations en temps réel"
]);
$this->loadModule("LandingMedia", "LandingMedia", [
	"Citation" => "« Mon Compte SCPI, un compte client gratuit permettant aux détenteurs de parts de SCPI de suivre en temps réel l’évolution de leur investissement »",
	"Who" => "Journal du Net - Avril 2017"
]);
$this->loadModule("LandingBottom", "LandingBottom", [
	"partenariat" => "linxo"
]);
//$this->loadModule("LandingBottom", "LandingBottom", []);
$this->loadModule("LandingFooter", "LandingFooter", []);
$this->loadModule("LandingLinxoContent", "LandingLinxoContent", ["code" => 3]);


/* ****************************************************************************************************************** */
//$this->state = 0;
//
//$this->linkFIL =  Document::getOnlineFromNameType("FIL");
//$this->linkCGU =  Document::getOnlineFromNameType("CGU");
//
//if (count($_POST)) // Si donnees en post alors on enregistre le nouvel utilisateur.
////if (0)
//{
//	$prc = 0.1;
//	if ($this->addNewUser())
//	{
//		$this->state = 3;
//	}
//	else
//	{
//		$this->state = 2;
//	}
//	// On check les donnees et si tout est valide on enregistre le nouvel utilisateur.
//}
//else // Si utilisateur non connecte
//{
//	$this->state = 1;
//	$prc = 0.1;
//	// On presente le formulaire d'inscription avec un token csrf
//}


//dbg($GLOBALS['_GET']);
//dbg($GLOBALS['_POST']);

//$this->loadModule("Loading", "Loading", array());