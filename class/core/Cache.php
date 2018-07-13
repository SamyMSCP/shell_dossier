<?php
trait Cache
{
	private static $_cachePath			= "../cache/";
	private $_cacheEntityPath	= null;
	
	function __call($method, $params) {
		if (strncmp($method, "getCache", 8) === 0) {
			$var = substr($method, 8);
			if (count($params))
				return ($this->readCacheData($var, $params[0]));
			else
				return ($this->readCacheData($var));
		}
		if (strncmp($method, "regenerateCache", 15) === 0) {
			$var = substr($method, 15);
			if (count($params)) {
				$this->writeCacheData($var, $params[0]);
			} else {
				$this->writeCacheData($var);
			}
			if (count($params)) {
				$this->readCacheData($var, $params[0]);
			} else {
				$this->readCacheData($var);
			}
			if (method_exists($this, "afterRegenerate" . $var)) {
				$this->{"afterRegenerate" . $var}($this->{"dataCache" . $var});
			}
			return ($this->{"dataCache" . $var});
		}
	}
	private function theCachePath($name, $id = null) {
		$pre = self::$_cachePath . strtolower(get_called_class()) . "/" . strtolower($name) . "/";
		@mkdir($pre, 0777, true);
		if ($id === null) {
			$id = strtolower(static::$_primary_key);
			$rt = ($pre . $this->$id . ".data");
		} else {
			$rt = ($pre . $id . ".data");
		}
		return ($rt);
	}
	public function readCacheData($name, $id = null) {
		if (!isset($this->{"dataCache" . $name})) {
			if (!file_exists($this->theCachePath($name, $id)) || !ENABLE_CACHE) {
				$this->writeCacheData($name, $id);
			} 
			$this->{"dataCache" . $name} = unserialize(file_get_contents(
				$this->theCachePath($name, $id)
			));
		}
		return ($this->{"dataCache" . $name});
	}
	public function writeCacheData($name, $id = null) {
		return (
			file_put_contents (
				$this->theCachePath($name, $id),
				serialize($this->{"generateCache" . $name}()),
				LOCK_EX
			)
		);
	}
	/////////////////////////////// Gestion statique
	public static function __callstatic($method, $params) {
		if (strncmp($method, "getCache", 8) === 0) {
			$var = substr($method, 8);
			if (count($params))
				return (static::staticReadCacheData($var, $params[0]));
			else
				return (static::staticReadCacheData($var));
		}
		if (strncmp($method, "regenerateCache", 15) === 0) {
			$var = substr($method, 15);
			if (count($params)) {
				static::staticWriteCacheData($var, $params[0]);
			} else {
				static::staticWriteCacheData($var);
			}
			if (count($params)) {
				static::staticReadCacheData($var, $params[0]);
			} else {
				static::staticReadCacheData($var);
			}
			if (method_exists(__CLASS__, "afterRegenerate" . $var)) {
				forward_static_call("static::afterRegenerate" . $var);
			}
			return (static::${"staticDataCache" . $var});
		}
	}
	private static function staticCachePath($name) {
		$pre = self::$_cachePath . strtolower(get_called_class()) . "/";
		@mkdir($pre, 0777, true);
		$rt = ($pre . strtolower($name) . ".data");
		return ($rt);
	}
	public static function staticReadCacheData($name) {
		if (static::${"staticDataCache" . $name} == null) {
			if (!file_exists(static::staticCachePath($name)) || !ENABLE_CACHE) {
				static::staticWriteCacheData($name);
			} 
			static::${"staticDataCache" . $name} = unserialize(file_get_contents(
				static::staticCachePath($name)
			));
		}
		return (static::${"staticDataCache" . $name});
	}
	public static function staticWriteCacheData($name) {
		return (
			file_put_contents (
				static::staticCachePath($name),
				serialize(static::{"generateCache" . $name}()),
				LOCK_EX
			)
		);
	}
}
