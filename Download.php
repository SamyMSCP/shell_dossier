<?php
require_once("app.php");
//@session_start();

$dh = Dh::getCurrent();

if (!isset($_GET['idDocument']))
{
	//echo "L'url demande n'existe pas ";
	header("Location: index.php");
	exit();
}
$doc = Document::getFromId($_GET['idDocument']);
if ($doc)
	$doc = $doc[0];
else
{
	header("Location: index.php");
	exit();
}
if ($doc->getTypeDocument()->need_access_frontoffice != 1 && (empty($dh) || !$doc->checkAuthorisation($dh)))
{
	header("Location: index.php");
	exit();
}
header('Content-Type: ' . $doc->getType());
if (isset($_GET['download']) && $_GET['download'] == "1")
	header('Content-disposition: attachment;filename=' . $doc->getFilename());
else
	header('Content-disposition: inline; filename=' . $doc->getFilename());
echo $doc->getData();
exit();

if ($doc->getEntity()->checkAuthorisation(Dh::getCurrent()))
{

}
