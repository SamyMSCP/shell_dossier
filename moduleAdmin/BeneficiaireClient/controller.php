<?php
require_once("class/core/ModuleAdmin.php");
class BeneficiaireClient extends ModuleAdmin
{
	private function getOrCreatePm($data, $prefix = null) {
		if ($data === "new")
		{
			$id_Pm = Pm::insert(
				$_POST['idClient'],
				$_POST[$prefix . 'Denomination'],
				"",
				""
			);
			return ($id_Pm);
		}
		else
		{
			$Pm = Pm::getFromId($data);
			if (count($Pm) && ($Pm[0]->lien_dh == $_POST['idClient']))
				return $data;
		}
		return null;
	}
	private function getOrCreatePp($data, $prefix = null) {
		if ($data === "new")
		{
			$id_Pp = Pp::insert(
				$_POST['idClient'],
				$_POST[$prefix . 'Civilite'],
				$_POST[$prefix . 'Prenom'],
				$_POST[$prefix . 'Nom'],
				$_POST[$prefix . 'Mail'],
				"-",
				"-",
				"-",
				"-",
				"-",
				"-",
				"-"
			);
			return ($id_Pp);
		}
		else
		{
			$Pp = Pp::getFromId($data);
			if (count($Pp) && ($Pp[0]->lien_dh == $_POST['idClient']))
				return $data;
		}
		echo "Il y a un probleme";
		return null;
	}
	private function insertNewBeneficiairePp() {
		if (isset($_POST['formBeneficiairePp']) && $_POST['formBeneficiairePp'] === "seul")
		{
			// On ajoute un personne seul
			// Il faut verifier que ce beneficiaire n'existe pas deja!
			$id_Pp = null;
			if (isset($_POST['formTypeBeneficiairePpSeul']))
			{
				$id_Pp = $this->getOrCreatePp($_POST['formTypeBeneficiairePpSeul'], "formBeneficiaireSeul");
				$rt = Beneficiaire::insertIsPp($_POST['idClient'],  $_POST['formBeneficiairePp'], array($id_Pp));
				return $rt;
			}
		}
		else if (isset($_POST['formBeneficiairePp']) && $_POST['formBeneficiairePp'] === "couple")
		{
			// on ajoute un couple
			$id_Pp1 = null;
			$id_Pp2 = null;
			if (isset($_POST['formTypeBeneficiairePpCouple1']) && isset($_POST['formTypeBeneficiairePpCouple2']))
			{
				$id_Pp1 = $this->getOrCreatePp($_POST['formTypeBeneficiairePpCouple1'], "formBeneficiaireCouple1");
				$id_Pp2 = $this->getOrCreatePp($_POST['formTypeBeneficiairePpCouple2'], "formBeneficiaireCouple2");
				$rt = Beneficiaire::insertIsPp($_POST['idClient'],  $_POST['formBeneficiairePp'], array($id_Pp1, $id_Pp2));
				return $rt;
			}
		}
		return false;
	}
	private function insertNewBeneficiairePm() {
		$id_Pm = null;
		if (isset($_POST['formBeneficiairePm']))
		{
			$id_Pm = $this->getOrCreatePm($_POST['formBeneficiairePm'], "formBeneficiaireMorale");
			$rt = Beneficiaire::insertIsPm($_POST['idClient'], $id_Pm);
			//Notif::set('provisoire', 'Creation dune nouvelle personne morale : ' . $id_Pm);
			return ($rt);
		}
		return (false);
	}
	public function insertNewBeneficiaire() {
		if (isset($_POST['formTypeBeneficiaire']) && $_POST['formTypeBeneficiaire'] === "Pp")
			return ($this->insertNewBeneficiairePp());
		else if (isset($_POST['formTypeBeneficiaire']) && $_POST['formTypeBeneficiaire'] === "Pm")
			return ($this->insertNewBeneficiairePm());
		return (false);
	}
}
