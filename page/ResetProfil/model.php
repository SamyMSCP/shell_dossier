<?php
$dh = Dh::getCurrent();
//$dh = Dh::getById(10);
if (!isset($GLOBALS['GET']['Pp']))
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

$this->Pp = Pp::getFromId(intval($GLOBALS['GET']['Pp']));
if (empty($this->Pp))
{
	Notif::set('ResetProfil', "Vous ne pouvez pas définir ce profil d'investisseur");
	header('Location: ?p=ListeProjets');
	exit();
}
$this->Pp = $this->Pp[0];
if ($this->Pp->lien_dh != $dh->id_dh)
{
	Notif::set('ResetProfil', "Vous ne pouvez pas définir ce profil d'investisseur");
	header('Location: ?p=ListeProjets');
	exit();
}

$this->loadModule("formThisPage", "SetProfilInvestisseur", array(
	"dh" => $dh,
	"Pp" => $this->Pp
));
