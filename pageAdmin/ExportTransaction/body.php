<?php
header('Content-type: text/csv');
if (!empty($GLOBALS['GET']["client"]))
	header('Content-disposition: attachment;filename=Portefeuille_' . $this->dh->getPersonnePhysique()->getFirstName() . "_" .  $this->dh->getPersonnePhysique()->getName() . "_" . date("d_m_Y") . '.csv');
else if ($GLOBALS['GET']["config"] == "all")
	header('Content-disposition: attachment;filename=allTransactions.csv');

echo "id,ID TRANSACTION,Type de bénéficiaire,Dénomination sociale,NOM,Prénom,Civilité,Mail / numéro de téléphone (si email absent),État transaction,Date enregistrement / Annulation,Cons,Commentaire,MP / MS,Type transaction,Effectuée par,SCPI,Date Signature BS,Nb  parts,Prix Achat / Vente,Type propriete,Durée si DT,Clé répart,Montant Transaction,Date entrée Jouis,Date fin Jouis,Date début valorisation,Date fin valorisation,Date début dividendes, Date fin dividendes\n";
//dbg($this->transactions);

foreach ($this->transactions as $key => $elm)
{
	echo $elm->id . ",";
	echo $elm->getIdMscpi() . ",";
	if (!empty($elm->getBeneficiaire()))
	{
		echo $elm->getBeneficiaire()->getTypeBeneficiaireForTable();
	}
	echo ",";
	if (!empty($elm->getBeneficiaire()) && $elm->getBeneficiaire()->getTypeBeneficiaire() == "Pm")
	{
		echo $elm->getBeneficiaire()->getPersonneMorale()[0]->getDenominationSociale();
	}
	echo ",";
	if (!empty($elm->getBeneficiaire()) && ($elm->getBeneficiaire()->getTypeBeneficiaire() == "seul" || $elm->getBeneficiaire()->getTypeBeneficiaire() == "couple"))
	{
		echo $elm->getBeneficiaire()->getPersonnePhysique()[0]->getName() . ",";
		echo $elm->getBeneficiaire()->getPersonnePhysique()[0]->getFirstName() . ",";
		echo $elm->getBeneficiaire()->getPersonnePhysique()[0]->getCiviliteFormat() . ",";
	}
	else
	{
		echo ",,,";
	}
	echo "\"" . $elm->getDh()->getLogin() . "\",";
	echo "\"" . $elm->getStatusTransaction() . "\",";
	if (!empty($elm->getEnrDate()))
		echo $elm->getEnrDate()->format("d/m/y");
	echo ",";
	if (!empty($elm->getConseiller()))
		echo $elm->getConseiller()->getLogin();
	echo ",";
	echo "\"" . $elm->getCommentaireForTable() . "\",";
	echo $elm->getMarcherForTable() . ",";
	echo "\"" . $elm->getTypeTransaction() . "\",";
	echo "\"" . $elm->getInfoTransaction() . "\",";
	echo $elm->getName() . ",";
	if (!empty($elm->getDateSignature()))
		echo $elm->getDateSignature()->format("d/m/y");
	echo ",";
	echo "\"" . str_replace(".", ",", $elm->getNbrPart()) . "\",";
	echo "\"" . number_format($elm->getPrixPart(), 4, ",", "") . "\",";
	echo $elm->getTypeProForTable() . ",";
	if (empty($elm->getDuree()))
		echo "SO";
	else
		echo $elm->getDuree();
	echo ",";
	echo "\"" . number_format(floatval($elm->getClefRepartition() / 100), 4, ",", "") . "\",";
	echo "\"" . str_replace(".", ",", $elm->getMontanInvestissement()) . "\",";
	if (!empty($elm->getExcelDateEntreeJouissance()))
		echo $elm->getExcelDateEntreeJouissance()->format("d/m/y");
	echo ",";
	if (!empty($elm->getExcelDateFinJouissance()))
		echo $elm->getExcelDateFinJouissance()->format("d/m/y");
	else
		echo "SO";
	
	echo ",";
	echo ($elm->getDateDebutValorisation()->getTimestamp() != 0) ? $elm->getDateDebutValorisation()->format('d/m/Y') : "-";
	echo ",";
	echo ($elm->getDateFinValorisation()->getTimestamp() != 0) ? $elm->getDateFinValorisation()->format('d/m/Y') : "-";
	echo ",";
	echo ($elm->getDateDebutDividendes()->getTimestamp() != 0) ? $elm->getDateDebutDividendes()->format('d/m/Y') : "-";
	echo ",";
	echo ($elm->getDateFinDividendes()->getTimestamp() != 0) ? $elm->getDateFinDividendes()->format('d/m/Y') : "-";
	echo "\n";
}
exit();
