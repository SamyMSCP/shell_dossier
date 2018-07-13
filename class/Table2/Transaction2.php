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

class Transaction2 extends Table2 {
	protected static		$_name = "TRANSACTION";
	protected static		$_primary_key = "id";
	public static			$_access = [ ACCESS_ALL_LOCAL, ACCESS_SERVER ];
	protected static		$_dataTypes = [
		"id_donneur_ordre" => [
			"type" => "TypeToOne",
			"config" => [
				"class" => "DonneurDOrdre",
				"column" => "id_donneur_ordre",
				"canEmpty" => false
			],
			"getter" => "getDonneurDOrdre",
			"getAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER  ],
			"storeAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER  ]
		],
		"id_scpi" => [
			"type" => "TypeToScpi",
			"config" => [
				"column" => "id_scpi",
			],
			"getter" => "getScpi",
			"getAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER  ],
			"storeAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER  ]
		],
	];

	protected static		$_dataAccess = [
		"id_donneur_ordre" => [
			"get" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"set" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"defaultValue" => ""
		],
		"id_scpi" => [
			"get" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"set" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"defaultValue" => ""
		],
	];

	public function __construct() {
		parent::__construct();
	}
	public function __destruct() {}

	public function getShortName() {
		return ("-");
	}

	public function getDh() {
		return (DonneurDOrdre::getById($this->id_donneur_ordre));
	}

	public function getForDonneurDOrdre($donneurdordre) {
		return (static::getFromKeyValue("id_donneur_ordre", $donneurdordre->getId()));
	}

	public static function generateVuexGetters() {

		$rt = [];
		/*
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
		*/
		$rt = array_merge($rt, parent::generateVuexGetters());
		return ($rt);
	}
};
