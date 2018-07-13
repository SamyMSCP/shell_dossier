<?php
ComponentManager::loadComponentGenerated("ComponentModalStack");
$store =  StoreGenerator::getInstance();

////////////////////////////////////////////////////////////////////////////////
if (ENABLE_DEVTOOLS)
	$this->loadModule("DevTools", "DevTools", ["store" => $store]);
////////////////////////////////////////////////////////////////////////////////

$store->loadModule("StoreModuleModalStack", "StoreModuleModalStack");
$store->loadModule("StoreModuleProcessProjet", "StoreModuleProcessProjet");
$store->loadModule("StoreModuleCodeVille", "StoreModuleCodeVille");
$store->loadModule("StoreModuleDocument", "StoreModuleDocument");

$this->loadModule("ModuleComponentManager", "ModuleComponentManager", []);
$store->loadDonneurDOrdre($this->dh);
$store->setSelected($this->dh);
$store->addToState(CategorieProfessionelle::getAll());
$store->addToState(CodeNaf::getAll());
