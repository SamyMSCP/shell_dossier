<?php

/**
 * \file          SocieteDeGestion.php
 * \author    Florian
 * \date       12 Avril 2018
 * \brief       La class recupere les principaux elements des spi.
 *
 * \details   La class recupere les principaux elements des spi.
 */
require_once("core/Database.php");
require_once("core/Apiv2.php");
require_once("core/Cache.php");
require_once("Publication.php");
require_once("Actuality.php");
//require_once("DelaiJouissance.php");
require_once("SocieteDeGestion.php");

function cmpScpi($a, $b) {
	if ($a == false || $b == false) {
		return (1);
	}
	return (strnatcasecmp($a->name, $b->name));
}

class Scpi extends Apiv2
{
	use Cache;
	public			$id;
	public			$name;
	public			$token;
	public			$slug;
	public			$company_id;
	public			$parent_id;
	public			$created_at;
	public			$absorbed_at;
	private			$_lastPrice = null;
	private static	$type = array(5 => "Rendement", 6 => "Fiscale");
	protected static	$staticDataCacheAllScpi = null;

	public function getDataById($id) {
		return (ScpiTimeData::getFromScpiIdTypeId($this->id, $id));
	}
	public function getLastDataById($id) {
		return (ScpiTimeData::getLastFromScpiIdTypeId($this->id, $id));
	}
	public function __toString() {
		return ("Scpi ['" . $this->name . "']\n");
	}
	public static	$geo = array (
		"Paris",
		"Régions",
		"Ile-de-France",
		"Etranger"
	);

	private static	$_lstAll = null;
	private static	$_lstUnit = array();

    /**
     * \brief       Recupere tout le cache cpi
     * \details     Cet function va permetre de recupere tout le cache cpi si la variable $_lstAll est égale a null
     *

     * \return    return tout le cache scpi dans la variable $_lstAll
     */

	public static function	getAll()
	{
		if (self::$_lstAll == null)
		{
			self::$_lstAll = self::getCacheAllScpi();
		}
		return (self::$_lstAll);
	}

	public static function	getShowList()
	{
		$rt = array();
		foreach (self::getAll() as $key => $elm)
		{
			if ($elm->isShow())
				$rt[$key] = $elm;
		}
		return ($rt);
	}
	public static function	getShowListTest()
	{
		$rt = array();
		foreach (self::getAll() as $key => $elm)
		{
			var_dump($elm);
			//if ($elm->isShow())
				$rt[$key] = $elm;
		}
		return ($rt);
	}
	public function			isShow()
	{
		return (
			(empty($this->checkShowList()) && $this->autoShow()) ||
			!empty($this->checkShowList()) && $this->checkShowList() == 1
		);
	}
	public function			checkShowList()
	{
		$rt = (ScpiGestion::getFromKeyValue("id_scpi", $this->id));
		if (empty($rt))
			return (null);
		return ($rt[0]->getShowList());
	}
	public function			autoShow()
	{
		return (empty($this->absorbed_at) && $this->type_id == 5);
	}
	public function			isAbsorbed()
	{
		return (!empty($this->absorbed_at));
	}
	public function			isAbsorbedStr()
	{
		return ($this->isAbsorbed() ? "oui" : "non");
	}
	public static function	generateCacheAllScpi() {
	/*
		$api = parent::getRequestObjects(
			array(
				"req" => "getAllSCPI"
				)
			);
			*/

		$api = self::getRequestJsonScpi();
		$rt = array();

		foreach ($api as $key => $elm)
		{
			//$elm->mscpiHave = false;
			$rt[$elm->id] = $elm;

		}
		uasort($rt, "cmpScpi");
		return ($rt);
	}
	public static function	afterRegenerateAllScpi() {
		/*
		 * Ajout des totaux de transactions
		 */
		$v = ["MSCPI" => 0, "AUTRE" => 0, "TOTAL" => 0];
		$_scpi =[];
		$dh = Dh::getAll();
		foreach ($dh as $d)
		{
			// Transactions de clients ou prospects uniquement
			if ($d->type == "client" || $d->type == "")
			{
				$tr_dh = $d->getCacheArrayTable();
				foreach ($tr_dh as $key => $value)
				{
					if ($key == "precalcul")
						continue;
					if (!isset($_scpi[$key]))
						$_scpi[$key] = $v;
					$_scpi[$key]["MSCPI"] += $value['precalcul']['vPMscpi'];
					$_scpi[$key]["AUTRE"] += $value['precalcul']['vPOther'];
					$_scpi[$key]["TOTAL"] += $value['precalcul']['vPMscpi'] + $value['precalcul']['vPOther'];
				}
			}
		}
		foreach (self::$staticDataCacheAllScpi as $key => &$elm)
		{
			// Boucle sur les acomptes et acomptes ex pour passer les -1 en 0;
			if (isset($elm->name) && isset($_scpi[$elm->name]))
			{
				$elm->ventePotentielleMscpi = $_scpi[$elm->name]["MSCPI"];
				$elm->ventePotentielleOther = $_scpi[$elm->name]["AUTRE"];
				$elm->ventePotentielleTotal = $_scpi[$elm->name]["TOTAL"];
			}
		}
		return (
			file_put_contents(
				self::staticCachePath('AllSCPI'),
				serialize(self::$staticDataCacheAllScpi),
				LOCK_EX
			)
		);
	}
	public static function	isExists($ScpiName){
		foreach (self::getAll() as $elem)
			if (strtolower($elem->name) == strtolower($ScpiName))
				return ($elem->name);
		return (NULL);
	}
	public function			getAcompteYear($year) {
		while (!isset($this->AllAcomptes[$year]) && $year > 1970)
			$year = intval($year) - 1;
		if ($year === 1970)
			return ["T1" => 0, "T2" => 0, "T3" => 0, "T4" => 0];
		$rt = [];
		foreach ($this->AllAcomptes[$year] as $key => $el) {
			$rt['T' . $key] = $el;
		}
		return ((array) $rt);
	}
	public function			getAcompteYearT($year, $T) {
		return (
			$this->getAcompteExYearT($year, $T) +
			$this->getAcompteOrdYearT($year, $T)
		);
	}
	public function			getAcompteExYearT($year, $T) {
		if (isset($this->AllAcomptesEx[$year]) && isset($this->AllAcomptesEx[$year][$T]))
			return ($this->AllAcomptesEx[$year][$T]);
		return (0);
	}
	public function			getAcompteOrdYearT($year, $T) {
		if (isset($this->AllAcomptes[$year]) && isset($this->AllAcomptes[$year][$T]))
			return ($this->AllAcomptes[$year][$T]);
		return (0);
	}
	public function			getAcompteThisYear()
	{
		return ($this->Acompte);
	}
	public function			getAcompteThisYearByT($t)
	{
		$rt = $this->Acompte;
		if (isset($rt['data']['T' . $t]))
			return ($rt['data']['T' . $t]);
		return (0);
	}
	public static function	getFromArrayDist($array)
	{
		$rt = parent::getRequestObjects(
				array(
					"req" => "getSCPIs",
					"lst" => json_encode($array, JSON_FORCE_OBJECT),
					"distinct" => 1
					)
			);
		return ($rt);
	}
	public static function	getFromArray($array)
	{
		if (self::$_lstAll == null)
			self::getAll();
		$rt = array();
		foreach($array as $k => $v){
			$rt[$v] = self::$_lstAll[$v];
		}
		return ($rt);
		/*$rt = parent::getRequestObjects(
				array(
					"req" => "getSCPIs",
					"lst" => json_encode($array, JSON_FORCE_OBJECT)
					)
			);
		return ($rt);*/
	}
	public static function	getFromId($id)
	{
		if (self::$_lstAll == null)
			self::getAll();
		return (self::$_lstAll[$id]);
	}

	public function			getUrl() {
		$rt = DOMAIN_NAME . "scpi/scpi-de-rendement/f" . $this->token . "-" . $this->slug . "";
		return ($rt);
	}
	public function			getPublicationUrl() {
		$rt = DOMAIN_NAME . "scpi/scpi-de-rendement/f" . $this->token . "-" . $this->slug . "/publication/";
		return ($rt);
	}
	public function			getActualityUrl() {
		$rt = DOMAIN_NAME . "scpi/scpi-de-rendement/f" . $this->token . "-" . $this->slug . "/Actuality/";
		return ($rt);
	}
	public function			getActuality() {
		return Actuality::getFromArray(
			$this->id,
			4
		);
	}
	public function			getAllActuality() {
		return Actuality::getAllFromArray(
			$this->id
		);
	}
	public function			getPublication() {
		return Publication::getFromArray(
			$this->id,
			4
		);
	}
	public function			getAllPublication() {
		return Publication::getAllFromArray(
			$this->id
		);
	}
	public function			getDelaiJouissanceString() {
		$joui = DelaiJouissance::getById($this->id)[0];
		$unite = "";
		if ($joui->unite == DelaiJouissance::TRIMESTRE) {
			$unite = " trimestre(s)";
		}
		else if ($joui->unite == DelaiJouissance::SEMESTRE) {
			$unite = " semestre(s)";
		}
		else {
			$unite = " mois";
		}
		return ($joui->value . " " . $unite);
	}
	public function			getDelaiVente() {
		$joui = DelaiJouissance::getById($this->id)[0];
		$unite = "";
		if ($joui->unite_vente == DelaiJouissance::TRIMESTRE) {
			$unite = " trimestre(s)";
		}
		else if ($joui->unite_vente == DelaiJouissance::SEMESTRE) {
			$unite = " semestre(s)";
		}
		else {
			$unite = " mois";
		}
		return ($joui->value_vente. " " . $unite);
	}
	public function			show() {
		echo "=============SCPI===========<br />";
		echo "Id : " . $this->id . "<br />";
		echo "Nom : " . $this->name . "<br />";
		echo "Delais de jouissance : " . $this->getDelaiJouissanceString() . "<br />";
		echo "Delais Vente : " . $this->getDelaiVente() . "<br />";
		echo "Type : " . self::$type[$this->type_id] . "<br />";
		echo "Prix Vendeur Actuel : " .  $this->prix_vendeur. " euros <br />";
		echo "Dividendes pour cette annee : <br />";
		foreach($this->Acompte["data"] as $key => $elm) {
			echo "\t- " . $key . " : " . $elm. " euros <br />";
		}
	}
	public function		getType()
	{
		return ($this->type_id);
	}
	public function			getTypeStr()
	{
		return (self::$type[$this->getType()]);
	}
	public function			getPrixVendeur() {
		return ($this->prix_vendeur);
	}
	public function			getPrixAcquereur() {
		return ($this->prix_acquereur);
	}
	public function			getActualValue()
	{
		if ($this->getType() == 5)
		{
			$rt = $this->getPrixVendeur();
			if (empty($rt))
				return ($this->getValeurRealisationManuelle());
			return ($rt);
		}
		else
		{
			$rt = $this->getValeurRealisation();
			if (empty($rt))
				return ($this->getValeurRealisationManuelle());
			return ($rt);
		}
	}
	public function			getDateCreation() {
		return (DateTime::createFromFormat("Y-m-d   H:i:s", $this->created_at));
	}
	public function			getTypeCapital() {
		return ($this->TypeCapital);
	}
	public function			getCategory() {
		return ($this->category_id);
	}
	public function			getCategoryStr() {
		return (CategoriesScpi::getAll()[$this->category_id]);
		//return (self::$catName[$this->category_id]);
	}
	public function			getGeoStr() {
		$rt = "";
		foreach (self::$geo as $elm)
		{
			if (isset($this->$elm))
			{
				$rt .= $elm . " ( " . $this->$elm . " % ) <br />";
			}
		}
		return ($rt);
	}
	public function			getValeurRealisation() {
		return (floatval($this->ValeurRealisation));
	}
	public function			getValeurReconstitution() {
		return (floatval($this->ValeurReconstitution));
	}
	public function			getTof() {
		if (isset($this->Tof) && $this->Tof > 0)
			return ($this->Tof);
		return (0);
	}
	public function			getClientsHaveThis() {
		$rt = Transaction::getFromKeyValue("id_scpi", $this->id);
		if (count($rt))
			return (true);
		return (false);
	}
	public function			getAllDelaiJouissance() {
		return (DelaiJouissance::getAllForScpi($this->id));
	}
	public function			getValeurRealisationManuelle() {
		$rt = ValeurRealisation::getFromScpiId($this->id);
		if (!empty($rt))
			return ($rt[0]->value);
		return (0);
	}
	public static function	getForStore() {
		$rt = [];
		foreach (self::getAll() as $key => $elm)
		{
			$elm->value = $elm->getActualValue();
			$elm->typeStr = $elm->getTypeStr();
			$elm->strategie = $elm->getStrategie();
			$elm->conseils_mscpi = $elm->getConseilsMscpi();
			$elm->category = $elm->getCategoryStr();
			$elm->adequation = $elm->getAdequation();
			$elm->actualValue = $elm->getActualValue();

			//BUG: There is a bug here must see whats the problems
//			if ($elm->getSocieteGestion() !== null)
			$elm->societeDeGestionName = $elm->getSocieteGestion()->getName();
			$elm->societeDeGestionAdresse = $elm->getSocieteGestion()->getAdresse();
			$elm->societeDeGestionId = $elm->getSocieteGestion()->getId();
			$elm->showOpportunite = $elm->checkShowOpportunite();
			$elm->age = $elm->getAge();
			$rt[] = $elm;

		}
		return ($rt);
	}
	public static function	getForFrontStore() {
		$rt = [];
		foreach (self::getAll() as $key => $elm)
		{
			if ($elm->online)
				$rt[] = [
					'id' => $elm->id,
					'name' => $elm->name,
					'showOpportunite' => $elm->checkShowOpportunite(),
					'value' => $elm->getPrixAcquereur(),
				];
		}


		return ($rt);
	}





	public function	getName() {
		return ($this->name);
	}
	public static function	getByNameNoCase($name) {
		$scpis = self::getAll();
		foreach ($scpis as $key => $elm)
		{
			if (strtolower($elm->name) == strtolower($name))
				return ($elm);
		}
		return (null);
	}
	public static function	getByName($name) {
		$scpis = self::getAll();
		foreach ($scpis as $key => $elm)
		{
			if ($elm->name == $name)
				return ($elm);
		}
		return (null);
	}
	public function			getConseilsMscpi() {
		$rt = ScpiGestion::getFromIdScpi($this->id);
		if (empty($rt))
			return (null);
		return ($rt->getConseilsMscpi());
	}
	public function			getAdequation() {
		$rt = ScpiGestion::getFromIdScpi($this->id);
		if (empty($rt))
			return (null);
		return ($rt->getAdequation());
	}
	public function			getCategorieSecondaireStr() {
		$first = true;
		$rt = "";
		foreach ($this->categorieSecondaire as $key => $elm)
		{
			if (!$first)
				$rt .= ", ";
			$rt .= $elm['name'];
			$first = false;
		}
		return ($rt);
	}



	public function			getStrategie() {
		return (str_replace("\\n", "\n", $this->Strategie));
	}
	public function			getValeurIsf() {
		$rt = ScpiGestion::getFromIdScpi($this->id);
		if (empty($rt))
			return (null);
		return ($rt->getValeurIsf());
	}
	public function			getValeurIfi2018() {
		$rt = ScpiGestion::getFromIdScpi($this->id);
		if (empty($rt))
			return (null);
		return ($rt->getValeurIfi2018());
	}
	public function			getValeurIfiExpatrie2018() {
		$rt = ScpiGestion::getFromIdScpi($this->id);
		if (empty($rt))
			return (null);
		return ($rt->getValeurIfiExpatrie2018());
	}
	public function			getScpiGestion() {
		$rt = ScpiGestion::getFromIdScpi($this->id);
		if (empty($rt))
			return (null);
		return ($rt);
	}
	public function getSocieteGestion() {
		return (SocieteDeGestion::getFromId($this->company_id));
	}
	public function mscpiHave() {
		$req = "SELECT * FROM `TRANSACTION` WHERE id_excel IS NOT NULL AND id_excel != 0 AND id_donneur_ordre = 10 AND id_scpi = ?;";
		$rt = Database::prepare("mscpi_db", $req, [$this->id], "Transaction");
		return (count($rt) > 0);
	}
	public function insertFourchetteRemuneration($tranche_haute, $tranche_basse, $date_execution = 0) {
		return (FourchetteRemuneration::shortInsert($tranche_haute, $tranche_basse, $this, $date_execution));
	}
	public function getFourchetteRemuneration() {
		return (FourchetteRemuneration::getFromKeyValue("id_scpi", $this->id));
	}
	public function getLastFourchetteRemuneration() {
		return (FourchetteRemuneration::getLastForScpi($this->id));
	}
	public static function getScpiOpportunite() {
		$rt = [];
		foreach (self::getAll() as $key => $elm)
		{
			if ($elm->checkShowOpportunite())
				$rt[$key] = $elm;
		}
		return ($rt);
	}
	public function			checkShowOpportunite()
	{
		$rt = (ScpiGestion::getFromKeyValue("id_scpi", $this->id));
		if (empty($rt))
			return (null);
		return ($rt[0]->getShowOpportunite());
	}
    /**
     * \brief       Recupere les frais de souscription
     *

     * \return    return les frais de souscriptions
     */

	public function         getFraisSouscription()
    {
        return ($this->FraisSouscription);
    }

    /**
     * \brief       Recupere la date de creation de la scpi
     * \details     Si la date de creation n'existe pas alors return null, sinon on retourne la date avec le bon format
     *

     * \return    return la date dans la variable $rt
     */

	public function			getDateCreationScpi() {
		if ($this->DateCreation == -1)
			return (null);
		$rt =  new DateTime();
		$rt->setTimestamp($this->DateCreation);
		return ($rt);
	}


    /**
     * \brief       Recupere l'age de la creation spi
     * \details     Cet function va permetre de recupere la date de creations scpi et de compare la date actuelle avec la date recuperer pour retourner l'age de la creation de la scpi
     *

     * \return    return l'age de la creation
     */
	public function			getAge() {
		$dateCreation = $this->getDateCreationScpi();
		if ($dateCreation == null)
			return (null);
		$date = $dateCreation->getTimeStamp();
		$now = DateTime::createFromFormat("d/m/Y H:i:s", date("d/m/Y") . " 00:00:00")->getTimeStamp();
		$age = ($now - $date) / (365.25 * 60 * 60 * 24);
		return ($age);
	}
}














