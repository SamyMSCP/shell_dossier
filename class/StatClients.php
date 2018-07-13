<?php
require_once("core/Cache.php");

class StatClients
{
	use Cache;

	public				$nbrCompteCreeFront = 0;
    public				$nbrCompteCreeApi = 0;
    public				$nbrCompteCreeFacebook = 0;
    public				$nbrCompteCreeTwitter = 0;
    public				$nbrCompteCreeImportationCsv = 0;
    public				$nbrCompteCreeLinxo = 0;
    public				$nbrCompteCreeMailChimp = 0;
    public				$nbrCompteCreeLinkedin= 0;

	public				$nbrFront = 0;
	public				$valorisationFront = 0;
	public				$valorisationMoyenneFront = 0;
	public				$valorisationMscpiFront = 0;
	public				$valorisationMscpiMoyenneFront = 0;
	public				$valorisationOtherFront = 0;
	public				$valorisationOtherMoyenneFront = 0;


	public				$nbrClients = 0;
	public				$nbrClientsMscpi = 0;
	public				$nbrClientsOther = 0;
	public				$nbrClientsNoVal = 0;
	public				$nbrClientsNoMail = 0;
	public				$nbrClientsNoPhone = 0;
	public				$nbrClientsProspect = 0;

	public				$valorisationClients = 0;
	public				$valorisationClientsMscpi = 0;
	public				$valorisationClientsOther = 0;
	public				$valorisationClientsNoVal  = 0;
	public				$valorisationClientsNoMail  = 0;
	public				$valorisationClientsNoPhone  = 0;
	public				$valorisationClientsProspect  = 0;

	public				$valorisationMoyenneClients = 0;
	public				$valorisationMoyenneClientsMscpi = 0;
	public				$valorisationMoyenneClientsOther = 0;
	public				$valorisationMoyenneClientsNoVal = 0;
	public				$valorisationMoyenneClientsNoMail = 0;
	public				$valorisationMoyenneClientsNoPhone = 0;
	public				$valorisationMoyenneClientsProspect = 0;

	public				$valorisationMscpiClients = 0;
	public				$valorisationMscpiClientsMscpi = 0;
	public				$valorisationMscpiClientsOther = 0;
	public				$valorisationMscpiClientsNoVal = 0;
	public				$valorisationMscpiClientsNoMail = 0;
	public				$valorisationMscpiClientsNoPhone = 0;
	public				$valorisationMscpiClientsProspect = 0;

	public				$valorisationMscpiMoyenneClients = 0;
	public				$valorisationMscpiMoyenneClientsMscpi = 0;
	public				$valorisationMscpiMoyenneClientsOther = 0;
	public				$valorisationMscpiMoyenneClientsNoVal = 0;
	public				$valorisationMscpiMoyenneClientsNoMail = 0;
	public				$valorisationMscpiMoyenneClientsNoPhone = 0;
	public				$valorisationMscpiMoyenneClientsProspect = 0;

	public				$valorisationOtherClients = 0;
	public				$valorisationOtherClientsMscpi = 0;
	public				$valorisationOtherClientsOther = 0;
	public				$valorisationOtherClientsNoVal = 0;
	public				$valorisationOtherClientsNoMail = 0;
	public				$valorisationOtherClientsNoPhone = 0;
	public				$valorisationOtherClientsProspect = 0;

	public				$valorisationOtherMoyenneClients = 0;
	public				$valorisationOtherMoyenneClientsMscpi = 0;
	public				$valorisationOtherMoyenneClientsOther = 0;
	public				$valorisationOtherMoyenneClientsNoVal = 0;
	public				$valorisationOtherMoyenneClientsNoMail = 0;
	public				$valorisationOtherMoyenneClientsNoPhone = 0;
	public				$valorisationOtherMoyenneClientsProspect = 0;

	public              $nbrApiAccesValeurPierre = 0;

    public static		$staticDataCacheStats = null;

	public static function generateCacheStats() {
		$rt = new StatClients();
		$dh = Dh::getAll();
		foreach ($dh as $key => $elm)
		{
			$dhCache = $elm->getCacheArrayTable();
			if ($elm->getType() == "client")
			{
				$rt->nbrClientsMscpi++;
				$rt->valorisationClientsMscpi += $dhCache['precalcul']['ventePotentielle'];
				$rt->valorisationMscpiClientsMscpi += $dhCache['precalcul']['ventePotentielleMscpi'];
				$rt->valorisationOtherClientsMscpi += $dhCache['precalcul']['ventePotentielleOther'];
			}
			else if ($elm->getType() == "" && $elm->isValide())
			{
				$rt->nbrClientsOther++;
				$rt->valorisationClientsOther += $dhCache['precalcul']['ventePotentielle'];
				$rt->valorisationMscpiClientsOther += $dhCache['precalcul']['ventePotentielleMscpi'];
				$rt->valorisationOtherClientsOther += $dhCache['precalcul']['ventePotentielleOther'];

				$rt->nbrClientsProspect++;
				$rt->valorisationClientsProspect += $dhCache['precalcul']['ventePotentielle'];
				$rt->valorisationMscpiClientsProspect += $dhCache['precalcul']['ventePotentielleMscpi'];
				$rt->valorisationOtherClientsProspect += $dhCache['precalcul']['ventePotentielleOther'];
			}
			else if ($elm->getType() == "" && $elm->phoneOk())
			{
				$rt->nbrClientsNoMail++;
				$rt->valorisationClientsNoMail += $dhCache['precalcul']['ventePotentielle'];
				$rt->valorisationMscpiClientsNoMail += $dhCache['precalcul']['ventePotentielleMscpi'];
				$rt->valorisationOtherClientsNoMail += $dhCache['precalcul']['ventePotentielleOther'];

				$rt->nbrClientsProspect++;
				$rt->valorisationClientsProspect += $dhCache['precalcul']['ventePotentielle'];
				$rt->valorisationMscpiClientsProspect += $dhCache['precalcul']['ventePotentielleMscpi'];
				$rt->valorisationOtherClientsProspect += $dhCache['precalcul']['ventePotentielleOther'];
			}
			else if ($elm->getType() == "" && $elm->mailOk())
			{
				$rt->nbrClientsNoPhone++;
				$rt->valorisationClientsNoPhone += $dhCache['precalcul']['ventePotentielle'];
				$rt->valorisationMscpiClientsNoPhone += $dhCache['precalcul']['ventePotentielleMscpi'];
				$rt->valorisationOtherClientsNoPhone += $dhCache['precalcul']['ventePotentielleOther'];

				$rt->nbrClientsProspect++;
				$rt->valorisationClientsProspect += $dhCache['precalcul']['ventePotentielle'];
				$rt->valorisationMscpiClientsProspect += $dhCache['precalcul']['ventePotentielleMscpi'];
				$rt->valorisationOtherClientsProspect += $dhCache['precalcul']['ventePotentielleOther'];
			}
			else if ($elm->getType() == "" && !$elm->isValide())
			{
				$rt->nbrClientsNoVal++;
				$rt->valorisationClientsNoVal += $dhCache['precalcul']['ventePotentielle'];
				$rt->valorisationMscpiClientsNoVal += $dhCache['precalcul']['ventePotentielleMscpi'];
				$rt->valorisationOtherClientsNoVal += $dhCache['precalcul']['ventePotentielleOther'];

				$rt->nbrClientsProspect++;
				$rt->valorisationClientsProspect += $dhCache['precalcul']['ventePotentielle'];
				$rt->valorisationMscpiClientsProspect += $dhCache['precalcul']['ventePotentielleMscpi'];
				$rt->valorisationOtherClientsProspect += $dhCache['precalcul']['ventePotentielleOther'];
			}
			else
				continue ;
			if ($elm->isFrontCreation())
			{
				$rt->nbrFront++;
				$rt->valorisationFront += $dhCache['precalcul']['ventePotentielle'];
				$rt->valorisationMscpiFront += $dhCache['precalcul']['ventePotentielleMscpi'];
				$rt->valorisationOtherFront += $dhCache['precalcul']['ventePotentielleOther'];
			}
		}
		$rt->nbrClients = $rt->nbrClientsMscpi + $rt->nbrClientsOther + $rt->nbrClientsNoVal + $rt->nbrClientsNoMail + $rt->nbrClientsNoPhone;

		$rt->valorisationClients = $rt->valorisationClientsMscpi + $rt->valorisationClientsOther +
			$rt->valorisationClientsNoVal + $rt->valorisationClientsNoMail + $rt->valorisationClientsNoPhone;

		$rt->valorisationMscpiClients = $rt->valorisationMscpiClientsMscpi + $rt->valorisationMscpiClientsOther +
			$rt->valorisationMscpiClientsNoVal + $rt->valorisationMscpiClientsNoPhone + $rt->valorisationMscpiClientsNoMail;

		$rt->valorisationOtherClients = $rt->valorisationOtherClientsMscpi + $rt->valorisationOtherClientsOther +
			$rt->valorisationOtherClientsNoVal + $rt->valorisationOtherClientsNoPhone + $rt->valorisationOtherClientsNoMail;


		$rt->valorisationMoyenneClients = $rt->valorisationClients /  $rt->nbrClients;
		$rt->valorisationMoyenneClientsMscpi = $rt->valorisationClientsMscpi /  $rt->nbrClientsMscpi;
		$rt->valorisationMoyenneClientsOther = $rt->valorisationClientsOther /  $rt->nbrClientsOther;


		$rt->valorisationMscpiMoyenneClients = $rt->valorisationMscpiClients /  $rt->nbrClients;
		$rt->valorisationMscpiMoyenneClientsMscpi = $rt->valorisationMscpiClientsMscpi /  $rt->nbrClientsMscpi;
		$rt->valorisationMscpiMoyenneClientsOther = $rt->valorisationMscpiClientsOther /  $rt->nbrClientsOther;

		$rt->valorisationOtherMoyenneClients = $rt->valorisationOtherClients /  $rt->nbrClients;
		$rt->valorisationOtherMoyenneClientsMscpi = $rt->valorisationOtherClientsMscpi /  $rt->nbrClientsMscpi;
		$rt->valorisationOtherMoyenneClientsOther = $rt->valorisationOtherClientsOther /  $rt->nbrClientsOther;
		/*


		$rt->valorisationMscpiClients= $rt->valorisationMscpiClientsMscpi + $rt->valorisationMscpiClientsOther;

		$rt->valorisationMscpiMoyenneClients = $rt->valorisationMscpiClients /  $rt->nbrClients;
		*/

		$rt->nbrCompteCreeFront = Dh::getNbInscriptionById(1);
        $rt->nbrCompteCreeFacebook = Dh::getNbInscriptionById(4);
        $rt->nbrCompteCreeTwitter = Dh::getNbInscriptionById(5);
        $rt->nbrCompteCreeLinxo = Dh::getNbInscriptionById(3);
        $rt->nbrCompteCreeMailChimp = Dh::getNbInscriptionById(2);
        $rt->nbrCompteCreeLinkedin = Dh::getNbInscriptionById(6);
        $rt->nbrCompteCreeApi = Dh::getNbInscriptionById(10);
        
        $rt->nbrCompteCreeApi = Logger::getNbrCompteCreeApi();

        $rt->accountCreations = Dh::getNbrByIdForLastDaysTotal();
        $rt->accountCreationsFront = Dh::getNbrByIdForLastDays(1);
        $rt->accountCreationsMailChimp = Dh::getNbrByIdForLastDays(2);
        $rt->accountCreationsFacebook = Dh::getNbrByIdForLastDays(4);
        $rt->accountCreationsTwitter = Dh::getNbrByIdForLastDays(5);
        $rt->accountCreationsLinkedin = Dh::getNbrByIdForLastDays(6);
        $rt->accountCreationsLinxo = Dh::getNbrByIdForLastDays(3);
        $rt->accountCreationsApi = Dh::getNbrByIdForLastDays(10);
        $rt->connexion = Logger::getNbrByIdForLastDays(2);
		//$rt->visualGuide = Logger::getNbrByIdForLastDays(42);
		$rt->centreInteret = Logger::getNbrByIdForFirstTime(44);
		$rt->StatCentreInteret = CentreInteret::getForStats();

		$rt->nbrFicheProduitParScpi = Dh::getNbrByElementInscription('Fiche produit');
        $rt->NbrPageContact = Dh::getNbrPageContact();
        $rt->NbrPageGuides = Dh::getNbrPageGuides('Page Guides');
        $rt->NbrLandingMarketing = Dh::getNbrByLandingMarketing('Landing Marketing');
        $rt->NbrLandingProduit = Dh::getNbrByElementInscription('Landing Produit');
        $rt->NbrLandingCreation = Dh::getNbrByLandingCreationCompte('Landing Création de compte');
        $rt->NbrPageSocieteGeston = Dh::getNbrByElementInscription('Page Société de gestion');
        $rt->NbrLandingGuide = Dh::getNbrByElementInscription('Landing Guides');
        $rt->NbrEtudePersonnalise = Dh::getNbrByElementInscription('Etude personnalisée');


        $rt->date = new Datetime('now');
		return ($rt);
	}
	public function __toString() {
		$rt = "Clients MSCPI : " . $this->nbrClientsMscpi . "<br />";
		$rt .= "Prospects : " . $this->nbrClientsOther . "<br />";
		$rt .= "Total: " . $this->nbrClientsOther . "<br />";
		return ($rt);
	}
	/*
	public function getClientsNbr() {
		return ($this->nbrClientsMscpi);
	}
	public function getProspectsNbr() {
		return ($this->nbrClientsOther);
	}
	public function getClientsTotalNbr() {
		return ($this->nbrClients);
	}
	public function getClientsValorisation() {
		return ($this->valorisationClientsMscpi);
	}
	public function getProspectsValorisation() {
		return ($this->valorisationClientsOther);
	}
	public function getClientsTotalValorisation() {
		return ($this->valorisationClients);
	}
	public function getClientsValorisationMoyenne() {
		return ($this->valorisationMoyenneClientsMscpi);
	}
	public function getProspectsValorisationMoyenne() {
		return ($this->valorisationMoyenneClientsOther);
	}
	public function getClientsTotalValorisationMoyenne() {
		return ($this->valorisationMoyenneClients);
	}
	public function getClientsValorisationMscpi() {
		return ($this->valorisationMscpiClientsMscpi);
	}
	public function getProspectsValorisationMscpi() {
		return ($this->valorisationMscpiClientsOther);
	}
	public function getClientsTotalValorisationMscpi() {
		return ($this->valorisationMscpiClients);
	}
	public function getClientsValorisationMscpiMoyenne() {
		return ($this->valorisationMscpiMoyenneClientsMscpi);
	}
	public function getProspectsValorisationMscpiMoyenne() {
		return ($this->valorisationMscpiMoyenneClientsOther);
	}
	public function getClientsTotalValorisationMscpiMoyenne() {
		return ($this->valorisationMscpiMoyenneClients);
	}
	*/
}
