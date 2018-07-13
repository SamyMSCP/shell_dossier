<?php
require_once("class/core/AjaxClient.php");
class AjaxOpportunity extends AjaxClient
{
	public function add($data) {
		if (
			!isset($data['crnp']) ||
			!isset($data['cru']) ||
			!isset($data['nb_part']) ||
			!isset($data['price_per_part']) ||
			!isset($data['m_usufruit']) ||
			!isset($data['m_nue']) ||
			!isset($data['m_global']) ||
			!isset($data['m_type']) ||
			!isset($data['m_scpi']) ||
			!isset($data['dem']) ||
			!isset($data['partial'])
		)
			error("La requete est mal formatée");

		if (intval($data['m_type']) != 0 && intval($data['m_type']) != 1)
			error("Le type de propriété n'est pas valide !");
		if (intval($data['partial']) != 0 && intval($data['partial']) != 1)
			error("Le formulaire n'est pas complet");
		if (intval($data['nb_part']) <= 0)
			error("Le nombre de part n'est pas valide");
		if (intval($data['cru']) < 1 || intval($data['cru'] > 50))
			error("La clé de répartition (Usufruit) ne peut pas être inférieure à 1 %");
		if (intval($data['dem']) < 2 || intval($data['dem'] > 20))
			error("La durée du démembrement n'est pas valide");
		if (empty(intval($data['m_scpi'])))
			error("La scpi renseignée n'est pas valide");

		$scpi = Scpi::getFromId(intval($data['m_scpi']));
		if (empty($scpi) || !$scpi->checkShowOpportunite())
			error("La scpi renseignée n'est pas valide");
		$op = new Opportunity();
		$obj = $op->createUser($data);
		if (empty($obj))
			error("L'objectif à mettre a jour n'a pas pu être trouvé sur la base de donnée !");
		$date = time() + (24 * 60 * 60);
		$id_crm = Crm2::insertNew(Dh::getCurrent()->id_dh, 8, 0, $date, -1, "
			Le client a fait une demande sur le module opportunité, merci de valider cette demande au plus vite. <br />
			<a href='http://{$_SERVER['SERVER_NAME']}/admin_lkje5sjwjpzkhdl42mscpi.php?p=Opportunity' target='_blank'>page des opportunit&eacute;</a>", [], 0);

		if (!empty($id_crm))
			Crm2::getFromId($id_crm)[0]->updateOneColumn("priority", 5);

		//TODO: On envoie un mail a Jonathan D'Hiver (2) et Andrea (1616)
		MailSender::sendToDhWithTemplateName((Dh::getById(2)), "Une nouvelle opportunité est disponible", "", "nouvelle_opportunite");
		MailSender::sendToDhWithTemplateName((Dh::getById(1616)), "Une nouvelle opportunité est disponible", "", "nouvelle_opportunite");
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
			!isset($data['state']))
			error("La requete est mal formatée");
		$op = new Opportunity();
		$op->updateUser($data);
	}

	public function interest($data) {
		// Vérifier si il n'y a pas déja une entrée en base !
		$dh = Dh::getCurrent();
		if (!empty(OpportunityInteract::getFromKeysValues([
			"op_id" => $data['id'],
			"uid" => $dh->id_dh
		])))
		{
			error("Vous êtes déjà inscrit à cette opportunité");
			exit();
		}
		$date = time() + (24 * 60 * 60);
		$op = Opportunity::getFromId(intval($data['id']))[0];
		if (empty($op))
			error('Cette Opportunité ne semble pas fonctionner !');
		$scpi = Scpi::getFromId($op->id_scpi);
		if (empty($scpi))
			error('Cette SCPI ne semble pas fonctionner !');
		$key = ($op->type == 1) ? $op->key_nue / 100 : ((100 - $op->key_nue) / 100);
		ob_start();
		include('crm.php');
		$code = ob_get_contents();
		ob_end_clean();
		$id_crm = Crm2::insertNew($dh->id_dh, 8, 0, $date, -1, "Le client est interressé par l'opportunité suivante : <br /> $code", [], 0);

		if (!empty($id_crm))
			Crm2::getFromId($id_crm)[0]->updateOneColumn("priority", 5);
		$params = [
			"id_opportunite" => $op->id,
			"SCPI" => $scpi->name,
			"Type propriété" => ($op->type == 1) ? "Nue propriété" : "Usufruit",
			"Démembrement" => $op->time_demembrement,
			"Prix par parts" => $op->price_per_part * $key,
			"Nombre de parts" => $op->nb_part,
			"Clé de répartition" => $key * 100,
			"Volume d'investissement" => $op->price_per_part * $key * intval($op->nb_part),
			"Souscription partielle ?" => ($op->partial_subscrib) ? "oui" : "non",
		];
		Logger::setNew("Inscription a une opportunite", $dh->id_dh, $dh->id_dh, $params);
		$op = new Opportunity();
		$op->interrest($data);
	}
}
