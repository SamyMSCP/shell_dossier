<?php
$this->Pm = $this->beneficiaire->getPersonneMorale();

$this->Pp = array($dh->getPersonnePhysique());
$this->gerant = $this->Pm[0]->getGerant();

if ($this->projet->etat_du_projet == -1) // Check si l'etat du projet est -1
{
	if (0) //Check si il y a bien une lettre de mission en cours de validite
	{

	}
	else if ($this->Pp[0]->getResetSituationJuridique() || empty($this->Pp[0]->getLastSituationJuridique()) || !$this->Pp[0]->getLastSituationJuridique()->isValide())
	// Check si la situation juridique n'est pas a jours ou non  renseignee pour ce beneficiaire
	{
		// Affiche le module pour le renseignement de situation Juridique
		$this->loadModule("formThisPage", "SetSituationJuridique", array(
			"dh" => $dh,
			"Pp" => $this->Pp[0]
		));
	}
	else if ($this->Pm[0]->getResetSituationJuridique() || empty($this->Pm[0]->getLastSituationJuridique()) || !$this->Pm[0]->getLastSituationJuridique()->isValide())
	// Check si la situation juridique n'est pas a jours ou non  renseignee pour ce beneficiaire
	{
		$this->loadModule("formThisPage", "SetSituationJuridiqueMorale", array(
			"dh" => $dh,
			"ben" => $this->beneficiaire,
			"Pm" => $this->Pm[0]
		));
	}
	else if ($this->gerant->getResetSituationJuridique() || empty($this->gerant->getLastSituationJuridique()) || !$this->gerant->getLastSituationJuridique()->isValide())
	{
		$this->loadModule("formThisPage", "SetSituationJuridique", array(
			"dh" => $dh,
			"Pp" => $this->gerant
		));
	}
	else if ($this->Pm[0]->getResetSituationFinanciere() || empty($this->Pm[0]->getLastSituationFinanciere()) || !$this->Pm[0]->getLastSituationFinanciere()->isValide())
	// Check si la situation Financiere n'est pas a jours ou non  renseignee pour ce beneficiaire
	{
		$this->loadModule("formThisPage", "SetSituationFinanciereMorale", array(
			"dh" => $dh,
			"ben" => $this->beneficiaire,
			"Pm" => $this->Pm[0]
		));
	}
	else if ($this->Pm[0]->getResetSituationFiscale() || empty($this->Pm[0]->getLastSituationFiscale()) || !$this->Pm[0]->getLastSituationFiscale()->isValide())
	// Check si la situation Fiscale n'est pas a jours ou non  renseignee pour ce beneficiaire
	{
		$this->loadModule("formThisPage", "SetSituationFiscaleMorale", array(
			"dh" => $dh,
			"ben" => $this->beneficiaire,
			"Pm" => $this->Pm[0]
		));
	}
	else if ($this->Pm[0]->getResetSituationPatrimoniale() || empty($this->Pm[0]->getLastSituationPatrimoniale()) || !$this->Pm[0]->getLastSituationPatrimoniale()->isValide())
	// Check si la situation Patrimoniale n'est pas a jours ou non  renseignee pour ce beneficiaire
	{
		$this->loadModule("formThisPage", "SetSituationPatrimonialeMorale", array(
			"dh" => $dh,
			"ben" => $this->beneficiaire,
			"Pm" => $this->Pm[0]
		));
	}
	else if (empty($this->gerant->getLastProfilInvestisseur()) || !$this->gerant->getLastProfilInvestisseur()->isValide())
	{
		$this->loadModule("formThisPage", "SetProfilInvestisseur", array(
			"dh" => $dh,
			"ben" => $this->beneficiaire,
			"Pp" => $this->gerant
		));
		// Affiche le module pour le renseignement du profil investisseur pour le gerant
	}
	else
	{
		$this->projet->updateOneColumn("etat_du_projet", "0");
		$this->loadModule("formThisPage", "ThanksNewProject", array(
			"dh" => $dh,
			"ben" => $this->beneficiaire,
			"Pp" => $this->Pp[0]
		));
	}
}
else
{
	$this->formThisPage = "Ce projet est valide";
	// On affiche les infos du projet
}
