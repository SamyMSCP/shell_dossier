<p style="font-family:sans-serif;color: #1d588c;">
	Bonjour <?=$this->getPp()->getCivilite()?> <?=$this->getPp()->getName()?>,
	<br />
	<br />
	Dans le cadre d’un projet d’investissement en parts de SCPI vous avez renseigné votre profil investisseur en date du <?=$this->getDateCreation()->format("d/m/Y")?>.
	<br /><br />
	Suite à ce profil investisseur veuillez noter que vous avez un <u><b><?=mb_strtolower($this->getProfil()['profil'])?>.</b></u><br /><br />
	Description d’un <?=mb_strtolower($this->getProfil()['profil'])?> : <?=$this->getProfil()['description']?><br />
</p>
<p style="font-family:sans-serif;color: #1d588c;">
	Vous retrouvez ci-dessous des précisions par rapport à vos réponses incorrectes. 
</p>
<p style="font-family:sans-serif;color: #1d588c;">
	Un conseiller prendra contact avec vous dans les meilleurs délais. Par ailleurs, il vous adressera dans les plus brefs délais une sélection comparative de SCPI, une suggestion de portefeuille (répartition typologique et géographique), et une ou des simulations financières d’investissement adaptée à votre situation fiscale et patrimoniale si vous le souhaitez.
</p>
<span style="font-family:sans-serif;color: #1d588c;">
	<?=$this->getPp()->getDh()->getConseiller()->getShortName()?><br />
	<?=$this->getPp()->getDh()->getConseiller()->getLogin()?><br />
	<br />
<table border="0" style="font-family: sans-serif;border-spacing: 0;border-collapse: collapse;">
	<thead>
		<tr style="color:white; background-color:#1781e0;">
			<th style="padding:5px;">Questions</th>
			<th style="padding:5px;min-width: 132px;text-align: center;">Réponses</th>
			<th style="padding:5px;">Explications</th>
		</tr>
	</thead>
	
	<tbody>
		<?php
		if ($this->getSiJinvesti() != "480")
		{
			?>
			<tr style="border-bottom: 1px solid #d0e2f3;
					<?php
					if ($this->getSiJinvesti() != "480")
						echo "color: #1d588c;";
					else
						echo "background: #dfeefb;";
					?>
			">
				<td style="padding: 20px;">
					Si j’investis 10 000 € dans une SCPI qui a un TDVM de 4,8%. Quels sont mes revenus annuels ? 
				</td>
				<td style="padding: 20px;text-align:center;
					<?php
					if ($this->getSiJinvesti() != "480")
						echo "color: red";
					?>
				">
					<?=$this->getSiJinvesti()?>
				</td>
				<td style="padding: 20px;">
					<?php if ($this->getSiJinvesti() != "480") { ?>
						<?=ProfilInvestisseur::$_correction480?>
					<?php } ?>
				</td>
			</tr>
		<?php
		}

		$quiz = $this->getQuizArray();
		foreach(ProfilInvestisseur::$_listQuestions as $key => $elm)
		{
			if ($elm['online'] != true)
				continue ;
			if ($elm['response'][$quiz[$key]] != 0)
				continue ;
			?>
			<tr style="border-bottom: 1px solid #d0e2f3;
				<?php
				if ($elm['response'][$quiz[$key]] == 0)
					echo "color: #1d588c;";
				else
					echo "background: #dfeefb;color: #1d588c;";
				?>
			">
				<td style="padding: 20px;">
					<?=$elm['title']?>
				</td>
				<td style="padding: 20px;text-align:center;
				<?php
				if ($elm['response'][$quiz[$key]] == 0)
					echo "color: red";
				?>
				">
					<?=ProfilInvestisseur::$_listReponses[$quiz[$key]]?>
				</td>
				<td style="padding: 20px;">
					<?=$elm['correction']?>
				</td>
			</tr>
			<?php
		}
		?>
	</tbody>
</table>
<br />
<br />
<hr />
Si vous souhaitez améliorer vos connaissances, nos guides sont disponibles sur votre compte client à l'adresse <a href="<?=getThisDomain()?>/index.php?p=Bibliotheque"><?=getThisDomain()?>/index.php?p=Bibliotheque</a><br /><br />
Guide SCPI : <a href="https://meilleurescpicom.eekl.it/p/66070017cd?email_auto=<?=$this->getPp()->getMail()?>">https://meilleurescpicom.eekl.it/p/66070017cd?email_auto=<?=$this->getPp()->getMail()?></a><br />
Guide de la déclaration : <a href="https://meilleurescpicom.eekl.it/p/0d6a94a4d0?email_auto=<?=$this->getPp()->getMail()?>">https://meilleurescpicom.eekl.it/p/0d6a94a4d0?email_auto=<?=$this->getPp()->getMail()?></a><br />
Guide SCPI Fiscales 2016 - 2017 : <a href="https://meilleurescpicom.eekl.it/p/145defbd88?email_auto=<?=$this->getPp()->getMail()?>">https://meilleurescpicom.eekl.it/p/145defbd88?email_auto=<?=$this->getPp()->getMail()?></a><br />
Guide du démembrement temporaire SCPI : <a href="https://meilleurescpicom.eekl.it/p/1ddb9ad2d3?email_auto=<?=$this->getPp()->getMail()?>">https://meilleurescpicom.eekl.it/p/1ddb9ad2d3?email_auto=<?=$this->getPp()->getMail()?></a><br />
<br />
<br />
<hr />
<br />
<p>
	Nom : MeilleureSCPI.com - Siège social : 4, rue de la Michodière - 75002 Paris<br />
	Forme juridique : S.A.S. au capital de 10 000 € - Siret 532 567 583 0010 RCS de Paris - NAF/APE : 7022Z<br />
	Adresse e-mail : <a href="mailto:contact@meilleurescpi.com">contact@meilleurescpi.com</a> - Site internet : MeilleureSCPI.com - Tél : 0805 696 022 (appel gratuit depuis un fixe)<br />
</p>

<p>
	Conformément aux dispositions de l'article 325-12-1 du règlement de l’AMF, MeilleureSCPI.com a établi une procédure efficace et transparente en vue du traitement raisonnable et rapide des réclamations que lui adressent ses clients existants ou potentiels.<br />
	Vous pouvez adresser vos réclamations par voie postale : à l’adresse suivante : MeilleureSCPI.com - Service Clients / Gestion des réclamations - 4, rue de la Michodière - 75002 Paris - par email : <a href="mailto:reclamation@meilleurescpi.com">reclamation@meilleurescpi.com</a> - par téléphone : 01 82 28 90 28 et en remplissant le formulaire de réclamation (en cliquant sur ce lien)<br />
	Votre Conseiller s’engage à traiter votre réclamation dans les délais suivants :<br />
	<ul>
		<li>
			dix jours ouvrables maximum à compter de la réception de la réclamation, pour accuser réception, sauf si la réponse elle-même est apportée au client dans ce délai ;
		</li>
		<li>
			deux mois maximum entre la date de réception de la réclamation et la date d’envoi de la réponse au client sauf survenance de circonstances particulières dûment justifiées. Le réclamant peut notamment s’adresser à : L’ACPR , L’AMF, L’ANACOFI.
		</li>
	</ul>
</p>

<p>
	MeilleureSCPI.com est inscrit à l’ORIAS sous le numéro d’immatriculation 13000814 (www.orias.fr) au titre des activités réglementées suivantes :<br />
	<ul>
		<li>
			Conseiller en investissement financier (CIF) enregistré auprès de l’ANACOFI-CIF, association agréée par l’Autorité des Marchés Financiers (AMF)<br />
		</li>
		<li>
			Courtier d'assurance ou de réassurance (COA) positionné dans la catégorie b Art. L520-1 II 1° du Code des assurances
		</li>
		<li>
			Mandataire d’intermédiaire d’assurance (MIA)
		</li>
		<li>
			Mandataire non exclusif en opérations de banque et en services de paiement (MOBSP)
		</li>
	</ul>
	La société ne peut recevoir aucun fonds, effets ou valeurs.<br />
	MeilleureSCPI.com dispose, conformément à la loi et au code de bonne conduite de l’ANACOFI-CIF, d’une couverture en Responsabilité Civile Professionnelle suffisante couvrant ses diverses activités.
</p>
