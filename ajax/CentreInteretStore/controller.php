<?php
require_once("class/core/Ajax.php");
require_once("class/CentreInteret.php");
class CentreInteretStore extends Ajax
{

	public function createCentreInteret($data)
	{
		$err = "Donnée manquante";
		if (!empty($data['nom']))
		{
			if (($id_ci = CentreInteret::insertNew( $data['nom'])))
			{
				if (($ci = CentreInteret::getFromId($id_ci)[0]))
					success($ci);
			}
			else
				$err = "Enregistrement impossible";
		}
		error($err);
	}

	public function updateCentreInteret($data)
	{
		$err = "Donnée manquante";
		if (!empty($data['id']) && !empty($data['nom']))
		{
			if (($ci = CentreInteret::getFromId($data['id'])[0]))
			{
				if ($ci->visible != $data['visible'])
					$ci->updateOneColumn("visible", !empty($data['visible']));
				if ($ci->updateOneColumn("nom", $data['nom']))
					success($ci);
				$err = "Enregistrement impossible";
			}
			else
				$err = "Non trouvé";
		}
		error($err);
	}

	public function deleteCentreInteret($data)
	{
		$err = "Donnée manquante";
		if (!empty($data['id']))
		{
			if (($ci = CentreInteret::getFromId($data['id'])[0]))
			{
				if ($ci->deleteMe())
					success($data['id']);
				$err = "Enregistrement impossible";
			}
			else
				$err = "Non trouvé";
		}
		error($err);
	}
}