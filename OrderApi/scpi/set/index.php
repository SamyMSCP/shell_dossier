<?php
	$__INC_BDD__ = "ok";
	require_once('OrderApi/inc/bdd.php');
	if (!isset($_POST['token']) || $_POST['token'] != $token)
	{
		header('HTTP/1.0 404 Not Found');
		exit;
	}
	if (!isset($_POST['error']) || !isset($_POST['id']))
	{
		header('HTTP/1.0 404 Not Found');
		exit;
	}
	$scpi['error'] = htmlspecialchars($_POST['error']);
	$scpi['id'] = htmlspecialchars($_POST['id']);
	$req;
	$scpi['error']++;
	if ($scpi['error'] >= 3)//If 3 time have an error -> disable
	{
		$req = $mysql->prepare("UPDATE `$base_scrap` SET `disabled` = '1' WHERE `id` = :id;");
		include_once($_SERVER['DOCUMENT_ROOT']."/app.php");
//		$dh = Dh::getById(1587);
		if ($__IS_LOCAl__ == false)
			MailSender::sendMail("teamdev@meilleurescpi.com", "Erreur - SCPI ".$_POST['name'] . " disabled", "La scpi " . $_POST['name'] . " a ete desactivee suite a un nombre trop eleve d'erreur.", 'Scrapping', 'teamdev@meilleurescpi.com');
//		MailSender::sendToDhWithTemplateName($dh, "Erreur - SCPI ".$_POST['name']." disabled", $_POST['name'], "scpi_scrap_error");//Sending mail error
	}
	else
	{
		$req = $mysql->prepare("UPDATE `$base_scrap` SET `error` = :err WHERE `id` = :id;");
		$err = intval($scpi['error']);
		$req->bindParam(":err", $err, PDO::PARAM_INT);
		if ($__IS_LOCAl__ == false)
			MailSender::sendMail("teamdev@meilleurescpi.com", "Erreur - SCPI ".$_POST['name'] . " have error", "La scpi " . $_POST['name'] . " a produit une erreur, verifier les valeurs..", 'Scrapping', 'teamdev@meilleurescpi.com');
//		MailSender::sendToDhWithTemplateName($dh, "Erreur - SCPI ".$_POST['name']." disabled", $_POST['name'], "scpi_scrap_error");//Sending mail error
	}
	$id = intval($scpi['id']);
	$req->bindParam(":id", $id);
	if (!$req->execute())
	{
		header('HTTP/1.0 404 Not Found');
		exit;
	}
	//$rep = $req->fetchAll();
	//header("content-type: application/json");
	//echo json_encode($rep);
?>
