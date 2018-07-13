<?php
try
{
	require_once 'app.php';
	Cli::cli_only();

	if (($ct = CommunicationTemplate::getFromKeyValue('name', 'renseignement_centre_interet')) == null)
		throw new Exception("Template renseignement_centre_interet non trouvé", 1);
	$ct = $ct[0]->getContent();

	$req = <<<SQL
SELECT `DONNEUR D'ORDRE`.*
FROM `DONNEUR D'ORDRE`
LEFT JOIN `dh_centre_interet` ON `DONNEUR D'ORDRE`.`id_dh` = `dh_centre_interet`.`id_dh`
LEFT JOIN `dh_centre_interet_scpi` ON `DONNEUR D'ORDRE`.`id_dh` = `dh_centre_interet_scpi`.`id_dh`
WHERE `dh_centre_interet_scpi`.`id_dh` IS NULL
AND `dh_centre_interet`.`id_dh` IS NULL
AND `page` = 'front'
AND `remove_access` = 0
AND (`ko` != 1 OR `ko` IS NULL)
SQL;
//$req = "SELECT * FROM `DONNEUR D'ORDRE` WHERE `id_dh` = 868;";
	$ret = Database::prepare("mscpi_db", $req, [], 'Dh');

	if (!empty($ret))
	{
		$recipients = $cs = [];

		foreach ($ret as $user)
		{
			if ($user->conseiller >= 1)
			{
				if (empty($cs[$user->conseiller]))
				{
					$tmp = Dh::getById($user->conseiller);
					$cs[$user->conseiller] = [
						'name' => $tmp->getPersonnePhysique()->getFirstName() . ' ' . $tmp->getPersonnePhysique()->getName(),
						'login' => $tmp->getLogin(),
						'telephone' => $tmp->getPersonnePhysique()->getPhone()
					];
				}
				$recipients[$user->conseiller][$user->getLogin()] =  [
					'login' => $user->getLogin(),
					'short_name' => $user->getShortName(),
					'conseiller' => $cs[$user->conseiller]['name'],
					'conseiller_telephone' => $cs[$user->conseiller]['telephone'],
					'conseiller_mail' => $cs[$user->conseiller]['login']
				];
				Logger::setNew("Envoi d'un mail", 0, $user->id_dh, ["Mail automatique" => "Préférences de communication non renseignée"]);
			}
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
					MailSender::sendBatch("Vous n'avez pas renseigner vos préférences de communication !", $ct, "", $clients, $from);
				//var_dump($clients, $from);
			}
		}
	}
}
catch (Exception $e)
{
	error_log($e->getMessage());
}
