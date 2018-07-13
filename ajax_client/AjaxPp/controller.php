<?php
require_once("class/core/AjaxClient.php");
class AjaxPp extends AjaxClient
{
	public function saveAdresse($data) {
		$err = false;
		$errMsg = [];
		/*
			Procédure:
			Vérifier que toutes les informations nécessaires sont bien présentes !
		*/
		if (
			!isset($data['complementAdresse']) ||
			!isset($data['extension']) ||
			!isset($data['numeroRue']) ||
			!isset($data['type_voie']) ||
			!isset($data['voie']) ||
			!isset($data['codePostal']) ||
			!isset($data['ville']) ||
			!isset($data['pays'])
		)
			error("Une donnée nécessaire à l'enregistrement de l'adresse postale est manquante !");

		/*
			Vérification de l'utilisateur
		*/
		$dh = Dh::getCurrent();
		if (empty($dh))
			error("Vous n'ètes pas connectés");
		$Pp = Pp::getFromId(intval($data['id']));
		if (empty($Pp))
			error("La personne physique n'a pas été trouvée");
		$Pp = $Pp[0];
		if ($Pp->lien_dh != $dh->id_dh)
			error("Vous ne pouvez pas modifier cette personne physique");


		/*
			Vérifier tous les champs
		*/
		$numeroRue = intval($data['numeroRue']);
		if ($numeroRue < 1) {
			$err = true;
			$errMsg['numero'] = "Merci d'indiquer un numéro valide";
		}
		else
			$Pp->updateOneColumn("numeroRue", intval($numeroRue));
		
		$type_voie = htmlspecialchars($data['type_voie']);
		if (!in_array($type_voie, Pp::$_type_voie)) {
			$err = true;
			$errMsg["type_voie"] = "Merci d'indiquer un type de voie valide";
		}
		else
			$Pp->updateOneColumn("type_voie", $type_voie);

		$complementAdresse = htmlspecialchars($data['complementAdresse']);
		//if (!empty($complementAdresse))
			$Pp->updateOneColumn("complementAdresse", $complementAdresse);

		$extension = htmlspecialchars($data['extension']);
		//if (!empty($extension))
			$Pp->updateOneColumn("extension", $extension);

		$voie = htmlspecialchars($data['voie']);
		if (empty($voie) || strlen($voie) < 3) {
			$err = true;
			$errMsg["voie"] = "Merci d'indiquer un nom de voie valide";
		}
		else
			$Pp->setVoie($voie);
			//$Pp->updateOneColumn("voie", $voie);


		$pays = htmlspecialchars($data['pays']);
		if (empty($pays) || empty(Pays::getFromKeyValue("nom_fr_fr", $pays))) {
			$err = true;
			$errMsg['pays'] = "Merci d'indiquer un nom de pays valide
";
		}
		else
			$Pp->updateOneColumn("pays", $pays);


		$codePostal = htmlspecialchars($data['codePostal']);
		$ville = htmlspecialchars($data['ville']);

		/*
			Si France : Vérifier si les données renseignées sont en base
			Sinon : Vérifier si les données renseignées sont bien renseignée. et > 2 caractères.
		*/
		if ($pays == "France")
		{
			$err2 = false;
			$codePostal = intval($codePostal);
			if ($codePostal < 1000) {
				$err = true;
				$err2 = true;
				$errMsg["code_postal"] = "Merci d'indiquer un code postal valide";
			}

			if (empty($ville) || strlen($ville) < 3) {
				$err = true;
				$err2 = true;
				$errMsg["ville"] = "Merci d'indiquer un nom de ville valide";
			}

			$ville = trim(strtoupper($ville));
			if (!$err2)
			{
				$data = [
					$ville,
					$codePostal
				];
				$cv = Database::prepare("mscpi_db", "SELECT * FROM `code_ville` WHERE Nom_commune =  ? AND Code_postal = ?;", $data, "CodeVille");
				if (empty($cv)) {
					$err = true;
					$errMsg["code_postal"] = "Merci d'indiquer un code postal valide";
					$errMsg["ville"] = "Merci d'indiquer un nom de ville valide";
				} else {
					$Pp->updateOneColumn("codePostal", $cv[0]->Code_postal);
					$Pp->updateOneColumn("ville", $cv[0]->Nom_commune);
				}
			}
		}
		else
		{
			if (empty($codePostal) || strlen($codePostal) < 3) {
				$err = true;
				$err2 = true;
				$errMsg["code_postal"] = "Merci d'indiquer un code postal valide";
			}

			if (empty($ville) || strlen($ville) < 3) {
				$err = true;
				$err2 = true;
				$errMsg["ville"] = "Merci d'indiquer un nom de ville valide";
			}
		}


		if ($err)
			error($errMsg);

		if ($Pp->id_phs == $dh->lien_phy)
			$dh->updateOneColumn("adresse_valide", 1);

		$params = [
			"infos" => "Validation de l'adresse postale sur le front",
			"Numéro de rue" => $numeroRue,
			"Extension" => $extension,
			"type de voie" => $type_voie,
			"Complément d'adresse" => $complementAdresse,
			"voie" => $voie,
			"code postal" => $codePostal,
			"ville" => $ville,
			"pays" => $pays
		];
		Logger::setNew("Adresse postale valide", $dh->id_dh, $dh->id_dh, $params);
		success(["data" => $Pp->getForFrontStore()]);
	}
}
