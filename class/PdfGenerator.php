<?php
include("class/lib/fpdf181/fpdf.php");
include("class/lib/FPDI-1.6.1/fpdi.php");

class PdfGenerator
{
	public					$pdf;
	private					$font = 'Arial';
	private					$fontSize = 9;
	private					$currentPage = 1;
	private					$filename = "noname.pdf";
	private					$color = array(
		"red" => 0,
		"green" => 0,
		"blue" => 0
	);
	public function write($str, $x, $y)
	{
		$this->pdf->SetFontSize($this->fontSize);
		$this->pdf->SetTextColor(
				$this->color['red'],
				$this->color['green'],
				$this->color['blue']
		);
		$this->pdf->SetXY($x, $y);
		$this->pdf->Write(0, $str);
	}
	public function __construct($filename)
	{
//		header("content-type: " . $doc['content-type']);
		$this->pdf = new FPDI();

		//$this->pdf->setSourceFile("documents/LM_PP.pdf");
		$this->pdf->setSourceFile($filename);
	}
	public function getBuffer() {
		return $this->pdf->Output('', "s");
	}
	public function Output()
	{
		$this->pdf->Output();
	}
	public function getLm()
	{
		$rt = array (
			"content-type" => "application/pdf",
			"data" => $this->getBuffer(),
			"name" => $this->filename,
			"id_type" => 4,
			"type_name" => TypeDocument::getFromId(4)[0]->getName(),
		);
		return ($rt);
	}
	public function nextPage() {
		$p = $this->pdf->importPage($this->currentPage, '/MediaBox');
		$this->pdf->addPage();
		$this->pdf->useTemplate($p);
		$this->currentPage++;
	}
	public static function getNewLMFromDh($dh,  $duree)
	{
		$Pp = $dh->getPersonnePhysique();
		return (self::getNewLM(
			$Pp->getCivilite(),
			$Pp->getName(),
			$Pp->getFirstName(),
			$Pp->getPhone(),
			$Pp->getMail(),
			$duree
			));
	}
	public static function getNewLMFromDh2($dh,  $duree)
	{
		$Pp = $dh->getPersonnePhysique();
		return (self::getNewLM2(
			$Pp->getCivilite(),
			$Pp->getName(),
			$Pp->getFirstName(),
			$Pp->getPhone(),
			$Pp->getMail(),
			$duree
			));
	}
	public static function getNewLM2($civilite, $lastname, $firstname, $phone, $mail, $duree) 
	{
		$rt = new PdfGenerator('documents/LM_PP_New.pdf');
		$rt->filename = mb_strtolower($civilite . $firstname. $lastname . "_" . time() . ".pdf");
		$rt->nextPage();

		$rt->write($lastname, 20, 155.5);
		$rt->write($firstname, 60, 155.5);
		$rt->write($phone, 20, 166);
		$rt->write($mail, 60, 166);

		if ($civilite == "Monsieur")
			$rt->write("X", 37, 146);
		else
			$rt->write("X", 51, 146);

		if ($duree >= 1)
			$rt->write("X", 53.3, 183);
		else
			$rt->write("X", 20.3, 183);
		$rt->nextPage();
		$rt->nextPage();
		return ($rt);
	}
	public static function getNewLM($civilite, $lastname, $firstname, $phone, $mail, $duree)
	{
		$rt = new PdfGenerator('documents/LM_PP.pdf');
		$rt->filename = mb_strtolower($civilite . $firstname. $lastname);
		$rt->nextPage();
		$rt->write($lastname, 16, 217);
		$rt->write($firstname, 58, 217);
		$rt->write($phone, 16, 227);
		$rt->write($mail, 58, 227);
		if ($civilite == "Monsieur")
			$rt->write("X", 34, 205.7);
		else
			$rt->write("X", 46.5, 205.7);
		if ($duree == 1)
			$rt->write("X", 50.2, 249.1);
		else
			$rt->write("X", 16.5, 249.1);
		$rt->nextPage();
		return ($rt);
	}
	public static function createStandardDocument($content) {
		$h2p = new HTML2PDF('P', 'A4', 'fr');
		$h2p->pdf->addFont('futurastd','', dirname(__FILE__) . '/font/futurastd.php');
		$h2p->pdf->addFont('futurastd','B', dirname(__FILE__) . '/font/futurastdbold.php');
		$h2p->pdf->addFont('futurastd','I', dirname(__FILE__) . '/font/futurastdoblique.php');
		$h2p->pdf->SetDisplayMode('fullpage');
		$h2p->SetDefaultFont('futurastd');
		$h2p->WriteHTML(self::_getStandardDocumentHtml($content));
		return ($h2p);
	}
	private static function _getStandardDocumentHtml($content) {
		ob_start();
		?>
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
				width: 100%;
				margin: 0 auto;
				border: 1px solid lightgray;
				border-collapse: collapse;
			}
			th {
				height: 8mm;
				text-align:center;
			}
			th, .bg {
				background: lightgray;
			}
			td {
				height: 4mm;
				text-align:center;
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
			table.s2 th, table.s2 td { width: 50%; }
			table.s3 th, table.s3 td { width: 32%; }
			table.s4 th, table.s4 td { width: 25%; }
			table.s5 th, table.s5 td { width: 20%; }
			table.s6 th, table.s6 td { width: 15%; }
		</style>
		<page backimg="<?= dirname(__FILE__) ?>/pdfRessources/img/MS-watermark.png" backtop="30mm" backbottom="85mm" footer="page">
			<page_header>
				<img width="194" src="<?= dirname(__FILE__) . "/pdfRessources/img/MS-Logo-RVB.png" ?>">
			</page_header>
			<page_footer>
				<img src="<?= dirname(__FILE__) ?>/pdfRessources/img/Bandeau-Moncompte.jpg" alt="" width="750" />
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
				</p>
			</page_footer>
			<p style="text-align: center;margin-top:0;padding-top:0;">
				<span class="protips" style="margin-left:120mm;font-size:14px;">Le <?= date_fr(date("d F Y")) ?>,</span><br>
				<span class="protips" style="margin-left: 120mm">Pour <?= (Dh::getById(intval($GLOBALS['GET']['client'])))->getShortName()?></span>
			</p>
			<?=$content?>
		</page>
		<?php
		$rt = ob_get_contents();
		ob_end_clean();
		return ($rt);
	}


    public static function createStandardDocument_Without_Bdd($content) {
        $h2p = new HTML2PDF('P', 'A4', 'fr');
        $h2p->pdf->addFont('futurastd','', dirname(__FILE__) . '/font/futurastd.php');
        $h2p->pdf->addFont('futurastd','B', dirname(__FILE__) . '/font/futurastdbold.php');
        $h2p->pdf->addFont('futurastd','I', dirname(__FILE__) . '/font/futurastdoblique.php');
        $h2p->pdf->SetDisplayMode('fullpage');
        $h2p->SetDefaultFont('futurastd');
        $h2p->WriteHTML(self::_getStandardDocumentHtml_Without_Bdd($content));
        return ($h2p);
    }

    private static function _getStandardDocumentHtml_Without_Bdd($content) {
        ob_start();
        ?>
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
            h5{
                font-size: 9px;
                font-weight: normal;
                overflow-wrap: break-word;

            }
            p {
                margin: 5px 0px;
                padding: 0px 0px;
                font-size: 12px;
            }
            table {
                width: 100%;
                margin: 0 auto;
                border-width:1px;
                border-style:solid;
                border-color:lightgray;
            }
            tr{
                height: 5px;
            }

            th {

                height: 2mm;
                text-align:center;
            }
            th, .bg {
                background: lightgray;
            }
            td {
                font-size: 12px;
                height: 2mm;
                text-align:center;
                overflow:auto;

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
            table.s2 th, table.s2 td { width: 50%; }
            table.s3 th, table.s3 td { width: 32%; }
            table.s4 th, table.s4 td { width: 25%; }
            table.s5 th, table.s5 td { width: 20%; }
            table.s6 th, table.s6 td { width: 15%; }
            table.s9 th, table.s9 td { width: 10%; }
            .aligner-droite{
                text-align: right;
            }
            .bloc{
                text-overflow: ellipsis;
                word-wrap: break-word;
            }



        </style>
        <page backimg="<?= dirname(__FILE__) ?>/pdfRessources/img/MS-watermark.png" backtop="30mm" backbottom="85mm" footer="page">
            <?=$content?>
        </page>
        <?php
        $rt = ob_get_contents();
        ob_end_clean();
        return ($rt);
    }
}
