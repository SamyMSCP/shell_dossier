	public static function forGeneracteCache($lst) {
		$rt = array();
		foreach ($lst as $elm) {
			$pleine = array();
			$nue = array();
			$usu = array();
			foreach ($elm->getData() as $data) {
				$data->actualDividendes = $elm;
				if ($data->status_trans != 42) {
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
				if ($data->status_trans == 42) {
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
			"actualDividendes" => 0,
			"lastDividendes" => 0,
			"scpiList" => [],
			"scpiListId" => [],
		);
		foreach ($rt as $key => $elm1) { // Separation par nom de SCPI
			$precalculSCPI = array(
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
				"Tof" => 0
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
						"plusMoinValueEuro" => 0
					);
				$MoyenneCleRepartitionX = 0;
				$MoyenneCleRepartitionY = 0;
				foreach ($elm2 as $key3 => $elm3) { // Separation par l'id de la transaction d'achat qui suit
					if (!isset($elm3['buy']))
					{
					//	var_dump($elm2);
						var_dump($elm3);
						var_dump($key3);
						exit();
					}
					$precalcul = array(
							"nbr_part" => 0,
							"doByMscpi" => false,
							"doByOther" => false,
							"prix_achat" => $elm3['buy']->prix_part,
							"flagMissingInfo" => false,
							"prix_actuel" => 0
						);
					//if ($elm3["buy"] == null)
					//{
						//dbg($elm3);
						//exit();
					//}
					if (!in_array($elm3['buy']->getScpi()->name, $precalculTotal['scpiList']))
						$precalculTotal['scpiList'][] = $elm3['buy']->getScpi()->name;
					if (!in_array($elm3['buy']->getScpi()->id, $precalculTotal['scpiListId']))
						$precalculTotal['scpiListId'][] = $elm3['buy']->getScpi()->id;

					if (strstr($elm3["buy"]->getTypePro(), "Usu")) {
						//$precalcul["prix_achat"] = $elm3['buy']->getUsufruit();
						$precalcul["prix_actuel"] = $elm3['buy']->getUsufruit();
					} elseif (strstr($elm3["buy"]->getTypePro(), "Nue")) {
						$precalcul["prix_actuel"] = $elm3['buy']->getNuePropriete();
					} else {
						$precalcul["prix_actuel"] = $elm3['buy']->getScpi()->getActualValue();
					}
					$precalculSCPI['scpi'] = $elm3['buy']->getScpi();
					$precalculSCPI['id_scpi'] = $elm3['buy']->getScpi()->id;
					$precalculSCPI['name'] = $elm3['buy']->getScpi()->name;
					$precalculSCPI['type_pro'] = $elm3['buy']->getTypePro();
					$precalculSCPI['actualDividendes'] = $elm3['buy']->actualDividendes->getDividende(date("Y"));
					$precalculSCPI['lastDividendes'] = $elm3['buy']->actualDividendes->getDividende(date("Y") - 1);
					$precalculType['lastDividendes'] = $elm3['buy']->actualDividendes->getDividendeTrimestreNoValue(0, date("Y") - 1);
					//$precalculType['lastDividendesTrimestre']["T1"] = $elm3['buy']->actualDividendes->getDividendeTrimestreNoValue(0, date("Y") - 1);
					//$precalculType['lastDividendesTrimestre']["T2"] = $elm3['buy']->actualDividendes->getDividendeTrimestreNoValue(1, date("Y") - 1);
					//$precalculType['lastDividendesTrimestre']["T3"] = $elm3['buy']->actualDividendes->getDividendeTrimestreNoValue(2, date("Y") - 1);
					//$precalculType['lastDividendesTrimestre']["T4"] = $elm3['buy']->actualDividendes->getDividendeTrimestreNoValue(3, date("Y") - 1);
					$precalculType['scpi'] = $elm3['buy']->getScpi();
					$precalculType['id_scpi'] = $elm3['buy']->getScpi()->id;
					$precalculType['name'] = $elm3['buy']->getScpi()->name;
					$precalculType['type_pro'] = $elm3['buy']->getTypePro();
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
					$precalcul['nbr_part'] = $elm3['buy']->getNbrPart();
					$elm3["buy"]->precalcul();
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
					if (strstr($precalculType["type_pro"], "Usu")){
						$precalculTotal['haveUsu'] = true;
					} else if (strstr($precalculType['type_pro'], "Nue")) {
						$precalculTotal['haveNue'] = true;
					} else {
						$precalculTotal['havePleine'] = true;
					}
					$precalculType['nbr_transaction'] += 1;
					if (strstr($elm3["buy"]->getTypePro(), 'Nue'))
						$precalculType['ventePotentielle'] += $precalcul['nbr_part'] * $elm3["buy"]->getNuePropriete();
					else
						$precalculType['ventePotentielle'] += $elm3["buy"]->getUsufruit() * $elm3["buy"]->getNbrPart();
					$precalculType['MontantInvestissement'] += $elm3['buy']->getNbrPart() * $precalcul["prix_achat"] * $elm3["buy"]->getClefRepartition() / 100;
					if (isset($elm3['sell']))
					{
						foreach ($elm3['sell'] as $key4 => $elm4) {
							$elm4->precalcul();
							$precalcul['nbr_part'] -= $elm4->getNbrPart();
							$precalculType['nbr_transaction'] += 1;
							$rt[$key][$key2][$key3]['sell'][$key4]->MontantRevente = $elm4->prix_part_vente * $elm4->nbr_part_vente;
							$rt[$key][$key2][$key3]['sell'][$key4]->plusMoinValuePourcent = (100 * ($elm4->prix_part_vente / ($elm3['buy']->prix_part))) - 100;
							$rt[$key][$key2][$key3]['sell'][$key4]->plusMoinValueEuro = $elm4->prix_part_vente - $elm3['buy']->prix_part;
						}
					}
					if (strstr($elm3["buy"]->getTypePro(), 'Nue')){
						$precalcul['ventePotentielle'] = $precalcul['nbr_part'] * $elm3["buy"]->getNuePropriete();
						if ($precalcul['prix_achat'] != 0 && $precalcul['nbr_part'] != 0) {
							$precalcul['plusMoinValuePourcent'] = 100 * ($elm3["buy"]->getNuePropriete() / ($precalcul['prix_achat'] * $elm3["buy"]->getClefRepartition() / 100)) - 100;
							$precalcul['plusMoinValueEuro'] = ($elm3["buy"]->getNuePropriete() * $precalcul['nbr_part']) - ($precalcul['prix_achat'] * $precalcul['nbr_part'] * ($elm3["buy"]->getClefRepartition() / 100));
						} else {
							$precalcul['plusMoinValuePourcent'] = "-";
							$precalcul['plusMoinValueEuro'] = "-";
						}
					}
					else{
						$precalcul['ventePotentielle'] = $precalcul['nbr_part'] * $precalcul['prix_actuel'];
						if ($precalcul['prix_achat'] != 0 && $precalcul['nbr_part'] != 0) {
							$precalcul['plusMoinValuePourcent'] = 100 * ($precalcul['prix_actuel'] / $precalcul['prix_achat']) - 100;
							$precalcul['plusMoinValueEuro'] = $precalcul['ventePotentielle'] - ($precalcul['prix_achat'] * $precalcul['nbr_part']);
						} else {
							$precalcul['plusMoinValuePourcent'] = "-";
							$precalcul['plusMoinValueEuro'] = "-";
						}
					}
					$rt[$key][$key2][$key3]["precalcul"] = $precalcul;
					$precalculType['nbr_part'] += $precalcul['nbr_part'];
					$precalculType['MoyennePrixPart'] += $precalcul['prix_achat'] * $precalcul['nbr_part'];

					$tmpInvestissement = $precalcul['prix_achat'] * $precalcul['nbr_part'];
					if (strstr($elm3["buy"]->getTypePro(), 'Nue')){
						$tmpInvestissement *= (100 - $elm3["buy"]->getClefRepartition()) / 100;
					}
					else if (strstr($elm3["buy"]->getTypePro(), 'Usu')){
						$tmpInvestissement *= $elm3["buy"]->getClefRepartition() / 100;
					}
					if ($precalcul['doByMscpi'])
					{
						$precalculTotal['MontantInvestissementMscpi'] += $tmpInvestissement;
						$precalculTotal['ventePotentielleMscpi'] += $precalcul['ventePotentielle'];
					}
					else
					{
						$precalculTotal['MontantInvestissementOther'] += $tmpInvestissement;
						$precalculTotal['ventePotentielleOther'] += $precalcul['ventePotentielle'];
					}






					if (!strstr($elm3['buy']->getTypePro(), "Pleine")) {
						$MoyenneCleRepartitionX += $elm3['buy']->getClefRepartition() * $elm3['buy']->prix_part * $precalcul['nbr_part'];
						$MoyenneCleRepartitionY += $elm3['buy']->prix_part * $precalcul['nbr_part'];
					}
				}
				uasort($rt[$key][$key2], function ($a, $b) {
					if ($a['precalcul']['flagMissingInfo']) {
						return false;
					}
					if ($b['precalcul']['flagMissingInfo']) {
						return true;
					}
					return ($a['buy']->getEnrDate() > $b['buy']->getEnrDate());
				});
				$precalculType["modal_link"] = 'modal_' . $key2 . '_' .  str_replace(array(' ', '"', "'"), '_' , $key);
				$precalculType['prix_actuel'] = $precalcul['prix_actuel'];
				if ($precalculType['nbr_part'] != 0)
					$precalculType['MoyennePrixPart'] /= $precalculType['nbr_part'];
				else
					$precalculType['MoyennePrixPart'] = 0;

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
					$precalculType['ventePotentielle'] = $precalculType['nbr_part'] * $precalculType['prix_actuel'];
					$precalculSCPI['MontantInvestissementPleine'] += $precalculType['MontantInvestissement'];
					$precalculSCPI['ventePotentiellePleine'] += $precalculType['ventePotentielle'];
					if ($precalculType['MoyennePrixPart'] != 0) {
						$precalculType['plusMoinValuePourcent'] = (100 * ($precalculType['prix_actuel'] / $precalculType['MoyennePrixPart'])) - 100;
						$precalculType['plusMoinValueEuro'] = $precalculType['ventePotentielle'] - $precalculType['MontantInvestissement'];
					}
				}
				$precalculSCPI['nbr_part'] += $precalculType['nbr_part'];
				$precalculSCPI['ventePotentielle'] += $precalculType['ventePotentielle'];
				$precalculSCPI['MontantInvestissement'] += $precalculType['MontantInvestissement'];
				$rt[$key][$key2]["precalcul"] = $precalculType;
			}

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
			$precalculTotal['lastDividendes'] += $precalculSCPI['lastDividendes'];

			$precalculSCPI['Tof'] = $precalculSCPI['ventePotentielle'] * floatval($precalculSCPI['scpi']->getTof());
			$rt[$key]["precalcul"] = $precalculSCPI;
			//$precalculTotal['Tof'] = $precalculTotal['ventePotentielle'] * floatval($precalculSCPI['scpi']->Tof);
			if (!empty(floatval($precalculSCPI['scpi']->getTof())))
			{
				$precalculTotal['ventePotentiellePourTof'] += $precalculSCPI['ventePotentielle'];
				$precalculTotal['Tof'] += $precalculSCPI['Tof'];
			}
		}
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
