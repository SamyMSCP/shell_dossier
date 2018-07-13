<?php

class Cli
{
	public static function is_cli() {
		return (php_sapi_name() === "cli");
	}

	public static function cli_only() {
		if (!self::is_cli()){
			http_response_code(404);
			die();
		}
	}
}
