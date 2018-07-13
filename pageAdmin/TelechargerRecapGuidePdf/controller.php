<?php
require_once("class/core/PageAdmin.php");
class TelechargerRecapGuidePdf extends PageAdmin
{

	public function printDocuments($data) {
		header("Content-Type: text/csv");
		echo "Donneur d'ordre,Date,Document\n";
		foreach ($data as $key => $elm) {
			$date = $elm->getDate()->format("d/m/Y");
			$donneurDOrdre = $elm->getClient()->getShortName();
			$doc  = $elm->getParams()['Document'];
			echo "$donneurDOrdre,$date,$doc\n";
		}
	}

	/*
		42 | Visualisation guide
		43 | Visualisation PDF
	*/

	public function printGuides() {
		header("Content-Disposition: attachment; filename=export_logs_guides.csv");
		$data = Logger::getByTypeId(42);
		$this->printDocuments($data);
	}

	public function printPdf() {
		header("Content-Disposition: attachment; filename=export_logs_pdf.csv");
		$data = Logger::getByTypeId(43);
		$this->printDocuments($data);
	}
}
