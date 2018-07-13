<?php
require_once("class/core/Module.php");
class Connexion2 extends Module
{
	public static $_MSG_MAIL_SENDED = "Un email vous a été transmis.";

	public static $_ERR_CAPTCHA = "Captcha erroné.";

	public static $_ERR_CONNECT_ME = "Votre adresse email ou votre mot de passe est incorrect. Vérifiez bien l'orthographe de votre email. Si vous ne vous souvenez plus de votre mot de passe, <a href=\"#\" class=\"forgottenpwd_a\">cliquez-ici</a>.";

	public static $_ERR_FORGOTTEN_PWD = "Aucun compte n’est associé à cette adresse email. Si vous souhaitez créer un compte, <a href=\"index.php?p=CreationCompte\" id=\"creationcompte_a\">cliquez-ici</a>.";

	public static $_ERR_VERIFY_CODE = "Le code saisi est incorrect. Pour recevoir un nouveau code, <a id=\"verifycode_a\" href=\"#\">cliquez-ici</a>.";

	public static $_ERR_ACCOUNT_BLOCKED = "Votre compte est désactivé.";
	public static $_ERR_CHANGE_PWD_NOT_MATCH = "Les mots de passe ne sont pas identiques.";
	public static $_ERR_CHANGE_PWD_INVALID = "Mots de passe invalides.";
	public static $_ERR_CHANGE_PWD = "Demande de changement de mot de passe invalide.";

	public static $_ERR = "Demande invalide.";

	protected function changePassword($newpassword, $confirm_newpassword, $reset_token)
	{
		if (!preg_match("/[a-z]/", $newpassword)
			|| !preg_match("/[A-Z]/", $newpassword)
			|| !preg_match("/[0-9]/", $newpassword)
			|| !preg_match("/[a-zA-Z0-9]{8,42}/", $newpassword))
			$this->err["changepwd"] = self::$_ERR_CHANGE_PWD_INVALID;
		else if ($newpassword !== $confirm_newpassword)
			$this->err["changepwd"] = self::$_ERR_CHANGE_PWD_NOT_MATCH;
		else if (!is_null(($dh = Dh::findByReset($reset_token))))
		{
			// Si le mail n'a pas été vérifié on le valide
			if (!$dh->mailOk())
			{
				$dh->updateOneColumn('confirmation', ($dh->phoneOk()) ? 3 : 2);
				Logger::setNew("Adresse mail confirmee", $dh->id_dh, $dh->id_dh, [
				"details" => "Confirmation automatique suite à demande de changement de mot de passe"]);
			}
			$dh->updateOneColumn('password', ft_crypt_pass($newpassword));
			$dh->updateOneColumn('reset', NULL);

			$dh->setConnected();
			$params = [
				"IP" => $_SERVER['REMOTE_ADDR'],
				"userAgent" => $_SERVER['HTTP_USER_AGENT'],
				"details" => "Connexion suite à changement de mot de passe"
			];
				Logger::setNew("Connexion front", $dh->id_dh, $dh->id_dh, $params);
			return true;
		}
		return false;
	}

	protected function forgottenPassword($login)
	{
		$dh = Dh::getBylogin($login);
		if (!empty($dh))
		{
			if ($dh[0]->remove_access)
			{
				$this->err["forgottenpwd"] = self::$_ERR_ACCOUNT_BLOCKED;
				return false;
			}
			$rt = null;
			if ($dh[0]->reset != "")
			{
				$rc = explode('|',$dh[0]->reset);
				if ($rc[1] < time())
					$rt = $rc[0];
			}
			$dh[0]->loosePasswordProcedure($rt);
			return true;
		}
		return false;
	}

	protected function needCaptcha($ip)
	{
		$dt = new DateTime("NOW");
		$date = $dt->getTimestamp() - TIME_CAPTCHA;

		if (($logs = Logger::getByTypeSince('Tentative connexion front', $date)))
		{
			// On récupère la derr date de connexion
			if (($logs_connex = Logger::getByTypeSince("Connexion front", $date)))
			{
				foreach ($logs_connex as $log)
				{
					if (($params = $log->getParams()) && !isset($params["Erreur"]) && $params['IP'] == $ip)
						$date = $log->date;
				}
			}

			$cnt = 0; // Nombre de tentative pour l'addresse IP 
			foreach ($logs as $log)
			{
				if ($log->date <= $date) // Si la tentative a eu lieu avant la derr connexion on arrete
					break ;
				if (($params = $log->getParams()) && !isset($params["Erreur"]) && $params['IP'] == $ip)
					++$cnt;
			}
			if ($cnt >= MAX_ATTEMPT_BEFORE_CAPTCHA)
				return true;
		}
		return false;
	}

	public static function checkCaptcha($gcaptcha)
	{
		if (empty($gcaptcha))
			return false;
		$url = "https://www.google.com/recaptcha/api/siteverify?secret=" . __PRIVATE_KEY_RECAPTCHA__ . "&response=" . $gcaptcha;
		$curl = curl_init($url);
		curl_setopt($curl, CURLOPT_HEADER, false);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($curl, CURLOPT_TIMEOUT, 1);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		$res = curl_exec($curl);
		$json = json_decode($res);
		return ($json->success);
	}

	protected function login($login, $password)
	{
		if ($this->needCaptcha($_SERVER['REMOTE_ADDR']) && !self::checkCaptcha($_POST["g-recaptcha-response"]))
			$this->err['connectme'] = self::$_ERR_CAPTCHA;
		else
		{
			$_login = ft_crypt_information($login);
			$dh = Dh::getFromKeysValues(['login' => $_login, 'password' => ft_crypt_pass($password)]);
		}

		$params = ["IP" => $_SERVER['REMOTE_ADDR'],
				"userAgent" => $_SERVER['HTTP_USER_AGENT']];

		if (isset($_POST["g-recaptcha-response"]))
			$params['captcha'] = $_POST["g-recaptcha-response"];

		if (!empty($dh))
		{
			if ($dh[0]->remove_access)
			{
				$this->err['connectme'] = self::$_ERR_ACCOUNT_BLOCKED;
				$params["details"] = "Compte désactivé";
				Logger::setNew("Tentative connexion front", $dh[0]->id_dh, $dh[0]->id_dh, $params);
				return false;
			}

			$token = ft_crypt_information(generateToken());
			$dh[0]->updateOneColumn("TOKEN", $token);

			$_ip = ft_crypt_information($_SERVER['REMOTE_ADDR']);
			// si l'adresse IP du client est différente de la dernière connexion
			// aka FRAUDE
			if ((empty($dh[0]->IP) || $dh[0]->IP !== $_ip) && !empty($dh[0]->getPersonnePhysique()->getPhone()) && $dh[0]->fraude >= 0)
			{
				$dh[0]->updateOneColumn("fraude", 1);
				$this->code = $this->sendCode($dh[0]);
				$this->_token = $token;
				return false;
			}
			else
			{
				$params["details"] = "Connexion sans validation par code sms";
				Logger::setNew("Connexion front", $dh[0]->id_dh, $dh[0]->id_dh, $params);
				$dh[0]->setConnected();
				return true;
			}
		}
		else if (($dh = Dh::getFromKeyValue('login', $_login)))
		{
			$params["details"] = "Mot de passe faux";
			Logger::setNew("Tentative connexion front", $dh[0]->id_dh, $dh[0]->id_dh, $params);
		}
		return false;
	}

	protected function logout()
	{
		if (($dh = Dh::getCurrent()))
		{
			Logger::setNew("Deconnexion front", $dh->id_dh, $dh->id_dh);
			del_cookie(['token','login']);
			$dh->updateOneColumn("TOKEN", null);
		}
	}

	protected function sendCode($dh)
	{
		$code = mt_rand(100000, 999999);
		$dh->updateOneColumn('code', $code);
		if (SmsSender::sendToDhWithTemplateName($dh, "", $code, "setPhone"))
		{
			$this->_num = mb_substr($dh->getPersonnePhysique()->getPhone(), -5);
			return true;
		}
		return false;
	}

	protected function verifyCode($token, $code)
	{
		$dh = Dh::getFromKeysValues(['token' => $token, 'code' => $code]);
		if (!empty($dh))
		{
			$dh[0]->updateOneColumn("code", NULL);
			$dh[0]->updateOneColumn("fraude", 0);
			if (!$dh[0]->phoneOk())
				$dh[0]->updateOneColumn('confirmation', ($dh[0]->mailOk())? 3 : 1);
			$params = [
				"IP" => $_SERVER['REMOTE_ADDR'],
				"userAgent" => $_SERVER['HTTP_USER_AGENT'],
				"details" => "Connexion avec validation par code sms"
			];
			Logger::setNew("Connexion front", $dh[0]->id_dh, $dh[0]->id_dh, $params);
			$dh[0]->setConnected();
			return true;
		}
		return false;
	}
}
