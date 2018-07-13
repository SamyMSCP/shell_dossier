<?php
if (isset($_POST['action']) && $_POST['action'] == "sendMail")
	$this->sendMail();

$this->collaborateur = Dh::getCurrent();

$this->loadModule("ckEditor", "ckEditor");

$this->typeCommunication = [];

foreach (CommunicationTemplate::getTypeCommunication() as $key => $elm)
{
	if ($elm->classname != "PREPARE")
		$this->typeCommunication[] = $elm->classname;
}

$this->listTemplates = CommunicationTemplate::getAll();
$this->footer = $this->listTemplates[1]->content;

/*
$this->clientList = [];

foreach (Dh::getAll() as $key => $elm)
{
	$this->clientList[] = [
		"id" => $elm->id_dh,
		"shortName" => $elm->getShortName(),
		"firstName" => $elm->getPersonnePhysique()->getFirstName(),
		"name" => $elm->getPersonnePhysique()->getName(),
		"mail" => $elm->getLogin(),
		"phone" => $elm->getPersonnePhysique()->getPhone(),
	];
}


usort($this->clientList, function($a, $b) {
	return (strcmp($a['firstName'], $b['firstName']));
});

*/
