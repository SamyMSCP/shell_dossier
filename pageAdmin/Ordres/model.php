<?php
$this->is_back = true;
$dh = Dh::getCurrent();
//$dh = Dh::getById(10);

$dataTransaction = $dh->getCacheArrayTable();

$this->collaborateur = Dh::getCurrent();
$this->loadModuleAdmin("Nav", "Nav", array("collaborateur" => $this->collaborateur));

$this->loadModuleAdmin("OrderScrapListStore", "OrderScrapListStore", []);

$this->loadModule("ToolTip", "ToolTip", array());
