<?php
class Ajax
{
	public static	$page_path = "ajax/";
	public function __construct() {
		include( self::$page_path . get_called_class() .  "/model.php");
	}
	public function getPath() {
		return ( self::$page_path . get_called_class() .  "/");
	}
}
