<?php
$config = [
	"collaborateur" => $this->collaborateur,
	"data" => $this->collaborateur->getCrmForConseillerForStore(),
	"noAdd" => true,
	"forConseiller" => true,
	"isLink" => true
];

if ($this->collaborateur->getType() == "yoda")
	$config["showConseiller"] = true;

$this->loadModuleAdmin("SuiviClient2", "SuiviClient2", $config);
