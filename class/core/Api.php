<?php
require_once("Database.php");
if (defined("CONNECT_URL") === false)
	define("CONNECT_URL", "http://54.229.5.3/");
class Api
{
//	private static $_instance = null;
	public static		$TIME_API = 0;
	public static		$NBR_REQUEST = 0;
	public static		$ALL_REQUEST = array();

	private function __construct() { }

	public static function getRequestJson($post)
	{
		$enc = base64_encode(mcrypt_encrypt("rijndael-256", constant("__passApiSend__"), json_encode($post, JSON_FORCE_OBJECT), "ecb"));
		$TIME_START_API = microtime(true);
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, CONNECT_URL);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $enc);

		$output = curl_exec($ch);
		curl_close($ch);
		$TIME_END_API = microtime(true);
		self::$TIME_API += ($TIME_END_API - $TIME_START_API);
		self::$ALL_REQUEST[] = array(
			"time" => $TIME_END_API - $TIME_START_API,
			"request" => $post
		);
		self::$NBR_REQUEST++;
		$output = trim(mcrypt_decrypt("rijndael-256", constant("__passApiSend__"), base64_decode($output), "ecb"));
		$output = json_decode($output, true);
		if ($output == null)
			$output = "{}";
		//var_dump($output); exit();
		return ($output);
	}
	protected static function arrayToObject($array, $class) {
		$rt = new $class;
		if (is_array($array)) {
			foreach ($array as $key => $value) {
				$rt->$key = $value;
			}
		}
		return ($rt);
	}
	protected static function getRequestObject($post) {
		$data = self::getRequestJson($post);
		if ($data === "{}")
			return null;
		return (self::arrayToObject($data[0], get_called_class()));
	}
	public static function getRequestObjects($post) {
		$rt = array();
		$data = self::getRequestJson($post);
		if ($data === "{}")
			return null;
		foreach ($data as $array) {
			$rt[] = self::arrayToObject($array, get_called_class());
		}
		return ($rt);
	}
/*
	protected function getRequest($post)
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $this->url);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
		$output = curl_exec($ch);
		curl_close($ch);
		if ($output == null)
			$output = "{}";
		return (json_decode($output, true));
	}
	public function getActualite()
	{
		$lst_scpi = $this->doRequestMysql("SELECT id_scpi FROM TRANSACTION WHERE id_donneur_ordre = :id_user", array(":id_user" => intval(get_my_dh(1)['id_dh'])));
		if (count($lst_scpi))
			$rt = $this->getRequestJson(
					array(
						"req" => "getUserActualite",
						"lst_scpi" => json_encode($lst_scpi, true),
						"limit" => "4"
				));
		else
			$rt = $this->getRequestJson(
					array(
						"req" => "getAllActualite",
						"limit" => "4"
					)
				);
		return ($rt);
	}
	public function getAcquisition()
	{
		$rt = $this->getRequestJson(
				array(
					"req" => "getAcquisition",
					"limit" => "4"
					)
			);
		return ($rt);
	}
*/
}
