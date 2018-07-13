<?php
	$__INC_BDD__ = "ok";
	require_once('OrderApi/inc/bdd.php');
	$req = Null;


	$cmd = "";
	if (isset($_POST['id']))
		$cmd = "SELECT * FROM `$base_ordre` WHERE `id_scpi` = :id AND `is_sell` = :sell ORDER BY `price`";
	else
		$cmd = "SELECT * FROM `$base_ordre` WHERE `is_sell` = :sell ORDER BY `price`";

	$req = $mysql->prepare($cmd);
	if (isset($_POST['id']))
	{
		$id = (int)htmlspecialchars($_POST['id']);
		$req->bindParam(":id", $id);
	}
	$sell = 1;
	$req->bindParam(":sell", $sell, PDO::PARAM_INT);
	if (!$req->execute())
		header('HTTP/1.0 404 Not Found');
	$vente = $req->fetchAll();
	$cmd .= " DESC";
	$req = $mysql->prepare($cmd);
	if (isset($_POST['id']))
	{
		$id = (int)htmlspecialchars($_POST['id']);
		$req->bindParam(":id", $id);
	}
	$sell = 0;
	$req->bindParam(":sell", $sell, PDO::PARAM_INT);
	if (!$req->execute())
	header('HTTP/1.0 404 Not Found');
	$achat = $req->fetchAll();
	$ret['achat'] = $achat;
	$ret['vente'] = $vente;

	header("content-type: application/json");
	echo (json_encode($ret));
?>
