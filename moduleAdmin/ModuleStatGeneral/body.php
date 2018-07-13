<h1>Module Stat general</h1>
<table border="1" class="tableStats">
	<tr>
		<th></th>
		<th>Nombres de clients</th>
		<th>Valorisation totale</th>
		<?php
		//<th>Valeur moyenne par client</th>
		?>
		<th>Valorisation totale Meilleurescpi.com</th>
		<?php
		//<th>Valeur moyenne par client Meilleurescpi.com</th>
		?>
		<th>Valorisation totale Autre</th>
		
		<?php
		//<th>Valeur moyenne par client Autre</th>
		?>
	</tr>
	<?php
	/*
	<tr>
		<th>Clients MSCPI</th>
		<td><?=$this->datas->getClientsNbr()?></td>
		<td><?=number_format($this->datas->getClientsValorisation(), 2, ",", " ")?> €</td>
		<td><?=number_format($this->datas->getClientsValorisationMoyenne(), 2, ",", " ")?> €</td>
		<td><?=number_format($this->datas->getClientsValorisationMscpi(), 2, ",", " ")?> €</td>
		<td><?=number_format($this->datas->getClientsValorisationMscpiMoyenne(), 2, ",", " ")?> €</td>
		</tr>
	<tr>
		<th>Prospects MSCPI</th>
		<td><?=$this->datas->getProspectsNbr()?></td>
		<td><?=number_format($this->datas->getProspectsValorisation(), 2, ",", " ")?> €</td>
		<td><?=number_format($this->datas->getProspectsValorisationMoyenne(), 2, ",", " ")?> €</td>
		<td><?=number_format($this->datas->getProspectsValorisationMscpi(), 2, ",", " ")?> €</td>
		<td><?=number_format($this->datas->getProspectsValorisationMscpiMoyenne(), 2, ",", " ")?> €</td>
	</tr>
	<tr>
		<th>Total MSCPI</th>
		<td><?=$this->datas->getClientsTotalNbr()?></td>
		<td><?=number_format($this->datas->getClientsTotalValorisation(), 2, ",", " ")?> €</td>
		<td><?=number_format($this->datas->getClientsTotalValorisationMoyenne(), 2, ",", " ")?> €</td>
		<td><?=number_format($this->datas->getClientsTotalValorisationMscpi(), 2, ",", " ")?> €</td>
		<td><?=number_format($this->datas->getClientsTotalValorisationMscpiMoyenne(), 2, ",", " ")?> €</td>
	</tr>
	*/
	?>
	<tr>
		<th>Clients MSCPI</th>
		<td><?=$this->datas->nbrClientsMscpi?></td>
		<td><?=number_format($this->datas->valorisationClientsMscpi, 2, ",", " ")?> €</td>

		<?php
		/*
		<td><?=number_format($this->datas->valorisationMoyenneClientsMscpi, 2, ",", " ")?> €</td>
		*/
		?>
		<td><?=number_format($this->datas->valorisationMscpiClientsMscpi, 2, ",", " ")?> €</td>
		<?php
		/*
		<td><?=number_format($this->datas->valorisationMscpiMoyenneClientsMscpi, 2, ",", " ")?> €</td>
		*/
		?>
		<td><?=number_format($this->datas->valorisationOtherClientsMscpi, 2, ",", " ")?> €</td>
		<?php
		/*
		<td><?=number_format($this->datas->valorisationOtherMoyenneClientsMscpi, 2, ",", " ")?> €</td>
		*/
		?>
	</tr>
	<tr>
		<th>Prospects MSCPI Validés</th>
		<td><?=$this->datas->nbrClientsOther?></td>
		<td><?=number_format($this->datas->valorisationClientsOther, 2, ",", " ")?> €</td>
		<?php
		/*
		<td><?=number_format($this->datas->valorisationMoyenneClientsOther, 2, ",", " ")?> €</td>
		*/
		?>
		<td><?=number_format($this->datas->valorisationMscpiClientsOther, 2, ",", " ")?> €</td>
		<?php
		/*
		<td><?=number_format($this->datas->valorisationMscpiMoyenneClientsOther, 2, ",", " ")?> €</td>
		*/
		?>
		<td><?=number_format($this->datas->valorisationOtherClientsOther, 2, ",", " ")?> €</td>
		<?php
		/*
		<td><?=number_format($this->datas->valorisationOtherMoyenneClientsMscpi, 2, ",", " ")?> €</td>
		*/
		?>
	</tr>
	<tr>
		<th>Prospects MSCPI email non validés</th>
		<td><?=$this->datas->nbrClientsNoMail?></td>
		<td><?=number_format($this->datas->valorisationClientsNoMail, 2, ",", " ")?> €</td>
		<td><?=number_format($this->datas->valorisationMscpiClientsNoMail, 2, ",", " ")?> €</td>
		<td><?=number_format($this->datas->valorisationOtherClientsNoMail, 2, ",", " ")?> €</td>
	</tr>
	<tr>
		<th>Prospects MSCPI téléphone non validés</th>
		<td><?=$this->datas->nbrClientsNoPhone?></td>
		<td><?=number_format($this->datas->valorisationClientsNoPhone, 2, ",", " ")?> €</td>
		<td><?=number_format($this->datas->valorisationMscpiClientsNoPhone, 2, ",", " ")?> €</td>
		<td><?=number_format($this->datas->valorisationOtherClientsNoPhone, 2, ",", " ")?> €</td>
	</tr>
	<tr>
		<th>Prospects MSCPI non validés</th>
		<td><?=$this->datas->nbrClientsNoVal?></td>
		<td><?=number_format($this->datas->valorisationClientsNoVal, 2, ",", " ")?> €</td>
		<td><?=number_format($this->datas->valorisationMscpiClientsNoVal, 2, ",", " ")?> €</td>
		<td><?=number_format($this->datas->valorisationOtherClientsNoVal, 2, ",", " ")?> €</td>
	</tr>
	<tr>
		<th>Prospects MSCPI Total</th>
		<td><?=$this->datas->nbrClientsProspect?></td>
		<td><?=number_format($this->datas->valorisationClientsProspect, 2, ",", " ")?> €</td>
		<td><?=number_format($this->datas->valorisationMscpiClientsProspect, 2, ",", " ")?> €</td>
		<td><?=number_format($this->datas->valorisationOtherClientsProspect, 2, ",", " ")?> €</td>
	</tr>
	<tr>
		<th>Total</th>
		<td><?=$this->datas->nbrClients?></td>
		<td><?=number_format($this->datas->valorisationClients, 2, ",", " ")?> €</td>
		<?php
		/*
		<td><?=number_format($this->datas->valorisationMoyenneClients, 2, ",", " ")?> €</td>
		*/
		?>
		<td><?=number_format($this->datas->valorisationMscpiClients, 2, ",", " ")?> €</td>
		<?php
		/*
		<td><?=number_format($this->datas->valorisationMscpiMoyenneClients, 2, ",", " ")?> €</td>
		*/
		?>
		<td><?=number_format($this->datas->valorisationOtherClients, 2, ",", " ")?> €</td>
		<?php
		/*
		<td><?=number_format($this->datas->valorisationOtherMoyenneClients, 2, ",", " ")?> €</td>
		*/
		?>
	</tr>
	<tr>
		<th>Comptes crées sur le front</th>
		<td><?=$this->datas->nbrFront?></td>
		<td><?=number_format($this->datas->valorisationFront, 2, ",", " ")?> €</td>
		<td><?=number_format($this->datas->valorisationMscpiFront, 2, ",", " ")?> €</td>
		<td><?=number_format($this->datas->valorisationOtherFront, 2, ",", " ")?> €</td>
	</tr>
	<tr>
		<th>Proportion crées sur le front</th>
		<td><?=number_format(100 * $this->datas->nbrFront / $this->datas->nbrClients, 2, ",", " ")?> %</td>
		<td><?=number_format(100 * $this->datas->valorisationFront / $this->datas->valorisationClients, 2, ",", " ")?> %</td>
		<td><?=number_format(100 * $this->datas->valorisationMscpiFront / $this->datas->valorisationMscpiClients, 2, ",", " ")?> %</td>
		<td><?=number_format(100 * $this->datas->valorisationOtherFront / $this->datas->valorisationOtherClients, 2, ",", " ")?> %</td>
	</tr>
</table>
<div class="nbrComteCree">

	Nombre de comptes crées sur le front : <b><?=$this->datas->nbrCompteCreeFront?></b>

	Nombre de comptes crées sur le front : <b><?=$this->datas->nbrCompteCreeFront[0]?></b><br>
    Nombre de comptes crées sur MailChimp : <b><?=$this->datas->nbrCompteCreeMailChimp[0]?></b><br>
    Nombre de comptes crées sur le landing Facebook : <b><?=$this->datas->nbrCompteCreeFacebook[0]?></b><br>
    Nombre de comptes crées sur le landing Linkedin : <b><?=$this->datas->nbrCompteCreeLinkedin[0]?></b><br>
    Nombre de comptes crées sur le landing Linxo : <b><?=$this->datas->nbrCompteCreeLinxo[0]?></b><br>
    Nombre de comptes crées sur le landing Twitter : <b><?=$this->datas->nbrCompteCreeTwitter[0]?></b><br>

</div>

<h2>Origine des connexions de la semaine</h2>
<?php
	$stats = Dh::getWhereFromStatsDay();
?>

<h2>Statistiques SCPI</h2>
<table border="1" class="tableStats cli">
	<tr>
		<th>SCPI</th>
		<th>Valorisation MSCPI</th>
		<th>Valorisation autre</th>
		<th>Valorisation totale</th>
	</tr>
	<?php
		$totM = 0;
		$totA = 0;
		$totT = 0;
	foreach(Scpi::getAll() as $elm) : ?>
	<tr onclick='window.open("?p=UsersByScpi2&scpi=<?=$elm->id?>", "_blank")'>
		<td><?= substr($elm->name, 4) ?></td>
		<td><?= number_format($elm->ventePotentielleMscpi, 2, ",", " ")?> €</td>
		<td><?= number_format($elm->ventePotentielleOther, 2, ",", " ")?> €</td>
		<td><?= number_format($elm->ventePotentielleTotal, 2, ",", " ")?> €</td>
	</tr>
	<?php 
		$totM += $elm->ventePotentielleMscpi;
		$totA += $elm->ventePotentielleOther;
		$totT += $elm->ventePotentielleTotal;

	endforeach; ?>
	<tr>
		<th>Total</th>
		<th><?= number_format($totM, 2, ",", " ") ?></th>
		<th><?= number_format($totA, 2, ",", " ") ?></th>
		<th><?= number_format($totT, 2, ",", " ") ?></th>
	</tr>
</table>

<h2>Statistique Centre d'Interet</h2>
<table border="1" class="tableStats">
	<?php
	$bn = 0;
	foreach ($this->datas->StatCentreInteret as $v) : ?>
	<tr>
		<td><?= $v['nom'] ?></td>
		<td><?= $v['cnt'] ?></td>
	</tr>
	<?php
	$bn += $v['cnt'];
	endforeach; ?>
	<tr>
		<td>Total</td>
		<td><?= $bn ?></td>
	</tr>
</table>
