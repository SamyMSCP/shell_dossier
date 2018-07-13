<?php
/**
 * Created by PhpStorm.
 * User: vthomas
 * Date: 07/02/2018
 * Time: 17:12
 * @desc This script is a cron file for sending mails auto when we start jouissance, end demenbrement or two month before demembrement end
 */

require_once "app.php";

Cli::cli_only();
$req = "";

$dbg = false; /// Enabling this will enable force datetime for debuging
$dbg_usu = false; /// Enablig this will change the date for the last day of this month


global $type;
$type = [
	"nue" => "bmenfPJ+T/ZRyzmGIYT5V++ppu/ht95k48nMjT+STSw=",
	"usu" => "QKdDk3WWIfRqGBfW76DkPjpHjYqcBNhRGYQGSvl6opA=",
	"pleine" => "8iqbXdNstZEFwqhUElgTE8nzE9OCR0iakMFEJ3KpD90="
];


$today = new DateTime();
$today->setTime(0, 0);
$endof_day = new DateTime();
$endof_day->setTime(23, 59, 59);


if ($dbg) {
	$today = new DateTime();
	$today->setTime(0, 0);
	if ($dbg_usu)
		$today->setDate(intval($today->format("Y")), intval($today->format("m")), 31);
	else
		$today->setDate(intval($today->format("Y")), intval($today->format("m")) + 1, 1);
	$endof_day = clone $today;
	$endof_day->setTime(23, 59, 59);
}

global $date_today;
$date_today = $today->format("d/m/Y");

$transactions = Transaction::getAll();
$tm_start = [];
$ajd_stop = [];
$ajd_start = [];
foreach ($transactions as $trans) {
	$today = null;
	$endof_day = null;
	if ($dbg) {
		$today = new DateTime();
		$today->setTime(0, 0);
		if ($dbg_usu)
			$today->setDate(intval($today->format("Y")), intval($today->format("m")), 31);
		else
			$today->setDate(intval($today->format("Y")), intval($today->format("m")) + 1, 1);
		$endof_day = clone $today;
		$endof_day->setTime(23, 59, 59);
	} else {
		$today = new DateTime();
		$today->setTime(0, 0);
		$endof_day = new DateTime();
		$endof_day->setTime(23, 59, 59);
	}
	/* ************************************************************************************************************** */
	//WORK ON
	//if not nue
	if (!intval($trans->doByMscpi()))
		continue;
	$status = ($trans->getLastStatusTransaction());
	if ((empty($status) || ($status->getStatus()[0] !== "5" && $status->getStatus()[0] !== "6")))
		continue;
	if ($trans->type_pro !== "bmenfPJ+T/ZRyzmGIYT5V++ppu/ht95k48nMjT+STSw=")
		$start = $trans->getDelaiJouissance()->getEntreeJouissance();
	else
		$start = DateTime::createFromFormat("U", $trans->getFinDemembrement());
	$start = ($start == null) ? 0 : $start->getTimestamp();
	$end = 0;
	try {
		if ($trans->type_pro == $type['usu'])
			$end = $trans->calcFinValorisation();
		else if ($trans->type_pro == $type['nue'])
			$end = $trans->calcDebutDividendes();
		$end = ($end == null) ? 0 : $end->getTimestamp();
	} catch (Exception $e) { $end = 0; }
	if ($end >= $today->getTimestamp() && $end <= $endof_day->getTimestamp())// Si sort de demembrement aujourd'hui
		$ajd_stop[] = $trans;
	else if ($start >= $today->getTimestamp() && $start <= $endof_day->getTimestamp())/// si entre en jouissance
		$ajd_start[] = $trans;
/* *********************************************** [ DEUX MOIS AVANT ] *********************************************** */
	try {
		$dt = new DateInterval("P2M");//Two month
//		var_dump($end);
		$tmp = $end;
		$end = new DateTime();
		$end->setTimestamp($tmp);
		$end->sub($dt);
		$end = $end->getTimestamp();
		if ($end >= $today->getTimestamp() && $end <= $endof_day->getTimestamp())
			$tm_start[] = $trans;
	}
	catch (Exception $e) {
		echo $e->getMessage();
	}
/* ************************************************ [ END CONDITION ] ************************************************ */

	try {
		if (!$trans->getEnrDate())
			throw new Exception("Enregistrement Date is empty");
	}
	catch (Exception $e) {
	}
}
//die();
/*
 * Now we got the mailing List.
 * We will get the template
 */

/*
 * We create some class for sending mail for a list
 * Gonna be more adaptive for list usage
 */

/** Class MailSenderList
 * This class is automailing to a list with specific template and information.
 * @author vthomas
 */
class MailSenderList
{
	public $list;
	private $tp;
	private $subject;
	private $crm;
	public static $send_mail = true;///Disable me if debug without mail
	public static $csv = false;
	public static $domain = "https://meilleurescpi.com";
	public static $csv_char = "\t";


	/**
	 * MailSenderList constructor.
	 * @param $list
	 * @param $subject
	 * @param $tp_id
	 * @param $crm
	 * @throws Exception
	 */
	public function __construct($list, $subject, $tp_id, $crm)
	{
		$this->list = $list;
		$this->crm = $crm;
		if (gettype($tp_id) == "array") {
			$this->tp = $tp_id;
			foreach ($tp_id as $key => $el) {
				$tp = CommunicationTemplate::getFromId($el)[0];
				if ($tp == null)
					throw new Exception("Cannot get template " . $el);
				$this->tp[$key] = $tp;
			}
		} else {
			$tp = CommunicationTemplate::getById($tp_id);
			if ($tp == null)
				throw new Exception("Cannot get template " . $tp_id);
			$this->tp = $tp;
		}
		$this->subject = $subject;
	}
	/** Run Auto Sender
	 * This function will run all transaction and send mail to the client
	 */
	public function run()
	{
		//Go see all the list
		$today = new DateTime();
		foreach ($this->list as $el) {
			$tran = Transaction::getFromId($el->id)[0];
			if (!($tran->doByMscpi()))
				continue;
			$tran->enr_date = ft_decrypt_crypt_information($tran->enr_date);

			if ($tran->enr_date === "-")
				$tran->enr_date = "01/01/1970";
			$dh = $tran->getDh();
			$cons = $dh->getConseiller();
			$cons->login = ft_decrypt_crypt_information($cons->login);

			$scpi = SCPI::getFromId($tran->id_scpi);

			$from = $cons->getPersonnePhysique()->getFirstName() . " " . $cons->getPersonnePhysique()->getName() . " <" . $cons->login . ">";
			$for = $dh->getLogin();

			$enr_date = DateTime::createFromFormat("d#m#Y", $tran->enr_date);

			$recipient = [
				"short_name" => $dh->getPersonnePhysique()->getCivilite() . " " .$dh->getPersonnePhysique()->getName(),
				"date_enr" => date_fr($enr_date->format("d F Y")),
				"date_du_jour" => $GLOBALS['date_today'],
				'type_pro' => ft_decrypt_crypt_information($tran->type_pro),
				'nbr_part' => (is_float(floatval($tran->nbr_part)) ? number_format($tran->nbr_part, 2, ",", " ") : $tran->nbr_part),
				'nom_scpi' => substr($scpi->name, 5),
				'conseiller' => $cons->getPersonnePhysique()->getFirstName() . " " . $cons->getPersonnePhysique()->getName(),
				'duree' => $tran->getDemembrement()
			];
			$tp = null;
			if (gettype($this->tp) == "array") {
				if ($tran->type_pro == "bmenfPJ+T/ZRyzmGIYT5V++ppu/ht95k48nMjT+STSw=")
					$tp = $this->tp['nue'];
				else
					$tp = $this->tp['usu'];
			} else {
				$tp = $this->tp;
			}
			if (static::$csv){
				echo $dh->getShortName() . static::$csv_char;
				echo $for . static::$csv_char;
				echo static::$domain . "/?p=EditionClient&client=" . $dh->id_dh . "&transac=" . $tran->id . static::$csv_char;
				echo $this->subject;
				foreach ($recipient as $d)
					echo static::$csv_char . $d;
				echo PHP_EOL;
			}
			else
				echo "\033[90mSending to: <\033[32m " . $for . " \033[90m> for transaction: \033[34;4m/?p=EditionClient&client=" . $dh->id_dh . "&transac=" . $tran->id . "\033[0m\033[90m - About: [\033[33m " . $this->subject. " \033[90m]\033[0m" . PHP_EOL;
			//Prepare mail
			$tp = $tp->render($dh, $tp->getContent());
			foreach ($recipient as $key => $value) {
				$tp = preg_replace("/%recipient\." . $key . "%/", $value, $tp);
			}


				if (isset($this->crm['text']))
					$crm_text = $this->crm['text'];
				else {
					if ($tran->type_pro == "bmenfPJ+T/ZRyzmGIYT5V++ppu/ht95k48nMjT+STSw=")
						$crm_text = $this->crm['nue'];
					else
						$crm_text = $this->crm['usu'];
				}
				$crm_text = preg_replace("/\#id_dh\#/", $dh->id_dh, $crm_text);
				$crm_text = preg_replace("/\#id_trans\#/", $tran->id, $crm_text);
				$crm_text = preg_replace("/##part##/", $tran->getNbrPart(), $crm_text);
				$crm_text = preg_replace("/##scpi##/", $tran->getScpi()->getName(), $crm_text);
				$d = $tran->getDelaiJouissance()->getEntreeJouissance();
				$d = ($d == null) ? 0 : $d->getTimestamp();
				$d = DateTime::createFromFormat("U", "".$d);
				$crm_text = preg_replace("/##date_entre##/", $d->format("d/m/Y"), $crm_text);
				try {
					$end = null;
					if ($tran->type_pro == $GLOBALS['type']['usu'])
						$end = $tran->calcFinValorisation();
					else if ($tran->type_pro == $GLOBALS['type']['nue'])
						$end = $tran->calcDebutDividendes();
					$end = ($end == null) ? 0 : $end->getTimestamp();
				} catch (Exception $e) { $end = 0; }
				$end = DateTime::createFromFormat("U", "".$end);
			$crm_text = preg_replace("/##date##/", ($end)->format("d/m/Y"), $crm_text);

/* ****************************************************************************************************************** */
				$date_execution = new DateTime("NOW");
				$id_crm = Crm2::insertNew(
					$dh->id_dh,
					9,
					0,
					$date_execution->getTimestamp(),
					-2700,
					($crm_text),
					[],
					0
				);
				Crm2::getFromId($id_crm)[0]->updateOneColumn("priority", 3);
/* ****************************************************************************************************************** */
//			$tp = CommunicationTemplate::render($dh, $tp);
			//$cons->login
			if (static::$send_mail)
				MailSender::sendMail($for, $this->subject, $tp, $dh->getShortName(), $from);//TODO: Utiliser le commit qui ajoute le BCC ici
		}
	}
}

try {
	$send_list = [
		new MailSenderList($ajd_start, "Entrée en jouissance de votre SCPI", 41, ["text" => "Entrée en jouissance de ##part## parts de la ##scpi## ce jour"]),
		new MailSenderList($ajd_stop, "Fin de démenbrement pour votre SCPI", ["usu" => 42, "nue" => 43], [
			"usu" => "Fin demembrement usufruit de ##part## parts de la ##scpi## ce jour",
			"nue" => "Fin demembrement Nue propriété de ##part## parts de la ##scpi## ce jour"
		]),
		new MailSenderList($tm_start, "Fin de démenbrement pour votre SCPI dans deux mois", ["usu" => 44, "nue" => 45], [
			"usu" => "Fin demembrement dans 2 mois usufruit de ##part## parts de la ##scpi##,le ##date##",
			"nue" => "Fin demembrement dans 2 mois Nue propriété de ##part## parts de la ##scpi##,le ##date##"
		])
	];
} catch (Exception $e) {
	echo "Something go wrong: " . $e->getMessage() . PHP_EOL;
	die();
}

MailSenderList::$send_mail = true;
MailSenderList::$csv = false;

foreach ($send_list as $el) {
	$el->run();
}
