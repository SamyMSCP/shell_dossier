<?php

require_once("class/core/Module.php");


class SetSituationPatrimonialeMorale extends Module
{
	public function insertSituationPatrimoniale() {

		if (
			!isset($_POST['fourchette_montant_patrimoine']) || 
			$_POST['fourchette_montant_patrimoine'] < 1 ||
			$_POST['fourchette_montant_patrimoine'] > 5
		)
		{
			Notif::set('msgAddSituation', "La situation n'a pas pu etre ajoutee (fourchette_montant_patrimoine)");
			return ;
		}
		$fourchette_montant_patrimoine = intval($_POST['fourchette_montant_patrimoine']);


		if (!isset($_POST['repartition_liquidite']) || 
			$_POST['repartition_liquidite'] < 0
		)
		{
			Notif::set('msgAddSituation', "La situation n'a pas pu etre ajoutee (repartition_liquidite)");
			return ;
		}
		$repartition_liquidite = intval($_POST['repartition_liquidite']);


		if (!isset($_POST['repartition_court']) || 
			$_POST['repartition_court'] < 0
		)
		{
			Notif::set('msgAddSituation', "La situation n'a pas pu etre ajoutee (repartition_court)");
			return ;
		}
		$repartition_court = intval($_POST['repartition_court']);

		if (!isset($_POST['repartition_long']) || 
			$_POST['repartition_long'] < 0
		)
		{
			Notif::set('msgAddSituation', "La situation n'a pas pu etre ajoutee (repartition_long)");
			return ;
		}
		$repartition_long = intval($_POST['repartition_long']);



		if (!isset($_POST['repartition_immobilier']) || 
			$_POST['repartition_immobilier'] < 0
		)
		{
			Notif::set('msgAddSituation', "La situation n'a pas pu etre ajoutee (repartition_immobilier)");
			return ;
		}
		$repartition_immobilier = intval($_POST['repartition_immobilier']);



		if (!isset($_POST['repartition_scpi']) || 
			$_POST['repartition_scpi'] < 0
		)
		{
			Notif::set('msgAddSituation', "La situation n'a pas pu etre ajoutee (repartition_scpi)");
			return ;
		}
		$repartition_scpi = intval($_POST['repartition_scpi']);

		if (!isset($_POST['repartition_autres']) || 
			$_POST['repartition_autres'] < 0
		)
		{
			Notif::set('msgAddSituation', "La situation n'a pas pu etre ajoutee (repartition_autres)");
			return ;
		}
		$repartition_autres = intval($_POST['repartition_autres']);

		if (
			!isset($_POST['futur_placement']) || 
			$_POST['futur_placement'] < 1 ||
			$_POST['futur_placement'] > 3
		)
		{
			Notif::set('msgAddSituation', "La situation n'a pas pu etre ajoutee (futur_placement)");
			return ;
		}
		$futur_placement = intval($_POST['futur_placement']);

		$rt = SituationPatrimonialeMorale::insertNew($this->Pm->getOrCreateSituation(), time(), time() + TIME_SITUATION_VALID,
		$fourchette_montant_patrimoine,
		$futur_placement,
		$repartition_liquidite,
		$repartition_court,
		$repartition_long,
		$repartition_immobilier,
		$repartition_scpi,
		$repartition_autres
		);
		
//		Notif::set('msgAddSituation', "La situation a bien ete ajoute");
		header("Location: ?p=" . $GLOBALS['GET']['p'] . "&projet=" . $GLOBALS['GET']['projet']);
		exit();
	}
}
