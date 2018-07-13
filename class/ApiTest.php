<?php
/**
 * Created by PhpStorm.
 * User: vthomas
 * Date: 08/03/2018
 * Time: 17:44
 */

class ApiRender extends ApiV2 {
	public $o;
	public $n;
	public $scpiRoute;
	public $data = "";
	protected static $has_data;

	public static function tableError(){
		static::$has_data = false;
		ob_start();
		echo "<table class='ui fixed celled table'>";
		echo "<tr><th class='collapsed'>Id</th><th class='collapsed'>Action</th><th class='collapsed'>Ancienne Api</th><th class='collapsed'>Nouvelle Api</th></tr>" . PHP_EOL;
	}

	public static function tableErrorEnd(){
		echo "</table>" . PHP_EOL;
		$x = ob_get_contents();
		ob_end_clean();
		if (static::$has_data)
			return ($x);
		return ("");
	}

	public static function addLine($id, $key, $a, $b) {
		static::$has_data = true;
		echo "<tr><td>" . $id . "</td><td>" . $key . "</td><td>" . $a . "</td><td>" . $b . "</td><tr>" . PHP_EOL;
	}
	public static function addException($id, $message){
		static::$has_data = true;
		echo "<tr><td>" . $id . "</td><td colspan='3'>" . $message . "</td></tr>" . PHP_EOL;
	}

	/**
	 * @return bool
	 */
	public function compare() {
		$ret = true;
		$this->tableError();
		foreach ($this->o as $key => $value){
			$t = null;
			foreach ($this->n as $el) {
				if ($el['id'] == $value['id']) {
					$t = $el;
					break;
				}
			}
			$line_success = true;
			foreach ($this->scpiRoute as $nkey => $nel) {
				try {
					$key_sub = explode(".", $nkey);
					$el_sub = explode(".", $nel);
					$nkey = preg_replace("/\#/","." , $nkey);
					$nel = preg_replace("/\#/","." , $nel);
					$v = $value;
					$k = $t;

					//Get subkey value
					foreach($key_sub as $sk){
						if (is_array($v) && !array_key_exists($sk, $v)) {
							throw new Exception("Key don't exist in old API: " . $nkey);
						}
						$v = $v[$sk];
					}
					foreach($el_sub as $sk){
						if (is_array($k) && !array_key_exists($sk, $k)) {
							throw new Exception("Key don't exist in old API: " . $nkey);
						}
						$k = $k[$sk];
					}

					try {
						if (!is_string($k) || !is_string($v))
							throw new Exception("Not a string");
						$timea = new DateTime($k);
						$timeb = new DateTime($v);
						if ($timea->getTimestamp() !== $timeb->getTimestamp())
							echo $this->addException('', 'Time Inequal');
						continue;
					}
					catch (Exception $e) {}
					$tmp = ($k == $v);
					$line_success = $line_success && $tmp;
					$a = (is_array($k)) ? json_encode($k) : $k;
					$b = (is_array($v)) ? json_encode($v) : $v;
					if (!$tmp) $this->addLine($value['id'], $nkey . " | " . $nel, $b, $a);
				}
				catch (Exception $e) {
					$line_success = false;
					$this->addException($value['id'], $e->getMessage());
				}
			}
			$ret = $ret && $line_success;
		}
		$this->data .= $this->tableErrorEnd();
		return ($ret);
	}
}

class ApiScpi extends ApiRender
{
	private static $path = [
		"req" => "getAllSCPI"
	];

	public $scpiRoute = [
		"id"					=> "id",
		"type_id"				=> "type_id",
		"category_id"			=> "category_id",
		"company_id"			=> "company_id",
		"parent_id"				=>"parent_id",
		"token"					=> "token",
		"name"					=> "name",
		"slug"					=> "slug",
		"created_at"			=> "created_at",
		"absorbed_at"			=> "absorbed_at",
		"online"				=> "online",
//		"date_transaction"		=> "price#date",
		"prix_vendeur"			=> "price#vendeur",
		"prix_acquereur"		=> "price#acquereur",
//		"Acompte"				=> "Acompte",
		"TypeCapital"			=> "TypeCapital",
		"Tof"					=> "Tof",
		"ValeurRealisation"		=> "ValeurRealisation",
		"FraisSouscription"		=> "frais_de_souscription",
//		"FraisSecondaires"		=> "frais_marche_secondaire_cf",
		"ValeurReconstitution"	=> "ValeurReconstitution",
		"Strategie"				=> "Strategie",
		"Tdvm"					=> "Tdvm",
		"AllAcomptes"			=> "AllAcomptes",
		"AllAcomptesEx"			=> "AllAcomptesEx",
		"categorieSecondaire"	=> "CategorieSecondaire",
	];
	public $scpiRoute2 = [
		"id"					=> "id",
		"name"					=> "name",
		"FraisSouscription"		=> "frais_de_souscription",
		"type_id"				=> "type_id",
		"category_id"			=> "category_id",
		"company_id"			=> "company_id",
		"parent_id"				=> "parent_id",
		"token"					=> "token",
		"slug"					=> "slug",
		"created_at"			=> "created_at",
		"absorbed_at"			=> "absorbed_at",
		"online"				=> "online",
		"TypeCapital"			=> "TypeCapital",
//		"Régions"				=> "Régions",
//		"Ile-de-France"			=> "Ile-de-France",
//		"Paris"					=> "Paris",
		"ValeurRealisation"		=> "ValeurRealisation",
		"Strategie"				=> "Strategie",
		"Tdvm"					=> "Tdvm",
		"ValeurReconstitution"	=> "ValeurReconstitution",
		"date_transaction"		=> "price#date",
		"prix_acquereur"		=> "price#acquereur",
		"Tof"					=> "Tof",
		"AllAcomptes"			=> "AllAcomptes",
		"AllAcomptesEx"			=> "AllAcomptesEx"
	];

	public $o = null;
	public $n = null;

	public $data = "";

	public function __construct() {

	}

	public function test() {
		$this->n = $this->getRequestJsonScpi();
		$this->o = Api::getRequestJson(["req" => "getAllSCPI"]);
//		dbg($this->o);
//		die();
		$ret = count($this->n) === count($this->o);
		$ret = $ret && $this->compare();
		return [
			'name' => get_called_class(),
			'return' => $ret,
			'desc' => ($this->data)
		];
	}
}

/* ****************************************************************************************************************** */


class ApiSociety extends ApiRender
{
	private static $path = [
		"req" => "getAllCompany"
	];

	public $scpiRoute = [
		"id" => "id",
		"name" => "name",
		"slug" => "slug"
	];

	public $o = null;
	public $n = null;

	public $data = "";

	public function __construct() {}

	public function test() {
		$this->n = $this->getRequestJsonSocieteGestion();
		$this->o = Api::getRequestJson(static::$path);

		$ret = count($this->n) === count($this->o);
		if (!$ret) {
			$this->tableError();
			$this->addLine("", "The number of object is different", count($this->o), count($this->n));
			$this->data .= $this->tableErrorEnd();
		}
		else
			$ret = $this->compare();
		return [
			'name' => get_called_class(),
			'return' => $ret,
			'desc' => ($this->data)
		];
	}
}

/* ****************************************************************************************************************** */

class ApiPublication extends ApiRender
{
	private static $path = [
		"req" => "getAllCompany"
	];

	public $scpiRoute = [
		"id" => "id",
		"date_published" => "publishedAt.date",
		"title" => "title",
		"path" => "path",
		"site" => "site"
	];

	public $o = null;
	public $n = null;

	public $data = "";

	public function __construct() {}


	public function test() {
		$scpis = Apiv2::getRequestJsonScpi();

		$r = true;
		$x = 0;
		foreach ($scpis as $key => $scpi){
//			$x ++;
//			if ($x > 2)
//				break;
			$scpiList = [$scpi['id']];

			$this->n = $this->getRequestJsonPublications($scpiList);
			$this->o = Api::getRequestJson([
				"req" => "getPublicationSCPIs",
				"lst" => json_encode($scpiList)
			]);
			$ret = count($this->n) === count($this->o);
			if (!$ret) {
				$this->tableError();
				$this->addLine("", "The number of object is different", count($this->o), count($this->n));
				$this->data .= $this->tableErrorEnd();
			}
			else
				$ret = $this->compare();
			$r = $r && $ret;
		}

		return [
			'name' => get_called_class(),
			'return' => $r,
			'desc' => ($this->data)
		];
	}
}

/* ****************************************************************************************************************** */

class ApiActualite extends ApiRender
{
	private static $path = [
		"req" => "getAllCompany"
	];

	public $scpiRoute = [
		"id" => "id",
		"date_publication" => "publicationDate.date",
		"content" => "content",
	];

	public $o = null;
	public $n = null;

	public $data = "";

	public function __construct() {}


	public function test() {
		$scpis = Apiv2::getRequestJsonScpi();

		$r = true;
		foreach ($scpis as $key => $scpi){
			$scpiList = [$scpi['id']];

			$this->n = $this->getRequestJsonActus($scpiList);
			$this->o = Api::getRequestJson([
				"req" => "getActualitySCPIs",
				"lst" => json_encode($scpiList)
			]);
			$ret = count($this->n) === count($this->o);
			if (!$ret) {
				$this->tableError();
				$this->addLine($scpi['id'], "The number of object is different", count($this->o), count($this->n));
				$this->data .= $this->tableErrorEnd();
			}
			else
				$ret = $this->compare();
			$r = $r && $ret;
		}

		return [
			'name' => get_called_class(),
			'return' => $r,
			'desc' => ($this->data)
		];
	}
}

/* ****************************************************************************************************************** */

class ApiBuilding extends ApiRender
{
	private static $path = [
		"req" => "getAllCompany"
	];

	public $scpiRoute = [
		"id" => "id",
		"acquisition_date" => "acquisition_date",
	];

	public $o = null;
	public $n = null;

	public $data = "";

	public function __construct() {}


	public function test() {
		$scpis = Apiv2::getRequestJsonScpi();

		$r = true;
		foreach ($scpis as $key => $scpi){
			$scpiList = [$scpi['id']];

			$this->n = $this->getRequestJsonBuildings($scpiList);
			$this->o = Api::getRequestJson([
				"req" => "getAcquisitionSCPIs2",
				"lst" => json_encode($scpiList)
			]);
			$ret = count($this->n) === count($this->o);
			if (!$ret) {
				$this->tableError();
				$this->addLine($scpi['id'], "The number of object is different", count($this->o), count($this->n));
				$this->data .= $this->tableErrorEnd();
			}
			else
				$ret = $this->compare();
			$r = $r && $ret;
		}

		return [
			'name' => get_called_class(),
			'return' => $r,
			'desc' => ($this->data)
		];
	}
}

/* ****************************************************************************************************************** */
