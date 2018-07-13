<?php
require_once("class/core/ModuleAdmin.php");
class DonneurDOrdreClient extends ModuleAdmin
{
	public function changeMailDh() {
		// Verifier que le mail a changer est le bon.
		//Verifier que la nouvelle adresse mail est valide.

		if (
			!isset($_POST['oldMail']) ||
			!isset($_POST['newMail']) ||
			!isset($_POST['newMailConfirmation'])
		)
		{
			Notif::set("mscChangeMail", "L'adresse mail n'a pas pu etre change");
			return (false);
		}
		if (!empty(Dh::getFromKeyValue("login", ft_crypt_information($_POST['newMail']))))
		{
			Notif::set("mscChangeMail", "L'adresse mail n'a pas pu etre change<br />car elle est utilisee par un autre Donneur d'ordre");
			return (false);
		}
		$oldMail = $this->dh->getLogin();
		if (
			$_POST['oldMail'] != $oldMail ||
			$_POST['newMail'] != $_POST['newMailConfirmation'] ||
			!filter_var($_POST['newMail'], FILTER_VALIDATE_EMAIL)
		)
		{
			Notif::set("mscChangeMail", "L'adresse mail n'a pas pu etre change");
			return (false);
		}
		if (!Dh::changeLogin($this->dh->id_dh, $_POST['newMail']))
		{
			Notif::set("mscChangeMail", "L'adresse mail n'a pas pu etre change");
			return (false);
		}
		$url = "?p=" . $GLOBALS['GET']['p'] . "&client=" . $GLOBALS['GET']['client'];
		$url .= "&onglet=DONNEUR_D_ORDRE";
		Notif::set("mscChangeMail", "L'adresse mail de " . $this->dh->getPersonnePhysique()->getShortName() . "<br /> a bien ete changee !");
		header("Location: " . $url);
		exit();
	}
	public function nonSollicitationParMail($why)
	{
		$why = trim($why);
		if (empty($why))
			$this->dh->updateOneColumn('non_sollicitation_par_mail', NULL);
		else
			$this->dh->updateOneColumn('non_sollicitation_par_mail', ft_crypt_information($why));
	}
	public function toogleVip() {
		$actualVip = $this->dh->isVip();
		$this->dh->updateOneColumn('vip', !$actualVip);
		if ($actualVip != Dh::getById($this->dh->id_dh)->isVip())
		{
			Notif::set("Change Vip status", "Le status VIP du donneur d'ordre a bien été changé");
			header("Location: " . getThisURL());
			exit();
		}
		else
			Notif::set("Change Vip status", "Erreur : Le status VIP du donneur d'ordre n'a pas été changé");
	}
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
