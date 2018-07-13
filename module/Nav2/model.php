<?php
if (empty($this->dh))
	$this->dh = Dh::getCurrent();

if (!empty($_POST["avis"]))
{
	if (!is_null(Avis::insertNew($this->dh->id_dh, $_POST["avis"])))
	{
		$params = [
			"contenu" => htmlspecialchars($_POST["avis"]),
		];
		Logger::setNew("Ajout d'un avis client", $this->dh->id_dh, $this->dh->id_dh, $params);
		$comment = $this->dh->getShortName() . " a laissé une suggestion : " . $_POST["avis"];
		Crm2::insertNew($this->dh->id_dh, 6, 1, time(), -2700, $comment, [], 0);

		MailSender::sendMail(
			"teamdev@meilleurescpi.com",
			"Depot d'un avis client: " . $this->dh->getShortName(),
			"$comment",
			"teamdev",
			"teamdev@meilleurescpi.com"
			);
//		MailSender::sendMail(
//			$this->dh->getLogin(),
//			"Votre avis compte",
//			"Bonjour {$this->dh->getShortName()}, je vous remerci d'avoir pris le temps de nous donner votre avis.",
//			"teamdev",
//			"teamdev@meilleurescpi.com"
//		);

/*
 * $Pp = $dh->getPersonnePhysique();
		return (self::getNewLM(
			$Pp->getCivilite(),
			$Pp->getName(),
			$Pp->getFirstName(),
			$Pp->getPhone(),
			$Pp->getMail(),
			$duree
			));
 */
// On passe l'id du template, le sujet , le content pas besoin car on le recupere en bdd, le nom du template, et l'adresse email de celui qui envoi
        MailSender::sendToDhWithTemplateNameAndFrom((Dh::getById($this->dh->getId())), "Nous vous remercions pour votre avis ", "", "suggestion_client","jonathan.conseiller@meilleurescpi.com");
        Notif::set("Avis", "Nous vous remercions pour votre avis :)");
	}
	else
		Notif::set("Avis", "Vous avez déposé trop d'avis dernièrement, merci de re-essayer plus tard.");
	header("location: ?p=" . $GLOBALS['GET']['p']);
	exit();
}
