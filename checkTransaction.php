<?php
require_once("app.php");

Cli::cli_only();

// Proteger le script d'une dans un browser.
if (isset($_SERVER['SERVER_NAME']))
	exit();


function readStdIn($prompt = null){
	if($prompt){
		echo $prompt;
	}
	$fp = fopen("php://stdin","r");
	$line = rtrim(fgets($fp, 1024));
	return $line;
}

echo "id_excel,Denomination sociale,Nom,Prenom,Civilite,mail,mail_absent,mail_introuvable\n";

function check_mail_absent($elm) {
	return (!empty(trim($elm[7])));
}

function check_mail_introuvable($elm) {
	$dh = Dh::getByLogin(trim($elm[7]));
	return (!empty($dh));
}

// Ouverture du fichier Csv et préparation des données
$filename = $argv[2];
$fd = fopen($filename, "r");
fgetcsv($fd);
$newDataArray = [];
while ($elm = fgetcsv($fd))
{
	if (
		!check_mail_absent($elm) ||
		!check_mail_introuvable($elm)
	)
	{
		echo "$elm[1],$elm[3],$elm[4],$elm[5],$elm[6],$elm[7],";
		if (!check_mail_absent($elm))
			echo "1";
		echo ",";
		if (!check_mail_introuvable($elm))
			echo "1";
		echo "\n";
	}
}
