<?php
if (!isset($GLOBALS['GET']['idDocument']))
{
	echo "L'url demande n'existe pas ";
	exit();
}
$doc = Document::getFromId($GLOBALS['GET']['idDocument']);
if ($doc)
	$doc = $doc[0];
header('Content-disposition: attachment;filename="' . $doc->getFilename() . '"');
header('Content-Type: ' . $doc->getType());
echo $doc->getData();
exit();
