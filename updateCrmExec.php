<?php
require_once("app.php");

Cli::cli_only();
$crms = Crm2::getAll();
foreach ($crms as $key => $elm)
{
	if ($elm->getCommentaire() == "Crm ajouté automatiquement lors de la création de compte.")
		$elm->updateOneColumn("id_executant", 0);
	else if ($elm->getCommentaire() == "Ce client souhaite être contacté.")
		$elm->updateOneColumn("id_executant", $elm->id_client);
	else if (empty($elm->id_executant))
		$elm->updateOneColumn("id_executant", $elm->id_user);
		
	//print_r($elm);
}
