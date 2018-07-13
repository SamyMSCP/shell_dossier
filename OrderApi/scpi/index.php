<?php
	$__INC_BDD__ = "ok";
	require_once('OrderApi/inc/bdd.php');
	$req = Null;
	if (isset($_POST['both_enable']))
		$req = $mysql->prepare("SELECT * FROM `$base_scrap` ORDER BY `name`");
	else
		$req = $mysql->prepare("SELECT * FROM `$base_scrap` WHERE `disabled` = 0 ORDER BY `name`");

	if (!$req->execute())
	{
		header('HTTP/1.0 404 Not Found');
		exit;
	}
	$rep = $req->fetchAll();
	$ret = [];
	foreach($rep as $line)
	{
		$tmp['text'] = $line['name'];
		$tmp['value'] = $line['id'];
		$ret[] = $tmp;
	}
	header("content-type: application/json");
	echo json_encode($ret);
?>
