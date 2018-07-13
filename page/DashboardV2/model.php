<?php
$this->dh = Dh::getCurrent();
$dataTransaction = $this->dh->getCacheArrayTable();

if (
	$this->dh->getPersonnePhysique()->getPhone() == "-" ||
	empty($this->dh->getPersonnePhysique()->getPhone())
)
{
	$this->loadModule("ForceSetPhone", "ForceSetPhone", array("dh" => $this->dh));
}

$this->loadModule('Nav2', 'Nav2');


$this->loadModule("MonCompte", "MonCompte", array(
        "dh" => $this->dh,
        "table" => $dataTransaction
    )
);

$this->loadModule("RepartitionAcceuil", "RepartitionAcceuil", array(
        "dh" => $this->dh,
        "table" => $dataTransaction
    )
);

$this->loadModule("DividendesAccueil", "DividendesAccueil", array(
        "dh" => $this->dh,
        "table" => $dataTransaction
    )
);

$this->loadModule("ValorisationPF", "ValorisationPF", array(
        "dh" => $this->dh,
        "table" => $dataTransaction
    )
);


$this->loadModule("Loading", "Loading", array());

$this->loadModule("OpportuniteASaisir", "OpportuniteASaisir", array());
$this->loadModule("MonthSuggest", "MonthSuggest", array());

$this->loadModule("ToolTip", "ToolTip", array());
$this->loadModule("NotNow", "NotNow", array("dh" => $this->dh));
$this->loadModule("DernieresActualites", "DernieresActualites", array("dh" => $this->dh));
$this->loadModule("ApercuDeMonPorteFeuilleAccueil", "ApercuDeMonPorteFeuilleAccueil", array("dh" => $this->dh, "data" => $dataTransaction));
$this->loadModule("Footer", "Footer", array("dh" => $this->dh));
$this->loadModule("ModuleBarre", "ModuleBarre", array("dh" => $this->dh));

$this->loadModule("AdressePostaleComponent", "AdressePostaleComponent", ["dh" => $this->dh]);
