<?php
//	$this->scpi = Dh::getCurrent()->getDistinctTransaction();
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
