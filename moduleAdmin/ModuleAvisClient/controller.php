<?php
require_once("class/core/ModuleAdmin.php");
class ModuleAvisClient extends ModuleAdmin
{
	public static function updateAvis() {
		if (!isset($_POST['status']) || !isset($_POST['prio']) || !isset($_POST['id_avis']))
		{
			Notif::set("msgUpdateAvis", "L'avis n'a pas pu etre modie");
			header("Location: ?p=" . $GLOBALS['GET']['p']);
			exit();
		}

		//check valeur status
		//check valeur priorite
		$status = intval($_POST['status']);
		$prio = intval($_POST['prio']);
		$id = intval($_POST['id_avis']);
		if (
			$prio < 0 || $prio >= count(Avis::$_lstPriorite) ||
			$status < 0 || $status >= count(Avis::$_status) ||
			$id < 1
		)
		{
			Notif::set("msgUpdateAvis", "L'avis n'a pas pu etre modie");
			header("Location: ?p=" . $GLOBALS['GET']['p']);
			exit();
		}

		// check date
		if (isset($_POST['date']))
		{
			//verification format date et conversion timestamp;
			$date = Datetime::createFromFormat("Y-m-d", $_POST['date']);
			if (empty($date))
			{
				Avis::updateAvis($id, $prio, $status);
				Notif::set("msgUpdateAvis", "L'avis a bien ete modifie");
				header("Location: ?p=" . $GLOBALS['GET']['p']);
				exit();
			}
			Avis::updateAvis($id, $prio, $status, $date->getTimestamp());
			Notif::set("msgUpdateAvis", "L'avis a bien ete modifie");
			header("Location: ?p=" . $GLOBALS['GET']['p']);
			exit();
		}
		else
		{
			Avis::updateAvis($id, $prio, $status);
			Notif::set("msgUpdateAvis", "L'avis a bien ete modifie");
			header("Location: ?p=" . $GLOBALS['GET']['p']);
			exit();
		}
	}
}
