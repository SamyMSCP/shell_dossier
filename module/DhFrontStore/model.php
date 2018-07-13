<?php
if ($this->dh instanceof Dh)
{
	$this->dhStore = $this->dh->getForFrontStore();
	$this->Beneficiaires = $this->dh->getBeneficiairesForStore();
	$this->precalcul = $this->dh->getPrecalculForFrontStore();
}
else
{
	$this->Beneficiaires = [];
	$this->dhStore = [];
	$this->precalcul = [];
}