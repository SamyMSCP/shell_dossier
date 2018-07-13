<?php
if (!isset($_POST['data']))
	error("pas de datas !!!");
$rt = Dh::getLikeColumn(htmlspecialchars($_POST['data']));

if (!empty($rt))
	success($rt);
success([]);