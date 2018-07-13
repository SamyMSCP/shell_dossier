<?php
$dh = Dh::getCurrent();

if (!isset($_POST['id_document']))
{
	echo "KO";
	exit();
}
$id_document = intval($_POST['id_document']);
if (count(DocumentBibliotheque::getFromId($id_document)) <= 0)
{
	echo "KO";
	exit;
}
DocumentBibliothequeConsulte::insertConsultation($dh->id_dh, $id_document);
echo "OK";
exit();
