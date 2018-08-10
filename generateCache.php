<?php
set_time_limit(-1);
require_once("app.php");

Cli::cli_only();

if (isset($_SERVER['argv'][2])) {
	$dh = Dh::getById(intval($_SERVER['argv'][2]));
	if (empty($dh)) {
		die("Ce donneur d'ordre n'a pas été trouvé");
	}
	$dataTransaction = $dh->regenerateCacheArrayTable();
	echo "Okay : " . $dh->id_dh . " - " . $dh->getShortName() . "\n";
} else {
	$lst = Dh::getAll();
	foreach ($lst as $dh) {
		$dataTransaction = $dh->regenerateCacheArrayTable();
		echo "Okay : " . $dh->id_dh . " - " . $dh->getShortName() . "\n";
	}
}

