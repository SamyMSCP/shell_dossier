<?php
if ($this->collaborateur->type == "prospecteur")
{
	$this->onglets = array(
		"OUTILS" => "OutilsProspecteur",
		"SUIVI" => "SuiviClient2",
		//"PERSONNES" => "PersonneClient2",
		"PERSONNES" => "PersonnePhysiqueV2",
		"LOGS" => "LogsClient"
	);
}
else if ($this->dh->getType() == "origine_contact") {
	$this->onglets = array(
		"SUIVI" => "SuiviClient2",
		//"PERSONNES" => "PersonneClient2",
		"PERSONNES" => "PersonnePhysiqueV2",
		"LOGS" => "LogsClient",
		"FILLEULS" => "ModuleFilleul"
	);
}
else if ($this->collaborateur->type == "chefprojet")
{
	$this->onglets = array(
		"SYNTHESE" => "SyntheseClient",
		"DONNEUR D'ORDRE" => "DonneurDOrdreClient",
		"SUIVI" => "SuiviClient2",
		//"PROJETS" => "ProjetClient2",
		"PROJETS" => "ProjetV2",
		"BENEFICIAIRES" => "BeneficiaireV2",
		//"BENEFICIAIRES" => "BeneficiaireClient2",
		//"PERSONNES" => "PersonneClient2",
		"PERSONNES" => "PersonnePhysiqueV2",
		"LOGS" => "LogsClient"
	);
}
else if ($this->collaborateur->type != "yoda" && ($this->collaborateur->type != "assistant" || $this->dh->isVip()) && $this->collaborateur->type != "backoffice" && $this->collaborateur->id_dh != $this->dh->conseiller)
{
	$this->onglets = array(
		"SUIVI" => "SuiviClient2"
	);
}
else
{
	$this->onglets = array(
		"SYNTHESE" => "SyntheseClient",
		"DONNEUR D'ORDRE" => "DonneurDOrdreClient",
		"SUIVI" => "SuiviClient2",
		//"PROJETS" => "ProjetClient2",
		"PROJETS" => "ProjetV2",
		"BENEFICIAIRES" => "BeneficiaireV2",
		//"PERSONNES" => "PersonneClient2",
		"PERSONNES" => "PersonnePhysiqueV2",
		"OPPORTUNITÉ" => "OpportuniteClient",
		"MAILS" => "MailClientSend",
		"LOGS" => "LogsClient"
	);
	if (count($this->dh->getFilleuls()) > 0)
		$this->onglets["FILLEULS"] = "ModuleFilleul";
}

foreach ($this->onglets as $key => $elm) {
	$this->loadModuleAdmin($elm, $elm, array(
		"collaborateur" => $this->collaborateur,
		"dh" => $this->dh,
		"table" => $this->table,
		"tableBen" => $this->tableBen
	));
}
