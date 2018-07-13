<?php
$notif = Notifications::getFromId($GLOBALS['GET']['notif_id']);
if (count($notif) == 0)
{
	header("Location: ?p=Accueil");
	exit();
}
$notif = $notif[0];
$notif->updateOneColumn("see", 1);
if (
	empty($notif->getLink()) ||
	$notif->getLink() == "#"
)
{
	header("Location: ?p=Accueil");
	exit();
}
header("Location: " . $notif->getLink());
exit();
