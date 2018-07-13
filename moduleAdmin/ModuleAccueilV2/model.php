<?php
$this->userInformations = [];

foreach($this->client as $key => $elm)
{
	$nElm = [];
	$nElm['id'] = $elm->id_dh;

	$Pp = $elm->getPersonnePhysique();
	$nElm['name'] = $Pp->getName();
	$nElm['firstName'] = $Pp->getFirstName();
	$nElm['shortName'] = $Pp->getShortName();
	$nElm['Civilité'] = $Pp->getCiviliteFormat();
	$nElm['Type'] = $elm->getTypeStr();
//	$nElm['email'] = $elm->getLogin();









	/////////////////////////////////////////////////////////////
	/*
	$nElm['Phone'] = $elm->getPersonnePhysique()->getPhone();
	$nElm['code'] = $elm->getCodeSms();
	$nElm['mailOk'] = $elm->mailOk();
	$nElm['phoneOk'] = $elm->phoneOk();
	$nElm['isValide'] = $elm->isValide();
	*/
	/////////////////////////////////////////////////////////////







	$tmp = $elm->getLastAction();
	$nElm['lastAction'] = (!empty($tmp)) ? $tmp->date : 0;






//////////////////////////////////////////////////////
	$nElm['vip'] = $elm->isVip();
	$nElm['ko'] = $elm->isKo();
/*
*/
/////////////////////////////////////////////////////////////







	$conseiller = $elm->getConseiller();
	if (!empty($conseiller))
		$nElm['Conseiller'] = $conseiller->getShortName();
	else
		$nElm['Conseiller'] = "-";
	$nElm['lastCrmOkay'] = !empty($elm->getLastCrmOkay()) ? $elm->getLastCrmOkay()->getDateEnd() : 0;
	$nElm['nextCrm'] = !empty($elm->getNextCrm()) ? $elm->getNextCrm()->getDateExecution() : 0;





	////////////////////////////////////////////////////
	/*
	foreach ($elm->getCacheArrayTable()['precalcul'] as $key2 => $elm2)
	{
		$nElm[$key2] = $elm->getCacheArrayTable()['precalcul'][$key2];
	}
	*/

	$nElm["scpiList"] = $elm->getCacheArrayTable()['precalcul']["scpiList"];
	//$nElm['Dernière souscription'] = '<a type="button" class="btn btn-info" href="?p=EditionClient&client=' . $elm->id_dh . '">Info</a>';
	//$nElm['Valeur du portefeuille'] = $nElm['ventePotentielle'];
	////////////////////////////////////////////////////////////////







	$nElm['Valeur du portefeuille'] = $elm->getCacheArrayTable()['precalcul']['ventePotentielle'];

	$this->userInformations[] = $nElm;






	//////////////////////////////////////////////////////////
	/*
	if ($nElm['id'] == 10)
	{
		foreach ($nElm as $key => $val)
		{
			if (is_array($val))
				echo "[Tableau]<br />";
			else
				echo $val . "<br />";
		}
		exit();
	}
	*/
	////////////////////////////////////////////////////////////////////
}


//exit();
//dbg($this->userInformations);
//exit();

$arrayType = [
	"id" => "number",
	"shortName" => "normal",
	//"email" => "normal",
	"Type" => "normal",
	"Conseiller" => "normal",
	"Valeur du portefeuille" => "euros",
	"scpiList" => "listLight",
/*
	"ventePotentielleMscpi" => "euros",
	"ventePotentielleOther" => "euros",

	"plusMoinValuePourcent" => "pourcent",
	"plusMoinValueEuro" => "euros",
	"Dernière souscription" => "html",
	"scpiListId" => "list",
	*/
	"lastCrmOkay" => "date",
	"nextCrm" => "date",
	"lastAction" => "date",
/*
	"vip" => "number",
	"ko" => "number",
	"isValide" => "number",
	"mailOk" => "number",
	"phoneOk" => "number"
	*/
];

$arrayName = [
	"shortName" => "Client",
	"name" => "Nom",
	"firstName" => "Prénom",
	//"code" => "Code SMS",
	"scpiList" => "Liste de SCPI",
	"lastCrmOkay" => "Dernier contact",
	"nextCrm" => "Prochain contact",
	//"isValide" => "E-mail et Téléphone validé",
	//"mailOk" => "E-mail validé",
	//"phoneOk" => "Téléphone validé",
	"lastAction" => "Dernière action"
];

$this->columnList = [];
foreach($this->userInformations as $key => $elm)
{
	foreach($elm as $key2 => $elm2)
	{
		$toAdd = [
			"data" => $key2,
			"type" => "strict",
			"name" => $key2
		];
		if (isset($arrayType[$key2]))
			$toAdd['type'] = $arrayType[$key2];
		if (isset($arrayName[$key2]))
			$toAdd['name'] = $arrayName[$key2];

		$this->columnList[] = $toAdd;
	}
	break;
}


$this->scpiList = [];
foreach(Scpi::getAll() as $key => $elm)
{
	$this->scpiList[] = $elm->name;
}

$this->loadModuleAdmin('ModuleSendMessage', 'ModuleSendMessage');

