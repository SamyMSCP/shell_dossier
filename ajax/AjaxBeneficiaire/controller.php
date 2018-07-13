<?php
require_once("class/core/Ajax.php");
class AjaxBeneficiaire extends Ajax
{
	public function AddBeneficiaire($data)
	{
			$rt = false;
		$dh = null;
		if (!empty($data['id_dh']))
		{
			$dh = Dh::getById($data['id_dh']);
			if (empty($dh))
				$dh = null;
		}
		if (!is_null($dh))
		{
			if ($data['typeBenef'] == 'seul' || $data['typeBenef'] == 'couple')
			{
				if (!empty($data['relBenef']))
				{
					if ($data['relBenef'] == 'null' || $data['relBenef'] == 'couple')
						$id_pp_1 = $dh->getPersonnePhysique()->id_phs;
					else if (!empty($data['civ1']) && !empty($data['nom1']) && !empty($data['prenom1']))
						$id_pp_2 = Pp::insertMini($dh->id_dh, $data['civ1'], $data['prenom1'], $data['nom1']);
				}
			}
			if ($data['typeBenef'] == 'couple')
			{
				if (!empty($data['relBenef']) && !empty($id_pp_1) && !empty($data['civ2']) && !empty($data['nom2']) && !empty($data['prenom2']))
					$id_pp_2 = Pp::insertMini($dh->id_dh, $data['civ2'], $data['prenom2'], $data['nom2']);
			}
			else if ($data['typeBenef'] == 'Pm')
			{
				if (!empty($data['relBenef']) && !empty($data['denomCommer']))
					$id_pm = Pm::insertMini($dh->id_dh, $data['denomCommer']);
			}
			if (!empty($id_pp_1))
			{
				if (!empty($id_pp_2))
					$rt = Beneficiaire::insertFromRelation($dh->id_dh, $data['relBenef'], [$id_pp_1, $id_pp_2]);
				$rt = Beneficiaire::insertFromRelation($dh->id_dh, $data['relBenef'], [$id_pp_1]);
			}
			else if (!empty($id_pm))
				$rt = Beneficiaire::insertFromRelation($dh->id_dh, $data['relBenef'], [$id_pm]);
		}
		if (!$rt)
			error(['KO']);
		success([$rt]);
	}
}