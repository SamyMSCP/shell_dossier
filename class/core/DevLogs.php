<?php
class DevLogs {
	private static $init = null;
	private static $last = "last.log";
	private static $path = LOG_PATH;
	private static $count = 0;
	private function __construct() {}

	public static function set($msg = null, $limit = null) {
		if (!ENABLE_LOG)
			return ;
		if (self::$init === null) {
			self::$init = date("Y/m/d/H-i-s") . ".log";
			@mkdir(self::$path . date("Y/m/d/"), 0755, true);

			file_put_contents(self::$path . self::$init, date("H:i:s") . "\n\n");
			file_put_contents(self::$path . self::$last, date("H:i:s") . "\n\n");
		}
		$tmp = "";
		$tmp .= self::$count . ":";
		self::$count++;
		$debug = debug_backtrace(0);
		foreach ($debug as $key => $elm) {
			if ($limit != null && $key == $limit)
				break ;
			$file = str_replace("/var/www/html/", "", $elm['file']);
			if ($key == 0) {
				$tmp .= "\033[33m{$file}\033[0m:\033[34m{$elm['line']}\t";
				$tmp .= "\033[31m";
				if (is_string($msg))
					$tmp.= $msg . "\n";
				else {
					$tmp .= "\n";
					ob_start();
					var_dump($msg);
					$tmp .= ob_get_contents() . "\n";
					ob_end_clean();
				}
				continue ;
			}
			$tmp .= "\033[33m{$file}\033[0m:\033[34m{$elm['line']}\t";
			if (isset($elm['class']))
				$tmp .= "\033[32m{$elm['class']}";
			if (isset($elm['type']))
				$tmp .= "\033[0m{$elm['type']}";
			if (isset($elm['function']))
				$tmp .= "\033[35m{$elm['function']}()";
			$tmp .= "\033[0m\n";
		}
		$tmp .= "\n";
		file_put_contents(self::$path . self::$last, $tmp, FILE_APPEND);
		file_put_contents(self::$path . self::$init, $tmp, FILE_APPEND);
	}
}
