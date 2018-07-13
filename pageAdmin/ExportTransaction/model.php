<?php
$this->collaborateur = Dh::getCurrent();

if (!empty($GLOBALS['GET']["client"])) {

	$this->dh = Dh::getById($GLOBALS['GET']["client"]);
	$this->loadModuleAdmin("Nav", "Nav", array(
		"id" => $this->dh->id_dh,
		"collaborateur" => $this->collaborateur
	));

	$this->transactions = $this->dh->getTransaction();
	foreach ($this->transactions as $key => $elm)
	{
		$this->transactions[$key]->getDh()->getPersonnePhysique();
	}
} 
else if (isset($GLOBALS['GET']["config"]) && $GLOBALS['GET']["config"] == "all")
{
	if ($this->collaborateur->getType() != "yoda")
	{
		http_response_code(403);
		exit();
	}
	$this->loadModuleAdmin("Nav", "Nav", array(
		"collaborateur" => $this->collaborateur
	));

	$this->transactions = Transaction::getFromKeyValue("type_transaction", "A");
	foreach ($this->transactions as $key => $elm)
	{
		$this->transactions[$key]->getDh()->getPersonnePhysique();
	}
}
else
{
	http_response_code(404);
	exit();
}

