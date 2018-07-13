<?php
require("app.php");
$testPaths = "./Tests";
$GLOBALS['showDetails'] = true;
$GLOBALS['showOkay'] = true;
//$GLOBALS['showOkay'] = false;

function test($name, $condition, $msg) {
	if (!$condition) {

		if (!$GLOBALS['showOkay'])
			echo "\033[31m-\033[0m\n";
		if ($GLOBALS['showDetails'])
		{
			echo "\t" . $name . " : ";
			echo "\033[31m" . $msg. "\033[0m\n";
		}
		return (false);
	} else {
		if ($GLOBALS['showOkay'] && $GLOBALS['showDetails'])
		{
			echo "\t" . $name . " : ";
			echo "\033[32mOK\033[0m\n";
		}
		else
			echo "\033[32m+\033[0m";
		return (true);
	}
}
function ass($file) {
	echo "\033[33m$file :\033[0m\n";
	$rt = include($file);
	if ($rt)
	{
		if (!$GLOBALS['showOkay'])
			echo "\n";
		echo "\033[32m============================= OK! =============================\033[0m\n\n";
	}
	else 
		echo "\033[31m============================= KO! =============================\033[0m\n\n";
}

function parseDirectory($path) {
	$path .= "/";
	$files = scandir($path);
	foreach ($files as $elm)
	{
		if ($elm[0] == ".")
			continue ;
		if (is_dir($path . $elm))
			parseDirectory($path . $elm);
		else 
			ass($path . $elm);
	}
}

if (count($argv) == 2)
{
	if (is_dir($argv[1]))
		parseDirectory($argv[1]);
	else
		ass($argv[1]);
}
else
	parseDirectory($testPaths);
