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

class DonneurDOrdre extends Table2 {
	private static			$_current;

	protected static		$_name = "DONNEUR D'ORDRE";
	protected static		$_primary_key = "id_dh";
	public static			$_access = [ ACCESS_SERVER, ACCESS_OWNER, ACCESS_ALL_LOCAL, ACCESS_EMPTY ];
	//public static			$_access = [ ACCESS_ALL_LOCAL ];
	protected static		$_dataTypes = [
		"login" => [
			"type" => "TypeEncryptedMail",
			"config" => [
				"column" => "login"
			],
			"getter" => "getLogin",
		"getAccess" => [ ACCESS_SERVER, ACCESS_OWNER, ACCESS_ALL_LOCAL ],
		"storeAccess" => [ ACCESS_SERVER, ACCESS_OWNER, ACCESS_ALL_LOCAL ]
		],
		"ko" => [
			"type" => "TypeBool",
			"config" => [
				"column" => "ko",
				"canBeEmpty" => true
			],
			"getter" => "getKo",
			"getAccess" => [ ACCESS_SERVER, ACCESS_OWNER, ACCESS_ALL_LOCAL ],
			"storeAccess" => [ ACCESS_SERVER, ACCESS_OWNER, ACCESS_ALL_LOCAL ]
		],
		"vip" => [
			"type" => "TypeBool",
			"config" => [
				"column" => "vip",
				"canBeEmpty" => true
			],
			"getter" => "getVip",
			"getAccess" => [ ACCESS_SERVER, ACCESS_OWNER, ACCESS_ALL_LOCAL ],
			"storeAccess" => [ ACCESS_SERVER, ACCESS_OWNER, ACCESS_ALL_LOCAL ]
		],
		"type" => [
			"type" => "TypeEnumString",
			"config" => [
				"props" => [
					":list" => [
						"Prospect"			=> null,
						"Client"			=> "client",
						"Conseiller"		=> "conseiller",
						"Backoffice"		=> "backoffice",
						"Assistant"			=> "assistant",
						"Prospecteur"		=> "prospecteur",
						"Developpeur"		=> "développeur",
						"Chef de projet"	=> "chefprojet",
						"Yoda"				=> "yoda"
					]
				],
				"datas" => [
					"",
					"client",
					"conseiller",
					"backoffice",
					"assistant",
					"prospecteur",
					"developpeur",
					"chefprojet",
					"yoda"
				],
				"column" => "type"
			],
			"getter" => "getType",
			"getAccess" => [ ACCESS_SERVER, ACCESS_OWNER, ACCESS_ALL_LOCAL ],
			"storeAccess" => [ ACCESS_SERVER, ACCESS_OWNER, ACCESS_ALL_LOCAL ]
		],
		"PersonnesPhysiques" => [
			"notShow" => true,
			"type" => "TypeByOne",
			"config" => [
				"class" => "PersonnePhysique",
				"link" => "lien_dh",
				"canEmpty" => false
			],
			"getAccess" => [ ACCESS_SERVER, ACCESS_OWNER, ACCESS_ALL_LOCAL ],
			"getter" => "getPersonnePhysiques"
		],
		"Beneficiaire" => [
			"notShow" => true,
			"type" => "TypeByOne",
			"config" => [
				"class" => "Beneficiaire2",
				"link" => "id_dh",
				"canEmpty" => false
			],
			"getAccess" => [ ACCESS_SERVER, ACCESS_OWNER, ACCESS_ALL_LOCAL ],
			"getter" => "getBeneficiaires"
		],
		"conseiller" => [
			"type" => "TypeToOneConseiller",
			"config" => [
				"column" => "conseiller",
				"canEmpty" => false
			],
			"getAccess" => [ ACCESS_SERVER, ACCESS_OWNER, ACCESS_ALL_LOCAL ],
			"getter" => "getConseiller"
		],
		"lien_phy" => [
			"type" => "TypeToOne",
			"config" => [
				"class" => "PersonnePhysique",
				"column" => "lien_phy",
				"canEmpty" => false
			],
			"getAccess" => [ ACCESS_SERVER, ACCESS_OWNER, ACCESS_ALL_LOCAL ],
			"getter" => "getMyPersonnePhysique"
		],

	];

	protected static		$_dataAccess = [
		"login" => [
			"get" => [ ACCESS_SERVER, ACCESS_OWNER, ACCESS_ALL_LOCAL ],
			"set" => [ ACCESS_SERVER, ACCESS_OWNER, ACCESS_ALL_LOCAL ],
		],
		"Beneficiaire" => [
			"get" => [ ACCESS_SERVER, ACCESS_OWNER, ACCESS_ALL_LOCAL ],
			"set" => [ ACCESS_SERVER, ACCESS_OWNER, ACCESS_ALL_LOCAL ],
		],
		"ko" => [
			"get" => [ ACCESS_SERVER, ACCESS_OWNER, ACCESS_ALL_LOCAL ],
			"set" => [ ACCESS_SERVER, ACCESS_OWNER, ACCESS_ALL_LOCAL ],
			"editComponent" => "ComponentTypeBool2btnEdit",
			"defaultValue" => false,
		],
		"vip" => [
			"get" => [ ACCESS_SERVER, ACCESS_OWNER, ACCESS_ALL_LOCAL ],
			"set" => [ ACCESS_SERVER, ACCESS_OWNER, ACCESS_ALL_LOCAL ],
			"editComponent" => "ComponentTypeBool2btnEdit",
			"defaultValue" => false,
		],
		"type" => [
			"get" => [ ACCESS_SERVER, ACCESS_OWNER, ACCESS_ALL_LOCAL ],
			"set" => [ ACCESS_SERVER, ACCESS_OWNER, ACCESS_ALL_LOCAL ],
			//"editComponent" => "ComponentTypeEdit",
			//"showComponent" => "ComponentTypeShow",
			"defaultValue" => null,
		],
		"lien_phy" => [
			"get" => [ ACCESS_SERVER, ACCESS_OWNER, ACCESS_ALL_LOCAL ],
			"set" => [ ACCESS_SERVER, ACCESS_OWNER, ACCESS_ALL_LOCAL ],
			"defaultValue" => null,
		],
		"conseiller" => [
			"get" => [ ACCESS_SERVER, ACCESS_OWNER, ACCESS_ALL_LOCAL ],
			"set" => [ ACCESS_SERVER, ACCESS_OWNER, ACCESS_ALL_LOCAL ],
			"defaultValue" => null,
		],
	];

	public function getDh() {
		return ($this);
	}

	public function __construct() {
		parent::__construct();
	}
	public function __destruct() {}

	public function getShortName() {
		//$login = $this->getLogin()->get();
		$pp = $this->getMyPersonnePhysique()->get();
		if (empty($pp))
			return ('-');
		return ($pp->getShortName());
		//return ($login);
	}

	public static function getCurrent() {
		if (self::$_current == null)
		{
			if (
				empty($_COOKIE["login"]) ||
				empty($_COOKIE["token"]) ||
				empty(ft_parse_cookie($_COOKIE["token"])) ||
				empty(ft_parse_cookie($_COOKIE["login"]))
			)
				return (0);
			self::$_current = parent::getFromKeysValues(
				array(
					"login" => $_COOKIE['login'],
					"TOKEN" => $_COOKIE['token'],
				)
			);
			if (count(self::$_current) == 0)
				return null;
			self::$_current = self::$_current[0];
		}
		return (self::$_current);
	}

	public static function generateVuexGetters() {
		$rt = [];
		$rt = array_merge($rt, parent::generateVuexGetters());
		return ($rt);
	}

	public function getProjets() {
		$bens = $this->getBeneficiaires()->get();
		$rt = [];
		foreach ($bens as $key => $ben) {
			$rt = array_merge($rt, $ben->getProjet()->get());
		}
		return ($rt);
	}
};




















