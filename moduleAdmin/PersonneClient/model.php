<?php
if (isset($_POST['action']) && ($_POST['action'] === "Ajouter une personne morale")) {
	$etat = Pm::insert(
		$_POST['idClient'],
		$_POST['denomination_sociale'],
		$_POST['forme_juridique'],
		$_POST['siret'],
		$_POST['RCS'],
		$_POST['date_immatri']
	);
	if ($etat != false){
		Notif::set("PmInsertOk", $_POST['denomination_sociale'] . " a bien ete ajoute aux personnes morales");
		header('Location: ?p=' . $GLOBALS['GET']['p'] . '&client=' . $GLOBALS['GET']['client'] . '&onglet=' . $GLOBALS['GET']['onglet']);
		exit();
	}
}
if (isset($_POST['action']) && ($_POST['action'] === "Modifier cette personne morale")) {
		$etat = Pm::updateFromIdPm(
		$_POST['idClient'],
		$_POST['denomination_sociale'],
		$_POST['forme_juridique'],
		$_POST['siret'],
		$_POST['RCS'],
		$_POST['date_immatri']
	);
	Notif::set("PmInsertOk", $_POST['denomination_sociale'] . " modifier sur personne moral");
	header('Location: ?p=' . $GLOBALS['GET']['p'] . '&client=' . $GLOBALS['GET']['client'] . '&onglet=' . $GLOBALS['GET']['onglet']);
	exit();
}

if (isset($_POST['action']) && ($_POST['action'] === "Ajouter une personne physique")) {
	$etat = Pp::insert(
		$_POST['idClient'],
		$_POST['civilite'],
		$_POST['prenom'],
		$_POST['nom'],
		$_POST['mail'],
		$_POST['indicatif_telephonique'],
		$_POST['telephone'],
		$_POST['etat_civil'],
		$_POST['nationalite'],
		$_POST['lieu_naissance'],
		$_POST['date_naissance'],
		$_POST['adresse']
	);
	if ($etat != false)
		Notif::set("PpInsertOk", $_POST['prenom'] . " " . $_POST['nom'] . " a bien ete ajoute aux personnes physique");
	header('Location: ?p=' . $GLOBALS['GET']['p'] . '&client=' . $GLOBALS['GET']['client'] . '&onglet=' . $GLOBALS['GET']['onglet']);
	exit();
}
		
if (isset($_POST['action']) && ($_POST['action'] === "Modifier cette personne physique")) {
	$etat = Pp::updateFromId(
		$_POST['idPersonnePhysique'],
		$_POST['idClient'],
		$_POST['civilite'],
		$_POST['prenom'],
		$_POST['nom'],
		$_POST['mail'],
		$_POST['indicatif_telephonique'],
		$_POST['telephone'],
		$_POST['etat_civil'],
		$_POST['nationalite'],
		$_POST['lieu_naissance'],
		$_POST['date_naissance'],
		$_POST['adresse']
	);
	if ($etat != false)
		Notif::set("PpUpdateOk", $_POST['prenom'] . " " . $_POST['nom'] . " a bien ete modifie");
	header('Location: ?p=' . $GLOBALS['GET']['p'] . '&client=' . $GLOBALS['GET']['client'] . '&onglet=' . $GLOBALS['GET']['onglet']);
	exit();
}

$this->Pp = $this->dh->getAllPersonnePhysique();
$this->Pm = $this->dh->getAllPersonneMorale();
$this->RequiredDocumentPp = Pp::getRequiredTypeDocument();
