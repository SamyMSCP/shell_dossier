<?php
$data = $_POST['data'];

if (!isset($_POST['action']))
    error("La requete est mal formatée");

$action = $_POST['action'];
if ($action == "setParrain")
	$this->setParrain($data);
else if ($action == "toggleAdresseValide")
	$this->toggleAdresseValide($data);
else
    error("There is nothing for you here");
//error("message de test");
