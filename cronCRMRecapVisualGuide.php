<?php
require 'app.php';

Cli::cli_only();
$conseillers = Dh::getConseillers();

$req = <<<SQL
SELECT `id_dh`,`params`,`date`
FROM `logger`
INNER JOIN `DONNEUR D'ORDRE` ON `id_client` = `id_dh`
WHERE `logger`.`type` = ? AND `conseiller` = ?
AND `date` >= ?
ORDER BY `id_client`, `params`, `date` DESC
SQL;

$req_crm = <<<SQL
INSERT INTO `crm2` (`id_client`, `sujetSelected`, `contactSelected`, `date_execution`, `duree`, `commentaire`, `id_user`)
VALUES (?, ?, ?, ?, ?, ?, ?)
SQL;

$date = new Datetime();
$ts = $date->sub(new DateInterval('P7D'))->setTime(0,0,0)->getTimestamp();

foreach ($conseillers as $cs)
{
	$rt = Database::getNoClass("mscpi_db", $req, [42, $cs->id_dh, $ts]);
	if ($rt)
	{
		$clients = [];
		foreach ($rt as $r)
		{
			$doc = unserialize($r['params']);
			if (!isset($clients[$r['id_dh']]))
			{
				$dh = Dh::getById($r['id_dh']);
				$clients[$r['id_dh']] = ['name' => $dh->getShortName(), 'doc' => []];
			}
			$clients[$r['id_dh']]['doc'][$doc["Document"]] = $date->setTimestamp($r['date'])->format('d/m/Y');
		}
		if (!empty($clients))
		{
			$msg = "";
			foreach ($clients as $id => $info)
			{
				$msg.= "<br/>{$info['name']} à consulté :";
				foreach ($info['doc'] as $k => $v)
					$msg.= "\t<br/> - {$k} le {$v}";
			}
			Database::prepareInsertNoSecurity("mscpi_db", $req_crm, [$cs->id_dh, 0, 3, time(), -2700, "Depuis le " . $date->setTimestamp($ts)->format("d/m/Y") . "<br/>" . $msg, $cs->id_dh]);
		}
	}
}
?>
