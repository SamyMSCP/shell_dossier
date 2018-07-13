<?php

if ($this->dh instanceof Dh)
	$this->dhStore = $this->dh->getForFrontStore();
else
	$this->dhStore = null;


$this->AllTransaction = [];
foreach ($this->dh->getTransaction() as $key => $elm)
{
	$this->AllTransaction[] = $elm->getForStore();
}
$this->StatusTransaction = StatusTransaction::getLst();
$this->RequiredDocumentTransaction = Transaction::getRequiredTypeDocument();
$this->ProprieteTransaction = Transaction::getTypeProLst();
$this->MarcherTransaction = Transaction::getMarcheLst();


$this->transact =  (isset($GLOBALS['GET']['transac'])) ? $GLOBALS['GET']['transac'] : null;
