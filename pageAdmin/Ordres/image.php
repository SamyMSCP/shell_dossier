<?php
//*
	if (!isset($GLOBALS['GET']['id']))
	{
		header('HTTP/1.0 404 Not Found');
		die();
	}

/* ****************************** [ GET DATA ] ****************************** */
	//TODO: Change me

	$url = "http://localhost/OrderApi.php";
	$data = array("id" => $GLOBALS['GET']['id'], "p" => "order");

	$option = array(
		'http' => array(
			'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
			'method'  => 'POST',
			'content' => http_build_query($data)
		)
	);

	$context = stream_context_create($option);
	$result = file_get_contents($url, false, $context);

	if ($result === false)
	{
		header('HTTP/1.0 404 Not Found');
		die();
	}

	$data = json_decode($result);


/* ************************************************************************** */


	$w = 512;
	$h = 8 * 32 + 1;

	$img		=  new Imagick();
	$img->newImage($w, $h, new ImagickPixel('rgba(255, 0, 255, 0.0)'));
	$img->setImageFormat('png');

	$img->setFont("font/montserra.afm");
	//INIT TABLE
	$min_x = 0;
	$max_x = $w - 1;
	$min_y = 0;
	$max_y = 32;

	if (!isset($GLOBALS['GET']['type']) || $GLOBALS['GET']['type'] == 0)
	{
		$data = $data->achat;
		$head_text = "Achat";
	}
	else
	{
		$data = $data->vente;
		$head_text = "Vente";
	}

	$draw = new ImagickDraw();
	$draw->setstrokewidth(1.0);
	$draw->setStrokeColor(new ImagickPixel('black'));
	$draw->setFillColor(new ImagickPixel('#01528A'));

	$draw->rectangle($min_x, $min_y, $max_x, $max_y);
	$draw->setStrokeColor(new ImagickPixel('#ffffff'));
	$draw->setFillColor(new ImagickPixel('#ffffff'));
	$draw->setTextAntialias(true);
	$draw->setFontSize(24);
	//$draw->setFont("montserrat");
	$draw->annotation($max_x / 2 - ((strlen($head_text) / 2) * ($draw->getFontSize() / 2)), $max_y / 2 + $draw->getFontSize() / 2, $head_text);

	$max_y += 64;
	$min_y += 32;

	$offset_x = 0;
	$part_len = $w / 4;
	$draw->setStrokeColor(new ImagickPixel('black'));
	$draw->setFillColor(new ImagickPixel('#3185BA'));

	$draw->rectangle($offset_x, $min_y, $offset_x + $part_len, $max_y);
	$offset_x += $part_len;

	$draw->rectangle($offset_x, $min_y, $offset_x + $part_len, $max_y);
	$offset_x += $part_len;

	$draw->rectangle($offset_x, $min_y, $offset_x + $part_len, $max_y);
	$offset_x += $part_len;

	$draw->rectangle($offset_x, $min_y, $offset_x + $part_len - 1, $max_y);
	$offset_x += $part_len;

	$offset_x = 0;

	$draw->setStrokeColor(new ImagickPixel('#ffffff'));
	$draw->setFillColor(new ImagickPixel('#ffffff'));
	$draw->setFontSize(18);
	//$draw->setFont("montserrat");
	$text = "Nombre ";
	$draw->annotation(($part_len) / 2 - ((strlen($text) / 2) * ($draw->getFontSize() / 2)) + $offset_x, ($max_y - 24) / 2 + $draw->getFontSize() + 3, $text);
	$text = " d'Ordres";
	$draw->annotation(($part_len) / 2 - ((strlen($text) / 2) * ($draw->getFontSize() / 3)) + $offset_x, ($max_y + 24) / 2 + $draw->getFontSize() + 3, $text);

	$offset_x += $part_len;
	$text = "Nombre ";
	$draw->annotation(($part_len) / 2 - ((strlen($text) / 2) * ($draw->getFontSize() / 2)) + $offset_x, ($max_y - 24) / 2 + $draw->getFontSize() + 3, $text);
	$text = " de parts";
	$draw->annotation(($part_len) / 2 - ((strlen($text) / 2) * ($draw->getFontSize() / 3)) + $offset_x, ($max_y + 24) / 2 + $draw->getFontSize() + 3, $text);

	$offset_x += $part_len;
	$text = "  Prix";
	$draw->annotation(($part_len) / 2 - ((strlen($text) / 2) * ($draw->getFontSize() / 2)) + $offset_x, ($max_y - 24) / 2 + $draw->getFontSize() + 3, $text);
	$text = "(en euros)";
	$draw->annotation(($part_len) / 2 - ((strlen($text) / 2) * ($draw->getFontSize() / 3)) + $offset_x, ($max_y + 24) / 2 + $draw->getFontSize() + 3, $text);

	$offset_x += $part_len;
	$text = "Date";
	$draw->annotation(($part_len) / 2 - ((strlen($text) / 2) * ($draw->getFontSize() / 2)) + $offset_x, $max_y / 2 + $draw->getFontSize() + 3, $text);

	$text_color = new ImagickPixel('#01528a');
	$line_color = new ImagickPixel('black');
	$bg_color = new ImagickPixel('#F0F0F0');

	if (count($data) == 0)
	{
		///IF NOTHING
		$max_y += 32;
		$min_y += 64;
		$offset_x = 0;
		$text = "-";
		$i = 0;

		//draw header
		while ($i <= 3)
		{
			$draw->setStrokeColor($line_color);
			$draw->setFillColor($bg_color);
			$draw->rectangle($offset_x, $min_y, $offset_x + $part_len, $max_y);
			$offset_x += $part_len;
			$i++;
		}

		//**//
		$offset_x = 0;
		$i = 0;
		while ($i <= 3)
		{
			$draw->setStrokeColor($text_color);
			$draw->setFillColor($text_color);
			$draw->annotation(($part_len) / 2 - ((strlen($text) / 2) * ($draw->getFontSize() / 2)) + $offset_x, $max_y - 12 , $text);
			$offset_x += $part_len;
			$i++;
		}
		$draw->setStrokeColor($line_color);
		$draw->setFillColor($line_color);
		$draw->line($w - 1, 0, $w - 1, $max_y);
	}

	$draw->setStrokeColor($line_color);
	$draw->setFillColor($bg_color);
	//draw column
	$max_y = 32 * 3;
	$min_y = 32 * 2;
	foreach ($data as $key)
	{
		$max_y += 32;
		$min_y += 32;
		$offset_x = 0;
		$i = 0;
		while ($i <= 3)
		{
			$draw->rectangle($offset_x, $min_y, $offset_x + $part_len, $max_y);
			$offset_x += $part_len;
			$i++;
		}
	}

//DRAW CP-RIGHT
	//if (!isset($GLOBALS['GET']['pingpong']) || $GLOBALS['GET']['pingpong'] != "Nani?NoCopyright?Awesomu!")
	if (true)
	{
		$draw->setStrokeColor($line_color);
		$draw->setFillColor($bg_color);

		$max_y = 32 * 8;
		$text = "MeilleureSCPI.com";
		$draw->setFontSize(60);
		$draw->rotate(-10);
		$op = 0.15;
		$draw->setFillOpacity($op);
		$draw->setStrokeOpacity($op);
		$draw->annotation($max_x / 2 - ((strlen($text) / 2) * ($draw->getFontSize() / 2)) - 16, $max_y - 12 , $text);


		$draw->rotate(10);
	}
	$max_y = 32 * 3;
	$min_y = 32 * 2;
	$draw->setFontSize(20);
	$op = 1;
	$draw->setFillOpacity($op);
	$draw->setStrokeOpacity($op);
	$draw->setStrokeColor($text_color);
	$draw->setFillColor($text_color);

	foreach ($data as $key)
	{
		$max_y += 32;
		$min_y += 32;
		$offset_x = 0;

		if ($key->nb_order == 0)
			$text = "NR*";
		else
			$text = $key->nb_order;
		$draw->annotation(($part_len) / 2 - ((strlen($text) / 2) * ($draw->getFontSize() / 2)) + $offset_x, $max_y - 12 , $text);
		$offset_x += $part_len;

		$text = $key->nb_part;
		$draw->annotation(($part_len) / 2 - ((strlen($text) / 2) * ($draw->getFontSize() / 2)) + $offset_x, $max_y - 12 , $text);
		$offset_x += $part_len;

		$text = number_format($key->price, 2, ',', '');
		//$text = strval($text) . " €";
		$draw->annotation(($part_len) / 2 - ((strlen($text) / 2) * ($draw->getFontSize() / 3)) + $offset_x, $max_y - 12 , $text);
		$offset_x += $part_len;


		$text = date("d/m/y", strtotime($key->date));
		$draw->annotation(($part_len) / 2 - ((strlen($text) / 2) * ($draw->getFontSize() / 2)) + $offset_x + 8, $max_y - 12 , $text);
	}
	$draw->setStrokeColor($line_color);
	$draw->setFillColor($line_color);
	$draw->line($w - 1, 0, $w - 1, $max_y);

	header('Content-type:image/png');
	$img->drawImage($draw);
	echo $img->getImageBlob();
?>
