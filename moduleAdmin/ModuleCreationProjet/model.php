<?php
//ComponentManager::loadComponentGenerated("ComponentTypeShow");
ComponentManager::loadComponentGenerated("ComponentModalStack");


ComponentManager::loadComponentGenerated("ComponentProjectTitle");

ComponentManager::loadComponentGenerated("ComponentProjectProgressBar");
ComponentManager::loadComponentGenerated("ComponentModalBlockMscpi");
ComponentManager::loadComponentGenerated("ComponentSimpleBlockMscpi");

// Liste des components projet
ComponentManager::loadComponentGenerated("ComponentProjetCheckProjet");
ComponentManager::loadComponentGenerated("ComponentProjetChoixBeneficiaire");
ComponentManager::loadComponentGenerated("ComponentProjetChoixObjectif");
ComponentManager::loadComponentGenerated("ComponentProjetCredit");
ComponentManager::loadComponentGenerated("ComponentProjetMontant");
ComponentManager::loadComponentGenerated("ComponentProjetAccompagnementInvestissement");
ComponentManager::loadComponentGenerated("ComponentProjetOrigineFonds");
ComponentManager::loadComponentGenerated("ComponentProjetOrigineFondsIncoherence");
ComponentManager::loadComponentGenerated("ComponentProjetOrigineFondsSelection");
ComponentManager::loadComponentGenerated("ComponentProjetJuridiqueVosInformations");
ComponentManager::loadComponentGenerated("ComponentProjetJuridiquePersonnePhysique1");
ComponentManager::loadComponentGenerated("ComponentProjetJuridiquePersonnePhysique1Complement");
ComponentManager::loadComponentGenerated("ComponentProjetJuridiquePersonnePhysique2");
ComponentManager::loadComponentGenerated("ComponentProjetJuridiquePersonnePhysique2Complement");
ComponentManager::loadComponentGenerated("ComponentProjetFinanciereRevenus");
ComponentManager::loadComponentGenerated("ComponentProjetFinanciereHabitation");
ComponentManager::loadComponentGenerated("ComponentProjetFinanciereCharges");
ComponentManager::loadComponentGenerated("ComponentProjetFiscaleDe");
ComponentManager::loadComponentGenerated("ComponentProjetFiscaleImpot");
ComponentManager::loadComponentGenerated("ComponentProjetFiscaleIsf");
ComponentManager::loadComponentGenerated("ComponentProjetPatrimoineSituation");
ComponentManager::loadComponentGenerated("ComponentProjetPatrimoineRepartition");
ComponentManager::loadComponentGenerated("ComponentProjetPatrimoineFuturePlacement");

ComponentManager::loadComponentGenerated("ComponentProfilInvestisseurRisque");
ComponentManager::loadComponentGenerated("ComponentProfilInvestisseurCompetences");
ComponentManager::loadComponentGenerated("ComponentProfilInvestisseurCompetencesFinance");
ComponentManager::loadComponentGenerated("ComponentProfilInvestisseurMarcheImmobiliers");
ComponentManager::loadComponentGenerated("ComponentProfilInvestisseurSupportPlacement");
ComponentManager::loadComponentGenerated("ComponentProfilInvestisseurPlacementDetenus");
ComponentManager::loadComponentGenerated("ComponentProfilInvestisseurModeGestion");
ComponentManager::loadComponentGenerated("ComponentProfilInvestisseurConnaissance");
ComponentManager::loadComponentGenerated("ComponentProfilInvestisseurSiJinvestis");
ComponentManager::loadComponentGenerated("ComponentProfilInvestisseurQuizScpi");

ComponentManager::loadComponentGenerated("ComponentProfilInvestisseurNote");

ComponentManager::loadComponentGenerated("ComponentModalCoherence");

ComponentManager::loadComponentGenerated("ComponentProjetClean");

//$store = new StoreGenerator("mscpi");
$store =  StoreGenerator::getInstance();

if (ENABLE_DEVTOOLS)
	$this->loadModule("DevTools", "DevTools", ["store" => $store]);

$store->loadModule("StoreModuleModalStack", "StoreModuleModalStack");
$store->loadModule("StoreModuleProcessProjet", "StoreModuleProcessProjet");
$store->loadModule("StoreModuleCodeVille", "StoreModuleCodeVille");

$store->addPage("CheckProjet",				[ "title" => "Création de projet",		"Component" => "" ]);
$store->addPage("CreationProjet",			[ "title" => "Création de projet",		"Component" => "" ]);
$store->addPage("SituationJuridique",		[ "title" => "Situation Juridique",		"Component" => "" ]);
$store->addPage("SituationFinanciere",		[ "title" => "Situation Financière",	"Component" => "" ]);
$store->addPage("SituationFiscale",			[ "title" => "Situation Fiscale",		"Component" => "" ]);
$store->addPage("SituationPatrimoniale",	[ "title" => "Situation Patrimoniale",	"Component" => "" ]);
$store->addPage("ProfilInvestisseur",		[ "title" => "Profil d'investisseur",	"Component" => "" ]);
$store->addPage("ProfilInvestisseurNote",	[ "title" => "Profil d'investisseur",	"Component" => "" ]);

$this->loadModule("ModuleComponentManager", "ModuleComponentManager", []);

$store->loadDonneurDOrdre($this->dh);
$store->setSelected($this->dh);

$store->addToState(CategorieProfessionelle::getAll());
$store->addToState(CodeNaf::getAll());

if (isset($GLOBALS['GET']['projet'])) {
	$projet = Projet2::getById(intval($GLOBALS['GET']['projet']));
	$store->setSelectedProjet($projet);
}
