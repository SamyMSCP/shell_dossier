<?php
	if (!isset($_POST['data']) || !isset($_POST['data']['look']))
		error("No data");
	$dh = null;
	if ($_POST['data']['look'] == "phone")
	{
		$dh = Dh::getFromPhone($_POST['data']['content']);
	}
	else if ($_POST['data']['look'] == "mail")
		$dh = Dh::getByLogin($_POST['data']['content']);

	if ($dh != null){
		$ret = new stdClass();
		$dh = $dh[0];
		$ret->shortName = $dh->getShortName();
		$ret->id= $dh->id_dh;
		success($ret);
	}
	success([]);