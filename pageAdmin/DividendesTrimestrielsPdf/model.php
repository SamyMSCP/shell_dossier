<?php
if (!isset($GLOBALS['GET']['client'])) {
	Notif::set("errorGeneratePdfDividendes", "La requete est mal formatée !");
	header("Location: ?p=Accueil");
	exit();
}

$this->client = Dh::getById(intval($GLOBALS['GET']['client']));

$data = $this->client->getCacheArrayTable();
ksort($data, SORT_STRING);

ob_start();
include("htmlContent.php");
$html = ob_get_contents();
ob_end_clean();
header('Content-disposition: attachment;filename=Dividendes_' . date('d_m_Y') . "_" . str_replace([" ", "."], "_",$this->client->getShortName()) . '.pdf;Content-type:application/pdf');
echo PdfGenerator::createStandardDocument($html)->Output('', "s");
exit();
//PdfGenerator::createStandardDocument($html)->Output('pdfdeTest.pdf', 'I');
