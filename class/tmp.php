<?php
class ParseCsv
{
	private function __construct() {}
	public static			$_ent = array(
		"CIVILITE",
		"PRENOM",
		"NOM",
		"INDICATIF PAYS",
		"NUMERO DE TELEPHONE PORTABLE",
		"INDICATIF PAYS2",
		"NUMERO DE TELEPHONE FIXE",
		"MAIL",
		"TYPE DE COMPTE"
	);

	public static function getDhCsv() {

	}
	public static function getDhCheck() {
		return  array(
			"CIVILITE" => function($data) {
				if (trim($data) == "M.")
					return "Monsieur";
				else if (trim($data) == "Mme")
					return "Madame";
				return false;
			},
			"PRENOM" => function($data) {
				if (!empty($data))
					return trim($data);
				else
					return (false);
			},
			"NOM" => function($data) {
				if (!empty($data))
					return trim($data);
				else
					return (false);
			},
			"INDICATIF PAYS" => function($data) {
				return trim($data);
			},
			"NUMERO DE TELEPHONE PORTABLE" => function($data) {
				$data = trim($data);
				return $data;
			},
			"INDICATIF PAYS2" => function($data) {
				return trim($data);
			},
			"NUMERO DE TELEPHONE FIXE" => function($data) {
				return trim($data);
			},
			"MAIL" => function($data) {
				$data = trim($data);
				if (filter_var($data, FILTER_VALIDATE_EMAIL))
					return trim($data);
				return false;
			},
			"TYPE DE COMPTE" => function($data) {
				if (in_array(strtolower($data), Dh::$typeDeCompte))
					return trim($data);
				foreach (Dh::getConseillers() as $elm) {
					if ($elm->getLogin() === $data)
						return trim($data);
				}
				return false;
			}
		);
	}
	public static function getDhDataFromBdd() {
		return  array(
			"CIVILITE" => function($dh) {
				$tmp = $dh->getPersonnePhysique()->getCivilite();
				if ($tmp === "Monsieur")
					return ("M.");
				else if ($tmp === "Madame")
					return ("Mme");
			},
			"PRENOM" => function($dh) {
				return $dh->getPersonnePhysique()->getFirstName();
			},
			"NOM" => function($dh) {
				return $dh->getPersonnePhysique()->getName();
			},
			"INDICATIF PAYS" => function($dh) {
				return $dh->getPersonnePhysique()->getIndicatifPhone();
			},
			"NUMERO DE TELEPHONE PORTABLE" => function($dh) {
				return $dh->getPersonnePhysique()->getPhone();
			},
			"INDICATIF PAYS2" => function($dh) {
				return $dh->getPersonnePhysique()->getIndicatifPhoneFixe();
				return "Pas encore inclus";
			},
			"NUMERO DE TELEPHONE FIXE" => function($dh) {
				return $dh->getPersonnePhysique()->getPhoneFixe();
			},
			"MAIL" => function($dh) {
				return $dh->getLogin();
			},
			"TYPE DE COMPTE" => function($dh) {
				if ($dh->getType() === "client")
					return $dh->getConseiller()->getLogin();
				else
					return strtoupper($dh->getType());
			}
		);
	}
	public static function getDhCsvData($filename, $separateur) {
		$check = self::getDhCheck();
		$fd = fopen($filename, "r");
		fgetcsv($fd); // Pour ignorer la ligne qui sert d'information au collaborateurs
		$entete = fgetcsv($fd, 0, $separateur);
		// Check si toutes les collonnes necessaires sont presentes;
		foreach($check as $key => $elm) {
			if(!in_array($key, $entete))
				return false;
		}
		$rt = array("entete" => $entete);
		$i = 0;
		while (($line = fgetcsv($fd, 0, $separateur)) !== FALSE) {
			$rt[$i] = array(
				"data" => null,
				"errorFormat" => null,
				"oldData" => null,
				"preSelection" => "add"
				);
			$rt[$i]["errorFormat"]["canAdd"] = true;
			$rt[$i]['errorFormat']["canUpdate"] = true;
			foreach($line as $key => $elm) {
				if (!in_array($entete[$key], self::$_ent))
					continue ;
				$elm = trim($elm);
				// Check si cheque elements de la ligne courrantes sont valides;
				if (isset($check[$entete[$key]])) {
					if ($entete[$key] === "NUMERO DE TELEPHONE PORTABLE" && !empty($elm)) {
						$elm = trim($elm);
						if (!strstr($elm, "+")) {
							$elm = "+33" . substr($elm, 1);
						}
					}
					//Check du format
					if ($check[$entete[$key]]($elm) === false) {
						$rt[$i]["errorFormat"][$entete[$key]] = true;
						$rt[$i]['errorFormat']["canAdd"] = false;
						$rt[$i]['errorFormat']["canUpdate"] = false;
					}
					$rt[$i]["data"][$entete[$key]] = $elm;
				}
			}
			if (count(Dh::getByLogin($rt[$i]["data"]["MAIL"]))) {
				$rt[$i]["errorFormat"]["alreadyExist"] = true;
				$rt[$i]["errorFormat"]["canAdd"] = false;
				$rt[$i]["preSelection"] = "nothing";
				$rt[$i]["oldData"] = array();
				foreach (self::getDhDataFromBdd() as $key => $elm) {
					$rt[$i]["oldData"][$key] = $elm(Dh::getByLogin($rt[$i]["data"]["MAIL"])[0]);
				}
			}
			else
			{
				$rt[$i]["errorFormat"]["canUpdate"] = false;
			}
			$i++;
		}
		return($rt);
	}
}
