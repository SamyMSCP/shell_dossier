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

if ($data['req'] == "update")
{
	if (
		!isset($data['id_scpi'])
	)
	{
		http_response_code(404);
		echo json_encode([]);
		exit();
	}
	echo json_encode($this->setValue($data));
	//exit();
}
