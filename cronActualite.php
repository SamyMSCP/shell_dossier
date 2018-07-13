<?php
require_once("app.php");

Cli::cli_only();
//$req = "SELECT * FROM `logger` WHERE `params` LIKE '%Notification actualite%' AND `params` LIKE ?";
$req = "SELECT * FROM `cache_actualite` WHERE `id` = ?";

$req_cache_actualite = "INSERT INTO `cache_actualite` (`id`, `actu`) VALUES (?, ?)";
$actus = Actuality::get(10);
foreach ($actus as $actu)
{
	$date_comp = new DateTime();
	$date_pub = DateTime::createFromFormat("Y-m-d H:i:s", $actu->date_publication);
	//echo $date_pub->format("d/m/Y H:i:s"),'  ', intval($date_comp->diff($date_pub)->format('%a')), PHP_EOL;
	if (intval($date_comp->diff($date_pub)->format('%a')) < 1)
	{
		if (count(($ret = Database::getNoClass("mscpi_db", $req, [$actu->id]))) == 0)
		{
			$_id = Crm2::insertNew(10, 7, 1, time(), -2700, "Une nouvelle actualité vient d'être publiée. <a href='admin_lkje5sjwjpzkhdl42mscpi.php?p=PageMailSender&get_actu=". $actu->id . "'>Cliquez-ici</a>", [], 0);
			Crm2::getFromId($_id)[0]->updateOneColumn("priority", 5);
			Database::prepareInsertNoSecurity("mscpi_db", $req_cache_actualite, [$actu->id, serialize($actu)]);
			//$crm = Crm2::getFromId($_id)[0];
			//$crm->updateOneColumn('id_user', 868);
			//var_dump($actu);
		}
	}
	else
		break ;
}
