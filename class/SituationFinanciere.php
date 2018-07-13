<?php
require_once("core/Database.php");
require_once("core/Table.php");

class SituationFinanciere extends Table
{
	protected static		$_name = "SITUATION FINANCIERE";
	protected static		$_primary_key = "id";

	public static function insertNew($id_situation, $date_situation, $date_fin_situation, $revenu_professionnels, $revenu_immobiliers, $revenu_mobiliers, $revenu_autres, $remboursement_mensuel, $duree_remboursement_restante, $nature_autres_emprunts, $montant_autres_emprunts, $duree_autres_emprunts) {

/*
		$req = "INSERT INTO `SITUATION FINANCIERE` (id_situation, date_situation, date_fin_situation, revenu_professionnels, revenu_immobiliers, revenu_mobiliers, revenu_autres, remboursement_mensuel, duree_remboursement_restante, nature_autres_emprunts, montant_autres_emprunts, duree_autres_emprunts)
			VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";
		$data = array(
			$id_situation,
			$date_situation,
			$date_fin_situation,
			$revenu_professionnels,
			$revenu_immobiliers,
			$revenu_mobiliers,
			$revenu_autres,
			$remboursement_mensuel,
			$duree_remboursement_restante,
			$nature_autres_emprunts,
			$montant_autres_emprunts,
			$duree_autres_emprunts
		);
		Situation::getFromId($id_situation)[0]->updateOneColumn("resetSituationFinanciere", 0);
		$id = Database::prepareInsert(static::$_db, $req, $data);
*/
		echo "Cette foncitonalité à été désactivée !";
		exit;
		return ($id);
	}

	public static function insertNew2($id_situation, $date_situation, $date_fin_situation, $revenu_professionnels, $revenu_immobiliers, $revenu_mobiliers, $revenu_autres, $remboursement_mensuel, $duree_remboursement_restante, 
		$residance_montant,
		$residance_duree,
		$locatif_montant,
		$locatif_duree,
		$scpi_montant,
		$scpi_duree,
		$autres_remboursement_montant,
		$autres_remboursement_duree,
		$nature_revenu_autres
	) {
		$dh = Dh::getCurrent();
		if (empty($dh))
			$dh = 0;
		else
			$dh = $dh->id_dh;

		$req = "INSERT INTO `SITUATION FINANCIERE` (id_situation, date_situation, date_fin_situation, revenu_professionnels, revenu_immobiliers, revenu_mobiliers, revenu_autres, remboursement_mensuel, duree_remboursement_restante, 

		residance_montant,
		residance_duree,
		locatif_montant,
		locatif_duree,
		scpi_montant,
		scpi_duree,
		autres_remboursement_montant,
		autres_remboursement_duree,
		nature_revenu_autres,
		creator
		)
			VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?,
			 ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";
		$data = array(
			$id_situation,
			$date_situation,
			$date_fin_situation,
			$revenu_professionnels,
			$revenu_immobiliers,
			$revenu_mobiliers,
			$revenu_autres,
			$remboursement_mensuel,
			$duree_remboursement_restante,
			$residance_montant,
			$residance_duree,
			$locatif_montant,
			$locatif_duree,
			$scpi_montant,
			$scpi_duree,
			$autres_remboursement_montant,
			$autres_remboursement_duree,
			$nature_revenu_autres,
			$dh
		);
		Situation::getFromId($id_situation)[0]->updateOneColumn("resetSituationFinanciere", 0);
		$id = Database::prepareInsert(static::$_db, $req, $data);
		return ($id);
	}
	public static function updateOne($id, $date_situation, $date_fin_situation, $revenu_professionnels, $revenu_immobiliers, $revenu_mobiliers, $revenu_autres, $remboursement_mensuel, $duree_remboursement_restante, $nature_autres_emprunts, $montant_autres_emprunts, $duree_autres_emprunts) {
		$req = "UPDATE `SITUATION FINANCIERE` SET date_situation = ?, date_fin_situation = ?, revenu_professionnels = ?, revenu_immobiliers = ?, revenu_mobiliers = ?, revenu_autres = ?, remboursement_mensuel = ?, duree_remboursement_restante = ?, nature_autres_emprunts = ?, montant_autres_emprunts = ?, duree_autres_emprunts = ? WHERE id = ?";
		$data = array(
			$date_situation,
			$date_fin_situation,
			$revenu_professionnels,
			$revenu_immobiliers,
			$revenu_mobiliers,
			$revenu_autres,
			$remboursement_mensuel,
			$duree_remboursement_restante,
			$nature_autres_emprunts,
			$montant_autres_emprunts,
			$duree_autres_emprunts,
			$id
		);
		$id = Database::prepareInsert(static::$_db, $req, $data);
		return ($id);
	}
	public static function getFromPdId($PpId) {
		return (parent::getFromKeyValue("id_situation", $PpId));
	}
	public static function getLastFromPpId($PpId) {
		$req = "SELECT * FROM `" . self::$_name . "` WHERE id_situation = ? ORDER BY date_situation DESC LIMIT 1";
		$data = array($PpId);
		$rt = Database::prepare(static::$_db, $req, $data, 'SituationFinanciere');
		if (count($rt))
			return ($rt[0]);
		else
			return (null);
	}
	public static function getFromDh($id_dh) {
		$req = "SELECT `SITUATION FINANCIERE`.* FROM `SITUATION FINANCIERE` INNER JOIN `situation` ON `SITUATION FINANCIERE`.id_situation = `situation`.id WHERE `situation`.id_dh = ?";
		$data = array(
			$id_dh
		);
		return Database::prepare(static::$_db, $req, $data, 'SituationFinanciere');
	}
	public function getDateSituation() {
		$rt = new DateTime();
		$rt = $rt->setTimestamp($this->date_situation);
		return ($rt);
	}
	public function getDateFinSituation() {
		$rt = new DateTime();
		$rt = $rt->setTimestamp($this->date_fin_situation);
		return ($rt);
	}
	public function getRevenuProfessionnels() {
		return ($this->revenu_professionnels);
	}
	public function getRevenuImmobiliers() {
		return ($this->revenu_immobiliers);
	}
	public function getRevenuMobiliers() {
		return ($this->revenu_mobiliers);
	}
	public function getRevenuAutres() {
		return ($this->revenu_autres);
	}
	public function getNatureRevenuAutres() {
		return (htmlspecialchars($this->nature_revenu_autres));
	}
	public function getRemboursementMensuel() {
		return ($this->remboursement_mensuel);
	}
	public function getDureeRemboursementRestante() {
		return ($this->duree_remboursement_restante);
	}
	public function getNatureAutresEmprunts() {
		return ($this->nature_autres_emprunts);
	}
	public function getMontantAutresEmprunts() {
		return ($this->montant_autres_emprunts);
	}
	public function getDureeAutresEmprunts() {
		return ($this->duree_autres_emprunts);
	}
	public function getMontantResidence() {
		return ($this->residance_montant);
	}
	public function getDureeResidence() {
		return ($this->residance_duree);
	}

	public function getMontantLocatif() {
		return ($this->locatif_montant);
	}
	public function getDureeLocatif() {
		return ($this->locatif_duree);
	}

	public function getMontanScpi() {
		return ($this->scpi_montant);
	}
	public function getDureeScpi() {
		return ($this->scpi_duree);
	}

	public function getHabitation() {
		return ($this->habitation);
	}

	public function getMontantLoyer() {
		if (empty($this->loyer_montant))
			return (0);
		return ($this->loyer_montant);
	}
	public function getMontantConsommation() {
		if (empty($this->consommation_montant))
			return (0);
		return ($this->consommation_montant);
	}
	public function getDureeConsommation() {
		if (empty($this->consommation_duree))
			return (0);
		return ($this->consommation_duree);
	}

	public function getMontantAutres2() {
		return ($this->autres_remboursement_montant);
	}
	public function getDureeAutres2() {
		return ($this->autres_remboursement_duree);
	}

	public function haveAutre() {
		return (
			$this->remboursement_mensuel > 0 ||
			$this->residance_montant > 0 ||
			$this->locatif_montant > 0 ||
			$this->scpi_montant > 0 ||
			$this->autres_remboursement_montant > 0
		);
	}
	public function isValide() {
		return (time() < ($this->getDateSituation()->getTimestamp() + TIME_SITUATION_VALID));
	}
	public function getAutresCharges() {
	    return (intval($this->autres_charges));
    }
	public static function getFromDhForStore($id_dh) {
		//return (self::getFromDh($id_dh));
		$rt = [];
		foreach (self::getFromDh($id_dh) as $key => $elm)
		{
			$rt[] = $elm->getForStore();
		}
		return ($rt);
	}
	public function getForStore() {
		$rt = $this;
		$rt->creatorShortName = $this->getCreatorStr();
		return ($rt);
	}
	public function getCreatorStr() {
		if ($this->creator == 0)
			return ("-");
		return (Dh::getById($this->creator)->getShortName());
	}
	public function getCharges() {
		$rt = 
			$this->residance_montant +
			$this->locatif_montant +
			$this->scpi_montant +
			$this->consommation_montant +
			$this->autres_remboursement_montant +
			$this->autres_charges
			;
		if ($this->habitation == 3)
			$rt += $this->loyer_montant;
		else if ($this->habitation == 2)
			$rt += $this->remboursement_mensuel;
		return ($rt);
	}
	public function getRevenu() {
		return (
			$this->getRevenuProfessionnels() +
			$this->getRevenuImmobiliers() +
			$this->getRevenuMobiliers() +
			$this->getRevenuAutres()
		);
	}
	public function getTauxDEndettement() {
		if ($this->getRevenu() > 0)
			return (100 * $this->getCharges() / $this->getRevenu());
		else
			return (100);
	}
}
