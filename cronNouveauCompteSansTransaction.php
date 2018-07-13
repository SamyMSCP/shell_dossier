<?php
try
{
	require_once 'app.php';
	Cli::cli_only();

	if (($ct = CommunicationTemplate::getFromKeyValue('name', 'newaccount_notransac')) == null)
		throw new Exception("Template newaccount_notransac introuvable", 1);
	$ct = $ct->getContent();

	$req = <<<SQL
SELECT `DONNEUR D'ORDRE`.*
FROM `DONNEUR D'ORDRE`
LEFT JOIN `TRANSACTION` ON `DONNEUR D'ORDRE`.`id_dh` = `TRANSACTION`.`id_donneur_ordre`
WHERE `page` = "front" AND `DONNEUR D'ORDRE`.`type` IS NULL AND `remove_access` = 0 AND `id_donneur_ordre` IS NULL AND `confirmation` = 0 AND `ko` != 1
AND `day` IS NOT NULL AND DATE_ADD(`day`, INTERVAL 15 DAY) <= NOW()
GROUP BY `DONNEUR D'ORDRE`.`id_dh`
SQL;
/*$req = "
SELECT `DONNEUR D'ORDRE`.*
FROM `DONNEUR D'ORDRE`
WHERE `id_dh` = 10";
*/
	$ret = Database::prepare("mscpi_db", $req, [], 'Dh');

	$recipients = [];

	if (!empty($ret))
	{
		foreach ($ret as $user)
		{
			if ($user->conseiller >= 1)
			{
				$tmp = Dh::getById($user->conseiller);
				$cs[$user->conseiller] = ['name' => $tmp->getPersonnePhysique()->getFirstName() . ' ' . $tmp->getPersonnePhysique()->getName(), 'login' => $user->getLogin()];
				$recipients[$user->conseiller][$user->getLogin()] = ['short_name' => $user->getShortName(), 'conseiller' => $cs[$user->conseiller]['name']];
				Logger::setNew("Envoi d'un mail", 0, $user->id_dh, ["Mail automatique" => "Compte crée depuis quinze jours sans transaction renseignée."]);
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
						MailSender::sendBatch("Utilisez votre compte SCPI et ajouter une SCPI", $ct, "", $clients, $from);
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
