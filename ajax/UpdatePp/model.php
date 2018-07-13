<?php
$data = $_POST['data'];

if ($data['id'] == 0)
	$rt = $this->savePp($data);
else
	$rt = $this->updateThisPp($data);

if (empty($rt))
{
	http_response_code(404);
	echo json_encode([]);
	exit();
}
$dh = Dh::getFromId($_GET['client']);
if (empty($dh))
{
	http_response_code(404);
	echo json_encode([]);
	exit();
}
$lstPersonnePhysique = $dh[0]->getPersonnePhysiqueForStore();

echo json_encode($lstPersonnePhysique);
exit();
/*

$lstPersonnePhysique = [];
foreach (Dh::getFromIdgetAllPersonnePhysique() as $key => $elm)
{
	$lstPersonnePhysique[] = $elm->getForStore();
}
echo json_encode($Pp->getForStore());
*/
