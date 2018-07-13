<?php
$this->collaborateur = Dh::getCurrent();

$this->loadModuleAdmin("Nav", "Nav", array("collaborateur" => $this->collaborateur));

if (isset($GLOBALS['GET']['scpi'])) {
	$this->scpi = Scpi::getFromId(intval($GLOBALS['GET']["scpi"]));
	if (empty($this->scpi)) {
		Notif::set("notScpi", "La scpi demandée ne semble pas exister");
			header("Location: ?p=Accueil");
			exit();
	}
	$this->users = [];
	$this->transactions = Transaction::getFromKeyValue("id_scpi", intval($GLOBALS['GET']["scpi"]));
	foreach ($this->transactions as $key => $elm) {
		if (isset($users[$elm->id_donneur_ordre]))
			continue ;
		$this->users[$elm->id_donneur_ordre] = $elm->getDh();
	}
	$this->loadModuleAdmin("ModuleAccueilV2", "ModuleAccueilV2", array(
		"collaborateur" => $this->collaborateur,
		"client" => $this->users
	));
} else {
		Notif::set("formatError", "L'url indiquée n'est pas valide");
			header("Location: ?p=Accueil");
			exit();
	}

