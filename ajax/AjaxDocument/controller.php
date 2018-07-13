<?php
require_once("class/core/Ajax.php");
class AjaxDocument  extends Ajax
{
	public function saveDateExecution($data) {
		if (
			!isset($data['id']) ||
			!isset($data['id_type_document']) ||
			!isset($data['type']) ||
			!isset($data['date_execution'])
		)
			error("La requete n'est pas valide ! La date d'execution n'a pas pu être mise à jours");
		$doc = Document::getFromId($data['id']);
		if (count($doc) == 0)
			error("Ce document ne semble pas exister dans la base de donnée !");
		$doc = $doc[0];
		$doc->updateOneColumn("date_execution", $data['date_execution']);
		$doc->updateOneColumn("date_expiration", intval($data['date_execution']) + TIME_LETTRE_MISSION_VALID);

		$dh = Dh::getById(intval($_POST['id_client']));
		if (empty($dh))
			error("Le donneur d'ordre n'a pas pu etre trouvé !");

		
		$params = [
			"nom du fichier" => $doc->filename,
			"type de document" => $doc->getTypeDocument()->getName(),
			"action" => "Changement de la date d'exectution du document",
			"date execution" => date("d/m/Y", $data['date_execution']),
			"date expiration" => date("d/m/Y", intval($data['date_execution']) + TIME_LETTRE_MISSION_VALID),
		];
		Logger::setNew("Changement etat document", Dh::getCurrent()->id_dh, $dh->id_dh, $params);
		success($dh->getDocumentsForStore());
	}
	public function changeSignedDocument($data) {
		$doc = Document::getFromId($data['id']);
		if (count($doc) == 0)
			error("Ce document ne semble pas exister dans la base de donnée !");
		$doc = $doc[0];

		if ($doc->id_type_document == 9 && !$doc->isSigned())
		{
			$projet = $doc->getEntity();
			if (empty($projet))
				error("le REC est lié à un document inexistant !");
			$projet = $projet[0];
			$dh = $projet->getDh();
			$id_crm = Crm2::insertNew(
				$dh->id_dh,
				5,
				1,
				time(),
				-2700,
				"Le Rapport écrit de conseil du projet " .$projet->getName()  . " du bénéficiaire : " . $projet->getBeneficiairesEntity()->getShortName() . " à été signé. ",
				serialize([$projet->id]),
				0
			);
			if (empty($id_crm))
				error("Le changement de status du projet n'a pas pu aboutir.");
			$projet->updateOneColumn('etat_du_projet', 5);
		}
		if ($doc->id_type_document == 9 && $doc->isSigned())
			error("Vous ne pouvez pas annuler la signature d'un rec !");
		$doc->toogleSigned();

		$dh = Dh::getById(intval($_POST['id_client']));
		if (empty($dh))
			error("Le donneur d'ordre n'a pas pu etre trouvé !");
		$params = [
			"nom du fichier" => $doc->filename,
			"type de document" => $doc->getTypeDocument()->getName(),
			"action" => "Changement de l'etat d'un document signé",
			"document signé" => $doc->signed ? "oui" : "non"
		];
		Logger::setNew("Changement etat document", Dh::getCurrent()->id_dh, $dh->id_dh, $params);
		success($dh->getDocumentsForStore());
	}
	public function changeValidatedDocument($data)
	{
		$doc = Document::getFromId($data['id']);
		if (count($doc) == 0)
			error("Ce document ne semble pas exister dans la base de donnée !");
		$doc = $doc[0];

		if ($doc->isValidated())
		{
			if ($dh = Dh::getById($doc->validated_by))
				error("Document déjà validé par " . $dh->getShortName());
			error("Document déjà validé");
		}
		$dh = Dh::getById(intval($_POST['id_client']));
		if ($doc->updateOneColumn('validated_by', $dh->id_dh))
		{
			$params = [
				"nom du fichier" => $doc->filename,
				"type de document" => $doc->getTypeDocument()->getName(),
				"action" => "Changement de l'etat d'un document validé",
				"document validé" => !empty($doc->validated_by) ? "oui" : "non",
				"document validé par" => Dh::getCurrent()->getShortName(),
			];
			Logger::setNew("Changement etat document", Dh::getCurrent()->id_dh, $dh->id_dh, $params);
			success($dh->getDocumentsForStore());
		}
		error("Impossible de valider le document");
	}
	public function deleteDocument($data) {
		if (
			!isset($data['id']) ||
			!isset($data['id_type_document']) ||
			!isset($data['type']) ||
			!isset($data['date_creation'])
		)
			error("La requete n'est pas valide ! le document n'a pas pu etre supprimé");

		$doc = Document::getFromId($data['id']);
		if (empty($doc))
			error("Le document a supprimer n'a pas été trouvé en base de donnée");

		$dh = Dh::getById(intval($_POST['id_client']));
		if (empty($dh))
			error("Le donneur d'ordre n'a pas pu etre trouvé !");

		$doc = $doc[0];
		//$rt = $doc->deleteMe();
		$filename = $doc->filename;
		$typeDocument = $doc->getTypeDocument()->getName();
		$rt = $doc->deleteDocument();
		if (!$rt)
			error("Le document n'a pas pu etre supprimer pour une raison inconnue !");

		$params = [
			"nom du fichier" => $filename,
			"type de document" => $typeDocument,
			"document supprimé par" => Dh::getCurrent($doc->validated_by)->getShortName()
		];
		Logger::setNew("Suppression document", Dh::getCurrent()->id_dh, $dh->id_dh, $params);
		success($dh->getDocumentsForStore());
	}
	public function updateCommentaire($data) {
		if(
			!isset($data['id']) ||
			!isset($data['commentaire']) ||
			!isset($_POST['id_client'])
		)
			error("Il manque des informations ! Le commentaire ne peux pas etre enregistré");
		$doc = Document::getFromId($data['id']);
		if (empty($doc))
			error("Le document n'a pas pu etre trouvé en base !");

		$rt = Dh::getById(intval($_POST['id_client']));
		if (empty($rt))
			error("Le donneur d'ordre n'a pas pu etre trouvé !");

		$doc = $doc[0];
		$doc->updateOneColumnCheckSecurity("commentaire", $data['commentaire']);

		$dh = Dh::getById(intval($_POST['id_client']));
		if (empty($dh))
			error("Le donneur d'ordre n'a pas pu etre trouvé !");
		$params = [
			"nom du fichier" => $doc->filename,
			"type de document" => $doc->getTypeDocument()->getName(),
			"commentaire" => htmlspecialchars($data['commentaire']),
			"action" => "Mise à jour du commentaire du document",
			"commentaire du document mis à jours  par" => Dh::getCurrent($doc->validated_by)->getShortName(),
		];
		Logger::setNew("Changement etat document", Dh::getCurrent()->id_dh, $dh->id_dh, $params);
		success($rt->getDocumentsForStore());
	}
	public function saveNewFile($data) {

		//DevLogs::set(["data" => $data, "ici" => "here"], 1);
		if (
			!isset($_POST['idTypeDocument']) ||
			!isset($_POST['idEntity']) ||
			!isset($_POST['linkEntity']) ||
			count($_FILES)
		) {
			if ($type = $_FILES['document']['type'] != "application/pdf")
				error("Ce format de fichier n'est pas valable !");
			$type = $_FILES['document']['type'];
			$dataE = ft_encryption_file($_FILES["document"]['tmp_name']);
			$dateExecution = "";
			if (isset($_POST['dateExecution']))
				$dateExecution = $_POST['dateExecution'];

			$doc = Document::insertNew(
				$_POST['idTypeDocument'],
				$_POST['idEntity'],
				$_POST['linkEntity'],
				$dataE,
				$type,
				$_FILES['document']['name'],
				$dateExecution
			);
			
			$doc = Document::getFromDocumentEntityId($doc);

			if (empty($doc))
				error("pas save");
			$doc = $doc[0];

			$msg = $doc->updateOneColumn('commentaire', '-');
			if (!$msg)
				error("Le fichier n'a pas pu etre enregistré ! Probleme avec le commentaire");

			$dh = Dh::getById(intval($_POST['id_client']));

			$params = [
				"nom du fichier" => $doc->filename,
				"type de document" => $doc->getTypeDocument()->getName(),
				//"commentaire" => htmlspecialchars($data['commentaire']),
				"Document ajouté par" => Dh::getCurrent()->getShortName(),
			];
			Logger::setNew("Ajout document", Dh::getCurrent()->id_dh, $dh->id_dh, $params);
			success(["doc" => $doc]);
		}
		else
		{
			error("Le fichier n'a pas pu etre enregistré !");
		}
		exit();
	}
}
