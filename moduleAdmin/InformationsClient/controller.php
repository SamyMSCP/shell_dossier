<?php
require_once("class/core/ModuleAdmin.php");
class InformationsClient extends ModuleAdmin
{

	public function changeConseiller() {

		// Vérifier que c'est bien un compte yoda ou backoffice sinon on sort !
		if ($this->collaborateur->type != "yoda" && $this->collaborateur->type != "prospecteur" && $this->collaborateur->type != "assistant" && $this->collaborateur->type != "backoffice" && $this->collaborateur->id_dh != $this->dh->conseiller)
			return ;

		// Changer le Conseiller
		// update
		$id_client = intval($_POST['id_client']);
		$id_conseiller = intval($_POST['id_conseiller']);

		$client = Dh::getById($id_client);
		if (empty($client))
		{
			Notif::set("changeConseiller", "Le donneur d'ordre n'a pas pu etre trouvé en base de donnée et n'a donc pas pu etre mis a jours!");
			return ;
		}
		$old = Dh::getById($client->conseiller);
		$new = Dh::getById($id_conseiller);
		if (empty($new))
		{
			Notif::set("msgContact", "Le conseiller demandé n'a pas été trouvé en base !");
			header("Location: ?p=" . $GLOBALS['GET']["p"]);
			exit();
		}
		$client->updateOneColumn("conseiller", $id_conseiller);
		if (!empty($old) && !empty($new))
		{
			Logger::setNew("Changement de conseiller", $this->collaborateur->id_dh, $this->dh->id_dh, [
				'Ancien conseiller' => $old->getShortName(),
				'Nouveau conseiller' => $new->getShortName()
			]);
		}
		else if (!empty($new))
		{
			Logger::setNew("Changement de conseiller", $this->collaborateur->id_dh, $this->dh->id_dh, [
				'Nouveau conseiller' => $new->getShortName()
			]);
		}

		$id_crm = Crm2::insertNew(
			$this->dh->id_dh,
			5,
			2,
			time(),
			-2700,
			"Ce client vous à été réaffecté. Pourriez-vous en informer le client.",
			[],
			0
		);
		if (empty($id_crm))
		{
			Notif::set("msgContact", "La Tache Crm concernant le changement de conseiller n'a pas pu etre inséré !");
			header("Location: ?p=" . $GLOBALS['GET']["p"]);
			exit();
		}
		Notif::set("changeConseiller", "Le changement de conseiller à bien été pris en compte");
		header("Location: ?p=" . $GLOBALS['GET']['p'] . "&client=" . $GLOBALS['GET']['client']);
		exit();
	}
	public function changeDhToProspect() {
		if (
			!isset($_POST['id_client'])
		)
		{
			Notif::set("msgContact", "La requete est mal formatée");
			header("Location: ?p=" . $GLOBALS['GET']["p"]);
			exit();
		}
		$dh = Dh::getById($_POST['id_client']);
		$dh->setColumnNull("type");
		Notif::set("changeConseiller", "Le changement de type d'utilisateur a bien été pris en compte");
		header("Location: ?p=" . $GLOBALS['GET']['p'] . "&client=" . $GLOBALS['GET']['client']);
		exit();
	}
	public function changeDhToOrigineContact() {
		if (
			!isset($_POST['id_client'])
		)
		{
			Notif::set("msgContact", "La requete est mal formatée");
			header("Location: ?p=" . $GLOBALS['GET']["p"]);
			exit();
		}
		$dh = Dh::getById($_POST['id_client']);
		$dh->updateOneColumn("type", "origine_contact");
		Notif::set("changeConseiller", "Le changement de type d'utilisateur a bien été pris en compte");
		header("Location: ?p=" . $GLOBALS['GET']['p'] . "&client=" . $GLOBALS['GET']['client']);
		exit();
	}
}
