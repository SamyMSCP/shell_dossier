<?php
$data = $_POST['data'];
$action = $_POST['action'];

//if ($data['id'] == 0)
if ($action == "create")
{
	$rt = $this->createTransaction($data);
}
else if ($action == "read")
{
	$rt = $this->readTransaction($data);
}
else if ($action == "update")
{
	$rt = $this->updateTransaction($data);
}
else if ($action == "update_new")
{
	$rt = $this->updateTransactionNew($data);
}
else if ($action == "delete")
{
	$rt = $this->deleteTransaction($data);
}
else if ($action == "reloadPrecalcul")
{
	$rt = $this->reloadPrecalcul($data);
}

if (empty($rt))
{
	http_response_code(404);
	echo json_encode([]);
	exit();
}

echo json_encode("Message de retour");
exit();
/*
$lstPersonnePhysique = [];
foreach (Dh::getFromIdgetAllPersonnePhysique() as $key => $elm)
{
	$lstPersonnePhysique[] = $elm->getForStore();
}
echo json_encode($Pp->getForStore());
*/
