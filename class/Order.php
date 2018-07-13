<?php
/**
 * Created by PhpStorm.
 * User: vthomas
 * Date: 09/10/2017
 * Time: 10:32
 */

require_once("core/Database.php");
require_once("core/Table.php");

class Order extends table
{
    protected static	$_name = "scpi_order";
    protected static	$_primary_key = "id";

    public static function getAllForStore() {
        $tmp = self::getAll();
        return $tmp;
        $i = 0;
        //`date` >= curdate() - INTERVAL DAYOFWEEK(curdate())+6 DAY AND
        $req = "SELECT t.* FROM `mscpi_db`.`scraping_history` t WHERE `date` >= curdate() - INTERVAL DAYOFWEEK(curdate())+6 DAY AND `id_scpi` = :id AND `is_sell` = :type LIMIT 40";
        foreach ($tmp as $line)
        {
            $hist = new stdClass();
            $hist->achat = Database::prepare(static::$_db, $req, ['id' => $line->id_scpi, 'type' => 0], get_called_class());
            $hist->vente = Database::prepare(static::$_db, $req, ['id' => $line->id_scpi, 'type' => 1], get_called_class());
/* ****************************************************************************************************************** */
            $max = count($hist->achat);
            $achat = [];
            if ($max != 0)
            {
                $date_elm = $hist->achat[0]->date;
                $vol = 0.0;
                $i = 0;
                foreach ($hist->achat as $subline)
                {
                    if (++$i === $max || $date_elm != $subline->date)
                    {
                        $achat[] = $vol;
                        $vol = 0.0;
                        $date_elm = $subline->date;
                    }
                    $vol += floatval($subline->nb_part) * floatval($subline->price);
                }
            }
            else
                $achat = [0.0];
/* ****************************************************************************************************************** */
            $max = count($hist->vente);
            $vente = [];
            if ($max != 0)
            {
                $date_elm = $hist->vente[0]->date;
                $vol = 0.0;
                $i = 0;
                foreach ($hist->vente as $subline)
                {
                    if (++$i === $max || $date_elm != $subline->date)
                    {
                        $vente[] = $vol;
                        $vol = 0.0;
                        $date_elm = $subline->date;
                    }
                    $vol += floatval($subline->nb_part) * floatval($subline->price);
                }
            }
            else
                $vente = [0.0];
/* ****************************************************************************************************************** */
            $hist->achat = $achat;
            $hist->vente = $vente;
            $tmp[$i]->hist = $hist;
            $i++;
        }
        return ($tmp);
    }

    public static function updateData($data) {
        $req = "UPDATE `scpi_scrap_list` SET `disabled` = :disabled,`error` = :error WHERE `id`=:id";
        $data['disabled'] = $data['disabled'] == "0" ? 0 : 1;
        $bind = [
            "id" => $data['id'],
            "disabled" => ($data['disabled']),
            "error" => $data['error']
        ];
        if (Database::prepareNoClass(static::$_db, $req, $bind));
			success(["data" => $bind]);
        return (0);
    }
}
