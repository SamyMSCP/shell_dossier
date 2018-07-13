<?php
require_once('app.php');

if (!check_adm_token())
	die ('no access');

$Api = new GraphApi($_POST);

echo json_encode($Api->doRequest());
