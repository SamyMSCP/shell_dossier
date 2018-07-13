<?php
/**
 * Created by PhpStorm.
 * User: vthomas
 * Date: 29/11/2017
 * Time: 13:35
 */

require_once "core/Table.php";

class OrderHistoric extends Table
{
	static function getAllDataScpi()
	{

		$req = "SELECT id FROM `scpi_scrap_list`";//Retourne la liste des ID

		$all_id = Database::prepare(static::$_db, $req, [], get_called_class());

		$data = [];
		//Requete de recup de l'historique en fonction de l'id de la SCPI
		$req = "SELECT sl.name, sl.id,
			`hist`.`price`, `hist`.`nb_part`, 
			`hist`.`date` ,
			`hist`.`is_sell`
			FROM `scraping_history` hist, `scpi_scrap_list` sl 
			WHERE `hist`.`id_scpi` = `sl`.`id` AND `sl`.`id` = :id
			ORDER BY `hist`.`date` DESC
			LIMIT 400";
		//Get date GET MAX
		$max_date = 0;
		foreach ($all_id as $id) {
			$tmp = Database::prepare(static::$_db, $req, ["id" => $id->id], get_called_class());
			$tmp_buy = 0.0;
			$tmp_sell = 0.0;
			if (!isset($tmp[0]) || $tmp === NULL)
				continue;
			$last_date = strtotime($tmp[0]->date);
			$cur_scpi = [];
			//On parcours tout l'historique de la SCPI
			foreach ($tmp as $el) {
				//Verif qu'il s'agit bien de la meme entree (Meme jour)
				$max_date = (strtotime($el->date) > $max_date) ? strtotime($el->date) : $max_date;
				if (strtotime($el->date) != $last_date) {
					//Si pas meme jour. On sauvegarde l'entree et on reset
					$cur_scpi[date("d-m-Y", $last_date)] = [
						"sell" => $tmp_sell,
						"buy" => $tmp_buy,
						"date" => date("H:i:s d-m-Y", $last_date)];
					$last_date = strtotime($el->date);
					$tmp_buy = 0.0;
					$tmp_sell = 0.0;
				}
				if ($el->is_sell === "1")//Ajout dans l'achat ou la vente en fonction
					$tmp_sell += $el->price * $el->nb_part;
				else
					$tmp_buy += $el->price * $el->nb_part;
			}
			//On ajoute une entree [id de scpi] avec l'historique de la SCPI en question
			$data["scpi_" . $id->id] = array_slice($cur_scpi, 0, 7);
			$data["scpi_" . $id->id]['name'] = $el->name;
		}
		$data['max'] = $max_date;
		return $data;
	}
	static function getAllCSV() {
//		$data = self::getAllDataScpi();

		$all_id = Database::prepare(static::$_db,  "SELECT id FROM `scpi_scrap_list`", [], get_called_class());
		$data = [];
		//Requete de recup de l'historique en fonction de l'id de la SCPI
		$req = "SELECT sl.name, sl.id,
			`hist`.`price`, `hist`.`nb_part`, 
			`hist`.`date` ,
			`hist`.`is_sell`
			FROM `scraping_history` hist, `scpi_scrap_list` sl 
			WHERE `hist`.`id_scpi` = `sl`.`id` AND `sl`.`id` = :id
			ORDER BY `hist`.`date` DESC
			LIMIT 400";
		$max_date = 0;
		foreach ($all_id as $id) {
			$tmp = Database::prepare(static::$_db, $req, ["id" => $id->id], get_called_class());
			if (!isset($tmp[0]) || $tmp === NULL)
				continue;
			$last_date = strtotime($tmp[0]->date);
			foreach ($tmp as $el) {
				//Verif qu'il s'agit bien de la meme entree (Meme jour)
				$max_date = (strtotime($el->date) > $max_date) ? strtotime($el->date) : $max_date;
				$data[] = $el;
			}
		}

		return ($data);
	}

}