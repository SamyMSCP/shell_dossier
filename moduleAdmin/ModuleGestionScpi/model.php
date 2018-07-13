<?php
if (isset($_POST['changeShowList']))
{
	$this->changeShowList();
}

$this->lstScpi = Scpi::getAll();
$this->loadModuleAdmin("ModuleGestionDelaiJouissance", "ModuleGestionDelaiJouissance");
