<?php
/**
 * Created by PhpStorm.
 * User: vthomas
 * Date: 09/10/2017
 * Time: 10:32
 */

require_once("core/Database.php");
require_once("core/Table.php");

class OrderScrapList extends table
{
	protected static $_name = "scpi_scrap_list";
	protected static $_primary_key = "id";

	public static function getAllForStore()
	{
		$tmp = Database::prepare(static::$_db, "SELECT t.* FROM `mscpi_db`.`scpi_scrap_list` t ORDER BY t.`name`", [], get_called_class());
		//$tmp = self::getAll();
		$i = 0;
		//$cond = "`date` >= curdate() - INTERVAL DAYOFWEEK(curdate())+6 DAY AND";
		$cond = '';
		$req = "SELECT t.* FROM `mscpi_db`.`scraping_history` t WHERE $cond `id_scpi` = :id AND `is_sell` = :type ORDER BY `date` LIMIT 40 ";
		foreach ($tmp as $line) {
			$hist = new stdClass();
			$hist->achat = OrderScrapList::construct_array(Database::prepare(static::$_db, $req, ['id' => intval($line->id), 'type' => "0"], get_called_class()));
			//TODO: MAKE WEEK AVERAGE HERE
			$hist->vente = OrderScrapList::construct_array(Database::prepare(static::$_db, $req, ['id' => intval($line->id), 'type' => "1"], get_called_class()));
			//TODO: MAKE WEEK AVERAGE HERE
			$tmp[$i]->hist = $hist;
			$tmp[$i]->disabled = ($tmp[$i]->disabled == '0');
			$i++;
		}
		return ($tmp);
	}
   
	private static function construct_array($data)
	{
		$max = count($data);
		$ar = [];
		$vol = 0.0;
		$date_elm = time();
		if ($max != 0) {
			$date_elm = strtotime($data[0]->date);
			$j = 0;
			foreach ($data as $subline) {
				if ($date_elm != strtotime($subline->date)) {
					$obj_el = new stdClass();
					$obj_el->price = $vol;
					$obj_el->date = $date_elm;
					$ar[] = $obj_el;
					$vol = 0.0;
					$date_elm = strtotime($subline->date);
				}
				$vol += floatval($subline->nb_part) * floatval($subline->price);
			}
		}
		$obj_el = new stdClass();
		$obj_el->price = $vol;
		$obj_el->date = $date_elm;
		$ar[] = $obj_el;

		usort($ar, "data_sort");
		return ($ar);
	}
 	public static function getImage($id)
	{
		$req = "SELECT `img_a`, `img_v` FROM `scpi_scrap_list` WHERE `id` = :id";
		return (Database::prepare(static::$_db, $req, ['id' => intval($id)], get_called_class()));
	}
}

function data_sort($a, $b)
{
	return $a->date < $b->date;
}

