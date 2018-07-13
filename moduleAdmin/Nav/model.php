<?php
if ($this->collaborateur->type == "conseiller")
{
	$id = Dh::addClient($this->collaborateur->id_dh);
	if (!empty($id))
	{
		$link = '?p=EditionClient&client=' . $id;
		header('Location: ' . $link);
		exit();
	}
	//Notif::set("addUser", "L'ajout du prospet à échouée ! :(");
}
elseif (!empty($_POST["conseiller_id"]))
{
	$id = Dh::addClient($_POST["conseiller_id"]);
	if (!empty($id))
	{
		$link = '?p=EditionClient&client=' . $id;
		header('Location: ' . $link);
		exit();
	}
	//Notif::set("addUser", "L'ajout du prospet à échouée ! :(");
}

$this->AbsorptionNotif = absorption::getNeedComplete();
$help = Dh::getCurrent()->getMyClientsHelping();

$this->myNotifications = $this->collaborateur->getCrmForToday();
$this->NbrNorification = count($this->myNotifications);
