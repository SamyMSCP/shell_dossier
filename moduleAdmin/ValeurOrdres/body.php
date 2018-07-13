<?php
//var_dump($scpi);


$date_table = "31/12/2016";//DATE AFFICHEE DANS LE TABLEAU


$i = 0;

$scpi = intval($_GET['scpi']);
if (!isset($scpi)) {
	header("HTTP/1.0 404 Not Found");
	die();
}

/* ************************************************************************** */

$img = OrderScrapList::getImage($scpi);
$img_a = $img[0]->img_a;
$img_v = $img[0]->img_v;

ob_start();
//SERVER_NAME is for get the current HostName. 'cause can't get the img without this.
?>
	<img class="img-tab" src="data:image/png;base64,<?= $img_a ?>"/>
<?php
$b = ob_get_contents();
ob_get_clean();

ob_start();
?>
	<img class="img-tab" src="data:image/png;base64,<?= $img_v ?>"/>
<?php
$vente = ob_get_contents();
ob_get_clean();

$date_du_jour = new DateTime();

$scpi_obj = Scpi::getFromId($GLOBALS['GET']['scpi']);
$scpi = $scpi_obj->getName();

//Calcul des acomptes
$date = intval(date("Y"));
$ac = $scpi_obj->getAcompteYear($date);
$val = 0.0;
$i = 1;

foreach ($ac as $key => $tmp) {
	$val += $tmp + $scpi_obj->getAcompteExYearT($date, $key);
	$val += $scpi_obj->getAcompteExYearT($date, $i);
	$i++;
}
if (count($ac) < 4) {
	$len = 4 - count($ac);
	$new_ac = $scpi_obj->getAcompteYear($date - 1);
	while ($len > 0) {
		$len--;
		$val += $new_ac['T' . (4 - $len)];
		$val += $scpi_obj->getAcompteExYearT($date - 1, $len);
	}

}

$prix_net_vendeur = floatval($GLOBALS['GET']['price']);
if ($prix_net_vendeur <= 0.00)
	$prix_net_vendeur = 1.00;
$droit_enregistrement = 5.00;
$com = $scpi_obj->FraisSecondaires;

$prix_aquereur = $prix_net_vendeur * (1.0 + ($com + $droit_enregistrement) / 100.0);
//$prix_aquereur = 574.08;
$tdvm = 5.44;
$tdvm = ($val / $prix_aquereur) * 100;
$quote = (($prix_aquereur / $scpi_obj->getValeurReconstitution()) - 1.0) * 100;
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

		.protips {
			font-size: 12px;
			font-weight: 400;
			color: #000000;
			font-style: italic
		}

		#advert {
			font-weight: 300;
			padding: 2mm;
			color: black;
		}

		.tac {
			text-align: center;
		}

		.tar {
			text-align: right;
		}

		.tal {
			text-align: left;
		}

		.5
		{
			width: 50%
		;
		}

		.4
		{
			width: 40%
		;
		}
		.3
		{
			width: 30%
		;
		}

		.2
		{
			width: 20%
		;
		}

		.1
		{
			width: 10%
		;
		}
		.img-tab {
			width: 100%;
		}

		.imp {
			background-color: #01528a;
		}

		.dk-bg {
			background-color: #d0d0d0;
		}

		h2 {
			text-decoration: underline;
		}

		.info-container {
			width: auto;
			position: relative;
			left: 5%;
			right: 5%;
		}

		.protips-title {
			text-decoration: underline;
		}
	</style>
	<page backimg="module/ValeurOrdres/img/MS-watermark.png" backtop="30mm" backbottom="85mm" footer="page">
		<page_header>
			<img width="194" src="module/ValeurOrdres/img/MS-Logo-RVB.png">
		</page_header>
		<page_footer>
			<img src="module/ValeurOrdres/img/Bandeau-Moncompte.jpg" alt="" width="750"/>
			<p style="font-size:9px">Nom : MeilleureSCPI.com - Siège social : 4, rue de la Michodière - 75002 Paris -
				Forme juridique : S.A.S. au capital de 10 000 € - Siret 532 567 583 0010 RCS de Paris - NAF/APE : 7022Z
				- Site internet : <a href="http://www.meilleurescpi.com">MeilleureSCPI.com</a> Conformément aux
				dispositions de l'article 325-12-1 du règlement de l’AMF, MeilleureSCPI.com a établi une procédure
				efficace et transparente en vue du traitement raisonnable et rapide des réclamations que lui adressent
				ses clients existants ou potentiels. Vous pouvez adresser vos réclamations par voie postale : à
				l’adresse suivante : MeilleureSCPI.com - Service Clients / Gestion des réclamations - 4, rue de la
				Michodière - 75002 Paris - par email : <a href="mailto:reclamation@meilleurescpi.com">reclamation@meilleurescpi.com</a>
				- par téléphone : 01 82 28 90 28 et en remplissant le formulaire de réclamation (en cliquant sur ce <a
						href="https://fr.slideshare.net/secret/IxSPbzQVQ2T5os">lien</a>) Votre Conseiller s’engage à
				traiter votre réclamation dans les délais suivants :
				- dix jours ouvrables maximum à compter de la réception de la réclamation, pour accuser réception, sauf
				si la réponse elle-même est apportée au client dans ce délai ;
				- deux mois maximum entre la date de réception de la réclamation et la date d’envoi de la réponse au
				client sauf survenance de circonstances particulières dûment justifiées. Le réclamant peut notamment
				s’adresser à : L’ACPR, L’AMF, L’ANACOFI.

				MeilleureSCPI.com est inscrit à l’ORIAS sous le numéro d’immatriculation 13000814 (<a
						href="http://www.orias.fr">www.orias.fr</a>) au titre des activités réglementées suivantes :
				- Conseiller en investissement financier (CIF) enregistré auprès de l’ANACOFI-CIF, association agréée
				par l’Autorité des Marchés Financiers (AMF)
				- Courtier d'assurance ou de réassurance (COA) positionné dans la catégorie b Art. L520-1 II 1° du Code
				des assurances ;
				- Mandataire d’intermédiaire d’assurance (MIA)
				- Mandataire non exclusif en opérations de banque et en services de paiement (MOBSP)
				La société ne peut recevoir aucun fonds, effets ou valeurs.
				MeilleureSCPI.com dispose, conformément à la loi et au code de bonne conduite de l’ANACOFI-CIF, d’une
				couverture en Responsabilité Civile Professionnelle suffisante couvrant ses diverses activités.
			</p>
		</page_footer>
		<p style="text-align: center;margin-top:0;padding-top:0;">
		<h4>March&eacute; des parts de la <?= $scpi ?> au <?= date('d/m/Y H:i') ?></h4>
		</p>
		<table border="1" bordercolor="#D8D8D8" cellpadding="0" cellspacing="0">
			<tbody>
			<tr>
				<td class="5">
					<?= $b ?>
				</td>
				<td class="5">
					<?= $vente ?>
				</td>
			</tr>
			</tbody>
		</table>
		<br/>
		<table width="100%">
			<tbody>
			<tr>
				<td class="1"></td>
				<td class="tac 4">Commission de cession (TTC)</td>
				<td class="tal 1"><?= number_format($com, 2, ",", "") ?>%</td>
				<td class="2">Droit d'enregistrement</td>
				<td class="1 tac dk-bg"><?= number_format($droit_enregistrement, 2, ",", "") ?>%</td>
				<td class="1"></td>
			</tr>
			</tbody>
		</table>
		<br/>
		<p>
			Les éléments inclus dans ce document reposent sur des informations obtenues par MeilleureSCPI.com auprès des
			sociétés de gestion et d'autres sources que MeilleureSCPI.com considère comme raisonnablement fiables.
			MeilleureSCPI.com ne saurait être tenu pour responsable de toute erreur, ni ne garantit l'exactitude de ces
			informations, fournies à titre indicatif.
		</p>
		<p>
			En l'&eacute;tat actuel du march&eacute;, si vous souhaitez vous positionner sur le march&eacute;
			secondaire:<br/><br/>
		<div class="tac info-container">
			<table border="1">
				<tbody class="tac">
				<tr>
					<td class="">Prix conseill&eacute; net vendeur:</td>
					<td class="2 dk-bg"><?= number_format($prix_net_vendeur, 2, ",", " "); ?> &euro;</td>
					<td class="">
						Prix conseill&eacute; Acqu&eacute;reur: <br>
						<small>(Tout Frais Compris)</small>
					</td>
					<td class="2"><?= number_format($prix_aquereur, 2, ",", " "); ?> &euro;</td>
				</tr>
				<tr>
					<td>Valeur reconstitution au <?= $date_table ?>**</td>
					<td class="dk-bg"><?= number_format($scpi_obj->getValeurReconstitution(), 2, ",", " ") ?>&euro;
					</td>
					<td>TDVM***</td>
					<td class="dk-bg"><?= number_format($tdvm, 2, ",", ""); ?>%</td>
				</tr>
				<tr>
					<td>Valeur de r&eacute;alisation au <?= $date_table ?>**</td>
					<td class="dk-bg"><?= number_format($scpi_obj->getValeurRealisation(), 2, ",", " ") ?> &euro;</td>
					<td>4 derniers acomptes</td>
					<td class="dk-bg"><?= number_format($val, 2, ",", " ") ?></td>
				</tr>
				<tr>
					<td>D&eacute;cote ou Surcote****</td>
					<td><?= number_format($quote, 2, ",", "") ?>%</td>

				</tr>
				</tbody>
			</table>
		</div>
		</p>

		<span class="protips">*NR: Non Renseign&eacute;</span><br/>
		<span class="protips">**<span class="protips-title">La valeur de r&eacute;alisation</span> repr&eacute;sente la valeur v&eacute;nale des immeubles (hors droits), d'apr&egrave;s les expertises immobili&egrave;res, ajout&eacute;e &agrave; celle des autres actifs de la soci&eacute;t&eacute; (tr&eacute;sorerie, placement financiers).</span><br/>
		<span class="protips"><span class="protips-title">La valeur de reconstitution</span> repr&eacute;sente la valeur de r&eacute;alisation augment&eacute;e du montant des frais estim&eacute;s n&eacute;c&eacute;ssaires pour reconstituer le patrimoine.</span><br/>
		<span class="protips">***TDVM est le taux de distribution de valeur de march&eacute;. Nous avons pris le dernier dividende connu ou le dividende pr&eacute;visionnel que nous avons divis&eacute; par le prix acqu&eacute;reur conseill&eacute;.</span><br/>
		<span class="protips">****D&eacute;cote ou surcote calculer en divisant le prix acqu&eacute;reur par la valeur de reconstitution si le r&eacute;sultat est n&eacute;gatif il y a une d&eacute;cote du pourcentage indiqu&eacute; sinon une surcote.</span>
	</page>
<?php
$c = ob_get_contents();
ob_get_clean();
$h2p = new HTML2PDF('P', 'A4', 'fr');
$h2p->pdf->addFont('futurastd', '', dirname(__FILE__) . '/font/futurastd.php');
$h2p->pdf->addFont('futurastd', 'B', dirname(__FILE__) . '/font/futurastdbold.php');
$h2p->pdf->addFont('futurastd', 'I', dirname(__FILE__) . '/font/futurastdoblique.php');
$h2p->pdf->SetDisplayMode('fullpage');
$h2p->SetDefaultFont('futurastd');
$h2p->WriteHTML($c);
$h2p->Output('Carnet_Ordre_' . $scpi . '_' . date('Y') . '.pdf', 'I');
