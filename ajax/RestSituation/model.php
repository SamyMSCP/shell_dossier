<?php
$data = $_POST['data'];
$action = $_POST['action'];

if ($action == "insert_situation_juridique")
	$rt = $this->insertJuridique($data);
if ($action == "insert_situation_financiere")
	$rt = $this->insertFinanciere($data);
if ($action == "insert_situation_fiscale")
	$rt = $this->insertFiscale($data);
if ($action == "insert_situation_patrimoniale")
	$rt = $this->insertPatrimoniale($data);

if (empty($rt))
{
	http_response_code(404);
	echo json_encode([]);
	exit();
}
/*

$lstPersonnePhysique = [];
foreach (Dh::getFromIdgetAllPersonnePhysique() as $key => $elm)
{
	$lstPersonnePhysique[] = $elm->getForStore();
}
echo json_encode($Pp->getForStore());
*/
