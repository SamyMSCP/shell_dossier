<?php
$data = $_POST['data'];

//error('Erreur de test');
if (!isset($_POST['action']))
	error("La requete est mal formatée");

$action = $_POST['action'];

if ($action == "update")
	$this->update($data);


error("ya un bug");
