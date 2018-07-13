<?php
//echo json_encode(['response' => "okay"]);

/*
{
	"id":"1",
	"contactSelected":"1",
	"sujetSelected":"2",
	"date_execution":"1487087651",
	"duree":"0",
	"commentaire":"<p>je suis un commentaire 1<\/p>\n"
}
*/
$data = $_POST['data'];
if (
	!isset($data['id']) ||
	!isset($data['contactSelected']) ||
	!isset($data['sujetSelected']) ||
	!isset($data['date_execution']) ||
	!isset($data['duree']) ||
	!isset($data['priority']) ||
	!isset($data['commentaire'])
)
{
	http_response_code(404);
	echo json_encode([]);
	exit();
}

if ($data['id'] == 0)
	$rt = $this->insertNewCrm($data);
else
	$rt = $this->updateCrm($data);
if (!$rt)
{
	http_response_code(404);
	echo json_encode([]);
	exit();
}

$this->collaborateur = Dh::getCurrent();

if (isset($_POST['config']) && $_POST['config'] == "all")
{
	//$this->data = $this->collaborateur->getCrmForConseillerForStore();
	$this->data = Crm2::getFromId($data['id'])[0]->getForStore();
}
else
	$this->data = Dh::getById($data['id_client'])->getCrmForStore();
echo json_encode($this->data);
exit();
