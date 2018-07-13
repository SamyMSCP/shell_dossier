<?php
$this->dh = Dh::getCurrent();
$this->loadModule('TransactionFrontStore','TransactionFrontStore', ['dh' => $this->dh]);
$this->loadModule('TransactionComponent','TransactionComponent');

$this->loadModule('Nav2', 'Nav2');
$this->loadModule('ToolTip','ToolTip');