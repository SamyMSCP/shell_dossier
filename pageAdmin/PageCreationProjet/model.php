<?php

$this->collaborateur = Dh::getCurrent();
//$this->client = $this->collaborateur->getMyClients();

$this->loadModuleAdmin("Nav", "Nav", array("collaborateur" => $this->collaborateur));

if (!isset($_GET['client']))
	die("Le client n'a pas été définit !");

$dh = DonneurDOrdre::getById(intval($_GET['client']));
if (empty($dh))
	die("Le client n'a pas pu être trouvé");

$this->loadModuleAdmin("ModuleCreationProjet", "ModuleCreationProjet", ['dh' => $dh]);
