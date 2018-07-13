<?php
if (!isset($GLOBALS['GET']['idDocument']))
{
	echo "L'url demande n'existe pas ";
	exit();
}
$doc = Document::getFromId($GLOBALS['GET']['idDocument']);
if ($doc)
	$doc = $doc[0];
else
{
	echo "L'url demande n'existe pas ";
	exit();
}
if ($doc->getTypeDocument()->need_access_frontoffice != 1)
{
	echo "L'url demande n'existe pas ";
	exit();
}
header('Content-Type: ' . $doc->getType() . ';filename="' . $doc->getFilename() . '"');
echo $doc->getData();
exit();
