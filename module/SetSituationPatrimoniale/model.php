<?php

$this->color = array(
		"#0085A9",
		"#014C7F",
		"#002640",
		"#006D7F",
		"#00C3E5",
		"#007F6C",
		"#007F6C",
		"#008A5E",
		"#0073B1",
		"#009491",
		"#00402B",
		"#01528A",
		"#007F3F"
	);

if(isset($_POST['action']) && $_POST['action'] == "setSituationPatrimoniale")
{
	$this->insertSituationPatrimoniale();
//	$this->setSituationJuridique();
}

$this->SituationPatrimoniale = $this->Pp->getLastSituationPatrimoniale();

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
