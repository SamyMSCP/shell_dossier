<?php

//$_SESSION['setPhoneStep'] = 2;

if (
	isset($GLOBALS['haveNotif']) &&
	$GLOBALS['haveNotif'] == true
)
{
	unset($_SESSION['setPhoneTmp']);
	unset($_SESSION['setPhoneStep']);
}
else
{
	$GLOBALS['haveNotif'] = true;
	if (!isset($_SESSION['setPhoneStep']))
		$_SESSION['setPhoneStep'] = 1;
	if (isset($_POST['action']) && $_POST['action'] == "resetPhone")
	{
		$_SESSION['setPhoneStep'] = 1;
		//unset($GLOBALS[_SESSION]['setPhoneTmp']);
	}
	if (isset($_POST['action']) && $_POST['action'] == "setPhone")
		$this->setPhone();
	/*else*/if (isset($_POST['action']) && $_POST['action'] == "setCode")
		$this->setCode();
}
