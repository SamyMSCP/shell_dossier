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

/*
class SituationPhysiqueSave extends Table2 {
	protected static		$_name = "situation_physique";
	protected static		$_primary_key = "id";
	public static			$_access = [ ACCESS_SERVER, ACCESS_OWNER ];
	protected static		$_dataTypes = [
		[
			"type" => "TypeUint",
			"config" => [
				"column" => "revenu_professionnels",
			],
			"getter" => "getRevenuProfessionnels",
			"getAccess" => [ ACCESS_SERVER, ACCESS_OWNER ],
			"storeAccess" => [ ACCESS_SERVER, ACCESS_OWNER ]
		],
		[
			"type" => "TypeUint",
			"config" => [
				"column" => "revenu_immobilliers",
			],
			"getter" => "getRevenuImmobilliers",
			"getAccess" => [ ACCESS_SERVER, ACCESS_OWNER ],
			"storeAccess" => [ ACCESS_SERVER, ACCESS_OWNER ]
		]
	];

	protected static		$_dataAccess = [
		"revenu_professionnels" => [
			"get" => [ ACCESS_SERVER, ACCESS_OWNER ],
			"set" => [ ACCESS_SERVER, ACCESS_OWNER ],
			"defaultValue" => 0
		],
		"revenu_immobilliers" => [
			"get" => [ ACCESS_SERVER, ACCESS_OWNER ],
			"set" => [ ACCESS_SERVER, ACCESS_OWNER ],
			"defaultValue" => 0
		],
	];

	public function __construct() {
		parent::__construct();
	}

	public function __destruct() {
	
	}

	public static function getStoreName() {
		return (static::$_storeName);
	}

};
*/
