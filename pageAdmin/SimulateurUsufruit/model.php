<?php
$this->collaborateur = Dh::getCurrent();
$this->client = $this->collaborateur->getMyClients();

$this->loadModuleAdmin("Nav", "Nav", array("collaborateur" => $this->collaborateur));

//getAllForFrontStore
//nb_part
$this->name_scpi = Scpi::getForFrontStore();


$this->name_scpi = Scpi::getForFrontStore();

$this->all = Scpi::getAll();

$this->part = Dh::getForScpiGestionAndOpportunity();

/*
 * var_dump(Dh::getForScpiGestionAndOpportunity());
exit();
*/

