<?php
require_once("class/core/AjaxClient.php");

class RestProject extends AjaxClient
{
	public function setStatus3($data) {
		if (
			!isset($data['id']) ||
			!isset($data['message'])
		)
			error("La requete n'est pas valide");

		$dh = Dh::getCurrent();
		$projet = Projet::getFromId(intval($data['id']));
		if (count($projet) == 0)
			error("Ce projet ne semble pas exister dans la base de donnée");
		$projet = $projet[0];

		if ($projet->getDh()->id_dh != $dh->id_dh)
			error("Accès refusé !");

		if ($projet->getEtatProjet() != 2)
			error("Un projet avec un etat different de 2 ne peux pas passer a l'etat 3 !");

		$message = htmlspecialchars($data['message']);

		$id_crm = Crm2::insertNew(
			$dh->id_dh,
			5,
			1,
			time(),
			-2700,
			"La proposition d'investissement pour le projet " .$projet->getName()  . " du bénéficiaire : " . $projet->getBeneficiairesEntity()->getShortName() . " à été refusée ! <br /> <br /> <b> Pourriez-vous nous donner quelques précision à propos de votre refus ?</b> <br /> <blockquote>" . $message . "</blockquote>",
			serialize([$projet->id]),
		0
		);

		if (empty($id_crm))
			error("Le changement de status du projet n'a pas pu aboutir.");

		Crm2::getFromId($id_crm)[0]->updateOneColumn("priority", 5);

		$log = Logger::setNew("Proposition d'investissement refuse", $dh->id_dh, $dh->id_dh, [
			'Id du Crm' => $id_crm,
			'Beneficiaire' => $projet->getBeneficiairesEntity()->getShortName(),
			'Id du projet' => $projet->id,
			'Nom du projet' => $projet->getName(),
			'link' => '?p=EditionClient&client=' . $dh->id_dh
		]);

		if (empty($log))
			error("Le changement de status du projet n'a pas pu aboutir.");

		Crm2::getFromId($id_crm)[0]->updateOneColumn("priority", 5);

		$projet->updateOneColumn("etat_du_projet", 3);
		return ($projet);
	}
	public function setStatus4($data) {
		if ( !isset($data['id']))
			error("La requete n'est pas valide");
		$dh = Dh::getCurrent();
		$projet = Projet::getFromId(intval($data['id']));

		if (count($projet) == 0)
			error("Ce projet ne semble pas exister dans la base de donnée");
		$projet = $projet[0];

		if ($projet->getDh()->id_dh != $dh->id_dh)
			error("Accès refusé !");

		if ($projet->getEtatProjet() != 2)
			error("Un projet avec un etat different de 2 ne peux pas passer a l'etat 4 !");

		$rec = $projet->getNewRec();
		$doc = Document::insertNew(
			9,
			5,
			$projet->id,
			ft_simple_encryption_file($rec->getPdf()),
			"application/pdf",
			"REC",
			null
		);

		$id_crm = Crm2::insertNew(
			$dh->id_dh,
			5,
			1,
			time(),
			-2700,
			"La proposition d'investissement pour le projet " .$projet->getName()  . " du bénéficiaire : " . $projet->getBeneficiairesEntity()->getShortName() . " à été acceptée.",
			serialize([$projet->id]),
			0
		);

		if (empty($id_crm))
			error("Le changement de status du projet n'a pas pu aboutir.");

		Crm2::getFromId($id_crm)[0]->updateOneColumn("priority", 5);

		$log = Logger::setNew("Proposition d'investissement accepte", $dh->id_dh, $dh->id_dh, [
			'Id du Crm' => $id_crm,
			'Beneficiaire' => $projet->getBeneficiairesEntity()->getShortName(),
			'Id du projet' => $projet->id,
			'Nom du projet' => $projet->getName(),
			'link' => '?p=EditionClient&client=' . $dh->id_dh
		]);

		if (empty($log))
			error("Le changement de status du projet n'a pas pu aboutir.");

		// TODO : On lance automatiquement la génération du REC.
		$projet->updateOneColumn("etat_du_projet", 4);
		$nProj = Projet::getFromId($projet->id)[0];
		return ($nProj->getForFrontStore());
	}
	public function updateName($data) {
		if (
			!isset($data['id']) ||
			!isset($data['nom']) ||
			strlen($data['nom']) < 2
		)
			error("Le nom du projet n'a pas pu etre mis a jours !");
		$projet = projet::getFromId($data['id']);
		if (empty($projet))
			error("Le nom du projet n'a pas pu etre mis a jours !");
		$projet[0]->updateOneColumn("nom", htmlspecialchars($data['nom']));
		success("Changement du nom du projet Okay");
	}
	public function contactProjet($data) {
		if ( !isset($data['id']))
			error("La requete n'est pas valide");

		// Insertion de Crm contenant les information du projet.
		$dh = Dh::getCurrent();
		$projet = Projet::getFromId(intval($data['id']));

		if (count($projet) == 0)
			error("Ce projet ne semble pas exister dans la base de donnée");
		$projet = $projet[0];
		
		if ($projet->getDh()->id_dh != $dh->id_dh)
			error("Accès refusé !");

		$id_crm = Crm2::insertNew(
			$dh->id_dh,
			5,
			1,
			time(),
			-2700,
			"Le donneur d'ordre souhaite être contacté concernant la proposition d'investissement pour le projet " .$projet->getName()  . " du bénéficiaire : " . $projet->getBeneficiairesEntity()->getShortName() . ".",
			serialize([$projet->id]),
			0
		);
		if (empty($id_crm))
			error("Le changement de status du projet n'a pas pu aboutir.");

		Crm2::getFromId($id_crm)[0]->updateOneColumn("priority", 5);

		success("Demande de contact Okay");
		error("Erreur de test");
	}
}
