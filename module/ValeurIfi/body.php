<?php

ob_start();
$i = 0;
foreach ($data as $k => $v)
{
	if ($k !== "precalcul")
	{
		if ($v['precalcul']['nbr_part_isf'] > 0)
		{
			?><tr>
				<td class="4 tac"><?=substr($k, 5)?></td>
				<td class="2 tar"><?=number_format($v['precalcul']['nbr_part_isf'], 5, ',', ' ')?>&nbsp;</td>
				<td class="2 tar"><?php
				$value = ($this->expatrie) ? $v['precalcul']['scpi']->getValeurIfiExpatrie2018() : $v['precalcul']['scpi']->getValeurIfi2018();
				if ($value !== null)
					echo number_format($value, 2, ',', ' ');
				else
					echo '<span class="protips">(**)</span>';
				 ?>&nbsp;</td>
				<td class="2 tar">
				<?php
				$value2 = ($this->expatrie) ? $v['precalcul']['valeur_ifi_expatrie_2018'] : $v['precalcul']['valeur_ifi_2018'];
				if ($value2 !== null && $value !== null)
					echo number_format($value2, 2, ',', ' ');
				else
					echo '<span class="protips">(**)</span>';
				?>&nbsp;</td>
			</tr><?php
			++$i;
		}
	}
	else
	{
		?>
		<tr>
			<td class="tf" colspan="2">&nbsp;</td>
			<td class="2 tar bg"><strong>Total (&euro;)&nbsp;&nbsp;</strong></td>
			<?php
				$value = ($this->expatrie) ? $v['valeur_ifi_expatrie_2018'] : $v['valeur_ifi_2018'];
			?>
			<td class="2 tar bg"><strong><?= ($value) ? number_format($value, 2, ',', ' ') : '-' ;?></strong>&nbsp;</td>
		</tr>
	<?php
	}
}
$b = ob_get_contents();
ob_get_clean();

$date_du_jour = new DateTime();


ob_start();
?>
<style>

table {
	width: 100%;
	margin: 0 auto;
	border: 1px solid lightgray;
	border-collapse: collapse;
}
th {
	height: 8mm;
}
th, .bg {
	background: lightgray; /* #D8D8D8 */
}
td {
	height: 4mm;
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
#advert {

}
</style>
<page backimg="<?= dirname(__FILE__) ?>/img/MS-watermark.png" backtop="30mm" backbottom="105mm" footer="page">
	<page_header>
		<img width="194" src="<?= dirname(__FILE__) . "/img/MS-Logo-RVB.png" ?>">
	</page_header>
	<page_footer>
	<img src="<?= dirname(__FILE__) ?>/img/Bandeau-Moncompte.jpg" alt="" width="750" />
	<p style="font-size:9px">Nom : MeilleureSCPI.com - Siège social : 4, rue de la Michodière - 75002 Paris - Forme juridique : S.A.S. au capital de 10 000 € - Siret 532 567 583 0010 RCS de Paris - NAF/APE : 7022Z - Site internet : <a href="http://www.meilleurescpi.com">MeilleureSCPI.com</a> Conformément aux dispositions de l'article 325-12-1 du règlement de l’AMF, MeilleureSCPI.com a établi une procédure efficace et transparente en vue du traitement raisonnable et rapide des réclamations que lui adressent ses clients existants ou potentiels. Vous pouvez adresser vos réclamations par voie postale : à l’adresse suivante : MeilleureSCPI.com - Service Clients / Gestion des réclamations - 4, rue de la Michodière - 75002 Paris - par email : <a href="mailto:reclamation@meilleurescpi.com">reclamation@meilleurescpi.com</a> - par téléphone : 01 82 28 90 28 et en remplissant le formulaire de réclamation (en cliquant sur ce <a href="https://fr.slideshare.net/secret/IxSPbzQVQ2T5os">lien</a>) Votre Conseiller s’engage à traiter votre réclamation dans les délais suivants :
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
	Les contribuables dont le patrimoine immobilier excède 1 300 000€ au 1er janvier 2018 sont assujettis à l’Impôt sur la Fortune Immobilière (IFI). Pour la détermination de leur patrimoine taxable, les souscripteurs de parts de SCPI sont tenus de prendre en compte la valeur au 1er janvier 2018 des parts de SCPI. A cet égard, les emprunts ayant servi à l’acquisition de ces parts sont déductibles du patrimoine imposable. En cas de démembrement des parts, seul l’usufruitier est en principe imposable au titre de l’IFI. S’agissant des modalités déclaratives, seuls les contribuables dont le patrimoine est supérieur à 2 570 000 € sont tenus de souscrire une déclaration d’ISF (formulaire 2725). Les personnes imposables dont le patrimoine est compris entre 1 300 000 € et 2 570 000€ mentionnent simplement le montant de la valeur brute et de la valeur nette taxable de leur patrimoine sur leur déclaration annuelle de revenus (2042C). Les valeurs IFI sont différentes entre résidents et non-résidents. Seuls les immeubles situés en France entrent dans la base d’imposition pour des non-résidents.
	</p>
	</page_footer>
	<p style="text-align: center;margin-top:0;padding-top:0;">
		<span class="protips" style="margin-left:120mm;font-size:14px;">Le <?= date_fr($date_du_jour->format("d F Y")) ?></span>
		<h4>Valeur<?php if ($i > 1) echo 's' ?> IFI (<?=($this->expatrie) ? "non résident fiscal Français": "résident fiscal Français"?>) au 01/01/<?= date('Y') ?></h4>
	</p>
	<table border="1" bordercolor="#D8D8D8" cellpadding="0" cellspacing="0">
		<thead>
			<tr>
				<th class="4 tac">SCPI</th>
				<th class="2 tac">Nombre de parts</th>
				<th class="2 tac">Valeur par part (*)</th>
				<th class="2 tac">Total par SCPI</th>
			</tr>
		</thead>
		<tbody>
		<?=$b?>
		</tbody>
	</table>
	<span class="protips">* Ce document est non contractuel. Il convient de vous rapprocher des sociétés de gestion qui vous communiquent les valeurs IFI à déclarer.</span><br />
	<span class="protips">** Merci de vous rapprocher de votre société de gestion pour en connaître la valeur.</span><br />
	<span class="protips">*** Ce document concerne l'ensemble des transactions saisies sur MeilleureSCPI.com.</span>
</page>
<?php
$c = ob_get_contents();
ob_get_clean();

//echo $c;
//exit();

$h2p = new HTML2PDF('P', 'A4', 'fr');
$h2p->pdf->addFont('futurastd','', dirname(__FILE__) . '/font/futurastd.php');
$h2p->pdf->addFont('futurastd','B', dirname(__FILE__) . '/font/futurastdbold.php');
$h2p->pdf->addFont('futurastd','I', dirname(__FILE__) . '/font/futurastdoblique.php');
$h2p->pdf->SetDisplayMode('fullpage');
$h2p->SetDefaultFont('futurastd');
$h2p->WriteHTML($c);
$name = ($this->expatrie) ? 'Valeur_IFI_expatrie_'.date('Y').'.pdf' : 'Valeur_IFI_'.date('Y').'.pdf';
$h2p->Output($name, 'I');
exit();
