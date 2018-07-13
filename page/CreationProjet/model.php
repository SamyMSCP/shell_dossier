<?php
$dh = Dh::getCurrent();

$dataTransaction = $dh->getCacheArrayTable();

$this->loadModule("MonCompte", "MonCompte", array(
	"dh" => $dh,
	"table" => $dataTransaction
	)
);

$this->loadModule("Nav2", "Nav2", array(
	"dh" => $dh
));

$this->loadModule("ToolTip", "ToolTip", array());

if (!$dh->lettreMissionOkay()) //Check si il y a bien une lettre de mission en cours de validite
{
	$this->loadModule("SetProject", "SignatureModule", array(
		"dh" => $dh
	));
}
else // Check si Lettre de mission en cours de validite.
{
	$this->loadModule("SetProject", "SetProject", array(
		"dh" => $dh
	));
}

$this->loadModule("AdressePostaleComponent", "AdressePostaleComponent", ["dh" => $dh]);
