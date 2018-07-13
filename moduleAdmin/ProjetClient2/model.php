<?php
$this->loadModule("PieChartComponent", "PieChartComponent", []);
$this->loadModule("RepartitionComponent", "RepartitionComponent", []);
$this->loadModuleAdmin("ProfilInvestisseurStore", "ProfilInvestisseurStore", []);
$this->okok = Scpi::getAll();

$this->allProject = [];
//foreach ($this->dh->getProjets() as $key => $elm)
{
	//$this->allProject[] = $elm;
	$this->allProject = $this->dh->getProjets();
}


/*
$this->loadModuleAdmin("Vuejs", "Vuejs",[
	"dh" => $this->dh
]);
*/
