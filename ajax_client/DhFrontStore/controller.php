<?php

require_once("class/core/AjaxClient.php");
class DhFrontStore extends AjaxClient
{
	private static function string_bool($str)
	{
		if ($str === "true")
			return true;
		if ($str === "false")
			return false;
		return null;
	}
	public function update_ci()
	{
		try
		{
			$params = $added = $removed = [];

			foreach ($this->dh->getCIForFrontStore() as $ci => $v)
			{
				if (self::string_bool($_POST['data']['ci'][$ci]) != $v)
				{
					$elt = CentreInteret::getFromId($ci)[0];
					if (self::string_bool($_POST['data']['ci'][$ci]))
					{
						$added[] = $elt->nom;
						DhCentreInteret::insertNew($this->dh->id_dh, $ci);
					}
					else
					{
						$removed[] = $elt->nom;
						DhCentreInteret::deleteFromKeysValues(['id_dh' => $this->dh->id_dh, 'id_ci' => $ci]);
					}
				}
			}
			if (!empty($added))
				$params['Ajout CI'] = implode('<br/>',$added);
			if (!empty($removed))
				$params['Retrait CI'] = implode('<br/>',$removed);
			Logger::setNew("Changement Centre Interet", $this->dh->id_dh, $this->dh->id_dh, $params);
			success(['ci' => $this->dh->getCIForFrontStore()]);
		}
		catch (Exception $e)
		{
			error("Une erreur est survenue !");
		}
	}

	public function update_ciscpi()
	{
		try
		{
			$params = $added = $removed = [];

			foreach ($this->dh->getCISCPIForFrontStore() as $ci => $v)
			{
				if (self::string_bool($_POST['data']['ciscpi'][$ci]) != $v)
				{
					if (self::string_bool($_POST['data']['ciscpi'][$ci]))
					{
						$added[] = Scpi::getFromId($ci)->name;
						DhCentreInteretSCPI::insertNew($this->dh->id_dh, $ci);
					}
					else
					{
						$removed[] = Scpi::getFromId($ci)->name;
						DhCentreInteretSCPI::deleteFromKeysValues(['id_dh' => $this->dh->id_dh, 'id_scpi' => $ci]);
					}
				}
			}
			if (!empty($added))
				$params['Ajout CI SCPI'] = implode('<br/>',$added);
			if (!empty($removed))
				$params['Retrait CI SCPI'] = implode('<br/>',$removed);
			Logger::setNew("Changement Centre Interet", $this->dh->id_dh, $this->dh->id_dh, $params);
			success(['ciscpi' => $this->dh->getCISCPIForFrontStore()]);
		}
		catch (Exception $e)
		{
			error("Une erreur est survenue !");
		}
	}

	public function precalcul()
	{
		success(["precalcul" => $this->dh->getPrecalculForFrontStore()]);
	}

	public function count_dh_ci()
	{
		if (!empty($_POST['data']))
			success(DhCentreInteret::countDhCI( $_POST['data'] ));
		error("You");
	}
	public function count_dh_ci_scpi()
	{
		if (!empty($_POST['data']))
			success(DhCentreInteretSCPI::countDhCISCPI( $_POST['data'] ));
		error("You");
	}
}
