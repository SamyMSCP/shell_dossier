<?php

if(isset($_POST['action']) && $_POST['action'] == "setSituationFinanciere")
{
	$this->insertSituationFinanciere();
}

$this->SituationFinanciere = $this->Pp->getLastSituationFinanciere();

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
