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

class Beneficiaire2 extends Table2 {
	protected static		$_name = "BENEFICIAIRE";
	protected static		$_primary_key = "id_benf";
	public static			$_access = [ ACCESS_ALL_LOCAL, ACCESS_SERVER ];
	protected static		$_dataTypes = [
		"id_dh" => [
			"type" => "TypeToOne",
			"config" => [
				"class" => "DonneurDOrdre",
				"column" => "id_dh",
				"canEmpty" => false
			],
			"getter" => "getDonneurDOrdre",
			"getAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"storeAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ]
		],
		"Projet2" => [
			"notShow" => true,
			"type" => "TypeByOne",
			"config" => [
				"class" => "Projet2",
				"link" => "id_beneficiaire",
				"canEmpty" => false
			],
			"getAccess" => [ ACCESS_SERVER, ACCESS_OWNER, ACCESS_ALL_LOCAL ],
			"getter" => "getProjet"
		],
		"type_ben" => [
			"type" => "TypeEnumString",
			"config" => [
				"props" => [
					":list" => [
						"Seul"				=> "seul",
						"Couple"			=> "couple",
						"Personne morale"	=> "Pm",
					]
				],
				"datas" => [
					"seul",
					"couple",
					"Pm",
				],
				"column" => "type_ben"
			],
			"getter" => "getTypeBeneficiaire",
			"getAccess" => [ ACCESS_SERVER, ACCESS_OWNER, ACCESS_ALL_LOCAL ],
			"storeAccess" => [ ACCESS_SERVER, ACCESS_OWNER, ACCESS_ALL_LOCAL ]
		],
		/*
		"type_ben" => [
			"type" => "TypeString",
			"config" => [
				"column" => "type_ben"
			],
			"getter" => "getTypeBeneficiaire",
			"getAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"storeAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ]
		],
		*/
		"type_relation" => [
			"type" => "TypeEnumString",
			"config" => [
				"props" => [
					":list" => [
						"dh"		=> "",
						"Couple"	=> "couple",
						"Parent"	=> "parent",
						"Enfant"	=> "enfant",
					]
				],
				"datas" => [
					"",
					"couple",
					"parent",
					"enfant",
				],
				"column" => "type_relation"
			],
			"getter" => "getTypeRelation",
			"getAccess" => [ ACCESS_SERVER, ACCESS_OWNER, ACCESS_ALL_LOCAL ],
			"storeAccess" => [ ACCESS_SERVER, ACCESS_OWNER, ACCESS_ALL_LOCAL ]
		],
		/*
		"type_relation" => [
			"type" => "TypeString",
			"config" => [
				"column" => "type_relation"
			],
			"getter" => "getTypeRelation",
			"getAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"storeAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ]
		],
		*/
		"PersonneMorale" => [
			"type" => "TypeToMany",
			"config" => [
				"accessName" => "PersonneMorale",
				"class" => "PersonneMorale",
				"joinTable" => "BENEFICIAIRE_PERSONNE",
				"myColumn" => "lien_bf",
				"otherColumn" => "lien_pm",
				"canEmpty" => false
			],
			"getter" => "getPersonnesMorale",
			"getAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER  ]
		],
		"PersonnePhysique" => [
			"type" => "TypeToMany",
			"config" => [
				"accessName" => "PersonnePhysique",
				"class" => "PersonnePhysique",
				"joinTable" => "BENEFICIAIRE_PERSONNE",
				"myColumn" => "lien_bf",
				"otherColumn" => "lien_pp",
				"canEmpty" => false
			],
			"getter" => "getPersonnesPhysiques",
			"getAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER  ]
		],
	];

	protected static		$_dataAccess = [
		"id_dh" => [
			"get" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"set" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"defaultValue" => ""
		],
		"type_ben" => [
			"get" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"set" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"defaultValue" => ""
		],
		"type_relation" => [
			"get" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"set" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"defaultValue" => ""
		],
		"PersonneMorale" => [
			"get" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"set" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"defaultValue" => []
		],
		"PersonnePhysique" => [
			"get" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"set" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"defaultValue" => []
		],
	];

	public function __construct() {
		parent::__construct();
	}
	public function __destruct() {}

	public function getDh() {
		return (DonneurDOrdre::getById($this->id_dh));
	}

	public function getForDonneurDOrdre($donneurdordre) {
		return (static::getFromKeyValue("id_dh", $donneurdordre->getId()));
	}

	public static function generateVuexGetters() {
		$rt = [
			"getBeneficiaire2ForDonneurDOrdre" => "
				var id_dh = this.store.getters.getSelectedDonneurDOrdre.id.value;
				var that = this;
					return (
						state.datas.Beneficiaire2.lst.filter(function (elm) {
							return (elm.id_dh.value == id_dh);
						})
			);"
		];
		$rt["getBeneficiaire2DonneurDOrdre"] = "
			var id_dh = this.store.getters.getSelectedDonneurDOrdre.id.value;
			var that = this;
				return (
					state.datas.Beneficiaire2.lst.filter(function (elm) {
						return (elm.id_dh.value == id_dh);
					})
		);";

		$rt["getBeneficiaireForSelectedProjet2"] = "
			return (store.getters.getBeneficiaire2_ByProjet2_id_beneficiaire(getters.getSelectedProjet2.id.value));
		";

		$rt["getBeneficiaireByProjet2Id"] = "
			return (function(projet) {
				return (store.getters.getBeneficiaire2_ByProjet2_id_beneficiaire(projet));
			});
		";

		$rt["getPersonnesPhysiqueForProjet2"] = "
			var ben = getters.getBeneficiaireForSelectedProjet2;
			if (typeof ben == 'undefined' || ben == null || ben.length < 1)
				return (null);
			return (store.getters.getBeneficiaire2_PersonnePhysique(ben[0].id.value));
		";
		$rt = array_merge($rt, parent::generateVuexGetters());
		return ($rt);
	}

	public function beforeSet($prev) {
		// TODO : ici le code pour mettre à jours ou faire les linking des situations si besoins
		return (true);
	}

	public function afterSet($prev) {

		// On récupère toutes les personnes physiques de ce béneficiaire !
		$pps = $this->getPersonnesPhysiques()->get();
		if (empty($pps))
			return (true);
		$pp1 = $pps[0];

		$dh = $pp1->getDonneurDOrdre()->get();
		$ppDh = $dh->getMyPersonnePhysique()->get();

		// Dans le cas d'un béneficiaire couple ou veux le dh
		if ($this->getTypeBeneficiaire()->get() == "couple") {
			foreach ($pps as $key => $elm) {
				if ($elm->getId() == $ppDh->getId()) {
					$pp1 = $elm;
					break;
				}
			}
		}

		$pp1 = $pp1->cloneFromDb();
		// On récupere la situation physique liée !
		$situation = $pp1->getSituationPhysique()->get();
		//DevLogs::set("Récupération pour le pp1 : " . $pp1->getShortName() . " il y a " . count($situation) . " situations", 1);

		// Si il n'y en a pas, on crée la situation !
		if (empty($situation)) {
			$situation = new SituationPhysique();
			//DevLogs::set("Création d'une nouvelle situation", 1);
		} else {
			$situation = $situation[0];
			//DevLogs::set("Réutilisation d'une situation id:" . $situation->getId(), 1);
		}

		$situation->removeCheck();

		//DevLogs::set($situation, 1);
		if (!$situation->commit()) {
			StoreGenerator::getInstance()->setSelected($situation);
			return (false);
		}
		//DevLogs::set("Commit de la situation okay new id : " . $situation->getId(), 1);
		StoreGenerator::getInstance()->setSelected($situation);

		foreach ($pps as $key => $elm) {
			$elm = $elm->cloneFromDb();
			$elm->removeCheck();
			$elm->getSituationPhysique()->set($situation->cloneFromDb());
			$elm->commit();
			StoreGenerator::getInstance()->addToState($elm);
		}
		$situation = $situation->cloneFromDb();
		StoreGenerator::getInstance()->addToState($situation);
		StoreGenerator::getInstance()->setSelected($situation);
		return (true);
	}
	public function getShortName() {
		$rt = "";
		/*
		foreach ($this->getPersonnesPhysiques()->get() as $key => $pp) {
			if ($key != 0)
				$rt .= " & ";
			$rt .= $pp->getShortName();
		}
		*/
		return ($rt);
	}


	public function beforeCheck(&$data = null) {

		if ($data == null) {

		} else {
			if ($data['type_ben']['value'] == "Pm") {
				$this->getPersonnesPhysiques()->setConfig('notCheck', true);
				$this->getPersonnesPhysiques()->setConfig('canEmpty', true);
			} else {
				$this->getPersonnesMorale()->setConfig('notCheck', true);
				$this->getPersonnesMorale()->setConfig('canEmpty', true);
			}
		}
	}
};
