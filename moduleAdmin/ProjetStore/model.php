<?php
$this->RequiredDocumentProjet  = Projet::getRequiredTypeDocument();
//$this->lstBeneficiaire = $this->dh->getBeneficiairesForStore();
//$this->lstProjet  = $this->dh->getProjetsForStore();
$this->lstProjet  = [];
$this->fourchettes = Projet::$fourchettes;
$this->lstObjectifs  = Projet::$_listObjectif;
$this->lstOrigine  = Projet::$_listOrigine;
