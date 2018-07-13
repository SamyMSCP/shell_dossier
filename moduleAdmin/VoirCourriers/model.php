<?php

if (!isset($GLOBALS['GET']['transac']) || !isset($GLOBALS['GET']['contact'])){
	header("Location: /");
	exit();
}



$this->contact = ($GLOBALS['GET']['contact']);

$this->transact = Transaction::getFromId($GLOBALS['GET']['transac'])[0];
$this->scpi = Scpi::getFromId($this->transact->id_scpi);

$this->dh = Dh::getFromId($this->transact->id_donneur_ordre)[0];

$this->sname = $this->dh->getPersonnePhysique()->getCivilite() . " " . $this->dh->getPersonnePhysique()->getFirstName() . " " . $this->dh->getPersonnePhysique()->getName();