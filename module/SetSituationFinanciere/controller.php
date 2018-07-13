<?php

require_once("class/core/Module.php");


class SetSituationFinanciere extends Module
{
	public function insertSituationFinanciere() {
		/////////////// Check des premieres donnees
		// revenu_professionnels
		// revenu_immobiliers
		// revenu_mobiliers
		// revenu_autres
		// nature_revenu_autres
		if (
			!isset($_POST['revenu_professionnels']) ||
			!isset($_POST['revenu_immobiliers']) ||
			!isset($_POST['revenu_mobiliers']) ||
			!isset($_POST['revenu_autres']) ||
			!isset($_POST['nature_revenu_autres'])
		)
		{
			Notif::set('msgAddSituation', "La situation n'a pas pu etre ajoutee (Manque info)");
			return;
		}
		
		$revenu_professionnels = intval($_POST['revenu_professionnels']);
		$revenu_immobiliers = intval($_POST['revenu_immobiliers']);
		$revenu_mobiliers = intval($_POST['revenu_mobiliers']);
		$revenu_autres = intval($_POST['revenu_autres']);
		$nature_revenu_autres = htmlspecialchars($_POST['nature_revenu_autres']);

		if (
			$revenu_professionnels < 0 ||
			$revenu_immobiliers < 0 ||
			$revenu_mobiliers < 0 ||
			$revenu_autres < 0
		)
		{
			Notif::set('msgAddSituation', "La situation n'a pas pu etre ajoutee (Info errone)");
			return;
		}





		if (isset($_POST['residence_principale']) ) // residence_principale // check
		{
			///////////////////// check secondaire
			// remboursement_mensuel
			// duree_remboursement_restante

			if ($_POST['residence_principale'] == 1)
			{
			}
		}

		$remboursement_mensuel = 0;
		$duree_remboursement_restante = 0;

		$residance_montant = 0;
		$residance_duree = 0;
		$locatif_montant = 0;
		$locatif_duree = 0;
		$scpi_montant = 0;
		$scpi_duree = 0;
		$autres_remboursement_montant = 0;
		$autres_remboursement_duree = 0;



		//habitation
		//residance_montant
		//residance_duree
		//loyer_montant
		//locatif_montant
		//locatif_duree
		//consommation_montant
		//consommation_duree
		//scpi_montant
		//scpi_duree
		//autres_remboursement_montant
		//autres_remboursement_duree
		if (
				!isset($_POST['habitation']) ||
				!isset($_POST['residance_montant']) ||
				!isset($_POST['residance_duree']) ||
				!isset($_POST['loyer_montant']) ||
				!isset($_POST['locatif_montant']) ||
				!isset($_POST['locatif_duree']) ||
				!isset($_POST['consommation_montant']) ||
				!isset($_POST['consommation_duree']) ||
				!isset($_POST['scpi_montant']) ||
				!isset($_POST['scpi_duree']) ||
				!isset($_POST['autres_remboursement_montant']) ||
				!isset($_POST['autres_remboursement_duree']) ||
				!isset($_POST['remboursement_mensuel']) ||
				!isset($_POST['duree_remboursement_restante']) ||
                !isset($_POST['autres_charges'])
		)
		{
			Notif::set('msgAddSituation', "La situation n'a pas pu etre ajoutee (Manque info secondaires 2)");
			return;
		}

		$habitation = intval($_POST['habitation']);
		$loyer_montant = intval($_POST['loyer_montant']);


		$residance_montant = intval($_POST['residance_montant']);
		$residance_duree = intval($_POST['residance_duree']);
		$locatif_montant = intval($_POST['locatif_montant']);
		$locatif_duree = intval($_POST['locatif_duree']);

		$consommation_montant = intval($_POST['consommation_montant']);
		$consommation_duree = intval($_POST['consommation_duree']);

		$scpi_montant = intval($_POST['scpi_montant']);
		$scpi_duree = intval($_POST['scpi_duree']);
		$autres_remboursement_montant = intval($_POST['autres_remboursement_montant']);
		$autres_remboursement_duree = intval($_POST['autres_remboursement_duree']);
		$remboursement_mensuel = intval($_POST['remboursement_mensuel']);
		$duree_remboursement_restante = intval($_POST['duree_remboursement_restante']);
        $autres_charges = intval($_POST['autres_charges']);


		if (
			$habitation <= 0 ||
			$habitation > 3 ||
			$remboursement_mensuel < 0 ||
			$duree_remboursement_restante < 0 ||
			(
				$habitation == 2 &&
				$loyer_montant <= 0
			) ||
			$residance_montant < 0 ||
			$residance_duree < 0 ||
			$consommation_montant < 0 ||
			$consommation_duree < 0 ||
			$locatif_montant < 0 ||
			$locatif_duree < 0 ||
			$scpi_montant < 0 ||
			$scpi_duree < 0 ||
			$autres_remboursement_montant < 0 ||
			$autres_remboursement_duree < 0 ||
            $autres_charges < 0
		)
		{
			Notif::set('msgAddSituation', "La situation n'a pas pu etre ajoutee (info secondaires errone 2)");
			return;
		}

		$rt = SituationFinanciere::insertNew2($this->Pp->getOrCreateSituation(), time(), time() + TIME_SITUATION_VALID, $revenu_professionnels, $revenu_immobiliers, $revenu_mobiliers, $revenu_autres, $remboursement_mensuel, $duree_remboursement_restante, 
		$residance_montant,
		$residance_duree,
		$locatif_montant,
		$locatif_duree,
		$scpi_montant,
		$scpi_duree,
		$autres_remboursement_montant,
		$autres_remboursement_duree,
		$nature_revenu_autres
		);
		$fin = SituationFinanciere::getFromId($rt);
		if (empty($fin))
		{
			Notif::set('msgAddSituation', "La situation Financiere n'a pas été ajoutée");
			header("Location: ?p=" . $GLOBALS['GET']['p'] . "&projet=" . $GLOBALS['GET']['projet'] . (isset($GLOBALS['GET']['client']) ? "&client=" . intval($GLOBALS['GET']['client']) : ""));
			exit();
		}
		$fin = $fin[0];
		$fin->updateOneColumn("habitation", $habitation);
		$fin->updateOneColumn("loyer_montant", $loyer_montant);
		$fin->updateOneColumn("consommation_montant", $consommation_montant);
		$fin->updateOneColumn("consommation_duree", $consommation_duree);
        $fin->updateOneColumn("autres_charges", $autres_charges);
		header("Location: ?p=" . $GLOBALS['GET']['p'] . "&projet=" . $GLOBALS['GET']['projet'] . (isset($GLOBALS['GET']['client']) ? "&client=" . intval($GLOBALS['GET']['client']) : ""));
		exit();
	}
}
