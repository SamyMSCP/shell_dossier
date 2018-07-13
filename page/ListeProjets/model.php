<?php
$dh = Dh::getCurrent();
//$dh = Dh::getById(10);

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

$this->projets = Projet::getFromDh($dh->id_dh);


if (count($this->projets))// Verifier si il y a deja au moin un projet existant
{
	if (!$dh->lettreMissionOkay()) //Check si il y a bien une lettre de mission en cours de validite
	{
		$this->loadModule("ShowProjetClient", "SignatureModule", array(
			"dh" => $dh
		));
	}
	else
	{
		$this->loadModule("ShowProjetClient", "ShowProjetClient", array(
			"dh" => $dh,
			"projets" => $this->projets
		));
	}
}
else
{
	$_SESSION['click_see_project'] = true;
	//Notif::set('MsgNeedCreate', "Vous n'avez pas encore de projet");
	header("Location: ?p=CreationProjet");
	exit();
}


$this->loadModule("AdressePostaleComponent", "AdressePostaleComponent", ["dh" => $dh]);
