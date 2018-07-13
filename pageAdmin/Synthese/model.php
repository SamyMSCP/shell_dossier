<?php
	$this->dh = Dh::getById($GLOBALS['GET']["client"]);

//	$dataTransaction = $this->dh->getLstTransactionArrayForShow();
	$dataTransaction = $this->dh->getCacheArrayTable();

	//$this->loadModule("ApercuDeMonPorteFeuillev2", "ApercuDeMonPorteFeuillev2", array("dh" => $dh, "data" => $dataTransaction));

	$this->loadModuleAdmin("SyntheseTable", "SyntheseTable", array("dh" => $this->dh));
	$this->loadModuleAdmin("Nav", "Nav", array("id" => $this->dh->id_dh));
	$this->loadModuleAdmin("SyntheseInfoInvestissement", "SyntheseInfoInvestissement", array("dh" => $this->dh));
	$this->loadModuleAdmin("RepartitionPorteFeuille", "RepartitionPorteFeuille", array(
		"dh" => $this->dh,
		"table" => $dataTransaction
		)
	);
	$this->loadModuleAdmin("SouscriptionFaitesParMeilleureSCPI", "SouscriptionFaitesParMeilleureSCPI", array("dh" => $this->dh));
	$this->loadModule("ApercuDeMonPorteFeuillev2", "ApercuDeMonPorteFeuillev2", array("dh" => $this->dh, "data" => $dataTransaction));
	$this->loadModuleAdmin("SyntheseTable", "SyntheseTable", array("dh" => $this->dh));

	$this->loadModuleAdmin("MiniUserInfo", "MiniUserInfo", array("dh" => $this->dh));
