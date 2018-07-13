<?php
if (isset($GLOBALS['GET']['client']))
	$this->lstOpportunite = Opportunity::getFromKeyValue('id_author', intval($GLOBALS['GET']['client']));
else
	$this->lstOpportunite = Opportunity::getAllForStore();
