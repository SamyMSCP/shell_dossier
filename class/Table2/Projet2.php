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

class Projet2 extends Table2 {
	protected static		$_name = "PROJET";
	protected static		$_primary_key = "id";
	public static			$_access = [ ACCESS_SERVER, ACCESS_ALL_LOCAL ];

	protected static		$_dataTypes = [
		"id_beneficiaire" => [
			"type" => "TypeToOne",
			"config" => [
				"class" => "Beneficiaire2",
				"column" => "id_beneficiaire",
				"canEmpty" => false
			],
			"getter" => "getBeneficiaire",
			"getAccess" => [ ACCESS_SERVER, ACCESS_ALL_LOCAL  ],
			"storeAccess" => [ ACCESS_SERVER, ACCESS_ALL_LOCAL  ]
		],
		"id_situation_physique" => [
			"type" => "TypeToOne",
			"config" => [
				"class" => "SituationPhysique",
				"column" => "id_situation_physique",
				"canEmpty" => false
			],
			"getter" => "getSituationPhysique",
			"getAccess" => [ ACCESS_SERVER, ACCESS_ALL_LOCAL  ],
			"storeAccess" => [ ACCESS_SERVER, ACCESS_ALL_LOCAL  ]
		],
		"id_conseiller" => [
			"type" => "TypeToOneConseiller",
			"config" => [
				"column" => "id_conseiller",
				"canEmpty" => false
			],
			"getter" => "getConseiller",
			"getAccess" => [ ACCESS_SERVER, ACCESS_ALL_LOCAL  ],
			"storeAccess" => [ ACCESS_SERVER, ACCESS_ALL_LOCAL  ]
		],
		"montant_investissement_previsionnel" => [
			"type" => "TypeUEuros",
			"config" => [
				"column" => "montant_investissement_previsionnel",
				"canEmpty" => false,
				"notCheck" => false
			],
			"getter" => "getMontantInvestissementPrevisionnel",
			"getAccess" => [ ACCESS_SERVER, ACCESS_ALL_LOCAL  ],
			"storeAccess" => [ ACCESS_SERVER, ACCESS_ALL_LOCAL  ]
		],
		/*
		"id_objectif_investissement" => [
			"type" => "TypeInt",
			"config" => [
				"column" => "id_objectif_investissement",
				"canEmpty" => true
			],
			"getter" => "getObjectifInvestissement",
			"getAccess" => [ ACCESS_SERVER, ACCESS_ALL_LOCAL  ],
			"storeAccess" => [ ACCESS_SERVER, ACCESS_ALL_LOCAL  ]
		],
		"date_finalisation" => [
			"type" => "TypeDate",
			"config" => [
				"column" => "date_finalisation",
			],
			"getter" => "getDateFinalisation",
			"getAccess" => [ ACCESS_SERVER, ACCESS_ALL_LOCAL  ],
			"storeAccess" => [ ACCESS_SERVER, ACCESS_ALL_LOCAL  ]
		],
		*/
		"date_creation" => [
			"type" => "TypeDate",
			"config" => [
				"column" => "date_creation",
			],
			"getter" => "getDateCreation",
			"getAccess" => [ ACCESS_SERVER, ACCESS_ALL_LOCAL  ],
			"storeAccess" => [ ACCESS_SERVER, ACCESS_ALL_LOCAL  ]
		],
		"etat_du_projet" => [
			"type" => "TypeEnumInt",
			"config" => [
				"props" => [
					":list" => [
						"Projet potentiel"							=> -1,
						"Projet/Situation complété"					=> 0,
						"Projet en étude"							=> 1,
						"Attente décision client"					=> 2,
						"Projet Refusé"								=> 3,
						"Proposition validée"						=> 4,
						"Rec signé"									=> 5,
						"Enregistrement des transactions"	=> 6,
						"Projet finalisé"							=> 7,
						"Projet annulé"								=> -2,
					]
				],
				"datas" => [ -1, 0, 1, 2, 3, 4, 5, 6, 7, -2 ],
				"column" => "etat_du_projet",
			],
			"getter" => "getEtatDuProjet",
			"getAccess" => [ ACCESS_SERVER, ACCESS_ALL_LOCAL  ],
			"storeAccess" => [ ACCESS_SERVER, ACCESS_ALL_LOCAL  ]
		],
		"nom" => [
			"type" => "TypeString",
			"config" => [
				"column" => "nom"
			],
			"getter" => "getNom",
			"getAccess" => [ ACCESS_SERVER, ACCESS_ALL_LOCAL   ],
			"storeAccess" => [ ACCESS_SERVER, ACCESS_ALL_LOCAL   ]
		],
		"objectifs" => [
			"type" => "TypeObjectif",
			"config" => [
				"column" => "objectifs"
			],
			"getter" => "getObjectifs",
			"getAccess" => [ ACCESS_SERVER, ACCESS_ALL_LOCAL   ],
			"storeAccess" => [ ACCESS_SERVER, ACCESS_ALL_LOCAL   ]
		],
		"objectif_autre" => [
			"type" => "TypeString",
			"config" => [
				"column" => "objectif_autre"
			],
			"getter" => "getObjectifAutre",
			"getAccess" => [ ACCESS_SERVER, ACCESS_ALL_LOCAL   ],
			"storeAccess" => [ ACCESS_SERVER, ACCESS_ALL_LOCAL   ]
		],
		/*
		"fourchette_investissement" => [
			"type" => "TypeInt",
			"config" => [
				"column" => "fourchette_investissement"
			],
			"getter" => "getFourchetteInvestissement",
			"getAccess" => [ ACCESS_SERVER, ACCESS_ALL_LOCAL   ],
			"storeAccess" => [ ACCESS_SERVER, ACCESS_ALL_LOCAL   ]
		],
		*/
		"credit" => [
			"type" => "TypeEnumString",
			"config" => [
				"column" => "credit",
				"props" => [
					":list" => [
						"Oui (en totalité)"	=> 1,
						"Oui (En partie)"	=> 2,
						"Non"				=> 3,
					]
				],
				"datas" => [1, 2, 3 ],
			],
			"getter" => "getCredit",
			"getAccess" => [ ACCESS_SERVER, ACCESS_ALL_LOCAL   ],
			"storeAccess" => [ ACCESS_SERVER, ACCESS_ALL_LOCAL   ]
		],
		"accompagne_investissement" => [
			"type" => "TypeEnumInt",
			"config" => [
				"props" => [
					":list" => [
						"Oui"	=> 1,
						"Non"	=> 0,
						//"Oui, intǵralement"		=> 1,
					]
				],
				"datas" => [ 0, 1 ],
				"column" => "accompagne_investissement",
			],
			"getter" => "getAccompagneInvestissement",
			"getAccess" => [ ACCESS_SERVER, ACCESS_ALL_LOCAL  ],
			"storeAccess" => [ ACCESS_SERVER, ACCESS_ALL_LOCAL  ]
		],
		"origine" => [
			"type" => "TypeSerializedOrigineFonds",
			"config" => [
				"column" => "origine"
			],
			"getter" => "getOrigine",
			"getAccess" => [ ACCESS_SERVER, ACCESS_ALL_LOCAL   ],
			"storeAccess" => [ ACCESS_SERVER, ACCESS_ALL_LOCAL   ]
		],
		"date_modification" => [
			"type" => "TypeDate",
			"config" => [
				"column" => "date_modification",
			],
			"getter" => "getDateModification",
			"getAccess" => [ ACCESS_SERVER, ACCESS_ALL_LOCAL  ],
			"storeAccess" => [ ACCESS_SERVER, ACCESS_ALL_LOCAL  ]
		],

		"id_objectifs_list_1" => [

			"type" => "TypeToOneObjectifsList",
			"config" => [
				"class" => "ObjectifsList2",
				"column" => "id_objectifs_list_1",
				"canEmpty" => false
			],
			"getter" => "getObjectifList1",
			"getAccess" => [ ACCESS_SERVER, ACCESS_ALL_LOCAL  ],
			"storeAccess" => [ ACCESS_SERVER, ACCESS_ALL_LOCAL  ]

		],
		"id_objectifs_list_2" => [
			"type" => "TypeToOneObjectifsList",
			"config" => [
				"class" => "ObjectifsList2",
				"column" => "id_objectifs_list_2",
				"canEmpty" => false
			],
			"getter" => "getObjectifList1",
			"getAccess" => [ ACCESS_SERVER, ACCESS_ALL_LOCAL  ],
			"storeAccess" => [ ACCESS_SERVER, ACCESS_ALL_LOCAL  ]
		],
		"id_objectifs_list_3" => [
			"type" => "TypeToOneObjectifsList",
			"config" => [
				"class" => "ObjectifsList2",
				"column" => "id_objectifs_list_3",
				"canEmpty" => false
			],
			"getter" => "getObjectifList1",
			"getAccess" => [ ACCESS_SERVER, ACCESS_ALL_LOCAL  ],
			"storeAccess" => [ ACCESS_SERVER, ACCESS_ALL_LOCAL  ]
		],
		"commentaire" => [
			"type" => "TypeString",
			"config" => [
				"column" => "commentaire"
			],
			"getter" => "getCommentaire",
			"getAccess" => [ ACCESS_SERVER, ACCESS_ALL_LOCAL   ],
			"storeAccess" => [ ACCESS_SERVER, ACCESS_ALL_LOCAL   ]
		],
/*

		"creator" => [
			"type" => "TypeToOne",
			"config" => [
				"class" => "DonneurDOrdre",
				"column" => "creator",
				"canEmpty" => false
			],
			"getter" => "getCreator",
			"getAccess" => [ ACCESS_SERVER, ACCESS_ALL_LOCAL  ],
			"storeAccess" => [ ACCESS_SERVER, ACCESS_ALL_LOCAL  ]
		],
		*/

		"strategie" => [
			"type" => "TypeString",
			"config" => [
				"column" => "strategie"
			],
			"getter" => "getCommentaire",
			"getAccess" => [ ACCESS_SERVER, ACCESS_ALL_LOCAL   ],
			"storeAccess" => [ ACCESS_SERVER, ACCESS_ALL_LOCAL   ]
		],
		"autres_elements" => [
			"type" => "TypeString",
			"config" => [
				"column" => "autres_elements"
			],
			"getter" => "getCommentaire",
			"getAccess" => [ ACCESS_SERVER, ACCESS_ALL_LOCAL   ],
			"storeAccess" => [ ACCESS_SERVER, ACCESS_ALL_LOCAL   ]
		],



		"statut_parcour_client" => [
			"type" => "TypeStatutParcourClient",
			"config" => [
				"column" => "statut_parcour_client"
			],
			"getter" => "getStatutParcourClient",
			"getAccess" => [ ACCESS_SERVER, ACCESS_ALL_LOCAL   ],
			"storeAccess" => [ ACCESS_SERVER, ACCESS_ALL_LOCAL   ]
		],
	];

	protected static		$_dataAccess = [
		"id_beneficiaire" => [
			"get" => [ ACCESS_SERVER, ACCESS_ALL_LOCAL ],
			"set" => [ ACCESS_SERVER, ACCESS_ALL_LOCAL ],
			//"editComponent" => "ComponentTypeEdit",
			//"showComponent" => "ComponentTypeShow",
			"defaultValue" => ""
		],
		"id_situation_physique" => [
			"get" => [ ACCESS_SERVER, ACCESS_ALL_LOCAL ],
			"set" => [ ACCESS_SERVER, ACCESS_ALL_LOCAL ],
			"defaultValue" => ""
		],
		"id_conseiller" => [
			"get" => [ ACCESS_SERVER, ACCESS_ALL_LOCAL ],
			"set" => [ ACCESS_SERVER, ACCESS_ALL_LOCAL ],
			"defaultValue" => ""
		],
		"montant_investissement_previsionnel" => [
			"get" => [ ACCESS_SERVER, ACCESS_ALL_LOCAL ],
			"set" => [ ACCESS_SERVER, ACCESS_ALL_LOCAL ],
			"defaultValue" => ""
		],
		/*
		"id_objectif_investissement" => [
			"get" => [ ACCESS_SERVER, ACCESS_ALL_LOCAL ],
			"set" => [ ACCESS_SERVER, ACCESS_ALL_LOCAL ],
			"defaultValue" => ""
		],
		*/
		"date_creation" => [
			"get" => [ ACCESS_SERVER, ACCESS_ALL_LOCAL ],
			"set" => [ /* ACCESS_SERVER, ACCESS_ALL_LOCAL */ ],
			"defaultValue" => ""
		],
		"etat_du_projet" => [
			"get" => [ ACCESS_SERVER, ACCESS_ALL_LOCAL ],
			"set" => [ ACCESS_SERVER, ACCESS_ALL_LOCAL ],
			"defaultValue" => -1
		],
		/*
		"date_finalisation" => [
			"get" => [ ACCESS_SERVER, ACCESS_ALL_LOCAL ],
			"set" => [ ACCESS_SERVER, ACCESS_ALL_LOCAL ],
			"defaultValue" => ""
		],
		*/
		"nom" => [
			"get" => [ ACCESS_SERVER, ACCESS_ALL_LOCAL ],
			"set" => [ ACCESS_SERVER, ACCESS_ALL_LOCAL ],
			"defaultValue" => ""
		],
		"objectifs" => [
			"get" => [ ACCESS_SERVER, ACCESS_ALL_LOCAL ],
			"set" => [ ACCESS_SERVER, ACCESS_ALL_LOCAL ],
			"editComponent" => "ComponentTypeObjectifEdit2",
			"defaultValue" => ""
		],
		"objectif_autre" => [
			"get" => [ ACCESS_SERVER, ACCESS_ALL_LOCAL ],
			"set" => [ ACCESS_SERVER, ACCESS_ALL_LOCAL ],
			"defaultValue" => ""
		],
		/*
		"fourchette_investissement" => [
			"get" => [ ACCESS_SERVER, ACCESS_ALL_LOCAL ],
			"set" => [ ACCESS_SERVER, ACCESS_ALL_LOCAL ],
			"defaultValue" => ""
		],
		*/
		"credit" => [
			"get" => [ ACCESS_SERVER, ACCESS_ALL_LOCAL ],
			"set" => [ ACCESS_SERVER, ACCESS_ALL_LOCAL ],
			"editComponent" => "ComponentTypeEnumButtonEdit",
			"defaultValue" => -1
		],
		"accompagne_investissement" => [
			"get" => [ ACCESS_SERVER, ACCESS_ALL_LOCAL ],
			"set" => [ ACCESS_SERVER, ACCESS_ALL_LOCAL ],
			//"editComponent" => "ComponentTypeBool2btnEdit",
			"editComponent" => "ComponentTypeEnumButtonEdit",
			"defaultValue" => null
		],
		"origine" => [
			"get" => [ ACCESS_SERVER, ACCESS_ALL_LOCAL ],
			"set" => [ ACCESS_SERVER, ACCESS_ALL_LOCAL ],
			"editComponent" => "ComponentTypeSerializedOrigineFonds2",
			"defaultValue" => '{}'
		],
		"date_modification" => [
			"get" => [ ACCESS_SERVER, ACCESS_ALL_LOCAL ],
			"set" => [ ACCESS_SERVER, ACCESS_ALL_LOCAL ],
			"defaultValue" => ""
		],

		"id_objectifs_list_1" => [
			"get" => [ ACCESS_SERVER, ACCESS_ALL_LOCAL ],
			"set" => [ ACCESS_SERVER, ACCESS_ALL_LOCAL ],
			"defaultValue" => ""
		],
		"id_objectifs_list_2" => [
			"get" => [ ACCESS_SERVER, ACCESS_ALL_LOCAL ],
			"set" => [ ACCESS_SERVER, ACCESS_ALL_LOCAL ],
			"defaultValue" => ""
		],
		"id_objectifs_list_3" => [
			"get" => [ ACCESS_SERVER, ACCESS_ALL_LOCAL ],
			"set" => [ ACCESS_SERVER, ACCESS_ALL_LOCAL ],
			"defaultValue" => ""
		],
		"commentaire" => [
			"get" => [ ACCESS_SERVER, ACCESS_ALL_LOCAL ],
			"set" => [ ACCESS_SERVER, ACCESS_ALL_LOCAL ],
			"defaultValue" => ""
		],

		/*
		"creator" => [
			"get" => [ ACCESS_SERVER, ACCESS_ALL_LOCAL ],
			"set" => [ ACCESS_SERVER, ACCESS_ALL_LOCAL ],
			"defaultValue" => ""
		],
		*/
		"strategie" => [
			"get" => [ ACCESS_SERVER, ACCESS_ALL_LOCAL ],
			"set" => [ ACCESS_SERVER, ACCESS_ALL_LOCAL ],
			"defaultValue" => ""
		],
		"autres_elements" => [
			"get" => [ ACCESS_SERVER, ACCESS_ALL_LOCAL ],
			"set" => [ ACCESS_SERVER, ACCESS_ALL_LOCAL ],
			"defaultValue" => ""
		],
		"statut_parcour_client" => [
			"get" => [ ACCESS_SERVER, ACCESS_ALL_LOCAL ],
			"set" => [ ACCESS_SERVER, ACCESS_ALL_LOCAL ],
			//"defaultValue" => "ProjetChoixBeneficiaire"
			"defaultValue" => "ProjetCheckProjet"
		],
	];

	public function __construct() {
		parent::__construct();
	}
	public function __destruct() {}

	public function getDh() {
		return (DonneurDOrdre::getById($this->lien_dh));
	}

	public function getForDonneurDOrdre($donneurdordre) {
		return (static::getFromRequest("SELECT `PROJET`.* FROM PROJET INNER JOIN `BENEFICIAIRE` ON `BENEFICIAIRE`.id_benf = `PROJET`.id_beneficiaire WHERE `BENEFICIAIRE`.id_dh = :id;", ['id' => $donneurdordre->getId()]));
	}

	public static function generateVuexGetters() {
		$rt = [
			"getProjet2ForBeneficiaire2" => "
				var id = this.store.getters.getSelectedBeneficiaire2.id.value;
				var that = this;
					return (
						state.datas.Projet2.lst.filter(function (elm) {
							return (elm.id_beneficiaire.value == id);
						})
				);",
			"getProjet2ForSelectedDh" => "
				var rt = {};
				var bens = this.store.getters.getBeneficiaire2ForDonneurDOrdre;
				for (key in bens) {
					var ben = bens[key];
					var projets = this.store.getters.getProjet2_id_beneficiaire(ben.id.value);
					for (key2 in projets) {
						var projet = projets[key2];
						rt[projet.id.value] = projet;
					}
				}
				return (Object.values(rt));
			"
		];
		$rt = array_merge($rt, parent::generateVuexGetters());
		return ($rt);
	}

	public function getVuexActions() {
		$rt= "";
		$rt = parent::getVuexActions() . $rt;
		return ($rt);
	}

	public function getVuexMutations() {
		$rt = "";
		$rt = parent::getVuexMutations() . $rt;
		return ($rt);
	}

	public function getPersonnesPhysiques() {
		$bens = $this->getBeneficiaire()->get();
		if (empty($bens))
			return (null);
		$pps = $bens->getPersonnesPhysiques()->get();
		if (empty($pps))
			return (null);
		return ($pps);
	}

	public function beforeCheck(&$data = null) {

		if ($data == null)
		{
			if (is_array($this->getObjectifs()->get()))
			{
				$haveAutre = false;
				foreach ($this->getObjectifs()->get() as $key => $elm)
				{
					if ($elm == 8)
						$haveAutre = true;
				}
				if (!$haveAutre)
				{
					$this->getObjectifAutre()->setNoControl(null);
					$this->getObjectifAutre()->setConfig('notCheck', true);
				}
			}
			if (is_array($this->getOrigine()->get()))
			{
				$origine = $this->getOrigine()->get();
				if ($this->getCredit()->get() == 1 || $this->getCredit()->get() == 2) {
					$origine['Crédit']['enabled'] = true;
				} else if ($this->getCredit()->get() === 3) {
					$origine['Crédit']['enabled'] = false;
					$origine['Crédit']['value'] = 0;
				}
				$origine = $this->getOrigine()->set($origine);
			}
		}
		else
		{
			if (
				isset($data['origine']) &&
				is_array($data['origine']['value']) &&
				isset($data['origine']['value']['Crédit']) &&
				isset($data['credit']) &&
				isset($data['credit']['value'])
			)
			{
				if ($data['credit']['value'] == 1 || $data['credit']['value'] == 2) {
					$data['origine']['value']['Crédit']['enabled'] = true;
				} else if ($data['credit']['value'] === 3) {
					$data['origine']['value']['Crédit']['enabled'] = false;
					$data['origine']['value']['Crédit']['value'] = 0;
				}
			}
			if (isset($data['objectifs']) && is_array($data['objectifs']['value']))
			{
				$haveAutre = false;
				foreach ($data['objectifs']['value'] as $key => $elm)
				{
					if ($elm == 8)
						$haveAutre = true;
				}
				if (!$haveAutre)
				{
					$data['objectif_autre']['value'] = null;
					$this->getObjectifAutre()->setNoControl(null);
					$this->getObjectifAutre()->setConfig('notCheck', true);
				}
			}
			if (isset($data['statut_parcour_client']) && $data['statut_parcour_client']['value'] == "Fin")
			{
				if ($this->getEtatDuProjet->get() < 0)
				{
					$data['etat_du_projet']['value'] = 0;
					$this->getEtatDuProjet()->setNoControl(0);
				}
			}
		}
	}

	public function getProfilInvestisseurIncomplet() {

		// On récupère les personnes physiques.
		$pps = $this->getPersonnesPhysiques();
		if (empty($pps)) {
			return (null);
		}

		// On les vérifie une par une si elles ont un profil complet et valide.
		$temoin = false;
		$ppProfil = null;
		foreach ($pps as $key => $pp) { // Boucle sur les Pp
			$profils = $pp->getProfilInvestisseur()->get();

			if (empty($profils)) { // Dans ce cas ce pp n'a aucun profil d'existant
				$temoin = true;
				$ppProfil = $pp;
				break ;
			}

			$temoin2 = false;
			foreach ($profils as $key2 => $profil) { // Boucle sur le profils du Pp
				if ($profil->getIsPerime() === false && $profil->getIsComplete()->get() === true) {
					$profil->removeCheck();
					$temoin2 = true;
					break;
				}
			}
			if (!$temoin2) {
				// On a des profils mais aucun n'est valide
				$temoin = true; // si true alors on a un profil à compléter.
				$ppProfil = $pp;
				break ;
			}
		}
		if ($temoin === false) {
			return (null);
		}

		// Si on arrive jusqu'ici c'est qu'on as de toute un profil à compléter.

		$name = $ppProfil->getShortName();
		$profils = $pp->getProfilInvestisseur()->get();
		$profil = null;

		// Dans ce cas on a des profils il faut voir si il y en a un incomplet
		if (!empty($profils)) {
			foreach ($profils as $key2 => $profil) {
				if ($profil->getIsComplete()->get() !== true && $profil->getIsPerime() === false) {
					// On en a trouvé un incomplet.
					return ($profil);
				}
			}
		}

		// Si on arrive ici c'est qu'il n'y a aucun profil valide et qu'il faut en créer un !

		$profil = new ProfilInvestisseur2();
		$profil->removeCheck();
		$profil->getPersonnePhysique()->setConfig("notCheck", false);
		$profil->getPersonnePhysique()->set($pp);
		$profil->commit();
		return ($profil);
	}

	public function beforeSet($prev) {
		if ($prev === null)
			$this->getDateCreation()->setRawValue(time());
		return (true);
	}
};
