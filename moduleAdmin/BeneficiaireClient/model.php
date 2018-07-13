<?php
if (isset($_POST['action']) && $_POST['action'] === "Ajouter un nouveau beneficiaire")
{
	$etat = $this->insertNewBeneficiaire();
	if ($etat != false)
		Notif::set("PpInsertOk", "Le nouveau beneficiaire a bien ete ajoute.");
	header('Location: ?p=' . $GLOBALS['GET']['p'] . '&client=' . $GLOBALS['GET']['client']);
	exit();
}

if (isset($_POST['addNewSituationJuridique']) && $_POST['addNewSituationJuridique'] === "Ajouter")
{
	$dateSituation = DateTime::createFromFormat("Y-m-d", $_POST['dateSituation'])->getTimestamp();
	$dateFinSituation = DateTime::createFromFormat("Y-m-d", $_POST['dateFinSituation'])->getTimestamp();
	SituationJuridique::insertNew(
		$_POST['idSituation'],
		$dateSituation,
		$dateFinSituation,
		$_POST['regimeMat'],
		$_POST['NbrEnfantCharge'],
		$_POST['NbrPersonnesCharge']
	);
	Notif::set("MsgAddSituationJuridique", "La Situation juridique a bien ete ajoutee");
	header('Location: ?p=' . $GLOBALS['GET']['p'] . '&client=' . $GLOBALS['GET']['client']);
	exit();
}

if (isset($_POST['addNewSituationJuridique']) && $_POST['addNewSituationJuridique'] === "Modifier")
{
	$dateSituation = DateTime::createFromFormat("Y-m-d", $_POST['dateSituation'])->getTimestamp();
	$dateFinSituation = DateTime::createFromFormat("Y-m-d", $_POST['dateFinSituation'])->getTimestamp();
	SituationJuridique::updateOne(
		$_POST['idSituationJuridique'],
		$dateSituation,
		$dateFinSituation,
		$_POST['regimeMat'],
		$_POST['NbrEnfantCharge'],
		$_POST['NbrPersonnesCharge']
	);
	Notif::set("MsgAddSituationJuridique", "La Situation juridique a bien ete mise a jours");
	header('Location: ?p=' . $GLOBALS['GET']['p'] . '&client=' . $GLOBALS['GET']['client']);
	exit();
}


if (isset($_POST['addNewSituationFiscale']) && $_POST['addNewSituationFiscale'] === "Ajouter")
{
	$dateSituation = DateTime::createFromFormat("Y-m-d", $_POST['dateSituation'])->getTimestamp();
	$dateFinSituation = DateTime::createFromFormat("Y-m-d", $_POST['dateFinSituation'])->getTimestamp();
	SituationFiscale::insertNew(
		$_POST['idSituation'],
		$dateSituation,
		$dateFinSituation,
		isset($_POST['residentFrance']),
		$_POST['tauxMarginalImposition'],
		$_POST['impotsAnneePrecedente'],
		$_POST['nbrPartsFiscales'],
		$_POST['trancheIsf'],
		$_POST['montantIsf']
	);
	Notif::set("MsgAddSituationFiscale", "La Situation Fiscale bien ete Ajoute");
	header('Location: ?p=' . $GLOBALS['GET']['p'] . '&client=' . $GLOBALS['GET']['client']);
	exit();
}

if (isset($_POST['addNewSituationFiscale']) && $_POST['addNewSituationFiscale'] === "Modifier")
{
	$dateSituation = DateTime::createFromFormat("Y-m-d", $_POST['dateSituation'])->getTimestamp();
	$dateFinSituation = DateTime::createFromFormat("Y-m-d", $_POST['dateFinSituation'])->getTimestamp();
	SituationFiscale::updateOne(
		$_POST['idSituationFiscale'],
		$dateSituation,
		$dateFinSituation,
		isset($_POST['residentFrance']),
		$_POST['tauxMarginalImposition'],
		$_POST['impotsAnneePrecedente'],
		$_POST['nbrPartsFiscales'],
		$_POST['trancheIsf'],
		$_POST['montantIsf']
	);
	Notif::set("MsgAddSituationFiscale", "La Situation Fiscale bien ete mise a jours");
	header('Location: ?p=' . $GLOBALS['GET']['p'] . '&client=' . $GLOBALS['GET']['client']);
	exit();
}

if (isset($_POST['addNewSituationFinanciere']) && $_POST['addNewSituationFinanciere'] === "Ajouter")
{
	$dateSituation = DateTime::createFromFormat("Y-m-d", $_POST['dateSituation'])->getTimestamp();
	$dateFinSituation = DateTime::createFromFormat("Y-m-d", $_POST['dateFinSituation'])->getTimestamp();
	SituationFinanciere::insertNew(
		$_POST['idSituation'],
		$dateSituation,
		$dateFinSituation,
		$_POST['revenuProfessionnels'],
		$_POST['revenuImmobiliers'],
		$_POST['revenuMobiliers'],
		$_POST['revenuAutres'],
		$_POST['remboursementMensuel'],
		$_POST['dureeRemboursementRestante'],
		$_POST['natureAutresEmprunts'],
		$_POST['montantAutresEmprunts'],
		$_POST['dureeAutresEmprunts']
	);
	Notif::set("MsgAddSituationFinanciere", "La Situation financiere a bien ete ajoutee");
	header('Location: ?p=' . $GLOBALS['GET']['p'] . '&client=' . $GLOBALS['GET']['client']);
	exit();
}

if (isset($_POST['addNewSituationFinanciere']) && $_POST['addNewSituationFinanciere'] === "Modifier")
{
	$dateSituation = DateTime::createFromFormat("Y-m-d", $_POST['dateSituation'])->getTimestamp();
	$dateFinSituation = DateTime::createFromFormat("Y-m-d", $_POST['dateFinSituation'])->getTimestamp();
	SituationFinanciere::updateOne(
		$_POST['idSituationFinanciere'],
		$dateSituation,
		$dateFinSituation,
		$_POST['revenuProfessionnels'],
		$_POST['revenuImmobiliers'],
		$_POST['revenuMobiliers'],
		$_POST['revenuAutres'],
		$_POST['remboursementMensuel'],
		$_POST['dureeRemboursementRestante'],
		$_POST['natureAutresEmprunts'],
		$_POST['montantAutresEmprunts'],
		$_POST['dureeAutresEmprunts']
	);
	Notif::set("MsgAddSituationFinanciere", "La Situation financiere a bien ete mise a jours");
	header('Location: ?p=' . $GLOBALS['GET']['p'] . '&client=' . $GLOBALS['GET']['client']);
	exit();
}

if (isset($_POST['addNewSituationPatrimoniale']) && $_POST['addNewSituationPatrimoniale'] === "Ajouter")
{
	$dateSituation = DateTime::createFromFormat("Y-m-d", $_POST['dateSituation'])->getTimestamp();
	$dateFinSituation = DateTime::createFromFormat("Y-m-d", $_POST['dateFinSituation'])->getTimestamp();
	SituationPatrimoniale::insertNew(
		$_POST['idSituation'],
		$dateSituation,
		$dateFinSituation,
		$_POST['fourchetteMontantPatrimoine'],
		$_POST['repartitionPatrimoine'],
		isset($_POST['futurPlacement'])
	);
	Notif::set("MsgAddSituationPatrimoniale", "La Situation Patrimoniale a bien ete ajoutee");
	header('Location: ?p=' . $GLOBALS['GET']['p'] . '&client=' . $GLOBALS['GET']['client']);
	exit();
}

if (isset($_POST['addNewSituationPatrimoniale']) && $_POST['addNewSituationPatrimoniale'] === "Modifier")
{
	$dateSituation = DateTime::createFromFormat("Y-m-d", $_POST['dateSituation'])->getTimestamp();
	$dateFinSituation = DateTime::createFromFormat("Y-m-d", $_POST['dateFinSituation'])->getTimestamp();
	SituationPatrimoniale::updateOne(
		$_POST['idSituationPatrimoniale'],
		$dateSituation,
		$dateFinSituation,
		$_POST['fourchetteMontantPatrimoine'],
		$_POST['repartitionPatrimoine'],
		isset($_POST['futurPlacement'])
	);
	Notif::set("MsgAddSituationPatrimoniale", "La Situation Patrimoniale a bien ete mise a jours");
	header('Location: ?p=' . $GLOBALS['GET']['p'] . '&client=' . $GLOBALS['GET']['client']);
	exit();
}

$this->Pp = $this->dh->getAllPersonnePhysique();
$this->Pm = $this->dh->getAllPersonneMorale();
$this->beneficiaires = $this->dh->getBeneficiaires();
$this->RequiredDocumentPp = Pp::getRequiredTypeDocument();

$this->dataSituationJuridique = array();
foreach ($this->dh->getSituationsJuridique() as $key => $elm)
{
	$this->dataSituationJuridique[$elm->id] = array();
	$this->dataSituationJuridique[$elm->id]['id'] = $elm->id;
	$this->dataSituationJuridique[$elm->id]["dateSituationJuridique"] = $elm->getDateSituation()->format("Y-m-d");
	$this->dataSituationJuridique[$elm->id]["dateFinSituationJuridique"] = $elm->getDateFinSituation()->format("Y-m-d");
	$this->dataSituationJuridique[$elm->id]["dateSituationJuridiqueEu"] = $elm->getDateSituation()->format("d/m/y");
	$this->dataSituationJuridique[$elm->id]["dateFinSituationJuridiqueEu"] = $elm->getDateFinSituation()->format("d/m/Y");
	$this->dataSituationJuridique[$elm->id]["regimeMat"] = $elm->getRegimeMat();
	$this->dataSituationJuridique[$elm->id]["NbrEnfantCharge"] = $elm->getNbrEnfantCharge();
	$this->dataSituationJuridique[$elm->id]["NbrPersonnesCharge"] = $elm->getNbrPersonnesCharge();
}

$this->dataSituationFiscale = array();
foreach ($this->dh->getSituationsFiscale() as $key => $elm)
{
	$this->dataSituationFiscale[$elm->id] = array();
	$this->dataSituationFiscale[$elm->id]['id'] = $elm->id;
	$this->dataSituationFiscale[$elm->id]["dateSituationFiscale"] = $elm->getDateSituation()->format("Y-m-d");
	$this->dataSituationFiscale[$elm->id]["dateFinSituationFiscale"] = $elm->getDateFinSituation()->format("Y-m-d");
	$this->dataSituationFiscale[$elm->id]["dateSituationFiscaleEu"] = $elm->getDateSituation()->format("d/m/y");
	$this->dataSituationFiscale[$elm->id]["dateFinSituationFiscaleEu"] = $elm->getDateFinSituation()->format("d/m/Y");

	$this->dataSituationFiscale[$elm->id]["residentFrance"] = $elm->getIsResidentFrance();
	//$this->dataSituationFiscale[$elm->id]["tauxMarginalImposition"] = $elm->getTauxMarginalImposition();
	$this->dataSituationFiscale[$elm->id]["tauxMarginalImposition"] = -1;
	//$this->dataSituationFiscale[$elm->id]["impotsAnneePrecedente"] = $elm->getImpotsAnneePrecedente();
	$this->dataSituationFiscale[$elm->id]["impotsAnneePrecedente"] = -1;
	$this->dataSituationFiscale[$elm->id]["nbrPartsFiscales"] = $elm->getNbrPartsFiscale();
	//$this->dataSituationFiscale[$elm->id]["trancheIsf"] = $elm->getTrancheIsf();
	//$this->dataSituationFiscale[$elm->id]["montantIsf"] = $elm->getMontantIsf();
	$this->dataSituationFiscale[$elm->id]["trancheIsf"] = -1;
	$this->dataSituationFiscale[$elm->id]["montantIsf"] = -1;
}

$this->dataSituationFinanciere = array();
foreach ($this->dh->getSituationsFinanciere() as $key => $elm)
{
	$this->dataSituationFinanciere[$elm->id] = array();
	$this->dataSituationFinanciere[$elm->id]['id'] = $elm->id;
	$this->dataSituationFinanciere[$elm->id]["dateSituationFinanciere"] = $elm->getDateSituation()->format("Y-m-d");
	$this->dataSituationFinanciere[$elm->id]["dateFinSituationFinanciere"] = $elm->getDateFinSituation()->format("Y-m-d");
	$this->dataSituationFinanciere[$elm->id]["dateSituationFinanciereEu"] = $elm->getDateSituation()->format("d/m/y");
	$this->dataSituationFinanciere[$elm->id]["dateFinSituationFinanciereEu"] = $elm->getDateFinSituation()->format("d/m/Y");

	$this->dataSituationFinanciere[$elm->id]["revenuProfessionnels"] = $elm->getRevenuProfessionnels();
	$this->dataSituationFinanciere[$elm->id]["revenuImmobiliers"] = $elm->getRevenuImmobiliers();
	$this->dataSituationFinanciere[$elm->id]["revenuMobiliers"] = $elm->getRevenuMobiliers();
	$this->dataSituationFinanciere[$elm->id]["revenuAutres"] = $elm->getRevenuAutres();
	$this->dataSituationFinanciere[$elm->id]["remboursementMensuel"] = $elm->getRemboursementMensuel();
	$this->dataSituationFinanciere[$elm->id]["dureeRemboursementRestante"] = $elm->getDureeRemboursementRestante();
	$this->dataSituationFinanciere[$elm->id]["natureAutresEmprunts"] = $elm->getNatureAutresEmprunts();
	$this->dataSituationFinanciere[$elm->id]["montantAutresEmprunts"] = $elm->getMontantAutresEmprunts();
	$this->dataSituationFinanciere[$elm->id]["dureeAutresEmprunts"] = $elm->getDureeAutresEmprunts();
}

$this->dataSituationPatrimoniale = array();
foreach ($this->dh->getSituationsPatrimoniale() as $key => $elm)
{
	$this->dataSituationPatrimoniale[$elm->id] = array();
	$this->dataSituationPatrimoniale[$elm->id]['id'] = $elm->id;
	$this->dataSituationPatrimoniale[$elm->id]["dateSituationPatrimoniale"] = $elm->getDateSituation()->format("Y-m-d");
	$this->dataSituationPatrimoniale[$elm->id]["dateFinSituationPatrimoniale"] = $elm->getDateFinSituation()->format("Y-m-d");
	$this->dataSituationPatrimoniale[$elm->id]["dateSituationPatrimonialeEu"] = $elm->getDateSituation()->format("d/m/y");
	$this->dataSituationPatrimoniale[$elm->id]["dateFinSituationPatrimonialeEu"] = $elm->getDateFinSituation()->format("d/m/Y");

	$this->dataSituationPatrimoniale[$elm->id]["fourchetteMontantPatrimoine"] = $elm->getFourchetteMontantPatrimoine();
	$this->dataSituationPatrimoniale[$elm->id]["repartitionPatrimoine"] = $elm->getRepartitionPatrimoine();
	$this->dataSituationPatrimoniale[$elm->id]["futurPlacement"] = $elm->getFuturPlacement();
}



$this->tabBen = array();
foreach ($this->beneficiaires as $key => $elm)
{
	$this->tabBen[$elm->id_benf] = array();
	$this->tabBen[$elm->id_benf]["SituationJuridique"] = $elm->getSituationsJuridiqueId();
	$this->tabBen[$elm->id_benf]["SituationFinanciere"] = $elm->getSituationsFinanciereId();
	$this->tabBen[$elm->id_benf]["SituationFiscale"] = $elm->getSituationsFiscaleId();
	$this->tabBen[$elm->id_benf]["SituationPatrimoniale"] = $elm->getSituationsPatrimonialeId();
	$this->tabBen[$elm->id_benf]["idSituation"] = $elm->getSituationsId();
	$this->tabBen[$elm->id_benf]["Projects"] = $elm->getProjectsId();
}

//var_dump($this->tabBen);
