<?php

if(isset($_POST['action']) && $_POST['action'] == "setNewProject")
{
	$this->setNewProject();
}

$this->loadModule("ProgressBlock", "ProgressBlock3", array(
	"prc" => 1,
	"data" =>array(
		"Vos objectifs & lettre de mission",
		"Votre projet  d’investissement",
		"Votre situation juridique, financière, fiscale et patrimonial",
		"Vos connaissances",
		"Commencement de votre projet d’investissement"
	)
));

$this->loadModule("ToolTip", "ToolTip", array());

$this->AllPp = $this->dh->getAllPersonnePhysique();

$this->otherPp = array();
$this->enfants = $this->dh->getEnfants();
$this->Pm = $this->dh->getAllPersonneMorale();

foreach ($this->AllPp as $key => $elm)
{
	if ($elm->id_phs != $this->dh->lien_phy && !$elm->getIsChild())
		$this->otherPp[] = $elm;
}

$this->dataNeed = array(
	"otherEnfantPp" => count($this->enfants),
	"otherPp" => count($this->otherPp),
	"haveCouple" => $this->dh->haveCouple(),
	"nbrPm" => count($this->Pm)
);
