<?php
require_once("class/core/ModuleAdmin.php");
class ModuleSendMessage extends ModuleAdmin
{
	public function sendMail() {
		if (
			!isset($_POST['idUser']) ||
			!isset($_POST['idTemplate']) ||
			!isset($_POST['message']) ||
			!isset($_POST['api']) ||
			!isset($_POST['title']) ||
			!isset($_POST['idUser']) ||
			!intval($_POST['idTemplate'])
		)
		{
			Notif::set("sendMail", "Le message n'a pas été envoyé");
			return ;
		}

		if (
			$_POST['api'] != "MailSender" &&
			$_POST['api'] != "SmsSender" &&
			$_POST['api'] != "Notifications"
		)
		{
			Notif::set("sendMail", "L'api n'a pas été trouvée, l'envoi a échoué !");
			return ;
		}

		$api = htmlspecialchars($_POST['api']);
		$idUser = json_decode($_POST['idUser']);
		$idTemplate = intval($_POST['idTemplate']);
		$message = $_POST['message'];
		$title= $_POST['title'];


		foreach ($idUser as $key => $elm)
		{
			$rt = $api::sendToDhWithTemplate(Dh::getById($elm), $title, $message, $idTemplate);
		}
		Notif::set("sendMail", "Les messages ont été envoyés avec succès !");
		header("Location: ?p=" . $GLOBALS['GET']['p']);
		exit();
	}
}
