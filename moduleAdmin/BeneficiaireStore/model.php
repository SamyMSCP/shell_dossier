<?php
$this->RequiredDocumentBeneficiaire = [];
$this->lstBeneficiaire = [];
if (isset($this->dh))
	$this->lstBeneficiaire = $this->dh->getBeneficiairesForStore();
