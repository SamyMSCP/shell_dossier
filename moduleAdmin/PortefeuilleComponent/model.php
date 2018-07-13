<?php
$this->AllTransaction = [];
foreach ($this->dh->getTransaction() as $key => $elm)
{
	$this->AllTransaction[] = $elm->getForStore();
}

$this->RequiredDocumentTransaction = Transaction::getRequiredTypeDocument();
