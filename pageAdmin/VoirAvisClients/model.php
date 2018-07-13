<?php
$this->collaborateur = Dh::getCurrent();

if (!empty($GLOBALS['GET']["client"])) {
	$this->dh = Dh::getById($GLOBALS['GET']["client"]);
	$this->loadModuleAdmin("Nav", "Nav", array(
		"id" => $this->dh->id_dh,
		"collaborateur" => $this->collaborateur
	));
} else {
	$this->loadModuleAdmin("Nav", "Nav", array(
		"collaborateur" => $this->collaborateur
	));
}

$this->loadModuleAdmin("ModuleAvisClient", "ModuleAvisClient", array());
