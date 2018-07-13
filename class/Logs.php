<?php
require_once("core/Database.php");
require_once("core/Table.php"); class Logs extends Table
{
	protected static	$_name = "LOG";
	protected static	$_primary_key = "id";
	private				$_infotime = null;

	public static function getFromDh($id)
	{
		return parent::getFromKeyValue("lien_dh", $id);
	}
	public static function getFromDhByDate($id)
	{
		$req = "SELECT * FROM `LOG` WHERE lien_dh = ? ORDER BY infotime DESC";
		$datas = array($id);
		return Database::prepare(static::$_db, $req, $datas, get_called_class());
	}
	public static function getAllByDate()
	{
		$req = "SELECT * FROM `LOG` WHERE lien_dh IS NOT NULL ORDER BY infotime DESC";
		$datas = array();
		return Database::prepare(static::$_db, $req, $datas, get_called_class());
	}
	public static function getFromDhDesc($id)
	{
		return parent::getFromKeyValueIdDesc("lien_dh", $id);
	}
	public function getDate()
	{
		return date("d/m/Y", $this->infotime);
	}
	public function getDateTime()
	{
		if ($this->_infotime == NULL) {
			$this->_infotime = new DateTime;
			$this->_infotime->setTimestamp($this->infotime); 
		}
		return ($this->_infotime);
	}
	public function getIp() {
		if (!empty($this->ip))
			return(ft_decrypt_crypt_information($this->ip));
		else
			return (null);
	}
	public function getPost() {
		if (!empty($this->post))
			return(ft_decrypt_crypt_information($this->post));
		else
			return (null);
	}
	public function getActivite() {
		if (!empty($this->activiter))
			return(ft_decrypt_crypt_information($this->activiter));
		else
			return (null);
	}
	public function getDh() {
		return (Dh::getById($this->lien_dh));
	}
}
