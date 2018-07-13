<?php
$this->TransactionsList = [];

foreach(Transaction::getAll() as $tr)
{
	$this->TransactionsList[] = $tr->getForStoreMini();
}