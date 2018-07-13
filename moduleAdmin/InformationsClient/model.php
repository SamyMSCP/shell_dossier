<?php

if (isset($_POST['action']) && $_POST['action'] == 'changeConseiller')
{
	$this->changeConseiller();
}
if (isset($_POST['action']) && $_POST['action'] == 'changeDhToOrigineContact')
	$this->changeDhToOrigineContact();
if (isset($_POST['action']) && $_POST['action'] == 'changeDhToProspect')
	$this->changeDhToProspect();

$crm = $this->dh->getCrm();
//$log = Logs::getFromDhDesc($GLOBALS['GET']["client"]);
$connexion = $this->dh->getLastConnexion();

$this->canBeOriginContact = $this->dh->getType() == null && count($this->dh->getTransaction()) == 0 && $this->collaborateur->getType() == "yoda";
$this->canBeProspect  = $this->dh->getType() == "origine_contact" && $this->collaborateur->getType() == "yoda";
