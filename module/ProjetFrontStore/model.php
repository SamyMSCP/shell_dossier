<?php
$this->RequiredDocumentProjet  = Projet::getRequiredTypeDocument();
$this->lstProjet  = $this->dh->getProjetsForFrontStore();
$this->fourchettes = Projet::$fourchettes;
$this->lstObjectifs  = Projet::$_listObjectif;
$this->lstOrigine  = Projet::$_listOrigine;

