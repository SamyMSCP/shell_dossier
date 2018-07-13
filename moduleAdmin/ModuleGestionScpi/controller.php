<?php
require_once("class/core/ModuleAdmin.php");
class ModuleGestionScpi extends ModuleAdmin
{
	public function				changeShowList()
	{
		$scpiGestion = ScpiGestion::getFromIdScpi($_POST['changeShowList']);
		if (empty($scpiGestion) || !isset($_POST['showListForm']) || $_POST['showListForm'] < 0 || $_POST['showListForm'] > 2)
		{
			Notif::set("changeScpiShowList", "La scpi n'a pas pu etre modifiee !");
			return (false);
		}
		if (!$scpiGestion->setShowList($_POST['showListForm']))
		{
			Notif::set("changeScpiShowList", "La scpi n'a pas pu etre modifiee !");
			return (false);
		}
		if (!$scpiGestion->updateIt())
		{
			Notif::set("changeScpiShowList", "La scpi n'a pas pu etre modifiee !");
			return (false);
		}
		//Notif::set("changeScpiShowList", "La scpi a bien ete modifiee !");
		header("Location: ?p=" . $GLOBALS['GET']['p']);
		exit();
	}
}
