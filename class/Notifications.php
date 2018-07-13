<?php
require_once("core/Database.php");
require_once("core/Table.php");
require_once("Dh.php");
require_once("CommunicationTemplate.php");

class Notifications extends Table
{
	protected static		$_name = "notifications";
	protected static		$_primary_key = "id";
	public static			$_noSecure = ["content", "title", "link"];

	public static function sendToDh($id_dh, $title, $content, $id_crm, $link = "")
	{
		$req = "INSERT INTO `notifications`
			(id_dh, title, content, date_creation, link, id_crm) VALUES 
			(:id_dh, :title, :content, :date_creation, :link, :id_crm)";
		$data = [
			"id_dh" => $id_dh,
			"title" => $title,
			"content" => $content,
			"date_creation" => time(),
			"link" => $link,
			"id_crm" => $id_crm
		];
		return Database::prepareInsertCheckSecurity(static::$_db, $req, $data, get_called_class());
	}
	public static function sendToDhNoLogs($id_dh, $title, $content, $id_crm, $link = "")
	{
		$req = "INSERT INTO `notifications`
			(id_dh, title, content, date_creation, link, id_crm) VALUES 
			(:id_dh, :title, :content, :date_creation, :link, :id_crm)";
		$data = [
			"id_dh" => $id_dh,
			"title" => $title,
			"content" => $content,
			"date_creation" => time(),
			"link" => $link,
			"id_crm" => $id_crm
		];
		return Database::prepareInsertCheckSecurity(static::$_db, $req, $data, get_called_class());
	}
	public static function sendToDhWithTemplate($dh, $title, $content, $templateId, $id_crm, $link = "")
	{
		return self::sendToDh(
			$dh->id_dh,
			$title,
			CommunicationTemplate::getById($templateId)->render($dh, $content),
			$id_crm,
			$link
		);
	}
	public static function sendToDhWithTemplateForTask($datas)
	{
		if (!isset($datas['id_crm']))
			$datas['id_crm'] = null;
		extract($datas);
		return self::sendToDhWithTemplate(
			Dh::getById($dh),
			$title,
			$content,
			$templateId,
			$id_crm,
			$link
		);
	}
	public static function sendToDhForLogs($datas)
	{
		if (!isset($datas['id_crm']))
			$datas['id_crm'] = null;
		extract($datas);
		return self::sendToDhNoLogs(
			$dh,
			$title,
			$content,
			$id_crm,
			$link
		);
	}
	public static function getForDh($id_dh) {
		return (parent::getFromKeyValue("id_dh", $id_dh));
	}
	public static function getNotCompleteForDh($id_dh) {
		$req = "SELECT * FROM `notifications` WHERE id_dh = ? AND see IS NULL ORDER BY date_creation DESC";
		$data = [$id_dh];
		return Database::prepare(static::$_db, $req, $data, get_called_class());
	}
	public static function getCompleteForDh($id_dh) {
		$req = "SELECT * FROM `notifications` WHERE id_dh = ? AND see = 1 ORDER BY date_creation DESC LIMIT 15";
		$data = [$id_dh];
		return Database::prepare(static::$_db, $req, $data, get_called_class());
	}
	public function			getContent() {
		return ($this->content);
	}
	public function			getDateCreation() {
		$rt = new DateTime();
		$rt->setTimestamp($this->date_creation);
		return ($rt);
	}
	public function			getTitle() {
		return ($this->title);
	}
	public function			getLink() {
		if (!empty($this->link))
			return ($this->link);
		return ("#");
	}
	public static function setSeeForCrm($id_crm) {
		//exit();
		$req = "UPDATE `notifications` set see = 1 WHERE id_crm = ?";
		$data = [$id_crm];
		return (Database::prepareNoClass(static::$_db, $req, $data));
	}
}
