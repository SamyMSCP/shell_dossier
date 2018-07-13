<?php
/*      __  __        _  _  _                          */
/*     |  \/  |  ___ (_)| || |  ___  _   _  _ __  ___  */
/*     | |\/| | / _ \| || || | / _ \| | | || '__|/ _ \ */
/*     | |  | ||  __/| || || ||  __/| |_| || |  |  __/ */
/*     |_|  |_| \___||_||_||_| \___| \__,_||_|   \___| */
/*                        _                            */
/*      ___   ___  _ __  (_)    ___  ___   _ __ ___    */
/*     / __| / __|| '_ \ | |   / __|/ _ \ | '_ ` _ \   */
/*     \__ \| (__ | |_) || | _| (__| (_) || | | | | |  */
/*     |___/ \___|| .__/ |_|(_)\___|\___/ |_| |_| |_|  */
/*                |_|                                  */

/*
	Cette classe gère les requètes ajax du site.

	Format des réponses :
		Si tout est okay : 
			Renvoi les données effectivement enregistrées avec un nouveau token !
		Si tout n'est pas okay :
			Renvoi les données en ajoutant les erreures avec un nouveau token !

	Comment limiter le nombre de requetes ?
*/
class GraphApi {

	private $_request = [];

	public function __construct($datas) {
		if (!isset($datas['Receiver']))
			self::error(403, "Le format de la requete est invalide");
		function setNull(&$elm) {
			foreach ($elm as $key => &$value) {
				if (is_array($value))
					setNull($value);
				else if ($value === "")
					$value = null;
				else if ($value === 'true')
					$value = true;
				else if ($value === 'false')
					$value = false;
			}
			return ($elm);
		}
		$this->_request = setNull($datas);
		//error();
	}

	public function __destruct() {}

	public function doRequestTable2() {
		if (!isset($this->_request['Action']) || !isset($this->_request['Datas']))
			self::error(403, "Le format de la requete n'est pas valide");

		//if (!method_exists($this->_request['Receiver'], $this->_request['Action']))
		if ($this->_request['Action'] != "commit")
			self::error(403, "L'action demandée n'existe pas");

		$class = $this->_request['Receiver'];
		$action = $this->_request['Action'];
		$datas = $this->_request['Datas'];

		if (!isset($datas['id']['value']))
			self::error(403, "pas okay");


		if ($datas['id']['value'] == 0)
			$entity = new $class();
		else
			$entity = $class::getById($datas['id']['value']);

		$entity->beforeSetCaller();

		$tmpError = $entity->setForGraphApi($datas);
		if ($tmpError === true && $entity->commit()) {
			$store = StoreGenerator::getInstance();
			$store->addToState($entity);
			$store->setSelected($entity);
			$store->success();
		}
			//self::success($entity->getVuexState());
		else {
			$store = StoreGenerator::getInstance();
			//$store->addToState($entity);
			$store->setSelected($tmpError, $class);
			$store->error();
		}
			//self::error(403, $tmpError);
	}

	public function doRequestCodeVille() {
		$datas = $this->_request['Datas'];
		if (!isset($datas['code']) && !isset($datas['ville']))
			self::success([]);
		else if (isset($datas['code']) && isset($datas['ville']))
			self::success(CodeVille::getFromCodeCommune($datas['code'], $datas['ville']));
		else if (isset($datas['code']))
			self::success(CodeVille::getFromCode($datas['code']));
		else if (isset($datas['ville']))
			self::success(CodeVille::getFromCommune($datas['ville']));
	}

	public function doRequestProcedure() {
		if (!isset($this->_request['Action']) || !isset($this->_request['Datas']))
			self::error(403, "Le format de la requete n'est pas valide");

		if (
			$this->_request['Action'] != "setActual" &&
			$this->_request['Action'] != "nextStep" &&
			$this->_request['Action'] != "previousStep" &&
			$this->_request['Action'] != "setBlock" &&
			$this->_request['Action'] != "setIncoherence"
		)
			self::error(403, "L'action demandée n'existe pas");

		$class = $this->_request['Receiver'];
		$action = $this->_request['Action'];
		$datas = $this->_request['Datas'];


		if ($this->_request['Action'] == "nextStep")
			$class::nextStep($datas);
		else if ($this->_request['Action'] == "setActual")
			$class::setActual($datas);
		else if ($this->_request['Action'] == "previousStep")
			$class::previousStep($datas);
		else if ($this->_request['Action'] == "setBlock")
			$class::setBlock($datas);
		else if ($this->_request['Action'] == "setIncoherence")
			$class::setIncoherence($datas);
	}

	public function doRequest() {
		if (is_subclass_of($this->_request['Receiver'], "Table2"))
			return ($this->doRequestTable2());


		if (is_subclass_of($this->_request['Receiver'], "Procedure"))
			return ($this->doRequestProcedure());

		if ($this->_request['Receiver'] === "CodeVille")
			return ($this->doRequestCodeVille());

		self::error(403, "L'action demandée n'existe pas");
	}

	public function getRequest() { return ($this->_request); }

	public static function success($rt) {
		if (!is_array($rt))
			self::error(403, "Une erreur est survenue, nous en sommes désolés !");
		echo json_encode($rt);
		exit();
	}

	public static function error($code, $content = []) {
		http_response_code($code);
		echo json_encode($content);
		exit();
	}

}
