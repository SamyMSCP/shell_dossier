<?php
	$__INC_BDD__ = "ok";
	require_once('OrderApi/inc/bdd.php');
	$req = Null;
	if (isset($_POST['type']) && $_POST['type'] == 1)
		$req = $mysql->prepare("SELECT `img_v` FROM $base_scrap WHERE `id`=:id");
	else
		$req = $mysql->prepare("SELECT `img_a` FROM $base_scrap WHERE `id`=:id");

	$id = 0;
	if (isset($_POST['id']))
		$id = intval($_POST['id']);
	$req->bindParam(":id", $id);
	if (!$req->execute())
	{
		header('HTTP/1.0 404 Not Found');
		exit;
	}
	$rep = $req->fetch();
	echo 'data:image/png;base64,' .  $rep[0];
?>
