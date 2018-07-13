<?php
require_once("core/Database.php");
require_once("core/Apiv2.php");
require_once("core/Cache.php");

class CategoriesScpi extends Apiv2
{
	use Cache;
	private static	$_lstAll = null;
	private static	$staticDataCacheApi = null;


	public static function	generateCacheApi() {
		$data = self::getRequestJsonCategories();
		$rt = [];
		foreach ($data as $key => $elm) {
			$rt[$elm['id']] = $elm['name'];
		}
		return ($rt);
	}
	public static function	getAll()
	{
		if (self::$_lstAll == null)
		{ self::$_lstAll = self::getCacheApi();
		}
		return (self::$_lstAll);
	}
}
