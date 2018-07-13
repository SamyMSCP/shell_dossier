<?php
require_once("app.php");

echo "Civilité,Prénom,Nom,N°,Extension,Type de voie,Voie,Complément d'adresse,Code postal,Commune,Pays,conseiller\n";

foreach (Dh::getAll() as $key => $dh)
{
	$before = false;
	$trans = $dh->getTransaction();
	foreach ($trans as $tr)
	{
		if (
			$tr->doByMscpi() &&
			$tr->getEnrDate() instanceof Datetime &&
			$tr->getEnrDate() > Datetime::createFromFormat("d/m/Y", "01/01/2017")
		)
		{
			$before = true;
		}
		if (
			$tr->doByMscpi() &&
			$tr->getEnrDate() instanceof Datetime &&
			$tr->getEnrDate() < Datetime::createFromFormat("d/m/Y", "01/01/2017")
		)
		{
			$before = false;
			break ;
		}
	}
	//if (!$dh->getCacheArrayTable()['precalcul']['ventePotentielleMscpi'])
	if (!$before)
		continue ;
	$pp = $dh -> getPersonnePhysique();
	echo "\"";
	echo $pp->getCivilite() . "\",\"";
	echo $pp->getFirstName() . "\",\"";
	echo $pp->getName() . "\",\"";
	echo $pp->getNumeroRue() . "\",\"";
	echo $pp->getExtention() . "\",\"";
	echo $pp->getTypeVoie() . "\",\"";
	echo $pp->getVoie() . "\",\"";
	echo $pp->getComplementAdresse() . "\",\"";
	echo $pp->getCodePostal() . "\",\"";
	echo $pp->getVille() . "\",\"";
	echo $pp->getPays() . "\",\"";
	echo $dh->getConseiller()->getShortName() . "\"\n";
}
