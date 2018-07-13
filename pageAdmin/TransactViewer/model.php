<?php
$this->is_back = true;
$dh = Dh::getCurrent();
$this->dh = $dh;

//$dh = Dh::getById(10);

$dataTransaction = $dh->getCacheArrayTable();

$this->collaborateur = Dh::getCurrent();
$this->loadModuleAdmin("Nav", "Nav", array("collaborateur" => $this->collaborateur));
//$this->loadModuleAdmin("TransactionsStore", "TransactionsStore", array(
//	"dh" => $this->dh,
//	"table" => $this->dh->getCacheArrayTable()
//));
//$this->loadModuleAdmin("TransactionsComponent", "TransactionsComponent", []);
//$this->loadModuleAdmin("PortefeuilleComponent", "PortefeuilleComponent", ["dh" => $this->dh]);

$this->loadModuleAdmin("TransactionsStore", "TransactionsStore", array(
	"dh" => $this->dh,
	"table" => $this->dh->getCacheArrayTable()
));
$this->loadModuleAdmin("TransactStatusStore", "TransactStatusStore", array(
	"dh" => $this->dh,
	"table" => $this->dh->getCacheArrayTable()
));


$this->loadModuleAdmin("SocieteGestionStore", "SocieteGestionStore", []);
$this->loadModuleAdmin("ScpiStore", "ScpiStore", []);

$this->loadModule("ToolTip", "ToolTip", array());


/* ****************************************************************************************************************** */






$this->loadModuleAdmin("ListeDeroulante", "ListeDeroulante", array());
$this->loadModule("MessageBox", "MessageBox", array());


$this->loadModule("ckEditor", "ckEditor");

	$this->loadModule("SimpleFormulaire", "SimpleFormulaire");


	$this->loadModuleAdmin("Validate", "Validate", array(
		"collaborateur" => $this->collaborateur,
		"dh" => $this->dh
	));


//	$this->loadModuleAdmin("SituationsStores", "SituationsStores", array(
//		"dh" => $this->dh
//	));

//		$this->loadModuleAdmin('TransactionsComponent','TransactionsComponent', ['dh' => $this->dh]);

//		$this->loadModuleAdmin("BeneficiaireStore", "BeneficiaireStore", ["dh" => $this->dh]);

//		$this->loadModuleAdmin("DocumentsStore", "DocumentsStore", ["dh" => $this->dh]);
//
//		$this->loadModuleAdmin("DocumentsComponent1_5", "DocumentsComponent1_5", ["dh" => $this->dh]);

//		$this->loadModuleAdmin("ProjetStore", "ProjetStore", ["dh" => $this->dh]);



$this->loadModule("Loading", "Loading", array());

