<?php
$this->collaborateur = Dh::getCurrent();

$this->loadModule("MessageBox", "MessageBox", array());
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
$this->loadModuleAdmin("ModuleGestionScpi", "ModuleGestionScpi",array(
		"collaborateur" => $this->collaborateur
));
