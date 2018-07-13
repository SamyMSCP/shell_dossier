<?php
/**
 * Created by PhpStorm.
 * User: vthomas
 * Date: 09/10/2017
 * Time: 16:01
 */

require_once("core/Database.php");
require_once("core/Table.php");

class OrderSociety extends table
{
    protected static	$_name = "scpi_society";
    protected static	$_primary_key = "id";

    public static function getAllForStore() {
        $tmp = self::getAll();
        return ($tmp);
    }
}