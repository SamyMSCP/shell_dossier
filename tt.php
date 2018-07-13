<?php
require "app.php";

Cli::cli_only();

$api = Api::getRequestObjects(
		array(
			"req" => "getAllSCPI"
		     )
		);

$api2 = Apiv2::getRequestJsonScpi();
foreach ($api as $s) {
	$t = NULL;
	foreach ($api2 as $el) {
		if ($s->id == $el->id)
		{
			$t = $el;
			break;
		}
	}
	foreach ($s as $key => $val) {
		if ($s->{$key} != $t->{$key})
			echo $s->id . ":" . $key . " = " .  $s->{$key} . " - " . $t->{$key} . PHP_EOL;
	}
	
}
