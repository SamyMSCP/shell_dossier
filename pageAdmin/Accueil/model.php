<?php
$this->collaborateur = Dh::getCurrent();
$this->client = $this->collaborateur->getMyClients();

$this->loadModuleAdmin("Nav", "Nav", array("collaborateur" => $this->collaborateur));

$this->loadModuleAdmin("tableDh", "tableDh", array(
	"collaborateur" => $this->collaborateur,
	"client" => $this->client
));
