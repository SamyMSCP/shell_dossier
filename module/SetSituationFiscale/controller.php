<?php

require_once("class/core/Module.php");


class SetSituationFiscale extends Module
{
	public function insertSituationFiscale() {
		///////////////////////////////////residence_principale
		if (!isset($_POST['residence_france']))
		{
			Notif::set('msgAddSituation', "La situation n'a pas pu etre ajoutee (radio residence)");
			header("Location: ?p=" . $GLOBALS['GET']['p'] . "&projet=" . $GLOBALS['GET']['projet'] . (isset($GLOBALS['GET']['client']) ? "&client=" . intval($GLOBALS['GET']['client']) : ""));
			exit();
		}
		$residence_france = intval($_POST['residence_france']);
		$pays = "France";
		if ($residence_france == 0)
		{
			if (!isset($_POST['pays']) || empty($_POST['pays']))
			{
				Notif::set('msgAddSituation', "La situation n'a pas pu etre ajoutee (pays)");
				header("Location: ?p=" . $GLOBALS['GET']['p'] . "&projet=" . $GLOBALS['GET']['projet'] . (isset($GLOBALS['GET']['client']) ? "&client=" . intval($GLOBALS['GET']['client']) : ""));
				exit();
			}
			$pays = htmlspecialchars($_POST['pays']);
		}

		if (!isset($_POST['other_money']))
		{
			Notif::set('msgAddSituation', "La situation n'a pas pu etre ajoutee (radio Impots)");
			header("Location: ?p=" . $GLOBALS['GET']['p'] . "&projet=" . $GLOBALS['GET']['projet'] . (isset($GLOBALS['GET']['client']) ? "&client=" . intval($GLOBALS['GET']['client']) : ""));
			exit();
		}
		$other_money = intval($_POST['other_money']);

		$id_impot = 0;
		$id_tranche_impot = 0;

		$nbr_parts_fiscales = 0;
		$impot_annee_precedente = 0;
		if ($other_money == 1)
		{
			if (
				!isset($_POST['id_impot']) ||
				!isset($_POST['id_tranche_impot']) ||
				!isset($_POST['nbr_parts_fiscales']) ||
				!isset($_POST['impot_annee_precedente']) ||
				$_POST['nbr_parts_fiscales'] < 1
			)
			{
				Notif::set('msgAddSituation', "La situation n'a pas pu etre ajoutee (radio Info Impots)");
				header("Location: ?p=" . $GLOBALS['GET']['p'] . "&projet=" . $GLOBALS['GET']['projet'] . (isset($GLOBALS['GET']['client']) ? "&client=" . intval($GLOBALS['GET']['client']) : ""));
				exit();
			}
			$impot_annee_precedente = floatval($_POST['impot_annee_precedente']);
			$id_impot = intval($_POST['id_impot']);
			$id_tranche_impot = intval($_POST['id_tranche_impot']);
			$nbr_parts_fiscales = intval($_POST['nbr_parts_fiscales']);
		}

		//ISF
		if (!isset($_POST['fortune']))
		{
			Notif::set('msgAddSituation', "La situation n'a pas pu etre ajoutee (radio fortune)");
			header("Location: ?p=" . $GLOBALS['GET']['p'] . "&projet=" . $GLOBALS['GET']['projet'] . (isset($GLOBALS['GET']['client']) ? "&client=" . intval($GLOBALS['GET']['client']) : ""));
			exit();
		}
		$fortune = intval($_POST['fortune']);
		$id_impot_fortune = 0;
		$id_tranche_impot_fortune = 0;
		//$tranche_isf = 0;
		if ($other_money == 1)
		{
			if (
				!isset($_POST['id_impot_fortune']) ||
				!isset($_POST['id_tranche_impot_fortune'])
			)
			{
				Notif::set('msgAddSituation', "La situation n'a pas pu etre ajoutee (radio Info ISF)");
				header("Location: ?p=" . $GLOBALS['GET']['p'] . "&projet=" . $GLOBALS['GET']['projet'] . (isset($GLOBALS['GET']['client']) ? "&client=" . intval($GLOBALS['GET']['client']) : ""));
				exit();
			}
			$id_impot_fortune = intval($_POST['id_impot_fortune']);
			$id_tranche_impot_fortune = intval($_POST['id_tranche_impot_fortune']);
		}

		$rt = SituationFiscale::insertNew2($this->Pp->getOrCreateSituation(), time(), time() + TIME_SITUATION_VALID,
			!$residence_france,
			$nbr_parts_fiscales,
			$pays,
			$id_impot,
			$id_tranche_impot,
			$id_impot_fortune,
			$id_tranche_impot_fortune
		);
		$situation = SituationFiscale::getFromId($rt);
		if (empty($situation))
		{
			Notif::set('msgAddSituation', "La situation n'a pas pu etre ajoutee");
			header("Location: ?p=" . $GLOBALS['GET']['p'] . "&projet=" . $GLOBALS['GET']['projet'] . (isset($GLOBALS['GET']['client']) ? "&client=" . intval($GLOBALS['GET']['client']) : ""));
			exit();
		}
		$situation = $situation[0];
		$situation->updateOneColumn("impot_annee_precedente", $impot_annee_precedente);
//		Notif::set('msgAddSituation', "La situation a bien ete enregistre");
		header("Location: ?p=" . $GLOBALS['GET']['p'] . "&projet=" . $GLOBALS['GET']['projet'] . (isset($GLOBALS['GET']['client']) ? "&client=" . intval($GLOBALS['GET']['client']) : ""));
		exit();
	}
}
