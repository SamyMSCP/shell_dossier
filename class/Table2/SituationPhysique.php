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

class SituationPhysique extends Table2 {
	protected static		$_name = "situation_physique";
	protected static		$_primary_key = "id";
	public static			$_access = [ ACCESS_ALL_LOCAL, ACCESS_SERVER ];
	protected static		$_dataTypes = [
		"date_creation" => [
			"type" => "TypeDate",
			"config" => [
				"column" => "date_creation",
				//"canEmpty" => true
			],
			"getter" => "getDateCreation",
			"getAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ]
		],
		"date_modification" => [
			"type" => "TypeDate",
			"config" => [
				"column" => "date_modification",
				//"canEmpty" => true
			],
			"getter" => "getDateModification",
			"getAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ]
		],
		"id_situation" => [
			"type" => "TypeUInt",
			"config" => [
				"column" => "id_situation"
			],
			"getter" => "getIdSituation",
			"getAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ]
		],
		"PersonnesPhysiques" => [
			"type" => "TypeToManyStatic",
			"config" => [
				"accessName" => "PersonnesPhysiques",
				"class" => "PersonnePhysique",
				"joinTable" => "situation",
				"myColumn" => "id",
				"otherColumn" => "id",
				"myIdName" => "id_situation",
				"otherIdName" => "id_situation",
				"canEmpty" => true
			],
			"getter" => "getPersonnesPhysiques",
			"getAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ]
		],
		"etat_civil" => [
			"type" => "TypeEnumInt",
			"config" => [
				"props" => [
					":list" => [
						"Marié(e)"			=> 1,
						"Pacsé(e)"			=> 2,
						"Union libre"		=> 3
					]
				],
				"datas" => [ 1, 2, 3 ],
				"column" => "etat_civil",
				"canEmpty" => true
			],
			"getter" => "getEtatCivil",
			"getAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ]
		],
		"regime_matrimonial" => [
			"type" => "TypeEnumInt",
			"config" => [
				"props" => [
					":list" => [
						"Communauté réduite aux acquêts (sans contrat)"	=> 1,
						"Participation aux acquêts"						=> 2,
						"Communauté universelle"						=> 3,
						"Séparation de biens"							=> 4
					]
				],
				"datas" => [ 1, 2, 3, 4 ],
				"column" => "regime_matrimonial"
			],
			"getter" => "getRegimeMatrimonial",
			"getAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ]
		],
		"a_des_enfants" => [
			"type" => "TypeBool",
			"config" => [
				"column" => "a_des_enfants"
			],
			"getter" => "getADesEnfants",
			"getAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ]
		],
		"nbr_enfants" => [
			"type" => "TypeUint",
			"config" => [
				"column" => "nbr_enfants"
			],
			"getter" => "getNbrEnfants",
			"getAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ]
		],
		"enfants_a_charge" => [
			"type" => "TypeUint",
			"config" => [
				"column" => "enfants_a_charge"
			],
			"getter" => "getEnfantsACharge",
			"getAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ]
		],
		"autre_personne_charge" => [
			"type" => "TypeUint",
			"config" => [
				"column" => "autre_personne_charge"
			],
			"getter" => "getAutrePersonneCharge",
			"getAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ]
		],
		"revenu_salaire" => [
			"type" => "TypeEuros",
			"config" => [
				"column" => "revenu_salaire"
			],
			"getter" => "getRevenuSalaire",
			"getAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ]
		],
		"revenu_immobilliers" => [
			"type" => "TypeEuros",
			"config" => [
				"column" => "revenu_immobilliers"
			],
			"getter" => "getRevenuImmobilliers",
			"getAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ]
		],
		"revenu_mobilliers" => [
			"type" => "TypeEuros",
			"config" => [
				"column" => "revenu_mobilliers"
			],
			"getter" => "getRevenuMobilliers",
			"getAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ]
		],
		"revenu_autres" => [
			"type" => "TypeEuros",
			"config" => [
				"column" => "revenu_autres"
			],
			"getter" => "getRevenuAutres",
			"getAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ]
		],
		"revenu_autres_precision" => [
			"type" => "TypeStringNotNull",
			"config" => [
				"column" => "revenu_autres_precision"
			],
			"getter" => "getRevenuAutresPrecision",
			"getAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ]
		],

		"remboursement_mensuel" => [
			"type" => "TypeEuros",
			"config" => [
				"column" => "remboursement_mensuel"
			],
			"getter" => "getRemboursementMensuel",
			"getAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ]
		],
		"duree_remboursement_restante" => [
			"type" => "TypeUint",
			"config" => [
				"column" => "duree_remboursement_restante"
			],
			"getter" => "getDureeRemboursementRestante",
			"getAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ]
		],
		"loyer" => [
			"type" => "TypeEuros",
			"config" => [
				"column" => "loyer"
			],
			"getter" => "getLoyer",
			"getAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ]
		],
		"credit_residence_secondaire" => [
			"type" => "TypeEuros",
			"config" => [
				"column" => "credit_residence_secondaire"
			],
			"getter" => "getCreditResidenceSecondaire",
			"getAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ]
		],
		"credit_residence_secondaire_duree" => [
			"type" => "TypeUint",
			"config" => [
				"column" => "credit_residence_secondaire_duree"
			],
			"getter" => "getCreditResidenceSecondaireDuree",
			"getAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ]
		],
		"credit_immobilier_locatif" => [
			"type" => "TypeEuros",
			"config" => [
				"column" => "credit_immobilier_locatif"
			],
			"getter" => "getCreditImmobilierLocatif",
			"getAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ]
		],
		"credit_immobilier_locatif_duree" => [
			"type" => "TypeUint",
			"config" => [
				"column" => "credit_immobilier_locatif_duree"
			],
			"getter" => "getCreditImmobilierLocatifDuree",
			"getAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ]
		],
		"credit_scpi" => [
			"type" => "TypeEuros",
			"config" => [
				"column" => "credit_scpi"
			],
			"getter" => "getCreditScpi",
			"getAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ]
		],
		"credit_scpi_duree" => [
			"type" => "TypeUint",
			"config" => [
				"column" => "credit_scpi_duree"
			],
			"getter" => "getCreditScpiDuree",
			"getAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ]
		],
		"credit_a_la_consommation" => [
			"type" => "TypeEuros",
			"config" => [
				"column" => "credit_a_la_consommation"
			],
			"getter" => "getCreditALaConsomation",
			"getAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ]
		],
		"credit_a_la_consommation_duree" => [
			"type" => "TypeUint",
			"config" => [
				"column" => "credit_a_la_consommation_duree"
			],
			"getter" => "getCreditALaConsomationDuree",
			"getAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ]
		],
		"credit_autres" => [
			"type" => "TypeEuros",
			"config" => [
				"column" => "credit_autres"
			],
			"getter" => "getCreditAutres",
			"getAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ]
		],
		"credit_autres_duree" => [
			"type" => "TypeUint",
			"config" => [
				"column" => "credit_autres_duree"
			],
			"getter" => "getCreditAutresDuree",
			"getAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ]
		],
		"autres_charges" => [
			"type" => "TypeEuros",
			"config" => [
				"column" => "autres_charges"
			],
			"getter" => "getAutresCharges",
			"getAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ]
		],
		"habitation" => [
			"type" => "TypeEnumInt",
			"config" => [
				"props" => [
					":list" => [
						"Propriétaire"				=> 1,
						"Locataire"					=> 2,
						"Hébergé à titre gratuit"	=> 3
					]
				],
				"datas" => [ 1, 2, 3 ],
				"column" => "habitation"
			],
			"getter" => "getHabitation",
			"getAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ]
		],
		"pays_residence_fiscale" => [
			"type" => "TypePays",
			"config" => [
				"column" => "pays_residence_fiscale"
			],
			"getter" => "getPaysResidenceFiscale",
			"getAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ]
		],
		"assujetti_impot_revenu" => [
			"type" => "TypeBool",
			"config" => [
				"column" => "assujetti_impot_revenu"
			],
			"getter" => "getAssujettiImpotRevenu",
			"getAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ]
		],
		"impot_annee_precedente" => [
			"type" => "TypeEurosNotNull",
			"config" => [
				"column" => "impot_annee_precedente"
			],
			"getter" => "getImpotAnneePrecedente",
			"getAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ]
		],
		"tranche_marginale_imposition" => [
			"type" => "TypeTrancheImpotRevenu",
			"config" => [
				"props" => [
					":list" => [
						"0 %"	=> 1,
						"14 %"	=> 2,
						"30 %"	=> 3,
						"41 %"	=> 4,
						"45 %"	=> 5
						/*
						"0 % :  excédant pas 9 710 €"			=> 1,
						"14 % : entre 9 710 € et 26 818 €"		=> 2,
						"30 % : entre 26 818 € et 71 898 €"		=> 3,
						"41 % : entre 71 898 € et 152 260 €"	=> 4,
						"45 % : supérieur à 152 260 €"			=> 5
						*/
					]
				],
				"datas" => [ 1, 2, 3, 4, 5 ],
				"column" => "tranche_marginale_imposition"
			],
			"getter" => "getTrancheMarginaleImposition",
			"getAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ]
		],
		"nombre_parts_fiscales" => [
			"type" => "TypeDemiInt",
			"config" => [
				"column" => "nombre_parts_fiscales"
			],
			"getter" => "getNombrePartFiscales",
			"getAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ]
		],
		"impot_fortune" => [
			"type" => "TypeBool",
			"config" => [
				"column" => "impot_fortune"
			],
			"getter" => "getImpotFortune",
			"getAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ]
		],
		"tranche_impot_fortune" => [
			"type" => "TypeTrancheImpotFortune",
			"config" => [
				"props" => [
					":list" => [
						"0.5 % : entre 800 000 € et 1 300 000 €	"		=> 1,
						"0.7 % : entre 1 300 000 € et 2 570 000 €"		=> 2,
						"1 % : entre 2 570 000 € et 5 000 000 €"		=> 3,
						"1.25 % : entre 5 000 000 € et 10 000 000 €"	=> 4,
						"1.5 % : supérieur à 10 000 000 €"				=> 5
					]
				],
				"datas" => [ 1, 2, 3, 4, 5 ],
				"column" => "tranche_impot_fortune"
			],
			"getter" => "getTrancheImpotFortune",
			"getAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ]
		],
		"estimation_patrimoine_global" => [
			"type" => "TypeEurosFourchette",
			"config" => [
				"props" => [
					":list" => [
						"à moins de 50 000 €"				=> 1,
						"entre 50 000 € et 100 000 €"		=> 2,
						"entre 100 000 € et 500 000 €"		=> 3,
						"entre 500 000 € et 1 300 000 €"	=> 4,
						"à plus de 1 300 000 €"				=> 5
					]
				],
				"datas" => [ 1, 2, 3, 4, 5 ],
				"column" => "estimation_patrimoine_global"
			],
			"getter" => "getEstimationPatrimoineGlobal",
			"getAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ]
		],
		"patrimoine_residence_principale" => [
			"type" => "TypeEuros",
			"config" => [
				"column" => "patrimoine_residence_principale"
			],
			"getter" => "getPatrimoineResidencePrincipale",
			"getAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ]
		],
		"patrimoine_assurance_vie" => [
			"type" => "TypeEuros",
			"config" => [
				"column" => "patrimoine_assurance_vie"
			],
			"getter" => "getPatrimoineAssuranceVie",
			"getAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ]
		],
		"patrimoine_pea_compte_titre" => [
			"type" => "TypeEuros",
			"config" => [
				"column" => "patrimoine_pea_compte_titre"
			],
			"getter" => "getPatrimoinePeaCompteTitre",
			"getAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ]
		],
		"patrimoine_pel_cel_codevi_livret" => [
			"type" => "TypeEuros",
			"config" => [
				"column" => "patrimoine_pel_cel_codevi_livret"
			],
			"getter" => "getPatrimoinePelCelCodeviLivret",
			"getAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ]
		],
		"patrimoine_residence_secondaire" => [
			"type" => "TypeEuros",
			"config" => [
				"column" => "patrimoine_residence_secondaire"
			],
		"getter" => "getPatrimoineResidenceSecondaire",
			"getAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ]
		],
		"patrimoine_immobilier_locatif" => [
			"type" => "TypeEuros",
			"config" => [
				"column" => "patrimoine_immobilier_locatif"
			],
			"getter" => "getPatrimoineImmobilierLocatif",
			"getAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ]
		],
		"patrimoine_scpi" => [
			"type" => "TypeEuros",
			"config" => [
				"column" => "patrimoine_scpi"
			],
			"getter" => "getPatrimoineScpi",
			"getAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ]
		],
		"patrimoine_autres" => [
			"type" => "TypeEuros",
			"config" => [
				"column" => "patrimoine_autres"
			],
			"getter" => "getPatrimoineAutres",
			"getAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ]
		],

		"patrimoine_epargne_retraite" => [
			"type" => "TypeEuros",
			"config" => [
				"column" => "patrimoine_epargne_retraite"
			],
			"getter" => "getPatrimoineEpargneRetraite",
			"getAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ]
		],

		"patrimoine_part_futur_placement" => [
			"type" => "TypeEnumInt",
			"config" => [
				"props" => [
					":list" => [
						"Faible (inférieure à 10 %)"		=> 1,
						"Moyenne (10 à 30 %)"				=> 2,
						"Importante (supérieure à 30 %)"	=> 3
					]
				],
				"datas" => [ 1, 2, 3 ],
				"column" => "patrimoine_part_futur_placement"
			],
			"getter" => "getPatrimoinePartFuturPlacement",
			"getAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ]
		],

		"revenu_fiscale_reference" => [
			"type" => "TypeEuros",
			"config" => [
				"column" => "revenu_fiscale_reference"
			],
			"getter" => "getRevenuFiscaleReference",
			"getAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ]
		],

		"regime_foncier" => [
			"type" => "TypeEnumInt",
			"config" => [
				"props" => [
					":list" => [
						"Réel"		=> 1,
						"Micro-Foncier"				=> 2
					]
				],
				"canEmpty" => true,
				"datas" => [ 1, 2 ],
				"column" => "regime_foncier"
			],
			"getter" => "getRegimeFoncier",
			"getAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ]
		],

		"deficit_foncier" => [
			"type" => "TypeEuros",
			"config" => [
				"canEmpty" => true,
				"column" => "deficit_foncier"
			],
			"getter" => "getDeficitFoncier",
			"getAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ]
		],

		"is_valid" => [
			"type" => "TypeBool",
			"config" => [
				"column" => "is_valid"
			],
			"getter" => "getIsValid",
			"getAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ]
		],
		"precision_coherence_1" => [
			"type" => "TypePrecisionCoherence",
			"config" => [
				"column" => "precision_coherence_1",
				"canEmpty" => true
			],
			"getter" => "getPrecisionCoherence1",
			"getAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ]
		],
		"precision_coherence_2" => [
			"type" => "TypePrecisionCoherence",
			"config" => [
				"column" => "precision_coherence_2",
				"canEmpty" => true
			],
			"getter" => "getPrecisionCoherence2",
			"getAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ]
		],
		"precision_coherence_3" => [
			"type" => "TypePrecisionCoherence",
			"config" => [
				"column" => "precision_coherence_3",
				"canEmpty" => true
			],
			"getter" => "getPrecisionCoherence3",
			"getAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ]
		],
		"precision_coherence_4" => [
			"type" => "TypePrecisionCoherence",
			"config" => [
				"column" => "precision_coherence_4",
				"canEmpty" => true
			],
			"getter" => "getPrecisionCoherence4",
			"getAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ]
		],
		"precision_coherence_5" => [
			"type" => "TypePrecisionCoherence",
			"config" => [
				"column" => "precision_coherence_5",
				"canEmpty" => true
			],
			"getter" => "getPrecisionCoherence5",
			"getAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ]
		],
		"precision_coherence_6" => [
			"type" => "TypePrecisionCoherence",
			"config" => [
				"column" => "precision_coherence_6",
				"canEmpty" => true
			],
			"getter" => "getPrecisionCoherence6",
			"getAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ]
		],
		"precision_coherence_7" => [
			"type" => "TypePrecisionCoherence",
			"config" => [
				"column" => "precision_coherence_7",
				"canEmpty" => true
			],
			"getter" => "getPrecisionCoherence7",
			"getAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ]
		],
		"precision_coherence_8" => [
			"type" => "TypePrecisionCoherence",
			"config" => [
				"column" => "precision_coherence_8",
				"canEmpty" => true
			],
			"getter" => "getPrecisionCoherence8",
			"getAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ]
		],
		"precision_coherence_9" => [
			"type" => "TypePrecisionCoherence",
			"config" => [
				"column" => "precision_coherence_9",
				"canEmpty" => true
			],
			"getter" => "getPrecisionCoherence9",
			"getAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ]
		],
		"precision_coherence_10" => [
			"type" => "TypePrecisionCoherence",
			"config" => [
				"column" => "precision_coherence_10",
				"canEmpty" => true
			],
			"getter" => "getPrecisionCoherence10",
			"getAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ]
		],
		"precision_coherence_11" => [
			"type" => "TypePrecisionCoherence",
			"config" => [
				"column" => "precision_coherence_11",
				"canEmpty" => true
			],
			"getter" => "getPrecisionCoherence11",
			"getAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ]
		],
		"precision_coherence_12" => [
			"type" => "TypePrecisionCoherence",
			"config" => [
				"column" => "precision_coherence_12",
				"canEmpty" => true
			],
			"getter" => "getPrecisionCoherence12",
			"getAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ]
		],
		"precision_coherence_13" => [
			"type" => "TypePrecisionCoherence",
			"config" => [
				"column" => "precision_coherence_13",
				"canEmpty" => true
			],
			"getter" => "getPrecisionCoherence13",
			"getAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ]
		],
		"precision_coherence_14" => [
			"type" => "TypePrecisionCoherence",
			"config" => [
				"column" => "precision_coherence_14",
				"canEmpty" => true
			],
			"getter" => "getPrecisionCoherence14",
			"getAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ]
		],
		"precision_coherence_15" => [
			"type" => "TypePrecisionCoherence",
			"config" => [
				"column" => "precision_coherence_15",
				"canEmpty" => true
			],
			"getter" => "getPrecisionCoherence15",
			"getAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ]
		],
		"precision_coherence_16" => [
			"type" => "TypePrecisionCoherence",
			"config" => [
				"column" => "precision_coherence_16",
				"canEmpty" => true
			],
			"getter" => "getPrecisionCoherence16",
			"getAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ]
		],
	];

	protected static		$_dataAccess = [
		"date_creation" => [
			"get" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"set" => [ /*ACCESS_ALL_LOCAL, ACCESS_SERVER */],
			"defaultValue" => null
		],
		"date_modification" => [
			"get" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"set" => [ /*ACCESS_ALL_LOCAL, ACCESS_SERVER */],
			"defaultValue" => null
		],
		"id_situation" => [
			"get" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"set" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"defaultValue" => null
		],
		"PersonnesPhysiques" => [
			"get" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"set" => [ /*ACCESS_ALL_LOCAL, ACCESS_SERVER */],
			"defaultValue" => null
		],
		"etat_civil" => [
			"get" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"set" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"defaultValue" => null
		],
		"regime_matrimonial" => [
			"get" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"set" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"defaultValue" => null
		],
		"a_des_enfants" => [
			"get" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"set" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"defaultValue" => null
		],
		"nbr_enfants" => [
			"get" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"set" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"defaultValue" => null
		],
		"enfants_a_charge" => [
			"get" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"set" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"defaultValue" => null
		],
		"autre_personne_charge" => [
			"get" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"set" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"defaultValue" => null
		],
		"revenu_salaire" => [
			"get" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"set" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"defaultValue" => 0
		],
		"revenu_immobilliers" => [
			"get" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"set" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"defaultValue" => 0
		],
		"revenu_mobilliers" => [
			"get" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"set" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"defaultValue" => 0
		],
		"revenu_autres" => [
			"get" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"set" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"defaultValue" => 0
		],
		"revenu_autres_precision" => [
			"get" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"set" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"defaultValue" => 0
		],
		"remboursement_mensuel" => [
			"get" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"set" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"defaultValue" => 0
		],
		"duree_remboursement_restante" => [
			"get" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"set" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"defaultValue" => 0
		],
		"loyer" => [
			"get" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"set" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"defaultValue" => 0
		],
		"credit_residence_secondaire" => [
			"get" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"set" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"defaultValue" => 0
		],
		"credit_residence_secondaire_duree" => [
			"get" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"set" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"defaultValue" => 0
		],
		"credit_immobilier_locatif" => [
			"get" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"set" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"defaultValue" => 0
		],
		"credit_immobilier_locatif_duree" => [
			"get" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"set" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"defaultValue" => 0
		],
		"credit_scpi" => [
			"get" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"set" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"defaultValue" => 0
		],
		"credit_scpi_duree" => [
			"get" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"set" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"defaultValue" => 0
		],
		"credit_a_la_consommation" => [
			"get" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"set" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"defaultValue" => 0
		],
		"credit_a_la_consommation_duree" => [
			"get" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"set" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"defaultValue" => 0
		],
		"credit_autres" => [
			"get" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"set" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"defaultValue" => 0
		],
		"credit_autres_duree" => [
			"get" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"set" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"defaultValue" => 0
		],
		"autres_charges" => [
			"get" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"set" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"defaultValue" => 0
		],
		"habitation" => [
			"get" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"set" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"defaultValue" => null,
			"editComponent" => "ComponentTypeEnumButtonEdit",
			//"editComponent" => "ComponentTypeEnumCheckboxEdit"
		],
		"pays_residence_fiscale" => [
			"get" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"set" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"defaultValue" => null
		],
		"assujetti_impot_revenu" => [
			"get" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"set" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"defaultValue" => null
		],
		"impot_annee_precedente" => [
			"get" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"set" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"defaultValue" => null
		],
		"tranche_marginale_imposition" => [
			"get" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"set" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"defaultValue" => null
		],
		"nombre_parts_fiscales" => [
			"get" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"set" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"defaultValue" => null
		],
		"impot_fortune" => [
			"get" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"set" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"defaultValue" => null
		],
		"tranche_impot_fortune" => [
			"get" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"set" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"defaultValue" => null
		],
		"estimation_patrimoine_global" => [
			"get" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"set" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"defaultValue" => null
		],
		"patrimoine_residence_principale" => [
			"get" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"set" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"defaultValue" => 0
		],
		"patrimoine_assurance_vie" => [
			"get" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"set" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"defaultValue" => 0
		],
		"patrimoine_pea_compte_titre" => [
			"get" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"set" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"defaultValue" => 0
		],
		"patrimoine_pel_cel_codevi_livret" => [
			"get" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"set" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"defaultValue" => 0
		],
		"patrimoine_residence_secondaire" => [
			"get" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"set" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"defaultValue" => 0
		],
		"patrimoine_immobilier_locatif" => [
			"get" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"set" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"defaultValue" => 0
		],
		"patrimoine_scpi" => [
			"get" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"set" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"defaultValue" => 0
		],
		"patrimoine_epargne_retraite" => [
			"get" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"set" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"defaultValue" => 0
		],
		"patrimoine_autres" => [
			"get" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"set" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"defaultValue" => 0
		],
		"patrimoine_part_futur_placement" => [
			"get" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"set" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"defaultValue" => null,
		],

		"revenu_fiscale_reference" => [
			"get" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"set" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"defaultValue" => null
		],
		"regime_foncier" => [
			"get" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"set" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"defaultValue" => null
		],
		"deficit_foncier" => [
			"get" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"set" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"defaultValue" => null
		],


		"is_valid" => [
			"get" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"set" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"defaultValue" => null
		],

		"precision_coherence_1" => [
			"get" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"set" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"defaultValue" => null
		],
		"precision_coherence_2" => [
			"get" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"set" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"defaultValue" => null
		],
		"precision_coherence_3" => [
			"get" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"set" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"defaultValue" => null
		],
		"precision_coherence_4" => [
			"get" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"set" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"defaultValue" => null
		],
		"precision_coherence_5" => [
			"get" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"set" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"defaultValue" => null
		],
		"precision_coherence_6" => [
			"get" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"set" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"defaultValue" => null
		],
		"precision_coherence_7" => [
			"get" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"set" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"defaultValue" => null
		],
		"precision_coherence_8" => [
			"get" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"set" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"defaultValue" => null
		],
		"precision_coherence_9" => [
			"get" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"set" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"defaultValue" => null
		],

		"precision_coherence_10" => [
			"get" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"set" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"defaultValue" => null
		],
		"precision_coherence_11" => [
			"get" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"set" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"defaultValue" => null
		],
		"precision_coherence_12" => [
			"get" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"set" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"defaultValue" => null
		],
		"precision_coherence_13" => [
			"get" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"set" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"defaultValue" => null
		],
		"precision_coherence_14" => [
			"get" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"set" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"defaultValue" => null
		],
		"precision_coherence_15" => [
			"get" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"set" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"defaultValue" => null
		],
		"precision_coherence_16" => [
			"get" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"set" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"defaultValue" => null
		],
	];

	public function __construct() {
		parent::__construct();
	}
	public function __destruct() {}

	public function getDh() {
		return (DonneurDOrdre::getById($this->id));
	}

	public function getForDonneurDOrdre($donneurdordre) {
		$rt = [];
		$pps = $donneurdordre->getPersonnePhysiques()->get();
		foreach ($pps as $pp) {
			$situations = $pp->getSituationPhysique()->get();
			foreach ($situations as $sit) {
				$rt[$sit->getId()] = $sit;
			}
		}
		return ($rt);
		//return (static::getFromKeyValue("id", $donneurdordre->getId()));
	}

	public static function generateVuexGetters() {
		$rt = [ ];
		$rt = array_merge($rt, parent::generateVuexGetters());
		return ($rt);
	}

	public function beforeSet($prev) {
		if ($prev === null)
			$this->getDateCreation()->setRawValue(time());
		$this->getDateModification()->setRawValue(time());
		return (true);
	}

	public function beforeCheck(&$data = null) {

		if ($data == null)
		{
			if ($this->getADesEnfants()->get() === false)
			{
				$this->getEnfantsACharge()->setConfig('notCheck', true);
				$this->getEnfantsACharge()->setNoControl(0);
			}
			if ($this->getEtatCivil()->get() === 3)
			{
				$this->getRegimeMatrimonial()->setConfig('notCheck', true);
				$this->getRegimeMatrimonial()->setNoControl(0);
			}
			if ($this->getRevenuAutres()->get() == 0)
			{
				$this->getRevenuAutresPrecision()->setConfig('notCheck', true);
				$this->getRevenuAutresPrecision()->setNoControl("");
			}
			if ($this->getHabitation()->get() != 1) {

				$this->getRemboursementMensuel()->setConfig('notCheck', true);
				$this->getRemboursementMensuel()->setNoControl(null);
				$this->getDureeRemboursementRestante()->setConfig('notCheck', true);
				$this->getDureeRemboursementRestante()->setNoControl(null);
			}
			if ($this->getHabitation()->get() != 2) {

				$this->getLoyer()->setConfig('notCheck', true);
				$this->getLoyer()->setNoControl(null);
			}
		}
		else
		{
			if ($data['a_des_enfants']['value'] === false)
			{
				$data['enfants_a_charge']['value'] = 0;
				$this->getEnfantsACharge()->setNoControl(0);
				$this->getEnfantsACharge()->setConfig('notCheck', true);

				$data['nbr_enfants']['value'] = 0;
				$this->getNbrEnfants()->setNoControl(0);
				$this->getNbrEnfants()->setConfig('notCheck', true);
			}
			if ($data['etat_civil']['value'] == 3)
			{
				$data['regime_matrimonial']['value'] = 0;
				$this->getRegimeMatrimonial()->setConfig('notCheck', true);
				$this->getRegimeMatrimonial()->setNoControl(0);
			}
			if ($data['revenu_autres']['value'] == 0)
			{
				$data['revenu_autres_precision']['value'] = "";
				$this->getRevenuAutresPrecision()->setConfig('notCheck', true);
				$this->getRevenuAutresPrecision()->setNoControl("");
			}

			if ($data['habitation']['value'] != 1) {

				$data['remboursement_mensuel']['value'] = null;
				$this->getRemboursementMensuel()->setConfig('notCheck', true);
				$this->getRemboursementMensuel()->setNoControl(null);

				$data['duree_remboursement_restante']['value'] = null;
				$this->getDureeRemboursementRestante()->setConfig('notCheck', true);
				$this->getDureeRemboursementRestante()->setNoControl(null);
			}
			if ($data['habitation']['value'] != 2) {

				$data['loyer']['value'] = null;
				$this->getLoyer()->setConfig('notCheck', true);
				$this->getLoyer()->setNoControl(null);
			}

			if ($data['remboursement_mensuel']['value'] == 0 xor $data['duree_remboursement_restante']['value'] == 0) {
				if ($data['remboursement_mensuel']['value'] == 0 )
					$data['remboursement_mensuel']['value'] = null;
				if ($data['duree_remboursement_restante']['value'] == 0 )
					$data['duree_remboursement_restante']['value'] = null;
			}
			if ($data['credit_residence_secondaire']['value'] == 0 xor $data['credit_residence_secondaire_duree']['value'] == 0) {
				if ($data['credit_residence_secondaire']['value'] == 0 )
					$data['credit_residence_secondaire']['value'] = null;
				if ($data['credit_residence_secondaire_duree']['value'] == 0 )
					$data['credit_residence_secondaire_duree']['value'] = null;
			}
			if ($data['credit_immobilier_locatif']['value'] == 0 xor $data['credit_immobilier_locatif_duree']['value'] == 0) {
				if ($data['credit_immobilier_locatif']['value'] == 0 )
					$data['credit_immobilier_locatif']['value'] = null;
				if ($data['credit_immobilier_locatif_duree']['value'] == 0 )
					$data['credit_immobilier_locatif_duree']['value'] = null;
			}
			if ($data['credit_scpi']['value'] == 0 xor $data['credit_scpi_duree']['value'] == 0) {
				if ($data['credit_scpi']['value'] == 0 )
					$data['credit_scpi']['value'] = null;
				if ($data['credit_scpi_duree']['value'] == 0 )
					$data['credit_scpi_duree']['value'] = null;
			}
			if ($data['credit_a_la_consommation']['value'] == 0 xor $data['credit_a_la_consommation_duree']['value'] == 0) {
				if ($data['credit_a_la_consommation']['value'] == 0 )
					$data['credit_a_la_consommation']['value'] = null;
				if ($data['credit_a_la_consommation_duree']['value'] == 0 )
					$data['credit_a_la_consommation_duree']['value'] = null;
			}
			if ($data['credit_autres']['value'] == 0 xor $data['credit_autres_duree']['value'] == 0) {
				if ($data['credit_autres']['value'] == 0 )
					$data['credit_autres']['value'] = null;
				if ($data['credit_autres_duree']['value'] == 0 )
					$data['credit_autres_duree']['value'] = null;
			}
			if ($data['assujetti_impot_revenu']['value'] === false) {
				$data['impot_annee_precedente']['value'] = null;
				$data['tranche_marginale_imposition']['value'] = null;
				$data['nombre_parts_fiscales']['value'] = null;

				$data['revenu_fiscale_reference']['value'] = null;
				$this->getRevenuFiscaleReference()->setConfig('notCheck', true);

				$this->getImpotAnneePrecedente()->setConfig('notCheck', true);
				$this->getTrancheMarginaleImposition()->setConfig('notCheck', true);
				$this->getNombrePartFiscales()->setConfig('notCheck', true);

				$this->getImpotAnneePrecedente()->setNoControl(null);
				$this->getTrancheMarginaleImposition()->setNoControl(null);
				$this->getNombrePartFiscales()->setNoControl(null);
			}
			if ($data['impot_fortune']['value'] === false) {

				$data['tranche_impot_fortune']['value'] = null;
				$this->getTrancheImpotFortune()->setConfig('notCheck', true);
				$this->getTrancheImpotFortune()->setNoControl(null);
			}
		}
	}

	public function checkCoherence($nbr) {
		$data = $this->{'getPrecisionCoherence' . $nbr}()->get();
		if (empty($data) || strlen($data) < 1)
			return (false);
		return (true);
	}

	public function getTotalRevenus() {
		return (
			$this->getRevenuSalaire()->get() +
			$this->getRevenuImmobilliers()->get() +
			$this->getRevenuMobilliers()->get() +
			$this->getRevenuAutres()->get()
		);
	}

	public function getTotalCharges() {
		return (
			$this->getRemboursementMensuel()->get() +
			$this->getLoyer()->get() +
			$this->getCreditResidenceSecondaire()->get() +
			$this->getCreditImmobilierLocatif()->get() +
			$this->getCreditScpi()->get() +
			$this->getCreditALaConsomation()->get() +
			$this->getCreditAutres()->get() +
			$this->getAutresCharges()->get()
		);
	}

	public function getTotalPatrimoine() {
		return (
			$this->getPatrimoineResidencePrincipale()->get() +
			$this->getPatrimoineAssuranceVie()->get() +
			$this->getPatrimoinePeaCompteTitre()->get() +
			$this->getPatrimoinePelCelCodeviLivret()->get() +
			$this->getPatrimoineResidenceSecondaire()->get() +
			$this->getPatrimoineImmobilierLocatif()->get() +
			$this->getPatrimoineScpi()->get() +
			$this->getPatrimoineAutres()->get()
		);
	}
	public function resetIncoherence() {
		for ($i = 1; $i < 17; $i++) {
			$this->{"getPrecisionCoherence" . $i}()->setNoControl(null);
		}
	}

	public function getNewCopy() {
		$rt = parent::getNewCopy();
		$rt->resetIncoherence();
		$rt->getIsValid()->set(false);
		return ($rt);
	}

	public function afterSet($prev) {
		
		//DevLogs::set("1", 1);
		$pps = $this->getPersonnesPhysiques()->get();
		//DevLogs::set($pps, 1);
		if (empty($pps))
			return (true);
		$ben = $pps[0]->getBeneficiaires()->get();

		$benCouple = null;
		foreach ($ben as $key => $elm) {
			if ($elm->getTypeBeneficiaire()->get() == 'couple') {
				$benCouple = $elm;
				break;
			}
		}
		if (!empty($benCouple)) {
			$pps = $benCouple->getPersonnesPhysiques()->get();
			foreach ($pps as $pp) {
				if ($pp->getIdSituation()->get() != $this->getIdSituation()->get())
					$pp->getIdSituation()->set($this->getIdSituation()->get());
				$pp->removeCheck();
				$pp->commit();
				StoreGenerator::getInstance()->addToState($pp);
			}
		}
		return (true);
	}

};
