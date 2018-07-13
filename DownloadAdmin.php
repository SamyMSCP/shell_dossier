<?php
require_once("app.php");
//@session_start();

$dh = Dh::getCurrent();
if (
	empty($dh) ||
	(
		$dh->getType() != "yoda" &&
		$dh->getType() != "conseiller" &&
		$dh->getType() != "backoffice" &&
		$dh->getType() != "communication" &&
		$dh->getType() != "assistant" &&
		$dh->getType() != "prospecteur" &&
		$dh->getType() != "developpeur" &&
		$dh->getType() != "chefprojet"
	)
)
	exit();


if (!isset($_GET['idDocument']))
{
	echo "L'url demande n'existe pas ";
	exit();
}
$doc = Document::getFromId($_GET['idDocument']);
if ($doc)
	$doc = $doc[0];
else
{
	echo "L'url demandé n'existe pas ";
	exit();
}
header('Content-Type: ' . $doc->getType());
if (isset($_GET['download']) && $_GET['download'] == "1")
	header('Content-disposition: attachment;filename=' . $doc->getFilename());
echo $doc->getData();
exit();
