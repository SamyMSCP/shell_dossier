<?php
require_once("app.php");
Cli::cli_only();
echo "client, conseiller\n";
foreach (Dh::getProspects() as $key => $elm)
{
	$toChange = false;
	foreach ($elm->getTransaction() as $key2 => $elm2)
	{
		if (!empty($elm2->getIdExcel()))
			$toChange = true;
	}
	if ($toChange)
		echo $elm->getShortName() . "," . $elm->getConseiller()->getShortName() . "\n";
	if ($toChange)
	{
		$elm->updateOneColumn("type", "client");
	}
}

