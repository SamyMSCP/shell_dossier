<?php
$action = $_POST['action'];
if ($action == "Send")
	$this->sendMail($_POST['data']);
else
	error("Bad formating");