<?php
require_once("class/core/Module.php");
class SetProject extends Module
{
	public function setNewProject() {

		if (!isset($_POST['listObjectif']) || !isset($_POST['res']) || !isset($_POST['invest'])  || !isset($_POST['forwhom']))
		{
			Notif::set("addProject", "Le projet n'a pas pu etre ajouté");
			return;
		}
		$listObjectif = json_decode($_POST['listObjectif']);
		if (count($listObjectif) != 3)
		{
			Notif::set("addProject", "Le projet n'a pas pu etre ajouté");
			return;
		}

		$haveAutre = false;

		foreach ($listObjectif as $key => $elm)
		{
			if ($elm == 8)
				$haveAutre = true;
			if ($elm < 1 || $elm > 8)
			{
				Notif::set("addProject", "Le projet n'a pas pu etre ajouté");
				return;
			}
		}
		if ($haveAutre && !isset($_POST['objectif_autre']))
		{
			Notif::set("addProject", "Le projet n'a pas pu etre ajouté");
			return;
		}

		$listObjectif = serialize($listObjectif);

		$invest = intval($_POST['invest']);

		$origine = [
			"1" => isset($_POST['origine-1']),
			"2" => isset($_POST['origine-2']),
			"3" => isset($_POST['origine-3']),
			"4" => isset($_POST['origine-4']),
			"5" => isset($_POST['origine-5']),
			"6" => isset($_POST['origine-6']),
			"7" => isset($_POST['origine-7']),
			"8" => isset($_POST['origine-8']),
		];

		$origine = serialize($origine);

		$res = intval($_POST['res']);

		if ($invest < 1 || $invest > 5)
		{
			Notif::set("addProject", "Le projet n'a pas pu etre ajouté");
			return;
		}
		/*
		if ($origine < 1 || $origine > 8)
		{
			Notif::set("addProject", "Le projet n'a pas pu etre ajouté");
			return;
		}
		*/


		if ($res != 1 && $res != 0 && $res != 2)
		{
			Notif::set("addProject", "Le projet n'a pas pu etre ajouté");
			return;
		}
		$res_2 = 0;
		if ($res == 1)
		{
			if (!isset($_POST['res_2']))
			{
				Notif::set("addProject", "Le projet n'a pas pu etre ajouté");
				return;
			}
			$res_2 = $_POST['res_2'];
			if ($res_2 != 1 && $res_2 != 0)
			{
				Notif::set("addProject", "Le projet n'a pas pu etre ajouté");
				return;
			}
		}
		//Verification que toutes les donnees sont bien presentes

		$dhType = Dh::getCurrent()->getType();
		if ($_POST['forwhom'] == 1)
		{
			//code pour ajouter un projet pour le dh
			$Pp = $this->dh->getPersonnePhysique();
			$ben = $Pp->getBeneficiaireSeul();
			if (count($ben) == 0) //verification si le Pp du Dh est deja assigne a un Beneficiaire seul
			{
				$ben = Beneficiaire::insertIsPp($this->dh->id_dh, 'seul', array($Pp->id_phs));
			}
			else
				$ben = $ben[0]->id_benf;
			if (empty($ben))
			{
				Notif::set("addProject", "Le projet n'a pas pu etre ajouté");
				return;
			}
			$rt = Projet::insertNew($ben, $this->dh->conseiller, "-", $listObjectif, $invest, $res, $res_2, $origine);
			if ($haveAutre)
			{
				$proj = Projet::getFromId($rt)[0];
				$proj->updateOneColumn("objectif_autre", $_POST['objectif_autre']);
			}
			if (empty($rt))
			{
				Notif::set("addProject", "Le projet n'a pas pu etre ajouté");
				return;
			}
			else
			{
				if ($dhType == null || $dhType == "client")
					header("Location: ?p=InfoProjet&projet=" . encrypt_url($rt));
				else
					header("Location: ?p=InfoProjetAdmin&projet=" . encrypt_url($rt) . "&client=" . intval($GLOBALS['GET']['client']));
				exit();
			}

		}
		else if ($_POST['forwhom'] == 2)
		{
			$Pp = $this->dh->getPersonnePhysique();
			$ben = $Pp->getBeneficiaireCouple();
			if (count($ben) == 0) // on verifie si le Dh a un beneficiaire pour son couple
			{
				if (!isset($_POST['compteConjoin']))
				{
					Notif::set("addProject", "Le projet n'a pas pu etre ajouté");
					return;
				}
				$Pp2 = intval($_POST['compteConjoin']);
				if ($Pp2 == 0) // on verifie si le conjoin existe
				{
					// Check des infos necessaires pour en ajouter un;
					if (!isset($_POST['conjoinCivilite']) || !isset($_POST['conjoinName']) || !isset($_POST['conjoinFirstName']))
					{
						Notif::set("addProject", "Le projet n'a pas pu etre ajouté");
						return;
					}
					// on cree un Pp pour le conjoin du Dh
					$Pp2 = Pp::insertMini($this->dh->id_dh, $_POST['conjoinCivilite'], $_POST['conjoinFirstName'], $_POST['conjoinName']);
					if (empty($Pp2))
					{
						Notif::set("addProject", "Le projet n'a pas pu etre ajouté");
						return;
					}
				}
				else
				{
					$checkPp2 = Pp::getFromId($Pp2);
					//Check si le Pp renseigne existe bien et si il appartien bien a ce Dh
					if (!(count($checkPp2) && $checkPp2[0]->lien_dh == $this->dh->id_dh))
					{
						Notif::set("addProject", "Le projet n'a pas pu etre ajouté");
						return;
					}
				}
				$ben = Beneficiaire::insertIsPp($this->dh->id_dh, 'couple', array($Pp->id_phs, $Pp2));
			}
			else
				$ben = $ben[0]->id_benf;
			if (empty($ben))
			{
				Notif::set("addProject", "Le projet n'a pas pu etre ajouté");
				return;
			}
			$rt = Projet::insertNew($ben, $this->dh->conseiller, "-", $listObjectif, $invest, $res, $res_2, $origine);
			if ($haveAutre)
			{
				$proj = Projet::getFromId($rt)[0];
				$proj->updateOneColumn("objectif_autre", $_POST['objectif_autre']);
			}
			if (empty($rt))
			{
				Notif::set("addProject", "Le projet n'a pas pu etre ajouté");
				return;
			}
			else
			{
				if ($dhType == null || $dhType == "client")
					header("Location: ?p=InfoProjet&projet=" . encrypt_url($rt));
				else
					header("Location: ?p=InfoProjetAdmin&projet=" . encrypt_url($rt) . "&client=" . intval($GLOBALS['GET']['client']));
				exit();
			}
		}
		else if ($_POST['forwhom'] == 3)
		{
			$Pp2 = intval($_POST['compteParent']);
			if ($Pp2 == 0) // on verifie si le conjoin existe
			{
				// Check des infos necessaires pour en ajouter un;
				if (!isset($_POST['parentCivilite']) || !isset($_POST['parentName']) || !isset($_POST['parentFirstName']))
				{
					Notif::set("addProject", "Le projet n'a pas pu etre ajouté");
					return;
				}
				// on cree un Pp pour le conjoin du Dh
				$Pp2 = Pp::insertMini($this->dh->id_dh, $_POST['parentCivilite'], $_POST['parentFirstName'], $_POST['parentName']);
				if (empty($Pp2))
				{
					Notif::set("addProject", "Le projet n'a pas pu etre ajouté");
					return;
				}
				//on cree un Pp pour le parent
				$Pp2 = Pp::getFromId($Pp2)[0];
			}
			else
			{
				$Pp2 = Pp::getFromId($Pp2);
				//Check si le Pp renseigne existe bien et si il appartien bien a ce Dh
				if (!(count($Pp2) && $Pp2[0]->lien_dh == $this->dh->id_dh))
				{
					Notif::set("addProject", "Le projet n'a pas pu etre ajouté");
					return;
				}
				$Pp2 = $Pp2[0];
			}
			$ben = $Pp2->getBeneficiaireSeul();
			if (count($ben) == 0) //verification si le Pp du Dh est deja assigne a un Beneficiaire seul
				$ben = Beneficiaire::insertIsPp($this->dh->id_dh, 'seul', array($Pp2->id_phs));
			else
				$ben = $ben[0]->id_benf;
			if (empty($ben))
			{
				Notif::set("addProject", "Le projet n'a pas pu etre ajouté");
				return;
			}
			//code pour ajouter un projet pour le beneficiaire du parent du Dh
			$rt = Projet::insertNew($ben, $this->dh->conseiller, "-", $listObjectif, $invest, $res, $res_2, $origine);
			if ($haveAutre)
			{
				$proj = Projet::getFromId($rt)[0];
				$proj->updateOneColumn("objectif_autre", $_POST['objectif_autre']);
			}
			if (empty($rt))
			{
				Notif::set("addProject", "Le projet n'a pas pu etre ajouté");
				return;
			}
			else
			{
				if ($dhType == null || $dhType == "client")
					header("Location: ?p=InfoProjet&projet=" . encrypt_url($rt));
				else
					header("Location: ?p=InfoProjetAdmin&projet=" . encrypt_url($rt) . "&client=" . intval($GLOBALS['GET']['client']));
				exit();
			}
		}
		else if ($_POST['forwhom'] == 6)
		{
			$Pp2 = intval($_POST['compteEnfant']);
			if ($Pp2 == 0) 			{
				if (!isset($_POST['enfantCivilite']) || !isset($_POST['enfantName']) || !isset($_POST['enfantFirstName']))
				{
					Notif::set("addProject", "Le projet n'a pas pu etre ajouté");
					return;
				}
				//on cree un Pp pour l'enfant
				$Pp2 = Pp::insertMini($this->dh->id_dh, $_POST['enfantCivilite'], $_POST['enfantFirstName'], $_POST['enfantName']);
				if (empty($Pp2))
				{
					Notif::set("addProject", "Le projet n'a pas pu etre ajouté");
					return;
				}
				$Pp2 = Pp::getFromId($Pp2)[0];
				$Pp2->updateOneColumn("enfant", 1);
			}
			else
			{
				$Pp2 = Pp::getFromId($Pp2);
				//Check si le Pp renseigne existe bien et si il appartien bien a ce Dh
				if (!(count($Pp2) && $Pp2[0]->lien_dh == $this->dh->id_dh))
				{
					Notif::set("addProject", "Le projet n'a pas pu etre ajouté");
					return;
				}
				$Pp2 = $Pp2[0];
			}
			$ben = $Pp2->getBeneficiaireSeul();
			if (count($ben) == 0) //verification si le Pp du Dh est deja assigne a un Beneficiaire seul
				$ben = Beneficiaire::insertIsPp($this->dh->id_dh, 'seul', array($Pp2->id_phs));
			else
				$ben = $ben[0]->id_benf;
			if (empty($ben))
			{
				Notif::set("addProject", "Le projet n'a pas pu etre ajouté");
				return;
			}
			//code pour ajouter un projet pour le beneficiaire du parent du Dh
			$rt = Projet::insertNew($ben, $this->dh->conseiller, "-", $listObjectif, $invest, $res, $res_2, $origine);
			if ($haveAutre)
			{
				$proj = Projet::getFromId($rt)[0];
				$proj->updateOneColumn("objectif_autre", $_POST['objectif_autre']);
			}
			if (empty($rt))
			{
				Notif::set("addProject", "Le projet n'a pas pu etre ajouté");
				return;
			}
			else
			{
				if ($dhType == null || $dhType == "client")
					header("Location: ?p=InfoProjet&projet=" . encrypt_url($rt));
				else
					header("Location: ?p=InfoProjetAdmin&projet=" . encrypt_url($rt) . "&client=" . intval($GLOBALS['GET']['client']));
				exit();
			}
		}
		else if ($_POST['forwhom'] == 4)
		{
			$Pm = intval($_POST['compteEntreprise']);
			if ($Pm == 0) // on verifie si le conjoin existe
			{
				if (!isset($_POST['entrepriseName']))
				{
					Notif::set("addProject", "Le projet n'a pas pu etre ajouté");
					return;
				}
				$Pm = Pm::insertMini($this->dh->id_dh, $_POST['entrepriseName']);
				if (empty($Pm))
				{
					Notif::set("addProject", "Le projet n'a pas pu etre ajouté");
					return;
				}
				//on cree un Pm pour l'entreprise duDh
				$Pm = Pm::getFromId($Pm)[0];
			}
			else
			{
				$Pm = Pm::getFromId($Pm);
				//Check si le Pp renseigne existe bien et si il appartien bien a ce Dh
				if (!(count($Pm) && $Pm[0]->lien_dh == $this->dh->id_dh))
				{
					Notif::set("addProject", "Le projet n'a pas pu etre ajouté");
					return;
				}
				$Pm = $Pm[0];
			}
			$ben = $Pm->getBeneficiaire();
			if (count($ben) == 0) // Si l'entreprise n'a pas de beneficiaire
				$ben = Beneficiaire::insertIsPm($this->dh->id_dh, $Pm->id_pm);
			else
				$ben = $ben[0]->id_benf;
			if (empty($ben))
			{
				Notif::set("addProject", "Le projet n'a pas pu etre ajouté");
				return;
			}
			//code pour ajouter un projet pour le beneficiaire du parent du Dh
			$rt = Projet::insertNewPm($ben, $this->dh->conseiller, "-", $listObjectif, $invest, $res, $res_2, $origine);
			if ($haveAutre)
			{
				$proj = Projet::getFromId($rt)[0];
				$proj->updateOneColumn("objectif_autre", $_POST['objectif_autre']);
			}
			if (empty($rt))
			{
				Notif::set("addProject", "Le projet n'a pas pu etre ajouté");
				return;
			}
			else
			{
				if ($dhType == null || $dhType == "client")
					header("Location: ?p=InfoProjet&projet=" . encrypt_url($rt));
				else
					header("Location: ?p=InfoProjetAdmin&projet=" . encrypt_url($rt) . "&client=" . intval($GLOBALS['GET']['client']));
				exit();
			}
			//code pour ajouter le projet au beneficiaire de l'entreprise
		}
		else if ($_POST['forwhom'] == 5)
		{
			$Pp = $this->dh->getPersonnePhysique();
			$benC = $Pp->getBeneficiaireCouple();
			if (count($benC) == 0) // on verifie si le Dh a un beneficiaire pour son couple
			{
				if (!isset($_POST['compteConjoinSeul']))
				{
					Notif::set("addProject", "Le projet n'a pas pu etre ajouté");
					return;
				}
				$Pp2 = intval($_POST['compteConjoinSeul']);
				if ($Pp2 == 0) // on verifie si le conjoin existe
				{
					// Check des infos necessaires pour en ajouter un;
					if (!isset($_POST['conjoinSeulCivilite']) || !isset($_POST['conjoinSeulName']) || !isset($_POST['conjoinSeulFirstName']))
					{
						Notif::set("addProject", "Le projet n'a pas pu etre ajouté");
						return;
					}
					// on cree un Pp pour le conjoin du Dh
					$Pp2 = Pp::insertMini($this->dh->id_dh, $_POST['conjoinSeulCivilite'], $_POST['conjoinSeulFirstName'], $_POST['conjoinSeulName']);
					if (empty($Pp2))
					{
						Notif::set("addProject", "Le projet n'a pas pu etre ajouté");
						return;
					}
				}
				else
				{
					$checkPp2 = Pp::getFromId($Pp2);
					//Check si le Pp renseigne existe bien et si il appartien bien a ce Dh
					if (!(count($checkPp2) && $checkPp2[0]->lien_dh == $this->dh->id_dh))
					{
						Notif::set("addProject", "Le projet n'a pas pu etre ajouté");
						return;
					}
				}
				$benC = Beneficiaire::insertIsPp($this->dh->id_dh, 'couple', array($Pp->id_phs, $Pp2));
				$ben = Beneficiaire::insertIsPp($this->dh->id_dh, 'seul', array($Pp2));
			}
			else
			{
				//On recupere le Pp qui correspond a la personne en couple du Dh
				$Pp2 = $benC[0]->getPersonnePhysique()[1];
				$ben = $Pp2->getBeneficiaireSeul();
				if (count($ben) == 0) //verification si le Pp du Dh est deja assigne a un Beneficiaire seul
					$ben = Beneficiaire::insertIsPp($this->dh->id_dh, 'seul', array($Pp2->id_phs));
				else
					$ben = $ben[0]->id_benf;
			}
			if (empty($ben))
			{
				Notif::set("addProject", "Le projet n'a pas pu etre ajouté");
				return;
			}
			$rt = Projet::insertNew($ben, $this->dh->conseiller, "-", $listObjectif, $invest, $res, $res_2, $origine);
			if ($haveAutre)
			{
				$proj = Projet::getFromId($rt)[0];
				$proj->updateOneColumn("objectif_autre", $_POST['objectif_autre']);
			}
			if (empty($rt))
			{
				Notif::set("addProject", "Le projet n'a pas pu etre ajouté");
				return;
			}
			else
			{
				if ($dhType == null || $dhType == "client")
					header("Location: ?p=InfoProjet&projet=" . encrypt_url($rt));
				else
					header("Location: ?p=InfoProjetAdmin&projet=" . encrypt_url($rt) . "&client=" . intval($GLOBALS['GET']['client']));
				exit();
			}
		}
		else
		{
			Notif::set("addProject", "Le projet n'a pas pu etre ajoute error global");
			return;
			//Error
		}
	}
}
