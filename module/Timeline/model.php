<?php
$this->scpi = $this->dh->getDistinctTransaction();
if (!empty($GLOBALS['GET']['id']))
	$this->data = Actuality::getAllFromSCPI($GLOBALS['GET']['id']);
else
	$this->data = $this->dh->getAllActuality();



$this->favoris = $this->dh->getFavoritesArray();

if (is_null($this->data))
{
	header($_SERVER["SERVER_PROTOCOL"]." 404 Not Found");
	die();
}
