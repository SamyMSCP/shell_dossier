<?php

$this->Transactions = [];

if (($tr = $this->dh->getTransaction()))
{
	foreach ($tr as $k => $v)
	{
		$this->Transactions[] = $v->getForFrontStore();
	}
}

$this->StatusTransaction = StatusTransaction::getLst();
$this->proprieteTransaction = Transaction::getTypeProLst();
$this->marcherTransaction = Transaction::getMarcheLst();

		//var_dump($this->Transactions);
		//exit();

