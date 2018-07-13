<?php
$data = $_POST['data'];
$action = $_POST['action'];

if ($action == "updateName")
	$rt = $this->updateName($data);
else if ($action == "updateAutresElements")
	$rt = $this->updateAutresElements($data);
else if ($action == "updateStrategie")
	$rt = $this->updateStrategie($data);
else if ($action == "updateCommentaire")
	$rt = $this->updateCommentaire($data);
else if ($action == "setStatus1") {
	$rt = $this->setStatus1($data);
	// TODO : Mail changement d'etat
	if (empty($rt))
		error("Le status du projet n'a pas pu etre défini a 1");
	success($rt);
}
else if ($action == "setStatus2") {
	$rt = $this->setStatus2($data);
	if (empty($rt))
		error("Le status du projet n'a pas pu etre défini a 2");
	success($rt);
}
else if ($action == "setStatus3") {
	$rt = $this->setStatus3($data);
	if (empty($rt))
		error("Le status du projet n'a pas pu etre défini a 4");
	success($rt);
}
else if ($action == "setStatus4") {
	$rt = $this->setStatus4($data);
	if (empty($rt))
		error("Le status du projet n'a pas pu etre défini a 4");
	success($rt);
}
else if ($action == "generateRec")
	$this->generateRec($data);
else if ($action == "setObjectifsList1")
	$this->setObjectifsList1($data);
else if ($action == "setObjectifsList2")
	$this->setObjectifsList2($data);
else if ($action == "setObjectifsList3")
	$this->setObjectifsList3($data);
else if ($action == "reloadOne")
	$this->reloadOne($data);

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
