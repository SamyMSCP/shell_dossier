<?php
$this->logs = Logs::getAllByDate();
if (isset($GLOBALS['GET']['idlog']))
{
//	$this->logger = Logger::getByTypeId(intval($GLOBALS['GET']['idlog']));
	$this->logger = Logger::getByTypeIdForModule(intval($GLOBALS['GET']['idlog']));
}
else
{
	$this->logger = Logger::getAllForModule();
}

$tmp = [];
foreach ($this->logger as $key => $elm)
{
	if (intval($elm->id_client) >= 1 && $this->collaborateur->isMine($elm->getClient()->id_dh))
		$tmp[] = $elm;
}
$this->logger = $tmp;

$this->TypeLogger = TypeLogger::getAll();
usort($this->logger, function($a, $b) {
	return ($b->getDate()->getTimestamp() - $a->getDate()->getTimestamp());
});

/*	
foreach (Logs::getAllByDate() as $key => $elm)
{
	if ($this->collaborateur->getType() == "conseiller" && $elm->lien_dh != $this->collaborateur->id_dh)	
		continue ;
	if (!isset($this->logs[$elm->lien_dh]))
		$this->logs[$elm->lien_dh] = array();
	$this->logs[$elm->lien_dh][] = $elm;
}
*/
