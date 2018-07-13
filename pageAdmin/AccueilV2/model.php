<?php
$this->collaborateur = Dh::getCurrent();
$this->client = $this->collaborateur->getMyClients();

$this->loadModuleAdmin("Nav", "Nav", array("collaborateur" => $this->collaborateur));


$this->loadModuleAdmin("ModuleAccueilV2", "ModuleAccueilV2", array(
	"collaborateur" => $this->collaborateur,
	"client" => $this->client
));
