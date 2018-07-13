<?php
$data = $_POST['data'];
if (
	!isset($data['req'])
)
{
	http_response_code(404);
	echo json_encode([]);
	exit();
}

if ($data['req'] == "get")
{
	if (
		!isset($data['id_scpi'])
	)
	{
		http_response_code(404);
		echo json_encode([]);
		exit();
	}
	echo json_encode(DelaiJouissance::getAllForScpi($data['id_scpi']));
	exit();
}

if ($data['req'] == "save")
{
	if (
		!isset($data['lst'])
	)
	{
		http_response_code(404);
		echo json_encode([]);
		exit();
	}
	$this->saveOrUpdate($data['lst']);
	echo json_encode(DelaiJouissance::getAllForScpi($data['id_scpi']));
	exit();
}

if ($data['req'] == "delete")
{
	if (
		!isset($data['id']) ||
		!isset($data['id_scpi'])
	)
	{
		http_response_code(404);
		echo json_encode([]);
		exit();
	}
	$this->removeOne($data['id']);
	echo json_encode(DelaiJouissance::getAllForScpi($data['id_scpi']));
	exit();
}
