<?php
$dh = Dh::getCurrent();
$data = $_POST['data'];

$id_scpi = $data['id'];
$demande = $data['demande'];
$scpi = Scpi::getFromId($id_scpi);

if ($demande == "contact vente")
{
	$log = $dh->getLoggerTodayByName("Demande contact Vente");
	foreach ($log as $key => $elm) {
		if (isset($elm->getParams()['id_scpi']) && $elm->getParams()['id_scpi'] == $id_scpi)
			success(["response"=> "Une demande à déja été enregistrée aujourd'hui. Votre conseiller vous contactera prochainement."]);
	}
	$id_crm = Crm2::insertNew($dh->id_dh, 3, 0, time(), 60 * 15, "Le donneur d'ordre souhaite vendre des parts de la scpi " . $scpi->name, [], 0);
	$crm = Crm2::getFromId($id_crm)[0];
	$crm->updateOneColumn("priority", 4);
	$params = [
		"demande" => "Demande de contact pour vente de parts",
		"id_scpi" => $scpi->id,
		"nom_scpi" => $scpi->name
	];
	Logger::setNew("Demande contact Vente", $dh->id_dh, $dh->id_dh, $params);
	success(["response"=> "La demande à bien été enregistrée !"]);
}
else if ($demande == "contact achat")
{
	$log = $dh->getLoggerTodayByName("Demande contact Achat");
	foreach ($log as $key => $elm) {
		if (isset($elm->getParams()['id_scpi']) && $elm->getParams()['id_scpi'] == $id_scpi)
			success(["response"=> "Une demande à déja été enregistrée aujourd'hui. Votre conseiller vous contactera prochainement."]);
	}
	$id_crm = Crm2::insertNew($dh->id_dh, 3, 0, time(), 60 * 15, "Le donneur d'ordre souhaite réinvestir dans  la scpi " . $scpi->name, [], 0);
	$crm = Crm2::getFromId($id_crm)[0];
	$crm->updateOneColumn("priority", 4);
	$params = [
		"demande" => "Demande de contact pour acheter des parts",
		"id_scpi" => $scpi->id,
		"nom_scpi" => $scpi->name
	];
	Logger::setNew("Demande contact Achat", $dh->id_dh, $dh->id_dh, $params);
	success(["response"=> "La demande à bien été enregistrée !"]);
}
else
	error("La requête est mal formatée !");
