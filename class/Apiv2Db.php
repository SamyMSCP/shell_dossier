<?php
/**
 * Created by PhpStorm.
 * User: florian
 * Date: 15/05/2018
 * Time: 10:06
 */



require_once ("core/Database.php");

class Apiv2Db extends Table
{
    protected static $_name = "guide_list_api_scpi";
    protected static $_primary_key = "id";
    public function __construct()
    {
    }

   /* public function getMessage($g_name, $addon) {

        return ("Le client se montre intéresser par un guide : " . $g_name . $addon);
    }
*/
    public function getAllLast()
    {
        $req = "SELECT * FROM `" . static::$_name . "`";
        return (Database::prepareNoClass(static::$_db, $req, []));
    }

    public function AddUser($user, $val, $typeComp, $origin, $date)
    {
        try {

            if (Database::prepareNoClass(static::$_db, "SELECT * FROM `" . static::$_name . "` WHERE `id_api` = :id_api", $user) === 0) {
                $req = "INSERT INTO `" . static::$_name . "` (`id`, `id_api`, `type`, `type_complement`, `origin`, `day`) VALUES (NULL, :id_api, '".$val."','".$typeComp."','".$origin."','".$date."');";
                Database::prepareNoClass(static::$_db, $req, $user);
                return (true);
            }
            else
                return (false);
        } catch (Exception $e) {
            echo $e;
            return (false);
        }
    }
}