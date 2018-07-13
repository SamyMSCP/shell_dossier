<?php
/**
 * Created by PhpStorm.
 * User: vthomas
 * Date: 03/11/2017
 * Time: 17:27
 */

require_once("MailChimpDb.php");

class MailChimpDbGf extends MailChimpDb
{
	protected static $_name = "guide_list_gf";


	public function getMessage($g_name, $new, $addon) {
		if ($new){
			return ("Andréa : Merci de recontacter le client et de l'attribuer 1/2 Jonathan|Camille\n\
		La civilité retournée est possiblement invalide. Vérifier la valeur manuemement\n\
		Le client se montre intéresser par un guide : " . $g_name . "\\
		Le client client envisage d'investir en SCPI et souhaite être recontacter : " . $g_name);
		}
		return ("Demande de guide de groupement Forestier");
	}
}