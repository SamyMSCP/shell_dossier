<?php
$this->title = "Connexion";
$this->code = false;
$this->_token = false;
$this->err = [];
$this->reset = NULL;
$this->captcha = false;
$this->_num = false;

if (($dh = Dh::getCurrent()))
{
	if (isset($GLOBALS['GET']['logout']))
	{
		$this->logout();
		header("Location: .");
		exit();
	}
	else
	{
		if (empty($GLOBALS['GET']['p']) || $GLOBALS['GET']['p'] == 'Index')
			header("Location: index.php?p=TableauDeBord");
		else
			header($_SERVER["SERVER_PROTOCOL"]." 404 Not Found");
		exit();
	}
}
else if (isset($_POST) && !empty($_POST['action']))
{
	if ($_POST['action'] == "connectme" && !empty($_POST['login']) && !empty($_POST['password']))
	{
		if ($this->login( $_POST['login'], $_POST['password'] ))
		{
			header("Location: index.php?p=TableauDeBord");
			exit();
		}
		else if (!$this->code && !isset($this->err["connectme"]))
			$this->err["connectme"] = Connexion2::$_ERR_CONNECT_ME;
	}
	else if ($_POST['action'] == "forgottenpwd" && !empty($_POST['login']))
	{
		if ($this->forgottenPassword( $_POST['login'] ))
		{
			header("Location: .?mailsended");
			exit();
		}
		else if (!isset($this->err["forgottenpwd"]))
			$this->err["forgottenpwd"] = Connexion2::$_ERR_FORGOTTEN_PWD;
	}
	else if ($_POST['action'] == "changepwd" && !empty($_POST['newpwd']) && !empty($_POST['confirmnewpwd']))
	{
		if ($this->changePassword( $_POST['newpwd'], $_POST['confirmnewpwd'], $_POST['reset'] ))
		{
			header("Location: .");
			exit();
		}
		else if (!isset($this->err["changepwd"]))
			$this->err["connectme"] = Connexion2::$_ERR_CHANGE_PWD;
	}
	else if (!empty($_POST['action']) && $_POST['action'] == "verifycode" && !empty($_POST['_token']) && (isset($_POST['renew']) || !empty($_POST['code'])))
	{
		if (($dh = Dh::getFromKeyValue("TOKEN", $_POST['_token'])))
		{
			$this->code = true;
			if (isset($_POST['renew']))
				$this->code = $this->sendCode($dh[0]);
			else if ($this->verifyCode($_POST['_token'], $_POST['code']))
			{
				header("Location: .");
				exit();
			}
			else
				$this->err["verifycode"] = Connexion2::$_ERR_VERIFY_CODE;
			$this->_token = $_POST['_token'];
		}
		else
			$this->err["connectme"] = Connexion2::$_ERR;
	}
}
else if (isset($GLOBALS['GET']['reset']))
{
	if (($dh = Dh::findByReset($GLOBALS['GET']['reset'])))
		$this->reset = $GLOBALS['GET']['reset'];
}
else if (isset($GLOBALS['GET']['mailsended']))
{
	$this->msg["connectme"] = Connexion2::$_MSG_MAIL_SENDED;
}
else if (!empty($GLOBALS['GET']['p']) && $GLOBALS['GET']['p'] != "Index")
{
	$this->err['connectme'] = "Vous devez être connecté pour accéder à cette page.";
}

$this->captcha = $this->needCaptcha($_SERVER['REMOTE_ADDR']);
