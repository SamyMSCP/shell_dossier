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


class ObjectifsList2 extends Table2 {
	protected static		$_name = "objectifs_list";
	protected static		$_primary_key = "id";
	public static			$_access = [ ACCESS_ALL_LOCAL, ACCESS_SERVER ];
	/*
		id
		name
		content
	*/
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
		"content" => [
			"type" => "TypeString",
			"config" => [
				"column" => "content"
			],
			"getter" => "getContent",
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
		"content" => [
			"get" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"set" => [ ACCESS_ALL_LOCAL, ACCESS_SERVER ],
			"defaultValue" => ""
		],
	];
}
