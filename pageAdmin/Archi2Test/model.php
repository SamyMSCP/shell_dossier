<?php

ComponentManager::loadComponentGenerated("ComponentSimpleBlockMscpi");


ComponentManager::loadComponentGenerated("ComponentTable2EditUlli", "DonneurDOrdre", []);
ComponentManager::loadComponentGenerated("ComponentListTable2Table", "DonneurDOrdre", [
	"column" => [
		"login" , "ko", "vip"
	]
]);

ComponentManager::loadComponentGenerated("ComponentTable2EditUlli", "PersonnePhysique", []);
ComponentManager::loadComponentGenerated("ComponentListTable2Table", "PersonnePhysique", [
	"column" => [
		"prenom", "nom", "mail"
	]
]);

ComponentManager::loadComponentGenerated("ComponentTable2EditUlli", "Beneficiaire2", []);
ComponentManager::loadComponentGenerated("ComponentListTable2Table", "Beneficiaire2", [
	"column" => [
		"id_dh", "type_ben"
	]
]);

ComponentManager::loadComponentGenerated("ComponentTable2EditUlli", "Projet2", []);
ComponentManager::loadComponentGenerated("ComponentListTable2Table", "Projet2", [
	"column" => [
		"nom"
	]
]);

//dbg(ComponentManager::getComponents());
//dbg(ComponentManager::getScriptHead()); exit();

$this->loadModule("ModuleComponentManager", "ModuleComponentManager", []);


$store = new StoreGenerator("mscpi");
$store->addPage("CreationProjet", [ "title" => "Création de projet", "Component" => "" ]);
$store->addPage("SituationJuridique", [ "title" => "Situation Juridique", "Component" => "" ]);
$store->addPage("SituationFinanciere", [ "title" => "Situation Financière", "Component" => "" ]);
$store->addPage("SituationFiscale", [ "title" => "Situation Fiscale", "Component" => "" ]);
$store->addPage("SituationPatrimoniale", [ "title" => "Situation Patrimoniale", "Component" => "" ]);

for ($i = 54; $i < 57; $i++) {
	$store->loadDonneurDOrdre(DonneurDOrdre::getById($i));
}

$store->addToState(DonneurDOrdre::getById(140));

