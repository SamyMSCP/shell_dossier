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

class StatusPro2 extends Table2 {
	protected static		$_name = "status_pro";
	protected static		$_primary_key = "id";
	public static			$_access = [ ACCESS_ALL_LOCAL, ACCESS_SERVER ];
	protected static		$_dataTypes = [
		"name" => [
			"type" => "TypeString",
			"config" => [
				"column" => "name"
			],
			"getter" => "getName",
			"getAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER   ],
			"storeAccess" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER   ]
		],
	];

	protected static		$_dataAccess = [
		"name" => [
			"get" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"set" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"defaultValue" => ""
		],
	];
}
