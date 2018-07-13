<?php
require_once("class/core/ModuleAdmin.php");
class OutilsProspecteur extends ModuleAdmin
{
	public function toogleKo() {
		$actualKo = $this->dh->isKo();
		$this->dh->updateOneColumn('ko', !$actualKo);
		if ($actualKo != Dh::getById($this->dh->id_dh)->isKo())
		{
			Notif::set("Change Vip status", "Le status KO du donneur d'ordre a bien été changé");
			header("Location: " . getThisURL());
			exit();
		}
		else
			Notif::set("Change Vip status", "Erreur : Le status KO du donneur d'ordre n'a pas été changé");
	}
}
