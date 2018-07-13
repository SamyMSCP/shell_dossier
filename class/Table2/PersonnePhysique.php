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

class PersonnePhysique extends Table2 {
	protected static		$_name = "PERSONNE PHYSIQUE";
	protected static		$_primary_key = "id_phs";
	public static			$_access = [ ACCESS_ALL_LOCAL, ACCESS_SERVER ];
	protected static		$_dataTypes = [
		"civilite" => [
			"type" => "TypeEncryptedCivilite",
			"config" => [
				"column" => "civilite"
			],
			"getter" => "getCivilite",
			"getAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER   ],
			"storeAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER   ]
		],
		"id_situation" => [
			"type" => "TypeUInt",
			"config" => [
				"column" => "id_situation"
			],
			"getter" => "getIdSituation",
			"getAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ]
		],
		"prenom" => [
			"type" => "TypeEncryptedName",
			"config" => [
				"column" => "prenom"
			],
			"getter" => "getPrenom",
			"getAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER   ],
			"storeAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER   ]
		],
		"nom" => [
			"type" => "TypeEncryptedName",
			"config" => [
				"column" => "nom"
			],
			"getter" => "getNom",
			"getAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER   ],
			"storeAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER   ]
		],

		"nationalite" => [
			"type" => "TypeNationalite",
			"config" => [
				"column" => "nationalite",
				"canEmpty" => true
			],
			"getter" => "getNationalite",
			"getAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER   ],
			"storeAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER   ],
		],

		"telephone_portable" => [
			"type" => "TypeEncryptedPhone",
			"config" => [
				"column" => [
					"indicatif"	=> "indicatif_telephonique",
					"num"		=> "telephone",
				],
				"canEmpty" => true
			],
			"getter" => "getTelephone",
			"getAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER   ],
			"storeAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER   ],
		],

		"telephone_fixe" => [
			"type" => "TypeEncryptedPhone",
			"config" => [
				"column" => [
					"indicatif"	=> "indicatif_telephonique_fixe",
					"num"		=> "telephone_fixe",
				],
				"canEmpty" => true
			],
			"getter" => "getTelephone",
			"getAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER   ],
			"storeAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER   ],
		],

/*
		"adresse_postale" => [
			"type" => "TypeAdresse",
			"config" => [
				"column" => [
					"numeroRue" => "numeroRue",
					"extension" => "extension",
					"type_voie" => "type_voie",
					"voie" => "voie",
					"complementAdresse" => "complementAdresse",
					"codePostal" => "codePostal",
					"ville" => "ville",
					"pays" => "pays"
				],
				//"notCheck" => true
				"canEmpty" => true
			],
			"getter" => "getAdresse",
			"getAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER   ],
			"storeAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER   ]
		],
		*/
/*
		"telephone" => [
			"type" => "TypeEncryptedString",
			"config" => [
				"column" => "telephone",
				"canEmpty" => true
			],
			"getter" => "getTelephone",
			"getAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER   ],
			"storeAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER   ],
		],

		"indicatif_telephonique" => [
			"type" => "TypeString",
			"config" => [
				"column" => "indicatif_telephonique",
				"canEmpty" => true
			],
			"getter" => "getIndicatifTelehponique",
			"getAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER   ],
			"storeAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER   ],
		],
		"telephone_fixe" => [
			"type" => "TypeEncryptedString",
			"config" => [
				"column" => "telephone_fixe",
				"canEmpty" => true
			],
			"getter" => "getTelephoneFixe",
			"getAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER   ],
			"storeAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER   ],
		],

		"indicatif_telephonique_fixe" => [
			"type" => "TypeString",
			"config" => [
				"column" => "indicatif_telephonique_fixe",
				"canEmpty" => true
			],
			"getter" => "getIndicatifTelehponiqueFixe",
			"getAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER   ],
			"storeAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER   ],
		],

*/
/*
		"nationalite_new" => [
			"type" => "TypeNationalite",
			"config" => [
				"column" => "nationalite_new"
			],
			"getter" => "getNationalite",
			"getAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER   ],
			"storeAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER   ]
		],
*/
		"date_de_n" => [
			"type" => "TypeDate",
			"config" => [
				"column" => "date_de_n",
				"canEmpty" => true
			],
			"getter" => "getDateDeNaissance",
			"getAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER   ],
			"storeAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER   ]
		],
		"lieu_de_n" => [
			"type" => "TypeEncryptedVille",
			"config" => [
				"column" => "lieu_de_n",
				"canEmpty" => true
			],
			"getter" => "getLieuDeNaissance",
			"getAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER   ],
			"storeAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER   ]
		],
		"code_naissance" => [
			"type" => "TypeCodePostal",
			"config" => [
				"column" => "code_naissance",
				"canEmpty" => true
			],
			"getter" => "getCodePostalDeNaissance",
			"getAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER   ],
			"storeAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER   ]
		],
		"pays_de_naissance" => [
			"type" => "TypePays",
			"config" => [
				"column" => "pays_de_naissance",
				"canEmpty" => true
			],
			"getter" => "getPaysDeNaissance",
			"getAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER   ],
			"storeAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER   ]
		],

		/*
			Adresse
				numeroRue
				extension
				type_voie
				voie
				complementAdresse
				codePostal
				ville
				pays
		*/
		"adresse_postale" => [
			"type" => "TypeAdresse",
			"config" => [
				"column" => [
					"numeroRue" => "numeroRue",
					"extension" => "extension",
					"type_voie" => "type_voie",
					"voie" => "voie",
					"complementAdresse" => "complementAdresse",
					"codePostal" => "codePostal",
					"ville" => "ville",
					"pays" => "pays"
				],
				//"notCheck" => true
				"canEmpty" => true
			],
			"getter" => "getAdresse",
			"getAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER   ],
			"storeAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER   ]
		],


/*
		"numeroRue" => [
			"type" => "TypeUint",
			"config" => [
				"column" => "numeroRue"
			],
			"getter" => "getNumeroRue",
			"getAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ]
		],
		"extension" => [
			"type" => "TypeString",
			"config" => [
				"column" => "extension"
			],
			"getter" => "getExtention",
			"getAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ]
		],
		"type_voie" => [
			"type" => "TypeString",
			"config" => [
				"column" => "type_voie"
			],
			"getter" => "getTypeVoie",
			"getAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ]
		],
		"voie" => [
			"type" => "TypeEncryptedString",
			"config" => [
				"column" => "voie"
			],
			"getter" => "getVoie",
			"getAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ]
		],
		"complementAdresse" => [
			"type" => "TypeString",
			"config" => [
				"column" => "complementAdresse"
			],
			"getter" => "getComplementAdresse",
			"getAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ]
		],
		"codePostal" => [
			"type" => "TypeString",
			"config" => [
				"column" => "codePostal"
			],
			"getter" => "getCodePostal",
			"getAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ]
		],
		"ville" => [
			"type" => "TypeString",
			"config" => [
				"column" => "ville"
			],
			"getter" => "getVille",
			"getAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ]
		],
		"status_pro_id" => [
			"type" => "TypeUint",
			"config" => [
				"column" => "status_pro_id"
			],
			"getter" => "getStatusPro",
			"getAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ]
		],
*/
		"code_naf" => [
			"type" => "TypeNaf",
			"config" => [
				"column" => "code_naf",
				"canEmpty" => true
			],
			"getter" => "getCodeNaf",
			"getAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER  ],
			"storeAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER  ]
		],
		"depart_retraite" => [
			"type" => "TypeYear",
			"config" => [
				"column" => "depart_retraite",
				"canEmpty" => true
			],
			"getter" => "getDepartRetraite",
			"getAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ]
		],



		"mail" => [
			"type" => "TypeEncryptedMail",
			"config" => [
				"column" => "mail",
				"canEmpty" => true
			],
			"getter" => "getMail",
			"getAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER  ],
			"storeAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER  ]
		],

		"categorie_professionelle" => [
			"type" => "TypeCategorieProfessionelle",
			"config" => [
				"column" => [
					"code_1" => "categorie_professionelle_code_1",
					"code_2" => "categorie_professionelle_code_2",
				],
				"canEmpty" => true
			],
			"getter" => "getCategorieProfessionnelle",
			"getAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER   ],
			"storeAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER   ]
		],
		"element_particulier" => [
			"type" => "TypeText",
			"config" => [
				"column" => "element_particulier",
				"canEmpty" => true
			],
			"getter" => "getElementParticulier",
			"getAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER   ],
			"storeAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER   ],
		],
		"politiquement_expose" => [
			"type" => "TypeBool",
			"config" => [
				"column" => "politiquement_expose",
				"canEmpty" => true
			],
			"getter" => "getPolitiquementExpose",
			"getAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER  ],
			"storeAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER  ]
		],
		"us_person" => [
			"type" => "TypeBool",
			"config" => [
				"column" => "us_person",
				"canEmpty" => true
			],
			"getter" => "getUsPersonne",
			"getAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER  ],
			"storeAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER  ]
		],
		"lien_dh" => [
			"type" => "TypeToOne",
			"config" => [
				"class" => "DonneurDOrdre",
				"column" => "lien_dh",
				"canEmpty" => false
			],
			"getter" => "getDonneurDOrdre",
			"getAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER  ],
			"storeAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER  ]
		],
		"SituationPhysique" => [
			"type" => "TypeToManyStatic",
			"config" => [
				"accessName" => "SituationPhysique",
				"class" => "SituationPhysique",
				"joinTable" => "situation",
				"myColumn" => "id",
				"otherColumn" => "id",
				"myIdName" => "id_situation",
				"otherIdName" => "id_situation",
				"canEmpty" => true
			],
			"getter" => "getSituationPhysique",
			"getAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ]
		],
		"beneficiaires" => [
			"type" => "TypeToMany",
			"config" => [
				"accessName" => "beneficiaires",
				"class" => "Beneficiaire2",
				"joinTable" => "BENEFICIAIRE_PERSONNE",
				"myColumn" => "lien_pp",
				"otherColumn" => "lien_bf",
				"canEmpty" => true
			],
			"getter" => "getBeneficiaires",
			"getAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER  ]
		],
		"DonneurDOrdre" => [
			"notShow" => true,
			"type" => "TypeByOne",
			"config" => [
				"class" => "DonneurDOrdre",
				"link" => "lien_phy",
				//"canEmpty" => true
			],
			"getAccess" => [ ACCESS_SERVER, ACCESS_OWNER, ACCESS_ALL_LOCAL ],
			"getter" => "getDonneurDOrdre"
		],
		"ProfilInvestisseur" => [
			"type" => "TypeByOne",
			"config" => [
				"class" => "ProfilInvestisseur2",
				"link" => "id_Pp",
				"canEmpty" => true
			],
			"getAccess" => [ ACCESS_SERVER, ACCESS_OWNER, ACCESS_ALL_LOCAL ],
			"getter" => "getProfilInvestisseur"
		]
	];

	protected static		$_dataAccess = [
		"id_situation" => [
			"get" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"set" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"defaultValue" => ""
		],
		"civilite" => [
			"get" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"set" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"defaultValue" => ""
		],
		"prenom" => [
			"get" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"set" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"defaultValue" => ""
		],
		"nom" => [
			"get" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"set" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"defaultValue" => ""
		],
		"nationalite" => [
			"get" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"set" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"defaultValue" => ""
		],

		"telephone" => [
			"get" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"set" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"defaultValue" => null
		],
		"indicatif_telephonique" => [
			"get" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"set" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"defaultValue" => null
		],
		
		"telephone_fixe" => [
			"get" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"set" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"defaultValue" => null
		],
		"indicatif_telephonique_fixe" => [
			"get" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"set" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"defaultValue" => null
		],
		/*
		"nationalite_new" => [
			"get" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"set" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"defaultValue" => ""
		],*/
		"date_de_n" => [
			"get" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"set" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"defaultValue" => ""
		],
		"lieu_de_n" => [
			"get" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"set" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"defaultValue" => ""
		],
		"code_naissance" => [
			"get" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"set" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"defaultValue" => ""
		],
		"pays_de_naissance" => [
			"get" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"set" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"defaultValue" => ""
		],


		"numeroRue" => [
			"get" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"set" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"defaultValue" => ""
		],
		"extension" => [
			"get" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"set" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"defaultValue" => ""
		],
		"type_voie" => [
			"get" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"set" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"defaultValue" => ""
		],
		"voie" => [
			"get" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"set" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"defaultValue" => ""
		],
		"complementAdresse" => [
			"get" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"set" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"defaultValue" => ""
		],
		"codePostal" => [
			"get" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"set" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"defaultValue" => ""
		],
		"ville" => [
			"get" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"set" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"defaultValue" => ""
		],
		"pays" => [
			"get" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"set" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"defaultValue" => ""
		],


/*
		"pays_new" => [
			"get" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"set" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"defaultValue" => ""
		],
		"status_pro_id" => [
			"get" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"set" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"defaultValue" => ""
		],
*/
		"mail" => [
			"get" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"set" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"defaultValue" => ""
		],

		"categorie_professionelle_code_1" => [
			"get" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"set" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"defaultValue" => null
		],
		"categorie_professionelle_code_2" => [
			"get" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"set" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"defaultValue" => null
		],

		"code_naf" => [
			"get" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"set" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"defaultValue" => null
		],
		"depart_retraite" => [
			"get" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"set" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"defaultValue" => null
		],

		"element_particulier" => [
			"get" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"set" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"defaultValue" => ""
		],

		"politiquement_expose" => [
			"get" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"set" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"editComponent" => "ComponentTypeBoolButtonEdit",
			"defaultValue" => null
		],
		"us_person" => [
			"get" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"set" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"editComponent" => "ComponentTypeBoolButtonEdit",
			"defaultValue" => null
		],
		"SituationPhysique" => [
			"get" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"set" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"defaultValue" => ""
		],
		"lien_dh" => [
			"get" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"set" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"defaultValue" => ""
		],
		"beneficiaires" => [
			"get" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"set" => [/* ACCESS_ALL_LOCAL, ACCESS_SERVER*/ ],
			"defaultValue" => []
		],
	];

	public function __construct() {
		parent::__construct();
	}
	public function __destruct() {}

	public function getShortName() {
		$civilite = $this->getCivilite()->getShort();
		$prenom = ucfirst($this->getPrenom()->get());
		$nom = mb_strtoupper($this->getNom()->get());
		return ("$civilite $prenom $nom");
	}

	public function getDh() {
		return (DonneurDOrdre::getById($this->lien_dh));
	}

	public function getForDonneurDOrdre($donneurdordre) {
		return (static::getFromKeyValue("lien_dh", $donneurdordre->getId()));
	}

	public static function generateVuexGetters() {

		$rt = [
			"getPersonnesPhysiquesForDonneurDOrdre" => "
				var id_dh = this.store.getters.getSelectedDonneurDOrdre.id.value;
				var that = this;
					return (
						state.datas.PersonnePhysique.lst.filter(function (elm) {
							return (elm.lien_dh.value == id_dh);
						})
				);"
		];

		$rt["getPersonnesPhysiquesDonneurDOrdre"] = "
			var lien_phy = this.store.getters.getSelectedDonneurDOrdre.lien_phy.value;
			var that = this;
				return (
					state.datas.PersonnePhysique.lst.filter(function (elm) {
						return (elm.id.value == lien_phy);
					})
		);";

		$rt["getPersonnesPhysiqueByProjet2Id"] = "
			return (function(projet_id) {
				var ben = getters.getBeneficiaireByProjet2Id(projet_id);
				if (typeof ben == 'undefined' || ben == null || ben.length < 1)
					return (null);
				return (store.getters.getBeneficiaire2_PersonnePhysique(ben[0].id.value));
			})
		";

		$rt = array_merge($rt, parent::generateVuexGetters());
		return ($rt);
	}

	public function getLastSituationPhysique() {
		$elm = $this->getSituationPhysique()->get();
		if (empty($elm))
			return (null);
		usort($elm, function($a, $b) {
			return (($a->date_modification < $b->date_modification) ? 1 : -1);
		});
		return ($elm[0]);
	}
	public function beforeCheck(&$data = null) {
		if ($data == null) {
			/*
			if ($this->getADesEnfants()->get() === false)
			{
				$this->getEnfantsACharge()->setConfig('notCheck', true);
				$this->getEnfantsACharge()->setNoControl(0);
			}
			*/
			} else {
			if ($data['categorie_professionelle_code_1']['value'] == 7) {
				$data['depart_retraite']['value'] = null;
				$this->getDepartRetraite()->setNoControl(null);
				$this->getDepartRetraite()->setConfig('notCheck', true);
			}
		}
	}

	public function afterSet($prev) {
		//DevLogs::set('okay3' . get_called_class(), 1);
		$dh = $this->getDonneurDOrdre()->get();
		if ($dh->lien_phy == $this->getId()) {

			$dh->getLogin()->set($this->getMail()->get());
			$dh->commit();
			$store = StoreGenerator::getInstance();
			$store->addToState($dh);
			$store->setSelected($dh);
		}
		return (true);
	}
};
