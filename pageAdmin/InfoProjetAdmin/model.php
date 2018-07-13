<?php
if (!isset($GLOBALS['GET']['client']))
{
	Notif::set("CreateProject", "La requete pour renseigner les situations clients n'est pas valide");
	header('Location: ?p=Accueil');
	exit();
}

// Vérifier que le collaborateur est bien les conseiller du client en question !

$dh = Dh::getById(intval($GLOBALS['GET']['client']));
//$dh = Dh::getById(10);

$this->collaborateur = Dh::getCurrent();

$this->loadModuleAdmin("Nav", "Nav", array("collaborateur" => $this->collaborateur));
$this->loadModule("ToolTip", "ToolTip", array());
$this->loadModuleAdmin("ListeDeroulante", "ListeDeroulante", array());
$this->loadModule("MessageBox", "MessageBox", array());
if (!isset($GLOBALS['GET']['projet']))
{
	header('Location: ?p=EditionClient&client=' . $dh->id_dh);
	exit();
}


// Récupère le projet passé en parametre
$this->projet = Projet::getFromId(decrypt_url($GLOBALS['GET']['projet']));
if (count($this->projet))
	$this->projet = $this->projet[0];
else
{
	header('Location: ?p=EditionClient&client=' . $dh->id_dh);
	exit();
}

$this->formThisPage = "";
$this->beneficiaire = $this->projet->getBeneficiairesEntity();

if ($dh->id_dh != $this->beneficiaire->id_dh)
{
	Notif::set("NoLm", "Le bénéficiaire et le projet ne semblent pas correspondre !");
	header('Location: ?p=EditionClient&client=' . $dh->id_dh);
	exit();
}

if (!$dh->lettreMissionOkay()) 
{
	Notif::set("NoLm", "Le donneur d'ordre ne semble pas avoir de Lettre de mission en cours de validité !");
	header('Location: ?p=CreationProjetAdmin&client=' . $dh->id_dh);
	exit();
}

if ($this->beneficiaire->getTypeBeneficiaire() == "Pm")
	include('forPm.php');
else
	include('forPp.php');
