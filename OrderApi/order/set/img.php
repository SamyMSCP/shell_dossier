<?php

function SortByOrderAsc($item1,$item2)
{
	if ($item1['price'] == $item2['price']) return 0;
	return ($item1['price'] > $item2['price']) ? 1 : -1;
}

function SortByOrderDesc($item1,$item2)
{
	if ($item1['price'] == $item2['price']) return 0;
	return ($item1['price'] < $item2['price']) ? 1 : -1;
}

function draw_table($data, $type)
{
	//BUG: error local cannot create image tmp fix
//	return ("");
	//var_dump($data);
	$w = 512;
	$h = 8 * 32 + 1;

	$img		=  new Imagick();
	$img->newImage($w, $h, new ImagickPixel('rgba(255, 0, 255, 0.0)'));
	$img->setImageFormat('png');

	$img->setFont("./font/montserra.afm");
	//var_dump("START");
	//INIT TABLE
	$min_x = 0;
	$max_x = $w - 1;
	$min_y = 0;
	$max_y = 32;

	if ($type == 0)
	{
		$data = json_encode($data['achat']);
		$data = json_decode($data, true);
		usort($data,'SortByOrderDesc');
		$head_text = "Achat";
	}
	else
	{
		$data = json_encode($data['vente']);
		$data = json_decode($data, true);
		usort($data,'SortByOrderAsc');
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
	$text = " Prix Hors Frais";
	$draw->annotation(($part_len) / 2 - ((strlen($text) / 2) * ($draw->getFontSize() / 2)) + $offset_x + 10, ($max_y - 24) / 2 + $draw->getFontSize() + 3, $text);
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
		$draw->setStrokeColor($text_color);
		$draw->setFillColor($text_color);

		$cell0 = "NR*";
		$cell1 = "-";
		$cell3 = date("d/m/y");
		$draw->setFontSize(20);

		$draw->annotation(($part_len) / 2 - ((strlen($text) / 2) * ($draw->getFontSize() / 2)) + $offset_x, $max_y - 12 , $cell0);
//		$offset_x += $part_len;


//		$text = date("d/m/y");
//		$draw->annotation(($part_len) / 2 - ((strlen($text) / 2) * ($draw->getFontSize() / 2)) + $offset_x + 8, $max_y - 12 , $text);

		//$draw->annotation(($part_len) / 2 - ((strlen($text) / 2) * ($draw->getFontSize() / 2)) + $offset_x, $max_y - 12 , $cell0);
		$offset_x += $part_len;
		while ($i <= 1)
		{
			$draw->annotation(($part_len) / 2 - ((strlen($text) / 2) * ($draw->getFontSize() / 2)) + $offset_x, $max_y - 12 , $cell1);
			$offset_x += $part_len;
			$i++;
		}

		$draw->annotation(($part_len) / 2 - ((strlen($text) / 2) * ($draw->getFontSize() / 2)) + $offset_x - 27, $max_y - 12 , $cell3);

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
	//if (!isset($_POST['pingpong']) || $_POST['pingpong'] != "Nani?NoCopyright?Awesomu!")
	$draw->setStrokeColor(new ImagickPixel('#000000'));
	$draw->setFillColor(new ImagickPixel('#D0D0D0'));

	$max_y = 32 * 6;
	$text = "MeilleureSCPI.com";
	$draw->setFontSize(65);
	$draw->rotate(-10);
	$op = 0.3;
	$draw->setFillOpacity($op);
	$draw->setStrokeOpacity($op);
	//$draw->annotation(0 , $max_y , $text);
	$draw->annotation(-$max_x + $max_x / 4, $max_y / 2 - $draw->getFontSize() / 2, $text);
	$draw->rotate(10);

	$max_y = 32 * 3;
	$min_y = 32 * 2;
	$draw->setFontSize(20);
	$op = 1;
	$draw->setFillOpacity($op);
	$draw->setStrokeOpacity($op);
	$draw->setStrokeColor($text_color);
	$draw->setFillColor($text_color);

	if (count($data) == 0)
	{
		$img->drawImage($draw);
		$b64_img = base64_encode($img->getImageBlob());
		return ($b64_img);
	}

	foreach ($data as $key)
	{
		$max_y += 32;
		$min_y += 32;
		$offset_x = 0;

		if ($key['ordres'] == 0)
			$text = "NR*";
		else
			$text = $key['ordres'];
		$draw->annotation(($part_len) / 2 - ((strlen($text) / 2) * ($draw->getFontSize() / 2)) + $offset_x, $max_y - 12 , $text);
		$offset_x += $part_len;

		$text = $key['parts'];
		$draw->annotation(($part_len) / 2 - ((strlen($text) / 2) * ($draw->getFontSize() / 2)) + $offset_x, $max_y - 12 , $text);
		$offset_x += $part_len;

		$text = number_format($key['price'], 2, ',', ' ');
		//$text = strval($text) . " €";
		$draw->annotation(($part_len) / 2 - ((strlen($text) / 2) * ($draw->getFontSize() / 3)) + $offset_x, $max_y - 12 , $text);
		$offset_x += $part_len;


		$text = date("d/m/y");
		$draw->annotation(($part_len) / 2 - ((strlen($text) / 2) * ($draw->getFontSize() / 2)) + $offset_x + 8, $max_y - 12 , $text);
//		var_dump($key);
	}
	$draw->setStrokeColor($line_color);
	$draw->setFillColor($line_color);
	$draw->line($w - 1, 0, $w - 1, $max_y);

	//header('Content-type:image/png');
	$img->drawImage($draw);
	$b64_img = base64_encode($img->getImageBlob());
	//echo '<img src="data:image/png;base64,' .  $b64_img  . '" />';
	return ($b64_img);
}
?>
