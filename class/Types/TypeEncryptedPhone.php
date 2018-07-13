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

require_once("../vendor/autoload.php");

class TypeEncryptedPhone extends TypeMulti {
	protected $_config = [];
	protected static $_sqlColumn = [
		"num" => "text",
		"indicatif" => "varchar(3)"
	];


	protected static function isValid($values, $getError = null) {
		$rt = [];
		if(!is_array($values))
			return (false);

		// On ne fait pas de controle si l'indicatif n'est pas renseigné
		if (
				empty($values["indicatif"])
			&& 
			(
					empty($values["num"])
				|| 
				(
					is_string($values['num']) && strlen($values['num']) >= 1
				)
			)
		)
		{
			return (true);
		}

		$phoneUtil = \libphonenumber\PhoneNumberUtil::getInstance();
		$objnum = null;
		try {
			$objnum = $phoneUtil->parse($values["num"], $values["indicatif"]);

// string(2) "GB"
		}
		catch (\libphonenumber\NumberParseException $e) {
			$rt["indicatif"] = "L'indicatif téléphonique et le numéro sont invalides";
			$rt["num"] = "L'indicatif téléphonique et le numéro sont invalides";
			//return ($rt);
		}

		if (empty($objnum)) {
			$rt["indicatif"] = "L'indicatif téléphonique et le numéro sont invalides";
			$rt["num"] = "L'indicatif téléphonique et le numéro sont invalides";
			return ($rt);
		}

		if ($phoneUtil->getRegionCodeForNumber($objnum) != $values['indicatif'] ) {
			$rt["indicatif"] = "L'indicatif téléphonique et le numéro sont invalides";
			$rt["num"] = "L'indicatif téléphonique et le numéro sont invalides";
		}


		if (!$phoneUtil->isValidNumber($objnum)) {
			$rt["num"] = "Le numéro de téléphone n'est pas valide";
		}

		if (!empty($rt) && $getError == null)
			return (false);
		else if (!empty($rt))
			return ($rt);

		return (true);
	}


	protected static function beforeSet($name, $value) {
		return (htmlspecialchars($value));
	}

	protected static function prepareSet($name, $value) {
		if ($name == "num") {
			DevLogs::set($value, 1);
			if ($value === null || !is_string($value) || strlen($value) < 1)
				return (null);
			return (ft_crypt_information($value));
		}
		return ($value);
	}
	protected static function prepareGet($name, $value) {
		if ($name == "num") {
			if ($value === null || !is_string($value) || strlen($value) < 1)
				return (null);
			return (ft_decrypt_crypt_information($value));
		}
		return ($value);
	}

	public function getShowComponent($col, $config) {
		return ("ComponentTypeShow");
	}

	public function getEditComponent($col, $config) {
		$name = static::fromTableToName($col, $config['config']);
		if ($name == "num") {
			return ("ComponentTypePhoneEdit");
		} else if ($name == "indicatif") {
			return ("ComponentTypeIndicatifPhoneEdit");
		}
		return ("ComponentTypeEdit");
	}
}
