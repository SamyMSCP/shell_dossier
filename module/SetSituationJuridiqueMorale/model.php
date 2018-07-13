<?php

if(isset($_POST['action']) && $_POST['action'] == "setSituationJuridique")
{
	$this->insertSituationJuridique();
}

$this->SituationJuridique = $this->Pm->getLastSituationJuridique();

$this->AllPp = $this->dh->getAllPersonnePhysique();
$this->otherPp = array();
foreach ($this->AllPp as $key => $elm)
{
	if ($elm->id_phs != $this->dh->lien_phy)
		$this->otherPp[] = $elm;
}

$this->loadModule("ProgressBlock", "ProgressBlock3", array(
	"prc" => 2,
	"data" =>array(
		"Vos objectifs & lettre de mission",
		"Votre projet  d’investissement",
		"Votre situation juridique, financière, fiscale et patrimonial",
		"Vos connaissances",
		"Commencement de votre projet d’investissement"
	)
));
