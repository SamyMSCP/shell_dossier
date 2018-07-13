<?php
require_once("core/Database.php");
require_once("core/Table.php");
require_once("Transaction.php");
require_once("Scpi.php");

class LstTransaction
{
	protected static		$_name = "TRANSACTION";
	protected static		$_db = "mscpi_db";
	private $_data = null;
	private $_partDate = null;
	private $id_scpi;
	private $id_dh;
	private $type_pro;
	private $_String = null;

	public function __construct($id_dh, $id_scpi, $type_pro = null, $isBen = null) {
		$this->id_dh = $id_dh;
		$this->id_scpi = $id_scpi;
		$this->type_pro = $type_pro;
		//if (!empty(strstr(ft_decrypt_crypt_information($this->type_pro), "Usufruit")))
			//$req =  "SELECT * FROM `TRANSACTION` WHERE id_donneur_ordre = :id_dh AND id_scpi = :id_scpi AND type_pro = '" .  . "';";
		//else if(!empty(strstr(ft_decrypt_crypt_information($this->type_pro), "Nue")))
			//;
		//else
		if ($isBen == null)
			$req =  "SELECT * FROM `TRANSACTION` WHERE id_donneur_ordre = :id_dh AND id_scpi = :id_scpi;";
		else
			$req =  "SELECT * FROM `TRANSACTION` WHERE id_beneficiaire = :id_dh AND id_scpi = :id_scpi;";
		$this->_data = Database::prepare(self::$_db, $req, compact("id_dh", "id_scpi"), "Transaction");
		usort($this->_data, array("LstTransaction", "cmpDate"));
	}
	private static function cmpDate($a, $b)
	{
		if (!($a instanceof DateTime) || !($b instanceof DateTime))
			return 0;
		return ($a->getDateTimePriseEffet() > $b->getDateTimePriseEffet());
	}
	public function getData() {
		return ($this->_data);
	}
	public function getFirstDate() {
		$arr = $this->getDatePartArray();
		if (count($arr) === 0)
			return (null);
		return ($arr[0]['date']);
	}
	public function getDatePartArray() {
		$current = 0;
		if ($this->_partDate == null) {
			$this->_partDate = array();
			foreach ($this->_data as $elm) {
				//if ($elm->isBuy()) {
					$current += $elm->nbr_part;
				//} else {
					//$current -= $elm->nbr_part;
				//}
				if ($elm->getEnrDate() == false) {
					continue;
				}
				array_push(
					$this->_partDate,
					array(
						"date" => DateTime::createFromFormat("d/m/Y", "1/" . $elm->getDateTimePriseEffet()->format("m") . "/" . $elm->getDateTimePriseEffet()->format("Y")),
						"nbr_part" => $current
					)
				);
			}
		}
		return ($this->_partDate);
	}
	public function getPartDate($month, $year) {
		$date = DateTime::createFromFormat("d/m/Y", "1/" . $month . "/" . $year);
		$arr = $this->getDatePartArray();
		$old = 0;
		foreach ($arr as $elm) {
			if ($elm["date"] > $date) {
				return $old;
			}
			$old = $elm["nbr_part"];
		}
		return $old;
	}
	public function getPartDateTime($date) {
		$date = DateTime::createFromFormat(
			"d/m/Y",
			"1/" .$date->format("m") . "/" .$date->format("Y")
		);
		$arr = $this->getDatePartArray();
		$old = 0;
		foreach ($arr as $elm) {
			if ($elm["date"] > $date) {
				return $old;
			}
			$old = $elm["nbr_part"];
		}
		return $old;
	}
	public function getScpi() {
		return (Scpi::getFromId($this->id_scpi));
	}
	public function getDh() {
		return (Dh::getById($this->id_dh));
	}
	// Pour une transaciton donnée cette valeur récupère
	//     les dividendes pour une année et un trimeste défini !
	public function getDividendeTrimestreNoValue($trimestre, $year = null) {
		if ($year === null) {
			$year = Date("Y");
			$values = $this->getScpi()->Acompte["data"];
		} else {
			$values = $this->getScpi()->getAcompteYear($year);
		}
		$trim = "T" . ($trimestre + 1);
		if (!isset($values[$trim])) {
			return (0);
		}
		$tmp = 1 + ($trimestre * 3);
		$tmp2 = 1 + ((1 + $trimestre) * 3);
		$T = 0;
		while ($tmp < $tmp2) {
			$T += $this->getPartDate($tmp, $year);
			$tmp++;
		}
		return ($T / 3) * $values[$trim];
	}
	public function getDividendeTrimestre($values, $trimestre, $year) {
		$trim = "T" . ($trimestre + 1);
		if (!isset($values[$trim])) {
			return (0);
		}
		$tmp = 1 + ($trimestre * 3);
		$tmp2 = 1 + ((1 + $trimestre) * 3);
		$T = 0;
		while ($tmp < $tmp2) {
			$T += $this->getPartDate($tmp, $year);
			$tmp++;
		}
		return ($T / 3) * $values[$trim];
	}
	public function getDividende($year = null) {
		if ($year === null) {
			$year = Date("Y");
			$values = $this->getScpi()->Acompte["data"];
		} else {
			$values = $this->getScpi()->getAcompteYear($year);
		}
		$rt = 0;
		for ($i = 0; $i < 4; $i++) {
			$rt += $this->getDividendeTrimestre($values, $i, $year);
		}
		return ($rt);
	}
	public function __toString() {
		if ($this->_String === null) {
			$this->_String = $this->getScpi()->name . " : " . number_format($this->getDividende(), 1, ",", "") . " €";
		}
		return ($this->_String);
	}
	public function show() {
		echo "=============LISTE_TRANSACTION===========<br />";
		$arr = $this->getDatePartArray();
		echo "nom scpi : " . $this->getScpi()->name . "<br />";
		echo "login donneur d'ordre: " . ft_decrypt_crypt_information(Dh::getById($this->id_dh)->login) . "<br />";
		echo "<br />";
		if (count($arr) == 0)
			return ;

		foreach ($this->_data as $elm) {
			if ($elm->getEnrDate() == false)
				continue;
			echo ($elm->getEnrDate()->format("d/m/Y") . (($elm->isBuy()) ? " achat de " :  " vente de ") . $elm->nbr_part . " parts. Prend effet : " . $elm->getDateTimePriseEffet()->format("d/m/Y") . "<br />") ;
		}
	}
	public static function forGeneracteCache($lst) {
		$rt = array();
		foreach ($lst as $elm) {
			$pleine = array();
			$nue = array();
			$usu = array();
			foreach ($elm->getData() as $data) {
				$sup = $data->getStatusTransactionObject();
				if ($data->doByMscpi() && ($sup->getStatus()[0] < 5 || $sup->getStatus()[0] > 6))
					continue ;
				$data->setDebutFinValorisationDividendes();
				$data->actualDividendes = $elm;
				if ($data->getTypeTransaction() != 'V') {
					if ($data->getTypePro() === "Pleine propriété") {
						$pleine[$data->id] = array("buy" => $data);
					} else if ($data->getTypePro() === "Nue propriété") {
						$nue[$data->id] = array("buy" => $data);
					} else if ($data->getTypePro() === "Usufruit") {
						$usu[$data->id] = array("buy" => $data);
					}
				}
			}
			foreach ($elm->getData() as $data) {
				$sup = $data->getStatusTransactionObject();
				if ($data->doByMscpi() && ($sup->getStatus()[0] < 5 || $sup->getStatus()[0] > 6))
					continue ;
				if ($data->getTypeTransaction() == 'V') {
					if ($data->getTypePro() === "Pleine propriété")
						$pleine[$data->id_transaction_achat]["sell"][] = $data;
					else if ($data->getTypePro() === "Nue propriété")
						$nue[$data->id_transaction_achat]["sell"][] = $data;
					else if ($data->getTypePro() === "Usufruit")
						$usu[$data->id_transaction_achat]["sell"][] = $data;
				}
			}
			if (count($pleine) != 0) {
				$rt[$elm->getScpi()->name]["Pleine"] = $pleine;
			}
			if (count($nue) != 0) {
				$rt[$elm->getScpi()->name]["Nue"] = $nue;
			}
			if (count($usu) != 0) {
				$rt[$elm->getScpi()->name]["Usu"] = $usu;
			}
		}
		$precalculTotal = array(
			"MontantInvestissement" => 0,
			"MontantInvestissementMscpi" => 0,
			"MontantInvestissementOther" => 0,
			"ventePotentielleMscpi" => 0,
			"ventePotentielleOther" => 0,
			"flagMissingInfo" => false,
			"ventePotentielle" => 0,
			"pourcentageFiscale" => 0,
			"pourcentageRendement" => 0,
			"MontantInvestissementPleine" => 0,
			"MontantInvestissementUsu" => 0,
			"MontantInvestissementNue" => 0,
			"ventePotentiellePleine" => 0,
			"ventePotentielleUsu" => 0,
			"ventePotentielleNue" => 0,
			"ventePotentiellePourTof" => null,
			"flagMissingInfoPleine" => false,
			"flagMissingInfoNue" => false,
			"flagMissingInfoUsu" => false,
			"havePleine" => false,
			"haveUsu" => false,
			"haveNue" => false,
			"Tof" => 0,
			"nbr_part" => 0,
			"haveDoByMscpi" => false,
			"haveDoByOther" => false,
			"lastDividendesTrimestre" => array(
				"T1" => 0,
				"T2" => 0,
				"T3" => 0,
				"T4" => 0
			),
			"lastDividendes" => 0,
			"actualDividendesTrimestre" => array(
				"T1" => 0,
				"T2" => 0,
				"T3" => 0,
				"T4" => 0
			),
			"actualDividendes" => 0,
			"scpiList" => [],
			"scpiListId" => [],
			"valeur_isf" => 0,
			"valeur_ifi_2018" => 0,
			"valeur_ifi_expatrie_2018" => 0,
			"nbr_part_isf" => 0,
			"pourAgeMoyenScpi" => 0,
			"ageMoyenScpi" => 0
		);
		foreach ($rt as $key => $elm1) { // Separation par nom de SCPI
			$precalculSCPI = array(
				"lastDividendesTrimestre" => array(
					"T1" => 0,
					"T2" => 0,
					"T3" => 0,
					"T4" => 0
				),
				"actualDividendesTrimestre" => array(
					"T1" => 0,
					"T2" => 0,
					"T3" => 0,
					"T4" => 0
				),
				"nbr_part" => 0,
				"prix_achat" => 0,
				"scpi" => null,
				"id_scpi" => null,
				"name_scpi" => null,
				"type_pro" => null,
				"flagMissingInfo" => false,
				"actualDividendes" => 0,
				"lastDividendes" => 0,
				"MontantInvestissement" => 0,
				"ventePotentielle" => null,
				"MontantInvestissementPleine" => 0,
				"MontantInvestissementUsu" => 0,
				"MontantInvestissementNue" => 0,
				"ventePotentiellePleine" => 0,
				"ventePotentielleUsu" => 0,
				"ventePotentielleNue" => 0,
				"flagMissingInfoPleine" => false,
				"flagMissingInfoNue" => false,
				"flagMissingInfoUsu" => false,
				"plusMoinValuePourcent" => null,
				"plusMoinValueEuro" => null,
				"plusMoinValuePourcentPleine" => null,
				"plusMoinValueEuroPleine" => null,
				"plusMoinValuePourcentNue" => null,
				"plusMoinValueEuroNue" => null,
				"haveDoByMscpi" => false,
				"haveDoByOther" => false,
				"Tof" => 0,
				"valeur_isf" => 0,
				"valeur_ifi_2018" => 0,
				"valeur_ifi_expatrie_2018" => 0,
				"nbr_part_isf" => 0,
				"pourAgeMoyenScpi" => 0,
				"vPMscpi" => 0,
				"vPOther" => 0
			);
			foreach ($elm1 as $key2 => $elm2) { // Separation par Type de propriete
				$precalculType = array(
						"lastDividendesTrimestre" => array(
							"T1" => 0,
							"T2" => 0,
							"T3" => 0,
							"T4" => 0
						),
						"lastDividendes" => 0,
						"actualDividendesTrimestre" => array(
							"T1" => 0,
							"T2" => 0,
							"T3" => 0,
							"T4" => 0
						),
						"actualDividendes" => 0,
						"nbr_part" => 0,
						"prix_achat" => 0,
						"scpi" => null,
						"id_scpi" => null,
						"name_scpi" => null,
						"type_pro" => null,
						"MoyennePrixPart" => 0,
						"MoyenneCleRepartition" => 0,
						"MontantInvestissement" => 0,
						"ventePotentielle" => 0,
						"flagMissingInfo" => false,
						"prix_actuel" => 0,
						"plusMoinValuePourcent" => 0,
						"nbr_transaction" => 0,
						"haveDoByMscpi" => false,
						"haveDoByOther" => false,
						"plusMoinValueEuro" => 0,
						"valeur_isf" => 0,
						"valeur_ifi_2018" => 0,
						"valeur_ifi_expatrie_2018" => 0,
						"nbr_part_isf" => 0
					);
				$MoyenneCleRepartitionX = 0;
				$MoyenneCleRepartitionY = 0;
				foreach ($elm2 as $key3 => $elm3) { // Separation par l'id de la transaction d'achat qui suit
					if (!isset($elm3['buy']))
					{
						//continue ;
						exit();
					}
					$precalcul = array(
							"MontantInvestissement" => 0,
							"nbr_part" => 0,
							"doByMscpi" => false,
							"doByOther" => false,
							"prix_achat" => $elm3['buy']->prix_part,
							"flagMissingInfo" => false,
							"prix_actuel" => 0,
							"valeur_isf" => 0,
							"valeur_ifi_2018" => 0,
							"valeur_ifi_expatrie_2018" => 0,
							"plusMoinValuePourcent" => 0,
							"plusMoinValueEuro" => 0,
							"nbr_part_isf" => 0
						);

					// Creation de la liste de toutes les Scpi du portefeuille si besoin
					if (!in_array($elm3['buy']->getScpi()->name, $precalculTotal['scpiList']))
						$precalculTotal['scpiList'][] = $elm3['buy']->getScpi()->name;
					if (!in_array($elm3['buy']->getScpi()->id, $precalculTotal['scpiListId']))
						$precalculTotal['scpiListId'][] = $elm3['buy']->getScpi()->id;


					// Calcul de la valorisation actuelle en fonction du type de propriété pour Une part

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
					/*
					if (strstr($elm3["buy"]->getTypePro(), "Usu")) {
						//$precalcul["prix_achat"] = $elm3['buy']->getUsufruit();
						$precalcul["prix_actuel"] = $elm3['buy']->getUsufruit();
					} elseif (strstr($elm3["buy"]->getTypePro(), "Nue")) {
						$precalcul["prix_actuel"] = $elm3['buy']->getNuePropriete();
					} else {
						$precalcul["prix_actuel"] = $elm3['buy']->getScpi()->getActualValue();
					}
					*/
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
					$precalcul["prix_actuel"] = $elm3['buy']->getValorisationOnePartAtTimestamp(today());

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////



					// Récupération des informations générales concernant la Scpi en precalcul
					$precalculSCPI['scpi'] = $elm3['buy']->getScpi();
					$precalculSCPI['id_scpi'] = $elm3['buy']->getScpi()->id;
					$precalculSCPI['name'] = $elm3['buy']->getScpi()->name;
					$precalculSCPI['type_pro'] = $elm3['buy']->getTypePro();
					$precalculType['scpi'] = $elm3['buy']->getScpi();
					$precalculType['id_scpi'] = $elm3['buy']->getScpi()->id;
					$precalculType['name'] = $elm3['buy']->getScpi()->name;
					$precalculType['type_pro'] = $elm3['buy']->getTypePro();

					// Recupération des dividendes courante et précédentes pour cette Scpi
					//$precalculSCPI['actualDividendes'] = $elm3['buy']->actualDividendes->getDividende(date("Y"));
					//$precalculSCPI['lastDividendes'] = $elm3['buy']->actualDividendes->getDividende(date("Y") - 1);
				
					// Récupération des dividendes précédentes pour ce type de propriété.
			//		$precalculType['lastDividendes'] = $elm3['buy']->actualDividendes->getDividendeTrimestreNoValue(0, date("Y") - 1);

					// Génération de l'information (Fait par Mscpi ou non)
					if ($elm3['buy']->doByMscpi()) {
						$precalcul['doByMscpi'] = true;
						$precalculType['haveDoByMscpi'] = true;
						$precalculSCPI['haveDoByMscpi'] = true;
						$precalculTotal['haveDoByMscpi'] = true;
					} else {
						$precalcul['doByOther'] = true;
						$precalculType['haveDoByOther'] = true;
						$precalculSCPI['haveDoByOther'] = true;
						$precalculTotal['haveDoByOther'] = true;
					}

					//Récupération du nombre de parts pour le calcul de l'ensemble (Ancienne version);
					$precalcul['nbr_part'] = $elm3['buy']->getNbrPart();

					// Demamde de Precalculer l'Usufruit et la NuePropriété (Ancienne version);
					$elm3["buy"]->precalcul();


					//Nouvelle version calcu Dividendes
					$precalcul['actualDividendes'] = $elm3['buy']->getDividendeYear(date("Y"));
					$precalcul['lastDividendes'] = $elm3['buy']->getDividendeYear(date("Y") - 1);

					$precalcul['actualDividendesTrimestre']['T1'] = $elm3['buy']->getDividendeYearT(date("Y"), 1);
					$precalcul['actualDividendesTrimestre']['T2'] = $elm3['buy']->getDividendeYearT(date("Y"), 2);
					$precalcul['actualDividendesTrimestre']['T3'] = $elm3['buy']->getDividendeYearT(date("Y"), 3);
					$precalcul['actualDividendesTrimestre']['T4'] = $elm3['buy']->getDividendeYearT(date("Y"), 4);

					$precalcul['lastDividendesTrimestre']['T1'] = $elm3['buy']->getDividendeYearT(date("Y") - 1, 1);
					$precalcul['lastDividendesTrimestre']['T2'] = $elm3['buy']->getDividendeYearT(date("Y") - 1, 2);
					$precalcul['lastDividendesTrimestre']['T3'] = $elm3['buy']->getDividendeYearT(date("Y") - 1, 3);
					$precalcul['lastDividendesTrimestre']['T4'] = $elm3['buy']->getDividendeYearT(date("Y") - 1, 4);

					$precalculType['actualDividendes'] += $precalcul['actualDividendes'];
					$precalculType['actualDividendesTrimestre']['T1'] += $precalcul['actualDividendesTrimestre']['T1'];
					$precalculType['actualDividendesTrimestre']['T2'] += $precalcul['actualDividendesTrimestre']['T2'];
					$precalculType['actualDividendesTrimestre']['T3'] += $precalcul['actualDividendesTrimestre']['T3'];
					$precalculType['actualDividendesTrimestre']['T4'] += $precalcul['actualDividendesTrimestre']['T4'];
					$precalculType['lastDividendes'] += $precalcul['lastDividendes'];
					$precalculType['lastDividendesTrimestre']['T1'] += $precalcul['lastDividendesTrimestre']['T1'];
					$precalculType['lastDividendesTrimestre']['T2'] += $precalcul['lastDividendesTrimestre']['T2'];
					$precalculType['lastDividendesTrimestre']['T3'] += $precalcul['lastDividendesTrimestre']['T3'];
					$precalculType['lastDividendesTrimestre']['T4'] += $precalcul['lastDividendesTrimestre']['T4'];



					//Récupération de l'information qu'il manque des informations pour cette transaction / Type Pro / Scpi
					if (empty($elm3['buy']->getEnrDate()) || $elm3['buy']->prix_part == 0) {
						$precalculTotal['flagMissingInfo'] = true;
						$precalculSCPI['flagMissingInfo'] = true;
						$precalculType['flagMissingInfo'] = true;
						$precalcul['flagMissingInfo'] = true;
						if (strstr($precalculType["type_pro"], "Usu")){
							$precalculTotal['flagMissingInfoUsu'] = true;
							$precalculSCPI['flagMissingInfoUsu'] = true;
						} else if (strstr($precalculType['type_pro'], "Nue")) {
							$precalculTotal['flagMissingInfoNue'] = true;
							$precalculSCPI['flagMissingInfoNue'] = true;
						} else {
							$precalculTotal['flagMissingInfoPleine'] = true;
							$precalculSCPI['flagMissingInfoPleine'] = true;
						}
					}

					// Récupération de l'information qu'il y a de l'Usufruit, de la Nue pro ou Pleine pro pour le total
					if (strstr($precalculType["type_pro"], "Usu")){
						$precalculTotal['haveUsu'] = true;
					} else if (strstr($precalculType['type_pro'], "Nue")) {
						$precalculTotal['haveNue'] = true;
					} else {
						$precalculTotal['havePleine'] = true;
					}

					// Pour le comptage du nombre de transaction dans cette scpi et type pro.
					$precalculType['nbr_transaction'] += 1;


///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
					// Precalcul de la vente potentielle pour cette transaction en fonction du type de propriété
					//if (strstr($elm3["buy"]->getTypePro(), 'Nue'))
						//$precalculType['ventePotentielle'] += $precalcul['nbr_part'] * $elm3["buy"]->getNuePropriete();
					//else
						//$precalculType['ventePotentielle'] += $elm3["buy"]->getUsufruit() * $elm3["buy"]->getNbrPart();
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
				//	$precalculType['ventePotentielle'] += $elm3["buy"]->getValorisationAtTimestamp(time());
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

					// Calcul du montant d'investissement en fonction de la clef de repartition;
					$precalculType['MontantInvestissement'] += $elm3['buy']->getNbrPart() * $precalcul["prix_achat"] * $elm3["buy"]->getClefRepartition() / 100;

					// Pour chaque transaction de vente associées :
					//     on retire de nombre de parts
					//     on calcule le montant de vente de celle ci
					//     on calcul les données associées (+/- value % et euros)
					$nbr_part_isf = $elm3['buy']->getNbrPart();
					$datetime = DateTime::createFromFormat("d/m/Y", "1/1/" . Date("Y"));
					if (isset($elm3['sell']))
					{
						foreach ($elm3['sell'] as $key4 => $elm4) {
							$date = $elm4->getEnrDate();
							if ($elm3['buy']->isPleinePro() && $date instanceof DateTime && $date->setTime(0,0,0) < $datetime)
								$nbr_part_isf -= $elm4->getNbrPart();
							$elm4->precalcul();
							$precalcul['nbr_part'] -= $elm4->getNbrPart();
							$precalculType['nbr_transaction'] += 1;
							$rt[$key][$key2][$key3]['sell'][$key4]->MontantRevente = $elm4->prix_part_vente * $elm4->nbr_part_vente;
							if (!empty($elm3['buy']->prix_part))
							{
								$rt[$key][$key2][$key3]['sell'][$key4]->plusMoinValuePourcent = (100 * ($elm4->prix_part_vente / ($elm3['buy']->prix_part))) - 100;
								$rt[$key][$key2][$key3]['sell'][$key4]->plusMoinValueEuro = $elm4->prix_part_vente - $elm3['buy']->prix_part;
							}
							else
							{
								$rt[$key][$key2][$key3]['sell'][$key4]->plusMoinValuePourcent =0;
								$rt[$key][$key2][$key3]['sell'][$key4]->plusMoinValueEuro = 0;
							}
						}
					}
					//En plus des pleines pro on ajoute au calcul ISF  les parts de nue-propriete dont le demembrement est terminé
					if ($elm3['buy']->getPatrimoineAtTimestamp($datetime->getTimestamp()) !== false)
					{
						$precalcul['nbr_part_isf'] = $nbr_part_isf;
						$precalcul['valeur_isf'] = $precalcul['nbr_part_isf'] * $elm3['buy']->getScpi()->getValeurIsf();
						$val = $elm3['buy']->getScpi()->getValeurIfi2018();
						if ($val !== null)
							$precalcul['valeur_ifi_2018'] = $precalcul['nbr_part_isf'] * $val;
						else
							$precalcul['valeur_ifi_2018'] = null;

						$val = $elm3['buy']->getScpi()->getValeurIfiExpatrie2018();
						if ($val !== null)
							$precalcul['valeur_ifi_expatrie_2018'] = $precalcul['nbr_part_isf'] * $val;
						else 
							$precalcul['valeur_ifi_expatrie_2018'] = null;


						$precalculType['valeur_isf'] += $precalcul['valeur_isf'];
						$precalculType['valeur_ifi_2018'] += $precalcul['valeur_ifi_2018'];
						$precalculType['valeur_ifi_expatrie_2018'] += $precalcul['valeur_ifi_expatrie_2018'];
						$precalculType['nbr_part_isf'] += $precalcul['nbr_part_isf'];
					}

					$precalcul['MontantInvestissement'] = $precalcul['nbr_part'] * $precalcul['prix_achat'];
					$precalcul['ventePotentielle'] = $precalcul['nbr_part'] * $elm3["buy"]->getValorisationOnePartAtTimestamp(today());
					//echo (new DateTime)->setTimestamp(time())->format('d/m/Y') . " : ";
					//echo $elm3['buy']->getNbrPartsForValorisationAtTimestamp(time()) . " : ";
					//echo $precalcul['ventePotentielle'] . "<br />";

					$precalculType['ventePotentielle'] += $precalcul['ventePotentielle'];
					// on calcul la valorisation/ (+/- value) de ce groupe de parts en fonction du type de propriété !


					// On remonte le nombre de parts et on prepare la moyenne de prix de parts
					$precalculType['nbr_part'] += $precalcul['nbr_part'];
					$precalculType['MoyennePrixPart'] += $precalcul['prix_achat'] * $precalcul['nbr_part'];

					// on calcul le montant d'investissement en fonction du nombre de parts restant dans ce groupe !
					$tmpInvestissement = $precalcul['prix_achat'] * $precalcul['nbr_part'];
					if (strstr($elm3["buy"]->getTypePro(), 'Nue'))
					{
						$tmpInvestissement *= $elm3["buy"]->getClefRepartition() / 100;
					}
					else if (strstr($elm3["buy"]->getTypePro(), 'Usu'))
					{
						$tmpInvestissement *= (100 - $elm3["buy"]->getClefRepartition()) / 100;
					}
					if (!empty($precalcul['prix_achat']) && !empty($precalcul['nbr_part']) && !empty($tmpInvestissement))
					{
						$precalcul['plusMoinValuePourcent'] = (($precalcul['ventePotentielle'] / $tmpInvestissement) - 1) * 100;
						$precalcul['plusMoinValueEuro'] = $precalcul['ventePotentielle'] - $tmpInvestissement;
					}
					// On calcule le montant d'investissement fait avec Meilleurescpi.com ou les autres.
					if ($precalcul['doByMscpi'])
					{
						$precalculTotal['MontantInvestissementMscpi'] += $tmpInvestissement;
						$precalculTotal['ventePotentielleMscpi'] += $precalcul['ventePotentielle'];
						$precalculSCPI["vPMscpi"] += $precalcul['ventePotentielle'];
					}
					else
					{
						$precalculTotal['MontantInvestissementOther'] += $tmpInvestissement;
						$precalculTotal['ventePotentielleOther'] += $precalcul['ventePotentielle'];
						$precalculSCPI["vPOther"] += $precalcul['ventePotentielle'];
					}

					$rt[$key][$key2][$key3]["precalcul"] = $precalcul;
/*
					if (strstr($elm3["buy"]->getTypePro(), 'Nue'))
					{
						if ($precalcul['prix_achat'] != 0 && $precalcul['nbr_part'] != 0)
						{
							//$precalcul['plusMoinValuePourcent'] = 100 * ($elm3["buy"]->getNuePropriete() / ($precalcul['prix_achat'] * $elm3["buy"]->getClefRepartition() / 100)) - 100;
							//$precalcul['plusMoinValueEuro'] = ($elm3["buy"]->getNuePropriete() * $precalcul['nbr_part']) - ($precalcul['prix_achat'] * $precalcul['nbr_part'] * ($elm3["buy"]->getClefRepartition() / 100));
							$precalcul['plusMoinValueEuro'] = $precalcul['ventePotentielle'] - $precalcul['MontantInvestissement'];
						} 
						else 
						{
							$precalcul['plusMoinValuePourcent'] = "-";
							$precalcul['plusMoinValueEuro'] = "-";
						}
					}
					else
					{
						if ($precalcul['prix_achat'] != 0 && $precalcul['nbr_part'] != 0) {
							$precalcul['plusMoinValuePourcent'] = 100 * ($precalcul['prix_actuel'] / $precalcul['prix_achat']) - 100;
							$precalcul['plusMoinValueEuro'] = $precalcul['ventePotentielle'] - ($precalcul['prix_achat'] * $precalcul['nbr_part']);
						} else {
							$precalcul['plusMoinValuePourcent'] = "-";
							$precalcul['plusMoinValueEuro'] = "-";
						}
					}
					*/




					// Calcul de la moyenne Cle repartition ??????????????????????
					if (!strstr($elm3['buy']->getTypePro(), "Pleine")) {
						$MoyenneCleRepartitionX += $elm3['buy']->getClefRepartition() * $elm3['buy']->prix_part * $precalcul['nbr_part'];
						$MoyenneCleRepartitionY += $elm3['buy']->prix_part * $precalcul['nbr_part'];
					}
				}
				// On trie les transaction en fonction de si il leur manque des infos et par la date;
				uasort($rt[$key][$key2], function ($a, $b) {
					if ($a['precalcul']['flagMissingInfo']) {
						return false;
					}
					if ($b['precalcul']['flagMissingInfo']) {
						return true;
					}
					return ($a['buy']->getEnrDate() > $b['buy']->getEnrDate());
				});


				$precalculSCPI['actualDividendes'] += $precalculType['actualDividendes'];
				$precalculSCPI['actualDividendesTrimestre']['T1'] += $precalculType['actualDividendesTrimestre']['T1'];
				$precalculSCPI['actualDividendesTrimestre']['T2'] += $precalculType['actualDividendesTrimestre']['T2'];
				$precalculSCPI['actualDividendesTrimestre']['T3'] += $precalculType['actualDividendesTrimestre']['T3'];
				$precalculSCPI['actualDividendesTrimestre']['T4'] += $precalculType['actualDividendesTrimestre']['T4'];

				$precalculSCPI['lastDividendes'] += $precalculType['lastDividendes'];
				$precalculSCPI['lastDividendesTrimestre']['T1'] += $precalculType['lastDividendesTrimestre']['T1'];
				$precalculSCPI['lastDividendesTrimestre']['T2'] += $precalculType['lastDividendesTrimestre']['T2'];
				$precalculSCPI['lastDividendesTrimestre']['T3'] += $precalculType['lastDividendesTrimestre']['T3'];
				$precalculSCPI['lastDividendesTrimestre']['T4'] += $precalculType['lastDividendesTrimestre']['T4'];
				// Utile pour le front 
				$precalculType["modal_link"] = 'modal_' . $key2 . '_' .  str_replace(array(' ', '"', "'"), '_' , $key);

				// On remonte l'info du prix actuelle 
				$precalculType['prix_actuel'] = $precalcul['prix_actuel'];

				// Si on a des parts on calcul le moyenne du prix de la part
				if ($precalculType['nbr_part'] != 0)
					$precalculType['MoyennePrixPart'] /= $precalculType['nbr_part'];
				else
					$precalculType['MoyennePrixPart'] = 0;

				// À quoi ca sert de calculer la moyenne des clefs de repartition ??
				if (strstr($precalculType["type_pro"], "Usu") && $MoyenneCleRepartitionY){
					$precalculType['MoyenneCleRepartition'] = $MoyenneCleRepartitionX / $MoyenneCleRepartitionY;
					$precalculSCPI['MontantInvestissementUsu'] += $precalculType['MontantInvestissement'];
					$precalculSCPI['ventePotentielleUsu'] += $precalculType['ventePotentielle'];
					if ($precalculType['MoyennePrixPart'] != 0) {
						$precalculType['plusMoinValuePourcent'] = 100 * ($precalculType['ventePotentielle'] / $precalculType['MontantInvestissement']) - 100;
						$precalculType['plusMoinValueEuro'] = $precalculType['ventePotentielle'] - $precalculType['MontantInvestissement'];
					}
				} else if (strstr($precalculType['type_pro'], "Nue") && $MoyenneCleRepartitionY) {
					$precalculType['MoyenneCleRepartition'] = $MoyenneCleRepartitionX / $MoyenneCleRepartitionY;
					$precalculSCPI['MontantInvestissementNue'] += $precalculType['MontantInvestissement'];
					$precalculSCPI['ventePotentielleNue'] += $precalculType['ventePotentielle'];
					if ($precalculType['MoyennePrixPart'] != 0) {
						$precalculType['plusMoinValuePourcent'] = 100 * ($precalculType['ventePotentielle'] / ( $precalculType['MoyennePrixPart'] * ($precalculType['MoyenneCleRepartition'] / 100) * $precalculType['nbr_part'])) - 100;
						$precalculType['plusMoinValueEuro'] = $precalculType['ventePotentielle'] - ( $precalculType['MoyennePrixPart'] * ($precalculType['MoyenneCleRepartition'] / 100) * $precalculType['nbr_part']);
					}
				} else {
					$precalculType['MontantInvestissement'] = $precalculType['MoyennePrixPart'] * $precalculType['nbr_part'];
					//$precalculType['ventePotentielle'] = $precalculType['nbr_part'] * $precalculType['prix_actuel'];
					$precalculSCPI['MontantInvestissementPleine'] += $precalculType['MontantInvestissement'];
					$precalculSCPI['ventePotentiellePleine'] += $precalculType['ventePotentielle'];
					if ($precalculType['MoyennePrixPart'] != 0) {
						$precalculType['plusMoinValuePourcent'] = (100 * ($precalculType['prix_actuel'] / $precalculType['MoyennePrixPart'])) - 100;
						$precalculType['plusMoinValueEuro'] = $precalculType['ventePotentielle'] - $precalculType['MontantInvestissement'];
					}
				}
				$precalculSCPI['valeur_isf'] += $precalculType['valeur_isf'];
				$precalculSCPI['valeur_ifi_2018'] += $precalculType['valeur_ifi_2018'];
				$precalculSCPI['valeur_ifi_expatrie_2018'] += $precalculType['valeur_ifi_expatrie_2018'];
				$precalculSCPI['nbr_part_isf'] += $precalculType['nbr_part_isf'];
				$precalculSCPI['nbr_part'] += $precalculType['nbr_part'];
				$precalculSCPI['ventePotentielle'] += $precalculType['ventePotentielle'];
				$precalculSCPI['MontantInvestissement'] += $precalculType['MontantInvestissement'];
				$rt[$key][$key2]["precalcul"] = $precalculType;
				$precalculSCPI['pourAgeMoyenScpi'] += $precalculSCPI['scpi']->getAge() * $precalculSCPI['ventePotentielle'];
			}
			$precalculTotal['pourAgeMoyenScpi'] += $precalculSCPI['pourAgeMoyenScpi'];

			// On remonte les différentes données calculées au total;
			$precalculTotal['valeur_isf'] += $precalculSCPI['valeur_isf'];
			$precalculTotal['valeur_ifi_2018'] += $precalculSCPI['valeur_ifi_2018'];
			$precalculTotal['valeur_ifi_expatrie_2018'] += $precalculSCPI['valeur_ifi_expatrie_2018'];
			$precalculTotal['nbr_part_isf'] += $precalculSCPI['nbr_part_isf'];
			$precalculTotal['nbr_part'] += $precalculSCPI['nbr_part'];
			$precalculTotal['ventePotentielle'] += $precalculSCPI['ventePotentielle'];
			$precalculTotal['MontantInvestissement'] += $precalculSCPI['MontantInvestissement'];
			$precalculTotal['MontantInvestissementUsu'] += $precalculSCPI['MontantInvestissementUsu'];
			$precalculTotal['ventePotentielleUsu'] += $precalculSCPI['ventePotentielleUsu'];
			$precalculTotal['MontantInvestissementNue'] += $precalculSCPI['MontantInvestissementNue'];
			$precalculTotal['ventePotentielleNue'] += $precalculSCPI['ventePotentielleNue'];
			$precalculTotal['MontantInvestissementPleine'] += $precalculSCPI['MontantInvestissementPleine'];
			$precalculTotal['ventePotentiellePleine'] += $precalculSCPI['ventePotentiellePleine'];
			if ($precalculSCPI['scpi']->type_id == 6)
				$precalculTotal['pourcentageFiscale'] += $precalculSCPI['nbr_part'];
			else if ($precalculSCPI['scpi']->type_id == 5)
				$precalculTotal['pourcentageRendement'] += $precalculSCPI['nbr_part'];

			$precalculTotal['actualDividendes'] += $precalculSCPI['actualDividendes'];
			$precalculTotal['actualDividendesTrimestre']['T1'] += $precalculSCPI['actualDividendesTrimestre']['T1'];
			$precalculTotal['actualDividendesTrimestre']['T2'] += $precalculSCPI['actualDividendesTrimestre']['T2'];
			$precalculTotal['actualDividendesTrimestre']['T3'] += $precalculSCPI['actualDividendesTrimestre']['T3'];
			$precalculTotal['actualDividendesTrimestre']['T4'] += $precalculSCPI['actualDividendesTrimestre']['T4'];

			$precalculTotal['lastDividendes'] += $precalculSCPI['lastDividendes'];
			$precalculTotal['lastDividendesTrimestre']['T1'] += $precalculSCPI['lastDividendesTrimestre']['T1'];
			$precalculTotal['lastDividendesTrimestre']['T2'] += $precalculSCPI['lastDividendesTrimestre']['T2'];
			$precalculTotal['lastDividendesTrimestre']['T3'] += $precalculSCPI['lastDividendesTrimestre']['T3'];
			$precalculTotal['lastDividendesTrimestre']['T4'] += $precalculSCPI['lastDividendesTrimestre']['T4'];

			$precalculSCPI['Tof'] = $precalculSCPI['ventePotentielle'] * floatval($precalculSCPI['scpi']->getTof());
			$rt[$key]["precalcul"] = $precalculSCPI;
			//$precalculTotal['Tof'] = $precalculTotal['ventePotentielle'] * floatval($precalculSCPI['scpi']->Tof);
			if (!empty(floatval($precalculSCPI['scpi']->getTof())))
			{
				$precalculTotal['ventePotentiellePourTof'] += $precalculSCPI['ventePotentielle'];
				$precalculTotal['Tof'] += $precalculSCPI['Tof'];
			}
		}
		if ($precalculTotal['ventePotentielle'] > 0)
			$precalculTotal['ageMoyenScpi'] = $precalculTotal['pourAgeMoyenScpi'] / $precalculTotal['ventePotentielle'];

		if ($precalculTotal['ventePotentiellePourTof'])
			$precalculTotal['Tof'] /= $precalculTotal['ventePotentiellePourTof'];
		if ($precalculTotal['pourcentageRendement']) {
			$precalculTotal['pourcentageFiscale'] /= $precalculTotal['pourcentageFiscale'] + $precalculTotal['pourcentageRendement'];
			$precalculTotal['pourcentageFiscale'] *= 100;
			$precalculTotal['pourcentageRendement'] /= $precalculTotal['pourcentageFiscale'] + $precalculTotal['pourcentageRendement'];
			$precalculTotal['pourcentageRendement'] *= 100;
		}
		if ($precalculTotal['MontantInvestissement'] != 0) {
			$precalculTotal['plusMoinValuePourcent'] = (100 * ($precalculTotal['ventePotentielle'] / $precalculTotal['MontantInvestissement'])) - 100;
			$precalculTotal['plusMoinValueEuro'] = $precalculTotal['ventePotentielle'] - $precalculTotal['MontantInvestissement'];
		} else {
			$precalculTotal['plusMoinValuePourcent'] = "-";
			$precalculTotal['plusMoinValueEuro'] = "-";
		}
		if ($precalculTotal['MontantInvestissementPleine'] != 0) {
			$precalculTotal['plusMoinValuePourcentPleine'] = (100 * ($precalculTotal['ventePotentiellePleine'] / $precalculTotal['MontantInvestissementPleine'])) - 100;
			$precalculTotal['plusMoinValueEuroPleine'] = $precalculTotal['ventePotentiellePleine'] - $precalculTotal['MontantInvestissementPleine'];
		} else {
			$precalculTotal['plusMoinValuePourcentPleine'] = "-";
			$precalculTotal['plusMoinValueEuroPleine'] = "-";
		}
		if ($precalculTotal['MontantInvestissementNue'] != 0) {
			$precalculTotal['plusMoinValuePourcentNue'] = (100 * ($precalculTotal['ventePotentielleNue'] / $precalculTotal['MontantInvestissementNue'])) - 100;
			$precalculTotal['plusMoinValueEuroNue'] = $precalculTotal['ventePotentielleNue'] - $precalculTotal['MontantInvestissementNue'];
		} else {
			$precalculTotal['plusMoinValuePourcentNue'] = "-";
			$precalculTotal['plusMoinValueEuroNue'] = "-";
		}
		uasort($rt, function ($a, $b) {
			return ($a['precalcul']['ventePotentielle'] < $b['precalcul']['ventePotentielle']);
		});
//		$precalculTotal['actualDividendes'] = $this->getDividendes();
		$rt['precalcul'] = $precalculTotal;
	//			exit();
		return ($rt);
	}
}
