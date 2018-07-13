<?php
	$data = $_POST['data'];
//	$data = json_decode($data);

	$data = json_decode($data . "");
//	var_dump($data);
//	var_dump($data->d_sel);

	if (!isset($_POST['action']))
		error("La requete est mal formatee");
	$action = $_POST['action'];

	if ($action === "read")
	{
		header('Content-Type: application/json');
		echo json_encode(($this->getDataFiltered($data->start, $data->end, $data->who, $data->socgest, $data->d_sel)));

	}
	else
		error("Action non accessible");