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

class CategorieProfessionelle  extends Table2 {
	protected static		$_name = "categorie_professionelle";
	protected static		$_primary_key = "id";
	public static			$_access = [ ACCESS_ALL_LOCAL, ACCESS_SERVER ];
	protected static		$_dataTypes = [
		"code_1" => [
			"type" => "TypeUintNotNull",
			"config" => [
				"column" => "code_1"
			],
			"getter" => "getCode1",
			"getAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER   ],
			"storeAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER   ]
		],
		"code_2" => [
			"type" => "TypeUintNotNull",
			"config" => [
				"column" => "code_2"
			],
			"getter" => "getCode2",
			"getAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER   ],
			"storeAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER   ]
		],
		"libelle_1" => [
			"type" => "TypeString",
			"config" => [
				"column" => "libelle_1"
			],
			"getter" => "getLibelle1",
			"getAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER   ],
			"storeAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER   ]
		],
		"libelle_2" => [
			"type" => "TypeString",
			"config" => [
				"column" => "libelle_2"
			],
			"getter" => "getLibelle2",
			"getAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER   ],
			"storeAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER   ]
		],
	];

	protected static		$_dataAccess = [
		"code_1" => [
			"get" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"set" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"defaultValue" => ""
		],
		"code_2" => [
			"get" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"set" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"defaultValue" => ""
		],
		"libelle_1" => [
			"get" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"set" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"defaultValue" => ""
		],
		"libelle_2" => [
			"get" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"set" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"defaultValue" => ""
		],
	];

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
}
