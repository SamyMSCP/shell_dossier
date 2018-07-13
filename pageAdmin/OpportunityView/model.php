<?php
$this->is_back = true;
$this->collaborateur = Dh::getCurrent();
//$dataTransaction = $dh->getCacheArrayTable();

$this->loadModule("ToolTip", "ToolTip", array());
//$this->loadModule("AdvancedOpResearch", "AdvancedOpResearch", array());

$this->loadModuleAdmin('ScpiStore','ScpiStore', array());

$this->loadModuleAdmin("Nav", "Nav", array("collaborateur" => $this->collaborateur));
$this->loadModule('ToolTip','ToolTip');

$this->loadModule("VueJsBaseComponent", "VueJsBaseComponent", []);
$this->loadModule("OpportuniteStore", "OpportuniteStore", []);

// Le module Scpi est déja chargé dans le module MonCompte
//$this->loadModule("ScpiFrontStore", "ScpiFrontStore", []);

$this->loadModule("OpportuniteListComponent", "OpportuniteListComponent", []);
$this->loadModule("ModuleCreationOpportunite", "ModuleCreationOpportunite", []);
$this->loadModule("Loading", "Loading", array());
