<?php
require 'app.php';

$GLOBALS['printDebug'] = true;
$GLOBALS['printDebugScpi'] = true;
echo "=================== Buildings =========================\n";

function printDebug($msg) {
	if ($GLOBALS['printDebug'])
		echo $msg;
}

function printDebugScpi($msg) {
	if ($GLOBALS['printDebugScpi'])
		echo $msg;
}

function printData($arr) {
	printDebug( "\tsize:" . count($arr) . "\n");
	foreach ($arr as $key => $elm)
	{
		printDebug( "\t\t[" . $key . "]id:" . $elm['id'] . "\n");
	}
}

function compare($a, $b) {
	//printDebug( "Old :\n");
	$sa = count($a);
	$sb = count($b);
	$rt = true;
	for ($i = 0; $i < $sa || $i < $sb; $i++)
	{

		
		if  ($i >= $sa)
		{
			$rt = false;
			printDebug( "\033[31m");
			printDebug( "\tL'ancienne API manque id : [" . $b[$i]["id"] . "]");
			printDebug( "\033[0m");
			printDebug( "\n");
			continue ;
		}
		if  ($i >= $sb)
		{
			$rt = false;
			printDebug( "\033[31m");
			printDebug( "\tLa nouvelle API manque id : [" . $a[$i]["id"] . "]");
			printDebug( "\033[0m");
			printDebug( "\n");
			continue ;
		}

		printDebug( "\033[31m");
		printDebug("acquisition_date: Old[" . $a[$i]['acquisition_date'] . "] New[" . $b[$i]['acquisition_date'] . "]");
		printDebug( "\033[0m");
		printDebug( "\n");
		//url
		//city
		//zipcode
		//categorie_maitre
		//surfaces
		//scpi
		if ( $a[$i]['id'] != $b[$i]['id'])
		{
			$rt = false;
			printDebug( "\033[31m");
			printDebug("id: Old[" . $a[$i]['id'] . "] New[" . $b[$i]['id'] . "]");
			printDebug( "\033[0m");
			printDebug( "\n");
			continue ;
		}
	}
	echo "\n\n\n";
	$rt = false;
	return ($rt);
}

$GLOBALS['printDebug'] = true;
$scpiList = [260];
$ActuN = Apiv2::getRequestJsonBuildings($scpiList);
$ActuO = Api::getRequestJson( array(
	"req" => "getAcquisitionSCPIs2",
	"lst" => json_encode($scpiList)
));
//$ActuO = Acquisition::getFromArray($scpiList, 0);
//var_dump($ActuN); exit();

if (!is_array($ActuO))
	$ActuO = [];
//$rt = compare($ActuO, $ActuN);
//exit();

// Test simple avec une seule Scpi.
$scpis = Apiv2::getRequestJsonScpi();
foreach ($scpis as $key => $scpi)
{
	$scpiList = [$scpi->id];
	$ActuN = Apiv2::getRequestJsonBuildings($scpiList);
	$ActuO = Api::getRequestJson( array(
		"req" => "getAcquisitionSCPIs2",
		"lst" => json_encode($scpiList)
	));
	//var_dump($ActuO); exit();
	if (!is_array($ActuO))
		$ActuO = [];
	$rt = compare($ActuO, $ActuN);
	if ($rt)
	{
		printDebugScpi("\033[32m");
		printDebugScpi("OK [" . $scpi['id'] . "][" . $scpi['name'] . "]\n");
		printDebugScpi("\033[0m");
		printDebugScpi("\n");
	}
	else
	{
		printDebugScpi("\033[31m");
		printDebugScpi("KO [" . $scpi->id . "][" . $scpi->name . "]\n");
		$GLOBALS['printDebug'] = true;
		compare($ActuO, $ActuN);
		$GLOBALS['printDebug'] = false;
		printDebugScpi("\033[0m");
		printDebugScpi("\n");
	}
}










/*
	retour ancienne Api
	["url"]=>
    string(109) "https://www.meilleurescpi.com/patrimoine-scpi/b37258-15-et-17-boulevard-du-general-de-gaulle-92120-montrouge/"
    ["city"]=>
    string(9) "Montrouge"
    ["zipcode"]=>
    string(5) "92120"
    ["categorie_maitre"]=>
    NULL
    ["surfaces"]=>
    string(4) "2522"
    ["acquisition_date"]=>
    NULL
    ["scpi"]=>
    string(33) "SCPI Accès Valeur Pierre (100%) "
*/
/*
OK:
url
city
zipcode
categorie_maitre
surfaces
scpi
*/


/*
	retour de la nouvelle Api
array(10) {
	["id"]=>
	int(19513)
	["url"]=>
	string(96) "http://dev.meilleurescpi.com/patrimoine-scpi/b27071-place-de-la-coupole-94220-charenton-le-pont/"
	["slug"]=>
	string(43) "place-de-la-coupole-94220-charenton-le-pont"
	["token"]=>
	string(5) "27071"
	["city"]=>
	string(17) "Charenton-le-Pont"
	["zipcode"]=>
	string(5) "94220"
	["categorie_maitre"]=>
	string(7) "bureaux"
	["acquisition_date"]=>
	NULL
	["surfaces"]=>
	int(5262)
	["scpi"]=>
	string(17) "La Coupole (100%)"
}
*/
