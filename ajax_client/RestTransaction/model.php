<?php

$action = (!empty($_POST['action'])) ? $_POST['action'] : $_GET['action'] ;
$data = (!empty($_POST['data'])) ? $_POST['data'] : $_GET['data'] ;

if ($action == 'read')
	$this->readTransaction($data);
else if ($action == 'read_all')
	$this->readAllTransaction($data);
else if ($action == 'add')
	$this->createTransaction($data);
else if ($action == 'delete')
	$this->deleteTransaction($data);
else if ($action == 'sell')
	$this->sellTransaction($data);
else if ($action == 'update')
	$this->updateTransaction($data);
else if ($action == 'read_doc')
	$this->getDocument($data);
else if ($action == 'add_doc')
	$this->saveDocument($data);