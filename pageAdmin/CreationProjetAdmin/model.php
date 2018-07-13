<?php
$this->collaborateur = Dh::getCurrent();
if (!isset($GLOBALS['GET']['client']))
{
	Notif::set("CreateProject", "La requete pour créer un projet n'est pas valide");
	header("Location: ?p=Accueil");
	exit();
}

// Vérifier que le collaborateur est bien les conseiller du client en question !

$dh = Dh::getById(intval($GLOBALS['GET']['client']));


$this->loadModuleAdmin("Nav", "Nav", array("collaborateur" => $this->collaborateur));
$this->loadModule("ToolTip", "ToolTip", array());
$this->loadModuleAdmin("ListeDeroulante", "ListeDeroulante", array());
$this->loadModule("MessageBox", "MessageBox", array());

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
