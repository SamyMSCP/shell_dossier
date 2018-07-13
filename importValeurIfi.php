<?php
require_once("app.php");

Cli::cli_only();

$filename = "val_ifi2.csv";
$fd = fopen($filename, "r");
fgetcsv($fd);

$countExpatrie = 0;
$count = 0;

function prepareDataIfi($data) {
	if (strlen($data) != 0) {
		$data = str_replace(",", ".", $data);
		$data = str_replace(" ", "", $data);
		$data = str_replace("\xc2\xa0", "", $data);
		$data = str_replace("€", "", $data);
		$data = trim($data);
		$data2 = floatval($data);

		if ($data2 == 0 && $data[0] != '0')
			$data = null;
		else
			$data = $data2;
	} else {
		$data = null;
	}
	return ($data);
}

while ($elm = fgetcsv($fd))
{
	$sg = null;
	$id = null;
	$scpiName = null;
	$ifi_resid = null;
	$ifi_non_resid = null;
	if (isset($elm[0]))
		$sg = $elm[0];
	if (isset($elm[1]))
		$id = intval($elm[1]);
	if (isset($elm[2]))
		$scpiName = $elm[2];
	if (isset($elm[3]))
		$ifi_resid = $elm[3];
	if (isset($elm[4]))
		$ifi_non_resid = $elm[4];

	if ($id == 409) {
		echo $ifi_resid . " - " . $ifi_non_resid . "\n";
	}

	$ifi_non_resid = prepareDataIfi($ifi_non_resid);
	$ifi_resid = prepareDataIfi($ifi_resid);

	$scpi = Scpi::getFromId($id);
	$scpiGestion = $scpi->getScpiGestion();
	/*
		Pour le debug !
		if ($scpiGestion->getValeurIsf() != $ifi_resid)
			echo $scpiGestion->getValeurIsf() . " - " . $ifi_resid . "\n";
	*/
	if ($ifi_non_resid !== null) {
		$countExpatrie++;
		$scpiGestion->updateOneColumn("valeur_ifi_expatrie_01_01_2018", $ifi_non_resid);
	}

	if ($ifi_resid !== null) {
		$count++;
		$scpiGestion->updateOneColumn("valeur_ifi_01_01_2018", $ifi_resid);
	}
}
echo "ifi_resid: $count importation\n";
echo "ifi_non_resid: $countExpatrie importation\n";
