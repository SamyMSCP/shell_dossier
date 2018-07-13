<?php
require_once("class/core/Ajax.php");
class RestSituation  extends Ajax
{

	public function checkCommun($data) {
		if (
			!isset($data["id_situation"]) ||
			!isset($data["date_situation"]) ||
			!isset($data["date_fin_situation"])
		)
			error("La situation n'a pas pu etre insérée car le format de la requete n'est pas respecté :(");
		$Pp = Pp::getFromKeyValue("id_situation", intval($data['id_situation']));
		if (empty($Pp))
			error("La situation juridique n'a pas pu etre insérée car aucune personne physique n'est rattachée a cette situation");
		return ($Pp[0]);
	}

	public function insertJuridique($data) {
		if (
			!isset($data["regime_mat"]) ||
			!isset($data["haveChild"]) ||
			!isset($data["nbr_enfant_charge"]) ||
			!isset($data["nbr_pers_charge"])
		)
			error("La situation juridique n'a pas pu etre insérée car le format de la requete n'est pas respecté :(");

		$regime_mat = intval($data['regime_mat']);
		$haveChild = $data["haveChild"];
		$nbr_enfant_charge = $data["nbr_enfant_charge"];
		$nbr_pers_charge = $data["nbr_pers_charge"];

		if (!isset(SituationJuridique::$_regimeMatrimonial[$regime_mat]))
			error("La situation juridique n'a pas pu etre insérée car le régime matrimoniale n'est pas valide :(");

		if ($haveChild != 1 && $haveChild != 0)
			error("La situation juridique n'a pas pu etre insérée ['haveChild'] :(");

		if ($nbr_enfant_charge < 0)
			error("La situation juridique n'a pas pu etre insérée ['nbr_enfant_charge'] :(");

		if ($nbr_pers_charge < 0)
			error("La situation juridique n'a pas pu etre insérée ['nbr_pers_charge'] :(");

		$Pp = $this->checkCommun($data);
		$rt = $Pp->insertSituationJuridique(time(), time() + TIME_SITUATION_VALID, $regime_mat, $nbr_enfant_charge, $nbr_pers_charge, $haveChild);
		$insert = SituationJuridique::getFromId($rt);
		if (empty($rt) || empty($insert))
			error("La situation juridique n'a pas pu etre insérée :(");
		success($insert[0]->getForStore());
	}

	public function insertFinanciere($data) {
		if (
			!isset($data["habitation"]) ||
			!isset($data["id_situation"]) ||
			!isset($data["date_situation"]) ||
			!isset($data["date_fin_situation"]) ||
			!isset($data["revenu_professionnels"]) ||
			!isset($data["revenu_immobiliers"]) ||
			!isset($data["revenu_mobiliers"]) ||
			!isset($data["revenu_autres"]) ||
			(!isset($data["nature_revenu_autres"]) && intval($data["revenu_autres"]) > 0)||
			(!isset($data["remboursement_mensuel"]) && $data["habitation"] == 1)  ||
			(!isset($data["duree_remboursement_restante"]) && $data["habitation"] == 1)  ||
			!isset($data["residance_montant"]) ||
			!isset($data["residance_duree"]) ||
			!isset($data["locatif_montant"]) ||
			!isset($data["locatif_duree"]) ||
			!isset($data["scpi_montant"]) ||
			!isset($data["scpi_duree"]) ||
			!isset($data["autres_remboursement_montant"]) ||
			!isset($data["autres_remboursement_duree"]) ||
			
			(!isset($data["loyer_montant"]) && $data["habitation"] == 2)  ||
			!isset($data["consommation_montant"]) ||
			!isset($data["consommation_duree"]) ||
			!isset($data["autres_charges"])
		)
			error("La situation financiere n'a pas pu etre insérée car le format de la requete n'est pas respecté :(");
			
		$id_situation = $data["id_situation"];
		$date_situation = $data["date_situation"];
		$date_fin_situation = $data["date_fin_situation"];
		$revenu_professionnels = $data["revenu_professionnels"];
		$revenu_immobiliers = $data["revenu_immobiliers"];
		$revenu_mobiliers = $data["revenu_mobiliers"];
		$revenu_autres = $data["revenu_autres"];
		$remboursement_mensuel = $data["remboursement_mensuel"];
		$duree_remboursement_restante = $data["duree_remboursement_restante"];
		$residance_montant = $data["residance_montant"];
		$residance_duree = $data["residance_duree"];
		$locatif_montant = $data["locatif_montant"];
		$locatif_duree = $data["locatif_duree"];
		$scpi_montant = $data["scpi_montant"];
		$scpi_duree = $data["scpi_duree"];
		$autres_remboursement_montant = $data["autres_remboursement_montant"];
		$autres_remboursement_duree = $data["autres_remboursement_duree"];
		$nature_revenu_autres = $data["nature_revenu_autres"];

		$habitation = $data["habitation"];
		$loyer_montant = $data["loyer_montant"];
		$consommation_montant = $data["consommation_montant"];
		$consommation_duree = $data["consommation_duree"];
		$autres_charges = $data["autres_charges"];

		$Pp = $this->checkCommun($data);
		$rt = SituationFinanciere::insertNew2(
			$Pp->getOrCreateSituation(),
			time(),
			time() + TIME_SITUATION_VALID,
			$revenu_professionnels,
			$revenu_immobiliers,
			$revenu_mobiliers,
			$revenu_autres,
			$remboursement_mensuel,
			$duree_remboursement_restante,
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
		$insert = SituationFinanciere::getFromId($rt);
		if (empty($rt) || empty($insert))
			error("La situation financiere n'a pas pu etre insérée :(");
		$insert[0]->updateOneColumn("habitation", $habitation);
		$insert[0]->updateOneColumn("loyer_montant", $loyer_montant);
		$insert[0]->updateOneColumn("consommation_montant", $consommation_montant);
		$insert[0]->updateOneColumn("consommation_duree", $consommation_duree);
        $insert[0]->updateOneColumn("autres_charges", $autres_charges);

		$insert = SituationFinanciere::getFromId($rt);
		if (empty($insert))
			error("La situation financiere n'a pas pu etre insérée :(");
		success($insert[0]->getForStore());
	}

	public function insertFiscale($data) {
		if (
			!isset($data["residence_france"]) ||
			!isset($data["nbr_parts_fiscales"]) ||
			!isset($data["pays"]) ||
			!isset($data["id_impot"]) ||
			!isset($data["id_tranche_impot"]) ||
			!isset($data["id_impot_fortune"]) ||
			!isset($data["id_tranche_impot_fortune"]) ||
			!isset($data["impot_annee_precedente"]) ||
			!isset($data["haveImpot"]) ||
			!isset($data["haveImpotFortune"])
		)
			error("La situation fiscale n'a pas pu etre insérée car le format de la requete n'est pas respecté :(");

		$residence_france				= intval($data["residence_france"]);
		$pays							= htmlspecialchars($data["pays"]);
		$impot_annee_precedente			= intval($data["impot_annee_precedente"]);
		$id_impot						= intval($data["id_impot"]);
		$id_tranche_impot				= intval($data["id_tranche_impot"]);
		$id_impot_fortune				= intval($data["id_impot_fortune"]);
		$id_tranche_impot_fortune		= intval($data["id_tranche_impot_fortune"]);
		$nbr_parts_fiscales				= intval($data["nbr_parts_fiscales"]);
		$haveImpot						= intval($data["haveImpot"]);
		$haveImpotFortune				= intval($data["haveImpotFortune"]);


		if ($residence_france == 0)
		{
			$pays = "France";
		}
		if ($haveImpot == 0)
		{
			$id_impot					= 0;
			$id_tranche_impot			= 0;
			$impot_annee_precedente		= 0;
		}
		if ($haveImpotFortune == 0)
		{
			$id_impot_fortune			= 0;
			$id_tranche_impot_fortune	= 0;
		}

		$Pp = $this->checkCommun($data);
		$rt = SituationFiscale::insertNew2(
			$Pp->getOrCreateSituation(),
			time(),
			time() + TIME_SITUATION_VALID,
			$residence_france,
			$nbr_parts_fiscales,
			$pays,
			$id_impot,
			$id_tranche_impot,
			$id_impot_fortune,
			$id_tranche_impot_fortune
		);
		$insert = SituationFiscale::getFromId($rt);
		if (empty($rt) || empty($insert))
			error("La situation fiscale n'a pas pu etre insérée :(");

		$insert[0]->updateOneColumn("impot_annee_precedente", $impot_annee_precedente);

		$insert = SituationFiscale::getFromId($rt);
		if (empty($insert))
			error("La situation fiscale n'a pas pu etre insérée :(");
		success($insert[0]->getForStore());
	}
	public function insertPatrimoniale($data) {
		if (
			!isset($data["fourchette_montant_patrimoine"]) ||
			!isset($data["repartition_residence_secondaire"]) ||
			!isset($data["repartition_immobilier_locatif"]) ||
			!isset($data["repartition_scpi"]) ||
			!isset($data["repartition_autres"]) ||
			!isset($data["futur_placement"]) ||
			!isset($data["repartition_residence_principale"]) ||
			!isset($data["repartition_assurance_vie"]) ||
			!isset($data["repartition_PEA"]) ||
			!isset($data["repartition_PEL"])
		)
			error("La situation patrimoniale n'a pas pu etre insérée car le format de la requete n'est pas respecté :(");

		$fourchette_montant_patrimoine		= intval($data["fourchette_montant_patrimoine"]);
		$repartition_residence_secondaire	= intval($data["repartition_residence_secondaire"]);
		$repartition_immobilier_locatif		= intval($data["repartition_immobilier_locatif"]);
		$repartition_scpi					= intval($data["repartition_scpi"]);
		$repartition_autres					= intval($data["repartition_autres"]);
		$futur_placement					= intval($data["futur_placement"]);
		$repartition_residence_principale	= intval($data["repartition_residence_principale"]);
		$repartition_assurance_vie			= intval($data["repartition_assurance_vie"]);
		$repartition_PEA					= intval($data["repartition_PEA"]);
		$repartition_PEL					= intval($data["repartition_PEL"]);

		$Pp = $this->checkCommun($data);
		$rt = SituationPatrimoniale::insertNew2(
			$Pp->getOrCreateSituation(),
			time(),
			time() + TIME_SITUATION_VALID,
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
		$insert = SituationPatrimoniale::getFromId($rt);
		if (empty($rt) || empty($insert))
			error("La situation fiscale n'a pas pu etre insérée :(");

		$insert = SituationPatrimoniale::getFromId($rt);
		if (empty($insert))
			error("La situation Patrimoniale n'a pas pu etre insérée :(");
		success($insert[0]->getForStore());
	}

}

/*

	fourchette_montant_patrimoine
	repartition_residence_secondaire
	repartition_immobilier_locatif
	repartition_scpi
	repartition_autres
	futur_placement
	repartition_residence_principale
	repartition_assurance_vie
	repartition_PEA
	repartition_PEL
*/
