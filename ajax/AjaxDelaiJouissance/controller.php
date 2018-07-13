<?php
require_once("class/core/Ajax.php");
class AjaxDelaiJouissance extends Ajax
{
	public function removeOne($id) {
		DelaiJouissance::removeFromId($id);
	}
	public function saveOrUpdate($data) {
		foreach($data as $key => $elm)
		{
			if ($elm['id'] == 0)
			{
				DelaiJouissance::insertNew(
					$elm['id_scpi'],
					$elm['value'],
					$elm['unite'],
					$elm['value_vente'],
					$elm['unite_vente'],
					$elm['date_execution']
				);
			}
			else
			{
				$delai = DelaiJouissance::getFromId($elm['id']);
				if (empty($delai))
					continue ;
				$delai = $delai[0];
				$delai->updateOneColumn("value", $elm['value']);
				$delai->updateOneColumn("unite", $elm['unite']);
				$delai->updateOneColumn("value_vente", $elm['value_vente']);
				$delai->updateOneColumn("unite_vente", $elm['unite_vente']);
				$delai->updateOneColumn("date_execution", $elm['date_execution']);
			}
		}
		//echo json_encode($data);
	}
}
