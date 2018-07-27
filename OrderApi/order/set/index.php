<?php
	$__INC_BDD__ = "ok";

	require_once('../../inc/bdd.php');
	$id=221;
	$soc = $mysql->prepare("SELECT * FROM scpi_scrap_list,scraping_history WHERE scraping_history.id_scpi = :id AND scraping_history.id_scpi = scpi_scrap_list.id ORDER BY date DESC LIMIT 10");//GET SOCIETY FOR SCPI SELF
	$soc->bindParam(":id", $id, PDO::PARAM_INT);
	$soc->execute();
	$full_list = $soc->fetchAll();
	print_r( $full_list);
	require_once("img.php");


	$a = draw_table($full_list, 0);
	$v = draw_table($full_list, 1);
$a = "ok";
$v="ko";
	echo '<img src="data:image/png;base64,' .  $a  . '" />';
	echo '<img src="data:image/png;base64,' .  $v  . '" />';
	$req = $mysql->prepare("UPDATE `$base_scrap` SET `img_a` = :img WHERE `id` = :id");
	$req->bindParam(":id", $id);
	$req->bindParam(":img", $a);

	$req = $mysql->prepare("UPDATE `$base_scrap` SET `img_v` = :img WHERE `id` = :id");
	$req->bindParam(":id", $id);
	$req->bindParam(":img", $v);

//	header("content-type: application/json");
//	print ('{"return": "true"}');
?>
