<?php
require_once("class/core/PageAdmin.php");

class PageMailSender extends PageAdmin
{
	public function sendMail() {
		if (
			!isset($_POST['idUser']) ||
			!isset($_POST['idTemplate']) ||
			!isset($_POST['message']) ||
			!isset($_POST['api']) ||
			!isset($_POST['title']) ||
			!intval($_POST['idUser']) ||
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
		$idUser = intval($_POST['idUser']);
		$idTemplate = intval($_POST['idTemplate']);
		$message = $_POST['message'];
		$title = $_POST['title'];

		$rt = $api::sendToDhWithTemplate(Dh::getById($idUser), $title, $message, $idTemplate);
		Notif::set("sendMail", "Le message a été envoyé avec succès !");
		return ;
	}
}
