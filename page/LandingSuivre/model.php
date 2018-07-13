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
//$this->loadModule("LandingBottom", "LandingBottom", [
//	"partenariat" => "linxo"
//]);
//$this->loadModule("LandingBottom", "LandingBottom", []);
$this->loadModule("LandingFooter", "LandingFooter", []);
$this->loadModule("LandingLinxoContent", "LandingLinxoContent", ["code" => 9]);
