<?php
	$this->collaborateur = Dh::getCurrent();
	$this->loadModuleAdmin("Nav", "Nav", array("collaborateur" => $this->collaborateur));

	$this->loadModule("ckEditor", "ckEditor");



$this->typeCommunication = [];
foreach (CommunicationTemplate::getTypeCommunication() as $key => $elm)
{
	$this->typeCommunication[] = $elm->classname;
}
//
$this->listTemplates = CommunicationTemplate::getAll();
$this->footer = $this->listTemplates[1]->content;
//
$this->userTest = Dh::getCurrent()->getPersonnePhysique();