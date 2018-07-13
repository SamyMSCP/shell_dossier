<?php
$dh = Dh::getCurrent();


if (!empty($GLOBALS['GET']['active']) && !check_token($GLOBALS['GET']['active'])){
	echo '<div id="message"><div id="inner-message" class="alert alert-danger" role="alert"><button type="button" class="close" data-dismiss="alert">&times;</button><strong>Erreur </strong>une anomalie s\'est produite</div></div>';
}
else if (!empty($_POST['del'])) {
	$id = intval($_POST['del']);
	if (del_scpi($id)) //vente
		Notif::set("removeTransaction", "<strong>Erreur </strong>une anomalie s'est produite");
	else {
		$dh->regenerateCacheArrayTable();
		//notification("La SCPI a été mise en vente.");
		Notif::set("removeTransaction", "La SCPI a été mise en vente.");
	}
}

if (!empty($_POST['update']))
{
	foreach ($_POST['update'] as $transac => $elm)
	{
		$res = 0;
		if (($tr = Transaction::getFromId($transac)[0]) instanceof Transaction)
		{
			if (!empty($elm['prix']))
			{
				if (preg_match('/^\d+((\.|,)(\d{1,2}))?$/', $elm['prix'])
					&& $tr->updateOneColumn('prix_part', floatval(str_replace(',','.',$elm['prix']))))
					$res++;
				else
					$res -= 100;
			}

			if (!empty($elm['date']))
			{
				$date = DateTime::createFromFormat("d/m/Y", $elm['date']);
				if (!$date || array_sum($date->getLastErrors()))
					$date = DateTime::createFromFormat("Y-m-d", $elm['date']); //Ne devrais pas arrivé non ??

				if ($date !== false && array_sum($date->getLastErrors()) == 0
					&& $tr->updateOneColumn('enr_date', ft_crypt_information($date->format("d/m/Y"))))
					$res++;
				else
					$res -= 100;
			}
		}
	}
	if ($res > 0)
	{
		$dh->regenerateCacheArrayTable();
		Notif::set("updateTransaction", "La SCPI a été mise à jour.");
	}
	else if ($res < 0)
		Notif::set("updateTransaction", "Une erreur s'est produite.");
}

$dataTransaction = $dataTransactionPot = $dh->getCacheArrayTable();
if (
	$dh->getPersonnePhysique()->getPhone() == "-" ||
	empty($dh->getPersonnePhysique()->getPhone())
)
{
	$this->loadModule("ForceSetPhone", "ForceSetPhone", array("dh" => $dh));
}


$precalcul_default = ['flagMissingInfo' => 0,
	"modal_link" => "",
	"nbr_part" => 0,
	"type_pro" => "",
	"ventePotentielle" => 0,
	"plusMoinValuePourcent" => 0,
	"MontantInvestissement" => 0,
	"name" => "test____"
 ];

foreach ($dh->getTransaction() as $tr)
{
	$founded = false;
	foreach ($dataTransactionPot as $precalcul => $p)
	{
		if ($precalcul == "precalcul")
			continue;
//		var_dump($tr->getScpi());
		if ($precalcul == $tr->getScpi()->getName())
		{

			if ($tr->isPleinePro() && isset($p['Pleine'][$tr->getId()]))
			{
				if ($tr->getTypeTransaction() == 'A' && isset($p['Pleine'][$tr->getId()]))
					$founded = true;
				else if ($tr->getTypeTransaction() == 'V' && isset($p['Pleine'][$tr->id_transaction_achat]))
					$founded = true;
			}
			else if ($tr->isNuePro() && isset($p['Nue']))
			{
				if ($tr->getTypeTransaction() == 'A' && isset($p['Nue'][$tr->getId()]))
					$founded = true;
				else if ($tr->getTypeTransaction() == 'V' && isset($p['Pleine'][$tr->id_transaction_achat]))
					$founded = true;
			}
			else if ($tr->isUsufruit() && isset($p['Usu']))
			{
				if ($tr->getTypeTransaction() == 'A' && isset($p['Usu'][$tr->getId()]))
					$founded = true;
				else if ($tr->getTypeTransaction() == 'V' && isset($p['Pleine'][$tr->id_transaction_achat]))
					$founded = true;
			}
		}
		if ($founded)
			break;
	}
	if (!$founded)
	{
		if ($tr->isPleinePro())
			$tp = "Pleine";
		else if ($tr->isNuePro())
			$tp = "Nue";
		else if ($tr->isUsufruit())
			$tp = "Usu"; 
		$dataTransactionPot[$tr->getScpi()->getName()][$tp][$tr->getId()][($tr->getTypeTransaction() == 'A') ? 'buy' : 'sell'][$tr->getId()] = $tr;
		if (!isset($dataTransactionPot[$tr->getScpi()->getName()][$tp]['precalcul']))
		{
			$dataTransactionPot[$tr->getScpi()->getName()][$tp]['precalcul'] = $precalcul_default;
			$dataTransactionPot[$tr->getScpi()->getName()][$tp]['precalcul']['id_scpi'] = $tr->getScpi()->getId();
			$dataTransactionPot[$tr->getScpi()->getName()][$tp]['precalcul']['scpi'] = $tr->getScpi();
			$dataTransactionPot[$tr->getScpi()->getName()][$tp]['precalcul']['name'] = $tr->getScpi()->getName();
			$dataTransactionPot[$tr->getScpi()->getName()][$tp]['precalcul']['type_pro'] = $tr->getTypePro();
			$dataTransactionPot[$tr->getScpi()->getName()][$tp]['precalcul']['modal_link'] = 'modal_' . $tp . '_' .  str_replace(array(' ', '"', "'"), '_' , $tr->getScpi()->getName());
		}
		$dataTransactionPot[$tr->getScpi()->getName()][$tp]['precalcul']['MontantInvestissement'] += $tr->getMontanInvestissement();
		$dataTransactionPot[$tr->getScpi()->getName()][$tp]['precalcul']['ventePotentielle'] += $tr->getMontantGlobalDeRevente();
		$dataTransactionPot[$tr->getScpi()->getName()][$tp]['precalcul']['nbr_part'] += $tr->getNbrPart();
	}
}

$this->loadModule("MonCompte", "MonCompte", array(
	"dh" => $dh,
	"table" => $dataTransaction
	)
);

$this->loadModule("Nav2", "Nav2", array("dh" => $dh));
if (count(Dh::getCurrent()->getTransaction()) !== 0) {
$this->loadModule("RepartitionAcceuil", "RepartitionAcceuil", array(
	"dh" => $dh,
	"table" => $dataTransaction
	)
);

$this->loadModule("RendementDeMesScpiAcceuil", "RendementDeMesScpiAcceuil", array(
	"dh" => $dh,
	"table" => $dataTransaction
	)
);

$this->loadModule("RepartitionGeographique", "RepartitionGeographique", array(
	"dh" => $dh,
	"table" => $dataTransaction
	)
);

$this->loadModule("RepartitionParCategorie", "RepartitionParCategorie", array(
	"dh" => $dh,
	"table" => $dataTransaction
	)
);

$this->loadModule("TauxDOccupation", "TauxDOccupation", array(
	"dh" => $dh,
	"table" => $dataTransaction
	)
);

$this->loadModule("RepartitionParType", "RepartitionParType", array(
	"dh" => $dh,
	"table" => $dataTransaction
	)
);
}

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
$this->loadModule("ApercuDeMonPorteFeuillev3_5", "ApercuDeMonPorteFeuillev3_5", array(
	"dh" => $dh,
	"data" => $dataTransactionPot
	)
);
$this->loadModule("DernieresAcquisitions", "DernieresAcquisitions", array("dh" => $dh));
$this->loadModule("NotNow", "NotNow", array("dh" => $dh));


$this->loadModule("ModuleBarre", "ModuleBarre", array("dh" => $dh));


$this->loadModule('ModalHistoriqueTransaction', 'ModalHistoriqueTransaction');
$this->loadModule('TransactionFrontStore', 'TransactionFrontStore', ['dh' => $dh]);
$this->loadModule('TransactionFrontComponent','TransactionFrontComponent');

$this->id_modal = [];
foreach ($dataTransactionPot as $scpi => $type)
{
	if ($scpi != "precalcul")
	{
		foreach ($type as $_tr => $tr)
		{
			if ($_tr != "precalcul")
				$this->id_modal[] = ['scpi' => $scpi, 'typepro' => $_tr, 'name' => $tr['precalcul']['modal_link']];
		}
	}
}

$this->loadModule("ToolTip", "ToolTip", array());
$this->loadModule("Loading", "Loading", array());
$this->loadModule("Footer", "Footer", array("dh" => $dh));

$this->loadModule("AdressePostaleComponent", "AdressePostaleComponent", ["dh" => $dh]);
