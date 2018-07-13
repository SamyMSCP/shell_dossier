<?php

require_once("class/core/Module.php");

class SetSituationJuridiqueMorale extends Module
{

	public function insertSituationJuridique() {
		/*
			$dn_sociale
			$f_juridique
			$siret
			$activite
			$representant
			$qualite_de
			$siege_social
			$nationalite
		*/

		//verifier dn_sociale
		if (!isset($_POST['dn_sociale']) || (empty($_POST['dn_sociale'])))
		{
			Notif::set('msgAddSituation', "La situation n'a pas pu etre ajoutee (nom)");
			return;
		}
		$dn_sociale = $_POST['dn_sociale'];

		//verifier f_juridiquee
		if (!isset($_POST['f_juridique']) || (empty($_POST['f_juridique'])))
		{
			Notif::set('msgAddSituation', "La situation n'a pas pu etre ajoutee (f_juridique)");
			return;
		}
		$f_juridique = $_POST['f_juridique'];

		//verifier siret
		if (!isset($_POST['siret']) || (empty($_POST['siret'])))
		{
			Notif::set('msgAddSituation', "La situation n'a pas pu etre ajoutee (siret)");
			return;
		}
		$siret = $_POST['siret'];

		//verifier siret
		if (!isset($_POST['rcs']) || (empty($_POST['rcs'])))
		{
			Notif::set('msgAddSituation', "La situation n'a pas pu etre ajoutee (rcs)");
			return;
		}
		$rcs = $_POST['rcs'];

		//verifier activite
		if (!isset($_POST['activite']) || (empty($_POST['activite'])))
		{
			Notif::set('msgAddSituation', "La situation n'a pas pu etre ajoutee (activite)");
			return;
		}
		$activite = $_POST['activite'];

		//verifier siege_social
		if (!isset($_POST['siege_social']) || (empty($_POST['siege_social'])))
		{
			Notif::set('msgAddSituation', "La situation n'a pas pu etre ajoutee (siege_social)");
			return;
		}
		$siege_social = $_POST['siege_social'];


/*
		//verifier nationalite
		if (!isset($_POST['nationalite']) || (empty($_POST['nationalite'])))
		{
			Notif::set('msgAddSituation', "La situation n'a pas pu etre ajoutee (nationalite)");
			return;
		}
		$nationalite = $_POST['nationalite'];

		//verifier us_person
		if (!isset($_POST['us_person']) ||
			(
				$_POST['us_person'] != "0" &&
				$_POST['us_person'] != "1"
			)
		)
		{
			Notif::set('msgAddSituation', "La situation n'a pas pu etre ajoutee (us_person)");
			return;
		}
		$us_person = intval($_POST['us_person']);

		//verifier politique
		if (!isset($_POST['politique']) ||
			(
				$_POST['politique'] != "0" &&
				$_POST['politique'] != "1"
			)
		)
		{
			Notif::set('msgAddSituation', "La situation n'a pas pu etre ajoute (politique)");
			return;
		}
		$politique = intval($_POST['politique']);
		*/

		//verifier representant
		if (!isset($_POST['representant']) || strlen($_POST['representant']) == 0)
		{
			Notif::set('msgAddSituation', "La situation n'a pas pu etre ajoutee (representant)");
			return;
		}
		$representant = intval($_POST['representant']);

		$qualite_de = "Gerant";
		$id_gerant = 0;
		if ($representant == -1)
		{
			$id_gerant = $this->dh->lien_phy;
			//Moi meme
		}
		else if ($representant == 0)
		{
			//Autre
			//verifier siege_social
			if (
				!isset($_POST['representantCivilite']) || (empty($_POST['representantCivilite'])) ||
				!isset($_POST['representantNom']) || (empty($_POST['representantNom'])) ||
				!isset($_POST['representantPrenom']) || (empty($_POST['representantPrenom']))
			)
			{
				Notif::set('msgAddSituation', "La situation n'a pas pu etre ajoutee (siege_social)");
				return;
			}
			$civiliteGerant = htmlspecialchars($_POST['representantCivilite']);
			$nomGerant = htmlspecialchars($_POST['representantNom']);
			$prenomGerant = htmlspecialchars($_POST['representantPrenom']);

			$id_gerant = Pp::insertMini($this->dh->id_dh, $civiliteGerant, $prenomGerant, $nomGerant);
			if (empty($id_gerant))
			{
				Notif::set("addProject", "Le projet n'a pas pu etre ajoute");
				return;
			}
			//verifier qualite_de
			if (!isset($_POST['qualite_de']) || (empty($_POST['qualite_de'])))
			{
				Notif::set('msgAddSituation', "La situation n'a pas pu etre ajoutee (qualite_de)");
				return;
			}
			$qualite_de = htmlspecialchars($_POST['qualite_de']);
		}
		else if ($representant > 0)
		{
			$id_gerant = $representant;
			//verifier qualite_de
			if (!isset($_POST['qualite_de']) || (empty($_POST['qualite_de'])))
			{
				Notif::set('msgAddSituation', "La situation n'a pas pu etre ajoutee (qualite_de)");
				return;
			}
			$qualite_de = htmlspecialchars($_POST['qualite_de']);
		}

		$rt = $this->Pm->updateOneColumn("dn_sociale", $dn_sociale);
		if (!$rt)
		{
			Notif::set('msgAddSituation', "La situation n'a pas pu etre ajoute (update Situation)");
			return;
		}
		$rt = $this->Pm->updateOneColumn("f_juridique", $f_juridique);
		if (!$rt)
		{
			Notif::set('msgAddSituation', "La situation n'a pas pu etre ajoute (update Situation)");
			return;
		}
		$rt = $this->Pm->updateOneColumn("siret", $siret);
		if (!$rt)
		{
			Notif::set('msgAddSituation', "La situation n'a pas pu etre ajoute (update Situation)");
			return;
		}
		$rt = $this->Pm->updateOneColumn("rcs", $rcs);
		if (!$rt)
		{
			Notif::set('msgAddSituation', "La situation n'a pas pu etre ajoute (update Situation)");
			return;
		}

		//$rt = $this->dh->getPersonnePhysique()->updateOneColumn("us_person", $us_person);
		//$rt = $this->dh->getPersonnePhysique()->updateOneColumn("politiquement_expose", $politique);
		if (!$rt)
		{
			Notif::set('msgAddSituation', "La situation n'a pas pu etre ajoute (update Situation)");
			return;
		}

		$rt = $this->Pm->insertSituationJuridique(
			time(),
			time() + TIME_SITUATION_VALID,
			$activite,
			$representant,
			$qualite_de,
			$siege_social,
			$id_gerant//,
			//$nationalite
		);
		if (!$rt)
		{
			Notif::set('msgAddSituation', "La situation n'a pas pu etre ajoute (insert Situation)");
			return;
		}

		/*
			$rt = Pm::getFromId($_POST['id_pm'])[0]->insertSituationJuridique(time(), time() + TIME_SITUATION_VALID, 
			);
		*/

//		Notif::set('msgAddSituation', "Votre situation juridique a bien ete enregistree");
		header("Location: ?p=" . $GLOBALS['GET']['p'] . "&projet=" . $GLOBALS['GET']['projet']);
		exit();
	}
}
