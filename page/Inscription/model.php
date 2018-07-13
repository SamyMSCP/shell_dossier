<?php
$this->loadModule("ProgressBlock", "ProgressBlock", array(
	"prc" => 0,
	"data" =>array(
		"Vos informations personnelles",
		"Vérification",
		"Récapitulatif & Validation"
	)
));

$this->linkFIL =  Document::getOnlineFromNameType("FIL");
$this->linkCGU =  Document::getOnlineFromNameType("CGU");
