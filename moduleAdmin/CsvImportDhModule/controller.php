<?php
require_once("class/core/ModuleAdmin.php");
class CsvImportDhModule extends ModuleAdmin
{
	public function getPostData() {
		$entete = array();
		foreach ($_POST as $key => $elm) {
			if (strncmp($key, "0", 1) != 0)
				break ;
			$entete[] = str_replace("_", " ", substr($key, 2));
		}
		$i = -1;
		$j = 0;
		$check = ParseCsv::getDhCheck();
		$rt = array();
		$rt["entete"] = $entete;
		foreach ($_POST as $key => $elm) {
			if (strncmp($key, $i, strlen($i)) != 0) {
				if ($i >= 0) {
					if (isset($current["data"]["MAIL"]) && count(Dh::getByLogin($current["data"]["MAIL"]))) {
						$current["errorFormat"]["alreadyExist"] = true;
						$current["errorFormat"]["canAdd"] = false;
						if ($current["preSelection"] === null)
							$current["preSelection"] = "nothing";
							/*
		// Verification du nom et prenom
		if (
			!isset($_POST['nom']) ||
			strlen($_POST['nom']) < 2 ||
			strlen($_POST['nom']) > 42
		)
		{
			Notif::set('msgCreateAccount', "Le nom renseigné n'est pas valide");
			return (0);
		}
		*/
						foreach (ParseCsv::getDhDataFromBdd() as $key2 => $elm2) {
							$current["oldData"][$key2] = $elm2(Dh::getByLogin($current["data"]["MAIL"])[0]);
						}
					}
					else
					{
						$current["errorFormat"]["canUpdate"] = false;
						if ($current["preSelection"] === null)
							$current["preSelection"] = "add";
					}
					$rt[] = $current;
				}
				$current = array(
					"data" => null,
					"errorFormat" => null,
					"oldData" => null,
					"preSelection" => null
				);
				$current["errorFormat"]["canAdd"] = true;
				$current['errorFormat']["canUpdate"] = true;
				$i++;
				$j = 0;
			}
			if (isset($check[$entete[$j]])) {
				//Check du format
				if ($check[$entete[$j]]($elm) === false) {
					if ($entete[$j] === "NUMERO DE TELEPHONE PORTABLE" && !empty($elm)) {
						$elm = trim($elm);
						if (!strstr($elm, "+")) {
							$elm = "+33" . substr($elm, 1);
						}
					}
					$current["errorFormat"][$entete[$j]] = true;
					$current['errorFormat']["canAdd"] = false;
					$current['errorFormat']["canUpdate"] = false;
				}
				$current['data'][$entete[$j]] = $elm;
			}
			else
			{
				if (strstr($key, "DOING"))
					$current["preSelection"] = $elm;
			}
			$j++;
		}
		return ($rt);
	}
	public function insert($data) {
		$rtArr = array();
		foreach ($data as $key => $elm) {
			if ($key === "entete")
				continue ;
			if ($elm['errorFormat']['canAdd'] && $elm['preSelection'] == "add") {
				$pass = "Ms" . generateRandomString(7) . "75";
				if ($elm['data']['CIVILITE'] === "M.")
					$elm['data']['CIVILITE'] = "Monsieur";
				else if ($elm['data']['CIVILITE'] === "Mme")
					$elm['data']['CIVILITE'] = "Madame";
					/*
				echo "Cet element sera ajoute :<br />";
				echo $elm['data']['CIVILITE'] . "<br />";
				echo $elm['data']['NOM'] . "<br />";
				echo $elm['data']['PRENOM'] . "<br />";
				echo $elm['data']['INDICATIF PAYS'] . "<br />";
				echo $elm['data']['NUMERO DE TELEPHONE PORTABLE'] . "<br />";
				echo $elm['data']['INDICATIF PAYS2'] . "<br />";
				echo $elm['data']['NUMERO DE TELEPHONE FIXE'] . "<br />";
				echo $elm['data']['MAIL'] . "<br />";
				echo $elm['data']['TYPE DE COMPTE'] . "<br />";
				*/
				if (empty($elm['data']['NUMERO DE TELEPHONE PORTABLE']))
					$elm['data']['NUMERO DE TELEPHONE PORTABLE'] = " ";
				if (empty($elm['data']['NUMERO DE TELEPHONE FIXE']))
					$elm['data']['NUMERO DE TELEPHONE FIXE'] = " ";
				$elm['data']['TYPE DE COMPTE'] = strtolower($elm['data']['TYPE DE COMPTE']);
				if (in_array($elm['data']['TYPE DE COMPTE'], Dh::$typeDeCompte))
				{
					//Code pour ajouter un collaborateur
					$id_dh = Database::prepareInsert('mscpi_db', "INSERT INTO `DONNEUR D'ORDRE` (
						login,
						conseiller,
						type,
						password,
						mdp_tmp,
						confirmation

						) VALUES(
						:mail,
						-1,
						:type,
						:password,
						1,
						1

						);", array(
						":mail" => ft_crypt_information($elm['data']['MAIL']),
						":type" => $elm['data']['TYPE DE COMPTE'],
						":password" => ft_crypt_pass($pass)
						));
					$id_phs = Database::prepareInsert('mscpi_db', "INSERT INTO `PERSONNE PHYSIQUE` (
						civilite,
						nom,
						prenom,
						mail,
						telephone,
						indicatif_telephonique,
						telephone_fixe,
						indicatif_telephonique_fixe,
						lien_dh

						) VALUES(
						:civilite,
						:nom,
						:prenom,
						:mail,
						:telephone,
						:indicatif_telephonique,
						:telephone_fixe,
						:indicatif_telephonique_fixe,
						$id_dh

						);", array(
						":civilite" => ft_crypt_information($elm['data']['CIVILITE']),
						":nom" => ft_crypt_information($elm['data']['NOM']),
						":prenom" => ft_crypt_information($elm['data']['PRENOM']),
						":mail" => ft_crypt_information($elm['data']['MAIL']),
						":telephone" => ft_crypt_information($elm['data']['NUMERO DE TELEPHONE PORTABLE']),
						":telephone_fixe" => ft_crypt_information($elm['data']['NUMERO DE TELEPHONE FIXE']),
						":indicatif_telephonique" => $elm['data']['INDICATIF PAYS'],
						":indicatif_telephonique_fixe" => $elm['data']['INDICATIF PAYS2']
						));
						Database::exec("mscpi_db", "UPDATE `DONNEUR D'ORDRE` SET lien_phy = $id_phs WHERE id_dh = $id_dh");
						$exPp = Dh::getById($id_dh)->getPersonnePhysique();
						$rtArr[] = array(
							"action" => "add",
							"civilite" => $exPp->getCiviliteFormat(),
							"prenom" => $exPp->getFirstName(),
							"nom" => $exPp->getName(),
							"type" => $elm['data']['TYPE DE COMPTE'],
							"login" => $elm['data']['MAIL'],
							"mdp" => $pass
						);

						$dhImport = Dh::getById($id_dh);
						$params = [
							"id" => $dhImport->id_dh,
							"login" => $dhImport->getLogin(),
							"biais" => "Importation d'un Csv"
						];
						Logger::setNew("Creation de compte", Dh::getCurrent()->id_dh, $id_dh, $params);
				}
				else
				{
					$id_conseiller = Dh::getByLogin($elm['data']['TYPE DE COMPTE'])[0]->id_dh;
					//Code pour ajouter un collaborateur
					$id_dh = Database::prepareInsert('mscpi_db', "INSERT INTO `DONNEUR D'ORDRE` (
						login,
						conseiller,
						type,
						password,
						mdp_tmp,
						confirmation

						) VALUES(
						:mail,
						:conseiller,
						:type,
						:password,
						1,
						1

						);", array(
						":mail" => ft_crypt_information($elm['data']['MAIL']),
						":conseiller" => $id_conseiller,
						":type" => "client",
						":password" => ft_crypt_pass($pass)
						));
					$id_phs = Database::prepareInsert('mscpi_db', "INSERT INTO `PERSONNE PHYSIQUE` (
						civilite,
						nom,
						prenom,
						mail,
						telephone,
						indicatif_telephonique,
						telephone_fixe,
						indicatif_telephonique_fixe,
						lien_dh

						) VALUES(
						:civilite,
						:nom,
						:prenom,
						:mail,
						:telephone,
						:indicatif_telephonique,
						:telephone_fixe,
						:indicatif_telephonique_fixe,
						$id_dh

						);", array(
						":civilite" => ft_crypt_information($elm['data']['CIVILITE']),
						":nom" => ft_crypt_information($elm['data']['NOM']),
						":prenom" => ft_crypt_information($elm['data']['PRENOM']),
						":mail" => ft_crypt_information($elm['data']['MAIL']),
						":telephone" => ft_crypt_information($elm['data']['NUMERO DE TELEPHONE PORTABLE']),
						":telephone_fixe" => ft_crypt_information($elm['data']['NUMERO DE TELEPHONE FIXE']),
						":indicatif_telephonique" => $elm['data']['INDICATIF PAYS'],
						":indicatif_telephonique_fixe" => $elm['data']['INDICATIF PAYS2']
						));
						Database::exec("mscpi_db", "UPDATE `DONNEUR D'ORDRE` SET lien_phy = $id_phs WHERE id_dh = $id_dh");
						$exPp = Dh::getById($id_dh)->getPersonnePhysique();
						$rtArr[] = array(
							"action" => "add",
							"civilite" => $exPp->getCiviliteFormat(),
							"prenom" => $exPp->getFirstName(),
							"nom" => $exPp->getName(),
							"type" => $elm['data']['TYPE DE COMPTE'],
							"login" => $elm['data']['MAIL'],
							"mdp" => $pass
						);

						$dhImport = Dh::getById($id_dh);
						$params = [
							"id" => $dhImport->id_dh,
							"login" => $dhImport->getLogin(),
							"biais" => "Importation d'un Csv"
						];
						Logger::setNew("Creation de compte", Dh::getCurrent()->id_dh, $id_dh, $params);
				}
			}
			else if ($elm['errorFormat']['canUpdate'] && $elm['preSelection'] == "update") {
				echo "Cet element sera mis a jours<br />";
				/*
					on fait un simple update de la bdd.
					Avec un tableau contenant
					les entete du excel en clef et la valeur qui correspond en tableau
					en valeur;
				*/
				$rtArr[] = array(
					"action" => "update",
					"civilite" => $exPp->getCiviliteFormat(),
					"prenom" => $exPp->getFirstName(),
					"nom" => $exPp->getName(),
					"type" => $elm['data']['TYPE DE COMPTE'],
					"login" => $elm['data']['MAIL'],
					"mdp" => "-"
				);
			}
		}
		return ($rtArr);
	}
}
