<?php

if ($this->dh instanceof Dh)
{
	$this->ppStore = $this->dh->getPersonnePhysiqueForStore();
}
else
{
	$this->ppStore = null;
}

$this->listQuestions = ProfilInvestisseur::$_listQuestions;
$this->listReponses = ProfilInvestisseur::$_listReponses;
