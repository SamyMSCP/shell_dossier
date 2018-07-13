<?php
/**
 * Created by PhpStorm.
 * User: vthomas
 * Date: 19/12/2017
 * Time: 16:46
 */

require_once ("core/Database.php");

class MailChimpDb extends Table
{
	protected static $_name = "";
	protected static $_primary_key = "id";

	public function __construct()
	{
	}

	public function getMessage($g_name, $new, $addon) {
		if ($new){
			return ("Andréa : Merci de recontacter le client et de l'attribuer 1/2 Jonathan|Camille\n\
		La civilité retournée est possiblement invalide. Vérifier la valeur manuemement\n\
		Le client se montre intéresser par un guide : " . $g_name . "\n\
		Le client client envisage d'investir en SCPI et souhaite être recontacter : " . $g_name);
		}
		return ("Le client se montre intéresser par un guide : " . $g_name . $addon);
	}

	public function getAllLast()
	{
		$req = "SELECT * FROM `" . static::$_name . "`";
		return (Database::prepareNoClass(static::$_db, $req, []));
	}

	public function AddUser($user)
	{
		try {
			if (Database::prepareNoClass(static::$_db, "SELECT * FROM " . static::$_name . " WHERE `id_mc` = :id_mc", $user) === 0) {
				$req = "INSERT INTO `" . static::$_name . "` (`id`, `id_mc`) VALUES (NULL, :id_mc);";
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