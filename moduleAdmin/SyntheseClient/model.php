<?php

if (isset($_POST['button2id']) && $_POST['button2id'] == 'addTransaction')
	$this->insertNewTransaction();

if (isset($_POST['action']) && $_POST['action'] == "Enregistrer la transaction")
	$this->updateTransactionBenefiaire();

if (isset($_POST['action']) && $_POST['action'] == "Supprimer la transaction")
	$this->deleteTransaction();

if (isset($_POST['actionChangeStatusTrans']) && $_POST['actionChangeStatusTrans'] == "Oui")
	$this->updateStatusTrans();

if (isset($_POST['actionUpdateTransactionCommentaire']) && $_POST['actionUpdateTransactionCommentaire'] == "Enregistrer")
	$this->updateCommentaire();

/*
$this->modal_content = $this->generateCacheModal($this->dh->id_dh);

$this->loadModule("ProgressBlock", "ProgressBlock2", array(
	"collaborateur" => $this->collaborateur,
	"prc" => 0,
	"data" =>array(
		"Potentielle",
		"Dossier receptionne",
		"Dossier envoye a la SG",
		"Dossier receptionne par la SG (non complet)",
		"Dossier Complet (en cours d'enregistrement)",
		"Transaction enregistree en attente du CNP)",
		"Transaction OK",
		"Transaction Annulee"
	)
));
*/

$this->RequiredDocumentTransaction = Transaction::getRequiredTypeDocument();
$this->dataTransaction = array();
{
	foreach ($this->dh->getTransaction() as $key1 => $elm1)
	{
		$this->dataTransaction[$elm1->id] = array();
		foreach($this->RequiredDocumentTransaction as $key2 => $elm2)
		{
			$this->dataTransaction[$elm1->id][$elm2->id] = array();
			foreach ($elm1->getDocuments($elm2->id) as $key3 => $doc)
			{
				$this->dataTransaction[$elm1->id][$elm2->id][$doc->id] = array();
				$this->dataTransaction[$elm1->id][$elm2->id][$doc->id]["id"] = $doc->id;
				$this->dataTransaction[$elm1->id][$elm2->id][$doc->id]["dateCreation"] = $doc->getDateCreation()->format("d/m/Y");
				$this->dataTransaction[$elm1->id][$elm2->id][$doc->id]["dateExecution"] = $doc->getDateExecution()->format("d/m/Y");
				$this->dataTransaction[$elm1->id][$elm2->id][$doc->id]["link"] = "?p=DownloadDocument&idDocument=" . $doc->id;
				$this->dataTransaction[$elm1->id][$elm2->id][$doc->id]["filename"] = $doc->getFilename();
			}
		}
	}
}

// Tri du tableau par ordre alphabetique
ksort($this->table, SORT_NATURAL);

///////////////////////////////////////////////// Like Front


if (count(Dh::getById($GLOBALS['GET']['client'])->getTransaction()) !== 0)
{
	$this->loadModule("RepartitionAcceuil", "RepartitionAcceuil", array(
		"dh" => $this->dh,
		"table" => $this->table
		)
	);

	$this->loadModule("RendementDeMesScpiAcceuil", "RendementDeMesScpiAcceuil", array(
		"dh" => $this->dh,
		"table" => $this->table
		)
	);

/*
	$this->loadModule("ApercuDeMonPorteFeuillev3", "ApercuDeMonPorteFeuillev3", array(
		"dh" => $this->dh,
		"data" => $this->table
		)
	);
*/

	$this->loadModuleAdmin("PortefeuilleComponent", "PortefeuilleComponent", array(
		"dh" => $this->dh,
		"table" => $this->table,
		"collaborateur" => $this->collaborateur
		)
	);

	$this->loadModule("RepartitionGeographique", "RepartitionGeographique", array(
		"dh" => $this->dh,
		"table" => $this->table
		)
	);

	$this->loadModule("RepartitionParCategorie", "RepartitionParCategorie", array(
		"dh" => $this->dh,
		"table" => $this->table
		)
	);

	$this->loadModule("TauxDOccupation", "TauxDOccupation", array(
		"dh" => $this->dh,
		"table" => $this->table
		)
	);

	$this->loadModule("RepartitionParType", "RepartitionParType", array(
		"dh" => $this->dh,
		"table" => $this->table
		)
	);

	$this->loadModule("ModuleAgeScpi", "ModuleAgeScpi", array(
		"dh" => $this->dh,
		"table" => $this->table
		)
	);

	$this->loadModuleAdmin("ModuleDividendesTrimestriels", "ModuleDividendesTrimestriels", array(
		"dh" => $this->dh,
		"table" => $this->table
		)
	);

	$this->loadModule("DernieresAcquisitions", "DernieresAcquisitions", array("dh" => $this->dh));

	$this->loadModule("DernieresActualites", "DernieresActualites", array("dh" => $this->dh));
}
