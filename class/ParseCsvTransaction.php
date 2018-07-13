<?php
class ParseCsvTransaction
{
	private function __construct() {}

	public static function getDhCsv() {

	}
	public static function getTransactionCalcul() {
		return  array(
			"Nb parts",
			"Prix Achat / Vente",
			"ID TRANSACTION",
			"Clé répart",
			"Durée si DT"
		);
	}
	public static function getTransactionCheck() {
		return  array(
			"Mail / numéro de téléphone (si email absent)",
			"Type de bénéficiaire",
			"Dénomination sociale",
			"Civilité",
			"NOM",
			"Prénom",
			"Cons",
			"SCPI",
			"État transaction",
			"Date Signature BS",
			"Date enregistrement / Annulation",
			"Nb parts",
			"Prix Achat / Vente",
			"Type de propr",
			"MP / MS",
			"Effectuée par",
			"Commentaire",
			"ID TRANSACTION",
			"Clé répart",
			"Date entrée jouis",
			"Date fin Jouis",
			"Durée si DT",
			"Type transaction",
			"A importer"
		);
	}
	public static function getCheckData($tmp){
//		exit();
			$tmp['idben'] = 0;
			$tmp['errorFormat'] = array(
				"DhNotFound" => false,
				"InvalidParam" => array(),
				"potentialDuplicate" => false,
				"canAdd" => true
			);
			//////// Check de la validite du Dh
			if (empty($tmp['data']['Mail / numéro de téléphone (si email absent)'])
				|| empty($tmp["data"]["ID TRANSACTION"]))
			{
				$tmp['errorFormat']['canAdd'] = false;
				$tmp['errorFormat']['DhNotFound'] = true;
				$tmp['errorFormat']['InvalidParam'][] = "Mail / numéro de téléphone (si email absent)";
				if (empty($tmp["data"]["ID TRANSACTION"]))
				{
					$tmp['errorFormat']['canAdd'] = false;
					$tmp['errorFormat']['DhNotFound'] = true;
					$tmp['errorFormat']['InvalidParam'][] = "ID TRANSACTION";
				}
				return ($tmp);
			}
			if (TRANSACTION::checkMutexTransaction($tmp["data"]["ID TRANSACTION"]))
			{
				$tmp['errorFormat']['canAdd'] = false;
				$tmp['errorFormat']['DhNotFound'] = true;
				$tmp['errorFormat']['InvalidParam'][] = "ID TRANSACTION";
			}
			if (!empty($tmp["data"]["Date entrée jouis"]) &&
				strtolower($tmp["data"]["Date entrée jouis"]) !== "so")
			{
				$date = DateTime::createFromFormat('d/m/y', $tmp["data"]["Date entrée jouis"]);
				if (empty($date))
					$tmp['errorFormat']['InvalidParam'][] = "Date entrée jouis";
				else
					$tmp["data"]["Date entrée jouis"] = $date->format("d/m/y");
			}
			if (!empty($tmp["data"]["Date fin Jouis"]) && strtolower($tmp["data"]["Date fin Jouis"]) !== "so")
			{
				$date = DateTime::createFromFormat('d/m/y', $tmp["data"]["Date fin Jouis"]);
				if (empty($date))
					$tmp['errorFormat']['InvalidParam'][] = "Date fin Jouis";
				else
					$tmp["data"]["Date fin Jouis"] = $date->format("d/m/y");
			}
			$strtmp = strtoupper(trim($tmp["data"]["Type transaction"]));
			if ($strtmp !== "V" && $strtmp !== "A")
			{
				$tmp['errorFormat']['canAdd'] = false;
				$tmp['errorFormat']['InvalidParam'][] = "Type transaction";
			}
			else
				$tmp["data"]["Type transaction"] = $strtmp;
			$dh = Dh::getOneByLogin(strtolower($tmp['data']['Mail / numéro de téléphone (si email absent)']));
			if (empty($dh))
			{
				$tmp['errorFormat']['canAdd'] = false;
				$tmp['errorFormat']['DhNotFound'] = true;
				$tmp['errorFormat']['InvalidParam'][] = "Mail / numéro de téléphone (si email absent)";
				return ($tmp);
			}
			////////// Check Type de beneficiaire
			$tmp['data']["Type de bénéficiaire"] = strtolower($tmp['data']["Type de bénéficiaire"]);
			if ($tmp['data']["Type de bénéficiaire"] != "pp" &&
				/*$tmp['data']["Type de bénéficiaire"] != "couple" &&*/
				$tmp['data']["Type de bénéficiaire"] != "pm"
			)
			{
				$tmp['errorFormat']['canAdd'] = false;
				$tmp['errorFormat']['InvalidParam'][] = "Type de bénéficiaire";
			}
			////////// Check Dénomination Sociale
			if ($tmp['data']["Type de bénéficiaire"] == "pm")
			{
				if (empty(trim($tmp['data']["Dénomination sociale"])))
				{
					$tmp['errorFormat']['canAdd'] = false;
					$tmp['errorFormat']['InvalidParam'][] = "Dénomination sociale";
				}
				$tmp['data']["Dénomination sociale"] = trim($tmp['data']["Dénomination sociale"]);
				$pm = $dh->getPersonneMoraleByDenomination($tmp["data"]["Dénomination sociale"]);
				if (empty($pm)){
					$pm = Pm::insertMini($dh->id_dh, $tmp['data']["Dénomination sociale"]);
					if (empty($pm))
						die("Kernel panic");
					$pm = Pm::getFromId($pm)[0];
				}
				$ben = $pm->getBeneficiaire();
				if (empty($ben))
				{
					$ben = Beneficiaire::insertIsPm($dh->id_dh, $pm->id_pm);
					if (empty($ben))
						die("Kernel panic");
					$ben = Beneficiaire::getFromId($ben);
				}
				$ben = $ben[0];
				$tmp['idben'] = $ben->id_benf;
			}
			///////// Check pp
			else if ($tmp['data']["Type de bénéficiaire"] == "pp")
			{
				if (strlen($tmp['data']["NOM"]) < 2)
				{
					$tmp['errorFormat']['canAdd'] = false;
					$tmp['errorFormat']['InvalidParam'][] = "NOM";
					return ($tmp);
				}
				if (strlen($tmp['data']["Prénom"]) < 2)
				{
					$tmp['errorFormat']['canAdd'] = false;
					$tmp['errorFormat']['InvalidParam'][] = "Prénom";
					return ($tmp);
				}
				// Check Nom, Prenom, Civilite
				// Check si existe deja ???
				if ($tmp['data']["Civilité"] != "M." && $tmp['data']["Civilité"] != "Mme")// existe pas
				{
					$tmp['errorFormat']['canAdd'] = false;
					$tmp['errorFormat']['InvalidParam'][] = "Civilité";
					return ($tmp);
					//Creer le Pp
				}
				$pp = $dh->getPersonnePhysiqueByCNP($tmp['data']["Civilité"],
					$tmp['data']["NOM"], $tmp["data"]["Prénom"]);
				if (empty($pp)) {
					$pp = Pp::insertMini($dh->id_dh, $tmp['data']["Civilité"],
						$tmp["data"]["Prénom"], $tmp['data']["NOM"]);
					if (empty($pp))
						die("Kernel panic");
					$pp = Pp::getFromId($pp)[0];
				}
				// Check si le beneficiaire existe deja ???
				$ben = $pp->getBeneficiaireSeul();
				if (empty($ben)) // existe pas 
				{
					$ben = Beneficiaire::insertIsPp($dh->id_dh, "seul", array($pp->id_phs));
					if (empty($ben)) // existe pas 
						die("Kernel panic");
					$ben = Beneficiaire::getFromId($ben)[0];
					//Creer le Beneficiaire
				}
				else
					$ben = $ben[0];
				$tmp['idben'] = $ben->id_benf;
			}
			if (!filter_var($tmp["data"]["Cons"], FILTER_VALIDATE_EMAIL)
				|| empty(Dh::getConseillerByLogin($tmp["data"]["Cons"])))
			{
				$tmp['errorFormat']['canAdd'] = false;
				$tmp['errorFormat']['InvalidParam'][] = "Cons";
			}
			$scpiName = Scpi::isExists($tmp["data"]["SCPI"]);

			// Vérification des informations concernant les Scpi
			if (empty($scpiName)){
				$tmp['errorFormat']['canAdd'] = false;
				$tmp['errorFormat']['InvalidParam'][] = "SCPI";
			}
			else
				$tmp["data"]["SCPI"] = $scpiName;

			// Vérification des information concernant le status de transaction
							/*
							if (intval($tmp["data"]["État transaction"]) > 6
								|| intval($tmp["data"]["État transaction"]) < 5)
							*/

			$status = new StatusTransaction();
			$rt = $status->setStatusFromStr($tmp["data"]["État transaction"]);
			if (!$rt ||($status->getStatus()[0] != 5 && $status->getStatus()[0] != 6))
			{
				$tmp['errorFormat']['canAdd'] = false;
				$tmp['errorFormat']['InvalidParam'][] = "État transaction";
			}

			// Vérificationcation d'une transaction Achat ou vente !
			if (empty($tmp["data"]["Type transaction"]) || strtolower($tmp["data"]["Type transaction"]) !== "a"){
				$tmp['errorFormat']['canAdd'] = false;
				$tmp['errorFormat']['InvalidParam'][] = "Type transaction";
			}
			if (empty($tmp["data"]["Date Signature BS"])){
				$tmp['errorFormat']['InvalidParam'][] = "Date Signature BS";
			}
			else{
				$date = DateTime::createFromFormat('d/m/y',
					$tmp["data"]["Date Signature BS"]);
				if (empty($date)){
					$tmp['errorFormat']['InvalidParam'][] = "Date Signature BS";
				}
				else
					$tmp["data"]["Date Signature BS"] = $date->format("d/m/y");
			}
			$date = DateTime::createFromFormat('d/m/y',
					$tmp["data"]["Date enregistrement / Annulation"]);
			if (empty($date))
			{
				$tmp['errorFormat']['canAdd'] = false;
				$tmp['errorFormat']['InvalidParam'][] = "Date enregistrement / Annulation";
			}
			else
				$tmp["data"]["Date enregistrement / Annulation"] = $date->format("d/m/y");
			if (intval($tmp["data"]["Nb parts"]) < -1)
			{
				$tmp['errorFormat']['canAdd'] = false;
				$tmp['errorFormat']['InvalidParam'][] = "Nb parts";
			}
			else
				$tmp["data"]["Nb parts"] = intval($tmp["data"]["Nb parts"]);
			if (floatval(preg_replace('/[\x{c2}\x{a0}]/u', "", $tmp["data"]["Prix Achat / Vente"])) < 1)
			{
				$tmp['errorFormat']['canAdd'] = false;
				$tmp['errorFormat']['InvalidParam'][] = "Prix Achat / Vente";
			}
			else
				$tmp["data"]["Prix Achat / Vente"] = floatval(
				str_replace(",", ".", preg_replace('/[\x{c2}\x{a0}]/u', "", $tmp["data"]["Prix Achat / Vente"])));
			$strtmp = strtoupper(trim($tmp["data"]["Type de propr"]));
			if ($strtmp !== "PP" && $strtmp !== "NU" && $strtmp !== "US"){
				$tmp['errorFormat']['canAdd'] = false;
				$tmp['errorFormat']['InvalidParam'][] = "Type de propr";
			}
			else
			{
				$tmp["data"]["Type de propr"] = $strtmp;
				if ($tmp["data"]["Type de propr"] === "PP"){
					$tmp["data"]["Clé répart"] = "100.00 %";
					$tmp["data"]["Durée si DT"] = "0";
				}
				else {
					$tmp["data"]["Durée si DT"] = intval($tmp["data"]["Durée si DT"]);
					if ($tmp["data"]["Durée si DT"] < 0) {
						$tmp['errorFormat']['canAdd'] = false;
						$tmp['errorFormat']['InvalidParam'][] = "Durée si DT";
					}
					$tmp["data"]["Clé répart"] = floatval(
				str_replace(",", ".", preg_replace('/[\x{c2}\x{a0}]/u', "", $tmp["data"]["Clé répart"])));
					if ($tmp["data"]["Clé répart"] > 99 ||
						$tmp["data"]["Clé répart"] < 1){
						$tmp['errorFormat']['canAdd'] = false;
						$tmp['errorFormat']['InvalidParam'][] = "Clé répart";
					}
				}
			}
			$strtmp = strtoupper(trim($tmp["data"]["MP / MS"]));
			if ($strtmp !== "MS" && $strtmp !== "MP")
			{
				$tmp['errorFormat']['canAdd'] = false;
				$tmp['errorFormat']['InvalidParam'][] = "Type de propr";
			}
			else
				$tmp["data"]["MP / MS"] = $strtmp;
		return ($tmp);
	}

	public static function count_value($tab)
	{
		$i = 0;
		if (empty($tab))
			return (0);
		foreach ($tab as $val)
			if (!empty($val))
				$i += 1;
		return ($i);
	}

	public static function getTransactionCsvData($filename, $separateur) {
		$check = self::getTransactionCheck();
		$fd = fopen($filename, "r");
		//fgetcsv($fd); // Pour ignorer la ligne qui sert d'information au collaborateurs
		$entete = NULL;
		while (self::count_value($entete) < count($check))
			$entete = fgetcsv($fd, 0, $separateur);
		//Check si toutes les collonnes necessaires sont presentes;
		foreach($check as $key => $elm) {
			if(!empty($elm) && !in_array($elm, $entete))
			{
				echo "la collone " ,  $elm , " est requise et non presente dans le fichier!";
				exit();
			}
		}
		$rt = array("entete" => $entete);
		$i = 0;
		//On recupere et range toutes les donnees dont on a besoin !
		while (($line = fgetcsv($fd, 0, $separateur)) !== FALSE) {
			$tmp = array();
			$tmp['data'] = array();
			foreach ($line as $key => $elm)
				if (in_array($entete[$key], $check))
					$tmp['data'][$entete[$key]] = trim($elm);
			if (!empty($tmp["data"]["A importer"]) || strtolower($tmp["data"]["A importer"]) == "oui")
				continue;
			$rt[$i] = self::getCheckData($tmp);
			$i += 1;
		}
		return($rt);
	}
}
