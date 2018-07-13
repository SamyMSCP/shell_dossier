<?php
ob_start();

foreach ($this->data as $t => $v)
{
	if (isset($v['Pleine']))
	{
		?><tr>
			<td class="4 tac"><?= substr($v['Pleine']['precalcul']['scpi']->name, 5) ?></td>
			<td class="2 tac"><?= $v['Pleine']['precalcul']['type_pro'] ?></td>
			<td class="2 tar"><?= number_format($v['Pleine']['precalcul']['nbr_part'], 5, ',', ' ') ?></td>
			<td class="2 tar"><?= number_format($v['Pleine']['precalcul']['ventePotentielle'], 2, ',', ' ') ?></td>
		</tr><?php
	}
	if (isset($v['Usu']))
	{
		?><tr>
			<td class="4 tac"><?= substr($v['Usu']['precalcul']['scpi']->name, 5) ?></td>
			<td class="2 tac"><?= $v['Usu']['precalcul']['type_pro'] ?></td>
			<td class="2 tar"><?= number_format($v['Usu']['precalcul']['nbr_part'], 5, ',', ' ') ?></td>
			<td class="2 tar"><?= number_format($v['Usu']['precalcul']['ventePotentielle'], 2, ',', ' ') ?></td>
		</tr><?php
	}
	if (isset($v['Nue']))
	{
		?><tr>
			<td class="4 tac"><?= substr($v['Nue']['precalcul']['scpi']->name, 5) ?></td>
			<td class="2 tac"><?= $v['Nue']['precalcul']['type_pro'] ?></td>
			<td class="2 tar"><?= number_format($v['Nue']['precalcul']['nbr_part'], 5, ',', ' ') ?></td>
			<td class="2 tar"><?= number_format($v['Nue']['precalcul']['ventePotentielle'], 2, ',', ' ') ?></td>
		</tr><?php
	}
}
$b = ob_get_contents();
ob_get_clean();

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
#graph p
{
	margin: 0;
	padding: 0;
}
#graph img {
	padding-left: 40px;
}
</style>

<page backimg="<?= dirname(__FILE__) ?>/img/MS-watermark.png" backtop="28mm" backbottom="85mm" footer="page">
	<page_header>
		<img width="194" src="<?= dirname(__FILE__) . "/img/MS-Logo-RVB.png" ?>">
	</page_header>
	<page_footer>
	<img src="<?= dirname(__FILE__) ?>/img/bandeau-moncompte.jpg" alt="" width="750" height="206" />
	<p style="font-size:9px">Nom : MeilleureSCPI.com - Siège social : 4, rue de la Michodière - 75002 Paris - Forme juridique : S.A.S. au capital de 10 000 € - Siret 532 567 583 0010 RCS de Paris - NAF/APE : 7022Z - Site internet : <a href="http://www.meilleurescpi.com">MeilleureSCPI.com</a> Conformément aux dispositions de l'article 325-12-1 du règlement de l’AMF, MeilleureSCPI.com a établi une procédure efficace et transparente en vue du traitement raisonnable et rapide des réclamations que lui adressent ses clients existants ou potentiels. Vous pouvez adresser vos réclamations par voie postale : à l’adresse suivante : MeilleureSCPI.com - Service Clients / Gestion des réclamations - 4, rue de la Michodière - 75002 Paris - par email : <a href="mailto:reclamation@meilleurescpi.com">reclamation@meilleurescpi.com</a> - par téléphone : 01 82 28 90 28 et en remplissant le formulaire de réclamation téléchargeable sur notre site internet. Votre Conseiller s’engage à traiter votre réclamation dans les délais suivants :
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
	</page_footer>
	<p style="text-align: center">
		<br>
		<h4>Situation de votre portefeuille SCPI au <?= $this->date->format('d/m/Y') ?></h4>
	</p>
	<table border="1" bordercolor="#D8D8D8" cellpadding="0" cellspacing="0">
		<thead>
			<tr>
				<th class="4 tac">SCPI</th>
				<th class="2 tac">Type de propriété</th>
				<th class="2 tac">Nombre de parts</th>
				<th class="2 tac">Valorisation (*)</th>
			</tr>
		</thead>
		<tbody>
		<?=$b?>
			<tr>
				<td colspan="2"></td>
				<td class="tar bg"><strong>Total (&euro;)&nbsp;&nbsp;</strong></td>
				<td class="tar bg"><strong><?= number_format($this->data['precalcul']['ventePotentielle'], 2, ',', ' ') ?></strong></td>
			</tr>
		</tbody>
	</table>
	<span class="protips">* Il s'agit du montant estimé potentiel de revente (dernière valeur de revente connue). Pour toute demande, merci de nous contacter : contact@meilleurescpi.com.</span><br/>
	<span class="protips">Ce document est non contractuel et concerne l'ensemble des transactions saisies sur MeilleureSCPI.com.</span><br/>
	<span class="protips">Pour tout document officiel, merci de vous rapprocher de la société de gestion ou de votre conseiller MeilleureSCPI.com qui pourra vous indiquer les démarches à effectuer. Ce document n'est pas valable pour la déclaration ISF.</span>
<?php if (!is_null($this->graph)) : ?>
	<div id="graph">
		<p style="text-align: center;">
			<img width="615" height="500" src="data:image/png;base64,<?= $this->graph ?>">
		</p>
		<p>
			<br/><span class="protips">1. Il s'agit de la part que représente chacune de vos SCPI en fonction de la valeur de revente estimée.</span>
			<br/><span class="protips">2. Il s'agit des dividendes bruts pour l'ensemble des parts détenues en pleine propriété et entrées en jouissance.</span>
			<br/><span class="protips">3. Il s'agit du taux d'occupation moyen de votre portefeuille de SCPI (à la fin du <?= $this->dateDividende ?>). Cette moyenne est pondérée en fonction de la répartition de chaque SCPI dans votre portefeuille.</span>
			<br/><span class="protips">4. Il s'agit de la répartition géographique de votre portefeuille SCPI global en fonction des dernières informations communiquées par les sociétés de gestion (pondérée en fonction de la valeur de vente potentielle de chaque ligne de SCPI que vous détenez).</span>
			<br/><span class="protips">5. Il s'agit de la répartition de votre portefeuille par catégorie de SCPI. La répartition de votre portefeuille étant calculée par rapport à la dernière valeur connue de vente par part potentielle.</span>
			<br/><span class="protips">Pour toute question merci de nous contacter.</span>
		</p>
	</div>
<?php endif ; ?>
</page>
<?php
$c = ob_get_contents();
ob_get_clean();
//echo $c;
$h2p = new HTML2PDF('P', 'A4', 'fr');
$h2p->pdf->addFont('futurastd','', dirname(__FILE__) . '/font/futurastd.php');
$h2p->pdf->addFont('futurastd','B', dirname(__FILE__) . '/font/futurastdbold.php');
$h2p->pdf->addFont('futurastd','I', dirname(__FILE__) . '/font/futurastdoblique.php');
$h2p->pdf->SetDisplayMode('fullpage');
$h2p->SetDefaultFont('futurastd');
$h2p->WriteHTML($c);
$h2p->Output('Patrimoine_'.$this->dh->getShortName().'.pdf', 'I');
