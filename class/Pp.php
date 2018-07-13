<?php
require_once("core/Database.php");
require_once("core/Table.php");
require_once("core/DocumentTrait.php");
require_once("Dh.php");
require_once("ConnuMscpi.php");
require_once("CatPro.php");
require_once("StatusPro.php");

class Pp extends Table
{
	use DocumentTrait;
	protected static		$_name = "PERSONNE PHYSIQUE";
	protected static		$_primary_key = "id_phs";
	public static			$_etat_civil_lst = array(
		"marie",
		"pacse",
		"celibataire",
		"veuf",
		"divorce",
		"unionlibre"
	);
	public static			$_type_voie = array(
		"Allée",
		"Avenue",
		"Boulevard",
		"Carrefour",
		"Chemin",
		"Chaussée",
		"Cité",
		"Corniche",
		"Cours",
		"Domaine",
		"Descente",
		"Ecart",
		"Esplanade",
		"Faubourg",
		"Grande Rue",
		"Hameau",
		"Halle",
		"Impasse",
		"Lieu-dit",
		"Lotissement",
		"Marché",
		"Montée",
		"Passage",
		"Place",
		"Plaine",
		"Plateau",
		"Promenade",
		"Parvis",
		"Quartier",
		"Quai",
		"Résidence",
		"Ruelle",
		"Rocade",
		"Rond-point",
		"Route",
		"Rue",
		"Sente - Sentier",
		"Square",
		"Terre-plein",
		"Traverse",
		"Villa",
		"Village"
	);
	private					$_nom = null;
	private					$_prenom = null;
	private					$_nom_jeune_fille = null;
	private					$_profession = null;
	private					$_phone = null;
	private					$_indicatifPhone = null;
	private					$_phoneFixe = null;
	private					$_indicatifPhoneFixe = null;
	private					$_civilite = null;
	private					$_mail = null;

	private					$_complementAdresse = null;
	private					$_numeroRue = null;
	private					$_voie = null;
	private					$_codePostal = null;
	private					$_ville = null;
	private					$_pays = null;

	private					$_dateNaissance = null;
	private					$_lieuNaissance = null;
	private					$_pays_de_naissance = null;
	private					$_etat_civil = null;
	private					$_nationalite = null;
	private					$_adresse = null;
	private					$_situationJuridique = null;
	private					$_situationFinanciere = null;
	private					$_situationFiscale = null;
	private					$_situationPatrimoniale = null;

	private					$_lastSituationJuridique = null;
	private					$_lastSituationFinanciere = null;
	private					$_lastSituationFiscale = null;
	private					$_lastSituationPatrimoniale = null;
	public static function insert($lien_dh, $civilite, $prenom, $nom, $mail, $indicatif_telephonique, $telephone, $etat_civil, $nationalite, $lieu_de_n, $date_de_n, $adresse) {
		$req = "INSERT INTO `PERSONNE PHYSIQUE` 
			(lien_dh, civilite, prenom, nom, mail, indicatif_telephonique, telephone, etat_civil, nationalite, lieu_de_n, date_de_n, adresse)
			VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
		$date_de_n = DateTime::createFromFormat("Y-m-d", $date_de_n);
		if (!$date_de_n)
			$date_de_n = "-";
		else
			$date_de_n = $date_de_n->getTimestamp();
		$data = array(
			$lien_dh,
			ft_crypt_information($civilite),
			ft_crypt_information($prenom),
			ft_crypt_information($nom),
			ft_crypt_information($mail),
			$indicatif_telephonique,
			ft_crypt_information($telephone),
			ft_crypt_information($etat_civil),
			ft_crypt_information($nationalite),
			ft_crypt_information($lieu_de_n),
			$date_de_n,
			ft_crypt_information($adresse)
		);
		return Database::prepareInsert(static::$_db, $req, $data);
	}
	public static function insertMini($lien_dh, $civilite, $prenom, $nom) {
		$req = "INSERT INTO `PERSONNE PHYSIQUE` (lien_dh, civilite, prenom, nom)
			VALUES (?, ?, ?, ?)";
		 if ($civilite !== "Monsieur" && $civilite !== "Madame")
			$civilite = $civilite == "M." ? "Monsieur" : "Madame";
		$data = array(
			$lien_dh,
			ft_crypt_information($civilite),
			ft_crypt_information($prenom),
			ft_crypt_information($nom)
		);
		return Database::prepareInsert(static::$_db, $req, $data);
	}
	public function setMail($mail)
	{
		$this->updateOneColumn("mail", ft_crypt_information($mail));
		$this->mail = ft_crypt_information($mail);
	}
	public static function updateFromId($id_phs, $lien_dh, $civilite, $prenom, $nom, $mail, $indicatif_telephonique, $telephone, $etat_civil, $nationalite, $lieu_de_n, $date_de_n, $adresse) {
		$date_de_n = DateTime::createFromFormat("Y-m-d", $date_de_n);
		if (!$date_de_n)
			$date_de_n = "-";
		else
			$date_de_n = $date_de_n->getTimestamp();
		$req = "UPDATE `PERSONNE PHYSIQUE` 
			SET lien_dh = ? ,
			civilite = ?,
			prenom = ?,
			nom = ?,
			mail = ?,
			indicatif_telephonique = ?,
			telephone = ?,
			etat_civil = ?,
			nationalite = ?,
			lieu_de_n = ?,
			date_de_n = ?,
			adresse = ?
			WHERE id_phs = " . $id_phs;
		$data = array(
			$lien_dh,
			ft_crypt_information($civilite),
			ft_crypt_information($prenom),
			ft_crypt_information($nom),
			ft_crypt_information($mail),
			$indicatif_telephonique,
			ft_crypt_information($telephone),
			ft_crypt_information($etat_civil),
			ft_crypt_information($nationalite),
			ft_crypt_information($lieu_de_n),
			$date_de_n,
			ft_crypt_information($adresse)
		);
		return Database::prepareNoClass(static::$_db, $req, $data);
	}
	public static function updateAllFromId($id_phs, $lien_dh, $civilite, $prenom, $nom, $mail, $indicatif_telephonique, $telephone, $etat_civil, $nationalite, $lieu_de_n, $date_de_n, $adresse, $profession, $us_person, $politique) {
		$date = DateTime::createFromFormat("Y-m-d", $date_de_n);
		if (empty($date))
			$date = Datetime::createFromFormat("d/m/Y", $date_de_n);
		if (empty($date))
		{
			return (false);
		}
		$date_de_n = $date;
		if (empty($profession))
			$profession = "-";

		if (!$date_de_n)
			$date_de_n = "-";
		else
			$date_de_n = $date_de_n->getTimestamp();
		$req = "UPDATE `PERSONNE PHYSIQUE` 
			SET lien_dh = ? ,
			civilite = ?,
			prenom = ?,
			nom = ?,
			mail = ?,
			indicatif_telephonique = ?,
			telephone = ?,
			etat_civil = ?,
			nationalite = ?,
			lieu_de_n = ?,
			date_de_n = ?,
			adresse = ?,
			profession = ?,
			us_person = ?,
			politiquement_expose = ?
			WHERE id_phs = " . $id_phs;
		$data = array(
			$lien_dh,
			ft_crypt_information($civilite),
			ft_crypt_information($prenom),
			ft_crypt_information($nom),
			ft_crypt_information($mail),
			$indicatif_telephonique,
			ft_crypt_information($telephone),
			ft_crypt_information($etat_civil),
			ft_crypt_information($nationalite),
			ft_crypt_information($lieu_de_n),
			$date_de_n,
			ft_crypt_information($adresse),
			ft_crypt_information($profession),
			$us_person,
			$politique
		);
		return Database::prepareNoClass(static::$_db, $req, $data);
	}
	public static function create() {
		$rt = new Pp();
		$rt->_is_new = 1;
		return ($rt);
	}
	public function getOrCreateSituation() {
		if (empty($this->id_situation))
		{
			$couple = $this->getBeneficiaireCouple();
			if (count($couple))
			{
				$lst = array();
				$found = 0;
				foreach ($couple[0]->getPersonnePhysique() as $key => $elm)
				{
					if (!empty($elm->id_situation))
						$found = $elm->id_situation;
					$lst[] = $elm->id_phs;
				}
				if (!empty($found))
				{
					$this->id_situation = Situation::linkPpArray($found, $lst);
					return ($this->id_situation);
				}
				else
				{
					$this->id_situation = Situation::insertNewPp($this->lien_dh, $lst);
					return ($this->id_situation);
				}
			}
			else
			{
				$this->id_situation = Situation::insertNewPp($this->lien_dh, array($this->id_phs));
				return ($this->id_situation);
			}
		}
		return ($this->id_situation);
	}
	public function insertSituationJuridique($date_situation, $date_fin_situation, $regime_mat, $nbr_enfant_charge, $nbr_pers_charge, $haveChild) {
		return SituationJuridique::insertNew(
			$this->getOrCreateSituation(),
			$date_situation,
			$date_fin_situation,
			$regime_mat,
			$nbr_enfant_charge,
			$nbr_pers_charge,
			$haveChild
		);
	}
	public function getSituationJuridique() {
		if ($this->_situationJuridique == null)
		{
			if (!empty($this->id_situation))
				$this->_situationJuridique = SituationJuridique::getFromPdId($this->getOrCreateSituation());
			else
				$this->_situationJuridique = array();
		}
		return ($this->_situationJuridique);
	}
	public function getLastSituationJuridique() {
		if ($this->_lastSituationJuridique == null)
		{
			if (!empty($this->id_situation))
				$this->_lastSituationJuridique = SituationJuridique::getLastFromPpId($this->getOrCreateSituation());
			else
				$this->_lastSituationJuridique = null;
		}
		return ($this->_lastSituationJuridique);
	}
	public function getResetSituation() {
		return Situation::getResetFromPpId($this->getOrCreateSituation());
	}
	public function getResetSituationJuridique() {
		return ($this->getResetSituation()->resetSituationJuridique);
	}
	public function getResetSituationFinanciere() {
		return ($this->getResetSituation()->resetSituationFinanciere);
	}
	public function getResetSituationFiscale() {
		return ($this->getResetSituation()->resetSituationFiscale);
	}
	public function getResetSituationPatrimoniale() {
		return ($this->getResetSituation()->resetSituationPatrimoniale);
	}
	public function resetAllSituation() {
		$situation = Situation::getFromId($this->getOrCreateSituation())[0];
		$situation->updateOneColumn("resetSituationJuridique", 1);
		$situation->updateOneColumn("resetSituationFinanciere", 1);
		$situation->updateOneColumn("resetSituationFiscale", 1);
		$situation->updateOneColumn("resetSituationPatrimoniale", 1);
	}
	public function getLastSituationFinanciere() {
		if ($this->_lastSituationFinanciere == null)
		{
			if (!empty($this->id_situation))
				$this->_lastSituationFinanciere = SituationFinanciere::getLastFromPpId($this->getOrCreateSituation());
			else
				$this->_lastSituationFinanciere = null;
		}
		return ($this->_lastSituationFinanciere);
	}
	public function getLastSituationPatrimoniale() {
		if ($this->_lastSituationPatrimoniale == null)
		{
			if (!empty($this->id_situation))
				$this->_lastSituationPatrimoniale = SituationPatrimoniale::getLastFromPpId($this->getOrCreateSituation());
			else
				$this->_lastSituationPatrimoniale = null;
		}
		return ($this->_lastSituationPatrimoniale);
	}
	public function getLastSituationFiscale() {
		if ($this->_lastSituationFiscale == null)
		{
			if (!empty($this->id_situation))
				$this->_lastSituationFiscale = SituationFiscale::getLastFromPpId($this->getOrCreateSituation());
			else
				$this->_lastSituationFiscale = null;
		}
		return ($this->_lastSituationFiscale);
	}
	public function getSituationFinanciere() {
		if ($this->_situationFinanciere == null)
		{
			if (!empty($this->id_situation))
				$this->_situationFinanciere = SituationFinanciere::getFromPdId($this->getOrCreateSituation());
			else
				$this->_situationFinanciere = array();
		}
		return ($this->_situationFinanciere);
	}
	public function getSituationPatrimoniale() {
		if ($this->_situationPatrimoniale == null)
		{
			if (!empty($this->id_situation))
				$this->_situationPatrimoniale = SituationPatrimoniale::getFromPdId($this->getOrCreateSituation());
			else
				$this->_situationPatrimoniale = array();
		}
		return ($this->_situationPatrimoniale);
	}
	public function getSituationFiscale() {
		if ($this->_situationFiscale == null)
		{
			if (!empty($this->id_situation))
				$this->_situationFiscale = SituationFiscale::getFromPdId($this->getOrCreateSituation());
			else
				$this->_situationFiscale = array();
		}
		return ($this->_situationFiscale);
	}
	public function getSituationJuridiqueId() {
		$rt = $this->getSituationJuridique();
		return ($rt);
	}
	public function getSituationFinanciereId() {
		$rt = $this->getSituationFinanciere();
		return ($rt);
	}
	public function getSituationFiscaleId() {
		$rt = $this->getSituationFiscale();
		return ($rt);
	}
	public function getSituationPatrimonialeId() {
		$rt = $this->getSituationPatrimoniale();
		return ($rt);
	}
	public static function getByDh($id_phs) {
		return parent::getFromKeyValue("id_phs", $id_phs)[0];
	}
	public static function getFromBeneficiaire($id_benf) {
		$req = "SELECT * FROM `PERSONNE PHYSIQUE` INNER JOIN `BENEFICIAIRE_PERSONNE` ON `PERSONNE PHYSIQUE`.id_phs = `BENEFICIAIRE_PERSONNE`.lien_pp WHERE `BENEFICIAIRE_PERSONNE`.lien_bf = " . $id_benf;
		return Database::prepare(static::$_db, $req, array(), get_called_class());
	}
	public static function getAllFromDh($id_dh) {
		return parent::getFromKeyValue("lien_dh", $id_dh);
	}
	public function getId() {
		return $this->id;
	}
	public function getDh() {
		return Dh::getById($this->lien_dh);
	}
	public function getTransaction() {
		
	}
	
	public function getCiviliteStr() {
		if (ft_decrypt_crypt_information($this->civilite) == "Monsieur")
			return ("M.");
		return ("Mme");
	}
	public function getName() {
		if ($this->_nom == NULL)
			$this->_nom = htmlspecialchars(ft_decrypt_crypt_information($this->nom));
		return (mb_strtoupper($this->_nom));
	}
	public function getUsPerson() {
		if ($this->us_person == 1)
			return (true);
		return (false);
	}
	public function getPolitiquementExpose() {
		if ($this->politiquement_expose == 1)
			return (true);
		return (false);
	}
	public function getFirstName() {
		if ($this->_prenom == NULL)
			$this->_prenom = htmlspecialchars(ft_decrypt_crypt_information($this->prenom));
		return ($this->_prenom);
	}
	public function getNomJeuneFille() {
		if ($this->_nom_jeune_fille == NULL && !empty($this->nom_jeune_fille))
			$this->_nom_jeune_fille = htmlspecialchars($this->nom_jeune_fille);
		return ($this->_nom_jeune_fille);
	}
	public function getProfession() {
		if ($this->_profession == NULL && !empty($this->profession))
			$this->_profession = htmlspecialchars(ft_decrypt_crypt_information($this->profession));
		return ($this->_profession);
	}
	public function getPhone() {
		if (empty($this->telephone))
			return "";
		if ($this->_phone == NULL)
			$this->_phone = htmlspecialchars(ft_decrypt_crypt_information($this->telephone));
		return ($this->_phone);
	}
	public function getIndicatifPhone() {
		return ($this->indicatif_telephonique);
	}
	public function getIndicatifPhoneFixe() {
		return (htmlspecialchars($this->indicatif_telephonique_fixe));
	}
	public function getPhoneFixe() {
		if (empty($this->telephone_fixe))
			return "";
		if ($this->_phoneFixe == NULL)
			$this->_phoneFixe = htmlspecialchars(ft_decrypt_crypt_information($this->telephone_fixe));
		return ($this->_phoneFixe);
	}
	public function getMail() {
		if ($this->_mail== NULL)
		{
			if (!empty($this->mail))
				$this->_mail = htmlspecialchars(ft_decrypt_crypt_information($this->mail));
			else
				$this->_mail = "";
		}
		return ($this->_mail);
	}
	public function getCivilite() {
		if ($this->_civilite == NULL)
			$this->_civilite = htmlspecialchars(ft_decrypt_crypt_information($this->civilite));
		return ($this->_civilite);
	}
	public function getCiviliteFormat() {
		if ($this->getCivilite() === "Monsieur")
			return ("M.");
		else
			return ("Mme");
	}
	public function getDateNaissance() {
		if (empty($this->date_de_n))
			$this->_dateNaissance = "";
		if ($this->_dateNaissance == NULL) {
			$this->_dateNaissance = new DateTime;
			$this->_dateNaissance->setTimestamp($this->date_de_n); 
		}
		return ($this->_dateNaissance);
	}
	public function getLieuNaissanceStr() {
		return (ucfirst(htmlspecialchars(ft_decrypt_crypt_information($this->lieu_de_n))));
	}
	public function getLieuNaissance() {
		if (empty($this->lieu_de_n))
			return (null);
		if ($this->_lieuNaissance == NULL)
			$this->_lieuNaissance = htmlspecialchars(ft_decrypt_crypt_information($this->lieu_de_n));
		return ($this->_lieuNaissance);
	}

	public function getComplementAdresse() {
		if (empty($this->complementAdresse))
			return (null);
		if ($this->_complementAdresse== NULL)
			$this->_complementAdresse = htmlspecialchars($this->complementAdresse);
		return ($this->_complementAdresse);
	}

	public function getNumeroRue() {
		if (empty($this->numeroRue))
			return (null);
		if ($this->_numeroRue== NULL)
			$this->_numeroRue = htmlspecialchars($this->numeroRue);
		return ($this->_numeroRue);
	}

	public function getVoie() {
		if (empty($this->voie))
			return (null);
		if ($this->_voie == NULL)
		{
			if ($this->voie != NULL)
				$this->_voie = htmlspecialchars(ft_decrypt_crypt_information($this->voie));
			if ($this->_voie == " ")
				$this->_voie = "";
		}
		return ($this->_voie);
	}

	public function setVoie($voie) {
		$this->updateOneColumn("voie", ft_crypt_information(htmlspecialchars($voie)));
	}


	public function getCodePostal() {
		if (empty($this->codePostal))
			return (null);
		if ($this->_codePostal== NULL)
		{
			$this->_codePostal = htmlspecialchars($this->codePostal);
			if ($this->_codePostal == " ")
				$this->_codePostal = "";
		}
		return ($this->_codePostal);
	}

	public function getVille() {
		if (empty($this->ville))
			return (null);
		if ($this->_ville== NULL)
		{
			$this->_ville = htmlspecialchars($this->ville);
			if ($this->_ville == " ")
				$this->_ville = "";
		}
		return ($this->_ville);
	}


	public function getPays() {
		if (empty($this->pays))
			return (null);
		if ($this->_pays== NULL)
		{
			$this->_pays = htmlspecialchars($this->pays);
			if ($this->_pays == " ")
				$this->_pays = "";
		}
		return ($this->_pays);
	}
/*
complementAdresse
numeroRue
voie
codePostal
ville
pays
*/
	public function getPaysNaissance() {
		if ($this->_pays_de_naissance == NULL)
		{
			$this->_pays_de_naissance = htmlspecialchars($this->pays_de_naissance);
			if ($this->_pays_de_naissance == " ")
				$this->_pays_de_naissance = "";
		}
		return ($this->_pays_de_naissance);
	}
	public function getEtatCivil() {
		if (empty($this->etat_civil))
			return (null);
		if ($this->_etat_civil == NULL)
			$this->_etat_civil = htmlspecialchars(ft_decrypt_crypt_information($this->etat_civil));
		return ($this->_etat_civil);
	}
	public function setEtatCivil($data) {
		return $this->updateOneColumn('etat_civil', ft_crypt_information(htmlspecialchars($data)));
	}
	public function getNationalite() {
		if (empty($this->nationalite))
			return (null);
		if ($this->_nationalite == null)
		{
			$this->_nationalite = htmlspecialchars(ft_decrypt_crypt_information($this->nationalite));
			if ($this->_nationalite == " ")
				$this->_nationalite = "";
		}
		return ($this->_nationalite);
	}
	public function getAdresseStr() {
		/*
			NumRue
			extension
			Type voie
			voie
			(ComplementAdresse)
		*/
		$rt = mb_strtolower($this->getNumeroRue() . " " .  $this->getExtention() . " " .  $this->getTypeVoie() . " " .  $this->getVoie() . " ");
		if (!empty($this->getComplementAdresse()))
			$rt .= $this->getComplementAdresse();
		return ($rt);
	}
	public function getCodeVilleStr() {
		/*
			codePostal
			ille
		*/
		return (
			$this->getCodePostal() . " " .
			$this->getVille() . " "
		);
	}
	public function getAdresse() {
		if (empty($this->adresse))
			$this->_adresse= " ";
		if ($this->_adresse == null)
			$this->_adresse = htmlspecialchars(ft_decrypt_crypt_information($this->adresse));
		return ($this->_adresse);
	}
	public function getBeneficiaire() {
		return (beneficiaire::getFromPersonnePhysique($this->id_phs));
	}
	public function getBeneficiaireCouple() {
		return (beneficiaire::getCoupleFromPersonnePhysique($this->id_phs));
	}
	public function getBeneficiaireSeul() {
		return (beneficiaire::getSeulFromPersonnePhysique($this->id_phs));
	}
	public function getShortName() {
		return ($this->getCiviliteFormat() . " " . $this->getFirstName() . " " . $this->getName());
	}
	public function getProfilInvestisseur() {
		return (ProfilInvestisseur::getFromPp($this->id_phs));
	}
	public function getLastProfilInvestisseur() {
		return (ProfilInvestisseur::getLastFromPp($this->id_phs));
	}
	public function getHaveSituation () {
		if (
			!empty($this->getLastSituationJuridique) ||
			!empty($this->getLastSituationFinanciere) ||
			!empty($this->getLastSituationFiscale) ||
			!empty($this->getLastSituationPatrimoniale)
		)
			return (true);
		return (false);
	}
	public function getForFrontStore() {
		$rt = [];

		$rt['id'] = $this->id_phs;
		$rt['complementAdresse'] = $this->getComplementAdresse();
		$rt['extension'] = $this->getExtention();
		$rt['numeroRue'] = $this->getNumeroRue();
		$rt['type_voie'] = $this->getTypeVoie();
		$rt['voie'] = $this->getVoie();
		$rt['codePostal'] = $this->getCodePostal();
		$rt['ville'] = $this->getVille();
		$rt['pays'] = $this->getPays();

		return ($rt);
	}

	public function getForStore() {
		$rt = [];
		$rt['id']							= $this->id_phs;
		$rt['id_dh']						= $this->lien_dh;
		$rt['civilite']						= $this->getCivilite();
		$rt['nom']							= $this->getName();
		$rt['nom_jeune_fille']				= $this->getNomJeuneFille();
		$rt['prenom']						= $this->getFirstName();
		$rt['mail']							= $this->getMail();
		$rt['telephone']					= $this->getPhone();
		$rt['indicatif_telephonique']		= $this->getIndicatifPhone();
		$rt['telephone_fixe']				= $this->getPhoneFixe();
		$rt['indicatif_telephonique_fixe']	= $this->getIndicatifPhoneFixe();
		$rt['date_naissance']				= $this->getDateNaissance()->getTimestamp();
		$rt['lieu_naissance']				= $this->getLieuNaissance();
		$rt['nationalite']					= $this->getNationalite();
		$rt['etat_civil']					= $this->getEtatCivil();
		$rt['us_person']					= $this->getUsPerson() ? "1" : "0";
		$rt['politique']					= $this->getPolitiquementExpose() ? "1" : "0";
		$rt['complementAdresse']			= $this->getComplementAdresse();
		$rt['numeroRue']					= $this->getNumeroRue();
		$rt['voie']							= $this->getVoie();
		$rt['type_voie']					= $this->getTypeVoie();
		$rt['codePostal']					= $this->getCodePostal();
		$rt['ville']						= $this->getVille();
		$rt['pays']							= $this->getPays();
		$rt['paysNaissance']				= $this->getPaysNaissance();
		$rt['profession']					= $this->getProfession();
		$rt['id_situation']					= $this->getOrCreateSituation();

		

		$rt['haveBeneficiaireSeul']			= (count($this->getBeneficiaireSeul()) > 0);
		$profil								= ProfilInvestisseur::getLastFromPp($this->id_phs);
		//$rt['profilInvestisseur'] = "test";
		if (!empty($profil))
		{
			$rt['profilInvestisseur'] = $profil->getForStore();
		}
		return ($rt);
	}

    public function getIsChild()
    {
        return ($this->enfant == 1);
    }

    public static function getEnfantsForDh($id_dh)
    {
        return (parent::getFromKeysValues([
            "lien_dh" => $id_dh,
            "enfant" => 1,
        ]));
    }

    public function getDepartRetraite()
    {
        return ($this->depart_retraite);
    }

    public function getContratTravail()
    {
        return $this->contrat_travail;
    }

    public function getAutreContratTravail()
    {
        return ($this->autre_contrat_travail);
    }

    public function getElementParticulier()
    {
        return ($this->element_particulier);
    }

    public function situationSetted()
    {
        return ($this->situation_setted == 1);
    }

	public function getTypeVoie() {
		return ($this->type_voie);
	}

	public function sameAdresse($Pp) {
		return (
			$this->getPays() == $Pp->getPays() &&
			$this->getCodePostal() == $Pp->getCodePostal() &&
			$this->getVille() == $Pp->getVille() &&
			$this->getNumeroRue() == $Pp->getNumeroRue() &&
			$this->getVoie() == $Pp->getVoie() &&
			$this->getTypeVoie() == $Pp->getTypeVoie() &&
			$this->getComplementAdresse() == $Pp->getComplementAdresse()
		);
	}
	public function getConnuMscpi() {
		if (empty($this->connu_mscpi_id))
			return (null);
		return (ConnuMscpi::getFromId($this->connu_mscpi_id)[0]);
	}
	public function getStatusPro() {
		if (empty($this->status_pro_id))
			return (null);
		return (StatusPro::getFromId($this->status_pro_id)[0]);
	}
	public function getCatPro() {
		if (empty($this->cat_pro_id))
			return (null);
		return (CatPro::getFromId($this->cat_pro_id)[0]);
	}
	public function getExtention() {
		return ($this->extension);
	}
	public function getCodeNaissance() {
		return ($this->code_naissance);
	}
	public function checkAuthorisation($dh) {
		return ($dh->id_dh == $this->lien_dh);
	}
	public function getEtatCivilStr() {
		$etat = $this->getEtatCivil();
		if ($etat == "marie")
			return ("Marié");
		else if ($etat == "pacse")
			return ("Pacsé");
		else if ($etat == "celibataire")
			return ("Célibataire");
		else if ($etat == "veuf")
			return ("Veuf");
		else if ($etat == "divorce")
			return ("Divorcé");
		else if ($etat == "unionlibre")
			return ("Union libre");
	}
}
