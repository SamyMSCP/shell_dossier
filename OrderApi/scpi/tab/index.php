<?php
	$__INC_BDD__ = "ok";
	require_once('OrderApi/inc/bdd.php');
	if (!isset($_POST['token']) || $_POST['token'] != $token || !isset($_POST['id']))
	{
		header('HTTP/1.0 404 Not Found');
		exit;
	}
	//	var_dump($_POST);
	$req;
	$req = $mysql->prepare("SELECT `tab`, `row`, `val`, `sort_a`, `sort_v` , `is_multi`, `v_before_a`, `index_el` , `is_shuffle` FROM `$base_socgest` WHERE `id` = :id");
	$_POST['id'] = htmlspecialchars($_POST['id']);

	$req->bindParam("id", $_POST['id']);
	$req->execute();
	$rep = $req->fetch();
	$obj;
	$obj['tab'] = json_decode($rep['tab']);
	$obj['row'] = json_decode($rep['row']);
	$obj['val'] = json_decode($rep['val']);
	$obj['sort_a'] = json_decode($rep['sort_a']);
	$obj['sort_v'] = json_decode($rep['sort_v']);
	$obj['settings']['is_multi'] = $rep['is_multi'];
	$obj['settings']['v_before_a'] = $rep['v_before_a'];
	$obj['settings']['index_el'] = $rep['index_el'];
	$obj['settings']['is_shuffle'] = $rep['is_shuffle'];
	//var_dump($obj);
	header("content-type: application/json");
	echo json_encode($obj);

?>
