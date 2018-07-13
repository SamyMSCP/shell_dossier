<?php
$this->lstPp = $this->dh->getPersonnePhysiqueForStore();
$this->listQuestions = ProfilInvestisseur::$_listQuestions;
$this->listReponses = ProfilInvestisseur::$_listReponses;
$this->RequiredDocumentPersonnePhysique = Pp::getRequiredTypeDocument();
