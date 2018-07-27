<?php
$this->dh = Dh::getCurrent();


if (isset($_POST['button2id']) && $_POST['button2id'] == 'addTransaction')
	$this->insertNewTransaction();

$dataTransaction = $this->dh->getCacheArrayTable();

if (
	$this->dh->getPersonnePhysique()->getPhone() == "-" ||
	empty($this->dh->getPersonnePhysique()->getPhone())
)
{
	$this->loadModule("ForceSetPhone", "ForceSetPhone", array("dh" => $this->dh));
}
$this->loadModule("MonCompte", "MonCompte", array(
	"dh" => $this->dh,
	"table" => $dataTransaction
	)
);

$this->loadModule("Nav2", "Nav2", array("dh" => $this->dh));

$this->loadModule("moduleDocumentDhValidationCGU", "moduleDocumentDhValidation", array(
	"documentTypeName" => "CGU",
	"dh" => $this->dh
	)
);

$this->loadModule("moduleDocumentDhValidationFIL", "moduleDocumentDhValidation", array(
	"documentTypeName" => "FIL",
	"dh" => $this->dh
	)
);

$this->loadModule("ToolTip", "ToolTip", array());

$this->loadModule("NotNow", "NotNow", array("dh" => $this->dh));


//$this->loadModule("MessageBox", "MessageBox", []);
$this->loadModule("Loading", "Loading", array());

$this->loadModule("AdressePostaleComponent", "AdressePostaleComponent", ["dh" => $this->dh]);


/*
	NEW
*/
$this->loadModule('VueJsBaseComponent','VueJsBaseComponent');

$this->loadModule('TransactionFrontStore','TransactionFrontStore', ["dh" => $this->dh]);


$this->loadModule('TableauPortefeuille','TableauPortefeuille', ["dh" => $this->dh]);
$this->loadModule('ApercuDeMonPortefeuilleStatRepartition','ApercuDeMonPortefeuilleStatRepartition', ["dh" => $this->dh]);
$this->loadModule('AvertissementPortefeuilleV3','AvertissementPortefeuilleV3');
$this->loadModule('ScpiSearchSelect','ScpiSearchSelect');

$this->loadModule('FooterPortefeuilleV3','FooterPortefeuilleV3', ["dh" => $this->dh]);




$this->loadModule("TooltipComponent", "TooltipComponent");




