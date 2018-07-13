<?php
$dh = Dh::getCurrent();
// Vérifier qu'un id de projet est bien transmis
if (!isset($GLOBALS['GET']['projet']))
{
	Notif::set("signRec", "La requete est mal formatée");
	header("Location: ?p=InfoProjet");
	exit();
}

// Vérifier si le parametre est transmis est valide
$id_projet = intval(decrypt_url($GLOBALS['GET']['projet']));
if ($id_projet <= 0)
{
	Notif::set("signRec", "La requete est mal formatée");
	header("Location: ?p=InfoProjet");
	exit();
}

// Récupérer le projet en question
$projet = Projet::getFromId($id_projet);
if (empty($projet))
{
	Notif::set("signRec", "Le projet demandé ne semble pas exister");
	header("Location: ?p=InfoProjet");
	exit();
}
$projet = $projet[0];

// Vérifier que le projet demandé appartien bien au donneur d'ordre connecté
if (!$projet->checkAuthorisation($dh))
{
	Notif::set("signRec", "Le projet demandé ne vous appartien pas !");
	header("Location: ?p=InfoProjet");
	exit();
}

// Vérifier que le projet est bien au status 2
if ($projet->getEtatProjet() != 4)
{
	Notif::set("signRec", "L'etat du projet ne vous permet pas de signer son Rec");
	header("Location: ?p=InfoProjet");
	exit();
}

// Vérifier que le projet n'a pas déja un Rec en cours de validité
if ($projet->recOkay())
{
	// Changer l'etat de ce projet a 5
	$projet->updateOneColumn("etat_du_projet", 5);
	Notif::set("signRec", "Ce projet à déja un Rec en cours de validité, votre conseillé à été notifié !");
	header("Location: ?p=InfoProjet");
	exit();
}

// Générer le pdf Rec
$projet->getNewRec()->printPdf();


// Générer la signature universign
// Rediriger le client sur la page en question.

// Le lien de retour de Universign doit Vérifier si le projet a un rec de signé et changer l'etat du projet en fonction.
