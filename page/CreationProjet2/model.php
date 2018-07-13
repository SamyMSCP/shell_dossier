<?php
$this->dh = Dh::getCurrent();
$dataTransaction = $this->dh->getCacheArrayTable();

$this->loadModule("MonCompte", "MonCompte", array(
	"dh" => $this->dh,
	"table" => $dataTransaction
	)
);

$this->loadModule('Nav2', 'Nav2');
$this->loadModule('ToolTip','ToolTip');

$this->loadModule("VueJsBaseComponent", "VueJsBaseComponent", []);
$this->loadModule("AdressePostaleComponent", "AdressePostaleComponent", ["dh" => $this->dh]);

$this->loadModule("Loading", "Loading", array());
$this->loadModule("ModuleBarre", "ModuleBarre", array("dh" => $this->dh));
