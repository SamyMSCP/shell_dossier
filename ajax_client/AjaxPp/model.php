<?php
$data = $_POST['data'];
$action = $_POST['action'];

if ($action == "saveAdressePostale")
	$this->saveAdresse($data);

error("La requete est mal formatée");
