<?php
try {
	require_once("app.php");

	Cli::cli_only();
	if (($ct = CommunicationTemplate::getFromKeyValue('name', 'client_not_connected')) == null)
		throw new Exception("Template client_not_connected introuvable", 1);
	$ct = $ct->getContent();

	define('CRM_MAX_PER_DAY', 5);

	$req = <<<SQL
SELECT `DONNEUR D'ORDRE`.* 
FROM `DONNEUR D'ORDRE` 
LEFT JOIN `logger` ON `logger`.`id_client` = `DONNEUR D'ORDRE`.`id_dh` AND `logger`.`type` = 39 
WHERE `DONNEUR D'ORDRE`.`type` = "client" 
AND `mdp_tmp` = 1
AND `conseiller` != 4
AND `logger`.`id_client` IS NULL
GROUP BY `DONNEUR D'ORDRE`.`id_dh`
ORDER BY `conseiller`
SQL;

//$req = "SELECT `DONNEUR D'ORDRE`.* FROM `DONNEUR D'ORDRE` WHERE `id_dh` = 868";
	$ret = Database::prepare("mscpi_db", $req, [], 'Dh');

	if (!empty($ret))
	{
		$recipients = $cs = [];

		$comment = "Le client ne s'est jamais connecté à son compte, un rappel lui a été transmis par mail.";
		foreach ($ret as $user)
		{
			if ($user->conseiller >= 1)
			{
				if (isset($recipients[$user->conseiller]) && sizeof($recipients[$user->conseiller]) == CRM_MAX_PER_DAY)
					continue ;
				if (empty($cs[$user->conseiller]))
				{
					$tmp = Dh::getById($user->conseiller);
					$cs[$user->conseiller] = [
						'name' => $tmp->getPersonnePhysique()->getFirstName() . ' ' . $tmp->getPersonnePhysique()->getName(),
						'login' => $tmp->getLogin(),
						'telephone' => $tmp->getPersonnePhysique()->getPhone()
					];
				}
				$recipients[$user->conseiller][$user->getLogin()] = [
					'login' => $user->getLogin(),
					'short_name' => $user->getShortName(),
					'conseiller' => $cs[$user->conseiller]['name'],
					'conseiller_telephone' => $cs[$user->conseiller]['telephone'],
					'conseiller_mail' => $cs[$user->conseiller]['login']
				];
				Logger::setNew('Envoi d\'un mail', 0, $user->id_dh, ["Mail automatique" => "Client non connecté : renvoi de ses identifiants"]);
				$date_crm = new DateTime();
				$date_crm->setTime(8,0)->modify('+ 3 day');
				Crm2::insertNew($user->id_dh, 1, 1, $date_crm->getTimestamp(), -2700, $comment, [], 0);
			}
		}

		if (!empty($recipients))
		{
			foreach ($recipients as $conseiller => $clients)
			{
				if (!empty($cs[$conseiller]) && !empty($clients))
				{
					$from = $cs[$conseiller]['name'] . " <" . $cs[$conseiller]['login'] . ">";
					if (isProd())
						MailSender::sendBatch("Rappel de vos identifiants - moncompte.MeilleureSCPI.com", $ct, "", $clients, $from);
					//var_dump($clients, $from);
				}
			}
		}
	}
}
catch (Exception $e)
{
	error_log($e->getMessage());
}
?>
