<?php
$this->loadModule('PortefeuilleAddScpi','PortefeuilleAddScpi');
$this->loadModule('PortefeuilleDeleteScpi','PortefeuilleDeleteScpi');
$this->loadModule('PortefeuilleModaleList','PortefeuilleModaleList');
$this->loadModule('TransactionFrontComponent','TransactionFrontComponent', ["dh" => Dh::getCurrent()]);