<?php
require_once('../vendor/autoload.php');
use Mailgun\Mailgun;

require_once("Dh.php");
require_once("CommunicationTemplate.php");


class MailSender
{
	private static	$_apiKey = 'key-2833db2824116d3a8815a4b07555cfcb';
	private static	$_publicApiKey = 'pubkey-94394f9e9956af1df2ad6e968f18b24f';
	private static	$_apiMail = null;
	private static	$_publicApiMail = null;
	private static	$_domain = "meilleurescpi.com";
	private static	$_from = "MeilleureSCPI.com <contact@meilleurescpi.com>";
	private static	$_verifKey = "Gvk1YePbiFJQqQKFtIh2Q";

	private static function instanciateApi()
	{
		if (self::$_apiMail == null)
			self::$_apiMail = new Mailgun(self::$_apiKey);

		if (self::$_publicApiMail == null)
			self::$_publicApiMail = new Mailgun(self::$_publicApiKey);
	}

	public static function checkBann($email) {
		$email = mb_strtolower($email);
		include("listMailBann.php");
		$domain = explode("@", $email)[1];
		foreach ($mailBann as $key => $elm)
		{
			if (strpos($domain, $elm) !== false)
				return ($elm);
		}
		return (false);
	}

	/** Permet la verification d'une addresse Email
	 * @param $email
	 * @return bool
	 */
	public static function verify($email) {
		$url = "https://apps.emaillistverify.com/api/verifyEmail?secret=". self::$_verifKey."&email=".$email;
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true );
		$response = curl_exec($ch);
		curl_close($ch);
		return ($response != "fail");
	}

	/** Envoi de mails via mailgun avec prise en compte de la prod
	 *
	 * Cette fonction a pour but de permet un envoi simple de mail tout en prenant en compte une mesure de securite
	 * vis a vis de la prod ou de la preprod. Ainsi si le site n'est pas dans une configuration de prod, les mails
	 * seront automatiquement rediriger vers l'addresse mail teamdev@meilleurescpi.com
	 *
	 * @param $destinataire
	 * @param $subject
	 * @param $content
	 * @param $entite
	 * @param string $from
	 * @param array $bcc
	 * @return mixed
	 */
	public static function sendMail($destinataire, $subject, $content, $entite, $from = "", $bcc = [])
	{
		if (!isProd())
		{
			$subject = "redirection[$destinataire] from [$from] $subject";
			$destinataire = "teamdev@meilleurescpi.com";
			$bcc = ["teamdev@meilleurescpi.com"];
		}
		self::instanciateApi();
		if (empty($from))
			$from = self::$_from;

		return (self::$_apiMail->sendMessage(
			self::$_domain,
			array(
				"from"		=> $from,
				"to"		=> "$entite <$destinataire>",
				"bcc"		=> $bcc,
				"subject"	=> $subject,
				"html"		=> $content
			)
		));
	}

	public static function sendToDhFromConseiller($dh, $subject, $content)
	{
		// Insertion d'un nouveau logs
		$currentDh = Dh::getCurrent();
		if (!empty($currentDh))
			$id_dh = $currentDh->id_dh;
		else
			$id_dh = 0;
		$rt = self::sendMail($dh->getLogin(), $subject, $content, $dh->getShortName(), $dh->getConseiller()->getShortName()." <" . $dh->getConseiller()->getLogin() . ">");
		$params = [
			"adresse" => $dh->getLogin(),
			"sujet" => $subject,
			"contenu" => $content,
			"id_mailChimp" => $rt->http_response_body->id,
			"retour" => $rt->http_response_body->message,
			"code" => $rt->http_response_code
		];
		Logger::setNew("Envoi d'un mail", $id_dh, $dh->id_dh, $params);
		return ($rt);
	}

	public static function sendToDh($dh, $subject, $content)
	{
		// Insertion d'un nouveau logs
		$currentDh = Dh::getCurrent();
		if (!empty($currentDh))
			$id_dh = $currentDh->id_dh;
		else
			$id_dh = 0;
		$rt = self::sendMail($dh->getLogin(), $subject, $content, $dh->getShortName());
		$params = [
			"adresse" => $dh->getLogin(),
			"sujet" => $subject,
			"contenu" => $content,
			"id_mailChimp" => $rt->http_response_body->id,
			"retour" => $rt->http_response_body->message,
			"code" => $rt->http_response_code
		];
		Logger::setNew("Envoi d'un mail", $id_dh, $dh->id_dh, $params);
		return ($rt);
	}

    public static function sendToDhWithFrom($dh, $subject, $content, $from)
    {
        // Insertion d'un nouveau logs
        $currentDh = Dh::getCurrent();
        if (!empty($currentDh))
            $id_dh = $currentDh->id_dh;
        else
            $id_dh = 0;
        $rt = self::sendMail($dh->getLogin(), $subject, $content, $dh->getShortName(),$from);
        $params = [
            "adresse" => $dh->getLogin(),
            "sujet" => $subject,
            "contenu" => $content,
            "id_mailChimp" => $rt->http_response_body->id,
            "retour" => $rt->http_response_body->message,
            "code" => $rt->http_response_code
        ];
        Logger::setNew("Envoi d'un mail", $id_dh, $dh->id_dh, $params);
        return ($rt);
    }

	public static function sendToMscpi($dh, $subject, $content) {
		$arr = explode('@', $dh->getLogin());
		$domain = array_pop($arr);
		//echo $domain ; exit();
		if  (strcmp($domain, "meilleurescpi.com") != 0)
			return (false);
		return (self::sendToDh($dh, $subject, $content));
	}

	public static function sendToPp($Pp, $subject, $content)
	{
		// Insertion d'un nouveau logs
		$dh = $Pp->getDh();
		$currentDh = Dh::getCurrent();
		if (!empty($currentDh))
			$id_dh = $currentDh->id_dh;
		else
			$id_dh = 0;
		$rt = self::sendMail($Pp->getMail(), $subject, $content, $Pp->getShortName());
		$params = [
			"Precision" => "Envoi a une personne Physique",
			"adresse" => $Pp->getMail(),
			"sujet" => $subject,
			"contenu" => $content,
			"id_mailChimp" => $rt->http_response_body->id,
			"retour" => $rt->http_response_body->message,
			"code" => $rt->http_response_code
		];
		Logger::setNew("Envoi d'un mail", $id_dh, $dh->id_dh, $params);
		return ($rt);
	}

	public static function sendToDhNoLogs($dh, $subject, $content)
	{
		return self::sendMail($dh->getLogin(), $subject, $content, $dh->getShortName());
	}

	public static function sendToDhWithTemplate($dh, $subject, $content, $templateId)
	{
		return self::sendToDh(
			$dh,
			$subject,
			CommunicationTemplate::getById($templateId)->render($dh, $content)
		);
	}

	public static function sendToDhWithTemplateName($dh, $subject, $content, $templateName)
	{
		return self::sendToDh(
			$dh,
			$subject,
			CommunicationTemplate::getByName($templateName)->render($dh, $content)
		);
	}

    public static function sendToDhWithTemplateNameAndFrom($dh, $subject, $content, $templateName,$from)
    {
        return self::sendToDhWithFrom(
            $dh,
            $subject,
            CommunicationTemplate::getByName($templateName)->render($dh, $content),
            $from
        );
    }

	public static function sendToMscpiWithTemplate($dh, $subject, $content, $templateId)
	{
		return self::sendToMscpi(
			$dh,
			$subject,
			CommunicationTemplate::getById($templateId)->render($dh, $content)
		);
	}

	public static function sendToMscpiWithTemplateName($dh, $subject, $content, $templateName)
	{
		return self::sendToMscpi(
			$dh,
			$subject,
			CommunicationTemplate::getByName($templateName)->render($dh, $content)
		);
	}

	public static function sendToDhWithTemplateForTask($datas)
	{
		extract($datas);
		return self::sendToDhWithTemplate(
			Dh::getById($dh),
			$title,
			$content,
			$templateId
		);
	}

	public static function sendToDhForLogs($datas)
	{
		extract($datas);
		return self::sendToDhNoLogs(
			Dh::getById($dh),
			$title,
			$content
		);
	}

	public static function sendBatch( $subject, $txt_content, $html_content, $recipients, $from = "")
	{
		self::instanciateAPi();
		$bm = self::$_apiMail->BatchMessage(self::$_domain);

		if (!empty($from))
			$bm->setFromAddress($from);
		else
			$bm->setFromAddress(self::$_from);
		$bm->setSubject($subject);
		if (!empty($html_content))
			$bm->setHtmlBody($html_content);
		if (!empty($txt_content))
			$bm->setTextBody($txt_content);

		//$bm->setClickTracking(true);

		foreach ($recipients as $address => $attributes)
		{
			if (!isProd())
				$bm->AddToRecipient("teamdev@meilleurescpi.com", $attributes);
			else
				$bm->AddToRecipient($address, $attributes);
		}
		$bm->finalize();
	}
}
