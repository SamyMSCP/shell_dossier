<?php
$data = $_POST['data'];

if (!isset($_POST['action']))
	error("La requete est mal formatée");

$action = $_POST['action'];

if ($action == "add")
	$this->add($data);
else if ($action == "update")
	$this->updateData($data);
else if ($action == "delete")
	$this->deleteOp($data);
else if ($action == "save")
	$this->saveData($data);
else if ($action == "reload")
	$this->reload($data);
