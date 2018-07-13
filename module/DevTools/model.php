<?php
//$this->store->loadModule("StoreModuleDevtools");
ComponentManager::loadComponentGenerated("ComponentDevtools");
ComponentManager::loadComponentGenerated("ComponentTable2EditTable", "DonneurDOrdre", []);
ComponentManager::loadComponentGenerated("ComponentListTable2Table", "DonneurDOrdre", [
	"column" => [
		"login" , "ko", "vip"
	],
	"selected" => "\$store.getters.getSelectedDonneurDOrdre"
]);

ComponentManager::loadComponentGenerated("ComponentTable2EditTable", "PersonnePhysique", []);
ComponentManager::loadComponentGenerated("ComponentListTable2Table", "PersonnePhysique", [
	"column" => [
		"civilite", "prenom", "nom"//, "mail"
	],
	"selected" => "\$store.getters.getSelectedPersonnePhysique"
]);

ComponentManager::loadComponentGenerated("ComponentTable2EditTable", "Beneficiaire2", []);
ComponentManager::loadComponentGenerated("ComponentListTable2Table", "Beneficiaire2", [
	"column" => [
		"id_dh", "type_ben"
	],
	"selected" => "\$store.getters.getSelectedBeneficiaire2"
]);

ComponentManager::loadComponentGenerated("ComponentTable2EditTable", "Projet2", []);
ComponentManager::loadComponentGenerated("ComponentListTable2Table", "Projet2", [
	"column" => [
		"nom"
	],
	"selected" => "\$store.getters.getSelectedProjet2"
]);
ComponentManager::loadComponentGenerated("ComponentTable2EditTable", "SituationPhysique", []);
ComponentManager::loadComponentGenerated("ComponentListTable2Table", "SituationPhysique", [
	"column" => [
		"id_situation"
	],
	"selected" => "\$store.getters.getSelectedSituationPhysique"
]);

ComponentManager::loadComponentGenerated("ComponentTable2EditTable", "ProfilInvestisseur2", []);
ComponentManager::loadComponentGenerated("ComponentListTable2Table", "ProfilInvestisseur2", [
	"column" => [
	],
	"selected" => "\$store.getters.getSelectedProfilInvestisseur2"
]);
