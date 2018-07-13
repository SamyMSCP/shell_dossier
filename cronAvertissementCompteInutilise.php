<?php
try
{
	require_once 'app.php';
	Cli::cli_only();
	if (($ct = CommunicationTemplate::getFromKeyValue('name', 'avert_block_account')) == null)
		throw new Exception("Template avert_block_account introuvable", 1);
	$ct = $ct->getContent();

	$req = <<<SQL
SELECT `DONNEUR D'ORDRE`.* 
FROM `DONNEUR D'ORDRE` 
LEFT JOIN `TRANSACTION` ON `DONNEUR D'ORDRE`.`id_dh` = `TRANSACTION`.`id_donneur_ordre` 
WHERE `page` = "front" 
AND `DONNEUR D'ORDRE`.`type` IS NULL 
AND `remove_access` = 0 
AND `id_donneur_ordre` IS NULL 
AND `ko` != 1 
AND `logger`.`type` IS NULL 
AND `day` IS NOT NULL AND DATEDIFF(`day`, NOW()) <= -30 
GROUP BY `DONNEUR D'ORDRE`.`id_dh`
SQL;
/*$req = "SELECT `DONNEUR D'ORDRE`.*
FROM `DONNEUR D'ORDRE` WHERE `id_dh` = 10";*/
	$ret = Database::prepare("mscpi_db", $req, [], 'Dh');

	if (!empty($ret))
	{
		$recipients = $cs = [];

		foreach ($ret as $user )
		{
			if ($user->conseiller >= 1)
			{
				if (empty($cs[$user->conseiller]))
				{
					$tmp = Dh::getById($user->conseiller);
					$cs[$user->conseiller] = [
						'name' => $tmp->getPersonnePhysique()->getFirstName() . ' ' . $tmp->getPersonnePhysique()->getName(),
						'login' => $tmp->getLogin()
					];
				}
				$recipients[$user->conseiller][$user->getLogin()] = [
					'short_name' => $user->getShortName(),
					'conseiller' => $cs[$user->conseiller]['name']
				];
				Logger::setNew('Envoi d\'un mail', 0, $user->id_dh, ["Mail automatique" => "Avertissement compte non vérifié au bout d'un mois"]);
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
						MailSender::sendBatch("Merci de valider votre compte MeilleureSCPI.com", $ct, "", $clients, $from);
					var_dump($clients, $from);
				}
			}
		}
	}
}
catch (Exception $e)
{
	error_log($e->getMessage());
}
