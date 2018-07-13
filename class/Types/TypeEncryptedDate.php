<?php
require_once("TypeEncryptedString.php");
class TypeEncryptedDate extends TypeEncryptedString {

	protected static $_sqlColumn = "bigint(20)";
	protected  $_config = [];
	protected static function isValid($val) {
		if (!$val instanceof DateTime)
			return (false);
		return (true);
	}

	protected static function beforeSet($val) {
		$rt = $val;
		if (is_int($val)) {
			$rt = new Datetime();
			$rt->setTimestamp(intval($val));
		}
		else if (is_string($val))
			$rt = DateTime::createFromFormat("d/m/Y", $val);
		if ($rt instanceof DateTime)
			return ($rt);
		return (null);
	}

	protected static function prepareSet($val) {
		$rt = $val;
		if (is_int($val))
			return (parent::prepareSet(intval($val)));
		else if (is_string($val))
			$rt = DateTime::createFromFormat("d/m/Y", $val);
		if ($rt instanceof DateTime)
			return (parent::prepareSet($rt->getTimestamp()));
	}


	protected static function prepareGet($val) {
		$val = parent::prepareGet($val);
		$rt = new DateTime();
		$rt->setTimestamp($val);
		return ($rt);
	}
}
