<?php
/*      __  __        _  _  _                          */
/*     |  \/  |  ___ (_)| || |  ___  _   _  _ __  ___  */ /*     | |\/| | / _ \| || || | / _ \| | | || '__|/ _ \ */
/*     | |  | ||  __/| || || ||  __/| |_| || |  |  __/ */
/*     |_|  |_| \___||_||_||_| \___| \__,_||_|   \___| */
/*                        _                            */
/*      ___   ___  _ __  (_)    ___  ___   _ __ ___    */
/*     / __| / __|| '_ \ | |   / __|/ _ \ | '_ ` _ \   */
/*     \__ \| (__ | |_) || | _| (__| (_) || | | | | |  */
/*     |___/ \___|| .__/ |_|(_)\___|\___/ |_| |_| |_|  */
/*                |_|                                  */

class PersonneMorale extends Table2 {
	protected static		$_name = "PERSONNE MORALE";
	protected static		$_primary_key = "id_pm";
	public static			$_access = [ ACCESS_ALL_LOCAL, ACCESS_SERVER ];
	protected static		$_dataTypes = [
		"id_situation" => [
			"type" => "TypeUInt",
			"config" => [
				"column" => "id_situation"
			],
			"getter" => "getIdSituation",
			"getAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ]
		],
		"dn_sociale" => [
			"type" => "TypeString",
			"config" => [
				"column" => "dn_sociale"
			],
			"getter" => "getDenominationSociale",
			"getAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER   ],
			"storeAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER   ]
		],
		"siret" => [
			"type" => "TypeSiret",
			"config" => [
				"column" => "siret",
				"canEmpty" => true
			],
			"getter" => "getSiret",
			"getAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER   ],
			"storeAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER   ]
		],
		"f_juridique" => [
			"type" => "TypeEnumInt",
			"config" => [
				"props" => [
					":list" => [
						"Entreprise individuelle"							=> 1,
						"Entreprise universelle à responsabilité limitée"	=> 2,
						"Société de capitaux"								=> 3,
						"Société en nom collectif"							=> 4,
						"SAS"												=> 5
					]
				],
				"datas" => [  1, 2, 3, 4, 5 ],
				"column" => "f_juridique",
				"canEmpty" => true
			],
			"getter" => "getFormeJuridique",
			"getAccess" => [ ACCESS_SERVER, ACCESS_ALL_LOCAL  ],
			"storeAccess" => [ ACCESS_SERVER, ACCESS_ALL_LOCAL  ]
		],

		"id_gerant" => [
			"type" => "TypeToOne",
			"config" => [
				"class" => "PersonnePhysique",
				"column" => "id_gerant",
				"canEmpty" => false
			],
			"getAccess" => [ ACCESS_SERVER, ACCESS_OWNER, ACCESS_ALL_LOCAL ],
			"getter" => "getGerant"
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
			"getter" => "getSiegeSocial",
			"getAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER   ],
			"storeAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER   ]
		],


		/*
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
		*/
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
	];

	protected static		$_dataAccess = [
		"id_situation" => [
			"get" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"set" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"defaultValue" => ""
		],
		"dn_sociale" => [
			"get" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"set" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"defaultValue" => null
		],
		"siret" => [
			"get" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"set" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"defaultValue" => null
		],
		"f_juridique" => [
			"get" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"set" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"defaultValue" => null
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
		"lien_dh" => [
			"get" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"set" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"defaultValue" => null
		],
		"id_gerant" => [
			"get" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"set" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"editComponent" => "ComponentTypeGerantEdit",
			"defaultValue" => null
		],

	];

	public function __construct() {
		parent::__construct();
	}
	public function __destruct() {}

	public function getShortName() {
		return ($this->getDenominationSociale()->get());
	}

	public function getDh() {
		return (DonneurDOrdre::getById($this->lien_dh));
	}

	public function getForDonneurDOrdre($donneurdordre) {
		return (static::getFromKeyValue("lien_dh", $donneurdordre->getId()));
	}

	/*
	public function getLastSituationPhysique() {
		$elm = $this->getSituationPhysique()->get();
		if (empty($elm))
			return (null);
		usort($elm, function($a, $b) {
			return (($a->date_modification < $b->date_modification) ? 1 : -1);
		});
		return ($elm[0]);
	}
	*/
	public static function generateVuexGetters() {

		$rt = [
			"getPersonnesMoraleForDonneurDOrdre" => "
				var id_dh = this.store.getters.getSelectedDonneurDOrdre.id.value;
				var that = this;
					return (
						state.datas.PersonneMorale.lst.filter(function (elm) {
							return (elm.lien_dh.value == id_dh);
						})
				);"
		];

		$rt["getPersonnesMoraleDonneurDOrdre"] = "
			var lien_phy = this.store.getters.getSelectedDonneurDOrdre.lien_phy.value;
			var that = this;
				return (
					state.datas.PersonneMorale.lst.filter(function (elm) {
						return (elm.id.value == lien_phy);
					})
		);";

/*
		$rt["getPersonnesMoraleByProjet2Id"] = "
			return (function(projet_id) {
				var ben = getters.getBeneficiaireByProjet2Id(projet_id);
				if (typeof ben == 'undefined' || ben == null || ben.length < 1)
					return (null);
				return (store.getters.getBeneficiaire2_PersonneMorale(ben[0].id.value));
			})
		";
*/
		$rt = array_merge($rt, parent::generateVuexGetters());
		return ($rt);
	}
};
