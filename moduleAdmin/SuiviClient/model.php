<?php
if (!empty($_POST["singlebutton"]) && $_POST['singlebutton'] === "setCrm") {
	$this->dh->setCrm();
	header("Location: ?p=" . $GLOBALS['GET']['p'] . "&client=" . $GLOBALS['GET']['client'] . "&onglet=SUIVI");
}

if (!empty($GLOBALS['GET']["idcrm"]) && $GLOBALS['GET']["idcrm"] && !empty($GLOBALS['GET']["client"]) && $GLOBALS['GET']["client"]) {
	CRM::set_finish_crm($GLOBALS['GET']["client"], $GLOBALS['GET']["idcrm"]);
	header("Location: ?p=" . $GLOBALS['GET']['p'] . "&client=" . $GLOBALS['GET']['client'] . "&onglet=SUIVI");
	exit();
}
$this->crmclient = $this->dh->getCrm();
