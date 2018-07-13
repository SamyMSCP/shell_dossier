<?php
$dh = Dh::getCurrent();
//$dh = Dh::getById(10);
$is_back = false;
$dataTransaction = $dh->getCacheArrayTable();

$this->loadModule("MonCompte", "MonCompte", array(
	"dh" => $dh,
	"table" => $dataTransaction
	)
);

$this->loadModule("Nav2", "Nav2", array(
	"dh" => $dh
));


//$this->loadModule("OpportunityVisual", "OpportuniteListComponent", array());
$this->loadModule("OpportunityVisual", "OpportunityVisual", array());
//$this->loadModule("ToolTip", "ToolTip", array());

//$this->loadModule("AdvancedOpResearch", "AdvancedOpResearch", array());
