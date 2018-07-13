<?php
require_once("class/core/Ajax.php");
class AjaxCrm extends Ajax
{
	public function insertNewCrm($data) {

		$id_client = intval($data['id_client']);
		$sujetSelected = intval($data['sujetSelected']);
		$contactSelected = intval($data['contactSelected']);
		$date_execution = intval($data['date_execution']);
		$duree = intval($data['duree']);
		$priority = intval($data['priority']);
		$commentaire = str_replace("script", "", $data['commentaire']);
		$isOkay = $data['isOkay'] == "1";

		$lstIdProject = serialize([]);
		if (
			isset($data['projectsId']) &&
			is_array($data['projectsId'])
		)
		{
			$lstIdProject = serialize($data['projectsId']);
		}

		$idCrm = Crm2::insertNew(
			$id_client,
			$sujetSelected,
			$contactSelected,
			$date_execution,
			$duree,
			$commentaire,
			$lstIdProject,
			$isOkay	
		);
		if (empty($idCrm))
			return (false);
		$crm = Crm2::getFromId($idCrm)[0];
		$crm->updateOneColumnCheckSecurity("priority", $priority);
		if ($isOkay)
		{
			$crm->updateOneColumnCheckSecurity("date_end", time());
		}

		return (true);
	}
	public function updateCrm($data) {
		//Crm2::getFromId($data['id'])[0]->updateOneColumn("isOkay", 1);
		//return (true);
		$id = intval($data['id']);
		$id_client = intval($data['id_client']);
		$sujetSelected = intval($data['sujetSelected']);
		$contactSelected = intval($data['contactSelected']);
		$date_execution = intval($data['date_execution']);
		$duree = intval($data['duree']);
		$isOkay = $data['isOkay'] == "1";
		$priority = intval($data['priority']);
		$commentaire = str_replace("script", "", $data['commentaire']);

		$priority = intval($data['priority']);

		$lstIdProject = serialize([]);
		if (
			isset($data['projectsId']) &&
			is_array($data['projectsId'])
		)
		{
			$lstIdProject = serialize($data['projectsId']);
		}

		$crm = Crm2::getFromId($id);
		if (empty($crm) || $id_client != $crm[0]->getIdClient())
		{
			http_response_code(400);
			echo json_encode([]);
			exit();
		}
		$crm = $crm[0];

		// Suppression de la tache automatise si il y en a une
		//$AT = $crm->getAutoTask();
		if (!empty($AT) && $AT->date_end === null)
			$AT->updateOneColumnCheckSecurity("date_end", 0);

		// Si le Crm n'est pas validé, Insertion d'une nouvelle tache.
		if ($isOkay != 1) {
			//$dh = Dh::getCurrent();
			$dh = Dh::getById($id_client)->getConseiller();
			$client = Dh::getById($id_client);
			$titre = $client->getShortName();
			$comment = Crm2::$_contacts[$contactSelected]['name'] . " " . Crm2::$_sujets[$sujetSelected]['name'] . "<br />" . $commentaire;
			/*
			$id_autotask = AutoTask::insertSpotTask($dh->id_dh, "Notifications", "sendToDhWithTemplateForTask", [
					'dh' => $dh->id_dh,
					'title' => $titre,
					'content' => $comment,
					'templateId' => 1,
					"id_crm" => $crm->id,
					'link' => '?p=EditionClient&client=' . $id_client . '&onglet=SUIVI&id_crm=' . $crm->id
				],
			$date_execution - TIME_BEFORE_NOTIFICATIONS);
			*/
			//$crm->updateOneColumnCheckSecurity("id_autotask", $id_autotask);
		}
		else {
			$crm->updateOneColumnCheckSecurity("date_end", time());
		}
		$crm->updateOneColumnCheckSecurity("sujetSelected", $sujetSelected);
		$crm->updateOneColumnCheckSecurity("contactSelected", $contactSelected);
		$crm->updateOneColumnCheckSecurity("date_execution", $date_execution);
		$crm->updateOneColumnCheckSecurity("duree", $duree);
		$crm->updateOneColumnCheckSecurity("commentaire", str_replace("script", "" ,$commentaire));
		$crm->updateOneColumnCheckSecurity("lstIdProject", $lstIdProject);
		$crm->updateOneColumnCheckSecurity("date_modification", time());

		$crm->updateOneColumnCheckSecurity("priority", $priority);
		if ($isOkay)
			$crm->setOkay();
		else
			$crm->updateOneColumnCheckSecurity("isOkay", $isOkay);
		return (true);
	}
}
