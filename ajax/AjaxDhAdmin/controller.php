<?php
require_once("class/core/Ajax.php");
class AjaxDhAdmin extends Ajax
{
	public function toggleAdresseValide($data) {
		if ( !isset($data['id']))
			error("La requête est mal formatée");

		$user = Dh::getCurrent();
		if ($user->getType() != "yoda" && $user->getType() != "conseiller" && $user->getType() != "backoffice" && $user->getType() != "assistant")
			error("Vous n'avez pas accès à cette fonctionalité !");

		$client = Dh::getById(intval($data['id']));
		if (empty($client))
			error("Impossible de trouver le client");
		$client->updateOneColumn("adresse_valide", !$client->adresse_valide);
		success(["data" => $client->getForStore()]);
	}

	public function setParrain($data) {
		if (
			!isset($data['id']) ||
			!isset($data['id_parrain'])
		)
			error("La requête est mal formatée");
		$user = Dh::getCurrent();
		if ($user->getType() != "yoda"  && $user->getType() != "assistant")
			error("Vous n'avez pas accès à cette fonctionalité !");
		$client = Dh::getById(intval($data['id']));
		if (empty($client))
			error("Impossible de trouver le client");
		$parrain = Dh::getById(intval($data['id_parrain']));
		if (empty($parrain))
			error("Impossible de trouver le parrain");
		$client->updateOneColumn("id_parrain", $parrain->id_dh);
		success(["data" =>$client->getForStore()]);
	}
}
