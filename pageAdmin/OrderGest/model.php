<?php
$this->is_back = true;
$this->collaborateur = Dh::getCurrent();
$this->loadModuleAdmin("Nav", "Nav", array("collaborateur" => $this->collaborateur));
$this->loadModule("OrderStore", "OrderStore", []);
$this->loadModuleAdmin("OrderSocietyStore", "OrderSocietyStore", []);
$this->loadModuleAdmin("OrderScrapListStore", "OrderScrapListStore", []);
$this->loadModuleAdmin("ScpiStore", "ScpiStore", []);
$this->loadModuleAdmin("OrderList", "OrderList", []);
$this->loadModuleAdmin("OrderNewScpi", "OrderNewScpi", []);

$this->loadModuleAdmin("OrderStats", "OrderStats", []);

