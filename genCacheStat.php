<?php
require 'app.php';
Cli::cli_only();
$stat = StatClients::generateCacheStats();
$filename = dirname(__FILE__) . "/../cache/statclients/" . date("Y_m_d") . ".data";
file_put_contents (
	$filename,
	serialize($stat),
	LOCK_EX
);
