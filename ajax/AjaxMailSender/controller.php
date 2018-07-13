<?php
require_once("class/core/Ajax.php");
require_once("class/MailSender.php");
class AjaxMailSender extends Ajax
{
	protected static $_CI = null;

	private function getConcernedDh()
	{
		if (!empty($_POST['data']['ci']) || !empty($_POST['data']['scpi']))
		{
			$data = [];

			$req_ = "SELECT `Dh`.* FROM `DONNEUR D'ORDRE` as `Dh`";
			$req = " WHERE 1";

			if (!empty($_POST['data']['scpi']) && ($size = count($_POST['data']['scpi'])) > 0)
			{
				$req_.= " LEFT JOIN `dh_centre_interet_scpi` as `TDCIS` ON `Dh`.`id_dh` = `TDCIS`.`id_dh`";
				$req.= " AND TDCIS.`id_scpi` IN (" . implode(',',str_split(str_repeat('?', $size))) . ")";
				$data = array_merge($data, $_POST['data']['scpi']);
			}
			if (!empty($_POST['data']['ci']) && ($size = count($_POST['data']['ci'])) > 0)
			{
				$req_.= " LEFT JOIN `dh_centre_interet` as `TDCI` ON `Dh`.`id_dh` = `TDCI`.`id_dh`";
				$req.= " AND TDCI.`id_ci` IN (" . implode(',', str_split(str_repeat('?', $size))) . ")";
				$data = array_merge($data, $_POST['data']['ci']);
			}
			$req.= " GROUP BY `Dh`.`id_dh`";
			$req_.= $req;
			//var_dump($req_, $data);
			return Database::prepare("mscpi_db", $req_, $data, 'Dh');
		}
		return 0;
	}

	public function count()
	{
		success(['nb' => count($this->getConcernedDh())]);
	}

	private function replace_var($text) 
	{
		$v = [
			'##CIVPRENOMNOM##',
			'##CONSEILLER##',
			'##CONSEILLER_TEL##',
			'##CONSEILLER_MAIL##'
		];
		$r = [
			'%recipient.short_name%',
			'%recipient.conseiller%',
			'%recipient.conseiller_telephone%',
			'%recipient.conseiller_mail%'
		];
		return str_replace($v, $r, $text);
	}

	private static function CiToArray()
	{
		$rt = [];

		foreach (CentreInteret::getAll() as $ci)
		{
			$rt[$ci->id] = $ci;
		}
		return $rt;
	}

	private function getCINames($actu_ci, $dh_ci)
	{
		if (is_null(self::$_CI))
			self::$_CI = self::CiToArray();
		$rt = [];

		if (!empty($actu_ci['ci']))
		{
			foreach ($actu_ci['ci'] as $ci)
			{
				foreach ($dh_ci->getCentreInteret() as $dci)
				{
					if ($dci->id == $ci)
						$rt[] = self::$_CI[$ci]->nom;
				}
			}
		}
		if (!empty($actu_ci['scpi']))
		{
			foreach ($actu_ci['scpi'] as $scpi)
			{
				foreach ($dh_ci->getCentreInteretSCPI() as $dscpi)
				{
					if ($dscpi->id == $scpi)
						$rt[] = SCPI::getFromId($scpi)->name;
				}
			}
		}
		return implode(', ',$rt);
	}

	public function send()
	{
		try
		{
			if (!empty($_POST['data']['message']) && !empty($_POST['data']['title']) && ($lstDh = $this->getConcernedDh()))
			{
				$recipients = $cs = [];

				foreach ($lstDh as $user)
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
					}
					$recipients[$user->conseiller][$user->getLogin()] = [
						'short_name'	=> $user->getShortName(),
						'conseiller'	=> $cs[$user->conseiller]['name'],
						'conseiller_telephone' => $cs[$user->conseiller]['telephone'],
						'conseiller_mail' => $cs[$user->conseiller]['login'],
						'centresinteret' => $this->getCINames($_POST['data'], $user),
							//!empty($_POST['data']['scpi'])
					];
				}
				$message = $this->replace_var($_POST['data']['message']);
				$title = $this->replace_var($_POST['data']['title']);

				if (!empty($_POST['data']['sign']))
				{
					$ct = CommunicationTemplate::getById('2');
					if ($ct != null)
						$message.= $ct->getContent();
				}

				if (!empty($recipients))
				{
					foreach ($recipients as $conseiller => $clients)
					{
						if (!empty($cs[$conseiller]) && !empty($clients))
						{
							$from = $cs[$conseiller]['name'] . " <" . $cs[$conseiller]['login'] . ">";
							//if (isProd())
								MailSender::sendBatch($title,"", $message, $clients, $from);
							//else
								//var_dump($clients, $from);
						}
					}
					success([1]);
				}
			}
		}
		catch (Exception $e)
		{
			error([$e->getMessage]);
		}
	}
}
