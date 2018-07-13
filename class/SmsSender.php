<?php
require_once('../vendor/autoload.php');
use \Ovh\Api;

require_once("Dh.php");
require_once("CommunicationTemplate.php");

class SmsSender
{
	private static		$_applicationKey = "dWTSoiiylAWeQGTt";
	private static		$_applicationSecret = "kw0cOJ35YtyRdRlaNlg1ymB0fgC4KzZV";
	private static		$_consumer_key = "HotlvdJ278TmMQOlmK7799eR1SVE7vOR";
	private static		$_endpoint = 'ovh-eu';

	private static		$_conn = null;
	private static		$_smsServices = null;

	private static function instanciateApi()
	{

		if (self::$_conn == null)
		{
			self::$_conn = new Api(
				self::$_applicationKey,
				self::$_applicationSecret,
				self::$_endpoint,
				self::$_consumer_key
			);
		}

		if (self::$_smsServices == null)
			self::$_smsServices = self::$_conn->get('/sms/');

	}
	public static function check($num) {
		self::instanciateApi();
		$dt = (object)array("receivers" => [$num]);
		$resultPostJob = self::$_conn->post('/sms/'. self::$_smsServices[0] . '/hlr/', $dt);
		$ids = $resultPostJob['ids'][0];
		$rt = null;
		while ($rt === null)
		{
			$result = self::$_conn->get('/sms/'. self::$_smsServices[0] . "/hlr/$ids");
			if ($result['status'] == "todo")
			{
				sleep(1);
				continue ;
			}
			if ($result['valid'] === true)
				return (true);
			return (false);
		}
		return (false);
	}
	public static function send($num, $content) {
		self::instanciateApi();
		$content = (object) array(
			"charset"=> "UTF-8",
			"class"=> "phoneDisplay",
			"coding"=> "8bit",
			'sender' => 'MSCPI',
			"message"=> strip_tags($content),
			"noStopClause"=> TRUE,
			"priority"=> "high",
			"receivers"=> [ $num ],
			"senderForResponse"=> false,
			"validityPeriod"=> 2880
		);
		$resultPostJob = self::$_conn->post('/sms/'. self::$_smsServices[0] . '/jobs/', $content);
		$smsJobs = self::$_conn->get('/sms/'. self::$_smsServices[0] . '/jobs/');
		//dbg($resultPostJob);
		//dbg($smsJobs);
	}
	public static function sendToDh($dh, $subject, $content, $num = null) {
		self::instanciateApi();
		if ($num == null)
			$num = $dh->getPersonnePhysique()->getPhone();
		$content = (object) array(
			"charset"=> "UTF-8",
			"class"=> "phoneDisplay",
			"coding"=> "8bit",
			'sender' => 'MSCPI',
			"message"=> strip_tags($content),
			"noStopClause"=> TRUE,
			"priority"=> "high",
			"receivers"=> [ $num ],
			"senderForResponse"=> false,
			"validityPeriod"=> 2880
		);

		$currentDh = Dh::getCurrent();
		if (!empty($currentDh))
			$id_dh = $currentDh->id_dh;
		else
			$id_dh = 0;
		//$rt = self::sendMail($dh->getLogin(), $subject, $content, $dh->getShortName());
		if (!empty(strstr($_SERVER["REQUEST_URI"], "admin_lkje5sjwjpzkhdl42mscpi.php")) || check_sms_ok())
		{
			$resultPostJob = self::$_conn->post('/sms/'. self::$_smsServices[0] . '/jobs/', $content);
			$smsJobs = self::$_conn->get('/sms/'. self::$_smsServices[0] . '/jobs/');
			$credits = $resultPostJob['totalCreditsRemoved'];
			$invalidReceivers = "";
			foreach ($resultPostJob['invalidReceivers'] as $key => $elm)
			{
				$invalidReceivers .=  $elm . ", ";
			}
			$validReceivers = "";
			foreach ($resultPostJob['validReceivers'] as $key => $elm)
			{
				$validReceivers .=  $elm . ", ";
			}
			$ids = "";
			foreach ($resultPostJob['ids'] as $key => $elm)
			{
				$ids .=  $elm . ", ";
			}
			$params = [
				"numéro" => $num,
				"sujet" => $subject,
				"contenu" => $content->message,
				"credits consomés" => $credits,
				"invalidReceivers" => $invalidReceivers,
				"validReceivers" => $validReceivers,
				"ids" => $ids
			];
			Logger::setNew("Envoi d'un sms", $id_dh, $dh->id_dh, $params);
			if (count($resultPostJob['invalidReceivers']) >= 1)
				return (false);
			else
				return (true);
		}
		else
		{
			Logger::setNew("Abus de ressources sms", $id_dh, $dh->id_dh, []);
			Notif::set("Abus_de_ressource", "Vous avez déjà effectué trop de mofications sur votre compte, merci de réessayer plus tard");
			if (empty($_GET["p"]))
			{
				header("Location: ?logout=" . $_COOKIE['token']);
				exit();
			}
			return (false);
			//header("Location: ?p=" . $_GET["p"]);
			//exit();
		}
	}
	public static function sendToDhWithTemplate($dh, $subject, $content, $templateId)
	{
		return self::sendToDh(
			$dh,
			$subject,
			CommunicationTemplate::getById($templateId)->render($dh, $content)
		);
	}
	public static function sendToDhWithTemplateName($dh, $subject, $content, $templateName, $num = null)
	{
		if ($num == null)
			return self::sendToDh(
				$dh,
				$subject,
				CommunicationTemplate::getByName($templateName)->render($dh, $content)
			);
		else
			return self::sendToDh(
				$dh,
				$subject,
				CommunicationTemplate::getByName($templateName)->render($dh, $content),
				$num
			);
	}

}
