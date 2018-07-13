<?php
require_once("class/core/Ajax.php");

class MailSend extends Ajax
{
	public function sendMail($data)
	{
		if (isset($data['to']) && isset($data['subject']) && isset($data['body']) && isset($data['entity']) && isset($data['from'])) {
			if ($data['from'] == "jonathan.yoda@meilleurescpi.com")
				$data['from'] = "jonathan.conseiller@meilleurescpi.com";

			$use_api = true;
			$crm = Crm2::insertNew(
				$data['id_client'],
				5,
				1,
				(new DateTime("NOW"))->getTimestamp(),
				-2700,
				("Une prise de contact par l'interface des mails a été effectuée: " . $data['body']),
				[],
				1
			);
			Crm2::getFromId($crm)[0]->updateOneColumn("priority", 3);


			if ($use_api) {
				$client = Dh::getFromId($data['id_client']);
				$bcc = [$client[0]->getConseiller()->getLogin()];
				$bcc[] = Dh::getCurrent()->getLogin();
				if (MailSender::sendMail($data['to'], $data['subject'], $data['body'], $data['entity'], $data['from'], $bcc)) ;
				success("success");
			} else {

				$to = $data['to'];
				$subject = $data['subject'];
				$headers = "From: " . strip_tags($data['from']) . "\r\n";
				$headers .= "MIME-Version: 1.0\r\n";
				$headers .= "Content-Type: text/html; charset=UTF-8\r\n";
				$message = $data['body'];

//				$crm = Crm2::insertNew($data['id_client'], 5, 1, time(), 0,"");

				if (mail($to, $subject, $message, $headers) === true)
					success("success");
			}
		}
		error("Cannot send mail");
	}
}
