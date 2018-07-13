<?php
require_once("class/core/Module.php");
class ForceSetPhone extends Module
{
	public function setPhone()
	{
		// Code de verification du numéro de téléphone
		//Verifier numero detelephone portable
		if (
			!isset($_POST['num']) ||
			!isset($_POST['pays']) ||
			!check_tel_mobile_okay($_POST['num'], $_POST['pays'])
		)
		{
			$_SESSION['setPhoneStep'] = 4;
			//Notif::set('msgSetPhone', "Le numéro de téléphone renseigné n'est pas valide");
			return (0);
		}
		$num = htmlspecialchars(trim($_POST['num']));
		$pays = htmlspecialchars(trim($_POST['pays']));

		$code = rand(100000, 999999);
		$_SESSION['setPhoneTmp'] = [
			"num" => $num,
			"pays" => $pays,
			"code" => $code
		];
		$rt = SmsSender::sendToDhWithTemplateName($this->dh, "", $code, "setPhone", $num);
		if ($rt)
			$_SESSION['setPhoneStep'] = 2;
		else
		{
			$_SESSION['setPhoneStep'] = 4;
			//Notif::set('msgSetPhone', "Une erreur est survenue pendant l'envoi du sms");
			// Insérer un log d'erreur
		}
		return (1);
}
	public function setCode()
	{
		// Verification du code de validation !
		//dbg($_POST);
		//dbg($_SESSION);
		//exit();
		if ($_POST['code'] == $_SESSION['setPhoneTmp']['code'])
		{

			$GLOBALS['haveNotif'] = false;
			$Pp = $this->dh->getPersonnePhysique();
			$Pp->updateOneColumn("telephone", ft_crypt_information($_SESSION['setPhoneTmp']['num']));
			$Pp->updateOneColumn("indicatif_telephonique", $_SESSION['setPhoneTmp']['pays']);
			$this->dh->updateOneColumn("confirmation", "1");
			$this->dh->updateOneColumn("IP", ft_crypt_information($_SERVER['REMOTE_ADDR']));
			Notif::set("msgSetPhone", "Votre numéro de téléphone à bien été validé");
			//unset($GLOBALS[_SESSION]['setPhoneTmp']);
			//unset($GLOBALS[_SESSION]['setPhoneStep']);
			$params = [
				"numéro" => $_SESSION['setPhoneTmp']['num']
			];
			Logger::setNew("Saisie du numéro de téléphone", Dh::getCurrent()->id_dh, $this->dh->id_dh, $params);
			unset($_SESSION['setPhoneTmp']);
			unset($_SESSION['setPhoneStep']);
			header("Location: ?p=" . $GLOBALS['GET']['p']);
			exit();
		}
		else
		{
			$_SESSION['setPhoneStep'] = 5;
			// Le code n'a pas correctement été vérifié
		}
		return (1);
	}

}
