<?php

function cmpActu($a, $b)
{
	$aDate = (new DateTime($a["publicationDate"]['date']))->getTimestamp();
	$bDate = (new DateTime($b["publicationDate"]['date']))->getTimestamp();
	return ($bDate - $aDate);
}
function cmpPublications($a, $b) {
	$aDate = (new DateTime($a->publishedAt['date']))->getTimestamp();
	$bDate = (new DateTime($b->publishedAt['date']))->getTimestamp();
}

function cmpBuildings($a, $b)
{
	return (0);
	$aDate = (DateTime::createFromFormat("d/m/Y", $a["acquisition_date"]))->getTimestamp();
	$bDate = (DateTime::createFromFormat("d/m/Y", $b["acquisition_date"]))->getTimestamp();
	return ($bDate - $aDate);
}

function cmpAcqui($a, $b) {
	$aDate = (DateTime::createFromFormat("d/m/Y", $a["acquisition_date"]))->getTimestamp();
	$bDate = (DateTime::createFromFormat("d/m/Y", $b["acquisition_date"]))->getTimestamp();
	return ($bDate - $aDate);
}

class Apiv2
{
	private function __construct()
	{
	}

	public static function getRequestJson($req)
	{
		//echo API_URL . $req;
		//exit();
		$headers = [];
		$headers[] = 'X-Auth-Token: ' . API_TOKEN;
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, API_URL . $req);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_USERPWD, "admin:preprod!2042");
		$output = curl_exec($ch);
		curl_close($ch);
		$output = json_decode($output, true);
        //var_dump($output); exit();

        if ($output == null)
			$output = "{}";
		return ($output);
	}

    public static function getRequestJsonWithNoDecode($req)
    {
        //echo API_URL . $req;
        //exit();
        $headers = [];
        $headers[] = 'X-Auth-Token: ' . API_TOKEN;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, API_URL . $req);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERPWD, "admin:preprod!2042");
        $output = curl_exec($ch);
        curl_close($ch);
        //var_dump($output); exit();

        if ($output == null)
            $output = "{}";
        return ($output);
    }

	public static function getRequestJsonScpi()
	{
		$rt = self::prepareScpi(self::getRequestJson('scpi/limit'));
		$t = [];

		foreach ($rt as $el) {
			$x = self::arrayToObject($el, get_called_class());
			$x->prix_vendeur = $x->{'price.vendeur'};
			$x->FraisSouscription = $x->{'frais_de_souscription'};
			$x->date_transaction = $x->{'price.date'};
			$x->prix_acquereur = $x->{'price.acquereur'};

			$d = new DateTime($x->DateCreation);
			$x->DateCreation = $d->getTimestamp();
			//$x->DateCreation = $d->format("d/m/Y");
			$t[] = $x;

		}
		return ($t);
	}

	public static function getRequestJsonSocieteGestion()
	{
		return (self::prepareSocieteGestion(self::getRequestJson('society/all')));
	}

	public function prepareSocieteGestion($sg)
	{
		$rt = [];
		foreach ($sg as $key => $elm) {
			$rt[$elm['id']] = static::arrayToObject($elm, get_called_class());
		}
		return ($rt);
	}

	public static function getRequestJsonBuildings($arr)
	{
		return (static::prepareBuildingsFromScpi(static::getRequestJson('acquisition/list/' . json_encode($arr))));
		//return (self::getRequestJson('acquisition/list/' . json_encode($arr). "/0"));
	}

	public function prepareBuildingsFromScpi($arr)
	{
		//return ($arr);
		$rt = [];
		foreach ($arr as $key => $scpiLst) {
			//var_dump(is_array($scpiLst));
			if (is_array($scpiLst))
				foreach ($scpiLst as $key2 => $elm)
					if (!isset($rt[$elm['id']]) && !empty($elm['acquisition_date']))
						//$rt[$elm['id']] = $elm;
						$rt[$elm['id']] = static::arrayToObject($elm, get_called_class());
		}
		usort($rt, "cmpBuildings");
		//exit();

		return ($rt);
	}


	/*
	 * Permet de recuperer une requete json prevenant de l'api
	 */

	public static function getRequestJsonContactPeriod($arr)
    {
        return (self::getRequestJsonWithNoDecode('contact/period/' . json_encode($arr)));
    }

	public static function getRequestJsonPublications($arr)
	{
		return (self::preparePublicationsFromScpi(self::getRequestJson('publication/list/' . json_encode($arr))));
	}

	public function preparePublicationsFromScpi($arr)
	{
		$rt = [];
		foreach ($arr as $key => $scpiLst)
			foreach($scpiLst as $key2 => $elm) {
				if (!isset($rt[$elm['id']]))
					$rt[$elm['id']] = static::arrayToObject($elm, get_called_class());

				//echo "salut";
			}
		usort($rt, "cmpPublications");
		return ($rt);
	}

	public static function getRequestJsonActus($arr)
	{
		return (self::prepareActusFromScpi(self::getRequestJson('posts/list/' . $arr)));
	}

	public static function getRequestJsonAllActus()
	{
		return (self::prepareActusFromScpi(self::getRequestJson('posts/all/0')));
	}

	public function prepareActusFromScpi($arr)
	{
		$rt = [];
		foreach ($arr as $key => $scpi) { // ici elm contient la liste par scpi !
			foreach ($scpi as $key2 => $elm) { // ici elm contient la liste par scpi !
				if (!isset($rt[$elm['id']])) {
					$elm['date_publication'] = $elm['publicationDate']['date'];
					$rt[$elm['id']] = $elm;
				}
			}
		}
		usort($rt, "cmpActu");
		return ($rt);
	}

	public function prepareScpi($scpis)
	{
		$year = date("Y");
		foreach ($scpis as $key => $elm) {
			if (!empty($elm["pie_geo"]["Régions"]))
				$scpis[$key]["Régions"] = floatval($elm["pie_geo"]["Régions"]);
			if (!empty($elm["pie_geo"]["Ile-de-France"]))
				$scpis[$key]["Ile-de-France"] = floatval($elm["pie_geo"]["Ile-de-France"]);
			if (!empty($elm["pie_geo"]["Paris"]))
				$scpis[$key]["Paris"] = floatval($elm["pie_geo"]["Paris"]);
			if (!empty($elm["pie_geo"]["Etranger"]))
				$scpis[$key]["Etranger"] = floatval($elm["pie_geo"]["Etranger"]);
			if (!empty($elm["pie_geo"]["Immobilisations"]))
				$scpis[$key]["Immobilisations"] = floatval($elm["pie_geo"]["Immobilisations"]);
			if ($scpis[$key]["type_id"] == "rendement")
				$scpis[$key]['type_id'] = 5;
			else if ($scpis[$key]["type_id"] == "fiscale")
				$scpis[$key]['type_id'] = 6;
			$scpis[$key]["ValeurReconstitution"] = $elm["ValeurReconstitution"]["value"];

			$scpis[$key]['Acompte'] = ['unit' => 1, 'data' => []];
			if (isset($elm['AllAcomptes'][$year])) {
				foreach ($elm['AllAcomptes'][$year] as $key2 => $elm2) {
					$scpis[$key]['Acompte']['data']['T' . $key2] = $elm2;
				}
			}
			$scpis[$key]["societeDeGestion"] = ["name" => $scpis[$key]['company_name']];
			$scpis[$key]['Tdvm'] = $scpis[$key]['tdvm']['value'];
			$scpis[$key]['online'] = (!empty($scpis[$key]['online'])) ? 1 : 0;

			self::prepareAcomptes($scpis[$key]["AllAcomptes"]);
			self::prepareAcomptes($scpis[$key]["AllAcomptesEx"]);
		}
		return ($scpis);
	}

	private static function prepareAcomptes(& $datas)
	{
		foreach ($datas as $key => & $elm) {
			$nArr = [];
			foreach ($elm as $key2 => & $elm2) {
				if (isset($elm2) && $elm2 !== null)
					$nArr[substr($key2, 1)] = $elm2;
			}
			$datas[$key] = $nArr;
		}
	}

	protected static function arrayToObject($array, $class)
	{
		$rt = new $class;
		if (is_array($array)) {
			foreach ($array as $key => $value) {
				$rt->$key = $value;
			}
		}
		return ($rt);
	}

	protected static function getRequestObject($req)
	{
		$data = self::getRequestJson($req);
		if ($data === "{}")
			return null;
		return (self::arrayToObject($data[0], get_called_class()));
	}

	public static function getRequestObjects($req)
	{
		$rt = array();
		$data = self::getRequestJson($req);
		if ($data === "{}")
			return null;
		foreach ($data as $array) {
			$rt[] = self::arrayToObject($array, get_called_class());
		}
		return ($rt);
	}

//Apiv2::getRequestJsonActusFromScpi()
	public static function getRequestJsonCategories()
	{
		return self::getRequestJson('scpi/categories');
	}

	public static function getRequestJsonActusFromScpi($arr, $nbr = null)
	{
		if ($nbr == null)
			return (self::prepareActusFromScpi(self::getRequestJson('posts/list/' . json_encode($arr))));
		else {
			$rt = self::prepareActusFromScpi(self::getRequestJson('posts/list/' . json_encode($arr) . '/' . $nbr));
			$t = [];
			$rt = array_slice($rt, 0, $nbr);
			foreach ($rt as $el) {
				$t[] = self::arrayToObject($el, get_called_class());
			}
			return ($t);
		}
	}

	public static function getRequestJsonAcquisition($array, $len = 0)
	{
		$x = [];
		$x = self::getRequestJson(("acquisition/list/" . json_encode($array) . (($len !== 0) ? "/" . $len : "")));
		return (self::prepareAcquisition($x));
	}

	public static function prepareAcquisition($arr)
	{
		$rt = [];
		foreach ($arr as $key => $scpi) { // ici elm contient la liste par scpi !
			foreach ($scpi as $key2 => $elm) { // ici elm contient la liste par scpi !
				if (!isset($rt[$elm['id']])) {
					$rt[$elm['id']] = $elm;
				}
			}
		}
		usort($rt, "cmpAcqui");
		$nw = [];
		foreach ($rt as $el) {
			$nw[] = self::arrayToObject($el, get_called_class());
		}
		return ($nw);
	}



}
