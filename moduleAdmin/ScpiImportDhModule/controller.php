<?php
require_once("class/core/ModuleAdmin.php");
class ScpiImportDhModule extends ModuleAdmin
{
	public function getPostData() {
		$entete = array();
		foreach ($_POST as $key => $elm) {
			if (strncmp($key, "1", 1) != 0)
				break ;
			$entete[] = str_replace("_", " ", substr($key, 2));
		}
		$check = ParseCsvTransaction::getTransactionCheck();
		$rt = array();
		$rt["entete"] = $entete;
		$tmp = array();
		foreach ($_POST as $key => $value){
			if (!isset($tmp[intval($key)]["data"]))
				$tmp[intval($key)]["data"] = array();
			$tmp[intval($key)]["data"][str_replace("_", " ", substr($key, strlen(intval($key)) + 1))] = $value;
		}
		$len = count($tmp);
		$i = 0;
		while ($len > $i){
			$rt[$i] = ParseCsvTransaction::getCheckData($tmp[$i]);
			if (empty($rt[$i]['data']['Mail / numéro de téléphone (si email absent)']) &&
				empty($rt[$i]['data']['Type de bénéficiaire']))
				unset($rt[$i]);
			$i++;
		}
		/*
		foreach ($_POST as $key => $elm) {
			if (strncmp($key, $i, strlen($i)) != 0) {
				if ($i >= 0) {
					if (isset($current["data"]["MAIL"]) && count(Dh::getByLogin($current["data"]["MAIL"]))) {
						$current["errorFormat"]["alreadyExist"] = true;
						$current["errorFormat"]["canAdd"] = false;
						if ($current["preSelection"] === null)
							$current["preSelection"] = "nothing";
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
		*/
		return ($rt);
	}

	public static function add_scpi99($POST, $login, $id_bene){
		$_POST = $POST;
		if (strstr($_POST['propriete'], "Usufruit"))
			$_POST['cle'] = 100 - $_POST['cle'];
		$api_scpi = Scpi::getAll();

		// Récupère l'id de la scpi.
		foreach ($api_scpi as $elem)
		{
			if (strtolower($elem->name) == strtolower($_POST["SCPI"]))
				$tmp = $elem->id;
		}

		// Crypte les données qui en ont besoins;
		foreach ($_POST as $key => $value) {
			$_POST[$key] = ft_parse_chr($value);
			if ($key == "prix" || $key == "cle_repartition")
				$_POST[$key] = str_replace(".", ",", $_POST[$key]);
			if ($key !== 'part' && $key !== 'SCPI' && $key !== 'duree' && $key !== "prix" && $key !== "signature_bs" &&
				!empty($_POST[$key]) && $key !== "id_mutex" && $key !== "date_entre_joui" && $key !== "date_fin_joui" &&
				$key !== "status" && $key !== "informations" && $key !== "Type_transaction")
			{
				$_POST[$key] = ft_crypt_information($_POST[$key]);
			}
		}
		if (empty($tmp))
			return (-1);
		$_POST["SCPI"] = $tmp;

			//$status = new StatusTransaction();
		// Crée un status de transaction.
		$status = new StatusTransaction();
		$rt = $status->setStatusFromStr($_POST['status']);
		if (!$rt ||($status->getStatus()[0] != 5 && $status->getStatus()[0] != 6))
			return (-1);
		$bdd = new PDO('mysql:host='. SERVERNAME . ';dbname=mscpi_db;charset=utf8', USERNAME, PASSWORD);

		$res = $bdd->prepare("SELECT * FROM `DONNEUR D'ORDRE` WHERE login = ?");
		$res->execute(array(ft_crypt_information(strtolower($login))));
		$id = $res->fetch()["id_dh"];

		$res = $bdd->prepare("SELECT * FROM `DONNEUR D'ORDRE` WHERE login = ?");
		$res->execute(array($_POST["conseiller"]));
		$id_cons = $res->fetch()["id_dh"];
		$scpi_name = ft_crypt_information(Scpi::getFromId($_POST['SCPI'])->name);
		$query = $bdd->prepare("INSERT INTO `TRANSACTION`(id_donneur_ordre, status_trans, info_trans, enr_date, date_bs, marcher, type_pro, nbr_part, prix_part, id_scpi, Name, dt, cle_repartition, commentaire, id_cons, id_beneficiaire, id_excel, date_entre_joui, date_fin_joui, type_transaction) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
		$_POST['date'] = empty($_POST['prix']) ? 0 : $_POST['date'];
		if (empty($_POST["date_entre_joui"]) || strtolower(trim($_POST["date_entre_joui"])) === "so" || strtolower(trim($_POST["date_entre_joui"])) === "none")
			$_POST['date_entre_joui'] = 0;
		else
			$_POST['date_entre_joui'] = DateTime::createFromFormat('d/m/y', $_POST['date_entre_joui'])->getTimestamp();
		if (empty($_POST["date_fin_joui"]) || strtolower(trim($_POST["date_fin_joui"])) === "so" || strtolower(trim($_POST["date_fin_joui"])) === "none")
			$_POST['date_fin_joui'] = 0;
		else
			$_POST['date_fin_joui'] = DateTime::createFromFormat('d/m/y', $_POST['date_fin_joui'])->getTimestamp();
		if (empty($_POST["signature_bs"]) || strtolower(trim($_POST["signature_bs"])) === "so" || strtolower(trim($_POST["signature_bs"])) === "none")
			$_POST['signature_bs'] = 0;
		else
			$_POST['signature_bs'] = DateTime::createFromFormat('d/m/y', $_POST['signature_bs'])->getTimestamp();
		$query->execute(array($id, $_POST['status'], $_POST['informations'], $_POST['date'], $_POST['signature_bs'], $_POST['marche'], $_POST['propriete'], intval($_POST['part']), floatval(str_replace(",", ".", $_POST['prix'])), intval($_POST['SCPI']), $scpi_name, $_POST['duree'], $_POST['cle'], $_POST["commentaire"], $id_cons, $id_bene, $_POST['id_mutex'], $_POST["date_entre_joui"], $_POST['date_fin_joui'], $_POST['Type_transaction']));

		$id_trans = $bdd->lastInsertId(); ;
		$Trans = Transaction::getFromId($id_trans)[0];

		$Trans->updateOneColumn("fait_par_mscpi", 1);

		$status->setTransaction($Trans);
		$status->insertIt();
		//exit();
		return ($id);
	}

	public function insert($data) {
		$rt = array();
		$tab_id = array();
		foreach ($data as $key => $tab){
			if ($key == "entete")
				continue;
			if (!empty($tab["errorFormat"]) && $tab["data"]["DOING"] == "add")
			{
				$tab_tmp = $tab["data"];
				if (strtolower($tab_tmp["Type de propr"]) == "pp")
					$str = "Pleine propriété";
				elseif (strtolower($tab_tmp["Type de propr"]) == "nu")
					$str = "Nue propriété";
				else
					$str = "Usufruit";
				if (strtolower($tab_tmp["MP / MS"]) == "mp")
					$marche = "Primaire";
				else if (strtolower($tab_tmp["MP / MS"]) == "ms")
					$marche = "Secondaire";
				else
					$marche = "Gris à gris";
				if (strlen($tab_tmp["Date enregistrement / Annulation"]) == 8)
					$tab_tmp["Date enregistrement / Annulation"] = DateTime::createFromFormat("d/m/y", $tab_tmp["Date enregistrement / Annulation"])->format("d/m/Y");
				$tmp = array(
					"Type_transaction" => $tab_tmp['Type transaction'],
					"SCPI" => $tab_tmp["SCPI"],
					"date" => $tab_tmp["Date enregistrement / Annulation"],
					"signature_bs" => $tab_tmp["Date Signature BS"],
					"part" => $tab_tmp["Nb parts"],
					"propriete" => $str,
					"prix" => $tab_tmp["Prix Achat / Vente"],
					"cle" => floatval($tab_tmp['Clé répart']),
					"duree" => intval($tab_tmp["Durée si DT"]),
					"marche" => $marche,
					"status" => $tab_tmp['État transaction'],
					"informations" => $tab_tmp['Effectuée par'],
					"commentaire" => $tab_tmp["Commentaire"],
					"conseiller" => $tab_tmp["Cons"],
					"id_mutex" => $tab_tmp["ID TRANSACTION"],
					"date_entre_joui" => $tab_tmp["Date entrée jouis"],
					"date_fin_joui" => $tab_tmp["Date fin Jouis"]
				);
				$tab_id[] = self::add_scpi99($tmp, $tab_tmp["Mail / numéro de téléphone (si email absent)"], $tab['idben']);
				$rt[] = $tab["data"];
			}
		}
		//foreach (array_unique($tab_id) as $val)
			//Dh::getById($val)->regenerateCacheArrayTable();
		return ($rt);
	}
}
