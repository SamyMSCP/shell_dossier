<?php
$this->lstConseiller = Dh::getConseillersForStore();
//$this->loadModuleAdmin("ScpiStore", "ScpiStore", array("id" => $this->dh->id_dh));
//$this->okok = SocieteDeGestion::getAll();
$this->typeCommunication = [];



foreach (CommunicationTemplate::getTypeCommunication() as $key => $elm)
{
	$this->typeCommunication[] = $elm->classname;
}

$this->recuperetout = SocieteDeGestion::generateCacheAllSocieteDeGestion();

$this->listTemplates = CommunicationTemplate::getAll();