<?php
$data = $_POST['data'];

if (!isset($_POST['action']))
    error("La requete est mal formatée");
$action = $_POST['action'];
if ($action == "update")
    $this->updateValue($data);
else
    error("There is nothing for you here");