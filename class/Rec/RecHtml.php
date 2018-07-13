<page backtop="140px" backleft="30px" backright="30px" backbottom="30px">
	<page_header style="vertical-align:top;">
		<img height="100" src="<?= dirname(__FILE__) . "/img/MS-Logo-RVB.png" ?>">
		<?php
		/*
		<span class="textHeader">RAPPORT ECRIT DE CONSEIL</span>
		*/
		?>
	</page_header>
	<page_footer>
		<div style="width:650px;display:inline">
			Nous contacter : 0805 696 022 (Appel gratuit depuis un téléphone fixe) - contact@MeilleureSCPI.com
		</div>
		<div style="display:inline;width:90px;">
			Page [[page_cu]] / [[page_nb]]
		</div>
	</page_footer>
	<h1>RAPPORT ÉCRIT DE CONSEIL du <?=strtoupper(date("d/m/Y"))?></h1>
	<nobreak>
		<h2>I. Rappels sur le contexte et vos besoins</h2>
		<h3>1. Rappel du contexte de notre mission et la demande</h3>
		<p style="text-align: justify; text-justify: inter-word;font-size:12px;">
		À la suite à votre demande entrante (site internet ou appel téléphonique), vous, <?=$this->dh->getShortName()?>, (appelé donneur d'ordre), nous avez contactés et vous souhaitez être accompagné dans le cadre d'un projet d’investissement dans des fonds immobiliers. Vous souhaitez faire l’investissement pour	<?=$this->beneficiaire->getShortName()?>.
		Lors de votre accès à moncompte.meilleurescpi.com le <?=$this->fil->getDateValidation()->format("d/m/Y")?>, vous avez validé un exemplaire de la fiche d’information légales de MeilleureSCPI.com appelée document d’entrée en relation.
		Dans ce document, nous vous avons présenté toutes les mentions relatives à l’exercice de nos activités réglementées qui nous permettent d’accompagner nos clients dans le conseil et la distribution de produits financiers, de produits d’assurance et de produits bancaires.
		Le <?=$this->lm->getDateExecution()->format("d/m/Y")?>, vous avez signé notre lettre de mission dans laquelle nous vous présentons notre mission de conseil. Afin que nous puissions poursuivre notre mission, vous avez complété le questionnaire client et le profil d'investisseur <?=(count($this->Pps) > 1) ? "des" : "du" ?> bénéficiaire<?=(count($this->Pps) > 1) ? "s" : "" ?>.
		<b>
			Le profil d'investisseur a permis à votre conseiller de faire un point sur les connaissances en SCPI <?=(count($this->Pps) > 1) ? "des" : "du" ?> bénéficiaire<?=(count($this->Pps) > 1) ? "s" : "" ?>. Une note explicative écrite vous a été adressée par mail à la suite de vos réponses au questionnaire de connaissance en SCPI. La note explicative concernait les points que vous avez souhaité approfondir lors de l'établissement du scoring (profil d'investisseur).
		</b>
		</p>
		<h3>2. Information <?=(count($this->Pps) > 1) ? "des" : "du" ?> bénéficiaire<?=(count($this->Pps) > 1) ? "s" : "" ?></h3>
		<?php
		foreach ($this->Pps as $key => $Pp)
		{
			?>
			<div style="margin:10px 20px 10px 20px">
				<h4>
					Bénéficiaire <?=$key + 1?> :
					<?=$Pp->getCivilite()?> <?=$Pp->getFirstName()?> <?=$Pp->getName()?> né<?=$Pp->getCiviliteStr() == "Mme" ? "e" : ""?>  le <?=$Pp->getDateNaissance()->format("d/m/Y")?> à <?=$Pp->getLieuNaissanceStr()?>
					<br /> 
					&nbsp;&nbsp;&nbsp;&nbsp;résidant au <?=$Pp->getAdresseStr()?> - <?=$Pp->getCodeVilleStr()?>
				</h4>
			</div>
			<?php
		}
		?>

		<h3>3. Situation <?=(count($this->Pps) > 1) ? "des" : "du" ?> bénéficiaire<?=(count($this->Pps) > 1) ? "s" : "" ?> et caractéristiques de votre projet d'investissement</h3>
		<table class="t_3 alignRight" border="1"  style="font-size:10px; margin-left:100px;margin-top:20px;">
			<tr>
				<th>État civil</th>
				<td><?=$this->Pps[0]->getEtatCivilStr()?></td>
			</tr>
			<tr>
				<th>Enfants</th>
				<td><?= $this->situationJuridique->getHaveChild() ? "oui" : "non"?></td>
			</tr>
			<tr>
				<th>Nombre d'enfants à charge</th>
				<td><?=($this->situationJuridique->getNbrEnfantCharge() > 0) ? $this->situationJuridique->getNbrEnfantCharge() : "aucun"?></td>
			</tr>
			<tr>
				<th>Résident fiscal en France</th>
				<td><?= $this->situationFiscale->getIsResidentFrance() ? "oui" : "non"?></td>
			</tr>
			<tr>
				<th>Impôt sur le revenu</th>
				<td><?= $this->situationFiscale->haveImpot() ? "oui" : "non"?></td>
			</tr>
			<tr>
				<th>Tranche Marginale d'Imposition</th>
				<td><?= number_format($this->situationFiscale->getValeurImpot()['taux'], 2, ",", " ") ?> %</td>
			</tr>
			<tr>
				<th>Imposé à l'ISF (Impôts sur la fortune)</th>
				<td><?= $this->situationFiscale->haveIsf() ? "oui" : "non"?></td>
			</tr>
			<tr>
				<th>Tranche ISF (Impôts sur la fortune)</th>
				<td>
					<?php
					if ($this->situationFiscale->id_tranche_impot_fortune != 0)
						echo number_format($this->situationFiscale->getValeurIsf()['taux'], 2, ",", " ") . " %";
					else
						echo "-"
					?>
				</td>
			</tr>
			<tr>
				<th style="padding-top:5px;">Pourcentage que représente cet investissement par rapport au patrimoine actuel</th>
				<td><?=$this->situationPatrimoniale->getFuturPlacementStr()?></td>
			</tr>
			<tr>
				<th>Montant d'investissement souhaité</th>
				<td><?=$this->projet->getBudget()?></td>
			</tr>
			<tr>
				<th>Taux d'endettement</th>
				<td><?=number_format($this->situationFinanciere->getTauxDEndettement(), 2, ",", " ")?> %</td>
			</tr>
		</table>
		<p style="margin-top:20px;">Autres éléments ayant déterminé le conseil :</p>
		<p>
			<?=$this->projet->getAutresElements()?>
		</p>
<?php
/*
		<p>
			Le<?=(count($this->Pps) > 1) ? "s" : ""?> bénéficiaire<?=(count($this->Pps) > 1) ? "s" : ""?> <?=(count($this->Pps) > 1) ? "sont" : "est"?> <?=$this->Pps[0]->getEtatCivil()?>. Le<?=(count($this->Pps) > 1) ? "s" : ""?> bénéficiare<?=(count($this->Pps) > 1) ? "s" : ""?> <?=(count($this->Pps) > 1) ? "ont" : "a"?> <?=$this->situationJuridique->getHaveChild() ? "des" : "aucun"?> enfant(s)
			<?php
			if ($this->situationJuridique->getHaveChild())
			{
				?>
				dont <?=$this->situationJuridique->getNbrEnfantCharge()?> à charge<?=($this->situationJuridique->getNbrEnfantCharge() > 1) ? "s" : ""?>
				<?php
			}
			?>
			<br />
			La Tranche Marginale d’Imposition <?=(count($this->Pps) > 1) ? "des" : "du"?> bénéficiaire<?=(count($this->Pps) > 1) ? "s" : ""?> est de <?= $this->situationFiscale->getValeurImpot()['taux'] ?> % 
			<?php if ($this->situationFiscale->id_tranche_impot_fortune != 0) { ?>
				et la Tranche ISF est de <?= $this->situationFiscale->getValeurIsf()['taux'] ?> %
			<?php } ?>


			<br />
			Le montant d'investissement souhaité par <?=(count($this->Pps) > 1) ? "les" : "le"?> bénéficiaire<?=(count($this->Pps) > 1) ? "s" : ""?> <?=$this->projet->getBudget()?>
			<br />
			La SCPI représenterait donc <?=$this->situationPatrimoniale->getFuturPlacementStr()?>
			<br />
			Le taux d'endettement <?=(count($this->Pps) > 1) ? "des" : "du"?> bénéficiare<?=(count($this->Pps) > 1) ? "s" : ""?> est de <?=number_format($this->situationFinanciere->getTauxDEndettement(), 2, ",", " ")?> %
		</p>
		*/
		?>
	</nobreak>
	<nobreak>
		<h2>
			II. Analyse des objectifs des bénéficiaires	
		</h2>
		<p>
			Notre analyse se fonde sur le croisement des objectifs hiérarchisés, du profil d'investisseur, ainsi que la situtation financière, fiscale et patrimoniale (éléments prélevés dans notre questionnaire client et repris dans ce présent rapport de mission) <?=(count($this->Pps) > 1) ? "des" : "du" ?> bénéficiaire<?=(count($this->Pps) > 1) ? "s" : "" ?>.
		</p>
		<table class="t_3" border="1"  style="font-size:10px;">
			<tr>
				<?php foreach ($this->objectifs as $key => $elm) { ?>
					<th><b style="font-size:12px"><?=$key + 1?></b> <?= Projet::$_listObjectif[$elm] ?></th> <?php }?>
			</tr>
			<tr>
				<?php foreach ($this->objectifs as $key => $elm) { ?>
					<td><?= Projet::$_listObjectifText[$elm] ?></td> <?php }?>
			</tr>
			<tr>
				<?php foreach ($this->objectifs_list as $key => $elm) { ?>
					<td><?= $elm->getName() ?></td> <?php }?>
			</tr>
			<tr>
				<?php foreach ($this->objectifs_list as $key => $elm) { ?>
					<td><?= $elm->getContent() ?></td> <?php }?>
			</tr>
			
		</table>
		<p>
			Vous avez complété le questionnaire client et nous vous avons remis les documents suivants :<br />
			<ul>
				<?php
				foreach ($this->projet->getDocuments(7) as $key => $elm) { ?>
					<li><?=$elm->getTypeDocument()->getName()?> le <?=$elm->getDateCreation()->format("d/m/Y")?> </li>
				<?php } ?>
				<?php
				foreach ($this->projet->getDocuments(8) as $key => $elm) { ?>
					<li><?=$elm->getTypeDocument()->getName()?> le <?=$elm->getDateCreation()->format("d/m/Y")?> </li>
				<?php } ?>
			</ul>
			Le conseiller travaille à l'appui de plusieurs documents dont : <br />
			<b>1.</b> Une sélection de SCPI (comparaison) accompagnée d’une méthodologie de sélection (critères financiers et immobiliers). Cette sélection s’est effectué en conservant « les SCPI qui ont retenu votre attention » mais aussi en fonction de critères importants pour faire un bon investissement (TDVM, taux d’occupation Financier, réserves de la SCPI, patrimoine des SCPI, provisions pour Grosse Réparation…). Le but était de confronter les SCPI qui ont retrenu votre attention avec d'autres SCPI correspondant à nos critères d'investissement, d'obtenir une transparence de l'information et d'établir un portefeuille de SCPI
			<br />
			<b>2.</b> Plusieurs simulations d’investissement accompagnée d’une suggestion de SCPI pour étudier les différentes stratégies d'investissement en SCPI
		</p>
	</nobreak>
	<nobreak>
		<h2>III. Préconisations sur la stratégie d'investissement</h2>
		<p style="text-align: justify; text-justify: inter-word">
			Au regard : <br />
			1. des différents objectifs <?=(count($this->Pps) > 1) ? "des" : "du" ?> bénéficiaire<?=(count($this->Pps) > 1) ? "s" : "" ?> et de la stratégie définie pour ces objectifs dans ce présent rapport de conseil <br />
			2. des connaissances en matière financière et en matière de SCPI et du profil établie, soit 
				<?php
				foreach ($this->Pps as $key => $Pp)
				{
					$tmp = $Pp->getLastProfilInvestisseur();
					if (empty($tmp))
						continue ;
					if ($key > 0)
						echo "et ";
					?>
					<?=$tmp->getProfil()["profil"]?> pour le Bénéficiaire <?=$key + 1?>
					<?php
				}
				?> <br />
			3. du croisement entre des objectifs et la situation fiscale, patrimoniale et financière <?=(count($this->Pps) > 1) ? "des" : "du" ?> bénéficiaire<?=(count($this->Pps) > 1) ? "s" : "" ?>. <br />
			4. des précisions concernant les avantages et les inconvénients des différentes stratégies d'investissement
		</p>
		<p style="text-align:center;">La stratégie globale d'investissement que nous vous proposons est la suivante :</p>
		<div class="blockStrategie">
			<p><?=$this->projet->getStrategie()?></p>
		</div>
	</nobreak>
</page>
<page orientation="landscape" backtop="0px" backleft="0px" backright="0px" backbottom="0px">
	<page_footer>
		<div style="width:980px;display:inline">
			Nous contacter : 0805 696 022 (Appel gratuit depuis un téléphone fixe) - contact@MeilleureSCPI.com
		</div>
		<div style="display:inline;width:90px;">
			Page [[page_cu]] / [[page_nb]]
		</div>
	</page_footer>
	<nobreak>
		<h2>IV. Nos préconisations sur le portefeuille de SCPI </h2>
		<?php
		foreach ($this->pTrans as $key => $grps)
		{
			if ($key != 0)
				echo "<br />";
			?>
			<h5>
				<?=$key + 1?> / <?=count($this->pTrans)?>
			</h5>
			<table border="1" class="t_4 thRight" style="font-size:10px;margin-left:22px;">
				<tr>
					<th>Nom de la SCPI proposée</th>
					<?php
					foreach ($grps as $keyScpi  => $scpiTrans){ ?>
						<th style="text-align:center;"><?=$scpiTrans['scpi']->getName()?></th>
					<?php } ?>
				</tr>
				<tr>
					<th>Société de gestion </th>
					<?php
					foreach ($grps as $keyScpi  => $scpiTrans){ ?>
						<td><?=$scpiTrans['scpi']->getSocieteGestion()->getName()?></td>
					<?php } ?>
				</tr>
				<tr>
					<th>Nombre de parts</th>
					<?php
					foreach ($grps as $keyScpi  => $scpiTrans){ ?>
						<td><?=$scpiTrans["nbr_part"]?></td>
					<?php } ?>
				</tr>
				<tr>
					<th>Type de propriété</th>
					<?php
					foreach ($grps as $keyScpi  => $scpiTrans){ ?>
						<td><?=$scpiTrans["typePro"]?></td>
					<?php } ?>
				</tr>
				<tr>
					<th>Clé de repartition pour la Nue propriété ou l'Usufruit</th>
					<?php
					foreach ($grps as $keyScpi  => $scpiTrans)
					{
						if ($scpiTrans["typePro"] == "PP")
							echo "<td>-</td>";
						else
						{
							?>
							<td><?=number_format($scpiTrans["cleRepartition"], 2, ",", " ")?> %</td>
							<?php 
						}
					} ?>
				</tr>
				<tr>
					<th>Montant d’investissement</th>
					<?php
					foreach ($grps as $keyScpi  => $scpiTrans){ ?>
						<td><?=number_format($scpiTrans["MontantInvestissement"], 2, ",", " ")?> €</td>
					<?php } ?>
				</tr>
				<tr>
					<th>% part sur le montant d’investissement</th>
					<?php
					foreach ($grps as $keyScpi  => $scpiTrans){ ?>
						<td><?=number_format(($scpiTrans["MontantInvestissement"] * 100) / $this->totalInvestissement, 2, ",", " ")?> %</td>
					<?php } ?>
				</tr>
				<tr>
					<th>Mode de fonctionnement</th>
					<?php
					foreach ($grps as $keyScpi  => $scpiTrans){ ?>
						<td>SCPI à capital <?=$scpiTrans['scpi']->getTypeCapital()?></td>
					<?php } ?>
				</tr>
				<tr>
					<th>Stratégie d'investissement</th>
					<?php
					foreach ($grps as $keyScpi  => $scpiTrans){ ?>
						<td><?=$scpiTrans['scpi']->getCategoryStr()?></td>
					<?php } ?>
				</tr>
				<tr>
					<th>Précisions de la stratégie d'investissement</th>
					<?php
					foreach ($grps as $keyScpi  => $scpiTrans){ ?>
						<td><?=$scpiTrans['scpi']->getCategorieSecondaireStr()?></td>
					<?php } ?>
				</tr>
				<tr>
					<th>Adéquation de la SCPI avec la stratégie définit</th>
					<?php
					foreach ($grps as $keyScpi  => $scpiTrans){ ?>
						<td><?=$scpiTrans['scpi']->getAdequation()?></td>
					<?php } ?>
				</tr>
				<tr>
					<th>Fourchette de rémunération de MeilleureSCPI.com</th>
					<?php
					foreach ($grps as $keyScpi  => $scpiTrans){ ?>
						<td><?=$scpiTrans['scpi']->getLastFourchetteRemuneration()->getStr()?></td>
					<?php } ?>
				</tr>
				<tr>
		<br />
		<br />
					<th>MeilleureSCPI.com détient des parts de cette SCPI</th>
					<?php
					foreach ($grps as $keyScpi  => $scpiTrans){ ?>
						<td><?= ($scpiTrans['scpi']->mscpiHave()) ? "oui" : "non" ?></td>
					<?php } ?>
				</tr>
			</table>
			</nobreak>
			<nobreak>
			<?php
		}
		?>
		</nobreak>
	</page>
	<page orientation="portrait" backtop="140px" backleft="30px" backright="30px" backbottom="30px">
		<page_header style="vertical-align:top;">
			<img height="100" src="<?= dirname(__FILE__) . "/img/MS-Logo-RVB.png" ?>">
		</page_header>
		<page_footer>
			<div style="width:650px;display:inline">
				Nous contacter : 0805 696 022 (Appel gratuit depuis un téléphone fixe) - contact@MeilleureSCPI.com
			</div>
			<div style="display:inline;width:90px;">
				Page [[page_cu]] / [[page_nb]]
			</div>
		</page_footer>
		<nobreak>
		<br />
		<h2>V. Signature et rappel sur les SCPI</h2>
		<br />
		<p style="text-align: justify; text-justify: inter-word">
			<b>
				Lorsque vous investissez dans une SCPI, vous devez tenir compte des éléments de risques suivants : <br />
			</b>
			- Les parts de SCPI sont des supports de placement à long terme et doivent être acquises dans une optique de diversification de votre patrimoine;<br />
			- Les dividendes qui vous seront versés dépendent des conditions de location des immeubles, notamment de la date de mise en location des immeubles et des loyers perçus;<br />
			- Les conditions de cession (délais, prix) peuvent varier en fonction de l’évolution du marché de l’immobilier et du marché des parts de SCPI;<br />
			- La SCPI ne bénéficie d’aucune garantie ou protection de capital. Le montant dépendra de l’évolution du marché de l’immobilier considéré sur la durée du placement;<br />
			- Lorsque un associé contracte un prêt immobilier pour l'achat de parts de SCPI, les intérêts d'emprunt sont uniquement déductibles sur les revenus fonciers français des SCPI. Ils ne sont pas déductibles sur les revenus issus de l'étranger des SCPI.<br />
			- Dans le cas d'un investissement immobilier avec une stratégie d'investissement au-delà de la zone euro, le capital et les revenus peuvent varier également en fonction du cours des devises.<br />
			Par la signature de ce présent rapport de conseil, vous attestez avoir reçu et pris connaissance des statuts, de la note d’information visée par l’Autorité des marchés financiers, des derniers rapports annuels et bulletins trimestriels des SCPI du portefeuille conseillé.<br />
		</p>
		<br />
		<br />
		<br />
		<?php
		/*
		<p style="font-size:10px;">
			Le présent rapport de conseil, établie en deux exemplaires originaux et est signée par les deux parties.
		</p>
		*/
		?>
		<?php
		if (count($this->Pps) == 2)
		{
			?>
			<table border="1" class="t_<?=($this->Pps[0]->id_phs == $this->dh->lien_phy) ? "3" : "4"?> table_signature">
				<tr>
					<?php
					if ($this->Pps[0]->id_phs != $this->dh->lien_phy)
					{
						?>
						<td>
							Signature du bénéficaire 1 :<br />
							<?=$this->Pps[0]->getShortName()?>
						</td>
						<?php
					}
					?>
					<td>
						Signature du bénéficaire 2 :<br />
						<?=$this->Pps[1]->getShortName()?>
					</td>
					<td>
						Signature du donneur d'ordre <?=($this->Pps[0]->id_phs == $this->dh->lien_phy) ? "(et bénéficiaire)" : ""?><br />
						<?=$this->dh->getShortName()?>
					</td>
					<td>
						Signature du conseiller :<br />
						<?=$this->conseiller->getShortName()?>
					</td>
				</tr>
				<tr>
					<?php
					if ($this->Pps[0]->id_phs != $this->dh->lien_phy)
					{
						?>
						<td style="height:100px">
							Lu et approuvé :
						</td>
						<?php
					}
					?>
					<td style="height:100px">
						Lu et approuvé :
					</td>
					<td style="height:100px">
						Lu et approuvé :
					</td>
					<td style="height:100px">
						Lu et approuvé :
					</td>
				</tr>
			</table>
			<?php
		}
		else if (count($this->Pps) == 1)
		{
			?>
			<table border="1" class="t_<?=($this->Pps[0]->id_phs == $this->dh->lien_phy) ? "2" : "3"?> table_signature">
				<tr>
					<?php
					if ($this->Pps[0]->id_phs != $this->dh->lien_phy)
					{
						?>
						<td>
							Signature du bénéficaire :<br />
							<?=$this->Pps[0]->getShortName()?>
						</td>
						<?php
					}
					?>
					<td>
						Signature du donneur d'ordre <?=($this->Pps[0]->id_phs == $this->dh->lien_phy) ? "(et bénéficiaire)" : ""?><br />
						<?=$this->dh->getShortName()?>
					</td>
					<td>
						Signature du conseiller :<br />
						<?=$this->conseiller->getShortName()?>
					</td>
				</tr>
				<tr>
					<?php
					if ($this->Pps[0]->id_phs != $this->dh->lien_phy)
					{
						?>
						<td style="height:100px">
							Lu et approuvé :
						</td>
						<?php
					}
					?>
					<td style="height:100px"> 
						Lu et approuvé :
					</td>
					<td style="height:100px">
						Lu et approuvé :
					</td>
				</tr>
			</table>
			<?php
		}
		?>
		<br />
		<br />
		<br />
		<br />
		<br />
		<br />
			<img src="<?= dirname(__FILE__) ?>/img/Bandeau-Moncompte.jpg" width="650" />
			<p style="font-size:9px">
				Nom : MeilleureSCPI.com - Siège social : 4, rue de la Michodière - 75002 Paris - Forme juridique : S.A.S. au capital de 10 000 € - Siret 532 567 583 0010 RCS de Paris - NAF/APE : 7022Z - Site internet : <a href="http://www.meilleurescpi.com">MeilleureSCPI.com</a> Conformément aux dispositions de l'article 325-12-1 du règlement de l’AMF, MeilleureSCPI.com a établi une procédure efficace et transparente en vue du traitement raisonnable et rapide des réclamations que lui adressent ses clients existants ou potentiels. Vous pouvez adresser vos réclamations par voie postale : à l’adresse suivante : MeilleureSCPI.com - Service Clients / Gestion des réclamations - 4, rue de la Michodière - 75002 Paris - par email : <a href="mailto:reclamation@meilleurescpi.com">reclamation@meilleurescpi.com</a> - par téléphone : 01 82 28 90 28 et en remplissant le formulaire de réclamation (en cliquant sur ce <a href="https://fr.slideshare.net/secret/IxSPbzQVQ2T5os">lien</a>) Votre Conseiller s’engage à traiter votre réclamation dans les délais suivants :
				- dix jours ouvrables maximum à compter de la réception de la réclamation, pour accuser réception, sauf si la réponse elle-même est apportée au client dans ce délai ;
				- deux mois maximum entre la date de réception de la réclamation et la date d’envoi de la réponse au client sauf survenance de circonstances particulières dûment justifiées. Le réclamant peut notamment s’adresser à : L’ACPR, L’AMF, L’ANACOFI.
				MeilleureSCPI.com est inscrit à l’ORIAS sous le numéro d’immatriculation 13000814 (<a href="http://www.orias.fr">www.orias.fr</a>) au titre des activités réglementées suivantes : 
				- Conseiller en investissement financier (CIF) enregistré auprès de l’ANACOFI-CIF, association agréée par l’Autorité des Marchés Financiers (AMF)
				- Courtier d'assurance ou de réassurance (COA) positionné dans la catégorie b Art. L520-1 II 1° du Code des assurances ;
				- Mandataire d’intermédiaire d’assurance (MIA)
				- Mandataire non exclusif en opérations de banque et en services de paiement (MOBSP)
				La société ne peut recevoir aucun fonds, effets ou valeurs.
				MeilleureSCPI.com dispose, conformément à la loi et au code de bonne conduite de l’ANACOFI-CIF, d’une couverture en Responsabilité Civile Professionnelle suffisante couvrant ses diverses activités.
				Ce document n'a aucune valeur contractuelle et ne saurait en aucun cas engager la responsabilité de MeilleureSCPI.com.
			</p>
	</nobreak>
</page>
<style>
	h1, h2, h4 {
		color:#01528A;
		margin-bottom:10px;
	}
	h1 {
		font-size:24px;
		text-align:center;
		margin-bottom:15px;
	}
	h2 {
		font-size:20px;
		margin-top:30px;
		margin-bottom:5px;
	}
	h3 {
		margin-top:15px;
		margin-bottom:5px;
		font-size: 14px;
		text-decoration: underline;
	}
	h4 {
		font-size: 12px;
		margin: 0px;
	}
	p {
		margin: 5px 0px;
		padding: 0px 0px;
		font-size: 12px;
	}
	table {
		border-collapse: collapse;
	}
	table td,
	table th {
		text-align:center;
		font-size: 10px;
	}
	.table_signature td {
		text-align: center;
		vertical-align: top;
	}
	.t_2 td, .t_2 th {
		width:330px;
	}
	.t_3 td, .t_3 th {
		width:220px;
	}
	.t_5 td, .t_5 th {
		width:127px;
	}
	.t_4 td, .t_4 th {
		width:166px;
	}
	.notOkay {
		color:red;
	}
	.textHeader {
		margin-left:430px;
		font-size:16px;
		font-weight:bold;
	}

	table {
		width: 100%; pdf
		margin: 0 auto;
		border: 1px solid lightgray;
		border-collapse: collapse;
	}
	th {
		height: 6mm;
	}
	th, .bg {
		background: lightgray;
	}
	td {
		height: 3mm;
	} 
	.protips
	{
		font-size:12px;
		font-weight:400;
		color:#505050;
		font-style:italic
	}
	#advert {
		font-weight:300;
		padding: 2mm;
		color: black;
	}
	.tac {
		text-align: center;
	}
	.tar {
		text-align: right;
	}
	.4 {
		width:40%;
	}
	.2 {
		width:20%;
	}
	.alignRight th {
		text-align:right;
		padding-right:10px;
	}
	.thRight th {
		text-align: right;
		padding-right:10px;
	}
	.blockStrategie {
		border: 1px solid black !important;
		padding:0px 20px 20px 20px;
	}
</style>
