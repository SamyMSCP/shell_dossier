<?php
$this->dh = (!empty($GLOBALS['GET']['gdh']))? Dh::getById((int)ft_decrypt_crypt_information($GLOBALS['GET']['gdh'])) : Dh::getCurrent();
if (is_bool($this->dh))
	die();
$this->table = $this->dh->getCacheArrayTable();

$this->dividendes = $this->table['precalcul'];

$this->loadModule("ToolTip", "ToolTip", []);

$this->loadModule('RepartitionAcceuil', 'RepartitionAcceuil', ['dh' => $this->dh, 'table' => $this->table, 'pdf' => 1]);
$this->loadModule('RepartitionGeographique', 'RepartitionGeographique', ['dh' => $this->dh, 'table' => $this->table, 'pdf' => 1]);
$this->loadModule('RepartitionParCategorie', 'RepartitionParCategorie', ['dh' => $this->dh, 'table' => $this->table, 'pdf' => 1]);
$this->loadModule('TauxDOccupation', 'TauxDOccupation', ['dh' => $this->dh, 'table' => $this->table, 'pdf' => 1]);
