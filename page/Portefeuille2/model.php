<?php
$this->dh = Dh::getCurrent();

$dataTransaction = $this->dh->getCacheArrayTable();

$this->loadModule('Nav2', 'Nav2');
$this->loadModule('ToolTip','ToolTip');
$this->loadModule("Loading", "Loading", array());
$this->loadModule("MonCompte", "MonCompte", ["dh" => $this->dh, "table" => $dataTransaction]);

// Load List component
$this->loadModule('VueJsBaseComponent','VueJsBaseComponent');
$this->loadModule('PortefeuillePreviewComponent','PortefeuillePreviewComponent');
$this->loadModule('PortefeuilleBlocsInfos','PortefeuilleBlocsInfos');
$this->loadModule('PortefeuilleModuleStats','PortefeuilleModuleStats');
$this->loadModule('PortefeuilleReinvest','PortefeuilleReinvest');
$this->loadModule('PortefeuilleModale','PortefeuilleModale');
$this->loadModule('PortefeuilleVente','PortefeuilleVente');
$this->loadModule('PortefeuilleCession','PortefeuilleCession');
$this->loadModule('PortefeuilleStats','PortefeuilleStats');
$this->loadModule('TooltipComponent','TooltipComponent');

$this->loadModule('TransactionFrontStore','TransactionFrontStore', ["dh" => $this->dh]);
$this->loadModule('TransactionFrontComponent','TransactionFrontComponent', ["dh" => $this->dh]);

$this->loadModule("Footer", "Footer", array("dh" => $this->dh));
$this->loadModule("ModuleBarreBleu", "ModuleBarreBleu", array("dh" => $this->dh));

$this->loadModule("RepartitionGeographique", "RepartitionGeographique", array(
	"dh" => $this->dh,
	"table" => $dataTransaction
	)
);

$this->loadModule("RepartitionParCategorie", "RepartitionParCategorie", array(
	"dh" => $this->dh,
	"table" => $dataTransaction
	)
);