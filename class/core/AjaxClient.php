<?php
class AjaxClient
{
	public static	$page_path = "ajax_client/";
	public function __construct() {
		include( self::$page_path . get_called_class() .  "/model.php");
	}
	public function getPath() {
		return ( self::$page_path . get_called_class() .  "/");
	}
}
