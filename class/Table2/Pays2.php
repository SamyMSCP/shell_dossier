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

class Pays2 extends Table2 {
	protected static		$_name = "pays";
	protected static		$_primary_key = "id";
	public static			$_access = [ ACCESS_ALL_LOCAL, ACCESS_SERVER ];
	/*
		code
		alpha2
		alpha3
		nom_en_gb
		nom_fr_fr
	*/
	protected static		$_dataTypes = [
		"code" => [
			"type" => "TypeString",
			"config" => [
				"column" => "code"
			],
			"getter" => "getCode",
			"getAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER   ],
			"storeAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER   ]
		],
		"alpha2" => [
			"type" => "TypeString",
			"config" => [
				"column" => "alpha2"
			],
			"getter" => "getAlpha2",
			"getAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER   ],
			"storeAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER   ]
		],
		"alpha3" => [
			"type" => "TypeString",
			"config" => [
				"column" => "alpha3"
			],
			"getter" => "getAlpha3",
			"getAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER   ],
			"storeAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER   ]
		],
		"nom_en_gb" => [
			"type" => "TypeString",
			"config" => [
				"column" => "nom_en_gb"
			],
			"getter" => "getNomEnGb",
			"getAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER   ],
			"storeAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER   ]
		],
		"nom_fr_fr" => [
			"type" => "TypeString",
			"config" => [
				"column" => "nom_fr_fr"
			],
			"getter" => "getNomFrFr",
			"getAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER   ],
			"storeAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER   ]
		],
		"nationalite" => [
			"type" => "TypeString",
			"config" => [
				"column" => "nationalite"
			],
			"getter" => "getNationalite",
			"getAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER   ],
			"storeAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER   ]
		],
		"gafi" => [
			"type" => "TypeBool",
			"config" => [
				"column" => "gafi"
			],
			"getter" => "getGafi",
			"getAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER   ],
			"storeAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER   ]
		],
		"moscovici" => [
			"type" => "TypeBool",
			"config" => [
				"column" => "moscovici"
			],
			"getter" => "getMoscovici",
			"getAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER   ],
			"storeAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER   ]
		],
		"non_coop" => [
			"type" => "TypeBool",
			"config" => [
				"column" => "non_coop"
			],
			"getter" => "getNonCoop",
			"getAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER   ],
			"storeAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER   ]
		],
	];

	protected static		$_dataAccess = [
		"code" => [
			"get" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"set" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"defaultValue" => ""
		],
		"alpha2" => [
			"get" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"set" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"defaultValue" => ""
		],
		"alpha3" => [
			"get" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"set" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"defaultValue" => ""
		],
		"nom_en_gb" => [
			"get" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"set" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"defaultValue" => ""
		],
		"nom_fr_fr" => [
			"get" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"set" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"defaultValue" => ""
		],
		"nationalite" => [
			"get" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"set" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"defaultValue" => ""
		],
		"gafi" => [
			"get" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"set" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"defaultValue" => ""
		],
		"moscovici" => [
			"get" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"set" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"defaultValue" => ""
		],
		"non_coop" => [
			"get" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"set" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"defaultValue" => ""
		],
	];
}
