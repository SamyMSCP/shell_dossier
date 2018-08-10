<?php
if (!isset($__INC_BDD__))
{
	header('HTTP/1.0 404 Not Found');
	exit;
}
$host = SERVERNAME;
$base = "mscpi_db";
$user = USERNAME;
$pass = PASSWORD;

$base_scrap = "scpi_scrap_list";
$base_ordre = "scpi_order";
$base_socgest = "scpi_society";
$base_history = "scraping_history";

$token = "061c44daa1083284051aee7ac636f2e2f7119ca19402ea44b2a405398ded157c";

global $mysql;

$mysql = new PDO("mysql:host=$host;dbname=$base;charset=utf8", $user, $pass);
?>
