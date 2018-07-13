<?php
$this->data = $this->dh->getCacheArrayTable();
$this->date = new DateTime();
$this->dateTs = $this->date->getTimestamp();

// Tri des clés du tableau (nom SCPI) par ordre alphabétique
ksort($this->data, SORT_NATURAL);

$this->graph = $this->getGraph($this->dh->id_dh);
//$this->graph = null;

// Trimestre des dernières info
$date = new DateTime();
$curT = floor(intval($date->format('n'))/ 12 * 4);
$year = intval($date->format('Y'));
if ($curT - 1 == 0 || $curT == 0)
{
	$curT = 4;
	$year -= 1;
}
else
	$curT -= 1;
$this->dateDividende = $curT."T ".$year;
