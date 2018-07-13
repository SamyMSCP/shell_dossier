<?php
require_once("class/core/Ajax.php");
class AddBeneficiaireSeul extends Ajax
{
	public function Add($data) {
		/*
			Données attendues :


		*/

		if (
			!isset($data['id']) ||
			!isset($data['id_dh'])
		)
			error('La requete est mal formatée');

		$id_phs = intval($data['id']);
		$id_dh = intval($data['id_dh']);
		$Pp = Pp::getFromId($id_phs);

		if (empty($Pp))
			error('Il y a eu un erreur lors de l\'ajout du Béneficiaire');
		$Pp = $Pp[0];

		if (
			$Pp->lien_dh != intval($id_dh) ||
			$Pp->id_dh != intval($_GLOBALS['GET'])
		)
			error('La requete est mal formatée');


		$type_beneficiaire = 'seul';
		$lst_Pp = [$id_phs];

		$beneficiaire = Beneficiaire::insertIsPp($id_dh, $type_beneficiaire, $lst_Pp);
		if (empty($beneficiaire))
			error("L'insertion à échouée");

		$dh = Dh::getById($id_dh);
		$rt = $dh->getPersonnePhysiqueForStore();
		success([$rt]);
	}
	
}
