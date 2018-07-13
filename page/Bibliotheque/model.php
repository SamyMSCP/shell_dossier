<?php
$dh = Dh::getCurrent();

$dataTransaction = $dh->getCacheArrayTable();

if (
	$dh->getPersonnePhysique()->getPhone() == "-" ||
	empty($dh->getPersonnePhysique()->getPhone())
)
{
	$this->loadModule("ForceSetPhone", "ForceSetPhone", array("dh" => $dh));
}
$this->loadModule("MonCompte", "MonCompte", array(
	"dh" => $dh,
	"table" => $dataTransaction
	)
);

$this->loadModule("ModuleBibliotheque", "ModuleBibliotheque", array(
	"dh" => $dh
	)
);

$this->loadModule("Nav2", "Nav2", array("dh" => $dh));

$this->loadModule("moduleDocumentDhValidationCGU", "moduleDocumentDhValidation", array(
	"documentTypeName" => "CGU",
	"dh" => $dh
	)
);

$this->loadModule("moduleDocumentDhValidationFIL", "moduleDocumentDhValidation", array(
	"documentTypeName" => "FIL",
	"dh" => $dh
	)
);

$this->loadModule("ToolTip", "ToolTip", array());

$this->loadModule("NotNow", "NotNow", array("dh" => $dh));

$this->loadModule("ModuleBarre", "ModuleBarre", array("dh" => $dh));

$this->loadModule("MessageBox", "MessageBox", []);
$this->loadModule("Loading", "Loading", array());

$this->loadModule("AdressePostaleComponent", "AdressePostaleComponent", ["dh" => $dh]);
