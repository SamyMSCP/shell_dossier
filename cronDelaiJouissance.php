<?php
try
{
	require_once 'app.php';

	Cli::cli_only();

	if (($ct = CommunicationTemplate::getById(15)) == null)
		throw new Exception("Template 15  - Délai jouissance - introuvable", 1);
	$ct = $ct->getContent();

	$date = new DateTime();

$req = "
SELECT *
FROM `TRANSACTION`
WHERE `info_trans` LIKE ?
";
	$ret = Database::prepare('mscpi_db', $req, ['MS.C'], 'Transaction');
var_dump(count($ret));
	if (!empty($ret))
	{
		$recipients = [];
		foreach ($ret as $transac)
		{
			$date_entre_joui = $transac->getDelaiJouissance()->getEntreeJouissanceStr();
var_dump($date->format('m/Y'), $date_entre_joui);

			if (strpos($date_entre_joui, $date->format('m/Y')) > 1)
			{
				$user = $transac->getDh();
				if ($user && $user->getConseiller())
				{
					// Informations du conseiller
					if (empty($cs[$user->getConseiller()->getId()]))
					{
						$cs[$user->getConseiller()->getId()] = [
							'name' => $user->getConseiller()->getPersonnePhysique()->getFirstName() . ' ' . $user->getConseiller()->getPersonnePhysique()->getName(),
							'login' => $user->getConseiller()->getLogin()
						];
					}

					$scpi = SCPI::getFromId($user_transac['id_scpi']);

					$recipients[$user_transac['conseiller']][$user->getLogin()] = [
						'short_name' => $user->getShortName(),
						'date_enreg' => date_fr($date_enreg->format("d F Y")),
						'date_du_jour' => date_fr($date_entre_joui->format("d F Y")), //$date_deb->format('d/m/Y'),
						'type_pro' => ft_decrypt_crypt_information($user_transac['type_pro']),
						'nbr_part' => $user_transac['nbr_part'],
						'nom_scpi' => $scpi->name,
					 	'conseiller' => $cs[$user_transac['conseiller']]['name']
					];
					Logger::setNewByTypeId(38, 0, $user_transac['id_dh'], ["Mail automatique" => "Entrée en jouissance d'une transaction"]);
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
						MailSender::sendBatch("Votre investissement SCPI entre en jouissance - %recipient.nom_scpi% - MeilleureSCPI.com", $ct, "", $clients, $from);
					else
						var_dump($clients, $from);
				}
			}
		}
	}
	else
		throw new Exception("Pas de transaction");
}
catch (Exception $e)
{
	if (isProd())
		error_log($e->getMessage());
	else
		var_dump($e->getMessage());
}
