<?php
/*      __  __        _  _  _                          */
/*     |  \/  |  ___ (_)| || |  ___  _   _  _ __  ___  */
/*     | |\/| | / _ \| || || | / _ \| | | || '__|/ _ \ */
/*     | |  | ||  __/| || || ||  __/| |_| || |  |  __/ */
/*     |_|  |_| \___||_||_||_| \___| \__,_||_|   \___| */
/*                        _                            */
/*      ___   ___  _ __  (_)    ___  ___   _ __ ___    */
/*     / __| / __|| '_ \ | |   / __|/ _ \ | '_ ` _ \   */
/*     \__ \| (__ | |_) || | _| (__| (_) || | | | | |  */
/*     |___/ \___|| .__/ |_|(_)\___|\___/ |_| |_| |_|  */
/*                |_|                                  */

/*
*/

require_once("../vendor/autoload.php");
class TypePhone extends TypeMulti {
	protected $_config = [];
	protected static $_sqlColumn = [
		"num" => "text",
		"indicatif" => "varchar(3)"
	];


	protected static function isValid($values, $getError = null) {
		if(!is_array($values))
			return (false);

		// On ne fait pas de controle si l'indicatif n'est pas renseigné
		if (empty($values["indicatif"]))
			return (true);

		$phoneUtil = \libphonenumber\PhoneNumberUtil::getInstance();
		try {
			$objnum = $phoneUtil->parse($values["num"], $values["indicatif"]);
		}
		catch (\libphonenumber\NumberParseException $e) {
			return (false);
		}
		if (!$phoneUtil->isValidNumber($objnum))
			return (false);
		return (true);
	}

	protected static function beforeSet($name, $value) {
		return (htmlspecialchars($value));
	}

	public static function normalize($name, $val, $config) {
		//if ($name == "num")
			//return (intval($val));
		return ($val);
	}
}
