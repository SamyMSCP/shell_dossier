<?php
if(isset($_POST['action']) && $_POST['action'] == "setSituationJuridique")
{
	$this->insertSituationJuridique();
}

$this->SituationJuridique = $this->Pp->getLastSituationJuridique();

$this->loadModule("ToolTip", "ToolTip", array());

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


function extractAdressNumExt($add) {
	$tmp = "/^\s*([0-9]+)\s*(.{0,8})$/";
	$arr = [];
	preg_match($tmp, $add, $arr);
	return ($arr);
}

function inLstNationalite($toFind, $lstNat)
{
	foreach ($lstNat as $key => $elm)
		if ($toFind == $elm['title'])
			return (true);
	return (false);
}
