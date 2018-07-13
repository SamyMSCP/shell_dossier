<?php

$collaborateur = Dh::getCurrent();
$client = $collaborateur->getMyClients();

if (empty($client))
{
	echo json_encode(["nom" => "No", "prenom" => "client", "id" => "2"]);
	exit();
}
if (empty($GLOBALS['GET']['pattern']) || ($pattern = filter_var($GLOBALS['GET']["pattern"], FILTER_DEFAULT)) === false)
{
	echo '[]';
	exit();
}

$this->tab = [];

foreach ($client as $val)
{

	if ($collaborateur->type != "assistant" && $collaborateur->type != "prospecteur" && $collaborateur->type != "yoda" && $collaborateur->type != "backoffice" && $collaborateur->id_dh != $val->conseiller && $this->dh->vip)
		continue ;
	$r = ["nom" => $val->getPersonnePhysique()->getName(), "prenom" => $val->getPersonnePhysique()->getFirstName(), "id" => $val->id_dh, "pos" => -1];
	if (($pos = mb_stripos($r["nom"], $pattern)) !== FALSE || (($pos = mb_stripos($r["prenom"], $pattern)) !== FALSE &&  $pos += 1000))
	{
		$r["pos"] = $pos;
		$this->tab[] = $r;
		usort($this->tab, function ($a, $b) {
			if (($x = $a['pos'] <=> $b['pos']) === 0)
				return ($a['pos'] >= 1000) ? strcasecmp($a["prenom"], $b["prenom"]) : strcasecmp($a["nom"], $b["nom"]);
			return $x;
		});
	}
	//echo stristr($r["nom"], $pattern),' ', stristr($r["prenom"], $pattern),' ', $r["pos"], PHP_EOL;
}
//if (!empty($this->tab))
	//array_walk($this->tab, function(&$ar, $k) { array_pop($ar); });
echo json_encode($this->tab);
exit();
