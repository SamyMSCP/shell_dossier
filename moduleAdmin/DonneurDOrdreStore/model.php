<?php
if ($this->dh instanceof Dh)
{
	//$this->dhStore = $this->dh->getForFrontStore();
	$this->dhStore = $this->dh->getForStore();
	$this->Beneficiaires = $this->dh->getBeneficiairesForStore();
}
else
{
	$this->Beneficiaires = null;
	$this->dhStore = null;
}

$this->lstConseillers = Dh::getConseillersForStore();
$this->RequiredDocumentDh = Dh::getRequiredTypeDocument();
