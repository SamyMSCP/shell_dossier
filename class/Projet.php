<?php
require_once("core/Database.php");
require_once("core/Table.php");
require_once("core/DocumentTrait.php");

class Projet extends Table
{
	use DocumentTrait;
	protected static		$_name = "PROJET";
	protected static		$_primary_key = "id";
	public static			$_noSecure = ['commentaire', 'strategie', 'autres_elements'];

	public static			$_listObjectif = array(
		"1" => "Percevoir des revenus réguliers à terme",
		"2" => "Percevoir des revenus réguliers immédiatement",
		"3" => "Transmettre un capital à mes proches",
		"4" => "Valoriser mon capital sur la durée",
		"5" => "Garantir mon capital",
		"6" => "Diversification",
		"7" => "Défiscalisation",
		"8" => "Autre"
	);

	public static			$_listObjectifText = array(
		"1" => "Notre stratégie sur cet objectif est",
		"2" => "Notre stratégie sur cet objectif est",
		"3" => "Notre stratégie sur cet objectif est",
		"4" => "Notre stratégie sur cet objectif est",
		"5" => "Le capital n’est pas garanti. Comme avec de l’immobilier en direct, la valeur des actifs détenus par la SCPI varie en fonction du marché. La responsabilité financière des associés est limitée aux apports au capital. La revente des parts ou la revente de votre actif immobilier n’est pas garantie, elle peut être plus ou moins facile en fonction de l’évolution du marché de l’immobilier et des parts de SCPI. Cependant la répartition géographique et la diversification dans la typologie d’immobilier permet de limiter et d’atténuer ces risques. La réglementation organise la liquidité des parts. lI est donc important d’être bien accompagné. Lors des missions confiées par nos clients, nous étudions la liquidité des parts. En signant ce présent rapport de conseil, vous attestez reconnaitre ce point.",
		"6" => "Notre stratégie sur cet objectif est",
		"7" => "Notre stratégie sur cet objectif est",
		"8" => "Notre stratégie sur cet objectif est"
	);

	public static			$_listOrigine  = array(
		"1" => "Épargne",
		"2" => "Cession d’actifs immobiliers",
		"3" => "Héritage (successions)",
		"4" => "Réemploi de fonds propres",
		"5" => "Donation",
		"6" => "Réemploi de fonds démembrés",
		"7" => "Cessions d’actifs mobiliers",
		"8" => "Autre"
	);
	
	private					$_beneficiaire = null;
	private					$_conseiller = null;
	private					$_objectifs = null;

	public static			$fourchettes = array(
		1 => array(0, 50000),
		2 => array(25000, 50000),
		3 => array(50000, 100000),
		4 => array(100000, 500000)
	);

	public static function insertNew($id_beneficiaire, $id_conseiller, $nom, $listObjectif, $invest, $credit, $accompagnement, $origine) {

		$dh = Dh::getCurrent();
		if (empty($dh))
			$dh = 0;
		else
			$dh = $dh->id_dh;

		$req = "INSERT INTO `PROJET` (id_beneficiaire, id_conseiller, nom, date_creation, objectifs, fourchette_investissement, credit, accompagne_investissement, etat_du_projet, origine, creator)
			VALUES(?, ?, ?, ?, ?, ?, ?, ?, -1, ?, ?);";
		$date_creation = time();
		$data = array(
			$id_beneficiaire,
			$id_conseiller,
			$nom,
			$date_creation,
			$listObjectif,
			$invest,
			$credit,
			$accompagnement,
			$origine,
			$dh
		);
		Pp::getFromBeneficiaire($id_beneficiaire)[0]->resetAllSituation();
		$id = Database::prepareInsert(static::$_db, $req, $data);
		return ($id);
	}
	public static function insertNewPm($id_beneficiaire, $id_conseiller, $nom, $listObjectif, $invest, $credit, $accompagnement, $origine) {
		$req = "INSERT INTO `PROJET` (id_beneficiaire, id_conseiller, nom, date_creation, objectifs, fourchette_investissement, credit, accompagne_investissement, etat_du_projet, origine)
			VALUES(?, ?, ?, ?, ?, ?, ?, ?, -1, ?);";
		$date_creation = time();
		$data = array(
			$id_beneficiaire,
			$id_conseiller,
			$nom,
			$date_creation,
			$listObjectif,
			$invest,
			$credit,
			$accompagnement,
			$origine
		);
		Pm::getFromBeneficiaire($id_beneficiaire)[0]->resetAllSituation();
		$id = Database::prepareInsert(static::$_db, $req, $data);
		return ($id);
	}
	public static function getFromDh($id_dh) {
		$rt = array();
		$ben = Beneficiaire::getFromDh($id_dh);
		foreach ($ben as $key => $elm)
		{
			foreach ($elm->getProjects() as $key2 => $elm2)
			{
				$rt[] = $elm2;
			}
		}
		return ($rt);
	}
	public static function getFromDhForFrontStore($id_dh) {
		$rt = array();
		$ben = Beneficiaire::getFromDh($id_dh);
		foreach ($ben as $key => $elm)
		{
			foreach ($elm->getProjects() as $key2 => $elm2)
			{
				$rt[] = $elm2->getForFrontStore();
			}
		}
		return ($rt);
	}
	public function getForFrontStore() {

		// TODO : Retirer les éléments au quels l'utilisateur n'a pas acces en fonction de la valeur de 'etat_du_projet'.
		$rt = [];
		$rt['id'] = $this->id;
		$rt['date_creation'] = $this->date_creation;
		$rt['id_beneficiaire'] = $this->id_beneficiaire;
		$rt['beneficiaireShortName'] = Beneficiaire::getFromId($this->id_beneficiaire)[0]->getShortName();
		$rt['nom'] = $this->getName();
		$rt['etat_du_projet'] = $this->etat_du_projet;
		$rt['conseiller'] = $this->id_conseiller;///id_conseiller:"2"
		$rt['conseillerShortName'] = Dh::getById($this->id_conseiller)->getShortName();
		$rt['conseillerShortName2'] = Dh::getById($this->id_conseiller)->getPersonnePhysique()->getFirstName() . " " .  Dh::getById($this->id_conseiller)->getPersonnePhysique()->getName();
		$rt['conseillerPhone'] = Dh::getById($this->id_conseiller)->getPersonnePhysique()->getPhoneFixe();
		$rt['conseillerMail'] = Dh::getById($this->id_conseiller)->getPersonnePhysique()->getMail();
		$rt['lstObjectifs'] = $this->getObjectifsArray();
		$rt['budget'] = $this->getBudget();
		$rt['accompagne_investissement'] = $this->accompagne_investissement;
		$rt['credit'] = $this->credit;
		$rt['date_modification'] = $this->date_modification;
		$rt['date_finalisation'] = $this->date_finalisation;
		$rt['fourchette_investissement'] = $this->fourchette_investissement;

		$rt['Beneficiaire'] =  $this->getBeneficiairesEntity()->getForStore();
		//$rt['Pps'] = $this->getBeneficiairesEntity();

		$rt['id_objectif_investissement'] = $this->id_objectif_investissement;
		$rt['objectif_autre'] = $this->objectif_autre;
		$rt['objectifs'] = $this->getObjectifs();
		$rt['origine'] = $this->getOrigine();
		$rt['commentaire'] = $this->getCommentaire();
		$rt['id_objectifs_list_1'] = $this->getObjectifsList1();
		$rt['id_objectifs_list_2'] = $this->getObjectifsList2();
		$rt['id_objectifs_list_3'] = $this->getObjectifsList3();
		$rt['url'] = encrypt_url($this->id);


		// Récupérer la liste des documents liés
		$documents = [];
		$temoin = false;
		foreach ($this->getDocumentsArray() as $key => $elm) {
			foreach ($elm as $key2 => $elm2) {
				unset($elm2->data);
				$elm2->type_document = $elm2->getTypeDocument()->getName();
				$documents[] = $elm2;
			}
		}

		$rt['documents'] = $documents;

		$rt['transactions'] = [];
		foreach ($this->getTransaction() as $key => $elm)
		{
			$scpi = $elm->getScpi();
			$tmp = $elm->getForStore();
			$tmp['scpiName'] = $scpi->getName();
			$tmp['scpiType'] = $scpi->getTypeStr();
			$tmp['scpiTypeCapital'] = $scpi->getTypeCapital();
			$tmp['scpiCategory'] = $scpi->getCategory();
			$tmp['scpiCategoryStr'] = $scpi->getCategoryStr();
			$tmp['scpiSocieteGestionName'] = $scpi->getSocieteGestion()->getName();
			$tmp['scpiAdequation'] = $scpi->getAdequation();
			$tmp['scpiStrategie'] = $scpi->getStrategie();
			$tmp['scpiConseil'] = $scpi->getConseilsMscpi();
			$rt['transactions'][] = $tmp;
		}
		return ($rt);
	}
	public static function getFromDhForStore($id_dh) {
		$rt = array();
		$ben = Beneficiaire::getFromDh($id_dh);
		foreach ($ben as $key => $elm)
		{
			foreach ($elm->getProjects() as $key2 => $elm2)
			{
				$rt[] = $elm2->getForStore();
			}
		}
		return ($rt);
	}
	public function getForStore() {
		$rt = [];
		$rt['id'] = $this->id;
		$rt['nom'] = $this->getName();
		$rt['accompagne_investissement'] = $this->accompagne_investissement;
		$rt['credit'] = $this->credit;
		$rt['date_creation'] = $this->date_creation;
		$rt['date_modification'] = $this->date_modification;
		$rt['date_finalisation'] = $this->date_finalisation;
		$rt['etat_du_projet'] = $this->etat_du_projet;
		$rt['fourchette_investissement'] = $this->fourchette_investissement;
		$rt['id_beneficiaire'] = $this->id_beneficiaire;
		//$rt['conseiller'] = 2;///id_conseiller:"2"
		$rt['conseiller'] = $this->id_conseiller;///id_conseiller:"2"
		$rt['id_objectif_investissement'] = $this->id_objectif_investissement;
		$rt['objectif_autre'] = $this->objectif_autre;
		$rt['objectifs'] = $this->getObjectifs();
		$rt['origine'] = $this->getOrigine();
		$rt['commentaire'] = $this->getCommentaire();
		$rt['id_objectifs_list_1'] = $this->getObjectifsList1();
		$rt['id_objectifs_list_2'] = $this->getObjectifsList2();
		$rt['id_objectifs_list_3'] = $this->getObjectifsList3();
		$rt['strategie'] = !empty($this->getStrategie()) ? $this->getStrategie() : "-";
		$rt['autres_elements'] = !empty($this->getAutresElements()) ? $this->getStrategie() : "-";
		$rt['url'] = encrypt_url($this->id);
		return ($rt);
	}
	public function getStrategie() {
		return ($this->strategie);
	}
	public function getOrigine() {
		return (mb_unserialize($this->origine));
	}
	public function getCommentaire() {
		if (empty($this->commentaire))
			return (" ");
		return ($this->commentaire);
	}
	public static function getFromBeneficiaire($id_beneficiaire) {
		return (parent::getFromKeyValue("id_beneficiaire", $id_beneficiaire));
	}
	public function getName() {
		if (empty($this->nom) || $this->nom == "-")
		{
			//$this->nom = self::$_listObjectif[$this->getObjectifs()[0]];
			$this->nom = ' ';
			$this->updateOneColumn('nom', $this->nom);
		}
		return ($this->nom);
	}
	public function getEtatProjet() {
		return ($this->etat_du_projet);
	}
	public function getBeneficiaires() {
		return ($this->id_beneficiaire);
	}
	public function getBeneficiairesEntity() {
		if ($this->_beneficiaire == null)
		{
			$this->_beneficiaire = Beneficiaire::getFromId($this->id_beneficiaire);
			if (count($this->_beneficiaire))
				$this->_beneficiaire = $this->_beneficiaire[0];
		}
		return ($this->_beneficiaire);
	}
	public function getConseiller() {
		if ($this->_conseiller == null)
		{
			$this->_conseiller = Dh::getById($this->id_conseiller);
		}
		return ($this->_conseiller);
	}
	public function getObjectifsArray() {
		$rt = [];
		foreach ($this->getObjectifs() as $key => $elm)
		{
			$rt[] = self::$_listObjectif[$elm];
		}
		return ($rt);
	}
	public function getObjectifs() {
		if ($this->_objectifs == null)
		{
			$this->_objectifs = unserialize($this->objectifs);
		}
		return ($this->_objectifs);
	}
	public function getDateCreation() {
		$rt = new DateTime();
		$rt = $rt->setTimestamp($this->date_creation);
		return ($rt);
	}
	public function getDateModification() {
		$rt = new DateTime();
		$rt = $rt->setTimestamp($this->date_modification);
		return ($rt);
	}
	public function haveCredit() {
		return (
			$this->credit == 1 ||
			$this->credit == 2
		);
	}
	public function getCredit() {
		return (intval($this->credit));
	}
	public function haveAccompagnement() {
		return ($this->accompagne_investissement == 1);
	}
	public function getBudget() {
		if (isset(self::$fourchettes[$this->fourchette_investissement]))
		{
			$rt = number_format(self::$fourchettes[$this->fourchette_investissement][0], 2, ",", " ");
			$rt .= " € à ";
			$rt .= number_format(self::$fourchettes[$this->fourchette_investissement][1], 2, ",", " ");
			$rt .= " €";
		}
		else
		{
			$rt = "À partir de ";
			$rt .= number_format(self::$fourchettes[$this->fourchette_investissement - 1][1], 2, ",", " ");
			$rt .= " €";
		}
		return ($rt);
	}
	public function getTransaction() {
		return (Transaction::getFromProject($this->id));
	}
	public function getNewRec() {
		return (new Rec($this));
		//$rt = new Rec($this);
		//return ($rt->getPdf());
	}
	public function recOkay() {
		if (count($this->getValideDocumentSignedByTypeId(9)))
			return (true);
		return (false);
	}

	public function getObjectifsList1() {
		if (!empty($this->id_objectifs_list_1))
			return ($this->id_objectifs_list_1);
		return (0);
	}
	public function getObjectifsList2() {
		if (!empty($this->id_objectifs_list_2))
			return ($this->id_objectifs_list_2);
		return (0);
	}
	public function getObjectifsList3() {
		if (!empty($this->id_objectifs_list_3))
			return ($this->id_objectifs_list_3);
		return (0);
	}

	public function getObjectifsList1Array() {
		if (!empty($this->id_objectifs_list_1))
			return (ObjectifsList::getFromId($this->id_objectifs_list_1)[0]);
		return (0);
	}
	public function getObjectifsList2Array() {
		if (!empty($this->id_objectifs_list_2))
			return (ObjectifsList::getFromId($this->id_objectifs_list_2)[0]);
		return (0);
	}
	public function getObjectifsList3Array() {
		if (!empty($this->id_objectifs_list_3))
			return (ObjectifsList::getFromId($this->id_objectifs_list_3)[0]);
		return (0);
	}
	public function getDh() {
		return ($this->getBeneficiairesEntity()->getDh());
	}
	public function checkAuthorisation($dh) {
		return ($dh->id_dh == $this->getBeneficiairesEntity()->id_dh);
	}
	public function getAutresElements() {
		return ($this->autres_elements);
	}
}
