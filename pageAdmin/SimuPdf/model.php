<?php



extract($_GET);

ob_start();
include("htmlContent.php");
$html = ob_get_contents();
ob_end_clean();
header('Content-disposition: attachment;filename=Simulateur_Usufruit.pdf;Content-type:application/pdf');
echo PdfGenerator::createStandardDocument_Without_Bdd($html)->Output('', "s");
exit();