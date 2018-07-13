<?php
require_once("class/core/Ajax.php");
class RestProject  extends Ajax
{
	/*
		id
		id_scpi
		type_pro
		nbr_part
		prix_part
		status_transaction
	*/

	public function reloadOne($data) {
		if ( !isset($data['id']))
			error("La requête est ma lformatée !");
		$projet = Projet::getFromId($data['id']);
		if (empty($projet))
			error("Le projet à mettre a jour n'a pas été trouvé dans la base donnée.");
		$projet = $projet[0];
		success($projet->getForStore());
	}

	public function setObjectifsList1($data) {
		if (
			!isset($data['id']) ||
			!isset($data['id_objectifs_list_1'])
		)
			error("La requête est ma lformatée !");

		$projet = Projet::getFromId(intval($data['id']));
		if (empty($projet))
			error("Le Projet en question n'a pas été trouvé en base de donnée !");
		$projet = $projet[0];
		$projet->updateOneColumn("id_objectifs_list_1", intval($data['id_objectifs_list_1']));
		success($projet);
	}
	public function setObjectifsList2($data) {
		if (
			!isset($data['id']) ||
			!isset($data['id_objectifs_list_2'])
		)
			error("La requête est ma lformatée !");

		$projet = Projet::getFromId(intval($data['id']));
		if (empty($projet))
			error("Le Projet en question n'a pas été trouvé en base de donnée !");
		$projet = $projet[0];
		$projet->updateOneColumn("id_objectifs_list_2", intval($data['id_objectifs_list_2']));
		success($projet);
	}
	public function setObjectifsList3($data) {
		if (
			!isset($data['id']) ||
			!isset($data['id_objectifs_list_3'])
		)
			error("La requête est ma lformatée !");

		$projet = Projet::getFromId(intval($data['id']));
		if (empty($projet))
			error("Le Projet en question n'a pas été trouvé en base de donnée !");
		$projet = $projet[0];
		$projet->updateOneColumn("id_objectifs_list_3", intval($data['id_objectifs_list_3']));
		success($projet);
	}
	public function generateRec($data) {
		if ( !isset($data['id']))
			error("La requete n'est pas complete");
		$projet = Projet::getFromId(intval($data['id']));
		if (count($projet) == 0)
			error("Ce projet ne semble pas exister !");
		$projet = $projet[0];
		$rec = $projet->getNewRec();
		$doc = Document::insertNew(
			9,
			5,
			$projet->id,
			ft_simple_encryption_file($rec),
			"application/pdf",
			"REC",
			null
		);
		success("C'est okay");
	}
	public function setStatus1($data) {
		if (
			!isset($data['id'])
		)
			error("La requete n'est pas valide");

		$projet = Projet::getFromId(intval($data['id']));
		if (count($projet) == 0)
			error("Ce projet ne semble pas exister dans la base de donnée");
			$projet = $projet[0];

		if ($projet->getEtatProjet() != 0)
			error("Un projet avec un etat different de 0 ne peux pas passer a l'etat 1 !");

		$projet->updateOneColumn("etat_du_projet", 1);
		$projet->getDh()->sendMail("Début de l'étude de votre projet d'investissement", $projet->getName(), "projectEtudeStart");
		return ($projet);
	}
	public function setStatus2($data) {
		if (
			!isset($data['id'])
		)
			error("La requete n'est pas valide");

		$projet = Projet::getFromId(intval($data['id']));
		if (count($projet) == 0)
			error("Ce projet ne semble pas exister dans la base de donnée");
			$projet = $projet[0];

		if ($projet->getEtatProjet() != 1 && $projet->getEtatProjet() != 3)
			error("Un projet avec un etat different de 1 ou 3 ne peux pas passer a l'etat 2 !");

		$comparaison	= $projet->getDocuments(7);
		if (count($comparaison) == 0)
			error("L'etat du projet ne peux pas passer a 1 sans avoir au moin une comparaison");

		$simulation	= $projet->getDocuments(8);
		if (count($simulation) == 0)
			error("L'etat du projet ne peux pas passer a 1 sans avoir au moin une simulation");

		$transaction	= $projet->getTransaction();
		if (count($transaction) == 0)
			error("L'etat du projet ne peux pas passer a 1 sans avoir au moins une transaction");

/*
		$recs			= $projet->getDocuments(9);
		if (count($recs) == 0)
			error("L'etat du projet ne peux pas passer a 1 sans avoir un REC");
			*/

		$projet->updateOneColumn("etat_du_projet", 2);
		$projet->getDh()->sendMail("Nouvelle Proposition d'investissement", $projet->getName(), "firstProposition");
		return ($projet);
	}
	public function setStatus2Save($data) {
		/*
			Faire les vérifications nécéssaires au changement de status :
				A une simulation
				A une comparaison
				A au moin une transaction
				A un REC qui est signé

			Passer le status du projet a 1;
		*/
		if (
			!isset($data['id'])
		)
			error("La requete n'est pas valide");
		$projet = Projet::getFromId(intval($data['id']));
		if (count($projet) == 0)
			error("Ce projet ne semble pas exister dans la base de donnée");
			$projet = $projet[0];

		if ($projet->getEtatProjet() < 1)
			$this->setStatus1($data);

		$recs			= $projet->getDocuments(9);
		foreach ($recs as $key => $elm)
		{
			if ($elm->isSigned())
			{
				$projet->updateOneColumn("etat_du_projet", 2);
				return ($projet);
			}
		}
		error("Le projet ne peux pas passer a l'etat 2 sans avoir de rec signé");
	}
	public function updateName($data) {
		if (
			!isset($data['id']) ||
			!isset($data['nom']) ||
			strlen($data['nom']) < 2
		)
			error("Le nom du projet n'a pas pu etre mis a jours !");
		$projet = Projet::getFromId(intval($data['id']));
		if (empty($projet))
			error("Le nom du projet n'a pas pu etre mis a jours !");
		$projet[0]->updateOneColumn("nom", htmlspecialchars($data['nom']));
		success("Changement du nom du projet Okay");
	}


	public function updateAutresElements($data) {
		if (
			!isset($data['id']) ||
			!isset($data['autres_elements']) ||
			strlen($data['autres_elements']) < 2
		)
			error("L'informations concernant les autres éléments ayant déterminés le consiles n'ont pas pu etre mis a jours !");
		$projet = Projet::getFromId(intval($data['id']));
		if (empty($projet))
			error("L'informations concernant les autres éléments ayant déterminés le consiles n'ont pas pu etre mis a jours ! car le projet n'a pas pu etre trouvé !");
		$projet[0]->updateOneColumnCheckSecurity("autres_elements", $data['autres_elements']);
		success($projet[0]);
		//success("Les autres éléments ayanta déterminés le conseils ont bien été mis à jours");
	}
	public function updateStrategie($data) {
		if (
			!isset($data['id']) ||
			!isset($data['strategie']) ||
			strlen($data['strategie']) < 2
		)
			error("La stratégie n'a pas pu etre mis a jours !");
		$projet = Projet::getFromId(intval($data['id']));
		if (empty($projet))
			error("Le stratégie n'a pas pu etre mis a jours !");
		$projet[0]->updateOneColumnCheckSecurity("strategie", $data['strategie']);
		success($projet[0]);
		//success("La stratégie a bien été mis à jours");
	}
	public function updateCommentaire($data) {
		if (
			!isset($data['id']) ||
			!isset($data['commentaire']) ||
			strlen($data['commentaire']) < 2
		)
			error("Le comentaire n'a pas pu etre mis a jours !");
		$projet = Projet::getFromId(intval($data['id']));
		if (empty($projet))
			error("Le comentaire n'a pas pu etre mis a jours !");
		$projet[0]->updateOneColumnCheckSecurity("commentaire", $data['commentaire']);
		//success("Le commentaire à bien été mis à jours");
		success($projet[0]);
	}















	public function setStatus3($data) {
		if (
			!isset($data['id'])
		)
			error("La requete n'est pas valide");

		$dh = Dh::getCurrent();
		$projet = Projet::getFromId(intval($data['id']));
		if (count($projet) == 0)
			error("Ce projet ne semble pas exister dans la base de donnée");
		$projet = $projet[0];

		if ($projet->getEtatProjet() != 2)
			error("Un projet avec un etat different de 2 ne peux pas passer a l'etat 3 !");

		$id_crm = Crm2::insertNew(
			$projet->getDh()->id_dh,
			5,
			1,
			time(),
			-2700,
			$dh->getShortName() .  " à définit comme refusée la proposition d'investissement concernant le projet " . $projet->getName()  . " du bénéficiaire : " . $projet->getBeneficiairesEntity()->getShortName() . ".",
			serialize([$projet->id]),
		0
		);

		if (empty($id_crm))
			error("Le changement de status du projet n'a pas pu aboutir.");

		Crm2::getFromId($id_crm)[0]->updateOneColumn("priority", 5);

/*
		$log = Logger::setNew("Proposition d'investissement refuse", $dh->id_dh, $dh->id_dh, [
			'Id du Crm' => $id_crm,
			'Beneficiaire' => $projet->getBeneficiairesEntity()->getShortName(),
			'Id du projet' => $projet->id,
			'Nom du projet' => $projet->getName(),
			'link' => '?p=EditionClient&client=' . $dh->id_dh
		]);
		if (empty($log))
			error("Le changement de status du projet n'a pas pu aboutir.");
			*/
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
			$projet->getDh()->id_dh,
			5,
			1,
			time(),
			-2700,
			$dh->getShortName() .  " à définit proposition d'investissement comme accepté pour le projet " .$projet->getName()  . " du bénéficiaire : " . $projet->getBeneficiairesEntity()->getShortName() . " à été acceptée.",
			serialize([$projet->id]),
			0
		);

		if (empty($id_crm))
			error("Le changement de status du projet n'a pas pu aboutir.");

		Crm2::getFromId($id_crm)[0]->updateOneColumn("priority", 5);

		/*
		$log = Logger::setNew("Proposition d'investissement accepte", $dh->id_dh, $dh->id_dh, [
			'Id du Crm' => $id_crm,
			'Beneficiaire' => $projet->getBeneficiairesEntity()->getShortName(),
			'Id du projet' => $projet->id,
			'Nom du projet' => $projet->getName(),
			'link' => '?p=EditionClient&client=' . $dh->id_dh
		]);

		if (empty($log))
			error("Le changement de status du projet n'a pas pu aboutir.");
		*/

		// TODO : On lance automatiquement la génération du REC.
		$projet->updateOneColumn("etat_du_projet", 4);
		$nProj = Projet::getFromId($projet->id)[0];
		return ($nProj->getForFrontStore());
	}
}
