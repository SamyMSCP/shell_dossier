<?php
	$lst = Dh::getAll();
	require_once("module/ApercuDeMonPorteFeuillev2/controller.php");
	foreach ($lst as $dh) {
		$dataTransaction = $dh->regenerateCacheArrayTable();
	}
