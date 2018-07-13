<?php
require_once("app.php");

$GLOBALS["showOkay"] = true;

function printcolumn($scpi) {
	foreach ($scpi as $key => $elm)
		echo $key . "\n";
}

function dataStr($data) {
	if (!is_array($data))
		return ($data);
	ob_start();
	var_dump($data);
	$rt = ob_get_contents();
	ob_end_clean();
	return (str_replace("\n", " ", $rt));
}

function printArray($arr) {
	foreach($arr as $key => $elm)
	{
		echo "\t\t\t\t\t". $key . " => " . $elm . "\n";
	}
}

function compareScpi() {
	$scpiRoute = [ 
		"id"					=> "id",
		"name"					=> "name",
		"type_id"				=> "type_id",
		"category_id"			=> "category_id",
		"company_id"			=> "company_id",
		"parent_id"				=> "parent_id",
		"token"					=> "token",
		"slug"					=> "slug",
		"created_at"			=> "created_at",
		"absorbed_at"			=> "absorbed_at",
		"online"				=> "online",
		"TypeCapital"			=> "TypeCapital",
		"Régions"				=> "Régions",
		"Ile-de-France"			=> "Ile-de-France",
		"Paris"					=> "Paris",
		"ValeurRealisation"		=> "ValeurRealisation",
		"Strategie"				=> "Strategie",
		"ValeurReconstitution"	=> "ValeurReconstitution",
		//"prix_vendeur"			=> "price.vendeur"
		"Tof"					=> "Tof",
		"AllAcomptes"			=> "AllAcomptes",
		"AllAcomptesEx"			=> "AllAcomptesEx",

		"date_transaction"		=> "price.date",
		"prix_acquereur"		=> "price.acquereur",
		"FraisSouscription"		=> "frais_de_souscription",
	];
	$new = (array)Apiv2::getRequestJsonScpi();

	$old = (array)Api::getRequestJson([
		"req" => "getAllSCPI"
	]);
	//var_dump($old); exit();
	$toutOkay = true;
	function compareAcompte($old, $new) {
		$i = 2018;
		$okay = true;
		while ($i-- > 2010)
		{
			if (empty($old[$i]) && empty($new[$i]))
				continue ;
			if (empty($old[$i]))
			{
				$okay = false;
				echo "\t\t[" . $i . "]\n";
				echo "\033[31m";
				echo "\t\t\tAbsent dans old\n";
				echo "\t\t\t\tnew:\n";
				printArray($new[$i]);
				echo "\033[0m";
				continue ;
			}
			else if (empty($new[$i]))
			{
				$okay = false;
				echo "\t\t[" . $i . "]\n";
				echo "\033[31m";
				echo "\t\t\tAbsent dans new\n";
				echo "\t\t\t\told:\n";
				printArray($old[$i]);
				echo "\033[0m";
				continue ;
			}
			if ($old[$i] == $new[$i])
			{
				if ($GLOBALS["showOkay"])
				{
					echo "\t\t[" . $i . "]\n";
					echo "\033[32m";
					echo "\t\t\tOK:\n";
					echo "\t\t\t\told:\n";
					printArray($old[$i]);
					echo "\t\t\t\tnew:\n";
					printArray($new[$i]);
					echo "\033[0m";
				}
				continue ;
			}
			else
			{
				$okay = false;
				echo "\t\t[" . $i . "]\n";
				echo "\033[31m";
				echo "\t\t\tKO\n";
				echo "\t\t\t\told:\n";
				printArray($old[$i]);
				echo "\t\t\t\tnew:\n";
				printArray($new[$i]);
				echo "\033[0m";
				continue ;
			}
		}
		return ($okay);
	}
	foreach ($new as $key1 => $elm1)
	{
		echo "===================================================================================================\n";
		echo "Comparaison des données aux index :" . $key1 . " ";
		echo "old_name:`" . $old[$key1]['name'] . "` /// new_name:`" . $elm1["name"] . "`\n";
		foreach ($scpiRoute as $key2 => $elm2)
		{
			if (empty($old[$key1][$key2]) && empty($elm1[$elm2]))
			{
				if ($GLOBALS["showOkay"])
				{
					echo "\033[32m";
					echo "\tOK: `" . $key2 . "` est absent dans les deux Api\n";
					echo "\033[0m";
				}
				continue ;
			}
				
			if (empty($old[$key1][$key2]))
			{
				$toutOkay = false;
				echo "\033[31m";
				echo "\tKO: `" . $elm2 . "`[";
				echo dataStr($elm1[$elm2]) ."] n'est présent que dans la nouvelle Api\n";
				echo "\033[0m";
				continue ;
			}
			else if (empty($new[$key1][$elm2]))
			{
				$toutOkay = false;
				echo "\033[31m";
				echo "\tKO: `" . $key2 . "`[";
				echo dataStr($old[$key1][$key2]) ."]  n'est présent que dans l'ancienne Api\n";
				echo "\033[0m";
				continue ;
			}
			if ($key2 == "AllAcomptes" || $key2 == "AllAcomptesEx")
			{

				if ($key2 == "AllAcomptes")
					echo "AllAcomptes :\n";
				else
					echo "AllAcomptesEx :\n";



				if (!compareAcompte($old[$key1][$key2], $new[$key1][$elm2]))
					$toutOkay = false;
				continue ;
			}

			if ($old[$key1][$key2] != $elm1[$elm2])
			{
				$toutOkay = false;
				echo "\033[31m";
				echo "\tKO: `" . $key2 . "[";
				echo dataStr($old[$key1][$key2]) ."] - ";
				echo $elm2 . "[";
				echo dataStr($elm1[$elm2]) ."]\n";
				echo "\033[0m";
			}
			else
			{
				if ($GLOBALS["showOkay"])
				{
					echo "\033[32m";
					echo "\tOK: `" . $key2 . "[";
					echo dataStr($old[$key1][$key2]) ."] - ";
					echo $elm2 . "[";
					echo dataStr($elm1[$elm2]) ."]\n";
					echo "\033[0m";
				}
			}
		}
		echo "\n";
	}
	if ($toutOkay == false)
	{
		echo "\033[31m";
		echo "======================================TOUT N'EST PAS OK============================================\n";
		echo "\033[0m";
	}
	else
	{
		echo "\033[32m";
		echo "========================================TOUT EST OK================================================\n";
		echo "\033[0m";
	}
}

compareScpi();
