<?php
class TypeRaw extends Type {
	protected static $_sqlColumn = "text";
	protected $_config = [];
	protected  static function isValid($val) {
		return (true);
	}

	public static function normalize($val, $config) {
		return ($val);
	}
}
