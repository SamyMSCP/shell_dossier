<?php
require_once("core/Database.php");
require_once("core/Table.php");
require_once("MailSender.php");
require_once("SmsSender.php");
require_once("Notifications.php");

class CommunicationTemplate  extends Table
{
	protected static		$_name = "communication_template";
	protected static		$_primary_key = "id";
	public static			$_noSecure = ["content"];
	const					MAIL_EMPTY = 1;
	const					MAIL_REGISTER = 3;


	public static function		insertNew($name, $content, $classname) {
		$req = "INSERT INTO `communication_template`
			(name, content, classname) VALUES 
			(:name, :content, :classname)";
		$data = [
			"name" => $name,
			"content" => $content,
			"classname" => $classname
		];
		return Database::prepareInsertCheckSecurity(static::$_db, $req, $data, get_called_class());
	}


	public static function		updateTemplate($data){
		$req = "UPDATE `communication_template` SET `name` = :naming, `content` = :content, `on_clientpage` = :on_client WHERE `communication_template`.`id` = :id";

		$x = [
			"naming" => $data['name'],
			"content" => $data['content'],
			"on_client" => $data['on_client'],
			"id" => $data['id']
		];
		$ret = Database::prepareNoClassCheckSecurity(static::$_db, $req, $x, get_called_class());
//		var_dump($ret);
		return ($ret);
	}

	public static function		getTypeCommunication() {
		$req =  "SELECT DISTINCT(classname) FROM communication_template";
		return Database::prepare(static::$_db, $req, [], "CommunicationTemplate");
	}
	public function getContent() {
		return ($this->content);
	}
	public static function getById($id){
		$rt = parent::getFromId($id);
		if (!empty($rt))
			return ($rt[0]);
		return (null);
	}
	public static function getByName($name){
		$rt = parent::getFromKeyValue("name", $name);
		if (!empty($rt))
			return ($rt[0]);
		return (null);
	}
	public function render($dh, $message) {
		$rt = $this->getContent();

        $host = 'serveur';
		if (isset($_SERVER['HTTP_HOST']))
		{
			$host = $_SERVER['HTTP_HOST'];
		}

		$search = [
			"##MESSAGE##"
		];
		$replace = [
			$message
		];
		$rt = str_replace($search, $replace, $rt);

		$search = [
			"##SHORT_NAME##",
			"##HOST##",
			"##FOOTER##"
		];
		$replace = [
			$dh->getShortName(),
			$host,
			self::getById(2)->content
		];
		$rt = str_replace($search, $replace, $rt);
		return ($rt);
	}

	public static function getTemplateSendToClient() {
		$req = "SELECT `id`, `name`, `content` as `value` FROM `communication_template` WHERE `on_clientpage` = 1";
		return Database::prepare(static::$_db, $req, [], "CommunicationTemplate");
	}
}
