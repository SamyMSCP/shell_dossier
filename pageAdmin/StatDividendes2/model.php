<?php
if (isset($GLOBALS['GET']['client']))
{
	$this->client = Dh::getById($GLOBALS['GET']['client']);
	$this->trans = $this->client->getTransaction();
}
else if (isset($GLOBALS['GET']['transaction']))
{
	//$this->client = Dh::getById($GLOBALS['GET']['client']);
	$this->trans = Transaction::getFromId($GLOBALS['GET']['transaction']);
}
