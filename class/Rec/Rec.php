<?php
class Rec {
	public  		$projet;
	public			$beneficiaire ;
	public			$situationJuridique;
	public			$Pps;
	public			$situationFinanciere;
	public			$situationFiscale;
	public			$situationPatrimoniale;
	public			$htmlStr = null;
	public			$pdfStr = null;
	public			$h2p = null;
	public			$transactions  = null;
	public			$pTrans  = null;
	public			$totalInvestissement = null;
	public			$objectifs = null;
	public			$objectifs_list = null;

	public function __construct(Projet $projet = null) {

		$this->projet = $projet;

		if (
			$this->projet->getObjectifsList1() == 0 ||
			$this->projet->getObjectifsList2() == 0 ||
			$this->projet->getObjectifsList3() == 0
		)
			return (0);

		$this->beneficiaire = $this->projet->getBeneficiairesEntity();
		$this->objectifs = $this->projet->getObjectifs();
		$this->Pps  = $this->beneficiaire->getPersonnePhysique();
		//$this->Pps[] = $this->Pps[0];
		$this->dh = $this->Pps[0]->getDh();
		$this->conseiller = $this->dh->getConseiller();
		$this->lm = $this->dh->getLastLm();
		if ($this->lm == null)
			return (0);
		$this->fil = $this->dh->getFilValidation();
		if ($this->fil == null)
			return (0);
		$this->situationJuridique = $this->Pps[0]->getLastSituationJuridique();
		$this->situationFinanciere = $this->Pps[0]->getLastSituationFinanciere();
		$this->situationFiscale = $this->Pps[0]->getLastSituationFiscale();
		$this->situationPatrimoniale = $this->Pps[0]->getLastSituationPatrimoniale();
		$this->pTrans = $this->prepareTransactions();
		$this->objectifs_list = [];
		$this->objectifs_list[] = $this->projet->getObjectifsList1Array();
		$this->objectifs_list[] = $this->projet->getObjectifsList2Array();
		$this->objectifs_list[] = $this->projet->getObjectifsList3Array();
	}

	private function prepareTransactions() {
		if ($this->transactions == null)
			$this->transactions = $this->projet->getTransaction();
		$rt = [];
		$this->totalInvestissement = 0;
		foreach ($this->transactions as $key => $trans)
		{
			$this->totalInvestissement += $trans->getMontanInvestissement();
			$typePro = "PP";
			if ($trans->isNuePro())
				$typePro = "NP";
			else if ($trans->isUsufruit())
				$typePro = "US";
			$newKey = $trans->getScpiId() . "_" . $typePro;
			if (!isset($rt[$newKey]))
			{
				$rt[$newKey] = [];
				$rt[$newKey]["typePro"] = $typePro;
				$rt[$newKey]["nbr_part"] = 0;
				$rt[$newKey]["MontantInvestissement"] = 0;
				$rt[$newKey]["scpi"] = $trans->getScpi();
				$rt[$newKey]["cleRepartition"] = $trans->getClefRepartition();
			}
			$rt[$newKey][] = $trans;
			$rt[$newKey]["nbr_part"] += $trans->getNbrPart();
			$rt[$newKey]["MontantInvestissement"] += $trans->getMontanInvestissement();
		}
		return (array_chunk($rt, 5, true));
	}
	public function generateHtml() {
		ob_start();
		include("RecHtml.php");
		$this->htmlStr = ob_get_contents();
		ob_end_clean();
	}
	public function getHtml() {
		if ($this->htmlStr == null)
			$this->generateHtml();
		return ($this->htmlStr);
	}
	public function generatePdf() {
		if ($this->htmlStr == null)
			$this->generateHtml();
		$this->h2p = new HTML2PDF('P', 'A4', 'fr');
		$this->h2p->WriteHTML($this->htmlStr);
		//echo $this->h2p->pdf->getNumPages(); exit();
		$this->pdfStr = $this->h2p->Output('REC.pdf', 'S');
	}
	public function printPdf() {
		if ($this->htmlStr == null)
			$this->generateHtml();
		$this->h2p = new HTML2PDF('P', 'A4', 'fr');
		$this->h2p->WriteHTML($this->htmlStr);
		$this->pdfStr = $this->h2p->Output();
	}
	public function getPdf() {
		if ($this->pdfStr == null)
			$this->generatePdf();
		return ($this->pdfStr);
	}

}
