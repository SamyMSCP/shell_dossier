<?php
require_once("core/Database.php");
require_once("core/Table.php");
require_once("Nuepropriete.php");
require_once("Usefruit.php");
require_once("Scpi.php");


function sortTransaction($a, $b)
{
	return ($a->id_excel > $b->id_excel);
}

function sortByDateTransaction($a, $b) {
	return ($a->enr_date < $b->enr_date);
}

class Transaction extends Table
{
	use DocumentTrait;
	protected static		$_name = "TRANSACTION";
	protected static		$_primary_key = "id";
	private					$_purchase;
	private					$_valorisation = null;
	private					$_actualValue;
	private					$_decrypted_enr_date = null;
	private					$_decrypted_enr_dateOne = null;
	private					$_dh = null;
	private					$_beneficiaire = null;
	private					$_conseiller = null;
	public static			$_noSecure= ['debut_valorisation', 'debut_dividendes', 'fin_dividendes'];

	private					$_excelDateEntreeJouissance = null;
	private					$_excelDateFinJouissance = null;
	private					$_excelDateBs = null;
	private					$_mscpiTable = null;
	private					$_delaiJouissance = null;
	protected static		$_marche = ['Primaire','Secondaire','Gré à gré'];
	protected static		$_typepro = ['Pleine propriété', 'Nue propriété', 'Usufruit'];
	protected static 		$_demembrement = ['Temporaire', 'Viager'];

	public $prix_part;
	public $nbr_part;
	public function getEndDemembrement() {
		return (Nuepropriete::getInstance()->getDateFinDemembrement($this));
	}


	public function getAllForStore() {
//		$req = "SELECT * FROM (SELECT * FROM (SELECT *  FROM `TRANSACTION` AS `ts`) t1 INNER JOIN (SELECT `id_transaction`, `status_sub`, `status_sup` FROM `StatusTransaction` AS `st` ORDER BY `date_creation` DESC) t2 ON `t1`.`id` = `t2`.`id_transaction` INNER JOIN `DONNEUR D'ORDRE` AS `dh` ON `dh`.`id_dh` = `t1`.`id_donneur_ordre` INNER JOIN `PERSONNE PHYSIQUE` AS `pp` ON `pp`.`id_phs` = `dh`.`lien_phy` ORDER BY `status_sup` AND `status_sub`) t_all GROUP BY `id_transaction`";
		$req = "SELECT * FROM `TRANSACTION`";
		$all =  Database::prepare(static::$_db, $req, [], "Transaction");
        foreach ($all as $key => $elm) {
            $nbr_part = ($elm->nbr_part);

            if($elm->cle_repartition != null){

                $cle_repartition=ft_decrypt_crypt_information($elm->cle_repartition);
            }
            else $cle_repartition="";
            $type_pro = $elm->type_pro;
            if($type_pro != null && ft_decrypt_crypt_information($type_pro) == "Nue propriété"){
                $prix_part = $elm->prix_part*$cle_repartition/100;
                $montant_invest=$nbr_part*$prix_part;
            }
            else if($type_pro != null && ft_decrypt_crypt_information($type_pro) == "Usufruit"){
                $cle_repartition=(100 - $cle_repartition);
                $prix_part = $elm->prix_part*$cle_repartition/100;
                $montant_invest=$nbr_part*$prix_part;
            }
            else{
                $prix_part = $elm->prix_part;
                $montant_invest=$nbr_part*$prix_part;
            }

            $req = "SELECT `id_transaction`, `status_sub`, `status_sup`, `status_mois` FROM `StatusTransaction` WHERE `id_transaction` = :id ORDER BY `date_creation` DESC";
            $b = Database::prepare(static::$_db, $req, ['id' => $elm->id], get_called_class());
//			var_dump($b);
            if (count($b) == 0) {
                $b['status_sub'] = 0;
                $b['status_sup'] = 0;
            }
            else
                $b = ['status_sup' => $b[0]->status_sup, 'status_sub' => $b[0]->status_sub, 'status_mois' => $b[0]->status_mois];
            ;
            $all[$key] = (object)array_merge((array)$all[$key], (array)$b);

            $req = "SELECT `id_dh`, `day`, `login`, `conseiller`, `non_sollicitation_par_mail`, `lien_phy` FROM `DONNEUR D'ORDRE` WHERE `id_dh` = :id";
            $c = Database::prepare(static::$_db, $req, ['id' => $all[$key]->id_donneur_ordre], get_called_class());
            $all[$key] = (object)array_merge((array)$all[$key], (array)$c[0]);

            $req = "SELECT  `id_phs`,`civilite`, `prenom`,`nom` FROM `PERSONNE PHYSIQUE` WHERE `id_phs` = :id";
//			var_dump($c);
            $d = Database::prepare(static::$_db, $req, ['id' => $all[$key]->lien_phy], get_called_class());
            $all[$key] = (object)array_merge((array)$all[$key], (array)$d[0]);
            $all[$key]->nbr_part = floatval($nbr_part);
            $all[$key]->prix_part = floatval($prix_part);
            $all[$key]->montant_investissement = $montant_invest;
            $all[$key]->cle_repartition = $cle_repartition;
		}
//		return ($all);
		foreach ($all as $key => $elm)
		{
			try {
				$elm->Name = (is_null($elm->Name) ? "" : ft_decrypt_crypt_information($elm->Name));
				$elm->type_pro = (is_null($elm->type_pro) ? "" : ft_decrypt_crypt_information($elm->type_pro));
				$elm->marcher = (is_null($elm->marcher) ? "" : ft_decrypt_crypt_information($elm->marcher));
				$elm->prenom = (is_null($elm->prenom) ? "" : ft_decrypt_crypt_information($elm->prenom));
				$elm->nom = (is_null($elm->nom) ? "" : ft_decrypt_crypt_information($elm->nom));
				$elm->civilite = (is_null($elm->civilite) ? "" : ft_decrypt_crypt_information($elm->civilite));
				$elm->commentaire = (is_null($elm->commentaire) ? "" : ft_decrypt_crypt_information($elm->commentaire));
				$elm->conseillerr = (is_null($elm->conseiller) ? "" : Pp::getFromId($elm->conseiller));
				if($elm->conseillerr != null){
				    if($elm->conseillerr[0]->getName() != "AZAM"){
                        $elm->conseillerrr=$elm->conseillerr[0]->getShortName();
                    }
                    else{
                        $elm->conseillerrr="M. Samuel MARTEL";
                    }
                }
				$tmp = DateTime::createFromFormat("d/m/Y", (is_null($elm->enr_date) ? "" : ft_decrypt_crypt_information($elm->enr_date)));
				if ($tmp === False)
					$elm->enr_date = 0;
				else
					$elm->enr_date = $tmp->getTimestamp();

				$tmp = DateTime::createFromFormat("Y/m/d", (is_null($elm->date_edit_trans) ? "" : ft_decrypt_crypt_information($elm->date_edit_trans)));
				$tmp = strtotime($elm->date_edit_trans);
				if ($tmp === False)
					$elm->date_edit_trans = 0;
				else
					$elm->date_edit_trans = $tmp;
			}
			catch (Exception $e) {
				$elm->Name = "";
				$elm->type_pro = "";
				$elm->marcher = "";
				$elm->enr_date = 0;
				$elm->date_edit_trans = 0;
			}
			$elm->date_edit_trans = ($elm->date_edit_trans == false) ? 0 : $elm->date_edit_trans;
			$elm->enr_date = ($elm->enr_date == false) ? 0 : $elm->enr_date;
            $elm->date_valid = date('m', $elm->enr_date);
            $all[$key] = $elm;
		}
		usort($all, 'sortByDateTransaction');
		return ($all);
	}

	public function getAllStatus($sup, $sub) {
		if ($sub != -1)
		{
//			$req = "SELECT * FROM `TRANSACTION` AS `ts`, `StatusTransaction` AS `st` WHERE `status_sup` = :sup AND `status_sub` = :sub  AND `st`.`id_transaction` = `ts`.`id`";
//			$req = "SELECT * FROM `TRANSACTION` AS `ts` INNER JOIN `StatusTransaction` AS `st` ON `st`.`id_transaction` = `ts`.`id` INNER JOIN `DONNEUR D'ORDRE` AS `dh` ON `dh`.`id_dh` = `ts`.`id_donneur_ordre` INNER JOIN `PERSONNE PHYSIQUE` AS `pp` ON `pp`.id_phs = `dh`.`lien_phy` WHERE `status_sup` = :sup AND `status_sub` = :sub";
			$req = "SELECT * FROM (SELECT * FROM  (SELECT *  FROM `TRANSACTION` AS `ts`) t1 INNER JOIN (SELECT `status_sub`, `status_sup`, `id_transaction` FROM `StatusTransaction` AS `st` WHERE `id_transaction` = 5202 ORDER BY `date_creation` DESC LIMIT 1) t2 ON `t1`.`id` = `t2`.`id_transaction` INNER JOIN `DONNEUR D'ORDRE` AS `dh` ON `dh`.`id_dh` = `t1`.`id_donneur_ordre` LIMIT 1) t_all WHERE t_all.`status_sup` = :sup AND t_all.`status_sub` = :sub";
			$all =  Database::prepare(static::$_db, $req, ['sup' => $sup, 'sub' => $sub], "Transaction");
		}
		else {
			$req = "SELECT * FROM (SELECT * FROM  (SELECT *  FROM `TRANSACTION` AS `ts`) t1 INNER JOIN (SELECT `status_sub`, `status_sup`, `id_transaction` FROM `StatusTransaction` AS `st` WHERE `id_transaction` = 5202 ORDER BY `date_creation` DESC LIMIT 1) t2 ON `t1`.`id` = `t2`.`id_transaction` INNER JOIN `DONNEUR D'ORDRE` AS `dh` ON `dh`.`id_dh` = `t1`.`id_donneur_ordre` LIMIT 1) t_all WHERE t_all.`status_sup` = :sup";
			$all =  Database::prepare(static::$_db, $req, ['sup' => $sup], "Transaction");
		}
		foreach ($all as $key => $elm) {
			try {
				$elm->Name = (is_null($elm->Name) ? "" : ft_decrypt_crypt_information($elm->Name));
				$elm->type_pro = (is_null($elm->type_pro) ? "" : ft_decrypt_crypt_information($elm->type_pro));
				$elm->marcher = (is_null($elm->marcher) ? "" : ft_decrypt_crypt_information($elm->marcher));
				$elm->prenom = (is_null($elm->prenom) ? "" : ft_decrypt_crypt_information($elm->prenom));
				$elm->nom = (is_null($elm->nom) ? "" : ft_decrypt_crypt_information($elm->nom));
				$elm->civilite = (is_null($elm->civilite) ? "" : ft_decrypt_crypt_information($elm->civilite));
//				echo ft_decrypt_crypt_information($elm->enr_date);
//				die();
				$tmp = DateTime::createFromFormat("d/m/Y", (is_null($elm->enr_date) ? "" : ft_decrypt_crypt_information($elm->enr_date)));
				if ($tmp === False)
					$elm->enr_date = 0;
				else
					$elm->enr_date = $tmp->getTimestamp();

				$tmp = DateTime::createFromFormat("Y/m/d", (is_null($elm->date_edit_trans) ? "" : ft_decrypt_crypt_information($elm->date_edit_trans)));
				$tmp = strtotime($elm->date_edit_trans);
				if ($tmp === False)
					$elm->date_edit_trans = 0;
				else
					$elm->date_edit_trans = $tmp;
			} catch (Exception $e) {
				$elm->Name = "";
				$elm->type_pro = "";
				$elm->marcher = "";
				$elm->enr_date = 0;
				$elm->date_edit_trans = 0;
			}
			$elm->date_edit_trans = ($elm->date_edit_trans == false) ? 0 : $elm->date_edit_trans;
			$elm->enr_date = ($elm->enr_date == false) ? 0 : $elm->enr_date;
			$all[$key] = $elm;
		}
		usort($all, 'sortByDateTransaction');
		return ($all);
	}

	public function getDelaiJouissance() {
		if ($this->_delaiJouissance == null)
		{
			$this->_delaiJouissance = DelaiJouissance::createFromTransaction($this);
		}
		return ($this->_delaiJouissance);
	}
	public static function insertForStore($id_dh, $id_projet, $info_trans)
	{
		foreach (Scpi::getAll() as $elm)
		{
			$id_scpi = $elm->id;
			break ;
		}
		$req = "INSERT INTO `TRANSACTION` (id_donneur_ordre, type_transaction, info_trans, id_scpi, type_pro)
			VALUES (?, ?, ?, ?, ?)";
		$rt = Database::prepareInsert(static::$_db, $req, [
			$id_dh, "A", $info_trans, $id_scpi, ft_crypt_information("Pleine propriété")
		]);
		return ($rt);
	}
	public static function insertOtherTransactionPleine($id_dh,
		$info,
		$date,
		$marche,
		$type_pro,
		$nbr_part,
		$prix_part,
		$id_scpi,
		$name,
		$dt,
		$cle,
		$viager,
		$montant_emprunt,
		$duree_emprunt,
		$date_debut_emprunt,
		$taux_emprunt,
		$mensualite_emprunt
	) {
	// public static function insertOtherTransactionPleine($id_dh, $info, $date, $marche, $type_pro, $nbr_part, $prix_part, $id_scpi, $name, $dt, $cle, $viager, $montant_emprunt, $duree_emprunt, $date_debut_emprunt, $taux_emprunt, $mensualite_emprunt) {
		$req = "INSERT INTO `TRANSACTION`(id_donneur_ordre, info_trans, enr_date, marcher, type_pro, nbr_part, prix_part, id_scpi, Name, dt, cle_repartition, viager, montant_emprunt, duree_emprunt, date_debut_emprunt, taux_emprunt, mensualite_emprunt, type_transaction) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
		$data = array(
			$id_dh,
			$info,
			$date,
			$marche,
			$type_pro, // chiffrée
			floatval($nbr_part),
			floatval($prix_part),
			intval($id_scpi),
			$name, // chiffrée
			$dt,
			$cle, // chiffrée
			$viager,
			$montant_emprunt,
			$duree_emprunt,
			$date_debut_emprunt,
			$taux_emprunt,
			$mensualite_emprunt,
			"A"
		);
		$rt = Database::prepareInsert(static::$_db, $req, $data);
		if (!empty($rt))
			self::getFromId($rt)[0]->setDebutFinValorisationDividendes();
		return ($rt);

	}
	public static function checkMutexTransaction($id) {
		if (empty($id))
			return (0);
		$id = intval($id);
		$rt = parent::getFromKeysValues(
			array(
				"id_excel" => $id
			)
		);
		return (count($rt));
	}

	public static function setTransactionAbsorbedByScpi($id_scpi_absorbed, $id_scpi_parent) {
		$req = "UPDATE `TRANSACTION` SET id_scpi_parent = ? WHERE id_scpi = ? AND id_scpi_parent IS NULL";
		$data = array(
			$id_scpi_parent,
			$id_scpi_absorbed
		);
		return Database::prepareNoClass(static::$_db, $req, $data);
	}
	public static function setTransactionAbsorbedById($id, $id_scpi_parent) {
		$req = "UPDATE `TRANSACTION` SET id_scpi_parent = ? WHERE id = ? AND id_scpi_parent IS NULL";
		$data = array(
			$id_scpi_parent,
			$id
		);
		return Database::prepareNoClass(static::$_db, $req, $data);
	}
	public static function getTransactionAbsorbed() {
		return (parent::getFromArray("id_scpi_parent", array("NOT NULL")));
	}

	public static function setTransactionById($id, $commentaire, $marcher, $effectuer, $scpi_name, $id_scpi, $date, $nbr_part, $prix, $type_pro, $dt, $cle) {
		$req = "UPDATE `TRANSACTION` SET commentaire = ?, marcher = ?, info_trans = ?, Name = ?,
		id_scpi = ?, enr_date = ?, nbr_part = ?, prix_part = ?, type_pro = ?, dt = ?, cle_repartition = ? , date_edit_trans = CURRENT_TIMESTAMP WHERE id = ?";
		$data = array($commentaire, $marcher, $effectuer, $scpi_name, $id_scpi, $date, $nbr_part, $prix, $type_pro, $dt, $cle,
		$id
		);
		$rt = Database::prepareNoClass(static::$_db, $req, $data);
		if (!empty($rt))
			self::getFromId($rt)[0]->setDebutFinValorisationDividendes();
		return ($rt);
	}
	
	public static function getTransactionAbsorbedNotComplete() {
		$req = "SELECT * FROM `TRANSACTION` WHERE id_scpi_parent IS NOT NULL AND id_transaction_absorption IS NULL";
		$data = array(
			$id_dh
		);
		return Database::prepare(static::$_db, $req, $data, "Transaction");
	}
	public static function getTransactionAbsorbedFromDh($id_dh) {
		$req = "SELECT * FROM `TRANSACTION` WHERE id_scpi_parent IS NOT NULL AND id_donneur_ordre = ?";
		$data = array(
			$id_dh
		);
		return Database::prepare(static::$_db, $req, $data, "Transaction");
	}
	public static function getTransactionAbsorbedNotCompleteFromDh($id_dh) {
		$req = "SELECT * FROM `TRANSACTION` WHERE id_scpi_parent IS NOT NULL AND id_donneur_ordre = ? AND id_transaction_absorption IS NULL";
		$data = array(
			$id_dh
		);
		return Database::prepare(static::$_db, $req, $data, "Transaction");
	}
	public static function getTransactionAbsorbedComplete() {
		$req = "SELECT * FROM `TRANSACTION` WHERE id_scpi_parent IS NOT NULL AND id_transaction_absorption IS NOT NULL";
		$data = array(
			$id_dh
		);
		return Database::prepare(static::$_db, $req, $data, "Transaction");
	}
	public function getCompletionAbsorption() {
		return (($this->getAbsorption()->after_nbr_part * $this->getNbrPart()) % $this->getAbsorption()->before_nbr_part);
	}
	public static function getTransactionAbsorbedCompleteFromDh($id_dh) {
		$req = "SELECT * FROM `TRANSACTION` WHERE id_scpi_parent IS NOT NULL AND id_donneur_ordre = ? AND id_transaction_absorption IS NOT NULL";
		$data = array(
			$id_dh
		);
		return Database::prepare(static::$_db, $req, $data, "Transaction");
	}
	public function isPleinePro() {
		if(strstr($this->getTypePro(), "Pleine"))
			return (true);
		return (false);
	}
	public function isNuePro() {
		if(strstr($this->getTypePro(), "Nue"))
			return (true);
		return (false);
	}
	public function isUsufruit() {
		if(strstr($this->getTypePro(), "Usu"))
			return (true);
		return (false);
	}
	public static function createNewSellTransaction($id_achat, $date, $nbr_part, $prix_part, $data, $isAjax = 0) {

		if (!($date instanceof DateTime))
		{
			$dateVal = DateTime::createFromFormat("Y-m-d", $date);
			if (!($dateVal instanceof DateTime))
				$dateVal = DateTime::createFromFormat("d/m/Y", $date);
			$date = $dateVal;
		}

		if (!is_float($nbr_part))
			$nbr_part = floatval(str_replace(',','.',$nbr_part));
		if (!is_float($prix_part))
			$prix_part = floatval(str_replace(',','.',$prix_part));

		$buying = self::getById($id_achat);
		if($buying->id_donneur_ordre != Dh::getCurrent()->id_dh) {
			if ($isAjax)
				error("La transaction que vous essayez de vendre ne vous appartient pas.");
			Notif::set("Vente de parts", "La transaction que vous essayez de vendre ne vous appartient pas.");
			return (false);
		}
		if(strstr($buying->getTypePro(), "Usu")) {
			if ($isAjax)
				error("Vous ne pouvez pas vendre des parts en usufruit.");
			Notif::set("Vente de parts", "Vous ne pouvez pas vendre des parts en usufruit");
			return (false);
		}
		if($date > new DateTime('+1 hour')) {
			if ($isAjax)
				error("Vous ne pouvez pas déclarer une vente de parts future. Veuillez faire un projet de vente de parts.");
			Notif::set("Vente de parts", "Vous ne pouvez pas déclarer une vente de parts future. Veuillez faire un projet de vente de parts.");
			return (false);
		}
		if (strstr($buying->getTypePro(), "Nue") && $buying->getDateDebutDividendes() > $date) {
			if ($isAjax)
				error("Vous ne pouvez pas vendre des parts en Nue propriété avant la fin du démembrement.");
			Notif::set("Vente de parts", "Vous ne pouvez pas vendre des parts en Nue propriété avant la fin du démembrement.");
			return (false);
		}
		$good = null;
		foreach ($data as $key => $elm1) {
			if ($key == "precalcul")
				continue ;
			foreach($elm1 as $key2 => $elm)
			{
				if ($key2 == "precalcul")
					continue ;

				if (
					strstr($buying->getTypePro(), $key2) && 
					intval($elm['precalcul']['scpi']->id) === intval($buying->id_scpi)
				) {
					if ($nbr_part > $elm['precalcul']['nbr_part']) {
						if ($isAjax)
							error("Vous ne pouvez pas informer une vente de part plus grande que le nombre de parts que vous détenez.");
						Notif::set("Vente de parts", "Vous ne pouvez pas informer une vente de part plus grande que le nombre de parts que vous détenez.");
						return (false);
					}
					//error($elm['precalcul']['nbr_part']);
					if (
						($nbr_part <= 0) ||
						($prix_part<= 0) ||
						($date < DateTime::createFromFormat("d/m/Y", ft_decrypt_crypt_information($buying->enr_date)))
					) {
						if ($isAjax)
							error("Il y a eu un probleme. La transaction n'a pas été enregistrée");
						Notif::set("VenteTransactionDetail", "Il y a eu un probleme. La transaction n'a pas été enregistrée");
						//echo "bug nbr part ... ";
						return (false);
					}
					$req = "INSERT INTO `TRANSACTION`(
						id_donneur_ordre,
						marcher,
						type_pro,
						dt,
						cle_repartition,
						Name,
						id_scpi,
						id_projet,
						nbr_part,
						status_trans,
						enr_date,
						nbr_part_vente,
						prix_part,
						prix_part_vente,
						id_transaction_achat,
						type_transaction
					) VALUES (
						?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?
					)";
					$data = array(
						$buying->id_donneur_ordre,
						$buying->marcher,
						$buying->type_pro,
						$buying->dt,
						$buying->cle_repartition,
						$buying->Name,
						$buying->id_scpi,
						$buying->id_projet,
						-intval($nbr_part),
						6,
						ft_crypt_information($date->format("d/m/Y")),
						$nbr_part,
						$buying->prix_part,
						$prix_part,
						$id_achat,
						"V"
					);
					$rt = Database::prepareInsert(static::$_db, $req, $data);
					return ($rt);
				}
			}
		}
		//exit();
		if ($isAjax)
			error("L'enregistrement de la transaction a echoue");
		Notif::set("VenteTransaction", "L'enregistrement de la transaction a echoue");
		return (false);
	}
	public static function getOnProperty($prop, $lst) {
		$rt = array();
		foreach($lst as $elm) {
			array_push($rt, $elm->$prop);
		}
		return ($rt);
	}
	public static function getNameOnProperty($lst) {
		$rt = array();
		foreach($lst as $elm) {
			array_push($rt, "%" . $elm->getScpi()->name . "%");
		}
		return ($rt);
	}
	public static function getLstScpiId($lst) {
		$rt = array();
		foreach($lst as $elm) {
			array_push($rt, $elm->getScpi()->id);
		}
		return ($rt);
	}
	public static function create() {
		$rt = new Transaction();
		$rt->_is_new = 1;
		return ($rt);
	}
	public static function getById($id) {
		if (!($tr = parent::getFromKeyValue("id", $id)))
			return false;
		return $tr[0];
	}
	public function getId() {
		return $this->id;
	}
	public function getScpiId() {
		return $this->id_scpi;
	}
	public function getScpi() {
		return (Scpi::getFromId($this->id_scpi));
	}
	public function getAbsorption() {
		return (absorption::getFromScpiId($this->id_scpi));
	}
	public function getResteAbsorption() {
		
	}
	public function getScpiParent() {
		return (Scpi::getFromId($this->id_scpi_parent));
	}
	public function getDistinctTransaction($id) {
		
		$req = "SELECT *, SUM(prix_part * nbr_part) as res, SUM(prix_part) as sum_prix_part, SUM(nbr_part) as sum_nbr_part FROM `TRANSACTION` WHERE id_donneur_ordre = :id_dh GROUP BY id_scpi  ORDER BY (nbr_part * prix_part) DESC";
		return Database::prepare(static::$_db, $req, array("id_dh" => $id), get_called_class());
	}
	public function getDistinctTransactionBeneficiaire($id) {
		
		$req = "SELECT *, SUM(prix_part * nbr_part) as res, SUM(prix_part) as sum_prix_part, SUM(nbr_part) as sum_nbr_part FROM `TRANSACTION` WHERE id_beneficiaire = :id_beneficiaire GROUP BY id_scpi ORDER BY (nbr_part * prix_part) DESC";
		return Database::prepare(static::$_db, $req, array("id_beneficiaire" => $id), get_called_class());
	}
	public function getDistinctTransactionTypePro($id) {
		
		$req = "SELECT *, SUM(prix_part * nbr_part) as res, SUM(prix_part) as sum_prix_part, SUM(nbr_part) as sum_nbr_part FROM `TRANSACTION` WHERE id_donneur_ordre = :id_dh GROUP BY id_scpi  ORDER BY (nbr_part * prix_part) DESC";
		return Database::prepare(static::$_db, $req, array("id_dh" => $id), get_called_class());
	}
	public function getDistinctTransactionTypeProModal() {
		
		$req = "SELECT * FROM `TRANSACTION` WHERE id_donneur_ordre = :id_dh AND type_pro = :type_pro AND Name = :Name";
		return Database::prepare(static::$_db, $req, array("id_dh" => $this->id_donneur_ordre, "type_pro" => $this->type_pro, "Name" => $this->Name), get_called_class());
	}
	public function getPurchase() {
		if ($this->_purchase == null)
		{
			$this->_purchase = $this->res;
		}
		return $this->_purchase;
	}
	public function getactualvalue() {
		if ($this->_actualValue == null)
		{
			$this->_actualValue = scpi::getfromid($this->id_scpi)->prix_vendeur * $this->sum_nbr_part;
		}
		return $this->_actualValue;
	}
	public function getactualvalueonepart() {
		if ($this->_actualValue == null)
		{
			$this->_actualValue = scpi::getfromid($this->id_scpi)->prix_vendeur;
		}
		return $this->_actualValue;
	}
	public function getPlusMoinValue() {
		if (!isset($this->_plusMoinValue)) {
			if ($this->getMontanInvestissement() != 0)
				$this->_plusMoinValue = (100 * $this->getMontantGlobalDeRevente() / $this->getMontanInvestissement()) - 100;
			else
				$this->_plusMoinValue = "-";
		}
		return ($this->_plusMoinValue);
	}
	public function getPlusMoinValueEuro() {
		if (!isset($this->_plusMoinValueEuro)) {
			if ($this->getMontanInvestissement() != 0)
				$this->_plusMoinValueEuro = $this->getMontantGlobalDeRevente() - $this->getMontanInvestissement();
			else
				$this->_plusMoinValueEuro = "-";
		}
		return ($this->_plusMoinValueEuro);
	}
	public function getMontanInvestissement() {
		if (!isset($this->_montantInvestissement)) {
			if (!empty(strstr(ft_decrypt_crypt_information($this->type_pro), "Usufruit")))
				$this->_montantInvestissement = ($this->prix_part * $this->getNbrPart() * $this->getClefRepartition() / 100);
			else if(!empty(strstr(ft_decrypt_crypt_information($this->type_pro), "Nue")))
				$this->_montantInvestissement = ($this->prix_part * $this->getNbrPart() * $this->getClefRepartition() / 100);
			else
				$this->_montantInvestissement = $this->getNbrPart() * $this->prix_part;
		}
		return ($this->_montantInvestissement);
	}
	public function getMontantGlobalDeRevente() {
		if (!isset($this->_montantGlobalDeRevente)) {
			if ($this->getTypeTransaction() != "V") {
				if (!empty(strstr(ft_decrypt_crypt_information($this->type_pro), "Usufruit")))
					$this->_montantGlobalDeRevente = ($this->getUsufruit() * $this->getNbrPart());
				else if(!empty(strstr(ft_decrypt_crypt_information($this->type_pro), "Nue")))
					$this->_montantGlobalDeRevente = ($this->getNuePropriete() * $this->getNbrPart());
				else
					$this->_montantGlobalDeRevente = ($this->getActualValueOne());
			} else {
				$this->_montantGlobalDeRevente = ($this->nbr_part_vente * $this->prix_part_vente);
			}
		}
		return ($this->_montantGlobalDeRevente);
	}

	public function precalcul() {
		//$this->Nuepropriete = $this->getNuePropriete() * $this->nbr_part;
		//$this->Usufruit = $this->getUsufruit() * $this->nbr_part;
		$this->Nuepropriete = $this->getValorisationAtTimestamp(today());
		$this->Usufruit = $this->getValorisationAtTimestamp(today());
	}

	public function getNuePropriete() {
		if ($this->getEnrDate() instanceof DateTime)
			return (Nuepropriete::getInstance()->getVal($this));
		return (NULL);
	}
	public function getUsufruit() {
		if ($this->getEnrDate() instanceof DateTime)
		return (
			Usefruit::getInstance()->getUsefruit(
				$this->id_scpi,
				$this->getClefRepartition(),
				$this->prix_part,
				$this->dt,
				ft_decrypt_crypt_information($this->enr_date)
			)
		);
		return (NULL);
	}

	public function getNbrPart () {
		if ($this->getTypeTransaction() != "V")
			return ($this->nbr_part);
		return (-$this->nbr_part);
	}
	public function getActualValueOne() {
		return $this->_actualvalue = scpi::getfromid($this->id_scpi)->prix_vendeur * $this->nbr_part;
	}
	public function getName() {
		$scpi = Scpi::getFromId($this->id_scpi);
		return ($scpi->getName());
		//return ft_decrypt_crypt_information($this->Name);
	}
	public function getTypePro() {
		if (empty($this->type_pro))
			return ("Pleine propriété");
		//return ("Usu");
		return ft_decrypt_crypt_information($this->type_pro);
	}
	public function getTypeProForTable() {
		$rt = $this->getTypePro();
		if ($rt == "Pleine propriété")
			return ("PP");
		else if ($rt == "Nue propriété")
			return ("NU");
		else if ($rt == "Usufruit")
			return ("US");
	}
	public function getClefRepartition() {
        $rt = $this->getTypePro();
		if (empty($this->cle_repartition))
			return (100);
        if ($rt == "Pleine propriété")
            return (100);
		if (!isset($this->_clefRepartition)){
			$this->_clefRepartition = ft_decrypt_crypt_information($this->cle_repartition);
			if (strstr($this->getTypePro(), "Usu"))
				$this->_clefRepartition = 100 - $this->_clefRepartition;
		}
		return ($this->_clefRepartition);
	}
	public function getDemembrement() {
		return ($this->dt);
	}
	public function getDemembrementStr() {
		if ($this->isPleinePro())
			return ("-");
		if ($this->getDemembrement() == 0)
			return ("Viager");
		return ($this->dt);
	}
	public function getDemembrementJours() {
		if ($this->getDemembrement() <= 0)
			return (0);
		$debut = $this->getDelaiJouissance()->getPriseActivite();
		$fin = $this->getDelaiJouissance()->getPriseActivite();
		if (empty($debut))
			return (null);
		$fin->add(new DateInterval('P' . $this->getDemembrement() . 'Y'));
		$rt = ($fin->getTimestamp() - $debut->getTimestamp()) / 86400;
		$rt -= 1;
		if ($rt < 0)
			$rt = 0;
		return ($rt);
	}
	public function getJoursEcoule($date = null) {
		$debut = $this->getDelaiJouissance()->getPriseActivite();
		if ($date == null)
			$fin = new DateTime("NOW");
		else {
			$fin = new DateTime();
			$fin->setTimestamp($date);
		}
		if (empty($debut))
			return (null);
		$rt = intval(($fin->getTimestamp() - $debut->getTimestamp()) / 86400);
		$rt += 1;
		if ($rt < 0)
			$rt = 0;
		return ($rt);
	}
	public function getMarcher() {
		if (empty($this->marcher))
			return ("");
		return ft_decrypt_crypt_information($this->marcher);
	}
	public function getMarcherForTable() {
		if (empty($this->marcher))
			return ("");
		$rt = ft_decrypt_crypt_information($this->marcher);
		if ($rt == "Primaire")
			return ("MP");
		else if ($rt == "Secondaire")
			return ("MS");
	}
	public function getValNue(){
		//return (CalculValCession::getInstance()->getVal(ft_decrypt_crypt_information($this->enr_date), ));
	}
	public function getNombreJoursRestant() {
		if ($this->getDemembrement() != 0)
			return (
				$this->getDemembrementJours() -
				$this->getJoursEcoule()
			);
		return (0);
		/*
		$today = DateTime::createFromFormat('d/m/Y', date('d/m/Y'));
		$end = $this->getFinDemembrement();
		$diff = $end->diff($today);
		return ($diff);
		*/
	}
	public function getEntreeJouissance () {
		return ($this->getDateTimeEntreeJouissance()->format('d/m/Y'));
	}
	public function getDateTimeEntreeJouissance () {
		if (!empty($this->getExcelDateEntreeJouissance()))
			return ($this->getExcelDateEntreeJouissance());
		if (!property_exists($this, "enr_date") || $this->enr_date == "0")
			return (DateTime::createFromFormat("d/m/Y", "01/01/1970"));
		return DelaiJouissance::getDateTimeFromDateId($this->id_scpi, ft_decrypt_crypt_information($this->enr_date));
	}
	public function getDateTimeSortieJouissance() {
		if (!property_exists($this, "enr_date") || $this->enr_date == "0")
			return (DateTime::createFromFormat("d/m/Y", "01/01/1970"));
		return DelaiJouissance::getDateTimeOutFromDateId($this->id_scpi, ft_decrypt_crypt_information($this->enr_date));
	}
	public function getDateTimePriseEffet() {
		if (!property_exists($this, "enr_date") || $this->enr_date == "0") {
			return (DateTime::createFromFormat("d/m/Y", "01/01/1970"));
		}
		if ($this->getTypeTransaction() == "V") {
			$entree = $this->getDateTimeSortieJouissance();
		} else {
			$entree = $this->getDateTimeEntreeJouissance();
		}
		return $entree;
	}
	public function getDateTimeBaseCalculDividende() {
		if (!property_exists($this, "enr_date") || $this->enr_date == "0")
			return (DateTime::createFromFormat("d/m/Y", "01/01/1970"));
		if ($this->getTypeTransaction() == "V") {
			$entree = $this->getDateTimeSortieJouissance();
		} else {
			$entree = $this->getDateTimeEntreeJouissance();
		}
		$year = $entree->format("Y") + 0;
		if ($year < date("Y")) {
			return (DateTime::createFromFormat('d/m/Y', "1/1/" . date("Y")));
		}
		else
			return $entree;
	}
	public function getBaseCalculDividende() {
		if (!property_exists($this, "enr_date") || $this->enr_date == "0")
			return (null);
		if ($this->getTypeTransaction() == "V")
			$entree = $this->getDateTimeSortieJouissance();
		else
			$entree = $this->getDateTimeEntreeJouissance();
		$year = $entree->format("Y") + 0;
		if ($year < date("Y"))
			return (DateTime::createFromFormat("d/m/Y", "1/1/" . date("Y"))->format("d/m/Y"));
		else
			return $entree->format("d/m/Y")	;
	}
	public function getEnrDate() {
		if (empty($this->enr_date))
		{
			return (false);
		}
		if ($this->_decrypted_enr_date == null && property_exists($this, "enr_date")) {
			$this->_decrypted_enr_date = DateTime::createFromFormat("d/m/Y", ft_decrypt_crypt_information($this->enr_date));
		}
		return ($this->_decrypted_enr_date);
	}
	public function getEnrDateStr() {
		$date = $this->getEnrDate();
		if ($date instanceof DateTime)
			return ($date->format('d/m/Y'));
		return ("-");
	}
	public function getEnrDateOne() {
		if ($this->_decrypted_enr_dateOne == null && property_exists($this, "enr_date")) {
			$this->_decrypted_enr_dateOne = DateTime::createFromFormat("d/m/Y", ft_decrypt_crypt_information($this->enr_date));
			$this->_decrypted_enr_dateOne = DateTime::createFromFormat("d/m/Y", "1/" . $this->_decrypted_enr_dateOne->format("m") . "/" . $this->_decrypted_enr_dateOne->format("Y"));
		}
		return ($this->_decrypted_enr_dateOne);
	}
	public function isBuy() {
		if (property_exists($this, "type_transaction") && $this->type_transaction != "V")
			return (true);
		return (false);
	}
	public function getCommentaire() {
		if (!empty($this->commentaire))
			return (ft_decrypt_crypt_information($this->commentaire));
		return ("");
	}
	public function getCommentaireForTable() {
		if (!empty($this->commentaire))
		{
			$rt = ft_decrypt_crypt_information($this->commentaire);
			if ($rt != "NONE")
				return ($rt);
		}
		return ("");
	}
	public function getDh() {
		if ($this->_dh == null)
			$this->_dh = Dh::getById($this->id_donneur_ordre);
		return ($this->_dh);
	}
	public function getBeneficiaire() {
		if ($this->_beneficiaire == null)
		{
			$this->_beneficiaire = Beneficiaire::getFromId($this->id_beneficiaire);
			if (count($this->_beneficiaire))
				$this->_beneficiaire = $this->_beneficiaire[0];
			else
				$this->_beneficiaire = false;
		}
		return ($this->_beneficiaire);
	}
	public function getIdMscpi() {
		return ($this->id_excel);
	}
	public function getConseiller() {
		if (!empty($this->id_cons) && $this->_conseiller == null)
		{
			$this->_conseiller = Dh::getById($this->id_cons);
		}
		return ($this->_conseiller);
	}
	public function getDateSignatureTs() {
		return ($this->date_bs);
	}
	public function getDateSignature() {
		if ($this->_excelDateBs == null && !empty($this->date_bs))
		{
			$this->_excelDateBs = new DateTime;
			$this->_excelDateBs->setTimestamp($this->date_bs); 
		}
		return ($this->_excelDateBs);
	}
	public function getDateSignatureStr() {
		$date = $this->getDateSignature();
		if (!empty($date))
			return ($date->format("d/m/Y"));
		return ("-");
	}
	public function getPrixPart() {
		return ($this->prix_part);
	}
	public function getDuree() {
		return ($this->dt);
	}
	public function getExcelDateFinJouissance() {
		if ($this->_excelDateFinJouissance == null && !empty($this->date_fin_joui))
		{
			$this->_excelDateFinJouissance = new DateTime;
			$this->_excelDateFinJouissance->setTimestamp($this->date_fin_joui); 
		}
		return ($this->_excelDateFinJouissance);
	}
	public function getExcelDateEntreeJouissance() {
		if ($this->_excelDateEntreeJouissance == null && !empty($this->date_entre_joui))
		{
			$this->_excelDateEntreeJouissance = new DateTime;
			$this->_excelDateEntreeJouissance->setTimestamp($this->date_entre_joui); 
		}
		return ($this->_excelDateEntreeJouissance);
	}
	public function getStatusTransaction() {
		if ($this->doByMscpi())
		{
			$rt = $this->getLastStatusTransaction();
			if (empty($rt))
				$this->setNewStatusTransaction(0, 0);
			$rt = $this->getLastStatusTransaction()->getStatusTitle();
			return ($rt);
		}
		else
			return ($this->status_trans);
	}
	public function getStatusTransactionObject() {
		if ($this->doByMscpi())
		{
			$rt = $this->getLastStatusTransaction();
			if (empty($rt))
				$this->setNewStatusTransaction(0, 0);
			$rt = $this->getLastStatusTransaction();
			return ($rt);
		}
		else
			return (null);
	}
	public function getStatusTransactionColumn() {
		return ($this->status_trans);
	}
	public function getInfoTransaction() {
		return (trim($this->info_trans));
	}
	public function getTypeTransaction() {
		return ($this->type_transaction);
	}

	public function getPatrimoineAtTimestamp($date)
	{
		if ($this->getEnrDate() instanceof DateTime)
		{
			$ts = new DateTime();
			$ts->setTimestamp($date)->setTime(0,0,0);
			$date_enreg = clone $this->getEnrDate();
			$date_enreg->setTime(0,0,0);
			if ($this->isPleinePro() && $date_enreg <= $ts)
				return true;
			if ($this->getDuree() > 0 && ($this->isNuePro() || $this->isUsufruit()))
			{
				$fin_demembrement = $date_enreg->add(new DateInterval('P'.$this->getDuree().'Y'));
				/*$diff = date_diff($fin_demembrement,$ts);
	echo $this->getScpi()->name,' ',$this->getTypePro(),' ',$this->getNbrPart(),' ',$fin_demembrement->format('d/m/Y'),'-',$ts->format('d/m/Y'),' ',$diff->invert,' ',$diff->days, PHP_EOL;
	var_dump(($fin_demembrement <= $ts),$fin_demembrement > $ts,($this->isNuePro() && $fin_demembrement <= $ts) || ($this->isUsufruit() && $fin_demembrement > $ts));
	echo PHP_EOL;*/
				if (($this->isNuePro() && $fin_demembrement <= $ts) || ($this->isUsufruit() && $fin_demembrement > $ts))
					return true;
			}
		}
		return false;
	}

	public function doByMscpi() {
		return $this->fait_par_mscpi;
	}
	public static function getMscpiTransaction()
	{
		$rt = array();
		foreach (self::getAll() as $key => $elm)
		{
			if (!empty($elm->id_excel))
				$rt[$key] = $elm;
		}
		uasort($rt, "sortTransaction");
		return ($rt);
	}
	public function getNombreJourRestant() {
		return (
			($this->getDateTimeSortieJouissance()->getTimestamp() - today()) /
			(24 * 60 * 60)
		);
	}
	public function getActualClefRepartition() {
		return ($this->getClefRepartitionAtTimestamp(today()));
	}
	public function getClefRepartitionAtTimestamp($date) {
		if (($this->isNuePro() && $this->getDemembrement() == 0) || $this->isPleinePro())
			return (100);
		else if ($this->isUsufruit() && $this->getDemembrement() == 0)
			return (0);
		if (!$this->getEnrDate() instanceof DateTime)
			return ($this->getClefRepartition());
		$clef = ft_decrypt_crypt_information($this->cle_repartition);
		$demembrement = $this->getDemembrementJours();
		$joursEcoule = $this->getJoursEcoule($date);
		if ($this->isPleinePro())
			$rt = 100;
		else if ($this->isNuePro())
			$rt = ((($joursEcoule / $demembrement) * (100 - $clef)) + $clef);
		else if ($this->isUsufruit())
			$rt = (((($demembrement - $joursEcoule) / $demembrement) * (100 - $clef)));
		if ($rt > 100)
			$rt = 100;
		if ($rt < 0)
			$rt = 0;
		return ($rt);
	}
	public function getValorisationOnePartAtTimestamp($date) {
		//if ($this->_valorisation == null)
		if (1)
		{
			$prix = Scpi::getFromId($this->id_scpi)->getActualValue();
			$nbr_part = 1;
			if ($this->isPleinePro())
			{
				$this->_valorisation = $prix * $nbr_part;
			}
			else if ($this->isNuePro())
			{
				if ($this->getDemembrement() > 0)
				{
					//return ($this->getClefRepartitionAtTimestamp($date));
					$this->_valorisation = $prix * $nbr_part * ($this->getClefRepartitionAtTimestamp($date) / 100);
				}
				else
				{
					//On calcul en fonction de l'age de l'Usufruitier
					$this->_valorisation = $prix * $nbr_part;
				}
			}
			else if ($this->isUsufruit())
			{
				if ($this->getDemembrement() > 0)
				{
					$this->_valorisation = $prix * $nbr_part * (($this->getClefRepartitionAtTimestamp($date)) / 100);
				}
				else
					// Il a été décidé de fixer a 0;
				$this->_valorisation = 0;
			}
			else
				return ($this->_valorisation = 0);
		}

		return ($this->_valorisation);
	}

	/**
	 * 
	 */
	public function getValorisationAtTimestamp($date) {
		if (1)
		{
			if (Scpi::getFromId($this->id_scpi) === null)
				return (0);
			$prix = Scpi::getFromId($this->id_scpi)->getActualValue();
			$nbr_part = $this->getNbrPartsForValorisationAtTimestamp($date);
			if ($this->isPleinePro())
			{
				$this->_valorisation = $prix * $nbr_part;
			}
			else if ($this->isNuePro())
			{
				if ($this->getDemembrement() > 0)
				{
					//return ($this->getClefRepartitionAtTimestamp($date));
					$this->_valorisation = $prix * $nbr_part * ($this->getClefRepartitionAtTimestamp($date) / 100);
				}
				else
				{
					//On calcul en fonction de l'age de l'Usufruitier
					$this->_valorisation = $prix * $nbr_part;
				}
			}
			else if ($this->isUsufruit())
			{
				if ($this->getDemembrement() > 0)
				{
					$this->_valorisation = $prix * $nbr_part * (($this->getClefRepartitionAtTimestamp($date)) / 100);
				}
				else
					// Il a été décidé de fixer a 0;
				$this->_valorisation = 0;
			}
			else
				return ($this->_valorisation = 0);
		}
		return ($this->_valorisation);
	}
	public function calcDebutValorisation() {
		$rt = null;
		if (!($this->getEnrDate() instanceof DateTime))
			$rt = null;
		else if ($this->isPleinePro())
			$rt = ($this->getDelaiJouissance()->getPriseActivite());
		elseif ($this->isNuePro())
			$rt = ($this->getDelaiJouissance()->getPriseActivite());
		elseif ($this->isUsufruit())
			$rt = ($this->getDelaiJouissance()->getPriseActivite());
		//	$rt = (null);
		return ($rt);
	}
	public function calcFinValorisation() {
		$rt = null;
		if (!($this->getEnrDate() instanceof DateTime))
			$rt = null;
		else if ($this->isPleinePro())
			$rt = null;
		elseif ($this->isNuePro())
			$rt = null;
		elseif ($this->isUsufruit() && $this->getDemembrement() != 0)
		{
			//($this->getDelaiJouissance()->getSortieJouissance());
			$rt = clone $this->getDelaiJouissance()->getSortieJouissance();
			$rt->sub(new DateInterval('P1D'));
		}
		return ($rt);
	}
	public function calcDebutDividendes() {
		$rt = null;
		if (!($this->getEnrDate() instanceof DateTime))
			$rt = null;
		else if ($this->isPleinePro() || $this->getTypeTransaction() == 'V')
			
		{
			if ($this->getTypeTransaction() == 'V')
				$rt = ($this->getDelaiJouissance()->getPriseActivite());
			else
				$rt = ($this->getDelaiJouissance()->getEntreeJouissance());
		}
		elseif ($this->isNuePro() && $this->getDemembrement() != 0)
		{
			//var_dump($this->getDelaiJouissance()->getEntreeJouissance());
			$rt = clone $this->getDelaiJouissance()->getEntreeJouissance();
				$rt->add(new DateInterval('P' . $this->getDemembrement() . 'Y'));
		}
		elseif ($this->isUsufruit())
			$rt = ($this->getDelaiJouissance()->getEntreeJouissance());
		return ($rt);
	}
	public function calcFinDividendes() {
		$rt = null;
		if (!($this->getEnrDate() instanceof DateTime))
			//$rt = null;
			return (null);
		/*
		else if ($this->isPleinePro())
			$rt = ($this->getDelaiJouissance()->getSortieJouissance());
		elseif ($this->isNuePro())
			$rt = ($this->getDelaiJouissance()->getSortieJouissance());
		elseif ($this->isUsufruit())
			$rt = ($this->getDelaiJouissance()->getSortieJouissance());
			*/
		if (!$this->getDelaiJouissance()->getSortieJouissance() instanceof DateTime)
			return (null);
		$rt = clone $this->getDelaiJouissance()->getSortieJouissance();
		$rt->sub(new DateInterval('P1D'));
		return ($rt);
	}
	public function setDebutFinValorisationDividendes() {
		if (!($this->getEnrDate() instanceof DateTime) || ft_decrypt_crypt_information($this->enr_date) == 0)
			return (null);
		// calcul de la date du debut de valorisation des parts
		if (!empty($this->debut_valorisation_manuel))
			$this->updateOneColumnCheckSecurity("debut_valorisation", $this->debut_valorisation);
		else if ($this->calcDebutValorisation() instanceof DateTime)
			$this->updateOneColumnCheckSecurity("debut_valorisation", $this->calcDebutValorisation()->getTimestamp());
		else if (!empty($this->date_entre_joui))
			$this->updateOneColumnCheckSecurity("debut_valorisation", $this->date_entre_joui);


		// Calcul de la date de fin de valorisation
		if (!empty($this->fin_valorisation_manuel))
			$this->updateOneColumnCheckSecurity("fin_valorisation", $this->fin_valorisation_manuel);
		else if ($this->calcFinValorisation() instanceof DateTime)
			$this->updateOneColumnCheckSecurity("fin_valorisation", $this->calcFinValorisation()->getTimestamp());

		// Calcul de la date de debut de dividendes
		if (!empty($this->debut_dividendes_manuel))
			$this->updateOneColumnCheckSecurity("debut_dividendes", $this->debut_dividendes_manuel);
		else if ($this->calcDebutDividendes() instanceof DateTime)
			$this->updateOneColumnCheckSecurity("debut_dividendes", $this->calcDebutDividendes()->getTimestamp());
		else if (!empty($this->date_entre_joui) && ($this->isPleinePro() || $this->isUsufruit()))
			$this->updateOneColumnCheckSecurity("debut_dividendes", $this->date_entre_joui);
		else if (!empty($this->date_entre_joui) && $this->getDemembrement() != 0)
		{
			$nValue = clone $this->getExcelDateEntreeJouissance();
			$nValue->add(new DateInterval('P' . $this->getDemembrement() . 'Y'));
			$this->updateOneColumnCheckSecurity("debut_dividendes", $nValue->getTimestamp());
		}

		// Calcul de la date de fin de dividendes
		if (!empty($this->fin_dividendes_manuel))
			$this->updateOneColumnCheckSecurity("fin_dividendes", $this->fin_dividendes_manuel);
		else if ($this->calcFinDividendes() instanceof DateTime)
			$this->updateOneColumnCheckSecurity("fin_dividendes", $this->calcFinDividendes()->getTimestamp());
		else if (!empty($this->date_fin_joui) && ($this->isPleinePro() || $this->isUsufruit()))
			$this->updateOneColumnCheckSecurity("fin_dividendes", $this->getExcelDateFinJouissance()->add(new DateInterval('P' . $this->getDemembrement() . 'Y'))->getTimestamp());
	}
	public function getNbrPartsForValorisationAtTimestamp($date) {
		if ($this->getTypeTransaction() == 'V')
			return (null);
		$req = "
			SELECT sum(nbr_part) as nbr_parts_active
			FROM `TRANSACTION`
			WHERE 
				(
					id = ?
					OR 
					(
						type_transaction  = 'V'
						AND
						id_transaction_achat = ?
						AND
						id_transaction_achat IN (
							SELECT `id`
							FROM `TRANSACTION`
							WHERE `id` = ?
							AND
								debut_valorisation <= ?
							AND
							(
								fin_valorisation > ?
								OR
								fin_valorisation = 0
								OR
								fin_valorisation IS NULL
							)
						)
					)
				)
				AND
					debut_valorisation <= ?
				AND
					(
						fin_valorisation > ?
						OR
						fin_valorisation = 0
						OR
						fin_valorisation IS NULL
					)
		";
		$data = [
			$this->id,
			$this->id,
			$this->id,
			$date,
			$date,
			$date,
			$date
		];
		$rt = Database::prepare(self::$_db, $req, $data, get_called_class());
		if (empty($rt))
			return (0);
		return ($rt[0]->nbr_parts_active);
	}
	public function getDateDebutValorisation() {
		if (empty($this->debut_valorisation))
			return (null);
		$rt = new DateTime();
		$rt->setTimestamp(intval($this->debut_valorisation));
		return ($rt);
	}
	public function getDateFinValorisation() {
		if (empty($this->fin_valorisation))
			return (null);
		$rt = new DateTime();
		$rt->setTimestamp(intval($this->fin_valorisation));
		return ($rt);
	}
	public function getDateDebutDividendes() {
		if (empty($this->debut_dividendes))
			return (null);
		$rt = new DateTime();
		$rt->setTimestamp(intval($this->debut_dividendes));
		return ($rt);
	}
	public function getDateFinDividendes() {
		if (empty($this->fin_dividendes))
			return (null);
		$rt = new DateTime();
		$rt->setTimestamp(intval($this->fin_dividendes));
		return ($rt);
	}
	public function getDateDebutValorisationManuel() {
		$rt = new DateTime();
		$rt->setTimestamp(intval($this->debut_valorisation_manuel));
		return ($rt);
	}
	public function getDateFinValorisationManuel() {
		$rt = new DateTime();
		$rt->setTimestamp(intval($this->fin_valorisation_manuel));
		return ($rt);
	}
	public function getDateDebutDividendesManuel() {
		$rt = new DateTime();
		$rt->setTimestamp(intval($this->debut_dividendes_manuel));
		return ($rt);
	}
	public function getDateFinDividendesManuel() {
		$rt = new DateTime();
		$rt->setTimestamp(intval($this->fin_dividendes_manuel));
		return ($rt);
	}
	public function getNbrPartsForDividendesAtTimestamp($date) {
		if ($this->getTypeTransaction() == 'V')
			return (null);
		$req = "
			SELECT sum(nbr_part) as nbr_parts_active
			FROM `TRANSACTION`
			WHERE 
				(
					id = ?
					OR 
					(
						type_transaction = 'V'
						AND
						id_transaction_achat = ?
						AND
						id_transaction_achat IN (
							SELECT `id`
							FROM `TRANSACTION`
							WHERE `id` = ?
							AND
								debut_dividendes <= ?
							AND
							(
								fin_dividendes > ?
								OR
								fin_dividendes = 0
								OR
								fin_dividendes IS NULL
							)
						)
					)
				)
				AND
					debut_dividendes <= ?
				AND
					(
						fin_dividendes > ?
						OR
						fin_dividendes IS NULL
					)
		";
		$data = [
			$this->id,
			$this->id,
			$this->id,
			$date,
			$date,
			$date,
			$date
		];
		$rt = Database::prepare(self::$_db, $req, $data, get_called_class());
		if (empty($rt))
			return (0);
		return ($rt[0]->nbr_parts_active);
	}
	public function getTransactionVentes() {
		if ($this->getTypeTransaction() == 'V')
			return (null);
		$req = "
			SELECT *
			FROM `TRANSACTION`
			WHERE type_transaction = 'V' AND id_transaction_achat = ?
		";
		$data = [$this->id];
		$rt = Database::prepare(self::$_db, $req, $data, get_called_class());
		return ($rt);
	}
	public function getDividendeYearMonth($year, $month)
	{
		return $this->getScpi()->getAcompteYearT($year, ($month + 2) / 3) * $this->getNbrPartsForDividendesAtTimestamp(DateTime::createFromFormat("d/m/Y", "1/$month/$year")->getTimestamp()) / 3;
	}
	public function getDividendeYearT($year, $T)
	{
		$acompte = $this->getScpi()->getAcompteYearT($year, $T);
		$rt = 0;
		$rt += $this->getDividendeYearMonth($year, (($T - 1) * 3) + 1);
		$rt += $this->getDividendeYearMonth($year, (($T - 1) * 3) + 2);
		$rt += $this->getDividendeYearMonth($year, (($T - 1) * 3) + 3);
		//$rt *= $acompte / 3;
		return ($rt);
	}
	public function getDividendeYear($year)
	{
		$rt = 0;
		for ($i = 1; $i <=4 ;$i++)
		{
			$rt += $this->getDividendeYearT($year, $i);
		}
		return ($rt);
	}
	public function remove() {
		Database::prepareNoClass(self::$_db, "DELETE FROM `StatusTransaction` WHERE `id_transaction` = ?", [$this->id]);
		return Database::prepareNoClass(self::$_db, "DELETE FROM `TRANSACTION` WHERE `id` = ? OR `id_transaction_achat` = ?", [$this->id, $this->id]);
	}
	public function getAllStatusTransaction() {
		return (StatusTransaction::getAllForTransaction($this->id));
	}
	public function getLastStatusTransaction() {
		return (StatusTransaction::getLastForTransaction($this->id));
	}
	public function setIsMscpi() {
		$this->updateOneColumn('fait_par_mscpi', 1);
		$this->updateOneColumn('info_trans', 'MS.C');
		$this->info_trans = "MS.C";
	}
	public function setNewStatusTransaction($sup, $sub) {
		$nelm = new StatusTransaction();
		$nelm->setTransaction($this);
		$nelm->setStatus($sup, $sub);
		return ($nelm->insertIt());
	}
	public function getFromProject($id_project) {
		return (parent::getFromKeyValue('id_projet', $id_project));
	}
	public function getProject() {
		return (Projet::getFromId($this->id_projet));
	}
	public function getIdExcel() {
		return (intval($this->id_excel));
	}

	public function getForStoreMini()
	{
		$rt = [];
		$rt['id'] = $this->id;
		$rt['id_dh'] = $this->id_donneur_ordre;
		//$rt['id_excel'] = $this->getIdExcel();
		$rt['id_scpi'] = $this->id_scpi;
		//$rt['id_projet'] = $this->id_projet;
		$rt['id_cons'] = (!empty($this->id_cons))? $this->id_cons : $this->getDh()->conseiller;
		$rt['id_benf'] = $this->id_beneficiaire;
		//$rt['id_tr_a'] = $this->id_transaction_achat;
		$rt['doByMscpi'] = $this->doByMscpi();
        $benef = $this->getBeneficiaire();
		if ($benef)
		{
			if ($benef->type_ben == "Pm")
			{
				$pm = $benef->getPersonneMorale()[0];
				$rt['is_pm'] = 1;
				$rt['is_pp'] = 0;
				$rt['ds'] = $pm->getDenominationSociale();
			}
			else
			{
				$pp = $benef->getPersonnePhysique()[0];
				$rt['is_pp'] = 1;
				$rt['is_pm'] = 0;
				$rt['shortname'] = $pp->getShortName();
				$rt['name'] = $pp->getName();
			}
		}
		else
		{
			$rt['is_pp'] = 1;
			$rt['is_pm'] = 0;
			$rt['shortname'] = $this->getDh()->getShortName();
			$rt['name'] = $this->getDh()->getPersonnePhysique()->getName();
		}
		$status = $this->getLastStatusTransaction($this->id);
		if ($status)
		{
			$rt['status'] = $status->getStatusSup() . "-" . $status->getStatusSub();
			$rt['status_date'] = $status->getDateStatus();
		}
		else
		{
			$rt['status'] = ($this->doByMscpi())? "0-0" : "" ;
			$rt['status_date'] = "";
		}
		if ($this->getEnrDate() instanceof DateTime)
			$rt['enr'] = $this->getEnrDate()->getTimestamp();
		else
			$rt['enr'] = '';
		$rt['com'] = $this->getCommentaire();
		$rt['part'] = $this->getNbrPart();
		$rt['pro'] = $this->getTypePro();
		$rt['type'] = $this->getTypeTransaction();
		$rt['dt'] = $this->getDemembrement();
		$rt['cle'] = $this->getClefRepartition();
		if (!empty($this->getNbrPart()) && !empty($this->getPrixPart()) && !empty($this->getClefRepartition()))
		{
			$rt['montant'] = $this->getPrixPart()
			 * $this->getNbrPart()
			 * (100 / $this->getClefRepartition());
		}
		else
			$rt['montant'] = 0;
		$rt['prix'] = $this->getPrixPart();

		return $rt;
	}

	public function getForStore() {
		$rt = [];
		$rt['id'] = $this->id;
		$rt['id_donneur_ordre'] = $this->id_donneur_ordre;
		$rt['id_excel'] = $this->getIdExcel();
		$rt['id_scpi'] = $this->id_scpi;
		$rt['id_projet'] = $this->id_projet;
		$rt['id_cons'] = $this->id_cons;
		$rt['id_beneficiaire'] = $this->id_beneficiaire;
		$rt['id_transaction_achat'] = $this->id_transaction_achat;
		$rt['marcher'] = $this->getMarcher();
		$rt['type_pro'] = $this->getTypePro();
		$rt['nbr_part'] = $this->getNbrPart();
		$rt['prix_part'] = $this->getPrixPart();
		$rt['cle_repartition'] = $this->getClefRepartition();
		$rt['fin_demembrement'] = $this->getFinDemembrement();
		$aujourdhui = Datetime::createFromFormat("d/m/Y H:i:s", date("d/m/Y") . " 00:00:00")->getTimeStamp();
		$rt['cle_repartition_dynamique'] = $this->getClefRepartitionAtTimestamp($aujourdhui);
		$rt['reventePotentielle'] = $this->getValorisationAtTimestamp($aujourdhui);
		$rt['montantInvestissement'] = $this->getMontanInvestissement();


		$rt['dt'] = $this->getDuree();
		$rt['viager'] = $this->viager;
		$rt['date_bs'] = $this->getDateSignatureTs();
		$rt['type'] = $this->getTypeTransaction();
		$rt['commentaire'] = $this->getCommentaire();
		$rt['date_entre_joui'] = $this->date_entre_joui;
		$rt['date_fin_joui'] = $this->date_fin_joui;
		$rt['commentaire_projet'] = $this->commentaire_projet;
		$benef = $this->getBeneficiaire();
		$rt['beneficiaire'] = ($benef) ? $benef->getForStore() : ['shortName' => ''];
		$rt['docs'] = $this->getDocumentsArray();

		$tmp = $this->getDelaiJouissance()->getEntreeJouissance();
		$rt['date_entre_joui_calc'] = ($tmp instanceof DateTime) ? $tmp->getTimeStamp() : 0;

		$tmp = $this->getDelaiJouissance()->getSortieJouissance();
		$rt['date_sortie_joui_calc'] = ($tmp instanceof DateTime) ? $tmp->getTimeStamp() : 0;

		$tmp = $this->getEnrDate();
		$rt['enr_date'] = ($tmp instanceof DateTime) ? $tmp->getTimestamp() : 0;

		if (($rt['doByMscpi'] = intval($this->doByMscpi())))
		{
			$status = $this->getStatusTransactionObject();
			$rt['status_trans'] = (!empty($status) && !empty($status->getKeyForStore())) ? $status->getKeyForStore() : "0-0";
			$rt['status_trans_done'] = ($rt['status_trans'] == '6-0') ? 1 : 0 ;
			$rt['status_trans_cancelled'] = ($rt['status_trans'] == '7-0') ? 1 : 0 ;
		}
		else
		{
			// Si transaction non-mscpi on regarde si un CNP a été validé
			$rt['status_trans'] = "";
			$rt['status_trans_done'] = (!empty(($rt['docs'][13])) && $rt['docs'][13][0]->isValidated()) ? 1 : 0;
			$rt['status_trans_cancelled'] = 0;
		}
		$rt['info_trans'] = $this->getInfoTransaction();

		// Infos crédits
		$rt['montant_emprunt'] = $this->montant_emprunt;
		$rt['type_emprunt'] = $this->type_emprunt;
		$rt['duree_emprunt'] = $this->duree_emprunt;
		$rt['date_debut_emprunt'] = $this->date_debut_emprunt;
		$rt['taux_emprunt'] = $this->taux_emprunt;
		$rt['mensualite_emprunt'] = $this->mensualite_emprunt;

		$rt['montantGlobalDeRevente'] = $this->getMontantGlobalDeRevente();
		return ($rt);
	}

	public function getForFrontStore() {

		$status = $this->getStatusTransactionObject();
		$rt = [
			"id" => $this->id,
			"id_scpi" => $this->id_scpi,
			"id_beneficiaire" => $this->id_beneficiaire,
			"scpi" => $this->getScpi()->getName(),
			"ventePotentiellePleinPro" => $this->getNbrPart() * $this->getScpi()->getActualValue(),
			"demembrement" => $this->getDemembrement(),
			"doByMscpi" => intval($this->doByMscpi()),
			"doByOther" => ($this->status_trans != "MS.C") ? true : false,
			"enr_date" => (!empty($this->enr_date) && ($enr_date = DateTime::createFromFormat("d/m/Y",ft_decrypt_crypt_information($this->enr_date)))) ? $enr_date->getTimestamp() : NULL,
			"nbr_part" => $this->nbr_part,
			"cle_repartition" => ($this->cle_repartition != NULL) ? $this->getClefRepartition() : NULL,
			"prix_part" => $this->prix_part,
			"status_trans" => (!empty($status) && !empty($status->getKeyForStore())) ? $status->getKeyForStore() : "0-0",
			"type_pro" => ($this->type_pro != NULL) ? ft_decrypt_crypt_information($this->type_pro) : NULL,
			"type_transaction" => ($this->type_transaction=="V")? "V" : "A",
			"marche" => $this->getMarcher(),
			"MontantInvestissement" => $this->getMontanInvestissement(),
			"debut_valorisation" => ($this->getDateDebutValorisation() != null) ? $this->getDateDebutValorisation()->getTimestamp() : null,
			"fin_valorisation" =>  ($this->getDateFinValorisation() != null) ? $this->getDateFinValorisation()->getTimestamp() : null,
			"debut_dividendes" =>  ($this->getDateDebutDividendes() != null) ? $this->getDateDebutDividendes()->getTimestamp() : null,
			"fin_dividendes" =>  ($this->getDateFinDividendes() != null) ? $this->getDateFinDividendes()->getTimestamp() : null,
			"fait_par_mscpi" => $this->fait_par_mscpi,

			"montant_emprunt" => $this->montant_emprunt,
			"type_emprunt" => $this->type_emprunt,
			"duree_emprunt" => $this->duree_emprunt,
			"date_debut_emprunt" => $this->date_debut_emprunt,
			"taux_emprunt" => $this->taux_emprunt,
			"mensualite_emprunt" => $this->mensualite_emprunt,
			"id_cons" => $this->id_cons,
			"info_trans" => $this->getInfoTransaction(),
			"societe" => $this->getSociete(),
            "non_pp_fin_demembrement" => $this->getDemembrementFini()
		];
		return ($rt);
	}

	public function getSociete() {
		return ($this->societe);
	}

	public static function getMarcheLst() {
		return self::$_marche;
	}
	public static function getTypeProLst() {
		return self::$_typepro;
	}
	public static function getTypeDemembrementLst() {
		return self::$_demembrement;
	}

/*
	public function getFinDemembrement() {
		if (!property_exists($this, "enr_date") || $this->enr_date == "0")
			return (null);
		$rt = DelaiJouissance::getDateTimeFromDateId($this->id_scpi, ft_decrypt_crypt_information($this->enr_date));
		$rt->add(new DateInterval("P10Y"));
		$rt->sub(new DateInterval("P1D"));
		return ($rt);
	}
*/
	public function getFinDemembrement() {
		if ($this->getTypePro() == "Pleine propriété")
			return (0);
		else if ($this->getTypePro() == "Nue propriété" && $this->getDateDebutDividendes() != null)
			return ($this->getDateDebutDividendes()->getTimestamp());
		else if ($this->getTypePro() == "Usufruit" && $this->getDateFinDividendes() != null)
			return ($this->getDateFinDividendes()->getTimestamp());
		return (100000);
	}

	/* si on a 1, c'est une fin de demembrement, sinon c'est 0 */
	public function getDemembrementFini() {
		if ($this->getTypePro() == "Pleine propriété"){
			return (1);
		}
		else if ($this->getTypePro() == "Nue propriété" && $this->getDateDebutDividendes() != null){
			$date=$this->getDateDebutDividendes()->getTimestamp()-time();
			if($date<0){
				return 1;
			}
			else return 0;
		}
		else if ($this->getTypePro() == "Usufruit" && $this->getDateFinDividendes() != null){
			$date=$this->getDateFinDividendes()->getTimestamp()-time();
			if($date<0){
				return 1;
			}
			else return 0;
		}
		return (100000);
	}

	public function getForFrontStoreOld() {
		$benef = $this->getBeneficiaire();
		$personnes = ['shortName' => ''];
		if ($benef)
			$personnes = $benef->getForFrontStore();
		$rt = [];
		$rt['id'] = $this->id;
		$rt['nom_projet'] = "";
		if (($projet = Projet::getFromId($this->id_projet)))
			$rt['nom_projet'] = $projet[0]->getName();
		$rt['beneficiaire'] = $personnes;
		$rt['id_beneficiaire'] = $this->id_beneficiaire;
		$rt['scpi'] = $this->getScpi()->getName();
		$rt['pieGeo'] = $this->getScpi()->pie_geo;
		$rt['pieBiens'] = $this->getScpi()->pie_biens;
		// Conseiller ayant réalisé la transaction
		if (!is_null($this->id_cons) && $this->id_cons > 0)
			$rt['conseiller'] = $this->getConseiller()->getShortName();
		else
			$rt['conseiller'] = $this->getDh()->getConseiller()->getShortName();
		//$rt['id_scpi'] = $this->id_scpi;
		$rt['info_trans'] = $this->getInfoTransaction();
		$rt['marcher'] = $this->getMarcher();
		$rt['type_pro'] = $this->getTypePro();
		$rt['cle_repartition'] = $this->getClefRepartition();
		$rt['dt'] = $this->getDuree();
		$rt['nbr_part'] = $this->getNbrPart();
		$rt['prix_part'] = $this->getPrixPart();
		$rt['doByMscpi'] = intval($this->doByMscpi());
		// Date d'enregistrement
		if ($this->getEnrDate() instanceof DateTime)
			$rt['enr_date'] = $this->getEnrDate()->getTimestamp();
		else
			$rt['enr_date'] = 0;
		// Documents
		$rt['docs'] = $this->getMiniDocumentArray();
		if (!$this->doByMscpi())
		{
			$rt['status_trans'] = "";
			// Si transaction non-mscpi on regarde si un CNP a été validé
			$rt['status_trans_done'] = (!empty(($rt['docs'][13])) && $rt['docs'][13][0]->isValidated()) ? 1 : 0;
			$rt['status_trans_cancelled'] = 0;
		}
		else
		{
			// Status
			$status = StatusTransaction::getForFrontStore($this->id);
			$rt['status_trans'] = $status['list'];
			$rt['status_trans_done'] = $status['done'];
			$rt['status_trans_cancelled'] = $status['canceled'];
		}
		// Infos crédits
		$rt['montant_emprunt'] = $this->montant_emprunt;
		$rt['type_emprunt'] = $this->type_emprunt;
		$rt['duree_emprunt'] = $this->duree_emprunt;
		$rt['date_debut_emprunt'] = $this->date_debut_emprunt;
		$rt['taux_emprunt'] = $this->taux_emprunt;
		$rt['mensualite_emprunt'] = $this->mensualite_emprunt;
		$rt['viager'] = $this->viager;
		$rt['type_transaction'] = $this->getTypeTransaction();


		$data = $this->getDh()->getCacheArrayTable();
		if (isset($data[$rt['scpi']])) {
			$rt['dividendes'] = $data[$rt['scpi']]['precalcul']['lastDividendes'];
			$rt['flagMissingInfo'] = $data[$rt['scpi']]['precalcul']['flagMissingInfo'];
		} else {
			$rt['dividendes'] = 0;
			$rt['flagMissingInfo'] = false;
		}
		// $rt['finjouissance'] = $data[$rt['scpi']]['precalcul'];
		// dbg($data[$rt['scpi']]['precalcul']);
		$rt['debut_jouissance'] = $this->getDelaiJouissance()->getEntreeJouissance();
		$rt['fin_jouissance'] = $this->calcFinValorisation();
		$rt['debut_dividendes'] = $this->calcDebutDividendes();
		// dbg($this);
		if (isset($data[$rt['scpi']])){
			switch ($this->getTypePro()) {
				case 'Pleine propriété':
					$rt['ventePotentielle'] = $data[$rt['scpi']]['Pleine'][$this->id]['precalcul']['ventePotentielle'];
					$rt['plus_ou_moins_scpi'] = $data[$rt['scpi']]['Pleine'][$this->id]['precalcul']['plusMoinValuePourcent'];
					break;
				case 'Usufruit':
					$rt['ventePotentielle'] = $data[$rt['scpi']]['Usu'][$this->id]['precalcul']['ventePotentielle'];
					$rt['plus_ou_moins_scpi'] = $data[$rt['scpi']]['Usu'][$this->id]['precalcul']['plusMoinValuePourcent'];
					break;
				case "Nue propriété":
					$rt['ventePotentielle'] = $data[$rt['scpi']]['Nue'][$this->id]['precalcul']['ventePotentielle'];
					$rt['ventePotentiellePleinePro'] = $data[$rt['scpi']]['Nue'][$this->id]['precalcul']['ventePotentiellePleinPro'];
					$rt['plus_ou_moins_scpi'] = $data[$rt['scpi']]['Nue'][$this->id]['precalcul']['plusMoinValuePourcent'];
					break;
			}
			$rt['capital'] = $data[$rt['scpi']]['precalcul']['scpi']->TypeCapital;
		}
		else {
			$rt['ventePotentielle'] = 0;
			$rt['capital'] = '-';
		}
		$d = Datetime::createFromFormat("d/m/Y", "15/02/" . date('Y'));
		$t = new Datetime();
		$rt['valorisation'] = $this->getValorisationAtTimestamp(time());
		// dbg($this);

		//A verifier
		if ($d->getTimestamp() <
		$t->getTimestamp())
			$rt['dividendes_percu'] = $this->getDividendeYear(date('Y') - 1);
		else
			$rt['dividendes_percu'] = $this->getDividendeYear(date('Y') - 2);
		$rt['plus_ou_moins'] = ($this->getPlusMoinValue());
		$rt['tmp_scpi'] = $data[$rt['scpi']];
		$rt['main_categorie'] = $this->getScpi()->getCategoryStr();
		$rt['tof'] = $this->getScpi()->Tof;
		$rt['tdvm'] = $this->getScpi()->Tdvm;
		return $rt;
	}
}
