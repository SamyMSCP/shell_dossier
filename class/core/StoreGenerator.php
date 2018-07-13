<?php

class StoreGenerator {
	protected static $_instance = null;
	private static $_autoload = [
		"PersonnePhysique",
		"Beneficiaire2",
		"Projet2",
		"SituationPhysique",
		"ProfilInvestisseur2",
		"PersonneMorale",
		"Transaction2",
	];
	protected $_name;
	protected $_classes = [];
	protected $_value = [];

	protected $_components = [];
	protected $_modules = [];
	protected $_filters = [];
	protected $_watchers = [];
	protected $_dispatch = [];
	protected $_commit = [];

	public function __construct($name) {
		if (self::$_instance != null)
			return (false);
		$this->_name = $name;
		$this->_value = [
			"state" => [
				"global" => [
					"pages" => [
						"empty" => [
							"title" => "no title",
							"component" => null
						]
					],
					"session" => [
						"page" => "CheckProjet"
					]
				],
				"modules" => [],
				"datas" => []
			],
			"getters" => "",
			"actions" => "",
			"mutations" => ""
		];
		foreach (self::$_autoload as $toLoad) {
			$this->loadClass($toLoad);
		}
		self::$_instance = $this;
	}

	public static function getInstance() {
		if (self::$_instance == null)
			self::$_instance = new StoreGenerator("mscpi");
		return (self::$_instance);
	}

	public function setPage($page) {
		$this->_value['state']['global']['session']['page'] = $page;
	}

	public function __destruct() {}

	public function getName() { return ($this->$_name); }

	public function getState() {
		return ($this->_value['state']);
	}

	public function getStore() {
		return ($this->_value);
	}

	public function addPage($name, $config) {
		$this->_value["state"]['global']["pages"][$name] = $config;
	}

	public function getDatas($description = null) {
		$datas = $this->_value['state']['datas'];

		if ($description == null)
			return ($datas);

		$rt = [];
		foreach ($description as $elm) {
			$rt[$elm] =  $datas[$elm];
		}
		return ($rt);
	}

	public function getJsState() {
		return ([
			"datas" => $this->getDatas(),
			"dispatch" => $this->_dispatch,
			"commit" => $this->_commit,
		]);
	}

	public function getJsStore() {
		$state = json_encode($this->_value['state']);
		$getters = $this->_value['getters'];
		$mutations = $this->_value['mutations'];
		$actions = $this->_value['actions'];

		$watcher = "";

		foreach ($this->_watchers as $key => $elm) {
			$watcher .= "
				store.watch(
					(state) => {
						{$elm['getter']}
					},
					(data) => {
						{$elm['function']}
					}
				);
			";
		}

		return (
			"store.registerModule('mscpi', {
				state: $state,
				getters: {
					getSelectedPage: function(state, getters) {
						return (state.global.pages[state.global.session.page]);
					},
					getSelectedPageName: function(state, getters) {
						return (state.global.session.page);
					},
				" . $getters . "
				},
				mutations: {
					update_datas: function(state, payload) {
						if (typeof payload.datas != 'undefined') {
							var datas = payload['datas']
							for (dt in datas)
							{
								if (dt == 'token' )
									continue ;
								mergeEntity(state.datas[dt], datas[dt]);
							}
						}
					},
					set_page: function(state, payload) {
						if (typeof state.global.pages[payload] != 'undefined') {
							state.global.session.page = payload;
							document.title = state.global.pages[payload].title;
						}
					},
					" . $mutations . "},
				actions: {
					update_datas: function(context, payload) {
						context.commit('update_datas', payload);
						if (typeof payload.dispatch != 'undefined') {
							var dispatch = payload['dispatch']
							for (dt in dispatch)
							{
								context.dispatch(dispatch[dt]['name'], dispatch[dt]['payload']);
							}
						}
					},
				" . $actions . "},
			});
			$watcher
			"
		);
	}
	/*
		$datas: un tableau d'instance héritant de la classe Table2. Chacune de ces instances seront insérée dans le state. si ca n'est pas encore fait, les actions, mutations et 
	*/
	public function setSelectedProjet($projet, $class = null, $error = true) {
		if (!($projet instanceof Projet2))
			return ;

		$this->setSelected($projet);
		$situation = $projet->getSituationPhysique()->get();
		if (!empty($situation))
			$this->setSelected($situation);

		$ben = $projet->getBeneficiaire()->get();
		if (!empty($ben))
			$this->setSelected($ben);
		foreach (ProcedureCreationProjet::$_steps as $elm) {
			if ($projet->getStatutParcourClient()->get() == $elm['name']) {
				$this->setPage($elm['page']);
			}
		}
		$profil = $projet->getProfilInvestisseurIncomplet();
		if (!empty($profil)) {
			$this->setSelected($profil, null, false);
		}
			
		// Recherche de la page
		// TODO chargement du profil d'investisseur si nécessaire.
		// Chargement de la personne physique !
	}
	public function setSelected($data, $class = null, $error = true) {
		$dt = null;
		if ($class === null)
		{
			if (!is_object($data) || !is_subclass_of($data, "Table2"))
				return (false);
			$class = get_class($data);
			$dt = $data->getVuexState($error);
		}
		else
			$dt = $data;

		if (!isset($this->_classes[$class])) {
			$this->loadClass($class);
			$this->_classes[$class] = true;
		}

		$this->_value['state']['datas'][$class]['selected'] = $dt;
		/*
		if ($class == "Beneficiaire2") {
			DevLogs::set($this->_value['state']
				['datas']
				[$class]
				['selected']);
			//error();
		}
		*/
		if ( $this->_value['state']['datas'][$class]['selected']['id']['value'] == 0) {
			$this->_value['state']
				['datas']
				[$class]
				['selected']
				['id']
				['value'] = -1;
		}
	}

	public function setSelectedError($data, $class = null, $error = false) {
		$dt = null;
		if ($class === null)
		{
			if (!is_object($data) || !is_subclass_of($data, "Table2"))
				return (false);
			$class = get_class($data);
			$dt = $data->getVuexState($error);
		}
		else
			$dt = $data;

		if (!isset($this->_classes[$class])) {
			$this->loadClass($class);
			$this->_classes[$class] = true;
		}

		$this->_value['state']['datas'][$class]['selected'] = $dt;
		if ( $this->_value['state']['datas'][$class]['selected']['id']['value'] == 0) {
			$this->_value['state']['datas'][$class]['selected']['id']['value'] = -1;
		}
	}

	public function addToState($datas) {
		if (is_array($datas)) {
			foreach ($datas as $k => $v) {
				if (!$this->addOneToState($v))
					return (false);
			}
		}
		else 
			return ($this->addOneToState($datas));
		return (true);
	}

	public function addOneToState($data) {
		if (!is_object($data) || !($data instanceof Table2))
			return (false);

		$class = get_class($data);

		if (!isset($this->_classes[$class])) {
			$this->loadClass($class);
			$this->_classes[$class] = true;
		}
		foreach ($this->_value['state']['datas'][$class]['lst'] as $key => $elm) {
			if ($elm['id']['value'] == $data->getId()) {
				$this->_value['state']['datas'][$class]['lst'][$key] = $data->getVuexState();
				return (true);
			}
		}
		$this->_value['state']['datas'][$class]['lst'][] = $data->getVuexState();
		return (true);
	}

	/*
		Cette methode charge une class, ses mutation, actions et getters.
	*/
	public function loadClass($className) {

		if (!is_subclass_of($className,  "Table2"))
			return (false);

		$nElm = new $className();
		if (!isset($this->_value['state']['datas'][$className]['lst']))
			$this->_value['state']['datas'][$className]['lst'] = [];
		$this->_value['state']['datas'][$className]['new'] = $nElm->getVuexState();
		$this->_value['state']['datas'][$className]['selected'] = $nElm->getVuexState();

		$this->_value['getters'] .= $className::getVuexGetters();
		$this->_value['mutations'] .= $className::getVuexMutations();
		$this->_value['actions'] .= $className::getVuexActions();
	}

	public function loadModule($className) {
		if (isset($this->_modules[$className]) && $this->_modules[$className] === true)
			return (false);

		require_once(__DIR__ . "/../StoreModule/$className.php");

		if (!is_subclass_of($className,  "StoreModule"))
			return (false);


		$this->_modules[$className] = true;

		$this->_value['state']['modules'][$className] = $className::getVuexState();
		$this->_value['getters'] .= $className::getVuexGetters();
		$this->_value['mutations'] .= $className::getVuexMutations();
		$this->_value['actions'] .= $className::getVuexActions();
			
		$watcher = $className::getVuexWatchers();
		if (is_array($watcher))
			$this->_watchers[] = $watcher;
	}

	// Renvoie la liste de tous les components par défaut.
	protected function getComponents() {
		// Boucle sur les classes et récupération de la liste des components et des filters.
	}

	public function loadCurrentDonneurDOrdre() {
		$dh = DonneurDOrdre::getCurrent();
		if (empty($dh))
			return (false);
		return ($this->loadDonneurDOrdre($dh));
	}

	public function loadDonneurDOrdre($donneurdordre) {
		if (!($donneurdordre instanceof DonneurDOrdre))
			return (false);
		self::addOneToState($donneurdordre);
		foreach (self::$_autoload as $toLoad) {
			$this->addToState($toLoad::getForDonneurDOrdre($donneurdordre));
		}
		return (true);
	}

	public static function getDefaultEditComponent($class) {
		$rt = "";
		foreach ($class::getDataTypes() as $type)
		{

		}
		return ($rt);
	}

	public static function getDefaultListComponent($store, $class) {
		return ("
			{{ \$store.state.$store->getName().datas.$class.lst }}<br />
		");
	}

	public function success() {
		http_response_code(200);
		$datas = $this->getJsState();
		$datas['token'] = $_SESSION['csrf'][0];
		echo json_encode($datas);
		exit();
	}
	public function error() {
		http_response_code(403);
		$datas = $this->getJsState();
		$datas['token'] = $_SESSION['csrf'][0];
		echo json_encode($datas);
		exit();
	}

	public function setDispatch($name, $payload) {
		$this->_dispatch[] = ["name" => $name, "payload" => $payload];
	}

	public function setCommit($name, $payload) {
		$this->_commit[] = ["name" => $name, "payload" => $payload];
	}

	public function getDispatch() {
		$rt = "";
		foreach ($this->dispatch() as $key => $elm) {
			//$rt .= 
		}
		return($rt);
	}

	public function getCommit() {

	}
}
