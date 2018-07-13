<?php
	include ("app.php");

	if (!isset($_POST['p']))
	{
		header('HTTP/1.0 404 Not Found');
		exit;
	}
	$__IS_LOCAL__ = false;

	$preset = "OrderApi";
	$p = $_POST['p'];
	if ($p == "order")
		include ($preset."/order/index.php");
	else if ($p == "order/set")
		include ($preset."/order/set/index.php");
	else if ($p == "scpi")
		include ($preset."/scpi/index.php");
	else if ($p == "scpi/all")
		include ($preset."/scpi/all/index.php");
	else if ($p == "scpi/set")
		include ($preset."/scpi/set/index.php");
	else if ($p == "scpi/tab")
		include ($preset."/scpi/tab/index.php");
	else if ($p == "scpi/tab/img")
		include ($preset."/scpi/tab/img/index.php");
	else
		header('HTTP/1.0 404 Not Found');
?>
