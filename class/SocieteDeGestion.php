<?php
require_once("core/Database.php");
require_once("core/Apiv2.php");
require_once("core/Cache.php");
require_once("Scpi.php");
/**
 * \file          SocieteDeGestion.php
 * \author    Florian
 * \date       11 Avril 2018
 * \brief       La class recupere les donner du cache.php pour les afficher .
 *
 * \details    Cette classe permet de recuperer les données du cache et de crée des fonctions qui vont utiliser le cache.
 */
function cmpSG($a, $b) {
	if ($a == false || $b == false)
	{
		return (1);
	}
	return (strcasecmp($a->name, $b->name));
}

class SocieteDeGestion extends Apiv2
{
	use Cache;
	private static	$_lstAll = null;
	protected static	$staticDataCacheAllSocieteDeGestion = null;


    /**
     * \brief       Recupere tout le cache de societe de Gestion
     * \details   Recupere tout le cache de societe de Gestion et verifie si la variable $_lstAll est egale a nul pour lancer la function qui permet de recuperer tout le cache
     *

     * \return    return la variable $_lstAll qui contient le cache des societe de gestion
     */
	public static function	getAll()
	{
		if (self::$_lstAll == null) {
			self::$_lstAll = self::getCacheAllSocieteDeGestion();
		}
		return (self::$_lstAll);

	}


    /**
     * \brief       Renvoi le nom
     * \details    Renvoi le nom qui es contenu en cache ce cache communiquant avec l'api
     *
     * \return    le nom.
     */
	public function getName() {
		return ($this->name);
	}


	public function getAdresse() {
	    return ($this->adresse);
    }

    public function getId() {
        return ($this->id);
    }

	public static function	getFromId($id)
	{
		if (self::$_lstAll == null)
			self::getAll();
		return (self::$_lstAll[$id]);
	}

	public static function	generateCacheAllSocieteDeGestion() {
		return (parent::getRequestJsonSocieteGestion());

		/*
		$api = parent::getRequestObjects(
			array(
				"req" => "getAllCompany"
				)
			);
		*/
		$rt = array();
		foreach ($api as $key => $elm)
			$rt[$elm->id] = $elm;
		uasort($rt, "cmpSG");
		return ($rt);
	}
	public function getScpi() {
		$rt = [];
		foreach (Scpi::getAll() as $key => $elm)
		{
			if ($elm->company_id == $this->id)
				$rt[$elm->id] = $elm;
		}
		return ($rt);
	}


    /**
     * \brief       Renvoi le cache de societe de gestion en fonction du name
     * \details    La function prend comme parametre le name et compare avec le nom du cache pour pouvoir return $elm qui contiendra tout le cache
     *
     * \return    return tout le cache tant que le name passer en parametre de function = name cache, sinon il return null.
     */
	public static function	getByName($name) {
		$sgs = self::getAll();
		foreach ($sgs as $key => $elm)
		{
			if ($elm->name == $name)
				return ($elm);
		}
		return (null);
	}
	public static function	getForStore() {
		$rt =  self::getAll();
		foreach ($rt as &$societe)
		{
			$societe->lstScpi = [];
			foreach ($societe->getScpi() as $key => $elm)
			{
				$societe->lstScpi[] = $elm->id;
			}
		}
		return ($rt);
	}
}
