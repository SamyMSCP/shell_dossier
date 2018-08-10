<?php
$dh = Dh::getCurrent();
$data = $_POST['data'];

$id_scpi = $data['id'];
$demande = $data['demande'];

if ($demande == "contact vente")
{
	$log = $dh->getLoggerTodayByName("Demande contact Vente");
	if (count($log) > 0)
		success(["response"=> "Une demande à déja été enregistrée aujourd'hui. Votre conseiller vous contactera prochainement."]);
	$id_crm = Crm2::insertNew($dh->id_dh, 3, 0, time(), 60 * 15, "Le donneur d'ordre souhaite vendre des parts d'une scpi.", [], 0);
	$crm = Crm2::getFromId($id_crm)[0];
	$crm->updateOneColumn("priority", 4);
	$params = ["demande" => "Demande de contact pour vente de parts"];
	Logger::setNew("Demande contact Vente", $dh->id_dh, $dh->id_dh, $params);
	success(["response"=> "La demande à bien été enregistrée !"]);
}
else if ($demande == "contact achat")
{
	// $scpi = Scpi::getFromId($id_scpi);
	$log = $dh->getLoggerTodayByName("Demande contact Achat");
	if (count($log) > 0)
		success(["response"=> "Une demande à déja été enregistrée aujourd'hui. Votre conseiller vous contactera prochainement."]);
	$id_crm = Crm2::insertNew($dh->id_dh, 3, 0, time(), 60 * 15, "Le donneur d'ordre souhaite réinvestir dans une scpi ", [], 0);
	$crm = Crm2::getFromId($id_crm)[0];
	$crm->updateOneColumn("priority", 4);
	$params = ["demande" => "Demande de contact pour acheter des parts"];
	Logger::setNew("Demande contact Achat", $dh->id_dh, $dh->id_dh, $params);
	success(["response"=> "La demande à bien été enregistrée !"]);
}
else
	error("La requête est mal formatée !");
