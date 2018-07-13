<?php
require_once("class/core/Module.php");
class SetProfilInvestisseur extends Module
{
	public function setProfilResult() {
		$btn1 = isset($_POST['estimation']) && $_POST['estimation'] == 1;
		$btn2 = isset($_POST['note']) && $_POST['note'] == 1;
		// Si le resultat le demande, verifier que tout est bien rempli.
		$profil = $this->Pp->getLastProfilInvestisseur();
		if ($profil->getScore() >= 10 || ($btn1 && $btn2))
		{
			$profil->updateOneColumn("estimation", $btn1);
			$profil->updateOneColumn("note", $btn2);
			$profil->updateOneColumn("status", 2);
			return (true);
		}
		else
		{
			Notif::set("msgAddProfil", "Le profil n'a pas pu etre ajoute !");
			return (false);
		}
	}
	public function setNewProfilInvestisseur() {
		if (
			!isset($_POST['risque']) ||
			!isset($_POST['immo']) ||
			!isset($_POST['finan']) ||
			!isset($_POST['connaissance']) ||
			!isset($_POST['connaissanceScpi']) ||
			!isset($_POST['id_Pp'])
		)
		{
			Notif::set("addProfil", "Le profil n'a pas pu etre ajoute");
			return (false);
		}
		$risque = intval($_POST['risque']);
		$immo = intval($_POST['immo']);
		$finan = intval($_POST['finan']);
		$connaissance = intval($_POST['connaissance']);
		$connaissanceScpi = intval($_POST['connaissanceScpi']);

		if ($risque < 1 || $risque > 4)
		{
			Notif::set("addProfil", "Le profil n'a pas pu etre ajoute");
			return (false);
		}

		if ($immo < 0 || $immo > 1)
		{
			Notif::set("addProfil", "Le profil n'a pas pu etre ajoute");
			return (false);
		}

		if ($finan < 0 || $finan > 1)
		{
			Notif::set("addProfil", "Le profil n'a pas pu etre ajoute");
			return (false);
		}

		if ($connaissance < 0 || $connaissance > 4)
		{
			Notif::set("addProfil", "Le profil n'a pas pu etre ajoute");
			return (false);
		}

		if ($connaissanceScpi < 0 || $connaissanceScpi > 3)
		{
			Notif::set("addProfil", "Le profil n'a pas pu etre ajoute");
			return (false);
		}

		$typePlacementAction = isset($_POST['typePlacementAction']) ;
		$typePlacementAssuranceVie = isset($_POST['typePlacementAssuranceVie']) ;
		$typePlacementObligations = isset($_POST['typePlacementObligations']) ;
		$typePlacementOPCVM = isset($_POST['typePlacementOPCVM']) ;
		$typePlacementScpi = isset($_POST['typePlacementScpi']) ;
		$typePlacementOPCI = isset($_POST['typePlacementOPCI']) ;
		$typePlacementFCPI = isset($_POST['typePlacementFCPI']) ;
		$typePlacementCrowdfunding = isset($_POST['typePlacementCrowdfunding']) ;


		$dispose_actions			= isset($_POST['dispose_actions']);
		$dispose_fcpi_fip_fcpr		= isset($_POST['dispose_fcpi_fip_fcpr']);
		$dispose_opcvm				= isset($_POST['dispose_opcvm']);
		$dispose_assurance_vie		= isset($_POST['dispose_assurance_vie']);
		$dispose_obligations		= isset($_POST['dispose_obligations']);
		$dispose_scpi				= isset($_POST['dispose_scpi']);
		$dispose_opci				= isset($_POST['dispose_opci']);
		$dispose_liquidite			= isset($_POST['dispose_liquidite']);
		$dispose_pea				= isset($_POST['dispose_pea']);
		$dispose_immobilier_direct	= isset($_POST['dispose_immobilier_direct']);
		$dispose_crowdfunding		= isset($_POST['dispose_crowdfunding']);

		$gestion_directe			= isset($_POST['gestion_directe']);
		$gestion_conseiller			= isset($_POST['gestion_conseiller']);
		$gestion_sous_mandat		= isset($_POST['gestion_sous_mandat']);

		if (!isset($_POST['si_jinvesti']))
		{
			Notif::set("addProfil", "Le profil n'a pas pu etre ajoute");
			return (false);
		}
		$si_jinvesti				= intval($_POST['si_jinvesti']);

		$profil = array();
		for ($i = 0; $i < count(ProfilInvestisseur::$_listQuestions); $i++)
		{
			if(!isset($_POST['Quiz-' . $i]))
			{
				Notif::set("addProfil", "Le profil n'a pas pu etre ajoute");
				return (false);
			}
			$profil[$i] = intval($_POST['Quiz-' . $i]);
		}

		$id_Pp = intval($_POST['id_Pp']);
		$score = ProfilInvestisseur::scoreTable(
			$id_Pp,
			$risque,
			$immo,
			$finan,
			$connaissance,
			$connaissanceScpi,
			$typePlacementAction,
			$typePlacementAssuranceVie,
			$typePlacementObligations,
			$typePlacementOPCVM,
			$typePlacementScpi,
			$typePlacementOPCI,
			$typePlacementFCPI,
			$profil
		);

		$score += $dispose_actions;
		$score += $dispose_fcpi_fip_fcpr;
		$score += $dispose_opcvm;
		$score += $dispose_assurance_vie;
		$score += $dispose_obligations;
		$score += $dispose_scpi;
		$score += $dispose_opci;
		$score += $dispose_liquidite;
		$score += $dispose_pea;
		$score += $dispose_immobilier_direct;

		$score += ($si_jinvesti == 480) ? 1 : 0;
		$score *= 20 / 40;
		$rt = ProfilInvestisseur::insertNew(
			$id_Pp,
			$risque,
			$immo,
			$finan,
			$connaissance,
			$connaissanceScpi,
			$typePlacementAction,
			$typePlacementAssuranceVie,
			$typePlacementObligations,
			$typePlacementOPCVM,
			$typePlacementScpi,
			$typePlacementOPCI,
			$typePlacementFCPI,
			serialize($profil),
			$score
		);
		$profil = ProfilInvestisseur::getFromId($rt);
		if (empty($profil))
		{
			Notif::set("addProfil", "Le profil n'a pas pu etre ajoute");
			return (false);
		}
		$profil = $profil[0];
		$profil->updateOneColumn("dispose_actions", $dispose_actions);
		$profil->updateOneColumn("dispose_fcpi_fip_fcpr", $dispose_fcpi_fip_fcpr);
		$profil->updateOneColumn("dispose_opcvm", $dispose_opcvm);
		$profil->updateOneColumn("dispose_assurance_vie", $dispose_assurance_vie);
		$profil->updateOneColumn("dispose_obligations", $dispose_obligations);
		$profil->updateOneColumn("dispose_scpi", $dispose_scpi);
		$profil->updateOneColumn("dispose_opci", $dispose_opci);
		$profil->updateOneColumn("dispose_liquidite", $dispose_liquidite);
		$profil->updateOneColumn("dispose_pea", $dispose_pea);
		$profil->updateOneColumn("dispose_immobilier_direct", $dispose_immobilier_direct);
		$profil->updateOneColumn("gestion_directe", $gestion_directe);
		$profil->updateOneColumn("gestion_conseiller", $gestion_conseiller);
		$profil->updateOneColumn("gestion_sous_mandat", $gestion_sous_mandat);
		$profil->updateOneColumn("si_jinvesti_10000", $si_jinvesti);
		$profil->updateOneColumn("dispose_crowdfunding", $dispose_crowdfunding);
		$profil->updateOneColumn("connaissance_placement_crowdfunding", $typePlacementCrowdfunding);
	
		$nprofil = ProfilInvestisseur::getFromId($profil->id);
		if (empty($nprofil))
		{
			Notif::set("Profil", "Il y a eu un problemet lors de l'insertiotn du profil investisseur");
			header("Location: ?p=" . $GLOBALS['GET']['p'] . "&projet=" . $GLOBALS['GET']['projet'] . (isset($GLOBALS['GET']['client']) ? "&client=" . intval($GLOBALS['GET']['client']) : ""));
			exit();
		}
		$nprofil[0]->sendByMailToPp();
//		Notif::set("addPI",  "Votre profil investisseur est bien complete");
		return (true);
	}
}
