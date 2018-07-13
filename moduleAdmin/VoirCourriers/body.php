<?php
//var_dump($scpi);

ob_start();

$c = $GLOBALS['GET']['c'];

$ville= $GLOBALS['GET']['ville'];
$zip= $GLOBALS['GET']['zip'];
$numeroRue= $GLOBALS['GET']['numeroRue'];
$nomDeLaVoie = $GLOBALS['GET']['nomDeLaVoie'];
$nameGestion = $GLOBALS['GET']['nameGestion'];
$nomFamille = $GLOBALS['GET']['nomFamille'];
$prenom = $GLOBALS['GET']['prenom'];
$courrier = Database::getNoClass('mscpi_db', "SELECT * FROM `communication_template` WHERE `id` = :cur", ["cur" => $c ])[0];
$content = $courrier['content'];

$civilite = $this->contact.' '.$prenom.' '.$nomFamille;

$arg = [
	"scpi" => $this->scpi->name,
	"shortname" => $this->contact.' '.$nomFamille,
	"email" => "andrea.pouillot@meilleurescpi.com",
	"tel" => "01 84 25 52 15",
	"conseiller" => "Andrea POUILLOT",
	"client" => $this->sname
];
//$addr = $GLOBALS['GET']['addresse'];
//$addr = preg_replace('/\!@\!/',"<br>", $addr);



$content = preg_replace("/%scpi%/", $arg['scpi'], $content);
$content = preg_replace("/%email%/", $arg['email'], $content);
$content = preg_replace("/%shortname%/", $arg['shortname'], $content);
$content = preg_replace("/%tel%/", $arg['tel'], $content);
$content = preg_replace("/%conseiller%/", $arg['conseiller'], $content);
$content = preg_replace("/%client%/", $arg['client'], $content);

$content = preg_replace("/##SHORT_NAME##/", $arg['shortname'], $content);
// Print the entire match result
//var_dump($matches[0][1]);
$re = '/##OBJ##(.*)##END##/';

preg_match_all($re, $content, $matches, PREG_SET_ORDER, 0);
if (isset($matches[0]) && $matches[0][1])
	$obj = $matches[0][1];
else
	$obj = "";

$content = preg_replace($re,'', $content);
//dbg($content);
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

		.address {
			text-align: left;
			position: absolute;
			right: 60px;
			top: 150px;
		}

		.content {
			text-align: left;
			position: relative;
			top: 110px;
			margin: 20px;
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
			<div class="address">
            <?php if ($nameGestion != "null") {
                echo strtoupper($nameGestion);
            }?>
            <br>Service Souscription<br>

            <?php if ($civilite != "null") {
                echo  $civilite.'<br>';
            }?>

            <?php if ($numeroRue != "null") {
                echo $numeroRue.'';
            }?>

            <?php if ($nomDeLaVoie != "null") {
                echo $nomDeLaVoie.'<br>';
            }?>
             <?php if ($zip != "null") {
            echo $zip.'';
            }?>
            <?php if ($ville != "null") {
                echo strtoupper($ville);
            } ?>

			<br><br>
				Paris, le <?= date('d/m/Y')?>
			</div>
			<p class="content">
				<?php if ($obj != "") { ?>
				<p class="object">
					<b>Object:</b> <?=$obj?>
				</p>
				<?php } ?>
					<?= $content ?>
			</p>
		</p>
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
try {
	$h2p->Output('Courrier_' . date('Y') . '.pdf', 'I');
}
catch (Exception $e) {
	echo $e;
}
