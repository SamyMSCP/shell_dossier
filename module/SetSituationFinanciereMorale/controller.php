<?php

require_once("class/core/Module.php");


class SetSituationFinanciereMorale extends Module
{
	public function insertSituationFinanciere() {
		/*
			CA_N
			CA_N1
			CA_N2
			resultat_N
			resultat_N1
			resultat_N2
			taux_endettement_N
			taux_endettement_N1
			taux_endettement_N2
			evolution_CA
			investissement_consequent_prevu
		*/
		if (
			!isset($_POST['CA_N']) ||
			!isset($_POST['CA_N1']) ||
			!isset($_POST['CA_N2']) ||
			!isset($_POST['resultat_N']) ||
			!isset($_POST['resultat_N1']) ||
			!isset($_POST['resultat_N2']) ||
			!isset($_POST['taux_endettement_N']) ||
			!isset($_POST['taux_endettement_N1']) ||
			!isset($_POST['taux_endettement_N2']) ||
			!isset($_POST['evolution_CA']) ||
			!isset($_POST['investissement_consequent_prevu']) ||
			strlen($_POST['CA_N']) <= 0 ||
			strlen($_POST['CA_N1']) <= 0 ||
			strlen($_POST['CA_N2']) <= 0 ||
			strlen($_POST['resultat_N']) <= 0 ||
			strlen($_POST['resultat_N1']) <= 0 ||
			strlen($_POST['resultat_N2']) <= 0 ||
			strlen($_POST['taux_endettement_N']) <= 0 ||
			strlen($_POST['taux_endettement_N1']) <= 0 ||
			strlen($_POST['taux_endettement_N2']) <= 0 ||
			intval($_POST['evolution_CA']) < 0 || intval($_POST['evolution_CA']) > 1 || 
			intval($_POST['investissement_consequent_prevu']) < 0 || intval($_POST['investissement_consequent_prevu']) > 1
		)
		{
			Notif::set('msgAddSituation', "La situation n'a pas pu etre ajoutee");
			return;
		}

		$datas = array(
			date("Y") => array(
				"CA" => intval($_POST['CA_N']),
				"resultat" => intval($_POST['resultat_N']),
				"taux_endettement" => intval($_POST['taux_endettement_N'])
			),
			date("Y") - 1 => array(
				"CA" => intval($_POST['CA_N1']),
				"resultat" => intval($_POST['resultat_N1']),
				"taux_endettement" => intval($_POST['taux_endettement_N1'])
			),
			date("Y") - 2 => array(
				"CA" => intval($_POST['CA_N2']),
				"resultat" => intval($_POST['resultat_N2']),
				"taux_endettement" => intval($_POST['taux_endettement_N2'])
			),
		);
		$evolution_CA = intval($_POST['evolution_CA']);
		$investissement_consequent_prevu = intval($_POST['investissement_consequent_prevu']);

		$rt = SituationFinanciereMorale::insertNew($this->Pm->getOrCreateSituation(), time(), time() + TIME_SITUATION_VALID,
			serialize($datas),
			$evolution_CA,
			$investissement_consequent_prevu
		);

//		Notif::set('msgAddSituation', "La situation Financiere a bien ete ajoute");
		header("Location: ?p=" . $GLOBALS['GET']['p'] . "&projet=" . $GLOBALS['GET']['projet']);
		exit();
	}
}
