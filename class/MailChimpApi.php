<?php
/**
 * Created by PhpStorm.
 * User: vthomas
 * Date: 03/11/2017
 * Time: 15:53
 */

class MailChimpApi
{
	private static $_g_scpi_token = ["scpi" => "d305507557",
									"fiscale" => "61073ba1d9",
									"dem" => "3623a62e8e",
									"gf" => "30269f84d4"];

	private static $_api_token = "461a57aad9eabc3884d1936fa1fcfbd6-us2";
	private static $_username = "anystring";
	private static $_api_url = "http://us2.api.mailchimp.com/3.0";

	private $since_date;
	const MAX_ELEM = 30;
	const NB_OF_DAY = 5;

	public function __construct()
	{
		$this->since_date = date("c",time() - (3600 * 24 * self::NB_OF_DAY));
	}

	public function getNormalUsers() {
		return ($this->_getUser(self::$_g_scpi_token['scpi']));
	}

	public function getFiscalUsers() {
		return ($this->_getUser(self::$_g_scpi_token['fiscale']));
	}

	public function getDemUsers() {
		return ($this->_getUser(self::$_g_scpi_token['dem']));
	}

	public function getGfUsers(){
		return ($this->_getUser(self::$_g_scpi_token['gf']));
	}

	private function _getUser($list) {
		$data = array("since_timestamp_opt" => $this->since_date,
			"count" => self::MAX_ELEM);
		$option = array(
			'http' => array(
				'header' => "Content-type: application/x-www-form-urlencoded\r\n" .
					"Authorization: Basic " . base64_encode(self::$_username . ":" . self::$_api_token),
				'method' => "GET",
				'content' => http_build_query($data)
			)
		);
		$context = stream_context_create($option);
		$url = self::$_api_url . "/lists/" . $list . "/members/";
		$url .= "?since_timestamp_opt=" . $this->since_date;
		$url .= "&count=" . self::MAX_ELEM;

//		echo $url;

		$result = file_get_contents($url, false, $context);
		if ($result === FALSE) {/*HANDLE THE ERROR*/}
		return ($result);
	}
}