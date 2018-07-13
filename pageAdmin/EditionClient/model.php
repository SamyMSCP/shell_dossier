<?php
$this->collaborateur = Dh::getCurrent();
$this->loadModuleAdmin("Nav", "Nav", array("collaborateur" => $this->collaborateur));
$this->loadModule("ToolTip", "ToolTip", array());
$this->loadModuleAdmin("ListeDeroulante", "ListeDeroulante", array());
$this->loadModule("MessageBox", "MessageBox", array());

if (isset($GLOBALS['GET']['client']))
{
	$this->dh = Dh::getById($GLOBALS['GET']["client"]);

	if ($this->collaborateur->type == "prospecteur" && $this->dh->getType() != "client" && !empty($this->dh->getType()))
	{
		Notif::set("AccessDenied", "Vous n'avez pas acces à cette page !");
		header("Location: ?p=Accueil");
		exit();
	}
	//echo $this->dh->getType(); exit();

	if ($this->collaborateur->type != "yoda"
		&& $this->collaborateur->type != "backoffice"
		&& $this->collaborateur->type != "chefprojet"
		&& $this->collaborateur->id_dh != $this->dh->conseiller
		&& $this->dh->vip)
	{
		Notif::set("AccessDenied", "Vous n'avez pas acces a ce client");
		header("Location: ?p=Accueil");
		exit();
	}

	$this->title = $this->dh->getShortName();

	$dataTransaction = $this->dh->getCacheArrayTable();
	$dataTransactionBen = array();
	foreach($this->dh->getBeneficiaires() as $key => $elm)
	{ 
		$dataTransactionBen[$elm->id_benf] = $elm->getCacheArrayTable();
	}

	$this->loadModule("SimpleFormulaire", "SimpleFormulaire");

	$this->loadModuleAdmin("DonneurDOrdreStore", "DonneurDOrdreStore", array(
		"dh" => $this->dh
	));


/*
	$this->loadModuleAdmin("PersonnePhysiqueStore", "PersonnePhysiqueStore", array(
		"dh" => $this->dh
	));
*/
	$this->loadModule("SeeProfilComponent", "SeeProfilComponent", array(
		"dh" => $this->dh
	));

	$this->loadModuleAdmin("Validate", "Validate", array(
		"collaborateur" => $this->collaborateur,
		"dh" => $this->dh
	));

	$this->loadModuleAdmin("InformationsClient", "InformationsClient", array(
		"collaborateur" => $this->collaborateur,
		"dh" => $this->dh
	));

	if ($this->collaborateur->getType() != "prospecteur")
	{

		$this->loadModuleAdmin("SituationsStores", "SituationsStores", array(
			"dh" => $this->dh
		));

		$this->loadModuleAdmin('TransactionsComponent','TransactionsComponent', ['dh' => $this->dh]);

		$this->loadModuleAdmin("tableauDeBordClient", "tableauDeBordClient", array(
			"collaborateur" => $this->collaborateur,
			"dh" => $this->dh,
			"table" => $dataTransaction
		));

		$this->loadModuleAdmin("TransactionsStore", "TransactionsStore", array(
			"dh" => $this->dh,
			"table" => $dataTransaction
		));

		$this->loadModuleAdmin("ScpiStore", "ScpiStore", array(
			"dh" => $this->dh
		));

		$this->loadModuleAdmin("BeneficiaireStore", "BeneficiaireStore", array(
			"dh" => $this->dh
		));

		$this->loadModuleAdmin("DocumentsStore", "DocumentsStore", array(
			"dh" => $this->dh
		));

		$this->loadModuleAdmin("DocumentsComponent1_5", "DocumentsComponent1_5", array(
			"dh" => $this->dh
		));

		$this->loadModuleAdmin("ProjetStore", "ProjetStore",[
			"dh" => $this->dh
		]);

	}

	$this->loadModuleAdmin("OngletsClients", "OngletsClients", array(
		"collaborateur" => $this->collaborateur,
		"dh" => $this->dh,
		"table" => $dataTransaction,
		"tableBen" => $dataTransactionBen
	));

	$dh2 = DonneurDOrdre::getById(intval($_GET['client']));
	$this->loadModuleAdmin("ModuleProjetStore", "ModuleProjetStore",[
		"dh" => $dh2
	]);
}
else
{
	Notif::set("AccessDenied", "L'url demandé est mal formatée !");
	header("Location: ?p=Accueil");
	exit();
}

$this->loadModule("Loading", "Loading", array());
