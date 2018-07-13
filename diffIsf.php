<?php
exit();
require_once("app.php");
$filename = "valeur_ifi.csv";
$fd = fopen($filename, "r");
fgetcsv($fd);

$countExpatrie = 0;

echo "scpi,valeur_isf(db),valeur_ifi(importé),valeur_ifi_expatrié(importé)\n";

function prepareDataIfi($data) {
	if (strlen($data) != 0) {
		$data = str_replace(",", ".", $data);
		$data = str_replace(" ", "", $data);
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



	$ifi_non_resid = prepareDataIfi($ifi_non_resid);
	$ifi_resid = prepareDataIfi($ifi_resid);

	$scpi = Scpi::getFromId($id);
	$name = $scpi->getName();
	$scpiGestion = $scpi->getScpiGestion();
	$ifiDb = $scpiGestion->getValeurIsf();

	echo "$name,$ifiDb,$ifi_resid,$ifi_non_resid\n";
}
//echo "ifi_non_resid: $countExpatrie importation";
