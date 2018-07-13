<?php
if (isset($_POST['action']) && $_POST['action'] == "saveTemplate")
	$this->saveTemplate();

$this->collaborateur = Dh::getCurrent();
$this->loadModuleAdmin("Nav", "Nav", array("collaborateur" => $this->collaborateur));

$this->loadModuleAdmin("ModuleNotificationsCrm", "ModuleNotificationsCrm", array("collaborateur" => $this->collaborateur));
$this->loadModule("MessageBox", "MessageBox");
