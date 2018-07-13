<?php
$dh = Dh::getCurrent();

if (!isset($GLOBALS['GET']['action']))
	exit();
if ($GLOBALS['GET']['action'] == "add")
{
	if (Favoris::checkActu($dh->id_dh, $GLOBALS['GET']['id']))
	{
		echo "KO";
		exit();
	}
	$rt = Favoris::insertActu($dh->id_dh, $GLOBALS['GET']['id']);
	if (Favoris::checkActu($dh->id_dh, $GLOBALS['GET']['id']))
		echo "OK";
	else
		echo "KO";
	exit();
}

if ($GLOBALS['GET']['action'] == "remove")
{
	Favoris::removeActu($dh->id_dh, $GLOBALS['GET']['id']);
	if (!Favoris::checkActu($dh->id_dh, $GLOBALS['GET']['id']))
		echo "OK";
	else
		echo "KO";
	exit();
}
