<?php
set_time_limit(-1);
require_once("app.php");
Cli::cli_only();
$lst = Dh::getAll();
foreach ($lst as $dh) {
	$dataTransaction = $dh->regenerateCacheArrayTable();
	echo "Okay : " . $dh->id_dh . " - " . $dh->getShortName() . "\n";
}
