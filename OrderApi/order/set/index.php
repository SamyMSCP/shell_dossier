<?php
	$__INC_BDD__ = "ok";
	require_once('OrderApi/inc/bdd.php');
	if (!isset($_POST['token']) || $_POST['token'] != $token)
	{
		header('HTTP/1.0 404 Not Found');
		exit;
	}

	if (!isset($_POST['id']))
	{
		header('HTTP/1.0 404 Not Found');
		exit;
	}
	//var_dump($_POST);

	$json_txt = str_replace("'", "\"", $_POST['data']);
	$txt = substr(strchr($json_txt, "\""), 1);
	$txt = substr($txt, 0, -1);
	$data = json_decode($txt, true);
	if ($data == NULL)
	{
		header('HTTP/1.0 403 Not Found');
		exit();
	}

	//$id = $data['id'];

	$id = intval($_POST['id']);
	//var_dump($id);
	$full_list['achat'] = $data['achat'];
	$full_list['vente'] = $data['vente'];

	$any_error = false;
	$unerror = $mysql->prepare("UPDATE `$base_scrap` SET `error` = '0' WHERE `id` = :id;");#Remove error
	$unerror->bindParam(":id", $id);
	if (!$unerror->execute())
		$any_error = true;
	$clean = $mysql->prepare("DELETE FROM `$base_ordre` WHERE `id_scpi` = :id");
	$clean->bindParam(":id", $id, PDO::PARAM_INT);
	if (!$clean->execute())
		$any_error = true;


	$soc = $mysql->prepare("SELECT `society` FROM `scpi_scrap_list` WHERE `id` = :id;");//GET SOCIETY FOR SCPI SELF
	$soc->bindParam(":id", $id, PDO::PARAM_INT);
	if (!$soc->execute())
		$any_error = true;

//	var_dump($any_error);
	$soc = intval($soc->fetch()['society']);
//	var_dump($soc);
//	die();
	$scpi = Scpi::getFromId($id);

	$i = 0;
	foreach ($full_list['achat'] as $table)
	{
		//var_dump($table);
		if ($table['parts'] == 0)
		{
			unset($full_list['achat'][$i]);
			$i++;
			continue;
		}
		if ($soc == 3)
		{
//			$price = $full_list['achat'][$i]['price'] / (1.0 + ($scpi->FraisSecondaires / 100.0) + 0.05);
			$full_list['achat'][$i]['price'] = $full_list['achat'][$i]['price'] / (1.0 + ($scpi->FraisSecondaires / 100.0) + 0.05);
		}
		$req = $mysql->prepare("INSERT INTO `$base_ordre` (`id`, `is_sell`, `nb_part`, `nb_order`, `price`, `id_scpi`, `date`) VALUES (NULL, '0', :parts, :ordres, :price, :society, CURRENT_TIMESTAMP)");
		$req->bindParam(":parts", $table['parts']);
		$req->bindParam(":ordres", $table['ordres']);
		$req->bindParam(":price", $table['price']);
		$req->bindParam(":society", $id);


        $req_h = $mysql->prepare("INSERT INTO `$base_history` (`id`, `is_sell`, `id_scpi`, `nb_part`, `price`, `nb_order`, `date`) VALUES (NULL, '0', :society, :parts, :price, :ordres, CURRENT_TIMESTAMP)");
        $req_h->bindParam(":parts", $table['parts']);
        $req_h->bindParam(":ordres", $table['ordres']);
        $req_h->bindParam(":price", $table['price']);
        $req_h->bindParam(":society", $id);
		if ($req->execute())
			if ($req_h->execute())
				$any_error = $any_error;
			else
                $any_error = true;
        else
            $any_error = true;

		$i++;
	}
	$i = 0;
	foreach ($full_list['vente'] as $table)
	{
		if ($table['parts'] == 0)
		{
			unset($full_list['vente'][$i]);
			$i++;
			continue;
		}
		$req = $mysql->prepare("INSERT INTO `$base_ordre` (`id`, `is_sell`, `nb_part`, `nb_order`, `price`, `id_scpi`, `date`) VALUES (NULL, '1', :parts, :ordres, :price, :society, CURRENT_TIMESTAMP)");
		$req->bindParam(":parts", $table['parts']);
		$req->bindParam(":ordres", $table['ordres']);
		$req->bindParam(":price", $table['price']);
		$req->bindParam(":society", $id);

        $req_h = $mysql->prepare("INSERT INTO `$base_history` (`id`, `is_sell`, `id_scpi`, `nb_part`, `price`, `nb_order`, `date`) VALUES (NULL, '1', :society, :parts, :price, :ordres, CURRENT_TIMESTAMP)");
        $req_h->bindParam(":parts", $table['parts']);
        $req_h->bindParam(":ordres", $table['ordres']);
        $req_h->bindParam(":price", $table['price']);
        $req_h->bindParam(":society", $id);
        if ($req->execute())
            if ($req_h->execute())
                $any_error = $any_error;
            else
                $any_error = true;
        else
			$any_error = true;
		$i++;
	}
	if ($any_error)
	{
		header('HTTP/1.0 404 Not Found');
		exit();
	}
	require_once("img.php");
	$a = draw_table($full_list, 0);
	$v = draw_table($full_list, 1);
	echo '<img src="data:image/png;base64,' .  $a  . '" />';
	echo '<img src="data:image/png;base64,' .  $v  . '" />';
	$req = $mysql->prepare("UPDATE `$base_scrap` SET `img_a` = :img WHERE `id` = :id");
	$req->bindParam(":id", $id);
	$req->bindParam(":img", $a);
	if ($req->execute())
		$any_error = $any_error;
	else
		$any_error = true;

	$req = $mysql->prepare("UPDATE `$base_scrap` SET `img_v` = :img WHERE `id` = :id");
	$req->bindParam(":id", $id);
	$req->bindParam(":img", $v);
	if ($req->execute())
		$any_error = $any_error;
	else
		$any_error = true;

	if ($any_error)
	{
		header('HTTP/1.0 404 Not Found');
		exit();
	}
//	header("content-type: application/json");
//	print ('{"return": "true"}');
?>
