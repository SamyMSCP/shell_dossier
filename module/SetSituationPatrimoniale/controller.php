<?php

require_once("class/core/Module.php");


class SetSituationPatrimoniale extends Module
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




		if (
			!isset($_POST['repartition_residence_principale']) || 
			$_POST['repartition_residence_principale'] < 0
		)
		{
			Notif::set('msgAddSituation', "La situation n'a pas pu etre ajoutee (repartition_residence_principale)");
			return ;
		}
		$repartition_residence_principale = intval($_POST['repartition_residence_principale']);






		if (
			!isset($_POST['repartition_assurance_vie']) || 
			$_POST['repartition_assurance_vie'] < 0
		)
		{
			Notif::set('msgAddSituation', "La situation n'a pas pu etre ajoutee (repartition_assurance_vie)");
			return ;
		}
		$repartition_assurance_vie = intval($_POST['repartition_assurance_vie']);



		if (
			!isset($_POST['repartition_PEA']) || 
			$_POST['repartition_PEA'] < 0
		)
		{
			Notif::set('msgAddSituation', "La situation n'a pas pu etre ajoutee (repartition_PEA)");
			return ;
		}
		$repartition_PEA = intval($_POST['repartition_PEA']);



		if (
			!isset($_POST['repartition_PEL']) || 
			$_POST['repartition_PEL'] < 0
		)
		{
			Notif::set('msgAddSituation', "La situation n'a pas pu etre ajoutee (repartition_PEL)");
			return ;
		}
		$repartition_PEL = intval($_POST['repartition_PEL']);












		if (
			!isset($_POST['repartition_residence_secondaire']) || 
			$_POST['repartition_residence_secondaire'] < 0
		)
		{
			Notif::set('msgAddSituation', "La situation n'a pas pu etre ajoutee (repartition_residence_secondaire)");
			return ;
		}
		$repartition_residence_secondaire = intval($_POST['repartition_residence_secondaire']);


		if (!isset($_POST['repartition_immobilier_locatif']) || 
			$_POST['repartition_immobilier_locatif'] < 0
		)
		{
			Notif::set('msgAddSituation', "La situation n'a pas pu etre ajoutee (repartition_immobilier_locatif)");
			return ;
		}
		$repartition_immobilier_locatif = intval($_POST['repartition_immobilier_locatif']);

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


		$rt = SituationPatrimoniale::insertNew2($this->Pp->getOrCreateSituation(), time(), time() + TIME_SITUATION_VALID,
		$fourchette_montant_patrimoine,
		$futur_placement,
		$repartition_autres,
		$repartition_scpi,
		$repartition_immobilier_locatif,
		$repartition_residence_secondaire,
		$repartition_residence_principale,
		$repartition_assurance_vie,
		$repartition_PEA,
		$repartition_PEL
		);
		
//		Notif::set('msgAddSituation', "La situation a bien ete ajoute");
		header("Location: ?p=" . $GLOBALS['GET']['p'] . "&projet=" . $GLOBALS['GET']['projet'] . (isset($GLOBALS['GET']['client']) ? "&client=" . intval($GLOBALS['GET']['client']) : ""));
		exit();
	}
}
