<?php
require_once("class/core/Ajax.php");
class AjaxOpportunity extends Ajax
{
	public function reload($data) {
		success(['lst' => Opportunity::getAllForStore()]);
	}
	public function saveData($data) {
		if (
			!isset($data['id']) ||
			!isset($data['type']) ||
			!isset($data['id_scpi']) ||
			!isset($data['time_demembrement']) ||
			!isset($data['price_per_part']) ||
			!isset($data['key_nue']) ||
			!isset($data['nb_part']) ||
			!isset($data['state']) ||
			!isset($data['partial_subscrib']) ||
			!isset($data['id_author']) ||
			!isset($data['validated'])
		)
			error('La requête est mal formatée !');
		if (empty(intval($data['id_scpi'])))
			error("La scpi renseignée n'est pas valide");
		$scpi = Scpi::getFromId(intval($data['id_scpi']));
		if (empty($scpi) || !$scpi->checkShowOpportunite())
			error("La scpi renseignée n'est pas valide");
		$op = new Opportunity();
		if ($data['id'] == 0)
			$op->createForClientAdmin($data);
		else
			$op->updateForClientAdmin($data);
		success(['data' => "OK"]);
	}
	public function add($data) {
		if (!isset($data['crnp']) ||
			!isset($data['cru']) ||
			!isset($data['nb_part']) ||
			!isset($data['price_per_part']) ||
			!isset($data['m_usufruit']) ||
			!isset($data['m_nue']) ||
			!isset($data['m_global']) ||
			!isset($data['m_type']) ||
			!isset($data['m_scpi']) ||
			!isset($data['dem']) ||
			!isset($data['partial']))
			error("La requete est mal formatée");
			$op = new Opportunity();
		$obj = $op->createAdmin($data);
		if (empty($obj))
			error("Impossible d'ajouter la valeur");
		success($obj);
	}

	public function updateData($data) {
		if (!isset($data['id']) ||
			!isset($data['type']) ||
			!isset($data['parts']) ||
			!isset($data['duree']) ||
			!isset($data['key']) ||
			!isset($data['partiel']) ||
			!isset($data['part']) ||
			!isset($data['active']) ||
			!isset($data['state']))
			error("La requete est mal formatée");
			$op = new Opportunity();
		if ($op->updateAdmin($data) == null)
			error("La requete est mal formatée");
	}

	public function deleteOp($data) {
		$op = new Opportunity();
		$obj = $op->deleteAdmin($data);
		success($obj);
	}
}
