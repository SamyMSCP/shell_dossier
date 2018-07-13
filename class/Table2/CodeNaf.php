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

class CodeNaf  extends Table2 {
	protected static		$_name = "code_naf";
	protected static		$_primary_key = "id";
	public static			$_access = [ ACCESS_ALL_LOCAL, ACCESS_SERVER ];
	protected static		$_dataTypes = [
		"section" => [ // A -> U
			"type" => "TypeString",
			"config" => [
				"column" => "section"
			],
			"getter" => "getSection",
			"getAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER   ],
			"storeAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER   ]
		],
		"code_1" => [ // 0 -> 99
			"type" => "TypeUint",
			"config" => [
				"column" => "code_1",
				"canEmpty" => true
			],
			"getter" => "getCode1",
			"getAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER   ],
			"storeAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER   ]
		],
		"code_2" => [ // 0 ->  9
			"type" => "TypeUint",
			"config" => [
				"column" => "code_2",
				"canEmpty" => true
			],
			"getter" => "getCode2",
			"getAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER   ],
			"storeAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER   ]
		],
		"code_3" => [ // 0 -> 9
			"type" => "TypeUint",
			"config" => [
				"column" => "code_3",
				"canEmpty" => true
			],
			"getter" => "getCode3",
			"getAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER   ],
			"storeAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER   ]
		],
		"code_4" => [ // A -> Z
			"type" => "TypeString",
			"config" => [
				"column" => "code_4",
				"canEmpty" => true
			],
			"getter" => "getCode4",
			"getAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER   ],
			"storeAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER   ]
		],
		"libelle" => [
			"type" => "TypeString",
			"config" => [
				"column" => "libelle"
			],
			"getter" => "getLibelle",
			"getAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER   ],
			"storeAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER   ]
		],
		"risque" => [
			"type" => "TypeBool",
			"config" => [
				"column" => "risque"
			],
			"getter" => "getRisque",
			"getAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER   ],
			"storeAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER   ]
		],
	];

	protected static		$_dataAccess = [
		"section" => [
			"get" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"set" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"defaultValue" => null
		],
		"code_1" => [
			"get" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"set" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"defaultValue" => null
		],
		"code_2" => [
			"get" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"set" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"defaultValue" => null
		],
		"code_3" => [
			"get" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"set" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"defaultValue" => null
		],
		"code_4" => [
			"get" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"set" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"defaultValue" => null
		],
		"libelle" => [
			"get" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"set" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"defaultValue" => null
		],
		"risque" => [
			"get" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"set" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"defaultValue" => false
		],
	];

	public static function getFromCode($val) {
		$code1 = null;
		$code2 = null;
		$code3 = null;
		$code4 = null;
		if (empty($val) || strlen($val) < 2)
			return (false);
		if (strlen($val) >= 2) // Code 1
			$code1 = intval(($val[0] * 10) + $val[1]);
		if (strlen($val) >= 4) // Code 2
			$code2 = intval($val[3]);
		if (strlen($val) >= 5) // Code 3
			$code3 = intval($val[4]);
		if (strlen($val) >= 6) // Code 4
			$code4 = $val[5];
		$naf = CodeNaf::getFromKeysValues([
			"code_1" => $code1,
			"code_2" => $code2,
			"code_3" => $code3,
			"code_4" => $code4
		]);
		if (empty($naf))
			return (null);
		return ($naf[0]);
	}
/*
	public static function generateVuexGetters() {
		$rt = [
			"getCategorieProfessionnelleByCode1" => "
				return (function(code_1) {
					return (
						state.datas.CategorieProfessionelle.lst.filter(function (elm) {
							return (elm.code_1.value == code_1);
						}));
					});
				"
		];
		$rt = array_merge($rt, parent::generateVuexGetters());
		return ($rt);
	}
	*/
}
