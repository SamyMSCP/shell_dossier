<?php
$dh = Dh::getCurrent();
//$dh = Dh::getById(10);
if (!isset($GLOBALS['GET']['projet']))
{
	header('Location: ?p=ListeProjets');
	exit();
}
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

// Récupère le projet passé en parametre
$this->projet = Projet::getFromId(decrypt_url($GLOBALS['GET']['projet']));
if (count($this->projet))
	$this->projet = $this->projet[0];
else
{
	header('Location: ?p=ListeProjets');
	exit();
}

$this->formThisPage = "";
$this->beneficiaire = $this->projet->getBeneficiairesEntity();

if ($dh->id_dh != $this->beneficiaire->id_dh || !$dh->lettreMissionOkay()) //Check si le beneficiaire appartien bien au donneur d'ordre connecté et si il y a bien une lettre de mission en cours de validite
{
	header('Location: ?p=ListeProjets');
	exit();
}

if ($this->beneficiaire->getTypeBeneficiaire() == "Pm")
	include('forPm.php');
else
	include('forPp.php');
