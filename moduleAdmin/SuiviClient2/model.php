<?php
/*
$this->mockdata = array(
	array(
		"id" => 1,
		"id_client" => $GLOBALS['GET']['client'],
		"contactSelected" => 1,
		"sujetSelected" => 2,
		"lstIdProject" => [],
		"date_execution" => 1487087651,
		"duree" => 0,
		"commentaire" => "je suis un commentaire 1"
	),
	array(
		"id" => 2,
		"id_client" => $GLOBALS['GET']['client'],
		"contactSelected" => 2,
		"sujetSelected" => 3,
		"lstIdProject" => [],
		"date_execution" => Datetime::createFromFormat("d/m/Y H:i", "26/05/1987 00:00")->getTimestamp(),
		"duree" => 1800,
		"commentaire" => "je suis un commentaire 2"
	),
	array(
		"id" => 3,
		"id_client" => $GLOBALS['GET']['client'],
		"contactSelected" => 3,
		"sujetSelected" => 0,
		"lstIdProject" => [],
		"date_execution" => Datetime::createFromFormat("d/m/Y H:i", "26/05/1987 00:15")->getTimestamp(),
		"duree" => 3600,
		"commentaire" => "je suis un commentaire 3"
	)
);
*/
//$this->data = Crm2::getAllArray();
if (!isset($this->data))
	$this->data = $this->dh->getCrmForStore();
	//$this->data = $this->collaborateur->getCrmForConseillerForStore();

$this->loadModule("PriorityStars", "PriorityStars");
$this->loadModule("ckEditor", "ckEditor");
