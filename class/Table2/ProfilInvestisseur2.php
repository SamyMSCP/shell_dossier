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

class ProfilInvestisseur2 extends Table2 {
	protected static		$_name = "PROFIL INVESTISSEUR";
	protected static		$_primary_key = "id";
	public static			$_access = [ ACCESS_ALL_LOCAL, ACCESS_SERVER ];
	protected static		$_dataTypes = [
		"id_Pp" => [
			"type" => "TypeToOne",
			"config" => [
				"class" => "PersonnePhysique",
				"column" => "id_Pp",
				"canEmpty" => false
			],
			"getter" => "getPersonnePhysique",
			"getAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ]
		],
		"niveau_risque" => [
			"type" => "TypeEnumInt",
			"config" => [
				"props" => [
					":list" => [
						'Aucune prise de risque'			=> 1,
						'Une prise de risque limitée'		=> 2,
						'Une prise de risque modérée'		=> 3,
						'Une prise de risque importante'	=> 4
					]
				],
				"datas" => [ 1, 2, 3, 4 ],
				"column" => "niveau_risque"
			],
			"getter" => "getNiveauRisque",
			"getAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ]
		],
		"competences_imobilieres" => [
			"type" => "TypeBool",
			"config" => [
				"column" => "competences_imobilieres"
			],
			"getter" => "getCompetencesImmobilieres",
			"getAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ]
		],
		"competences_financieres" => [
			"type" => "TypeBool",
			"config" => [
				"column" => "competences_financieres"
			],
			"getter" => "getCompetencesFinancieres",
			"getAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ]
		],
		"connaissance_marche_imbobilier" => [
			"type" => "TypeEnumInt",
			"config" => [
				"props" => [
					":list" => [
						'Inexistante'	=> 1,
						'Faible'		=> 2,
						'Moyenne'		=> 3,
						'Elevée'		=> 4
					]
				],
				"datas" => [ 1, 2, 3, 4 ],
				"column" => "connaissance_marche_imbobilier"
			],
			"getter" => "getConnaissanceMarcheImbobilier",
			"getAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ]
		],
		"connaissance_scpi" => [
			"type" => "TypeEnumInt",
			"config" => [
				"props" => [
					":list" => [
						'Aucune connaissance'	=> 1,
						'Niveau à améliorer'	=> 2,
						'Niveau bon'			=>3
					]
				],
				"datas" => [ 1, 2, 3 ],
				"column" => "connaissance_scpi"
			],
			"getter" => "getConnaissanceScpi",
			"getAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ]
		],
		"resultat_questionnaire" => [
			"type" => "TypeFloat",
			"config" => [
				"column" => "resultat_questionnaire",
				"canEmpty" => true
			],
			"getter" => "getResultatQuestionnaire",
			"getAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ]
		],
		"connaissance_placement_actions" => [
			"type" => "TypeBool",
			"config" => [
				"column" => "connaissance_placement_actions"
			],
			"getter" => "getConnaissancePlacementActions",
			"getAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ]
		],
		"connaissance_placement_scpi" => [
			"type" => "TypeBool",
			"config" => [
				"column" => "connaissance_placement_scpi"
			],
			"getter" => "getConnaissancePlacementScpi",
			"getAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ]
		],
		"connaissance_placement_assurance_vie" => [
			"type" => "TypeBool",
			"config" => [
				"column" => "connaissance_placement_assurance_vie"
			],
			"getter" => "getConnaissancePlacementAssuranceVie",
			"getAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ]
		],
		"connaissance_placement_opci" => [
			"type" => "TypeBool",
			"config" => [
				"column" => "connaissance_placement_opci"
			],
			"getter" => "getConnaissancePlacementOpci",
			"getAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ]
		],
		"connaissance_placement_obligations" => [
			"type" => "TypeBool",
			"config" => [
				"column" => "connaissance_placement_obligations"
			],
			"getter" => "getConnaissancePlacementObligations",
			"getAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ]
		],
		"connaissance_placement_fcpi_fip_fcpr" => [
			"type" => "TypeBool",
			"config" => [
				"column" => "connaissance_placement_fcpi_fip_fcpr"
			],
			"getter" => "getConnaissancePlacementFcpiFipFcpr",
			"getAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ]
		],
		"connaissance_placement_opcvm" => [
			"type" => "TypeBool",
			"config" => [
				"column" => "connaissance_placement_opcvm"
			],
			"getter" => "getConnaissancePlacementOpcvm",
			"getAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ]
		],
		"quiz" => [
			"type" => "TypeQuizScpi",
			"config" => [
				"column" => "quiz"
			],
			"getter" => "getQuiz",
			"getAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ]
		],
		"date_creation" => [
			"type" => "TypeDate",
			"config" => [
				"column" => "date_creation"
			],
			"getter" => "getDateCreation",
			"getAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ]
		],
		"estimation" => [
			"type" => "TypeInt",
			"config" => [
				"column" => "estimation",
				"canEmpty" => true
			],
			"getter" => "getEstimation",
			"getAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ]
		],
		"note" => [
			"type" => "TypeInt",
			"config" => [
				"column" => "note",
				"canEmpty" => true
			],
			"getter" => "getNote",
			"getAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ]
		],
		"status" => [
			"type" => "TypeInt",
			"config" => [
				"column" => "status",
				"notCheck" => true
			],
			"getter" => "getStatus",
			"getAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ]
		],
		"dispose_actions" => [
			"type" => "TypeBool",
			"config" => [
				"column" => "dispose_actions"
			],
			"getter" => "getDisposeActions",
			"getAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ]
		],
		"dispose_fcpi_fip_fcpr" => [
			"type" => "TypeBool",
			"config" => [
				"column" => "dispose_fcpi_fip_fcpr"
			],
			"getter" => "getDisposeFcpiFipFcpr",
			"getAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ]
		],
		"dispose_opcvm" => [
			"type" => "TypeBool",
			"config" => [
				"column" => "dispose_opcvm"
			],
			"getter" => "getDisposeOpcvm",
			"getAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ]
		],
		"dispose_assurance_vie" => [
			"type" => "TypeBool",
			"config" => [
				"column" => "dispose_assurance_vie"
			],
			"getter" => "getDisposeAssuranceVie",
			"getAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ]
		],
		"dispose_obligations" => [
			"type" => "TypeBool",
			"config" => [
				"column" => "dispose_obligations"
			],
			"getter" => "getDisposeObligations",
			"getAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ]
		],
		"dispose_scpi" => [
			"type" => "TypeBool",
			"config" => [
				"column" => "dispose_scpi"
			],
			"getter" => "getDisposeScpi",
			"getAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ]
		],
		"dispose_opci" => [
			"type" => "TypeBool",
			"config" => [
				"column" => "dispose_opci"
			],
			"getter" => "getDisposeOpci",
			"getAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ]
		],
		"dispose_liquidite" => [
			"type" => "TypeBool",
			"config" => [
				"column" => "dispose_liquidite"
			],
			"getter" => "getDisposeLiquidite",
			"getAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ]
		],
		"dispose_pea" => [
			"type" => "TypeBool",
			"config" => [
				"column" => "dispose_pea"
			],
			"getter" => "getDisposePea",
			"getAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ]
		],
		"dispose_immobilier_direct" => [
			"type" => "TypeBool",
			"config" => [
				"column" => "dispose_immobilier_direct"
			],
			"getter" => "getDisposeImmobilierDirect",
			"getAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ]
		],
		"gestion_directe" => [
			"type" => "TypeBool",
			"config" => [
				"column" => "gestion_directe"
			],
			"getter" => "getGestionDirecte",
			"getAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ]
		],
		"gestion_conseiller" => [
			"type" => "TypeBool",
			"config" => [
				"column" => "gestion_conseiller"
			],
			"getter" => "getGestionConseiller",
			"getAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ]
		],
		"gestion_sous_mandat" => [
			"type" => "TypeBool",
			"config" => [
				"column" => "gestion_sous_mandat"
			],
			"getter" => "getGestionSousMandat",
			"getAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ]
		],

		"si_jinvesti_10000" => [
			"type" => "TypeEnumInt",
			"config" => [
				"props" => [
					":list" => [
						'5760 €'		=> 5760,
						'480 €'		=> 480,
						'10 000 €'	=> 10000
					]
				],
				"datas" => [ 5760, 480, 10000],
				"column" => "si_jinvesti_10000"
			],
			"getter" => "getSiJinvesti10000",
			"getAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ]
		],
		"dispose_crowdfunding" => [
			"type" => "TypeBool",
			"config" => [
				"column" => "dispose_crowdfunding"
			],
			"getter" => "getDisposeCrowdFunding",
			"getAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ]
		],
		"connaissance_placement_crowdfunding" => [
			"type" => "TypeBool",
			"config" => [
				"column" => "connaissance_placement_crowdfunding"
			],
			"getter" => "getConnaissancePlacementCrowdfunding",
			"getAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ]
		],
		"is_complete" => [
			"type" => "TypeBool",
			"config" => [
				"column" => "is_complete"
			],
			"getter" => "getIsComplete",
			"getAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ]
		]
	];

	protected static		$_dataAccess = [
		"id_Pp" => [
			"get" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"set" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"defaultValue" => null
		],
		"resultat_questionnaire" => [
			"get" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"set" => [ /* ACCESS_ALL_LOCAL, ACCESS_SERVER */ ],
			"defaultValue" => 0
		],
		"niveau_risque" => [
			"get" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"set" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"defaultValue" => null,
			"editComponent" => "ComponentTypeEnumButtonEdit"
		],
		"competences_imobilieres" => [
			"get" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"set" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"editComponent" => "ComponentTypeBoolButtonEdit",
			"defaultValue" => null
		],
		"competences_financieres" => [
			"get" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"set" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"editComponent" => "ComponentTypeBoolButtonEdit",
			"defaultValue" => null
		],
		"connaissance_marche_imbobilier" => [
			"get" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"set" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"editComponent" => "ComponentTypeEnumButtonEdit",
			"defaultValue" => null,
		],
		"connaissance_scpi" => [
			"get" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"set" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"editComponent" => "ComponentTypeEnumButtonEdit",
			"defaultValue" => null,
		],
		"connaissance_placement_actions" => [
			"get" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"set" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"editComponent" => "ComponentTypeBoolButtonToogleEdit",
			"defaultValue" => false
		],
		"connaissance_placement_scpi" => [
			"get" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"set" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"editComponent" => "ComponentTypeBoolButtonToogleEdit",
			"defaultValue" => false
		],
		"connaissance_placement_assurance_vie" => [
			"get" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"set" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"editComponent" => "ComponentTypeBoolButtonToogleEdit",
			"defaultValue" => false
		],
		"connaissance_placement_opci" => [
			"get" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"set" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"editComponent" => "ComponentTypeBoolButtonToogleEdit",
			"defaultValue" => false
		],
		"connaissance_placement_obligations" => [
			"get" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"set" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"editComponent" => "ComponentTypeBoolButtonToogleEdit",
			"defaultValue" => false
		],
		"connaissance_placement_fcpi_fip_fcpr" => [
			"get" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"set" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"editComponent" => "ComponentTypeBoolButtonToogleEdit",
			"defaultValue" => false
		],
		"connaissance_placement_opcvm" => [
			"get" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"set" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"editComponent" => "ComponentTypeBoolButtonToogleEdit",
			"defaultValue" => false
		],
		"quiz" => [
			"get" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"set" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"defaultValue" => "[ null, null, null, null, null, null, null, null, null, null, null, null, null ]"
		],
		"date_creation" => [
			"get" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"set" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"defaultValue" => null
		],
		"estimation" => [
			"get" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"set" => [/* ACCESS_ALL_LOCAL, ACCESS_SERVER*/ ],
			"defaultValue" => null
		],
		"note" => [
			"get" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"set" => [ /*ACCESS_ALL_LOCAL, ACCESS_SERVER*/ ],
			"defaultValue" => null
		],
		"status" => [
			"get" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"set" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"defaultValue" => null
		],
		"dispose_actions" => [
			"get" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"set" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"editComponent" => "ComponentTypeBoolButtonToogleEdit",
			"defaultValue" => false
		],
		"dispose_fcpi_fip_fcpr" => [
			"get" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"set" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"editComponent" => "ComponentTypeBoolButtonToogleEdit",
			"defaultValue" => false
		],
		"dispose_opcvm" => [
			"get" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"set" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"editComponent" => "ComponentTypeBoolButtonToogleEdit",
			"defaultValue" => false
		],
		"dispose_assurance_vie" => [
			"get" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"set" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"editComponent" => "ComponentTypeBoolButtonToogleEdit",
			"defaultValue" => false
		],
		"dispose_obligations" => [
			"get" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"set" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"editComponent" => "ComponentTypeBoolButtonToogleEdit",
			"defaultValue" => false
		],
		"dispose_scpi" => [
			"get" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"set" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"editComponent" => "ComponentTypeBoolButtonToogleEdit",
			"defaultValue" => false
		],
		"dispose_opci" => [
			"get" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"set" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"editComponent" => "ComponentTypeBoolButtonToogleEdit",
			"defaultValue" => false
		],
		"dispose_liquidite" => [
			"get" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"set" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"editComponent" => "ComponentTypeBoolButtonToogleEdit",
			"defaultValue" => false
		],
		"dispose_pea" => [
			"get" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"set" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"editComponent" => "ComponentTypeBoolButtonToogleEdit",
			"defaultValue" => false
		],
		"dispose_immobilier_direct" => [
			"get" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"set" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"editComponent" => "ComponentTypeBoolButtonToogleEdit",
			"defaultValue" => false
		],
		"gestion_directe" => [
			"get" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"set" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"editComponent" => "ComponentTypeBoolButtonToogleEdit",
			"defaultValue" => false
		],
		"gestion_conseiller" => [
			"get" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"set" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"editComponent" => "ComponentTypeBoolButtonToogleEdit",
			"defaultValue" => false
		],
		"gestion_sous_mandat" => [
			"get" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"set" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"editComponent" => "ComponentTypeBoolButtonToogleEdit",
			"defaultValue" => false
		],
		"si_jinvesti_10000" => [
			"get" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"set" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"defaultValue" => null,
			"editComponent" => "ComponentTypeEnumButtonEdit"
		],
		"dispose_crowdfunding" => [
			"get" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"set" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"editComponent" => "ComponentTypeBoolButtonToogleEdit",
			"defaultValue" => false
		],
		"connaissance_placement_crowdfunding" => [
			"get" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"set" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"editComponent" => "ComponentTypeBoolButtonToogleEdit",
			"defaultValue" => false
		],
		"is_complete" => [
			"get" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"set" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"defaultValue" => null
		],
	];

	public function getForDonneurDOrdre($donneurdordre) {
		$rt = [];
		$pps = $donneurdordre->getPersonnePhysiques()->get();
		foreach ($pps as $pp) {
			$profils = $pp->getProfilInvestisseur()->get();
			foreach ($profils as $profil) {
				$rt[$profil->getId()] = $profil;
			}
		}
		return ($rt);
	}

	public function calculateScore() {
		$rt = 0;
		$rt += $this->getNiveauRisque()->get() - 1; // 0 - 3

		$rt += $this->getCompetencesImmobilieres()->get() ? 1 : 0;
		$rt += $this->getCompetencesFinancieres()->get() ? 1 : 0;
		$rt += $this->getConnaissanceMarcheImbobilier()->get() - 1; // 0 - 3
		$rt += $this->getConnaissanceScpi()->get() - 1; // 0 - 2

		$rt += $this->getConnaissancePlacementActions()->get() * 0.5;
		$rt += $this->getConnaissancePlacementAssuranceVie()->get() * 0.5;
		$rt += $this->getConnaissancePlacementObligations()->get() * 0.5;
		$rt += $this->getConnaissancePlacementOpcvm()->get() * 0.5;
		$rt += $this->getConnaissancePlacementScpi()->get() ;
		$rt += $this->getConnaissancePlacementOpci()->get() * 0.5;
		$rt += $this->getConnaissancePlacementFcpiFipFcpr()->get() * 0.5;


		$rt += $this->getDisposeActions()->get() ? 1 : 0;
		$rt += $this->getDisposeFcpiFipFcpr()->get() ? 1 : 0;
		$rt += $this->getDisposeOpcvm()->get() ? 1 : 0;
		$rt += $this->getDisposeAssuranceVie()->get() ? 1 : 0;
		$rt += $this->getDisposeObligations()->get() ? 1 : 0;
		$rt += $this->getDisposeScpi()->get() ? 1 : 0;


		$rt += $this->getDisposeOpci()->get() ? 1 : 0;
		$rt += $this->getDisposeLiquidite()->get() ? 1 : 0;
		$rt += $this->getDisposePea()->get() ? 1 : 0;
		$rt += $this->getDisposeImmobilierDirect()->get() ? 1 : 0;

		$rt += ($this->getSiJinvesti10000()->get() == 480) ? 1 : 0;

		$profil = $this->getQuiz()->get();
		foreach($profil as $key => $elm) {
			$rt += self::$_listQuestions[$key]['response'][intval($elm)];
		}

		return (intval($rt) / 2);
	}

	public function beforeSet($prev) {
		if ($prev === null)
			$this->getDateCreation()->setRawValue(time());
		$quiz = $this->getQuiz();
		if ($quiz->checkValid()) {
			$this->getResultatQuestionnaire()->setControlEmpty($this->calculateScore());
		}
		return (true);
	}

	public function getIsPerime() {
		// TODO On doit vérifier ici que la date n'est pas périmée et que is_complete est la.
		return (false);
	}

	public static		$_listQuestions = array(
			0 => array(
				"title" => "Connaissez-vous les modalités de vente et d’achat en parts de SCPI ?",
				//"title" => "Connaissez-vous les modalités de passage des ordres en part de SCPI ?",
				"correction" => 
					"Il existe deux formes de SCPI :<br />
					- Les SCPI à capital fixe : un capital plafond est inscrit dans les statuts. La société de gestion augmente progressivement le capital de la SCPI jusqu’à atteindre ce capital plafond. Entre chaque augmentation, le capital reste fixe. On peut donc souscrire :<br />
					<ul>
						<li>
							sur le marché primaire lors d’augmentation de capital et de l’émission de nouvelles parts; (le prix est déterminé par la société de gestion) vous souscrivez avec un bulletin de souscription
						</li>
						<li>
							sur le marché secondaire, ce marché est organisé et permet de déterminer le prix de vente. (le prix est déterminé selon l'offre et la demande) vous souscrivez avec un mandat d'achat de parts
						</li>
					</ul>
					<br />
					Les SCPI à capital variable : il n’y a pas de marché secondaire ce qui permet (sauf cas exceptionnel) de souscrire de manière permanente. Le prix de souscription est alors défini par la société de gestion vous souscrivez avec un bulletin de souscription",
				"online" => true,
				"response" => array(
					0 => 1,		// Oui
					1 => 0		// Non
				)
			),
			1 => array(
				"title" => "Connaissez-vous les risques liés aux investissements en parts de SCPI ?",
				"correction" =>
					"La SCPI en tant qu’investissement immobilier peut présenter certains risques : perte de valeur et/ou absence de rendement. Cependant la répartition géographique (région parisienne, Province) et la diversification dans la typologie d’immobilier (bureaux, commerces, activités...) permet de limiter et d’atténuer ces risques. <br />
					La défaillance de la société de gestion qui gère la SCPI. Les sociétés de gestion sont agréées et contrôlées par l’Autorité des Marchés Financiers. Cependant si une société de gestion venait à défaillir, la gestion de la SCPI serait transférée, selon la loi, à une autre société de gestion agréée par l’Autorité des Marchés Financiers..<br />
					Le capital n’est pas garanti <br />
					La responsabilité financière des porteurs est limitée aux apports au capital. <br />
					La revente des parts n’est pas garantie, elle peut donc varier en fonction de l’évolution du marché de l’immobilier et des parts de SCPI. La réglementation du marché secondaire organise la liquidité des parts.",
				"online" => true,
				"response" => array(
					0 => 1,		// Oui
					1 => 0		// Non
				)
			),
			2 => array(
				"title" => "La SCPI est un placement garanti.",
				"correction" => "Le capital de la SCPI n'est pas garanti. Il en est de même pour les dividendes qui peuvent augmenter et dimuner en fonction du contexte du marché immobilier.",
				"online" => true,
				"response" => array(
					0 => 0,		// Oui
					1 => 2,		// Non
					2 => 0		// Ne se prononce pas
				)
			),
			3 => array(
				"title" => "La rentabilité d’un placement en immobilier dépend de la qualité des locataires et de la localisation des actifs.",
				"correction" => "La rentabilité dépend de la qualité de l'emplacement et de la qualité du locataire.",
				"online" => true,
				"response" => array(
					0 => 1,		// Oui
					1 => 0,		// Non
					2 => 0		// Ne se prononce pas
				)
			),
			4 => array(
				"title" => "La société de gestion peut acheter tous les actifs immobiliers qu’elle souhaite sans respecter la politique d’investissement de la SCPI.",
				"correction" => "La société de gestion doit respecter la politique d'investissement précisée dans la note d'informations et les statuts de la SCPI.",
				"online" => true,
				"response" => array(
					0 => 0,		// Oui
					1 => 1,		// Non
					2 => 0		// Ne se prononce pas
				)
			),
			5 => array(
				"title" => "La revente des parts d’une SCPI de rendement est possible.",
				"correction" =>
					"La liquidité des parts se fait selon la forme juridique de la SCPI :<br />
					- Pour les SCPI à capital variable :<br />
					L’associé fait une demande de remboursement de la part à la valeur de retrait (définie par la société de gestion). La demande est acceptée seulement si une contrepartie souhaite souscrire, sinon la société de gestion peut être amenée à créer un fonds de remboursement destiné éventuellement à satisfaire les demandes de retrait. Ce fonds de remboursement peut être constitué à partir de cession d’actifs immobiliers.<br />
					- Pour les SCPI à capital fixe :<br />
					Le marché secondaire est organisé depuis la loi du 9 juillet 2001, des «confrontations» ont lieu tout au long de l’année et un carnet d’ordres recense l’ensemble des ordres d’achat et de vente. Le marché secondaire des parts de SCPI répond ainsi aux lois de l'offre et de la demande. L’acquisition de parts de SCPI à capital fixe sur le marché secondaire est soumise aux droits d’enregistrement.",
				"online" => true,
				"response" => array(
					0 => 1,		// Oui
					1 => 0,		// Non
					2 => 0		// Ne se prononce pas
				)
			),
			6 => array(
				"title" => "La SCPI est un placement investi quasi exclusivement en immobilier.",
				"correction" => "La SCPI est une société civile de placement immobilier. Elle investit quasi exclusivement en immobilier d’entreprise (commerces, bureaux, logistiques, santé, hôtels) pour les SCPI de rendement et en habitations pour le SCPI Fiscales. Je vous joins le guide de la SCPI qui vous permettra d’étoffer vos connaissances en SCPI.",
				"online" => true,
				"response" => array(
					0 => 1,		// Oui
					1 => 0,		// Non
					2 => 0		// Ne se prononce pas
				)
			),
			7 => array(
				"title" => "Le placement en parts de SCPI est un placement à court terme.",
				"correction" => "Le placement en parts de SCPI doit être sur le long terme minimum 8 années pour les SCPI de rendement et 15 ans pour les SCPI Fiscales.",
				"online" => true,
				"response" => array(
					0 => 0,		// Oui
					1 => 1,		// Non
					2 => 0		// Ne se prononce pas
				)
			),
			8 => array(
				"title" => "La liquidité du placement en SCPI fiscale est très limitée.",
				"correction" => "La liquidité du placement est très limitée. L'avantage fiscal, composante importante de la rentabilité du placement ne peut être transmis, les possibilités de revente seront donc très réduites sauf à des prix fortement décotés. La SCPI ne garantit pas la revente des parts.",
				"online" => true,
				"response" => array(
					0 => 1,		// Oui
					1 => 0,		// Non
					2 => 0		// Ne se prononce pas
				)
			),
			9 => array(
				"title" => "L’investissement en SCPI fiscale doit s’envisager sur une période généralement inférieure à 15 ans.",
				"correction" => "Un investissement en parts de SCPI fiscales doit s'envisager sur une période de 15 ans minimum : c'est la durée au terme de laquelle la SCPI sera dissoute, et l'associé récupérera le capital investi.",
				"online" => true,
				"response" => array(
					0 => 0,		// Oui
					1 => 1,		// Non
					2 => 0		// Ne se prononce pas
				)
			),
			10 => array(
				"title" => "L’avantage fiscal d’une SCPI fiscal est transmissible.",
				"correction" => "L'avantage fiscal d’une SCPI fiscale n'est pas transmissible.",
				"online" => true,
				"response" => array(
					0 => 0,		// Oui
					1 => 1,		// Non
					2 => 0		// Ne se prononce pas
				)
			),
			11 => array(
				"title" => "La SCPI est un investissement immobilier. Acceptez-vous d’envisager ce placement sur le long terme (supérieur à 10 ans) pour les SCPI de rendement?",
				"correction" => "Un investissement en SCPI est pour une durée d’investissement long terme minimum 8 années pour les SCPI de rendement et 15 ans généralement pour les SCPI Fiscales. ",
				"online" => true,
				"response" => array(
					0 => 1,		// Oui
					1 => 0		// Non
				)
			),
			12 => array(
				"title" => "Dans le cas d'un investissement immobilier avec une stratégie d'investissement au-delà de la zone euro, le capital et les revenus peuvent varier également en fonction du cours des devises. Acceptez-vous de prendre un risque lié à la variation du cours des devises ?",
				"correction" => "Le versement des dividendes n’est pas garanti et peut évoluer à la hausse comme à la baisse en raison de la variation des marchés immobiliers et cours des devises, des conditions de location des
				immeubles (notamment niveau des loyers, taux de vacance).",
				"online" => true,
				"response" => array(
					0 => 2,		// Oui
					1 => 0,		// Non
					2 => 0		// Ne se prononce pas
				)
			)
		);

	public static $_typeProfil = array(
		0 => array(
			"color" => "rgb(120, 165, 191)",
			"min" => 0,
			"max" => 5,
			"needCheck" => true,
			"niveau" => "CONNAISSANCE INEXISTANTE",
			"profil" => "PROFIL PRUDENT OU SÉCURITAIRE",
			"description" => "Vous êtes un investisseur novice et vous avez une expérience très reduite des investissements.Vous souhaitez protéger votre capital en favorisant la sécurité de vos placements au détriment du potentiel de rendement."
		),
		1 => array(
			"color" => "rgb(90, 145, 177)",
			"min" => 5,
			"max" => 10,
			"needCheck" => true,
			"niveau" => "DÉBUTANT",
			"profil" => "PROFIL MODÉRÉ",
			"description" => "Vous êtes un investisseur débutant et vous avez une expérience reduite des investissements.Vous souhaitez favoriser la sécurité de vos placements tout en autorisant un certain niveau de risque pour augmenter légèrement votre rendement potentiel."
		),
		2 => array(
			"color" => "rgb(61, 124, 163)",
			"min" => 10,
			"max" => 15,
			"needCheck" => false,
			"niveau" => "CONNAISANCE INTERMÉDIAIRE",
			"profil" => "PROFIL EQUILIBRÉ",
			"description" => "Vous avez une expérience intermédiaire des investissement. Vous cherchez un juste équilibre entre des investissements bénéficiant d'un bon potentiel de rendement et des placements tolérant de maintenir le risque de votre portefeuille à un niveau modéré."
		),
		3 => array(
			"color" => "rgb(31, 104, 149)",
			"min" => 15,
			"max" => 19,
			"needCheck" => false,
			"niveau" => "CONNAISSANCE CONFIRMÉ",
			"profil" => "PROFIL DYNAMIQUE",
			"description" => "Vous êtes un investisseur avisé et êtes relativement expérimenté. Vous souhaitez vous procurer un potentiel de rendement élevé sur vos placements tout en abaissant en partie les variabilités des marchés."
		),
		4 => array(
			"color" => "rgb(2, 84, 135)",
			"min" => 19,
			"max" => 20.1,
			"needCheck" => false,
			"niveau" => "CONNAISSANCE ÉLEVÉE",
			"profil" => "PROFIL OFFENSIF",
			"description" => "Vous êtes un investisseur très avisé et êtes un investisseur très expérimenté. Vous souhaitez améliorer le potentiel de rendement sur vos placements en autorisant pour cela des fluctuations importantes sur les valeurs de vos placements."
		)
	);

	public static function generateVuexGetters() {
		$rt = [
			"getProfilInvestisseur2ByProjet2Id" => "
				return ( function(projet2_id) {
					var Pps = getters.getPersonnesPhysiqueByProjet2Id(projet2_id);
					for (key in Pps) {
						var pp = Pps[key];
						var profils = getters.getProfilInvestisseur2_id_Pp(pp.id.value);
						for (key2 in profils) {
							var profil = profils[key2];
							if (profil.is_complete.value !== true) {
								return (profil);
							}
							// TODO : il faudra aussi vérifier si la date est valide
						}
					}
					return (null);
				});
			",
		];
		$rt = array_merge($rt, parent::generateVuexGetters());
		return ($rt);
	}


	public function getProfil() {
		$rt = null;
		foreach (self::$_typeProfil as $key => $elm)
		{
			if ($this->getScore() < $elm['max'])
				return ($elm);
		}
	}
}
