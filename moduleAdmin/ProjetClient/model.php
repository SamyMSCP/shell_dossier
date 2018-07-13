<?php
$this->allProject = array();
$this->beneficiaires = $this->dh->getBeneficiaires();
$this->RequiredDocumentProject = Projet::getRequiredTypeDocument();
foreach ($this->beneficiaires as $key => $elm)
{
	foreach ($elm->getProjects() as $key2 => $elm2)
	{
		$this->allProject[] = $elm2;
	}
}

$this->projectForJson = array();

//$this->documentProject = array();
foreach ($this->allProject as $key => $elm)
{
	$this->projectForJson[$elm->id] = array();
	$this->projectForJson[$elm->id]['id'] = $elm->id;
	$this->projectForJson[$elm->id]['idBeneficiaire'] = $elm->getBeneficiaires();
	$this->projectForJson[$elm->id]['nom'] = mb_strtoupper($elm->getName());
	$this->projectForJson[$elm->id]['conseiller'] = $elm->getConseiller()->getPersonnePhysique()->getShortName();
	//$this->projectForJson[$elm->id]['nom'] = "COMPLÉMENTAIRE RETRAITE";
	//$this->projectForJson[$elm->id]['nom'] = Projet::$_listObjectif[$elm->getObjectifs()[0]];
	$this->projectForJson[$elm->id]['dateCreation'] = $elm->getDateCreation()->format("d/m/Y");
	$this->projectForJson[$elm->id]['dateCreationStr'] = date_fr($elm->getDateCreation()->format("d F Y"));
	$this->projectForJson[$elm->id]['etatProjet'] = $elm->getEtatProjet();
	$this->projectForJson[$elm->id]['objectifs'] = $elm->getObjectifs();
	$this->projectForJson[$elm->id]['credit'] = $elm->haveCredit();
	$this->projectForJson[$elm->id]['accompagnement'] = $elm->haveAccompagnement();
	$this->projectForJson[$elm->id]['budget'] = $elm->getBudget();

	$this->projectForJson[$elm->id]['files'] = array();
	foreach ($this->RequiredDocumentProject as $key1 => $elm1)
	{
		$this->projectForJson[$elm->id]['files'][$elm1->id] = array();
		foreach ($elm->getDocuments($elm1->id) as $key2 => $elm2)
		{
			$this->projectForJson[$elm->id]['files'][$elm1->id][$elm2->id] = array();
			$this->projectForJson[$elm->id]['files'][$elm1->id][$elm2->id]["filename"] = $elm2->getFilename();
			$this->projectForJson[$elm->id]['files'][$elm1->id][$elm2->id]["dateExecution"] = $elm2->getDateExecution();
			$this->projectForJson[$elm->id]['files'][$elm1->id][$elm2->id]["dateCreation"] = $elm2->getDateCreation();
			$this->projectForJson[$elm->id]['files'][$elm1->id][$elm2->id]["link"] = "?p=DownloadDocument&idDocument=" . $elm2->id;
			$this->projectForJson[$elm->id]['files'][$elm1->id][$elm2->id]["id"] = $elm2->id;
		}
	}
}

//$this->documentProject

/*
$this->RequiredDocumentProject = array();
foreach (Projet::getRequiredTypeDocument() as $key =>$elm)
{
	$this->RequiredDocumentProject[$elm->id] = $elm;
}
*/

$this->conseillerClient = $this->dh->getConseiller()->getPersonnePhysique();
$this->Pp = $this->dh->getPersonnePhysique();
