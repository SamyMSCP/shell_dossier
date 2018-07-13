<?php
$this->dh = Dh::getCurrent();
$dataTransaction = $this->dh->getCacheArrayTable();

$this->loadModule('Nav2', 'Nav2');
$this->loadModule('ToolTip','ToolTip');

$this->loadModule("MonCompte", "MonCompte", array(
	"dh" => $this->dh,
	"table" => $dataTransaction
	)
);

$this->loadModule("VueJsBaseComponent", "VueJsBaseComponent", []);

$this->loadModule("OpportuniteStore", "OpportuniteStore", []);

// Le module Scpi est déja chargé dans le module MonCompte
//$this->loadModule("ScpiFrontStore", "ScpiFrontStore", []);

$this->loadModule("OpportuniteListComponent", "OpportuniteListComponent", []);
$this->loadModule("ModuleCreationOpportunite", "ModuleCreationOpportunite", []);
$this->loadModule("Loading", "Loading", array());
$this->loadModule("ModuleBarre", "ModuleBarre", array("dh" => $this->dh));

$this->loadModule("AdressePostaleComponent", "AdressePostaleComponent", ["dh" => $this->dh]);
